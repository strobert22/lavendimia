$( document ).ready(function() {
	var clientes=[];
	var cliente_clave=0;
	$("#btn_cliente_nuevo").click(function(){
		$(".section_cliente_crear").show();
		$(".section_cliente_list").hide();
		$(".section_cliente_editar").hide();
		GetClientesClave();
	});
	$("#btn_cliente_cancelar").click(function(){ //cancelar formulario de cliente
		if(confirm("¿Estas seguro que deseas salir del formulario?")){
			$(".section_cliente_crear").hide();
			$(".section_cliente_list").show();
			$(".section_cliente_editar").hide();
			$("#form_cliente_crear")[0].reset();
		}
	});	

	$("#btn_cliente_editar_cancelar").click(function(){
		if(confirm("¿Estas seguro que deseas salir del formulario?")){
			$(".section_cliente_crear").hide();
			$(".section_cliente_list").show();
			$(".section_cliente_editar").hide();
		}
	});	


	$("#btn_cliente_guardar").click(function(){
			SendAjax(
			"form_cliente_crear",
			"SetCliente",
			function(){
				$(".section_cliente_crear").hide();
				$(".section_cliente_list").show();
				$(".section_cliente_editar").hide();
				GetClientes();
			});
	});	


	$("#btn_cliente_editar_guardar").click(function(){
			SendAjax(
			"form_cliente_editar",
			"EditCliente",
			function(){
				$(".section_cliente_crear").hide();
				$(".section_cliente_list").show();
				$(".section_cliente_editar").hide();
				GetClientes();
			});
	});	


	function RefreshClientes(clientes_){
		var html_clientes="";
		if(clientes_.length==0 || clientes_==null || clientes_===undefined){
			html_clientes+='<tr  >';
            html_clientes+='	<td  ></td>'; 
            html_clientes+='	<td  >Sin registros de Clientes.</td>'; 
            html_clientes+='	<td  ></td>'; 
            html_clientes+='</tr>';
            usuarios=[];
		}else{
			usuarios=clientes_;
			for (var i = 0; i < clientes_.length; i++) {
				html_clientes+='<tr>';
	            html_clientes+='	<td   item-index="'+i+'"  >'+clientes_[i]['clave']+'</td>'; 
	            html_clientes+='	<td   item-index="'+i+'"  >'+clientes_[i]['nombre']+' '+clientes_[i]['apaterno']+' '+clientes_[i]['amaterno']+'</td>'; 
	            html_clientes+='	<td  item-index="'+i+'"  >'+clientes_[i]['rfc']+'</td>'; 
	            html_clientes+='	<td >';
	            html_clientes+='		<button type="button" class="ui primary button btn_cliente_editar" item-index="'+i+'"   >Editar</button>'; 
	            html_clientes+='	</td>';
	            html_clientes+='</tr>';
			}			
		}

		$("#table_clientes").empty().append(html_clientes);

		$(".btn_cliente_editar").click(function(){ // muestra formulario de edicion de alumno
			
			var idx=$(this).attr("item-index");
			$("#form_cliente_editar_id_cliente").val(clientes[idx]['id']);
			$("#form_cliente_editar_nombre").val(clientes[idx]['nombre']);
			$("#form_cliente_editar_apaterno").val(clientes[idx]['apaterno']);
			$("#form_cliente_editar_amaterno").val(clientes[idx]['amaterno']);
			$("#form_cliente_editar_rfc").val(clientes[idx]['rfc']);
			$("#form_cliente_editar_id_clave_label").val(clientes[idx]['clave']);


			$(".section_cliente_crear").hide();
			$(".section_cliente_list").hide();
			$(".section_cliente_editar").show();
		});	
	}

	function GetClientesClave(){
		$("#form_cliente_id_clave_label").val("Generando...");
		cliente_clave=0;
		GetAjax(
			null,
			"GetClientesClave",
			function(response){
				cliente_clave=response;
				$("#form_cliente_id_clave").val(cliente_clave);
				$("#form_cliente_id_clave_label").html(ZeroFill(cliente_clave,8));

			}
		);
	}

	function GetClientes(){

		GetAjax(
			null,
			"GetClientes",
			function(response){
				clientes=response;
				RefreshClientes(clientes);
			}
		);
	}

	function InitializeClientes(){
			GetClientes();
	}

	InitializeClientes();
});