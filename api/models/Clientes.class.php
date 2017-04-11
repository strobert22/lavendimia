<?php 

class Clientes extends Connection {
	
	function Clientes(){
		$this->Connect();
	}

	function GetClientes(){

		$query="SELECT c.*,cc.id as clave FROM clientes c left join clientes_claves cc on cc.id_cliente=c.id WHERE c.eliminado=0 order by c.id asc " ;
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
	
	function GetClientesClave(){

		$query="INSERT INTO clientes_claves (id_cliente) values (0);" ;
		$result=$this->Query($query);
		if($result['success']){ 
			$last_id=$this->last_insert_id();
			$result['data']=$last_id;
		}else{
			$result['message']="No se pudo generar una nueva clave, intente mas tarde. Codigo de error: C003";

		}
		return $result;
	}

	function GetClientesByName($nombre=''){

		$query="SELECT c.*,cc.id as clave FROM clientes c left join clientes_claves cc on cc.id_cliente=c.id WHERE c.eliminado=0 
		and concat(c.nombre,' ',c.apaterno,' ',c.amaterno) LIKE '%".$nombre."%'  order by c.id asc " ;
		$result=$this->Query($query);
		$arrayResult=array();
		if($result['success']){
			$i=0; 
			while($row=mysqli_fetch_assoc($result['data'])){
				$arrayResult[]=array('label' => $row['clave'].' '.$row['nombre'].' '.$row['apaterno'].' '.$row['amaterno'] , 
									'id' => $row['id'], 
									'rfc' => $row['rfc'] );
				$i++;
			}
			$result['data']=$arrayResult;
		}
		return $result['data'];
	}

	function SetCliente($id_clave,$nombre,$apaterno,$amaterno,$rfc){
		$this->begin_transaction();
		$query="INSERT INTO  clientes (nombre,apaterno,amaterno,rfc) values ('".$nombre."','".$apaterno."','".$amaterno."','".$rfc."') " ;
		$result=$this->Query($query);
		if($result['success']){ 
			$id_cliente=$this->last_insert_id();
			$query_clave="UPDATE clientes_claves SET id_cliente=".$id_cliente." WHERE id=".$id_clave." limit 1" ;
			$result_clave=$this->Query($query_clave);
			if($result_clave['success']){
				$result['message']="Bien Hecho. El Cliente ha sido registrado correctamente";
				$this->commit();
			}else{
				$result['message']="Lo sentimos no se ha podido crear el cliente. intente mas tarde. \n Codigo de error :C004";
				$this->rollback();
			}
		}else{
			$result['message']="Lo sentimos no se ha podido crear el cliente. intente mas tarde. \n Codigo de error :C001";
			$this->rollback();
		}
		return $result;
	}


	function EditCliente($id_cliente=0,$nombre,$apaterno,$amaterno,$rfc){

		$query="UPDATE clientes SET nombre='".$nombre."',apaterno='".$apaterno."',amaterno='".$amaterno."',rfc='".$rfc."',fecha_modificacion=now() WHERE id='".$id_cliente."' limit 1" ;
		$result=$this->Query($query);
		if($result['success']){ 
			$result['message']="Cliente modificado correctamente";
		}else{
			$result['message']="Lo sentimos no se ha podido crear el cliente. intente mas tarde. \n Codigo de error :C002";
		}
		return $result;
	}
}
?>