
$(function(){

// ----- FUNCION IMAGE PREVIEW ARTICULOS--//
	  $('#btncanceltemplate').click(function(){
	  $('#thumbailtemplate').hide();
	  $('#imagetemplate').show();
	  $(this).hide();
      });
      // ----- END FUNCION IMAGE PREVIEW ARTICULOS--//
				
				
$('#frmtemplate').iframePostForm
	({
		json : false,
		post : function ()
		{
			var message;
			
						
			if ($('#txttitulotemplate').val().length)
			{
				//GUARDANDO ARCHIVOS
				$('html, body').animate({scrollTop:0}, 'slow');
                $.blockUI({ css: { backgroundColor: 'transparent', color: '#fff', border:"null" },
                 message: '<img src="skins/admin/images/ajax-loader.gif" /><br><h3> Guardando Plantilla</h3>'
                 }); 
				
				
			}
			
			else
			{
				$('html, body').animate({scrollTop:0}, 10);
				$('#alerta')
					.html('Por favor ingresa el titulo de la plantilla')
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
					.html('La plantilla ha sido guardada correctamente.')
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



function readURLTemplate(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                $('#thumbailtemplate')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(150)
						.show();
                };
				
				$('#btncanceltemplate').show();
				$('#imagetemplate').hide();
				
				
               reader.readAsDataURL(input.files[0]);
            }
        }
		

