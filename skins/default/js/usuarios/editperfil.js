$(function(){
// ----- FUNCION IMAGE PREVIEW USUARIOS--//
	  $('#btncancelimage').click(function(){
	  $('#thumbailarticulo').hide();
	  $('#imagearticulo').show();
	  $(this).hide();
      });
      // ----- END FUNCION IMAGE PREVIEW USUARIOS--//
	  
	  
	 //VENTANA MODAL PARA ELIMINAR USUARIO
	  $('#eliminar-usuario').click(function(e){
		e.preventDefault();
		$('#myModalDeleteUser').modal('show');
	});
    //END VENTANA MODAL
	
	//POST FRAME ADD IMAGE USER
	$('#frmaddusuarios').iframePostForm
	({
		json : false,
		post : function ()
		{
			var message;
			
						
			if ($('#nombre').val().length && $('#apellidos').val().length && $('#usuario').val().length && $('#password').val().length )
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
				
				$.unblockUI();
				$('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha guardado el usuario");
				
				
				
				
				window.history.back(-1);
				//  window.location.href = '?execute=operativo&method=default&Menu=F2&SubMenu=SF21#&p=1&s=25&sort=1&q=';
			 
				return false;
				
				
			}
		}
	});
	
		//END POST FRAME ADD IMAGE USER
	
	
	
$('#btnenviaform1').click(function() {

$('#frmaddusuarios').submit();
});

$('#btnenviaform2').click(function() {

$('#frmaddusuarios').submit();
});
	  

});//End function jquery



function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                $('#thumbailarticulo')
                        .attr('src', e.target.result)
                        .width(100)
                        .height(100)
						.show();
                };
				
				$('#editimagen').val('TRUE');
				$('#btncancelimage').show();
				$('#imagearticulo').hide();
				
               reader.readAsDataURL(input.files[0]);
            }
        }


