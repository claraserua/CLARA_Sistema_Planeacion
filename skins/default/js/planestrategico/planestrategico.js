



$(document).ready(function(){

  
  if(gup("alert")){
		 //$.growlUI('Plan Operativo Enviado', 'Se ha enviado para su Revisión');
		 
		$("#alerta").fadeIn();
		$("#alerta").removeClass();
        $("#alerta").addClass("alert alert-success");
	    $("#headAlerta").html("¡Correcto!");
			
				
	switch(gup("alert"))
    {
    case '1':
    $("#bodyAlerta").html("Se ha agregado un nuevo plan estrategico"); 
    break;
    case '2':
    $("#bodyAlerta").html("Se ha guardado el plan estrategico"); 
    break;
    
	//default:
    
    }
				
				
	}
  



   if(gup("p")){}else{
   urltag = "&p=1&s=25&sort=1&q=";
   window.location.hash = urltag;
   }

  


	$(window).load(function() {
	
      buscar();

	});
	    


$('#search_go-button-pe').click(function(){
	q = $('#searchbar').val();
	urltag = "&p="+gup('p')+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+q;
	
	if(gup('filter')){
	urltag += "&filter="+gup('filter');	
	}
	
	window.location.hash = urltag;
    buscar();
			});

  });
  
 
   
  function filtrar(cat){
    
	
	 var  q = $('#searchbar').val();
	
     var categorias = new Array();
    
	  $("input[@name='niveles[]']:checked").each(function() {
            categorias.push($(this).val());
        });
	
  			
	urltag = "&p=1&s="+gup('s')+"&sort="+gup('sort')+"&q="+q;
  
    if(categorias.length>0){
  	fil = categorias.join(";");
	
	urltag += "&filter="+fil;
        }

     window.location.hash = urltag;
	
     buscar();		
	
  }
  
  
  function showPage(p){

  urltag = "&p="+p+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+gup('q');
  if(gup('filter')!=" "){

	urltag += "&filter="+gup('filter');
        }
 
   window.location.hash = urltag;
   buscar();	
  }
  
  
  
  
  function showLimitPage(s,id){

  urltag = "&p="+gup('p')+"&s="+s+"&sort="+gup('sort')+"&q="+gup('q');
  if(gup('filter')!=" "){

	urltag += "&filter="+gup('filter');
        }
  
   window.location.hash = urltag;	
   buscar();	
  }
  
  
  function Ordenar(value){
  	

  	
  }
  
   
  function buscar(){
  
  
   $('div.table').block({ css: { backgroundColor: 'transparent', color: '#EC5C00', border:"null" },
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Buscando...</h3>' });
  
  var fil="";
  var q="";
  
    q = gup('q');
	$('#searchbar').val(q);
	

var s= parseInt(gup('s'));
  
  urltag = "&p="+gup('p')+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+q;
  
 
    if(gup('filter')){
		urltag += "&filter="+gup('filter');
	}
 
 
   window.location.hash = urltag;
	
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=principal&method=Buscar"+urltag,  
    success: function(msg){  
	
	var contenido = msg.split('#%#');

    	// alert(msg);
   $('#pagginghead').html(contenido[0]);
   $('#results-panel').html(contenido[1]);
   $('#barfilterfooter').html(contenido[2]);
   $('#results_text').html(contenido[3]+" Resultados");
   
      
  /* if(gup('q')==""){
   	strresul = "resultados";
   }else{
   	strresul = 'resultados para <span class="bold_terms">'+gup('q')+'</span>';
   }
  
   $('#results_for').html(strresul);*/
   
   
	switch(s)
{
 case 25:
 $("#page_size_25-panel").addClass("page_size_25-selected");
  break;
 
 case 50:
 $("#page_size_50-panel").addClass("page_size_50-selected");
 break;
 
 case 100:
 $("#page_size_100-panel").addClass("page_size_100-selected");
  break;
 
 case 200:
 $("#page_size_200-panel").addClass("page_size_200-selected");
  break;

 
 
}
	 
      $('div.table').unblock();	  
 // $.unblockUI();
               } 
   
           });
	
  }
  
  
function ImprimirPlan(id){
	    var idplan = id;
	    var href = "?execute=planestrategico/printplan&IDPlan="+idplan;
		var caracteristicas = "height=600,width=830,scrollTo,resizable=1,scrollbars=1,location=0";
      	nueva=window.open(href, 'Popup', caracteristicas);
      	return false;
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



function EliminarPlanEstrategico(id,confirm){
      
	 if(!confirm){
	 $('#titlemodal').html('Eliminar Plan Estrategico');
	 $('#bodymodal').html('¿Esta seguro de eliminar el plan');
	  $("#aceptarmodal").attr("onClick", "javascript:EliminarPlanEstrategico('"+id+"',true);return false;")
	 
     $('#myModal').modal('show');
	 }else{
	 $('#myModal').modal('hide');
	 
	 /*$.blockUI({ css: { backgroundColor: 'transparent', color: '#fff', border:"null" },
	            overlayCSS: {backgroundColor: '#000'},
                 message: '<img src="skins/admin/images/ajax-loader2.gif" /><br><h3> Espere un momento..</h3>'
                 });*/
	 buscar();
	 $.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=principal&method=Eliminar&id="+id,  
    success: function(msg){  
	
    buscar();
	  
	  $('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha eliminado el plan estrategico"); 
      
	  
               } 
   
           });
		
	 }
}



function ArchivarPlanEstrategico(id,confirm){
      
	 if(!confirm){
	 $('#titlemodal').html('Archivar Plan Estrategico');
	 $('#bodymodal').html('¿Esta seguro de archivar el plan');
	  $("#aceptarmodal").attr("onClick", "javascript:ArchivarPlanEstrategico('"+id+"',true);return false;")
	 
     $('#myModal').modal('show');
	 }else{
	 $('#myModal').modal('hide');
	 
	 /*$.blockUI({ css: { backgroundColor: 'transparent', color: '#fff', border:"null" },
	            overlayCSS: {backgroundColor: '#000'},
                 message: '<img src="skins/admin/images/ajax-loader2.gif" /><br><h3> Espere un momento..</h3>'
                 });*/
	 buscar();
	 $.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=principal&method=Archivar&id="+id,  
    success: function(msg){  
	
    buscar();
	  
	  $('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha archivado el plan estrategico"); 
      
	  
               } 
   
           });
		
	 }
}
