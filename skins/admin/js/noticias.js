
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


$( "#from" ).datepicker({
		 changeMonth: true,
         numberOfMonths: 2,
		 dateFormat: 'yy-mm-dd',
		  onClose: function( selectedDate ) {
                $( "#to" ).datepicker( "option", "minDate", selectedDate );
            }
		 
		 });
		 
		  $( "#to" ).datepicker({
            changeMonth: true,
            numberOfMonths: 2,
			dateFormat: 'yy-mm-dd',
            onClose: function( selectedDate ) {
                $( "#from" ).datepicker( "option", "maxDate", selectedDate );
            }
        });

// ----- FUNCION IMAGE PREVIEW ARTICULOS--//
	  $('#btncancelimage').click(function(){
	  $('#thumbailarticulo').hide();
	  $('#imagearticulo').show();
	  $(this).hide();
      });
      // ----- END FUNCION IMAGE PREVIEW ARTICULOS--//
				
				
$('#frmnoticias').iframePostForm
	({
		json : false,
		post : function ()
		{
			var message;
		
			if($('#inputeditimage').val() == 'on'){			
			if ($('input[type=file]').val().length)
			{
				//GUARDANDO ARCHIVOS
				$('html, body').animate({scrollTop:0}, 'slow');
                $.blockUI({ css: { backgroundColor: 'transparent', color: '#fff', border:"null" },
                 message: '<img src="skins/admin/images/ajax-loader.gif" /><br><h3> Guardando Noticia</h3>'
                 }); 
				
				
			}
			
			else
			{
				$('html, body').animate({scrollTop:0}, 10);
				$('#alerta')
					.html('Por favor ingrese la imagen')
					.css({
						color : '#9c0006',
						background : '#ffc7ce',
						border : '2px solid #9c0006'
					})
					.slideDown();
				
				return false;
			}
			}else{
				  //GUARDANDO ARCHIVOS
				$('html, body').animate({scrollTop:0}, 'slow');
                $.blockUI({ css: { backgroundColor: 'transparent', color: '#fff', border:"null" },
                 message: '<img src="skins/admin/images/ajax-loader.gif" /><br><h3> Guardando Noticia</h3>'
                 }); 
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
					.html('La noticia ha sido guardada correctamente.')
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
                        .width(490)
                        .height(170)
						.show();
                };
				
				$('#btncancelimage').show();
				$('#imagearticulo').hide();
				
               reader.readAsDataURL(input.files[0]);
            }
        }
		
		
//function ELIMINAR ARTICULO		
function EliminarNoticia(id){
	
	
var id = id;
var eliminar = confirm("¿Esta seguro de eliminar esta noticia?");
if(eliminar){
//$("#status").html('Loading.....');
$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=noticias&handle=noticias&action=get&method=deleteNoticia&id="+id,  
    success: function(msg){  
      
	  //$.unblockUI();
	
   
   $("#alerta").fadeIn();
   $("#alerta").removeClass();
   $("#alerta").addClass("alert_success");
   $("#alerta").html("La noticia se ha eliminado correctamente");
   
   
	 setTimeout ("redireccionar()", 1000);
   
               } 
   
           });
    }
  }//end function*/
  
  
  function redireccionar(){
  	
	window.location.href = document.URL;
  }