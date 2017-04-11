<?php 

class Connection {

	var $bd="vendimia";
	var $usuario="root";
	var $pass="";
	var $servidor="localhost";
	var $con; //conexion

	//CONFIG

	
	function Connection($servidor_="localhost",$usuario_="root",$pass_="",$bd_="vendimia"){
		$this->bd=$bd_;
		$this->servidor=$servidor_;
		$this->usuario=$usuario_;
		$this->pass=$pass_;
	}
	
	function Connect()
	{

		if($this->con){
			$this->Close();
		}

		if($this->con=mysqli_connect($this->servidor,$this->usuario,$this->pass)){
			if(mysqli_select_db($this->con,$this->bd)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}

	}

	function Close(){
		mysqli_close($this->con);
	}

	function Query($query=''){
		mysqli_query($this->con,"set charset utf8 ");

		$result['message']="No message";
		$result['data']=null;
		$result['success']="";
		$result['data']=mysqli_query($this->con,$query);
		if($result['data']){
			$result['message']="Query executed successfully";
			$result['success']=true;
		}else{
			$result['data']=null;
			$result['message']=mysqli_error($this->con);
			$result['success']=false;
		}
		return $result;

	}

	function last_insert_id(){
		return mysqli_insert_id($this->con);
	}

	function begin_transaction(){
		 $this->Query("START TRANSACTION");
	}

	function commit(){
		 $this->Query("COMMIT");
	}
	
	function rollback(){
		 $this->Query("ROLLBACK");
	}
	
	function limpiarString($text){

	 $chars =   array("\\", "¨", "º", "~",
	              "|", "!", "\"",
	             "·", "$", "%", "&", "/",
	             "(", ")", "'", "¡",
	              "[", "^", "`", "]",
	             "+", "}", "{", "¨", "´",
	             ">", "<"
	             );
	        

	$clean = str_replace($chars, "", $text);
	return $clean;
	}


	function strip_all($text){

	  return limpiarString(strip_tags($text));

	}

}
?> 