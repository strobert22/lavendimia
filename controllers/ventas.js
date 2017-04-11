$( document ).ready(function() {
	var ventas=[];
	var ventas_articulos=[];
	var current_articulo=null;
	var venta_clave=0;
	var configs=[];

	function GetConfigs(){
		GetAjax(
			null,
			"GetConfigs",
			function(response){
				configs=response;
				if(configs[0]["tasa"]==null || configs[0]["tasa"]===undefined || configs[0]["tasa"]==""){
					configs[0]["tasa"]=0;
				}

				if(configs[0]["enganche"]==null || configs[0]["enganche"]===undefined || configs[0]["enganche"]==""){
					configs[0]["enganche"]=0;

				}

				if(configs[0]["plazo"]==null || configs[0]["plazo"]===undefined || configs[0]["plazo"]=="" ){
					configs[0]["plazo"]=0;
				}
				ClearVenta();
			}
		);
	}

	$("#btn_venta_nuevo").click(function(){
		$(".section_venta_crear").show();
		$(".section_venta_list").hide();
		
		GetVentasClave();
	});
	$("#btn_venta_cancelar").click(function(){ //cancelar formulario de cliente
		if(confirm("¿Estas seguro que deseas salir del formulario?")){
			$(".section_venta_crear").hide();
			$(".section_venta_list").show();
				ClearVenta();

		}
	});	

	$("#btn_venta_guardar").click(function(){


			SendAjax(
			"form_venta_crear",
			"SetVenta",
			function(){
				$(".section_venta_crear").hide();
				$(".section_venta_list").show();
				ClearVenta();
				GetVentas();

			});
	

	});	

        $("#form_venta_edit_cliente").click(function(){
        	ClearCliente();
        	RefreshVentasArticulos();

        });

    $( "#form_venta_cliente" ).autocomplete({
      source: 
			function (request, response) {
		    $.ajax({
			  type: "POST",
			  url:"api/api.php",
			  data: {term:request.term, 'request':"GetClientesByName"
	                },
			  success: response,
			  dataType: 'json'
			});
	  }
      ,
      minLength: 3,
      select: function( event, ui ) {
        console.log( "Selected: " + ui.item.value + " aka " + ui.item.id+" rfc: "+ui.item.rfc );
        $("#form_venta_cliente_rfc_label").html(ui.item.rfc);
        $("#form_venta_id_cliente").val(ui.item.id);
        $("#form_venta_edit_cliente").show();
        $("#form_venta_cliente_rfc").show();
        $("#form_venta_cliente").attr("disabled","disabled");
        RefreshVentasArticulos();
      }
    });

    function ClearCliente(){
    	$("#form_venta_cliente").removeAttr("disabled");
    	$("#form_venta_cliente_rfc_label").html("");
        $("#form_venta_id_cliente").val("");
        $("#form_venta_cliente").val("");
        $("#form_venta_edit_cliente").hide();
        $("#form_venta_cliente_rfc").hide();
        HideAbonosMensuales();
        $("#form_venta_cliente").focus();
    }


        $("#form_venta_add_articulo").click(function(){
        	if(current_articulo!=null){
	        	AddArticulo(current_articulo);
	        	ClearArticulo();
        	}else{
        		ShowMensaje("Se necesita buscar un articulo para agregarlo a la venta.");
        		$( "#form_venta_articulo" ).val("");
        		$( "#form_venta_articulo" ).focus();
        	}

        });

    $( "#form_venta_articulo" ).autocomplete({
      source: 
			function (request, response) {
		    $.ajax({
			  type: "POST",
			  url:"api/api.php",
			  data: {term:request.term, 'request':"GetArticulosByName"
	                },
			  success: response,
			  dataType: 'json'
			});
	  }
      ,
      minLength: 3,
      select: function( event, ui ) {
        console.log( "Selected: " + ui.item.value + " aka " + ui.item.id+" clave: "+ui.item.clave );

        if(!ExisteArticulo(ui.item.id)){ //si no se ha agregado el articulo en la lista
        	    if(parseInt(ui.item.existencia)<=0){ // si no hay existencia del articulo selecconado
		        	ShowMensaje("El artículo seleccionado no cuenta con existencia, favor de verificar”.");
		        	ClearArticulo();
		        }else{
		        	current_articulo=ui.item;
		        	$("#form_venta_id_articulo").val(ui.item.id);
		        }
        } else{ // ya se ha agregado ese articulo
				ShowMensaje("El artículo seleccionado ya se encuentra agregado a la venta, favor de verificar”.");
		        ClearArticulo();
        }

        
      }
    });

    function ExisteArticulo(id){
    	var existe=false;
    	for (var i = 0; i < ventas_articulos.length; i++) {
    		if(parseInt(id)==parseInt(ventas_articulos[i].id)){
    			existe=true;
    			break;
    		}

    	}

    	return existe;

    }

    function ClearArticulo(){
        $("#form_venta_id_articulo").val("");
        $("#form_venta_articulo").val("");
        $("#form_venta_articulo").focus();
        current_articulo=null;
    }

    function AddArticulo(item){
    	ventas_articulos.push(item);
    	RefreshVentasArticulos();

    }


    function RemoveArticulo(idx){
    	ventas_articulos.splice(idx, 1);
    	RefreshVentasArticulos();
    }

	function RefreshVentasArticulos(){
		var html_ventas_articulos="";

		var total_articulos=0;
		var enganche=0;
		var bono=0;
		var total=0;
		var total_count_articulos=0;
		if(ventas_articulos.length==0 || ventas_articulos==null || ventas_articulos===undefined){
			html_ventas_articulos+='<tr  >';
            html_ventas_articulos+='</tr>';
            ventas_articulos=[];
             HideAbonosMensuales();
		}else{
			
			for (var i = 0; i < ventas_articulos.length; i++) {
				html_ventas_articulos+='<tr>';
	            html_ventas_articulos+='	<td   item-index="'+i+'"  >'+ventas_articulos[i].clave+'</td>'; 
	            html_ventas_articulos+='	<td   item-index="'+i+'"  >'+ventas_articulos[i].descripcion+'</td>'; 
	            html_ventas_articulos+='	<td  item-index="'+i+'"  >'+ventas_articulos[i].modelo+'</td>'; 
	            html_ventas_articulos+='	<td  item-index="'+i+'"  >'; 
	           	html_ventas_articulos+='	<input item-index="'+i+'" class="form_venta_cantidades input-form_venta_crear" value="'+ventas_articulos[i].cantidad+'" type="number" name="cantidades_'+i+'" id="form_venta_cantidad_'+ventas_articulos.id+'" >'; 
	           	html_ventas_articulos+='	<input value="'+ventas_articulos[i].id+'" type="hidden" name="articulos_'+i+'" id="form_venta_articulo_'+ventas_articulos[i].id+'" class="input-form_venta_crear" >'; 
	           	html_ventas_articulos+='	</td>'; 

	           	var precio_articulo=ventas_articulos[i].precio * (1 + (parseFloat(configs[0]['tasa'])*parseInt(configs[0]['plazo'])) / 100 );
	           	html_ventas_articulos+='	<td  item-index="'+i+'"  >$'+precio_articulo.toFixed(2)+'</td>'; 
	            html_ventas_articulos+='	<td  item-index="'+i+'"  >$'+(precio_articulo*ventas_articulos[i].cantidad).toFixed(2)+'</td>'; 
	            html_ventas_articulos+='	<td >';
	            html_ventas_articulos+='		<button type="button" class="ui primary button btn_venta_remove_articulo" item-index="'+i+'"   >Eliminar</button>'; 
	            html_ventas_articulos+='	</td>';
	            html_ventas_articulos+='</tr>';

	            var precio_importe=(precio_articulo*ventas_articulos[i].cantidad);
				total_count_articulos++;
	            total_articulos+=precio_importe;
			}			
		}

		$("#form_venta_total_articulos").val(total_count_articulos);

		enganche=(parseFloat(configs[0]['enganche'])/100) *total_articulos;
		bono=enganche * ((parseFloat(configs[0]['tasa']) * parseInt(configs[0]['plazo'])) /100);
		total=(total_articulos - enganche) - bono;
		$("#table_ventas_articulos").empty().append(html_ventas_articulos);

		$("#form_venta_enganche").val(enganche);
		$("#form_venta_bono").val(bono);
		$("#form_venta_total").val(total);

		$("#enganche").empty().append(enganche.toFixed(2));
		$("#bono").empty().append(bono.toFixed(2));
		$("#total").empty().append(total.toFixed(2));

		var precio_contado= total /(1+ ((parseFloat(configs[0]['tasa'])*parseInt(configs[0]['plazo']))/100 ));

		var total_pagar_3=precio_contado * (1 + (configs[0]['tasa'] * 3) / 100);
		var total_pagar_6=precio_contado * (1 + (configs[0]['tasa'] * 6) / 100);
		var total_pagar_9=precio_contado * (1 + (configs[0]['tasa'] * 9) / 100);
		var total_pagar_12=precio_contado * (1 + (configs[0]['tasa'] * 12) / 100);

		var importe_abono_3=total_pagar_3 / 3;
		var importe_abono_6=total_pagar_6 / 6;
		var importe_abono_9=total_pagar_9 / 9;
		var importe_abono_12=total_pagar_12 / 12;

		var importe_ahorra_3=total - total_pagar_3;
		var importe_ahorra_6=total - total_pagar_6;
		var importe_ahorra_9=total - total_pagar_9;
		var importe_ahorra_12=total - total_pagar_12;

		var html_ventas_plazos='';

			html_ventas_plazos+='<div class="ui segment">';
	        html_ventas_plazos+='	<center>ABONOS MENSUALES</center>';
	        html_ventas_plazos+='</div>';
	        html_ventas_plazos+='<div class="ui blue segment grid">';
       		html_ventas_plazos+='	<div class="four wide column " >3 ABONOS DE $'+importe_abono_3.toFixed(2)+'</div>';
       		html_ventas_plazos+='	<div class="five wide column " >TOTAL A PAGAR $'+total_pagar_3.toFixed(2)+'</div>';
       		html_ventas_plazos+='	<div class="five wide column " >SE AHORRA $'+importe_ahorra_3.toFixed(2)+'</div>';
       		html_ventas_plazos+='	<div class="two wide column " ><input type="radio" name="plazos" error="Debe seleccionar un plazo para realizar el pago de su compra" class="input-form_venta_crear" value="3" required></div>';
	        html_ventas_plazos+='</div>';
	        html_ventas_plazos+='<div class="ui segment grid">';
       		html_ventas_plazos+='	<div class="four wide column " >6 ABONOS DE $'+importe_abono_6.toFixed(2)+'</div>';
       		html_ventas_plazos+='	<div class="five wide column " >TOTAL A PAGAR $'+total_pagar_6.toFixed(2)+'</div>';
       		html_ventas_plazos+='	<div class="five wide column " >SE AHORRA $'+importe_ahorra_6.toFixed(2)+'</div>';
       		html_ventas_plazos+='	<div class="two wide column " ><input type="radio" name="plazos"  error="Debe seleccionar un plazo para realizar el pago de su compra" class="input-form_venta_crear" value="4" required></div>';
	        html_ventas_plazos+='</div>';
	        html_ventas_plazos+='<div class="ui segment grid">';
       		html_ventas_plazos+='	<div class="four wide column " >9 ABONOS DE $'+importe_abono_9.toFixed(2)+'</div>';
       		html_ventas_plazos+='	<div class="five wide column " >TOTAL A PAGAR $'+total_pagar_9.toFixed(2)+'</div>';
       		html_ventas_plazos+='	<div class="five wide column " >SE AHORRA $'+importe_ahorra_9.toFixed(2)+'</div>';
       		html_ventas_plazos+='	<div class="two wide column " ><input type="radio" name="plazos"  error="Debe seleccionar un plazo para realizar el pago de su compra" class="input-form_venta_crear" value="9" required></div>';
	        html_ventas_plazos+='</div>';
	        html_ventas_plazos+='<div class="ui segment grid">';
       		html_ventas_plazos+='	<div class="four wide column " >12 ABONOS DE $'+importe_abono_12.toFixed(2)+'</div>';
       		html_ventas_plazos+='	<div class="five wide column " >TOTAL A PAGAR $'+total_pagar_12.toFixed(2)+'</div>';
       		html_ventas_plazos+='	<div class="five wide column " >SE AHORRA $'+importe_ahorra_12.toFixed(2)+'</div>';
       		html_ventas_plazos+='	<div class="two wide column " ><input type="radio" name="plazos"  error="Debe seleccionar un plazo para realizar el pago de su compra" class="input-form_venta_crear" value="12" required></div>';
	        html_ventas_plazos+='</div>';


		$(".section_venta_crear_2").empty().append(html_ventas_plazos);

		$(".form_venta_cantidades").change(function(){
			var idx=$(this).attr("item-index");
			var cant=$(this).val();
			if(isNaN(cant)){
				cant=1;
			}else if(cant<=0) {
				cant=1;
			}
			if(parseInt(cant)>ventas_articulos[idx].existencia){
        		ShowMensaje("La cantidad del artículo no puede ser mayor a la existencia, favor de verificar”.");
       			ventas_articulos[idx].cantidad=1;
       		}else{
				ventas_articulos[idx].cantidad=parseInt(cant);				
       		}

			RefreshVentasArticulos();
        });


		$(".btn_venta_remove_articulo").click(function(){
			var idx=$(this).attr("item-index");
        	RemoveArticulo(idx);
        });
	}

	$("#btn_venta_next").click(function(){ //Cuando da siguiente valida si tiene los datos correctos
    	if($("#form_venta_id_cliente").val()==0 || $("#form_venta_id_cliente").val()==""){
    		ShowMensaje("Los datos ingresados no son correctos, favor de verificar");
    	}else if(ventas_articulos.length<=0){
    		ShowMensaje("Los datos ingresados no son correctos, favor de verificar");
    	}else{
    		ShowAbonosMensuales();
    	}
    });

	function HideAbonosMensuales(){
		$("#btn_venta_guardar").hide();
		$(".section_venta_crear_2").hide();
		$("#btn_venta_next").show();
	}
	function ShowAbonosMensuales(){
		$("#btn_venta_guardar").show();
		$(".section_venta_crear_2").show();
		$("#btn_venta_next").hide();
	}
	function RefreshVentas(ventas_){
		var html_ventas="";
		if(ventas_.length==0 || ventas_==null || ventas_===undefined){
			html_ventas+='<tr  >';
            html_ventas+='	<td  ></td>'; 
            html_ventas+='	<td  >Sin registros de ventas.</td>'; 
            html_ventas+='	<td  ></td>'; 
            html_ventas+='</tr>';
            ventas=[];
		}else{
			ventas=ventas_;
			for (var i = 0; i < ventas_.length; i++) {
				html_ventas+='<tr>';
	            html_ventas+='	<td   item-index="'+i+'"  >'+ventas_[i]['clave']+'</td>'; 
	            html_ventas+='	<td   item-index="'+i+'"  >'+ventas_[i]['clave_cliente']+'</td>'; 
	            html_ventas+='	<td  item-index="'+i+'"  >'+ventas_[i]['nombre_cliente']+'</td>'; 
	            html_ventas+='	<td  item-index="'+i+'"  >$'+parseFloat(ventas_[i]['total']).toFixed(2)+'</td>'; 
	            html_ventas+='	<td  item-index="'+i+'"  >'+ventas_[i]['fecha_registro']+'</td>'; 
	            html_ventas+='	<td >';
	            //html_ventas+='		<button type="button" class="ui primary button btn_venta_editar" item-index="'+i+'"   >Editar</button>'; 
	            html_ventas+='	</td>';
	            html_ventas+='</tr>';
			}			
		}

		$("#table_ventas").empty().append(html_ventas);

		/*$(".btn_venta_visualizar").click(function(){ // muestra la venta
			
			var idx=$(this).attr("item-index");
			$("#form_ventas_editar_id_venta").val(ventas[idx]['id']);
			$("#form_ventas_editar_id_clave_label").val(ventas[idx]['clave']);
			$(".section_venta_visualizar").hide();
			$(".section_venta_list").hide();
			
		});	*/
	}

	function GetVentasClave(){

		$("#form_venta_id_clave_label").val("Generando...");
		venta_clave=0;
		GetAjax(
			null,
			"GetVentasClave",
			function(response){
				venta_clave=response;
				$("#form_venta_id_clave").val(venta_clave);
				$("#form_venta_id_clave_label").html(ZeroFill(venta_clave,8));

			}
		);
	}

	function GetVentas(){

		GetAjax(
			null,
			"GetVentas",
			function(response){
				ventas=response;
				RefreshVentas(ventas);
			}
		);
	}
	function ClearVenta(){
		$("#form_venta_crear")[0].reset();
		ClearCliente();
		ClearArticulo();
		ventas_articulos=[];
		venta_clave=0;
		RefreshVentasArticulos();
	}

	function InitializeVentas(){
		GetConfigs();
		GetVentas();
		ClearCliente();
		ClearArticulo();
	}

	InitializeVentas();
});