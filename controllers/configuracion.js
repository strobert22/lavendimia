$( document ).ready(function() {
	var configs=[];



	$("#btn_config_editar_guardar").click(function(){
			SendAjax(
			"form_config",
			"SetConfig",
			function(){
				GetConfigs();
			});
	});	

	$("#btn_config_editar_cancelar").click(function(){
		if(confirm("¿Estas seguro que deseas salir de la configuracion?")){
			location.href="index.php";
		}
	});	

	function RefreshConfigs(configs_){
		if(configs_.length==0 || configs_==null || configs_===undefined){
			$("#form_config_tasa").val("");
			$("#form_config_enganche").val("");
			$("#form_config_plazo").val("");
			configs=[];
		}else{
			if(!(configs_[0]["tasa"]==null) && !(configs_[0]["tasa"]===undefined) && !(configs_[0]["tasa"]=="")){
				$("#form_config_tasa").val(configs_[0]["tasa"]);
			}

			if(!(configs_[0]["enganche"]==null) && !(configs_[0]["enganche"]===undefined) && !(configs_[0]["enganche"]=="")){
				$("#form_config_enganche").val(configs_[0]["enganche"]);

			}

			if(!(configs_[0]["plazo"]==null) && !(configs_[0]["plazo"]===undefined) && !(configs_[0]["plazo"]=="")){
				$("#form_config_plazo").val(configs_[0]["plazo"]);
			}
		}
	}

	function GetConfigs(){
		GetAjax(
			null,
			"GetConfigs",
			function(response){
				configs=response;
				RefreshConfigs(configs);
			}
		);
	}
	function InitializeConfig(){
		GetConfigs();
	}

	InitializeConfig();
});