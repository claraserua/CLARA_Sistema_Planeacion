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
			
						
			if ($('#usuarios').val().length)
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
			
			
	//alert(response);
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
			
			var idplan = gup('IDPlan');
			var jerarquia = gup('IDJerarquia');
								
	window.setTimeout("window.location.href='?execute=planesoperativo/asignaciones&method=null&Menu=F2&SubMenu=SF21&IDPlan="+idplan+"&IDJerarquia="+jerarquia+"#&p=1&s=25&sort=1&q=&alert=trueadduser'",700)
			 
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


// Extender jQuery con un método personalizado:
jQuery.fn.getCheckboxValues = function(){
    var values = [];
    var i = 0;
    this.each(function(){
        // guarda los valores en un array
        values[i++] = this.id;
    });
    // devuelve un array con los checkboxes seleccionados
    return values;
}
  
  
function enviar(){
var arr = $("input:checked").getCheckboxValues();

 if(arr.length==0){
	alert("Debe elegir un usuario");
 }else{
	//alert(arr); // esto muestra un pop-up con los checkboxes seleccionados
	 $('#myModalplanese').modal('hide');
	 $('#usuarios').val(arr);
 }
 }






function BuscarInput(){
	
	q = $('#searchbar').val();
	urltag = "&p="+gup('p')+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+q;
	window.location.hash = urltag;
    buscarUsuarios();
	
}


function AsignarUsuarios(confirm){
      
	  
	$('#results-panel-Modal').html("");
	  
	 if(!confirm){
	// $('#titlemodal').html('Eliminar Plan Estrategico');
	 //$('#bodymodal').html('¿Esta seguro de eliminar el plan');
	 $("#aceptarmodalpe").attr("onClick", "javascript:enviar();return false;") 
     $('#myModalplanese').modal('show');
	setTimeout("buscarUsuarios()",900);
	 }else{
	 $('#myModalplanese').modal('hide');
	 
	 
	 }
}


function gup(name){
	
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp ( regexS );
	var tmpURL = window.location.href;
	var results = regex.exec( tmpURL );
	if( results == null )
		return"";
	else
		return results[1];
}

function showPage(p){

  urltag = "&p="+p+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+gup('q');
  if(gup('filter')!=" "){

	urltag += "&filter="+gup('filter');
        }
 
   window.location.hash = urltag;
   buscarUsuarios();	
  }


function showLimitPage2(s,id){

  urltag = "&p="+gup('p')+"&s="+s+"&sort="+gup('sort')+"&q="+gup('q');
  if(gup('filter')!=" "){

	urltag += "&filter="+gup('filter');
        }
  
   window.location.hash = urltag;	
   buscarUsuarios();	
  }



function buscarUsuarios(){
  
   
   $('div.tableModal').block({ css: { backgroundColor: 'transparent', color: '#EC5C00', border:"null" },
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Buscando...</h3>' });
  
  var fil="";
  var q="";
  
    q = gup('q');
	$('#searchbar').val(q);
	

var s= parseInt(gup('s'));
  
  urltag = "&p="+gup('p')+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+q;
  
  /*if(filter.length>0){
  	fil = filter.join(";");
	
	urltag += "&filter="+fil;
        }*/
   	
   window.location.hash = urltag;
	
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=planesoperativo/asignarusuario&method=Buscar"+urltag,  
    success: function(msg){  
	
	var contenido = msg.split('#%#');

    	// alert(msg);
   $('#paggingheadModal').html(contenido[0]);
   $('#results-panel-Modal').html(contenido[1]);
   $('#barfilterfooterModal').html(contenido[2]);
   $('#results_textModal').html(contenido[3]+" Resultados");
   
      
  /* if(gup('q')==""){
   	strresul = "resultados";
   }else{
   	strresul = 'resultados para <span class="bold_terms">'+gup('q')+'</span>';
   }
  
   $('#results_for').html(strresul);*/
   
   
	switch(s)
{
 case 25:
 $("#page_size_25-panel2").addClass("page_size_25-selected");
  break;
 
 case 50:
 $("#page_size_50-panel2").addClass("page_size_50-selected");
 break;
 
 case 100:
 $("#page_size_100-panel2").addClass("page_size_100-selected");
  break;
 
 case 200:
 $("#page_size_200-panel2").addClass("page_size_200-selected");
  break;

 
 
}
	 
      $('div.tableModal').unblock();	  
 // $.unblockUI();
               } 
   
           });
	
  }

