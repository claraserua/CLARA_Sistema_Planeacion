		
//function ELIMINAR IMAGEN		
function EliminarImagen(id,dir,img,adjunto){
var eliminar = confirm("¿Esta seguro de eliminar este recurso?");
	//?execute=articulos&handle=articulos&action=get&method=getArticulo&id='.$id.'
if(eliminar){
	

              
$('html, body').animate({scrollTop:0}, 'slow');
                $.blockUI({ css: { backgroundColor: 'transparent', color: '#fff', border:"null" },
                 message: '<img src="skins/admin/images/ajax-loader.gif" /><br><h3> Eliminando Imagen</h3>'
                 }); 


$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=galeria&handle=galeria&action=delete&method=deleteImagen&id="+id+"&dir="+dir+"&img="+img+"&adjunto="+adjunto,  
    success: function(msg){  
      


   
   $("#alerta").fadeIn();
   $("#alerta").removeClass();
   $("#alerta").addClass("alert_success");
   $("#alerta").html("La imagen se ha eliminado correctamente");
   $.unblockUI();
	 setTimeout ("redireccionar()", 1000);
   
               } 
   
           });
  }
  }//end function*/
  
  
  function EliminarVideo(id,dir,img,adjunto){
var eliminar = confirm("¿Esta seguro de eliminar este recurso?");
	//?execute=articulos&handle=articulos&action=get&method=getArticulo&id='.$id.'
if(eliminar){
	
$('html, body').animate({scrollTop:0}, 'slow');
              
	
$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=galeria&handle=galeria&action=delete&method=deleteVideo&id="+id+"&dir="+dir+"&img="+img+"&adjunto="+adjunto,  
    success: function(msg){  
      


//   alert(msg);
   $("#alerta").fadeIn();
   $("#alerta").removeClass();
   $("#alerta").addClass("alert_success");
   $("#alerta").html("El video se ha eliminado correctamente");
   
	 setTimeout ("redireccionar()", 1000);
   
               } 
   
           });
  }
  }//end function*/
  
  
  
  function EliminarDocumento(id,dir,img,adjunto){
var eliminar = confirm("¿Esta seguro de eliminar este recurso?");
	//?execute=articulos&handle=articulos&action=get&method=getArticulo&id='.$id.'
if(eliminar){
	
$('html, body').animate({scrollTop:0}, 'slow');
              
	
$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=galeria&handle=galeria&action=delete&method=deleteDocumento&id="+id+"&dir="+dir+"&img="+img+"&adjunto="+adjunto,  
    success: function(msg){  
      


  // alert(msg);
   $("#alerta").fadeIn();
   $("#alerta").removeClass();
   $("#alerta").addClass("alert_success");
   $("#alerta").html("El documento se ha eliminado correctamente");
   
	 setTimeout ("redireccionar()", 1000);
   
               } 
   
           });
  }
  }//end function*/
  
  
  
  function EliminarTemplate(id,dir,img,adjunto){
var eliminar = confirm("¿Esta seguro de eliminar este recurso?");
	//?execute=articulos&handle=articulos&action=get&method=getArticulo&id='.$id.'
if(eliminar){
	
$('html, body').animate({scrollTop:0}, 'slow');
              
	
$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=galeria&handle=galeria&action=delete&method=deleteTemplate&id="+id+"&dir="+dir+"&img="+img+"&adjunto="+adjunto,  
    success: function(msg){  
      


//   alert(msg);
   $("#alerta").fadeIn();
   $("#alerta").removeClass();
   $("#alerta").addClass("alert_success");
   $("#alerta").html("La plantilla se ha eliminado correctamente");
   
	 setTimeout ("redireccionar()", 1000);
   
               } 
   
           });
  }
  }//end function*/
  
   function WindowOpen(id){
	    var href = "index.php?execute=admin&handle=galeria&action=view&method=popup&id="+id;
		var caracteristicas = "height=600,width=830,scrollTo,resizable=1,scrollbars=1,location=0";
      	nueva=window.open(href, 'Popup', caracteristicas);
      	return false;
}
  
  
  
  function redireccionar(){
  	
	window.location.href = document.URL;
  }