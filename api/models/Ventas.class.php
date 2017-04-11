<?php
class Ventas extends Connection {
	
	function Ventas(){
		$this->Connect();
	}


	function GetVentas(){
		$query="SELECT v.*,vc.id as clave, concat(c.nombre,' ',c.apaterno,' ',c.amaterno) as nombre_cliente,cv.id as clave_cliente FROM ventas v 
		inner join ventas_claves vc on vc.id_venta=v.id
		inner join clientes c on c.id=v.id_cliente 
		inner join clientes_claves cv on cv.id_cliente=c.id
		where v.eliminado=0  " ;
		$result=$this->Query($query);
		$arrayResult=array();
		if($result['success']){ 
			while($row=mysqli_fetch_assoc($result['data'])){
				$fecha_formato = date("d/m/Y", strtotime($row['fecha_registro']));
				$row['fecha_registro']=$fecha_formato;
				$arrayResult[]=$row;
			}
			$result['data']=$arrayResult;
		}
		return $result;
	}


	function GetVentasClave(){
		$query="INSERT INTO ventas_claves (id_venta) values (0);" ;
		$result=$this->Query($query);
		if($result['success']){ 
			$last_id=$this->last_insert_id();
			$result['data']=$last_id;
		}else{
			$result['message']="No se pudo generar una nueva clave, intente mas tarde. Codigo de error: V003";

		}
		return $result;
	}


	function SetVenta($id_clave,$id_cliente,$articulos,$enganche,$bono,$total,$total_articulos,$abonos,$total_pagar,$ahorra,$plazos){

		$this->begin_transaction();
		$query="INSERT INTO ventas (id_cliente,enganche,bono,total,total_articulos,abonos,total_pagar,ahorra,plazos) values ('".$id_cliente."','".$enganche."','".$bono."','".$total."','".$total_articulos."','".$abonos."','".$total_pagar."','".$ahorra."','".$plazos."') " ;
		$result=$this->Query($query);
		$error_articulos=false;

		if($result['success']){ 
			$id_venta=$this->last_insert_id();
			$query_clave="UPDATE ventas_claves SET id_venta=".$id_venta." WHERE id=".$id_clave." limit 1" ;
			$result_clave=$this->Query($query_clave);

			for ($i=0; $i < count($articulos) ; $i++) {  // INSERTA LOS ARTICULOS A EL REGISTRO DE VENTA
				$query_articulo="INSERT INTO ventas_articulos (id_venta,id_articulo,precio,precio_tasa,cantidad,importe) values ('".$id_venta."','".$articulos[$i]['id']."','".$articulos[$i]['precio']."','".$articulos[$i]['precio_tasa']."','".$articulos[$i]['cantidad']."','".$articulos[$i]['importe']."') " ;
				$result_articulo=$this->Query($query_articulo);
				if(!$result_articulo['success']){ // SI NO SE DETIENE EL PROCESO
					$error_articulos=true;
					break;
				}else{ // SI INSERTA SE ELIMINA LA CANTIDAD DEL ARTICULO UNO DE LA EXISTENCIA
					$query_update_articulo="UPDATE articulos SET existencia=(existencia-".$articulos[$i]['cantidad'].") WHERE id='".$articulos[$i]['id']."' limit 1; " ;
					$result_update_articulo=$this->Query($query_update_articulo);
					if(!$result_update_articulo['success']){
						$error_articulos=true;
						break;
					}
				}
			}

			if($result_clave['success'] && !$error_articulos){
				$result['message']="Bien Hecho, Tu venta ha sido registrada correctamente";
				$this->commit();
			}else{
				$result['message']="Lo sentimos no se ha podido registrar la venta. intente mas tarde. \n Codigo de error :V004";
				$this->rollback();
			}
		}else{
			$result['message']="Lo sentimos no se ha podido registrar la venta. intente mas tarde. \n Codigo de error :V001".$result['message'];
			$this->rollback();
		}

		return $result;
	}
}

?>