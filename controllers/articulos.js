$( document ).ready(function() {
	var articulos=[];
	var articulo_clave=0;

	$("#btn_articulo_nuevo").click(function(){
		$(".section_articulo_crear").show();
		$(".section_articulo_list").hide();
		$(".section_articulo_editar").hide();
		GetArticulosClave();

	});
	$("#btn_articulo_cancelar").click(function(){ //cancelar formulario de articulo nuevo
		if(confirm("¿Estas seguro que deseas salir del formulario?")){
			$(".section_articulo_crear").hide();
			$(".section_articulo_list").show();
			$(".section_articulo_editar").hide();
			$("#form_articulo_crear")[0].reset();
		}
	});	

	$("#btn_articulo_editar_cancelar").click(function(){

		if(confirm("¿Estas seguro que deseas salir del formulario?")){
			$(".section_articulo_crear").hide();
			$(".section_articulo_list").show();
			$(".section_articulo_editar").hide();
		}

		
	});	

	$("#btn_articulo_guardar").click(function(){
			SendAjax(
			"form_articulo_crear",
			"SetArticulo",
			function(){
				$(".section_articulo_crear").hide();
				$(".section_articulo_list").show();
				$(".section_articulo_editar").hide();
				GetArticulos();
			});
	});	

	$("#btn_articulo_editar_guardar").click(function(){
			SendAjax(
			"form_articulo_editar",
			"EditArticulo",
			function(){
				$(".section_articulo_crear").hide();
				$(".section_articulo_list").show();
				$(".section_articulo_editar").hide();
				GetArticulos();
			});
	});	


	function RefreshArticulos(articulos_){
		var html_articulos="";
		if(articulos_.length==0 || articulos_==null || articulos_===undefined){
			html_articulos+='<tr  >';
            html_articulos+='	<td  ></td>'; 
            html_articulos+='	<td  >Sin registros de articulos.</td>'; 
            html_articulos+='	<td  ></td>'; 

            html_articulos+='</tr>';
            usuarios=[];
		}else{
			usuarios=articulos_;
			for (var i = 0; i < articulos_.length; i++) {
				html_articulos+='<tr>';
	            html_articulos+='	<td   item-index="'+i+'"  >'+articulos_[i]['clave']+'</td>'; 
	            html_articulos+='	<td   item-index="'+i+'"  >'+articulos_[i]['descripcion']+'</td>'; 
	            html_articulos+='	<td   item-index="'+i+'"  >'+articulos_[i]['modelo']+'</td>'; 
	            html_articulos+='	<td   item-index="'+i+'"  >$'+articulos_[i]['precio']+'</td>'; 
	            html_articulos+='	<td   item-index="'+i+'"  >'+articulos_[i]['existencia']+'</td>'; 
	            html_articulos+='	<td >';
	            html_articulos+='		<button type="button" class="ui primary button btn_articulo_editar" item-index="'+i+'"   >Editar</button>'; 
	            html_articulos+='	</td>';
	            html_articulos+='</tr>';
			}			
		}

		$("#table_articulos").empty().append(html_articulos);

		$(".btn_articulo_editar").click(function(){ // muestra formulario de edicion de alumno
			
			var idx=$(this).attr("item-index");
			$("#form_articulo_editar_id_articulo").val(articulos[idx]['id']);
			$("#form_articulo_editar_descripcion").val(articulos[idx]['descripcion']);
			$("#form_articulo_editar_modelo").val(articulos[idx]['modelo']);
			$("#form_articulo_editar_precio").val(articulos[idx]['precio']);
			$("#form_articulo_editar_existencia").val(articulos[idx]['existencia']);
			$("#form_articulo_editar_id_clave_label").html(articulos[idx]['clave']);
			$(".section_articulo_crear").hide();
			$(".section_articulo_list").hide();
			$(".section_articulo_editar").show();
		});
	}

	function GetArticulosClave(){
		$("#form_articulo_id_clave_label").html("Generando...");
		articulo_clave=0;
		GetAjax(
			null,
			"GetArticulosClave",
			function(response){
				articulo_clave=response;
				$("#form_articulo_id_clave").val(articulo_clave);
				$("#form_articulo_id_clave_label").html(ZeroFill(articulo_clave,8));

			}
		);
	}

	function GetArticulos(){

		GetAjax(
			null,
			"GetArticulos",
			function(response){
				articulos=response;
				RefreshArticulos(response);
			}
		);
	}

	function InitializeArticulos(){
			GetArticulos();
	}

	InitializeArticulos();
});
