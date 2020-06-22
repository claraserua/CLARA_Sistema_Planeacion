
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
		autoSize	: true,
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
	   $('#inputeditimage').val('on');
	  $(this).hide();
      });
      // ----- END FUNCION IMAGE PREVIEW ARTICULOS--//
				
				
$('#frmarticulos').iframePostForm
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
                 message: '<img src="skins/admin/images/ajax-loader.gif" /><br><h3> Guardando Link</h3>'
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
						}else{
							
							//GUARDANDO ARCHIVOS
				$('html, body').animate({scrollTop:0}, 'slow');
                $.blockUI({ css: { backgroundColor: 'transparent', color: '#fff', border:"null" },
                 message: '<img src="skins/admin/images/ajax-loader.gif" /><br><h3> Guardando Articulo</h3>'
                 }); 
							
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
					.html('El Link ha sido guardado correctamente.')
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
				
				
				
				
				//AUTOCOMPLETE TAGS//
				$("#totag").autocomplete({
					
					//define callback to format results
					source: function(req, add){
					
						//pass request to server
						$.getJSON("tags.php?callback=?", req, function(data) {
							
							//create array for response objects
							var suggestions = [];
							
							//process response
							$.each(data, function(i, val){								
								suggestions.push(val.tag);
							});
							
							//pass array to callback
							add(suggestions);
						});
					},
					
					//define select handler
					select: function(e, ui) {
						
						//create formatted friend
						var friend = ui.item.value,
							span = $("<span>").text(friend),
							a = $("<a>").addClass("remove").attr({
								href: "javascript:",
								title: "Eliminar " + friend
							}).text("x").appendTo(span);
						
						//add friend to friend div
						span.insertBefore("#totag");
					},
					
					//define select handler
					change: function() {
						
						//prevent 'to' field being updated and correct position
						$("#totag").val("").css("top", 2);
					}
				});
				
				//add click handler to friends div
				$("#tags").click(function(){
					
					//focus 'to' field
					$("#totag").focus();
				
				});
				
				//add live handler for clicks on remove links
				$(".remove", document.getElementById("tags")).live("click", function(){
				
					//remove current friend
					$(this).parent().remove();
					
					//correct 'to' field position
					if($("#tags span").length === 0) {
						$("#totag").css("top", 0);
					}				
				});				
			});



function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                $('#thumbailarticulo')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(150)
						.show();
                };
				
				$('#btncancelimage').show();
				$('#imagearticulo').hide();
				
               reader.readAsDataURL(input.files[0]);
            }
        }
		
		
//function ELIMINAR ARTICULO		
function EliminarArticulo(id){
	
	//?execute=articulos&handle=articulos&action=get&method=getArticulo&id='.$id.'
var id = id;
var eliminar = confirm("¿Esta seguro de eliminar este Link?");
if(eliminar){
//$("#status").html('Loading.....');
$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=links&handle=links&action=delete&method=deleteLink&id="+id,  
    success: function(msg){  
      
	  //$.unblockUI();
	
   
   $("#alerta").fadeIn();
   $("#alerta").removeClass();
   $("#alerta").addClass("alert_success");
   $("#alerta").html("El articulo se ha eliminado correctamente");
   
   
 setTimeout ("redireccionar()", 1000);
   
               } 
   
           });
	}
  }//end function*/
  
  
  function redireccionar(){
  	
	window.location.href = document.URL;
  }