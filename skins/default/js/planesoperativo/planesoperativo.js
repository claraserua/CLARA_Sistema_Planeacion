

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
    $("#bodyAlerta").html("Se ha guardado el plan operativo"); 
    break;
    case '2':
    $("#bodyAlerta").html("Se ha enviado el plan operativo para su revisión"); 
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
	    


  });
  
  $(document).on("click", ".operativoLoading", function () {
    var modal = '<div class="modal fade" id="operativoLoadingModal" role="dialog">'
                 + '<div class="modal-dialog" role="document">'
                  + '<!-- Modal content-->'
                   + '<div class="modal-content">'
                    + ' <div class="modal-body">jaaaai'
                     + '</div>'
                    +'</div>'
                  +'</div>'
                +'</div>';
          //$('body').append(modal);
          //$("#operativoLoadingModal").modal();
var modal2 = '<!-- COVER SCREEN -->'
            +'<div id="coverScreen" style = "width:100%;height:100%; position:fixed;top:0;bottom:0; left:0;right:0;background-color: rgba(0,0,0,0.4); z-index:10500;text-align:center;">'
              +'<table width="100%" height="100%">'
              + '<tr><td align="center" valign="middle"><img src="skins/default/images/spinner-md.gif" alt="" /><div style="color:#a5ceef;">Espere un momento por favor...</div></td></tr>'
              +'</table>' 
            +'</div>';
            $('body').append(modal2);
    });

  function buscarPE(){
  		
	q = $('#searchbar').val();
	urltag = "&p="+gup('p')+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+q;
	window.location.hash = urltag;
    buscarPlanesE();
	
  }
 
 
  function buscarPlanes(){
  		
	q = $('#searchbarpo').val();
	urltag = "&p="+gup('p')+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+q;
	
    if(gup('filter')){
	urltag += "&filter="+gup('filter');	
	}
	window.location.hash = urltag;
    buscar();
	
  }
 
     
  function filtrar(cat){
  

    var q = $('#searchbarpo').val();
    
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
  
  
  
  function showLimitPage2(s,id){

  urltag = "&p="+gup('p')+"&s="+s+"&sort="+gup('sort')+"&q="+gup('q');
  if(gup('filter')!=" "){

	urltag += "&filter="+gup('filter');
        }
  
   window.location.hash = urltag;	
   buscarPlanesE();
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
    data: "execute=operativo&method=Buscar"+urltag,  
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
	  //popover
	$('[rel="popover"],[data-rel="popover"]').popover();
 
               } 
   
           });
	
  }
  
  
  
  
  
  function buscarPlanesE(){
  
   
   $('div.tableModal').block({ css: { backgroundColor: 'transparent', color: '#EC5C00', border:"null" },
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Buscando...</h3>' });
  
  var fil="";
  var q ="";
  
    
	q = $('#searchbarpe').val();

     if(q==null){
	 	q="";
	 }	

		
  var s = parseInt(gup('s'));
  
  urltag = "&p="+gup('p')+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+q;
  
  /*if(filter.length>0){
  	fil = filter.join(";");
	
	urltag += "&filter="+fil;
        }*/
   	
   window.location.hash = urltag;
	
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=operativo&method=BuscarPlanesEstrategicos"+urltag,  
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


	url = window.location.toString();
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



function AsignarPlanEstrategico(confirm){
      
	 if(!confirm){
	// $('#titlemodal').html('Eliminar Plan Estrategico');
	 //$('#bodymodal').html('¿Esta seguro de eliminar el plan');
	 $("#aceptarmodalpe").attr("onClick", "javascript:RedirectPlanEstrategico();return false;")
	 
	  
     $('#myModalplanese').modal('show');
	setTimeout("buscarPlanesE()",900);
	 }else{
	 $('#myModalplanese').modal('hide');
	 
	 
	 }
}


function ImprimirPlan(id,idestretegico){
	    var idplan = id;
	    var href = "?execute=planesoperativo/printplan&IDPlan="+idplan+"&IDPlanE="+idestretegico;
		var caracteristicas = "height=600,width=830,scrollTo,resizable=1,scrollbars=1,location=0";
      	nueva=window.open(href, 'Popup', caracteristicas);
      	
      	nueva.document.body.innerHTML = '<div align="center" style="margin-top:150px; font-family:Arial, Helvetica, sans-serif;"><img src="http://redanahuac.mx/app/serviciosocial/skins/default/images/spinner-md.gif"/><br /><br /><span>Exportando a PDF espere por favor...</span></div>';
      	
      	return false;
}




function ImprimirPlanHtml(id,idestretegico){
	    var idplan = id;
	    //var href = "?execute=planesoperativo/printplanhtm&IDPlan="+idplan+"&IDPlanE="+idestretegico;
	    
		var caracteristicas = "height=600,width=830,scrollTo,resizable=1,scrollbars=1,location=0";
      	var myWindow=window.open('', 'Popup', caracteristicas);
      	
      	//var myWindow=window.open('','','width=200,height=100');
      	
      	myWindow.document.body.innerHTML = '<div align="center" style="margin-top:150px; font-family:Arial, Helvetica, sans-serif;"><img src="http://redanahuac.mx/app/serviciosocial/skins/default/images/spinner-md.gif"/><br /><br /><span>Generando Vista Previa espere por favor...</span></div>';
      	
      	
      	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=planesoperativo/printplanhtm&IDPlan="+idplan+"&IDPlanE="+idestretegico,  
    success: function(msg){  
	
    myWindow.document.write(msg);
    myWindow.document.close(); 
    myWindow.focus();
    myWindow.print();
    //myWindow.close(); 
	  
               } 
   
           });
  
      	return false;
}


function ExportarExcel(id,idestretegico){
	    var idplan = id;
	    //var href = "?planesoperativo/exportexcel&IDPlan="+idplan+"&IDPlanE="+idestretegico;
	    
	    //var url = "http://13.84.158.61/app/planeacion/?execute=planesoperativo/exportexcel&IDPlan="+idplan+"&IDPlanE="+idestretegico;
	  
	  
	   // var url = "https://redanahuac.mx/app/planeacion/controllers/planesoperativo/exportexcelV2.class.php?&IDPlan="+idplan+"&IDPlanE="+idestretegico;
     
      var url = "https://redanahuac.mx/app/planeacion/controllers/planesoperativo/exportexcel.class.php?&IDPlan="+idplan+"&IDPlanE="+idestretegico;
     //var url = "https://test.redanahuac.mx/app/planeacion/controllers/planesoperativo/exportexcel.class.php?&IDPlan="+idplan+"&IDPlanE="+idestretegico;
		
		
		// var url = "http://13.65.208.28/app/planeacion/controllers/planesoperativo/exportexcel.class.php?&IDPlan="+idplan+"&IDPlanE="+idestretegico;
		 
		  //var url = "http://52.171.142.236/app/planeacion/controllers/planesoperativo/exportexcel.class.php?&IDPlan="+idplan+"&IDPlanE="+idestretegico;
		 
		 
        
		var myWindow = window.open(url,'_blank');
		//window.parent.opener.focus();
		myWindow.opener.document.focus();
		
		//var caracteristicas = "height=300,width=830,scrollTo,resizable=1,scrollbars=1,location=0";
      	//var myWindow=window.open(url, 'Popup', caracteristicas);
		

      	
      	//var myWindow=window.open('','','width=200,height=100');
      	
      	 //	myWindow.document.write('html to write...');
      	
      //	myWindow.document.body.innerHTML = '<div align="center" style="margin-top:200px; font-family:Arial, Helvetica, sans-serif;"><img src="http://redanahuac.mx/app/serviciosocial/skins/default/images/spinner-md.gif"/><br /><br /><span>Generando Excel espere por favor...</span></div>';
      	
		//myWindow.focus();
		//alert("entra");
		
		
		
		
		
		/*$(myWindow.popup).onload = function()
        {
                alert("Popup has loaded a page");
        };*/
		
		
      //	myWindow.focus();
      	
      	//setTimeout(function(){myWindow.document.location.href = "http://redanahuac.mx/app/planeacion/?execute=planesoperativo/exportexcel&IDPlan="+idplan+"&IDPlanE="+idestretegico;} , 2000); 
      	
      	
/*
     $(myWindow.document).ready(function() {
         
      myWindow.document.location.href = "http://redanahuac.mx/app/planeacion/?execute=planesoperativo/exportexcel&IDPlan="+idplan+"&IDPlanE="+idestretegico; 
   
});
      */	
      	
      	
      	//myWindow.close();
      	
      	/*$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=planesoperativo/exportexcel&IDPlan="+idplan+"&IDPlanE="+idestretegico,  
    success: function(msg){  
	
    //myWindow.document.write(msg);
    //myWindow.document.close(); 
    myWindow.focus();
        //myWindow.print();
        //myWindow.close(); 
	  
               } 
   
           });*/
      	
      	
      	
      	
      //	setTimeout(function(){ /*myWindow.close()*/ }, 100000);
      //	setTimeout("",3000);
      	
      	//print(nueva);
      	
      	
      	
      	return false;
}



function RedirectPlanEstrategico(){
	
  var valstring =  $("input:radio[name=rbtplane]:checked").val();	
  var nstring = valstring.split("|");
  var idplane = nstring[0];
  var idjerarquia = nstring[1];
  
    if(idplane!=null){
   window.location.href = '?execute=planesoperativo/addplano&method=default&Menu=F2&SubMenu=SF21&IDPlanEstrategico='+idplane+'&IDJerarquia='+idjerarquia;
   	
    }else{
		alert("Debe seleccionar un Plan Estrategico");
	}
}


function EliminarPlanOperativo(id,confirm){
      
	  $("#alerta").hide();
	  
	 if(!confirm){
	 $('#titlemodal').html('Eliminar Plan Operativo');
	 $('#bodymodal').html('¿Esta seguro de eliminar el plan? Se eliminaran todos sus objetivos');
	  $("#aceptarmodal").attr("onClick", "javascript:EliminarPlanOperativo('"+id+"',true);return false;")
	 
     $('#myModal').modal('show');
	 }else{
	 $('#myModal').modal('hide');
	 
	$('div.table').block({ css: { backgroundColor: 'transparent', color: '#EC5C00', border:"null" },
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Buscando...</h3>' });
				 
				 
	 $.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=operativo&method=Eliminar&id="+id,  
    success: function(msg){  
	
    	// alert(msg);
  
     // $('div.table').unblock();
	  
	  //$.unblockUI();
	  buscar();
	  $('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha eliminado el plan operativo"); 
      
	  
               } 
   
           });
		
	 }
}



function ArchivarPlanOperativo(id,confirm){
      
	  $("#alerta").hide();
	  
	 if(!confirm){
	 $('#titlemodal').html('Archivar Plan Operativo');
	 $('#bodymodal').html('¿Esta seguro de archivar el plan? Se colocara en historicos');
	  $("#aceptarmodal").attr("onClick", "javascript:ArchivarPlanOperativo('"+id+"',true);return false;")
	 
     $('#myModal').modal('show');
	 }else{
	 $('#myModal').modal('hide');
	 
	$('div.table').block({ css: { backgroundColor: 'transparent', color: '#EC5C00', border:"null" },
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Buscando...</h3>' });
				 
				 
	 $.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=operativo&method=Archivar&id="+id,  
    success: function(msg){  
	
    	// alert(msg);
  
     // $('div.table').unblock();
	  
	  //$.unblockUI();
	  buscar();
	  $('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha ARCHIVADO el plan operativo"); 
      
	  
               } 
   
           });
		
	 }
}


