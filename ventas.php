<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <title>Vendimia | Ventas</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <?php
        include_once('includes/scripts.php');
      ?>
    </head>
  <body class="bg_pattern" >
  	<?php 
  		include_once('includes/menu.php');
  	?>



<div class="ui grid container" style="margin-top:40px;">
  <div class="row">
    <div class="four column">
      <h1 class="ui header">Ventas</h1>
    </div>
  </div>

  <div class="row">
    <div class=" four column">
          <div class="ui breadcrumb">
            <a class="section" href="index.php" >Inicio</a>
            <div class="divider"> / </div>
            <a class="section active" href="#" >Ventas</a>
          </div>
    </div>
  </div>

  <div class="row section_venta_list">
    <div class=" four column">
          <button class="ui primary button" type="button" id="btn_venta_nuevo" >Nueva Venta</button>
    </div>
  </div>

  <div class="row section_venta_list">
    <div class="eight column " >
          <table class="ui celled table" > 
            <thead>
              <tr>
                  <th>Folio Venta</th>
                  <th>Clave cliente</th>
                  <th>Nombre</th>
                  <th>Total</th>
                  <th>Fecha</th>
                  <th></th>
              </tr>
            </thead>
            <tbody id="table_ventas">
              <tr>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
              </tr>
            </tbody>
          </table>
    </div>
  </div>

  <div class="row section_venta_crear" style="display:none;">
    <div  class="eight column " >
      <h1>Registro de Ventas</h1>

      <form class="ui form" id="form_venta_crear">
      	<div class="ui segments">
	        <div class="ui segment">
	          <label>Folio: <storng id="form_venta_id_clave_label">Generando...</strong></label>
	          <input name="id_clave" value="" id="form_venta_id_clave" error="No es posible continuar, error en la clave, es obligatorio." class="input-form_venta_crear" type="hidden" required>
	        </div>
	        <div class="ui blue segment">
	        	<div class="ui labeled action input">
	        		  <div class="ui label">
					    Buscar Cliente:
					  </div>
					  	<input name="id_cliente" value="" id="form_venta_id_cliente"  error="No es posible continuar, debe ingresar el Cliente correctamente, es obligatorio."  class="input-form_venta_crear" type="hidden" required>
	        			<input name="cliente_nombre" id="form_venta_cliente" placeholder="juan perez" maxlength="45" error="No es posible continuar, debe ingresar la busqueda del cliente correctamente, es obligatorio."  class="input-form_venta_crear" type="text" >
	        			<button class="ui primary button" type="button" id="form_venta_edit_cliente" style="display:none;" > Cambiar </button>
	        		<div class="ui label" id="form_venta_cliente_rfc" style="display:none;" >
					    RFC: <strong id="form_venta_cliente_rfc_label" ></strong>
					</div>
	        	</div>
 	        	
	        </div>
	        <div class="ui segment">
	        	<div class="ui labeled action input">
	        		<div class="ui label">
					    Buscar Articulo:
					  </div> 
					<input name="id_articulo"  value="0" id="form_venta_id_articulo"  error="No es posible continuar, debe ingresar el Cliente correctamente, es obligatorio."  class="input-form_venta_crear" type="hidden" >
	        		<input name="articulo_nombre" id="form_venta_articulo" placeholder="mueble" maxlength="45" error="No es posible continuar, debe ingresar la busqueda del articulo correctamente, es obligatorio."  class="input-form_venta_crear" type="text" >
	        		<button class="ui primary button" type="button" id="form_venta_add_articulo" > + </button>
	        	</div>
	        </div>
	    </div>
              <input name="total_articulos" value="0" id="form_venta_total_articulos"  error="No es posible continuar, debe ingresar el total de articulos correctamente, es obligatorio."  class="input-form_venta_crear" type="hidden">

      	<div class="ui segments">
	        <div class="ui blue segment">
	        	<div class="eight column " >
			          <table class="ui celled table" > 
			            <thead>
			              <tr>
			                  <th>Clave</th>
			                  <th>Descripción</th>
			                  <th>Modelo</th>
			                  <th>Cantidad</th>
			                  <th>Precio</th>
			                  <th>Importe</th>
			                  <th></th>
			              </tr>
			            </thead>
			            <tbody id="table_ventas_articulos">
			              <tr>

			              </tr>
			            </tbody>
			          </table>
			    </div>
	        </div>
	       	<div class="ui segment grid ">
	       		<div class="row">
	       			<div class="eight wide column " ></div>
	       			<div class="four wide column " >Enganche</div>
	       			<div id="enganche" class="four wide column " >0</div>
	       			<input value="0" type="hidden" id="form_venta_enganche" class="input-form_venta_crear"  name="enganche"  >
	       		</div>
	       		<div class="row">
	       			<div class="eight wide column " ></div>
	       			<div class="four wide column " >Bonificación Enganche</div>
	       			<div id="bono" class="four wide column " >0</div>
	       			<input value="0" type="hidden" id="form_venta_bono" class="input-form_venta_crear"  name="bono"  >
	       		</div>
	       		<div class="row">
	       			<div class="eight wide column " ></div>
	       			<div class="four wide column " >Total</div>
	       			<div id="total" class="four wide column " >0</div>
	       			<input value="0" type="hidden" id="form_venta_total" class="input-form_venta_crear"  name="total"  >

	       		</div>
	       	</div>
	    </div>

      <div class="ui segments section_venta_crear_2" style="display:none;" >

	    </div>

      <div class="ui segment grid"  >
   			<div class="eight wide column " ></div>
   			<div class="four wide column " ></div>
   			<div class="four wide column " >
				<button class="ui default button" id="btn_venta_cancelar" type="button">Cancelar</button>
 				<button class="ui primary button" id="btn_venta_next" type="button">Siguiente</button>
  				<button class="ui primary button" id="btn_venta_guardar" style="display:none;" type="button">Guardar</button>
   			</div>
	    </div>
       
      </form>
    </div>
  </div>


</div>
      <?php
        include_once('includes/modals.php');
      ?>
      <script src="controllers/ventas.js"></script>
  <body>
  </html>