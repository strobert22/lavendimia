<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <title>Vendimia | Articulos</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <?php
        include_once('includes/scripts.php');
      ?>
    </head>
  <body class="bg_pattern">
  	<?php 
  		include_once('includes/menu.php');
  	?>

<div class="ui grid container" style="margin-top:40px;">
  <div class="row">
    <div class="four column">
      <h1 class="ui header">Catalogo de Articulos</h1>
    </div>
  </div>

  <div class="row">
    <div class=" four column">
          <div class="ui breadcrumb">
            <a class="section" href="index.php" >Inicio</a>
            <div class="divider"> / </div>
            <a class="section active" href="#" >Articulos</a>
          </div>
    </div>
  </div>
  <div class="row section_articulo_list">
    <div class=" four column">
          <button class="ui primary button" type="button" id="btn_articulo_nuevo" >Agregar Articulo</button>
    </div>
  </div>

  <div class="row section_articulo_list">
    <div class="eight column " >
          <table class="ui celled table" > 
            <thead>
              <tr>
                  <th>Clave</th>
                  <th>Descripción</th>
                  <th>Modelo</th>
                  <th>Precio</th>
                  <th>Existencia</th>
                  <th></th>

              </tr>
            </thead>
            <tbody id="table_articulos">
              <tr>
                <td>...</td>
                <td>...</td>
                <td> </td>
              </tr>
            </tbody>
          </table>
    </div>
  </div>
  <div class="row section_articulo_crear" style="display:none;">
    <div  class="eight column " >
      <h1>Registro de Articulo Nuevo</h1>
      <form class="ui form" id="form_articulo_crear">
        <div class="field">
          <label>Clave: <strong id="form_articulo_id_clave_label">Generando...</strong></label>
        </div>
        <div class="field">
          <label>Descripción</label>
          <input name="id_clave" value="" id="form_articulo_id_clave" error="No es posible continuar, error en la clave, es obligatorio." class="input-form_articulo_crear" type="hidden" required>
          <input name="descripcion" id="form_articulo_descripcion" placeholder="articulo" maxlength="45"  error="No es posible continuar, debe ingresar la descripcion del articulo correctamente, es obligatorio." class="input-form_articulo_crear" type="text" required>
        </div>
        <div class="field">
          <label>Modelo</label>
          <input name="modelo" id="form_articulo_modelo" placeholder="AB-123" maxlength="45" error="No es posible continuar, debe ingresar el Modelo correctamente, es obligatorio."  class="input-form_articulo_crear" type="text" >
        </div>
        <div class="field">
          <label>Precio (MXN)</label>
          <input name="precio" id="form_articulo_precio" placeholder="12.5" error="No es posible continuar, debe ingresar el Precio correctamente, es obligatorio." class="input-form_articulo_crear" type="number" required>
        </div>
        <div class="field">
          <label>Existencia</label>
          <input name="existencia" id="form_articulo_existencia" placeholder="1"  error="No es posible continuar, debe ingresar la existencia del articulo correctamente, es obligatorio." class="input-form_articulo_crear" type="number" required>
        </div>
         <button class="ui default button" id="btn_articulo_cancelar" type="button">Cancelar</button> <button class="ui primary button" id="btn_articulo_guardar" type="button">Guardar</button>
      </form>
    </div>
  </div>

  <div class="row section_articulo_editar" style="display:none;">
    <div  class="eight column " >
      <h1>Modificación de articulo</h1>
      <form class="ui form" id="form_articulo_editar">
       <div class="field">
          <label>Clave: <strong id="form_articulo_editar_id_clave_label">Generando...</strong></label>
        </div>
        <div class="field">
          <label>Descripción</label>
          <input name="id_articulo" id="form_articulo_editar_id_articulo" value="0" error="selecciona correctamente el articulo" class="input-form_articulo_editar" type="hidden" required>
          <input name="descripcion" id="form_articulo_editar_descripcion" placeholder="articulo" error="No es posible continuar, debe ingresar la descripcion del articulo correctamente, es obligatorio."  maxlength="45" class="input-form_articulo_editar" type="text" required>
        </div>
        <div class="field">
          <label>Modelo</label>
          <input name="modelo" id="form_articulo_editar_modelo" placeholder="AB-123" error="No es posible continuar, debe ingresar el Modelo del articulo correctamente." maxlength="45" class="input-form_articulo_editar" type="text" >
        </div>
        <div class="field">
          <label>Precio (MXN)</label>
          <input name="precio" id="form_articulo_editar_precio" placeholder="12.5" error="No es posible continuar, debe ingresar el Precio del articulo correctamente, es obligatorio." class="input-form_articulo_editar" type="number" required>
        </div>
        <div class="field">
          <label>Existencia</label>
          <input name="existencia" id="form_articulo_editar_existencia" placeholder="1"  error="No es posible continuar, debe ingresar la existencia del articulo correctamente, es obligarotio." class="input-form_articulo_editar" type="number" required>
        </div>
         <button class="ui default button" id="btn_articulo_editar_cancelar" type="button">Cancelar</button> <button class="ui primary button" id="btn_articulo_editar_guardar" type="button">Guardar</button>
      </form>
    </div>
  </div>

</div>
      <?php
        include_once('includes/modals.php');
      ?>
      <script src="controllers/articulos.js"></script>
  <body>
  </html>
