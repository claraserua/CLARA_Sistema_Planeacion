
$(function(){


$("tr.data").mouseover(function() {
    $(this).css('background-color', '#e8e8ee');
}).mouseout(function() {
    $(this).css('background-color', 'transparent');
});


$(".various").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});




// ----- FUNCION IMAGE PREVIEW ARTICULOS--//
	  $('#btncancelimage').click(function(){
	  $('#thumbailarticulo').hide();
	  $('#imagearticulo').show();
	  $(this).hide();
      });
      // ----- END FUNCION IMAGE PREVIEW ARTICULOS--//
				
				
$('#frmusuarios').iframePostForm
	({
		json : false,
		post : function ()
		{
			var message;
			
						
			if ($('#txtusuario').val().length)
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
					.html('Por favor ingresa el usuario')
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
			
			
		//alert(response);
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

var eliminar = confirm("¿Esta seguro de eliminar este usuario?");
if(eliminar){
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
    }
  }//end function*/
  
  
  function redireccionar(){
  	
	window.location.href = document.URL;
  }