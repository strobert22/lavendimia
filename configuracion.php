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
      <h1 class="ui header">Configuración del Sistema</h1>
    </div>
  </div>

  <div class="row">
    <div class=" four column">
          <div class="ui breadcrumb">
            <a class="section" href="index.php" >Inicio</a>
            <div class="divider"> / </div>
            <a class="section active" href="#" >Configuración</a>
          </div>
    </div>
  </div>
  <div class="row">
    <div  class="eight column " >
      <h1>Configuración General</h1>
      <form class="ui form" id="form_config">
        <div class="field">
          <label>Tasa de Financiamiento</label>
          <input name="tasa" id="form_config_tasa" placeholder="12.6" size="5" error="No es posible continuar, debe ingresar la Tasa de financiamiento correctamente, es obligatorio." class="input-form_config" type="number" required>
        </div>
        <div class="field">
          <label>% de Enganche</label>
          <input name="enganche" id="form_config_enganche" placeholder="20" size="5" error="No es posible continuar, debe ingresar el Enganche correctamente, es obligatorio."  class="input-form_config" type="number" required>
        </div>
        <div class="field">
          <label>Plazo Máximo</label>
          <input name="plazo" id="form_config_plazo" placeholder="12" size="5" error="No es posible continuar, debe ingresar el Plazo Máximo correctamente, es obligatorio." class="input-form_config" type="number" required>
        </div>
      		<button class="ui default button" id="btn_config_editar_cancelar" type="button">Cancelar</button>
			<button class="ui primary button" id="btn_config_editar_guardar" type="button">Guardar</button>
      </form>
    </div>
  </div>

</div>
      <?php
        include_once('includes/modals.php');
      ?>
      <script src="controllers/configuracion.js"></script>
  <body>
  </html>