
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
  
  //  window.location.href = '?execute=planesoperativo/addplano&method=default&Menu=F2&SubMenu=SF21&IDPlanEstrategico='+idplane+'&IDJerarquia='+idjerarquia;
   	
 
  
  function buscar(fil){
  	
  	$('div.box-content').html('<div style="height:190px;"></div>');
  	
  	  $('#danos').hide();
  	
    
   $('div.box-content').block({ css: { backgroundColor: 'transparent', color: '#EC5C00', border:"null" },
                 message: '<img src="skins/default/images/245.GIF" /><br><h3> Generando Reporte. No cierre el navegador...</h3>' });
    
    
    var nodos = fil;
    
  var anos =  $( "#anos" ).val();
    
    $.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=planesoperativo/reportes/reportes&method=Reporte&nodos="+nodos+"&anos="+anos,  
    success: function(msg){  
    
   //  var contenido = msg.split('#%#');
    
    $('div.box-content').html(msg);
    
     $("#descargarE").attr("href", "?execute=planesoperativo/reportes/descargar_excel&nodos="+nodos+"&anos="+anos);
      
      
    
    // <a  href="?execute=planesoperativo/reportes/descargar_excel&method=default&Menu=F2&SubMenu=SF23#&p=1&s=25&sort=1&q=" style="display:none;" id="btnimprimir" onclick="Exportar();" on class="btn btn-large">Descargar Excel</a>
    
    
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

function Exportar(){
	
	
	   
/*	$.ajax({ 
    type: "POST",  
    url: "?execute=planesoperativo/reportes/descargar_excel&method=Descargar",      
    success: function(msg){   
   // alert(msg);
 
               } 
   
           });*/
		
      
}


function Imprimir(){
	   
	    
		var caracteristicas = "height=600,width=830,scrollTo,resizable=1,scrollbars=1,location=0";
      	var myWindow=window.open('', 'Popup', caracteristicas);
      	
      	var contenido = $('.box-content').html();
      	
      	myWindow.document.head.innerHTML = '<style type="text/css">.datagrid table {border-collapse: collapse;text-align: left;width: 100%;} .datagrid {background: #fff none repeat scroll 0 0;border: 1px solid #006699;border-radius: 3px;font: 12px/150% Arial,Helvetica,sans-serif;overflow: hidden;}.datagrid table td, .datagrid table th {padding: 3px 10px;}.datagrid table thead th {background: #006699;border-left: 1px solid #0070a8;color: #ffffff;font-size: 15px;font-weight: bold;}.datagrid table thead th:first-child {border: medium none;}.datagrid table tbody td {border-left: 1px solid #e1eef4;color: #00557f;font-size: 12px;font-weight: normal;}.datagrid table tbody .alt td {background: #e1eef4 none repeat scroll 0 0;color: #00557f;}.datagrid table tbody td:first-child {border-left: medium none;}.datagrid table tbody tr:last-child td {border-bottom: medium none;} .oldtd{background: #E2E2E2;}</style>';
      	
      	myWindow.document.body.innerHTML = contenido;
      	
      	myWindow.print();
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




