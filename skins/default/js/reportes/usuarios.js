

  

  
  function generarReporte(){
  	
  	var categorias = new Array();
    
	  $("input[@name='niveles[]']:checked").each(function() {
            categorias.push($(this).val());
        });
      
    if(categorias.length>0){
  	fil = categorias.join(";");
    }
    
   // alert("ATENCION: Esta operacion puede tardar demasiado, no cierre el navegador.");
  	
  	buscar(fil);
  	
  }
  
  
 
  
  function buscar(fil){
    
    $('div.box-content').html('<div style="height:190px;"></div>');
    
      $('#danos').hide();
    
   $('div.box-content').block({ css: { backgroundColor: 'transparent', color: '#EC5C00', border:"null" },
                 message: '<img src="skins/default/images/245.GIF" /><br><h3> Generando Reporte. No cierre el navegador...</h3>' });
    
    
    var nodos = fil;
    
     var anos =  $( "#anos" ).val();
	
	$.ajax({ 
    type: "POST",  
    url: "?execute=planesoperativo/reportes/usuarios&method=Reporte&nodos="+nodos+"&anos="+anos,    
    success: function(msg){  
    

    
    $('div.box-content').html(msg);
    
      $("#descargarE").attr("href", "?execute=planesoperativo/reportes/descargar_usuarios&nodos="+nodos+"&anos="+anos);
    
    $('#descargarE').show();
    
	
     $('div.box-content').unblock();	  
 
               } 
   
           });
	
  }
  
  
  
  function redireccionar(){
  	
	window.location.href = document.URL;
  }
  
  
  function WindowOpen(id){
	    var href = "index.php?pag=popup&id="+id;
		var caracteristicas = "height=600,width=830,scrollTo,resizable=1,scrollbars=1,location=0";
      	nueva=window.open(href, 'Popup', caracteristicas);
      	return false;
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

function getURL(){


	url = window.location.toString(); ;
    param = url.split('#');
    parametros = param[1].split('&');
  
    urltag = "&"+parametros[1]+"&"+parametros[2]+"&"+parametros[3]+"&q="+$('#searchbar').val();	
    window.location.hash = urltag;
	
}


function deseleccionar_todo(){
   for (i=0;i<document.f1.elements.length;i++)
      if(document.f1.elements[i].type == "checkbox")
         document.f1.elements[i].checked=0
} 


function seleccionarTodo(){
    
	 if(document.getElementById('checkboxall').checked==1)
	   {
	   
	   for (i=0;i<document.forms.namedItem("frmaddusuarios").elements.length;i++){ 
	      if(document.forms.namedItem("frmaddusuarios").elements[i].type == "checkbox"){ 
	         document.forms.namedItem("frmaddusuarios").elements[i].checked=1 
			 }
			 }
	   }
	    else{
		
		for (i=0;i<document.forms.namedItem("frmaddusuarios").elements.length;i++) 
	      if(document.forms.namedItem("frmaddusuarios").elements[i].type == "checkbox") 
	         document.forms.namedItem("frmaddusuarios").elements[i].checked=0 
		}
	}




