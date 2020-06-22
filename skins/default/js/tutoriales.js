
$(document).ready(function(){

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



    $.blockUI({ css: { backgroundColor: 'transparent', color: '#0c83ea', border:"null" },
                 message: '<img src="skins/admin/images/ajax-loader.gif" /><br><h3> Buscando...</h3>'
                 }); 
    
	
	$(window).load(function() {
		
		 buscar();

	});
	    





$('#search_go-button-tutoriales').click(function(){

			q = $('#searchbar').val();
	urltag = "&p="+gup('p')+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+q;
	 window.location.hash = urltag;
     buscar();
			 
			
			});
			
		
			
  });
  
  
  var filter= Array();
  
  
  
   
  function filtrar(cat){
  
 if(cat=="all"){
  
  if($("#navigator-cat-any").is(':checked') ){
  	deseleccionar_todo();
	filter= Array();
	buscar();
  }
  
  }else{
 
	$("#navigator-cat-any").attr('checked', false);
	switch(cat){
		
		case "BLA":
		if($("#cat-vid").is(':checked') ){
		filter.push("BLA");
		}else{
		filter.splice(filter.indexOf("BLA"), 1);
		}
		break;
		
		case "TEC":
		if($("#cat-img").is(':checked') ){
		filter.push("TEC");
		}else{
		filter.splice(filter.indexOf("TEC"), 1);			
		}
		
		break;
		
		
		case "EDU":
		if($("#cat-doc").is(':checked') ){
		filter.push("EDU");
		}else{
		filter.splice(filter.indexOf("EDU"), 1);
		}
		break;
		
		
		
		
		case "GAD":
		if($("#cat-tpl").is(':checked') ){
		filter.push("GAD");
		}else{
		filter.splice(filter.indexOf("GAD"), 1);
		}
		
		break;
		

		case "RUA":
			if($("#cat-rua").is(':checked') ){
		 filter.push("RUA");
				}else{
	  		filter.splice(filter.indexOf("RUA"), 1);
		}
		break;
		
		
		
	}
	
	
	urltag = "&p=1&s="+gup('s')+"&sort="+gup('sort')+"&q="+gup('q');
  
  if(filter.length>0){
  	fil = filter.join(";");
	
	urltag += "&filter="+fil;
        }

   window.location.hash = urltag;
	
     buscar();
  }
  
   
   
   	
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
  
  
   function buscar(){
  
   $.blockUI({ css: { backgroundColor: 'transparent', color: '#0c83ea', border:"null" },
                 message: '<img src="skins/admin/images/ajax-loader.gif" /><br><h3> Buscando...</h3>'
                 }); 
  
  var fil="";
  var q="";
  
    q = gup('q');
	$('#searchbar').val(q);
	
	
var s= parseInt(gup('s'));
  
  urltag = "&p="+gup('p')+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+q;
  
  if(filter.length>0){
  	fil = filter.join(";");
	
	urltag += "&filter="+fil;
        }
  
   	
   window.location.hash = urltag;
	
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "pag=searchTutoriales"+urltag,  
    success: function(msg){  
	
	var contenido = msg.split('#%#');

    	 
   $('#barfilterheader').html(contenido[0]);
   $('#results-panel').html(contenido[1]);
   $('#barfilterfooter').html(contenido[2]);
   $('#total_result_count').html(contenido[3]);
   
      
   if(gup('q')==""){
   	strresul = "resultados";
   }else{
   	strresul = 'resultados para <span class="bold_terms">'+gup('q')+'</span>';
   }
  
   $('#results_for').html(strresul);
   
   
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
	 
     	  
  $.unblockUI();
               } 
   
           });
	
  }
  

  
  
  function redireccionar(){
  	
	window.location.href = document.URL;
  }
  
  
  function WindowOpen(){
	    var href = "index.php?pag=popup";
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