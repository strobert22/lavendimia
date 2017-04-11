
function ShowConfirm(msg){
	$('#modal_confirm_mensaje').html(msg);
	$('#modal_confirm').modal('show');
}


function ShowMensaje(msg){
	$('#modal_mensaje').html(msg);
	$('#modal_aviso').modal('show');
}

function ZeroFill( number, width )
{
  width -= number.toString().length;
  if ( width > 0 )
  {
    return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
  }
  return number + ""; // always return a string
}

function ShowLoading(){
  		$("#loading").fadeIn('fast');
 }

function HideLoading(){
		$("#loading").fadeOut('fast');
} 	

function getFormData($form){
	    var unindexed_array = $form.serializeArray();
	    var indexed_array = {};
	    $.map(unindexed_array, function(n, i){
	        indexed_array[n['name']] = n['value'];
	    });

	    return indexed_array;
	}

    function validarTipo(input){ //VALIDADOR

		if(input.prop('required')){ // si es requerido
			var valor=input.val();
			var texto=input.children(':selected').text();
			var validado=false;
			if(!valor.trim()=="")// si no esta vacio sigue validando
			{ 
				switch(input.attr("type")) 
				{//Sicumple con los requerimientos de tipo de datos entonces el valor de validado se cambia a true
					case "text":
						if(valor.trim().length>2)
						{
							validado= !validado; //tiene que tener almenos 3 caracteres
						}
					break;

					case "precio":
						if(!isNaN(valor))
						{
							if(valor>0){
								validado= !validado; // sies numero
							}
						}
					break;

					case "number":
						if(!isNaN(valor))
						{
							if(valor>=0){
								validado= !validado; // sies numero
							}
						}						
					break;

					case "select":
						if((texto.indexOf("NO DEFINIDO") == -1) && (texto.indexOf("No definido") == -1) )
						{
							validado= !validado; // ES NODEFINIDO
						}
					break;

					case "hidden":
						if(!isNaN(valor))
						{
							validado= !validado; // es numero
						}
					break;

					case "rfc":
				 		var rfc_exp=/^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))((-)?([A-Z\d]{3}))?$/;	
				 		if(rfc_exp.test(valor)){
				 			validado=!validado;
				 		}
				 		
					break;

					case "radio": // VALIDA RADIO .   nota : solo funciona con un grupo de input Radios en el form
						var form=input.closest("form"); 
						var checkeds=0;
						var inputsradio=0;
						$("#"+form.attr('id')+" input:radio").each(function(){
							if($(this).is( ":checked" )){ // si es checked
								checkeds++;
							}
							inputsradio++;
						});
						if(checkeds>=1){ // SI TIENE UNO CHECKED entonces es true
							validado= !validado; 
						}
					break;


					default:
					break;
				} 
 

					return validado;
				
			}else
			{ // si está vacio devuelve false
				validado;
			}
		}else
		{
			return true;
		}
	}


	function SendAjax(form_element,request,function_after){
			var $form = $(".input-"+form_element);
			var validado=true;
			$form.each(function(){
				var input = $(this);
				input.parent().removeClass("error");
				if(!validarTipo(input)  ){
					if(input.attr("error")){
						ShowMensaje(input.attr("error"));
					}
					input.focus();
					input.parent().toggleClass("error");
					validado=false;
					 return false;
				}
			});

			if(validado){
				ShowLoading();
				 var postData = 
	                {
	                    'request':request,
	                    'data':getFormData($("#"+form_element))
	                };

				$.post( 
					"api/api.php", postData
					  ).done(function( data ) {
					  	try {
					  		var datos=JSON.parse(data);
						  	if(datos['success']==true){
						  		ShowMensaje(datos['message']);
						  		console.log("SEND AJAX correctamente: "+request);
						  		$("#"+form_element)[0].reset();
						  		function_after();
						  	}else{
						  		ShowMensaje(datos['message']);
						    	console.log( "error al  SEND AJAX 2: "+datos['message'] );
						  	}	
					  	}catch(e){
					    	console.log( "error al SEND AJAX 3: "+data);

					  	}
			  	
				  	
				 }).fail(function( err) {

					   var keys = "";
					   for(var key in err){
					      keys+="|"+key;
					   }
					
					    console.log( "error al SEND AJAX 1: "+keys );
					    console.log( "error al SEND AJAX 1: "+err.responseText );
					    console.log( err.responseText );
					    console.log( err.getAllResponseHeaders() );
   						console.log( err.getResponseHeader("Content-Type") );
   						console.log( err.statusText );

   						 console.log( err.status );
   						 console.log( err.error );

					  })
					  .always(function() {
					    //alert( "finished" );
					    HideLoading();
				});
			}	
	}



	function GetAjax(data_array,request,result){
			var validado=true;
			if(validado){
					ShowLoading();
				 var postData = 
	                {
	                    'request':request,
	                    'data':data_array
	                };

				 $.post( 
					"api/api.php", postData
					  ).done(function( data ) {
					  	try {
					  		var datos=JSON.parse(data);
						  	if(datos['success']==true){
						  		console.log( "GetAjax correctamente "+request);
						  		result(datos['data']);
						  	}else{
						  		console.log( "error al  getAjax 2: "+request+" "+datos['message'] );
						  		result(datos['data']);
						  	}	
					  	}catch(e){
					    	console.log( "error:"+e+" | ERROR al getAjax 3: "+request+" "+data);
					    	result([]);
					  	}
				 }).fail(function() {
					    console.log("error al getAjax  1 "+request+" ");
					    result([]);
					  })
					  .always(function() {
					    HideLoading();
				});
				
				return result;
			}	
	}


	function RefreshComboBox(id_select,arrayData,keyArray_value,keyArray_option){
		var html_combobox="";
		if(arrayData.length==0 || arrayData==null || arrayData===undefined){
			html_combobox="<option value=''>Sin Registros</option>";
			$("#"+id_select).empty().append(html_combobox);

		}else{
			html_combobox="<option value=''>Selecciona una opción</option>";
			regiones=arrayData;
			for (var i = 0; i < arrayData.length; i++) {
	            html_combobox+='	<option  value="'+arrayData[i][keyArray_value]+'"  >'+arrayData[i][keyArray_option]+'</option>'; 
			}		
			$("#"+id_select).empty().append(html_combobox);
		}
	}
