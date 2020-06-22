
$(document).ready(function(){

	$(window).load(function() {
	
      buscar();

	});
	    


$('#search_go-button-usuarios').click(function(){
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
		
		case "VID":
		if($("#cat-vid").is(':checked') ){
		filter.push("VID");
		}else{
		filter.splice(filter.indexOf("VID"), 1);
		}
		break;
		
		case "IMG":
		if($("#cat-img").is(':checked') ){
		$("#cat-img-icn").attr('checked', true);
		$("#cat-img-btn").attr('checked', true);
		$("#cat-img-ftg").attr('checked', true);
		$("#cat-img-bgd").attr('checked', true);
		$("#cat-img-ilu").attr('checked', true);
		$("#cat-img-ltp").attr('checked', true);
		
		filter.push("ICN");
		filter.push("BTN");
		filter.push("FTG");
		filter.push("BGD");
		filter.push("ILU");
		filter.push("LTP");
		
	
		}else{
	
		$("#cat-img-icn").attr('checked', false);
		$("#cat-img-btn").attr('checked', false);
		$("#cat-img-ftg").attr('checked', false);
		$("#cat-img-bgd").attr('checked', false);
		$("#cat-img-ilu").attr('checked', false);
		$("#cat-img-ltp").attr('checked', false);
		
		filter.splice(filter.indexOf("ICN"), 1);
		filter.splice(filter.indexOf("BTN"), 1);
		filter.splice(filter.indexOf("FTG"), 1);
		filter.splice(filter.indexOf("BGD"), 1);
		filter.splice(filter.indexOf("ILU"), 1);
		filter.splice(filter.indexOf("LTP"), 1);
		
			
		}
		
		break;
		
		
		
		case "DOC":
		if($("#cat-doc").is(':checked') ){
		$("#cat-doc-pdf").attr('checked', true);
		$("#cat-doc-wrd").attr('checked', true);
		$("#cat-doc-pwp").attr('checked', true);
		$("#cat-doc-ebk").attr('checked', true);
		
		filter.push("DOC");
		filter.push("PDF");
		filter.push("WRD");
		filter.push("PWP");
		filter.push("EBO");
		
	
		}else{
		
		$("#cat-doc-pdf").attr('checked', false);
		$("#cat-doc-wrd").attr('checked', false);
		$("#cat-doc-pwp").attr('checked', false);
		$("#cat-doc-ebk").attr('checked', false);
		
		filter.splice(filter.indexOf("DOC"), 1);
		filter.splice(filter.indexOf("PDF"), 1);
		filter.splice(filter.indexOf("WRD"), 1);
		filter.splice(filter.indexOf("PWP"), 1);
		filter.splice(filter.indexOf("EBO"), 1);
		
			
		}
		
		break;
		
		
		
		
		case "TPL":
		if($("#cat-tpl").is(':checked') ){
		$("#cat-tpl-htm").attr('checked', true);
		$("#cat-tpl-pwp").attr('checked', true);
		$("#cat-tpl-pts").attr('checked', true);
		$("#cat-tpl-wrd").attr('checked', true);
		$("#cat-tpl-oht").attr('checked', true);
		$("#cat-tpl-ofl").attr('checked', true);
		
		filter.push("HTM");
		filter.push("PTS");
		filter.push("TPT");
		filter.push("TWD");
		filter.push("OHT");
		filter.push("OFL");
	
	
		}else{
		
	    $("#cat-tpl-htm").attr('checked', false);
		$("#cat-tpl-pwp").attr('checked', false);
		$("#cat-tpl-pts").attr('checked', false);
		$("#cat-tpl-wrd").attr('checked', false);
		$("#cat-tpl-oht").attr('checked', false);
		$("#cat-tpl-ofl").attr('checked', false);
		
		
		filter.splice(filter.indexOf("HTM"), 1);
		filter.splice(filter.indexOf("PTS"), 1);
		filter.splice(filter.indexOf("TPT"), 1);
		filter.splice(filter.indexOf("TWD"), 1);
		filter.splice(filter.indexOf("OHT"), 1);
		filter.splice(filter.indexOf("OFL"), 1);
			
		}
		
		break;
		
	
		
		
		case "ICN":
			if($("#cat-img-icn").is(':checked') ){
		 filter.push("ICN");
				}else{
	  		filter.splice(filter.indexOf("ICN"), 1);
		}
		break;
		
		
		case "BTN":
			if($("#cat-img-btn").is(':checked') ){
		 filter.push("BTN");
				}else{
	  		filter.splice(filter.indexOf("BTN"), 1);
		}
		break;
		
		
		case "FTG":
			if($("#cat-img-ftg").is(':checked') ){
		 filter.push("FTG");
				}else{
	  		filter.splice(filter.indexOf("FTG"), 1);
		}
		break;
		
		
		case "BGD":
			if($("#cat-img-bgd").is(':checked') ){
		 filter.push("BGD");
				}else{
	  		filter.splice(filter.indexOf("BGD"), 1);
		}
		break;
		
       	case "ILU":
			if($("#cat-img-ilu").is(':checked') ){
		 filter.push("ILU");
				}else{
	  		filter.splice(filter.indexOf("ILU"), 1);
		}
		break;
		
		
		case "LTP":
			if($("#cat-img-ltp").is(':checked') ){
		 filter.push("LTP");
				}else{
	  		filter.splice(filter.indexOf("LTP"), 1);
		}
		break;
		
		
		case "PDF":
			if($("#cat-doc-pdf").is(':checked') ){
		 filter.push("PDF");
				}else{
	  		filter.splice(filter.indexOf("PDF"), 1);
		}
		break;
		
		
		case "WRD":
			if($("#cat-doc-wrd").is(':checked') ){
		 filter.push("WRD");
				}else{
	  		filter.splice(filter.indexOf("WRD"), 1);
		}
		break;
		
		
		case "PWP":
			if($("#cat-doc-pwp").is(':checked') ){
		 filter.push("PWP");
				}else{
	  		filter.splice(filter.indexOf("PWP"), 1);
		}
		break;
		
		
		case "EBO":
			if($("#cat-doc-ebk").is(':checked') ){
		 filter.push("EBO");
				}else{
	  		filter.splice(filter.indexOf("EBO"), 1);
		}
		break;
		
		
		
		case "HTM":
			if($("#cat-tpl-htm").is(':checked') ){
		 filter.push("HTM");
				}else{
	  		filter.splice(filter.indexOf("HTM"), 1);
		}
		break;
		
	
		case "PTS":
			if($("#cat-tpl-pts").is(':checked') ){
		 filter.push("PTS");
				}else{
	  		filter.splice(filter.indexOf("PTS"), 1);
		}
		break;
		
		
		case "TPT":
			if($("#cat-tpl-pwp").is(':checked') ){
		 filter.push("TPT");
				}else{
	  		filter.splice(filter.indexOf("TPT"), 1);
		}
		break;
		
		
		case "TWD":
			if($("#cat-tpl-wrd").is(':checked') ){
		 filter.push("TWD");
				}else{
	  		filter.splice(filter.indexOf("TWD"), 1);
		}
		break;
		
		
		case "OHT":
			if($("#cat-tpl-oht").is(':checked') ){
		 filter.push("OHT");
				}else{
	  		filter.splice(filter.indexOf("OHT"), 1);
		}
		break;
		
		
		case "OFL":
			if($("#cat-tpl-ofl").is(':checked') ){
		 filter.push("OFL");
				}else{
	  		filter.splice(filter.indexOf("OFL"), 1);
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
    data: "pag=search"+urltag,  
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