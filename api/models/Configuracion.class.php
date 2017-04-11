<?php
class Configuracion extends Connection {
	
	function Configuracion(){
		$this->Connect();
	}


	function GetConfigs(){

		$query="SELECT c.* FROM configuracion c where c.id=1 limit 1 " ;
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

	function SetConfig($tasa,$enganche,$plazo){

		$query="UPDATE configuracion SET tasa='".$tasa."',enganche='".$enganche."',plazo='".$plazo."',fecha_modificacion=now() WHERE id=1 limit 1" ;
		$result=$this->Query($query);
		if($result['success']){ 
			$result['message']="Bien Hecho. La configuración ha sido registrada";
		}else{
			$result['message']="Lo sentimos no se ha podido modificar la Configuración. intente mas tarde. \n Codigo de error :CON001";
		}
		return $result;
	}
}

?>