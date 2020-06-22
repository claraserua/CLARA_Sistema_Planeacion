
$(function(){
// ----- FUNCION IMAGE PREVIEW ARTICULOS--//
	  $('#btncancelimage').click(function(){
	  $('#thumbailarticulo').hide();
	  $('#imagearticulo').show();
	  $(this).hide();
      });
      // ----- END FUNCION IMAGE PREVIEW ARTICULOS--//
				
				
$('#frmprofile').iframePostForm
	({
		json : false,
		post : function ()
		{
			var message;
			
						
			if ($('input[type=file]').val().length)
			{
				//GUARDANDO ARCHIVOS
				$('html, body').animate({scrollTop:0}, 'slow');
                $.blockUI({ css: { backgroundColor: 'transparent', color: '#fff', border:"null" },
                 message: '<img src="skins/admin/images/ajax-loader.gif" /><br><h3> Guardando Usuario</h3>'
                 }); 
				
				
			}
			
			else
			{
				$('html, body').animate({scrollTop:0}, 10);
				$('#alerta')
					.html('Por favor ingrese la Imagen')
					.css({
						color : '#9c0006',
						background : '#ffc7ce',
						border : '2px solid #9c0006'
					})
					.slideDown();
				
				return false;
			}
		},
		complete : function (response)
		{
			
			
		alert(response);
			if (response=="false")
			{
			
				$('html, body').animate({scrollTop:0}, 10);
				$.unblockUI();
				$('#alerta')
					.html('Se ha producido un error al intentar guardar los datos.')
					.css({
						color : '#9c0006',
						background : '#ffc7ce',
						border : '2px solid #9c0006'
					})
					.slideDown();
				
				return false;
			}
			
			else
			{
				$('html, body').animate({scrollTop:0}, 10);
				$.unblockUI();
				$('#alerta')
					.html('El usuario no ha sido guardado correctamente.')
					.removeClass()
					.addClass("alert_success")
					.slideDown();
				return false;
				
			}
		}
	});
				
				
				
/*	//function ELIMINAR ARTICULO		
$("#btn_save_articulo").click(function() 
{ 

var username = $("#username").val();
//$("#status").html('Loading.....');
$.ajax({ 
    type: "POST",  
    url: "save_articulo.php",  
    data: "username="+ username,  
    success: function(msg){  
      
	  $.unblockUI();
   
   $("#alerta").fadeIn();
   $("#alerta").removeClass();
   $("#alerta").addClass("alert_success");
   $("#alerta").html("El articulo ha sido guardado correctamente");
   
   } 
   
  });
  
  });//end function*/
		
			});



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
				
				$('#btncancelimage').show();
				$('#imagearticulo').hide();
				
               reader.readAsDataURL(input.files[0]);
            }
        }
		
		
//function ELIMINAR ARTICULO		
function EliminarUsuario(id){
	
	//?execute=articulos&handle=articulos&action=get&method=getArticulo&id='.$id.'
var id = id;
//$("#status").html('Loading.....');
$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=usuarios&handle=usuarios&action=delete&method=deleteUsuario&id="+id,  
    success: function(msg){  
      
	  //$.unblockUI();
	
   
   $("#alerta").fadeIn();
   $("#alerta").removeClass();
   $("#alerta").addClass("alert_success");
   $("#alerta").html("El usuario se ha eliminado correctamente");
   
   
	 setTimeout ("redireccionar()", 1000);
   
               } 
   
           });
  
  }//end function*/
  
  
  function redireccionar(){
  	
	window.location.href = document.URL;
  }