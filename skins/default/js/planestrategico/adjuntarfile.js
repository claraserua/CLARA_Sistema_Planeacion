$(function(){
	
	//POST FRAME ADD IMAGE USER
	$('#frmaddusuarios').iframePostForm
	({
		json : false,
		post : function ()
		{
			var message;
			var idplan;
			
						
			if ($('#titulo').val().length)
			{
				//GUARDANDO ARCHIVOS
					
			 $('html, body').animate({scrollTop:0}, 'slow');
              $.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
				
			}else{
				
				$('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-block");
				$("#headAlerta").html("¡Advertencia!");
				$("#bodyAlerta").html("Debes de ingresar todos los campos obligatorios");
				
				
				return false;
			}
			
			
			
			
		},
		complete : function (response)
		{
			
			
	
			if (response.trim()=="false")
			{
			
				$('html, body').animate({scrollTop:0}, 10);
				$.unblockUI();
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-error");
				$("#headAlerta").html("!Error!");
				$("#bodyAlerta").html("Se ha producido un error al guardar los datos, intentelo nuevamente.");
				
				return false;
			}
			
			else
			{
				
			idplan = $('#idplan').val();
				
			window.location.href='?execute=planestrategico/adjuntos&method=default&Menu=F1&SubMenu=SF11&IDPlan='+idplan+'#&p=1&s=25&sort=1&q=';
			
			 
				return false;
				
				
			}
		}
	});
	
		//END POST FRAME ADD IMAGE USER
	
	
	

	  

});//End function jquery






