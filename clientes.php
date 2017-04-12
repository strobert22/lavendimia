<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <title>Vendimia | Clientes</title>
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
      <h1 class="ui header">Catalogo de Clientes</h1>
    </div>
  </div>

  <div class="row">
    <div class=" four column">
          <div class="ui breadcrumb">
            <a class="section" href="index.php" >Inicio</a>
            <div class="divider"> / </div>
            <a class="section active" href="#" >Clientes</a>
          </div>
    </div>
  </div>
  <div class="row section_cliente_list">
    <div class=" four column">
          <button class="ui primary button" type="button" id="btn_cliente_nuevo" >Agregar Cliente</button>
    </div>
  </div>

  <div class="row section_cliente_list">
    <div class="eight column " >
          <table class="ui celled table" > 
            <thead>
              <tr>
                  <th>Clave</th>
                  <th>Nombre</th>
                  <th>RFC</th>
                  <th></th>
              </tr>
            </thead>
            <tbody id="table_clientes">
              <tr>
                <td>...</td>
                <td>...</td>
                <td> </td>
              </tr>
            </tbody>
          </table>
    </div>
  </div>
  <div class="row section_cliente_crear" style="display:none;">
    <div  class="eight column " >
      <h1>Registro de Cliente Nuevo</h1>
      <form class="ui form" id="form_cliente_crear">
        <div class="field">
          <label>Clave: <storng id="form_cliente_id_clave_label">Generando...</strong></label>
        </div>
        <div class="field">
          <label>Nombre</label>
          <input name="id_clave" value="" id="form_cliente_id_clave" error="No es posible continuar, error en la clave, es obligatorio." class="input-form_cliente_crear" type="hidden" required>
          <input name="nombre" id="form_cliente_nombre" placeholder="Jhon" maxlength="45" error="No es posible continuar, debe ingresar el nombre del cliente correctamente, es obligatorio." class="input-form_cliente_crear" type="text" required>
        </div>
        <div class="field">
          <label>Apellido Paterno</label>
          <input name="apaterno" id="form_cliente_apaterno" placeholder="Vega" maxlength="45" error="No es posible continuar, debe ingresar el apellido paterno correctamente, es obligatorio."  class="input-form_cliente_crear" type="text" required>
        </div>
        <div class="field">
          <label>Apellido Materno</label>
          <input name="amaterno" id="form_cliente_amaterno" placeholder="Lopez" maxlength="45" error="No es posible continuar, debe ingresar el apellido materno correctamente, es obligatorio." class="input-form_cliente_crear" type="text" required>
        </div>
        <div class="field">
          <label>RFC</label>
          <input name="rfc" id="form_cliente_rfc" placeholder="XXXX010101000"  error="No es posible continuar, debe ingresar el RFC correctamente, es obligatorio.: Formato XXXX010101000" class="input-form_cliente_crear" type="rfc" required>
        </div>
         <button class="ui default button" id="btn_cliente_cancelar" type="button">Cancelar</button> <button class="ui primary button" id="btn_cliente_guardar" type="button">Guardar</button>
      </form>
    </div>
  </div>

  <div class="row section_cliente_editar" style="display:none;">
    <div  class="eight column " >
      <h1>Modificación de Cliente</h1>
      <form class="ui form" id="form_cliente_editar">
        <div class="field">
          <label>Clave: <storng id="form_cliente_editar_id_clave_label"></strong></label>
        </div>
        <div class="field">
          <label>Nombre</label>
          <input name="id_cliente" id="form_cliente_editar_id_cliente" value="0" error="selecciona correctamente el cliente" class="input-form_cliente_editar" type="hidden" required>
          <input name="nombre" id="form_cliente_editar_nombre" placeholder="Jhon" maxlength="45" error="No es posible continuar, debe ingresar el nombre correctamente,es obligatorio." class="input-form_cliente_editar" type="text" required>
        </div>
        <div class="field">
          <label>Apellido Paterno</label>
          <input name="apaterno" id="form_cliente_editar_apaterno" placeholder="Vega" maxlength="45" error="No es posible continuar, debe ingresar el apellido paterno correctamente, es obligatorio."  class="input-form_cliente_editar" type="text" required>
        </div>
        <div class="field">
          <label>Apellido Materno</label>
          <input name="amaterno" id="form_cliente_editar_amaterno" placeholder="Lopez" maxlength="45" error="No es posible continuar, debe ingresar el apellido materno del cliente" class="input-form_cliente_editar" type="text" required>
        </div>
        <div class="field">
          <label>RFC</label>
          <input name="rfc" id="form_cliente_editar_rfc" placeholder="XAXX010101000"  error="No es posible continuar, debe ingresar el RFC correcamente, es obligatorio. Formato XXXX010101000" class="input-form_cliente_editar" type="rfc" required>
        </div>
         <button class="ui default button" id="btn_cliente_editar_cancelar" type="button">Cancelar</button> <button class="ui primary button" id="btn_cliente_editar_guardar" type="button">Guardar</button>
      </form>
    </div>
  </div>

</div>
      <?php
        include_once('includes/modals.php');
      ?>
      <script src="controllers/clientes.js"></script>
  <body>
  </html>