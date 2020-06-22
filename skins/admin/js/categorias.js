
$(function(){


$("tr.data").mouseover(function() {
    $(this).css('background-color', '#e8e8ee');
}).mouseout(function() {
    $(this).css('background-color', 'transparent');
});


//function Save CATEGORIA
$("#btn_save_categoria").click(function() 
{

var titulo = $('#txttitulocat').val();
var descripcion = $('#txtdesccat').val();
var activo = $('#disp_cate:checked').val();

if(activo==null){
	activo = "off";
}


//GUARDANDO CATEGORIAS
$('html, body').animate({scrollTop:0}, 'slow');
$.blockUI({ css: { backgroundColor: 'transparent', color: '#fff', border:"null" },
message: '<img src="skins/admin/images/ajax-loader.gif" /><br><h3> Guardando Categoría</h3>'
});


$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=categorias&handle=categorias&action=save&method=saveCategorias&titulo="+titulo+"&descripcion="+descripcion+"&activo="+activo,  
    success: function(msg){  
      
	  $.unblockUI();
   
   $("#alerta").fadeIn();
   $("#alerta").removeClass();
   $("#alerta").addClass("alert_success");
   $("#alerta").html("La categoria ha sido guardada correctamente");
   
   } 
   
  });


});


});



		
//function ELIMINAR ARTICULO		
function EliminarCategoría(id){
	
	//?execute=articulos&handle=articulos&action=get&method=getArticulo&id='.$id.'
var id = id;
//$("#status").html('Loading.....');
var eliminar = confirm("¿Esta seguro de eliminar esta categoria?");
if(eliminar){
$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=categorias&handle=categorias&action=get&method=deleteCategoria&id="+id,  
    success: function(msg){  
      
	  //$.unblockUI();
	
   
   $("#alerta").fadeIn();
   $("#alerta").removeClass();
   $("#alerta").addClass("alert_success");
   $("#alerta").html("La categoria se ha eliminado correctamente");
   
   
	 setTimeout ("redireccionar()", 1000);
   
               } 
   
           });
	 }

  }//end function*/
  
  
  function redireccionar(){
  	
	window.location.href = document.URL;
  }