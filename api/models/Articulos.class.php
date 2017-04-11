<?php 

class Articulos extends Connection {
	
	function Articulos(){
		$this->Connect();
	}

	function GetArticulos(){

		$query="SELECT a.*,ac.id as clave FROM articulos a left join articulos_claves ac on ac.id_articulo=a.id WHERE a.eliminado=0 order by a.id asc " ;
		$result=$this->Query($query);
		$arrayResult=array();
		if($result['success']){ 
			while($row=mysqli_fetch_assoc($result['data'])){
				$arrayResult[]=$row;
			}
			$result['data']=$arrayResult;
		}
		return $result;
	}

	function GetArticulo($id=0){

		$query="SELECT a.*,ac.id as clave FROM articulos a left join articulos_claves ac on ac.id_articulo=a.id WHERE a.eliminado=0 and a.id=".$id." order by a.id asc " ;
		$result=$this->Query($query);
		$arrayResult=array();
		if($result['success']){ 
			while($row=mysqli_fetch_assoc($result['data'])){
				$arrayResult[]=$row;
			}
			$result['data']=$arrayResult;
		}
		return $result;
	}


	function GetArticulosClave(){

		$query="INSERT INTO articulos_claves (id_articulo) values (0);" ;
		$result=$this->Query($query);
		if($result['success']){ 
			$last_id=$this->last_insert_id();
			$result['data']=$last_id;
		}else{
			$result['message']="No se pudo generar una nueva clave, intente mas tarde. Codigo de error: A003";

		}
		return $result;
	}

	function GetArticulosByName($descripcion=''){

		$query="SELECT a.*,ac.id as clave FROM articulos a left join articulos_claves ac on ac.id_articulo=a.id WHERE a.eliminado=0 and a.descripcion LIKE '%".$descripcion."%' order by a.id asc " ;
		$result=$this->Query($query);
		$arrayResult=array();
		if($result['success']){
			while($row=mysqli_fetch_assoc($result['data'])){
				$arrayResult[]=array('label' => $row['clave'].' '.$row['descripcion'].' '.$row['modelo'] , 
									'id' => $row['id'], 
									'descripcion' => $row['descripcion']
									, 
									'modelo' => $row['modelo']
									, 
									'precio' => $row['precio']
									, 
									'existencia' => $row['existencia']
									, 
									'cantidad' => 1
									, 
									'clave' => $row['clave']   );
			}
			$result['data']=$arrayResult;
		}
		return $result['data'];
	}

	function SetArticulo($id_clave,$descripcion,$modelo,$precio,$existencia){
		$this->begin_transaction();
		$query="INSERT INTO  articulos (descripcion,modelo,precio,existencia) values ('".$descripcion."','".$modelo."','".$precio."','".$existencia."') " ;
		$result=$this->Query($query);
		if($result['success']){ 
			$id_articulo=$this->last_insert_id();
			$query_clave="UPDATE articulos_claves SET id_articulo=".$id_articulo." WHERE id=".$id_clave." limit 1" ;
			$result_clave=$this->Query($query_clave);
			if($result_clave['success']){
				$result['message']="Bien Hecho. El Articulo ha sido registrado correctamente";
				$this->commit();
			}else{
				$result['message']="Lo sentimos no se ha podido crear el articulo. intente mas tarde. \n Codigo de error :A004";
				$this->rollback();
			}
		}else{
			$result['message']="Lo sentimos no se ha podido crear el articulo. intente mas tarde. \n Codigo de error :A001";
			$this->rollback();
		}
		return $result;
	}


	function EditArticulo($id_articulo=0,$descripcion,$modelo,$precio,$existencia){

		$query="UPDATE articulos SET descripcion='".$descripcion."',modelo='".$modelo."',precio='".$precio."',existencia='".$existencia."',fecha_modificacion=now() WHERE id='".$id_articulo."' limit 1" ;
		$result=$this->Query($query);
		if($result['success']){ 
			$result['message']="Bien Hecho. El Articulo ha sido modificado correctamente";
		}else{
			$result['message']="Lo sentimos no se ha podido modificar el articulo. intente mas tarde. \n Codigo de error :A002";
		}
		return $result;
	}
}
?>