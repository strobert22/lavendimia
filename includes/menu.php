<div class="ui fixed inverted menu">
    <div class="ui container">
      <a href="#" class="header item">
        La Vendimia
      </a>
      <a href="index.php" class="item">Inicio</a>
      <div class="ui simple dropdown item">
        Menu <i class="dropdown icon"></i>
        <div class="menu">
          <a class="item" href="ventas.php">Ventas</a>
       	  <div class="divider"></div>
          <a class="item" href="clientes.php">Clientes</a>
          <a class="item" href="articulos.php">Articulos</a>
          <div class="divider"></div>
          <a class="item" href="configuracion.php">Configuración</a>
        </div>
      </div>
        <div class="right menu">
          <div class="ui item" id="fecha_actual">
            <?php echo date("d/m/Y"); ?>
          </div>
        </div>
    </div>
  </div>
      <div id="loading"  style="display:none; opacity: 0.9; z-index: 999; position:fixed; width:40px; height:40px; top:0px; right:0px;" ><img width="100%" height="100%" src="assets/img/loading.gif" alt="Cargando..."  ></div>