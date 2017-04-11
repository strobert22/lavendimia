<?php
	//includes de models o classes
	require_once("models/funciones.php");
	require_once("models/Connection.class.php");
	require_once("models/Clientes.class.php");
	require_once("models/Articulos.class.php");
	require_once("models/Configuracion.class.php");
	require_once("models/Ventas.class.php");

	/*inicializando result object*/
	$result['success']=false;
	$result['message']='Invalid Request';
	$result['data']=null;

	if(isset($_POST['request'])){

		$request=$_POST;



		switch ($request['request']) {

			/* === CLIENTES ===*/

			case 'GetClientes':
				$clientes = new Clientes();
				$result=$clientes->GetClientes();
				$clientes->Close();
			break;

			case 'GetClientesByName':
				$clientes = new Clientes();
				$result=$clientes->GetClientesByName(strip_all($request['term']));
				$clientes->Close();
			break;

			case 'GetClientesClave':
				$clientes = new Clientes();
				$result=$clientes->GetClientesClave();
				$clientes->Close();
			break;

			case 'SetCliente':
					if(isset($request['data'])){
						foreach ($request['data'] as $key => $value) {
							$request['data'][$key]=strip_all($value); // Elimina chars especiales y tags htmls
						}			
					}
				$clientes = new Clientes();
				if(!isset($request['data']['id_clave']) || !is_numeric($request['data']['id_clave']) ){
					$result['message']="No es posible continuar, debe ingresar el id_clave correctamente, es obligatorio.";

				}else if(!isset($request['data']['nombre']) || empty($request['data']['nombre']) || is_numeric($request['data']['nombre']) ){
					$result['message']="No es posible continuar, debe ingresar el nombre correctamente, es obligatorio.";

				}else if(!isset($request['data']['apaterno']) || empty($request['data']['apaterno']) || is_numeric($request['data']['apaterno']) ){
					$result['message']="No es posible continuar, debe ingresar el apellido paterno correctamente, es obligatorio.";

				}else if(!isset($request['data']['amaterno']) || empty($request['data']['amaterno']) || is_numeric($request['data']['amaterno']) ){
					$result['message']="No es posible continuar, debe ingresar el apellido materno correctamente, es obligatorio.";

				}else if(!isset($request['data']['rfc']) || empty($request['data']['rfc']) || !preg_match("/^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))((-)?([A-Z\d]{3}))?$/",$request['data']['rfc']) ){
					$result['message']="No es posible continuar, debe ingresar el RFC correctamente, es obligatorio.";
				}else{
					$result=$clientes->SetCliente($request['data']['id_clave'],$request['data']['nombre'],$request['data']['apaterno'],$request['data']['amaterno'],$request['data']['rfc']);
				}
				$clientes->Close();
			break;

			case 'EditCliente':
					if(isset($request['data'])){
						foreach ($request['data'] as $key => $value) {
							$request['data'][$key]=strip_all($value); // Elimina chars especiales y tags htmls
						}			
					}
				$clientes = new Clientes();
				if(!isset($request['data']['id_cliente']) || !is_numeric($request['data']['id_cliente']) ){
					$result['message']="id de cliente incorrecto, intente mas tarde";

				}else if(!isset($request['data']['nombre']) || empty($request['data']['nombre']) || is_numeric($request['data']['nombre']) ){
					$result['message']="No es posible continuar, debe ingresar el nombre correctamente, es obligatorio.";

				}else if(!isset($request['data']['apaterno']) || empty($request['data']['apaterno']) || is_numeric($request['data']['apaterno']) ){
					$result['message']="No es posible continuar, debe ingresar el apellido paterno correctamente, es obligatorio.";

				}else if(!isset($request['data']['amaterno']) || empty($request['data']['amaterno']) || is_numeric($request['data']['amaterno']) ){
					$result['message']="No es posible continuar, debe ingresar el apellido materno correctamente, es obligatorio.";

				}else if(!isset($request['data']['rfc']) || empty($request['data']['rfc']) || !preg_match("/^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))((-)?([A-Z\d]{3}))?$/",$request['data']['rfc']) ){
					$result['message']="No es posible continuar, debe ingresar el RFC correctamente, es obligatorio.";
				}else{
					$result=$clientes->EditCliente($request['data']['id_cliente'],$request['data']['nombre'],$request['data']['apaterno'],$request['data']['amaterno'],$request['data']['rfc']);
				}
				$clientes->Close();
			break;

			//=== Articulos ===

			case 'GetArticulos':
				$articulos = new Articulos();
				$result=$articulos->GetArticulos();
				$articulos->Close();
			break;

			case 'GetArticulosByName':
				$articulos = new Articulos();
				$result=$articulos->GetArticulosByName(strip_all($request['term']));
				$articulos->Close();
			break;

			case 'GetArticulosClave':
				$articulos = new Articulos();
				$result=$articulos->GetArticulosClave();
				$articulos->Close();
			break;

			case 'SetArticulo':
					if(isset($request['data'])){
						foreach ($request['data'] as $key => $value) {
							$request['data'][$key]=strip_all($value); // Elimina chars especiales y tags htmls
						}			
					}
				$articulos = new Articulos();
				if(!isset($request['data']['id_clave']) || !is_numeric($request['data']['id_clave']) ){
					$result['message']="No es posible continuar, debe ingresar el id_clave correctamente, es obligatorio.";

				}else if(!isset($request['data']['descripcion']) || empty($request['data']['descripcion']) ){
					$result['message']="No es posible continuar, debe ingresar la descripcion correctamente, es obligatorio.";

				}else if(!isset($request['data']['modelo']) ){
					$result['message']="No es posible continuar, debe ingresar el modelo correctamente.";

				}else if(!isset($request['data']['precio']) || !is_numeric($request['data']['precio']) || ($request['data']['precio']<=0)){
					$result['message']="No es posible continuar, debe ingresar el precio correctamente, es obligatorio.";

				}else if(!isset($request['data']['existencia']) || !is_numeric($request['data']['existencia']) || ($request['data']['existencia']<0) ){
					$result['message']="No es posible continuar, debe ingresar la existencia correctamente, es obligatorio.";
				}else{
					$result=$articulos->SetArticulo($request['data']['id_clave'],$request['data']['descripcion'],$request['data']['modelo'],$request['data']['precio'],$request['data']['existencia']);
				}
				$articulos->Close();

			break;

			case "EditArticulo":
					if(isset($request['data'])){
						foreach ($request['data'] as $key => $value) {
							$request['data'][$key]=strip_all($value); // Elimina chars especiales y tags htmls
						}			
					}
				$articulos = new Articulos();
				if(!isset($request['data']['id_articulo']) || !is_numeric($request['data']['id_articulo']) ){
					$result['message']="No es posible continuar, debe ingresar el id_articulo correctamente, es obligatorio.";

				}else if(!isset($request['data']['descripcion']) || empty($request['data']['descripcion']) ){
					$result['message']="No es posible continuar, debe ingresar la descripcion correctamente, es obligatorio.";

				}else if(!isset($request['data']['modelo'])){
					$result['message']="No es posible continuar, debe ingresar el modelo correctamente, es obligatorio";

				}else if(!isset($request['data']['precio']) || !is_numeric($request['data']['precio']) || ($request['data']['precio']<=0)){
					$result['message']="No es posible continuar, debe ingresar el precio correctamente, es obligatorio";

				}else if(!isset($request['data']['existencia']) || !is_numeric($request['data']['existencia']) || ($request['data']['existencia']<0) ){
					$result['message']="No es posible continuar, debe ingresar la existencia correctamente, es obligatorio";
				}else{
					$result=$articulos->EditArticulo($request['data']['id_articulo'],$request['data']['descripcion'],$request['data']['modelo'],$request['data']['precio'],$request['data']['existencia']);
				}
				$articulos->Close();

			break;

			// === CONFIGURACION ===

			case "GetConfigs":
				$configuracion = new Configuracion();
				$result=$configuracion->GetConfigs();
				$configuracion->Close();
			break;
			case "SetConfig":
					if(isset($request['data'])){
						foreach ($request['data'] as $key => $value) {
							$request['data'][$key]=strip_all($value); // Elimina chars especiales y tags htmls
						}			
					}
				$configuracion = new Configuracion();

				if(!isset($request['data']['tasa']) || !is_numeric($request['data']['tasa']) || ($request['data']['tasa']<0) ){
					$result['message']="No es posible continuar, debe ingresar la Tasa de Financiamiento correctamente, es obligatorio.";
				}else if(!isset($request['data']['enganche']) || !is_numeric($request['data']['enganche']) || ($request['data']['enganche']<0) ){
					$result['message']="No es posible continuar, debe el Enganche correctamente, es obligatorio.";
				}else if(!isset($request['data']['plazo']) || !is_numeric($request['data']['plazo']) || ($request['data']['plazo']<=0) ){
					$result['message']="No es posible continuar, debe ingresar el Plazo Máximo correctamente, es obligatorio.";
				}else{
					$result=$configuracion->SetConfig($request['data']['tasa'],$request['data']['enganche'],$request['data']['plazo']);
				}
				$configuracion->Close();

			break;		

			//=== VENTAS ===

			case 'GetVentas':
				$ventas = new Ventas();
				$result=$ventas->GetVentas();
				$ventas->Close();
			break;

			case 'GetVentasClave':
				$ventas = new Ventas();
				$result=$ventas->GetVentasClave();
				$ventas->Close();
			break;


			case "SetVenta":
					if(isset($request['data'])){
						foreach ($request['data'] as $key => $value) {
							$request['data'][$key]=strip_all($value); // Elimina chars especiales y tags htmls
						}			
					}
				$configuracion = new Configuracion();
				$configs_result=$configuracion->GetConfigs();
				$configs=$configs_result['data'];
				$configuracion->Close();

				$total_articulos=0;
				$tasa=0;
				$bono=0;
				$enganche=0;
				$total=0;

				$error=0;
				$articulos_array=array();

				if(!isset($request['data']['id_cliente']) || !is_numeric($request['data']['id_cliente']) || !(int)$request['data']['id_cliente']>0 ){
					$result['message']="Lo sentimos el cliente registrado a la venta es invalido. favor de verificar. \n Codigo de error :V013";

				}else if(!isset($request['data']['id_clave']) || !is_numeric($request['data']['id_clave']) || !(int)$request['data']['id_clave']>0 ){
					$result['message']="Lo sentimos no se ha podido registrar la venta. intente mas tarde. \n Codigo de error :V012";

				}else if(isset($request['data']['total_articulos']) && is_numeric($request['data']['total_articulos']) && $request['data']['total_articulos']>0 ){

	 				$articulos = new Articulos();
					for ($i=0; $i < (int)$request['data']['total_articulos']; $i++) { 
						
						$articulo_result=$articulos->GetArticulo($request['data']['articulos_'.$i]);
						$articulo=$articulo_result['data'][0];

						if((int)$request['data']['cantidades_'.$i]<=(int)$articulo['existencia']){ // SI HAY EXISTENCIA
							$precio_articulo=(float)$articulo['precio'] * (1 + ((float)$configs[0]['tasa']*(int)$configs[0]['plazo']) / 100 );
							$precio_articulo_importe=$precio_articulo*(int)$request['data']['cantidades_'.$i];
							$articulo['precio_tasa']=$precio_articulo;
							$articulo['importe']=$precio_articulo_importe;
							$articulo['cantidad']=(int)$request['data']['cantidades_'.$i];

							$articulos_array[]=$articulo; // lo agrega al array de articulos
							$total_articulos+=$precio_articulo_importe;
							

						}else{ // SI NO HAY EXISTENCIA
							$error++;
							$result['message']="Lo sentimos alguno de los articulos no cuenta con existencia. favor de verificar. \n Codigo de error :V011";
							break;
						}
					} 
					$articulos->Close();	

					if($error==0){ //si no hay errores continua

						$enganche=((float)$configs[0]['enganche']/100) *$total_articulos;
						$bono=$enganche * (((float)$configs[0]['tasa'] * (int)$configs[0]['plazo']) /100);
						$total=($total_articulos - $enganche) - $bono;

						$precio_contado= $total /(1+ ( ((float)$configs[0]['tasa']*(int)$configs[0]['plazo'])/100 ));

						$total_pagar_3=$precio_contado * (1 + ((float)$configs[0]['tasa'] * 3) / 100);
						$total_pagar_6=$precio_contado * (1 + ((float)$configs[0]['tasa'] * 6) / 100);
						$total_pagar_9=$precio_contado * (1 + ((float)$configs[0]['tasa'] * 9) / 100);
						$total_pagar_12=$precio_contado * (1 + ((float)$configs[0]['tasa'] * 12) / 100);

						$importe_abono_3=$total_pagar_3 / 3;
						$importe_abono_6=$total_pagar_6 / 6;
						$importe_abono_9=$total_pagar_9 / 9;
						$importe_abono_12=$total_pagar_12 / 12;

						$importe_ahorra_3=$total - $total_pagar_3;
						$importe_ahorra_6=$total - $total_pagar_6;
						$importe_ahorra_9=$total - $total_pagar_9;
						$importe_ahorra_12=$total - $total_pagar_12;

						$total_pagar_venta=$precio_contado * (1 + ((float)$configs[0]['tasa'] * (int)$request['data']['plazos']) / 100);
						$importe_abono_venta=$total_pagar_venta / (int)$request['data']['plazos'];
						$importe_ahorra_venta=$total - $total_pagar_venta;

						$ventas = new Ventas();
						$result=$ventas->SetVenta($request['data']['id_clave'],$request['data']['id_cliente'],$articulos_array,$enganche,$bono,$total,$total_articulos,$importe_abono_venta,$total_pagar_venta,$importe_ahorra_venta,$request['data']['plazos']);
						$ventas->Close();
					}

	 			}else{
	 				$error++;
					$result['message']="Lo sentimos no se ha podido registrar la venta. intente mas tarde. \n Codigo de error :V010";
	 			}



			break;


			default: //no encuentra la request

			break;
		}

		echo json_encode($result); // devuelve el reusltado en json

	}else{ //sin request
		echo json_encode($result); // devuelve el resultado en json
	}
?>