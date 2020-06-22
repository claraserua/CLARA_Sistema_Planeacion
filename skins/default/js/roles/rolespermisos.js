
$(document).ready(function(){

	$(window).load(function() {
		
      buscar();

	});
	    


$('#search_go-button-rolespermisos').click(function(){
	q = $('#searchbar').val();
	urltag = "&p="+gup('p')+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+q;
	window.location.hash = urltag;
    buscar();
			});

  });
  
  var filter= Array();
  
  
  
   
  function filtrar(cat){
   
   	
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
  
   /*$.blockUI({ css: { backgroundColor: 'transparent', color: '#EC5C00', border:"null" },
                 message: '<img src="skins/admin/images/ajax-loader.gif" /><br><h3> Buscando...</h3>'
                 }); */
  
  
  $('div.table').block({ css: { backgroundColor: 'transparent', color: '#EC5C00', border:"null" },
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Buscando...</h3>' });
				 
				 
  
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
	
   var rol= gup('Rol');
   var tipo= gup('Tipo');
	
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=roles/permisosrol&method=Buscar&Rol="+rol+"&Tipo="+tipo+""+urltag,  
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
  
  
  
  
  function permitirPermisos(){
  var generar=false;
  
  var listapermisos = new Array() 
  var cont=0;
  
   var permisos ="";
   var rol= gup('Rol');
   
   if(document.form.checkboxall.checked==1)
{
 for (i=0;i<document.form.elements.length;i++)
 { 
      if(document.form.elements[i].type == "checkbox")
	  { 
         if(document.form.elements[i].checked==1)
		 {
		   listapermisos[cont]=document.form.elements[i].value; 
		   cont+=1;
		 // alert(document.form.elements[i].value);
		 generar=true;
		 } 
	  }
  }
}
else if(document.form.checkboxall.checked==0)
{
 listapermisos[cont]=document.form.checkboxall.value; 
for (i=0;i<document.form.elements.length;i++)
 { 
      if(document.form.elements[i].type == "checkbox")
	  { 
         if(document.form.elements[i].checked==1)
		 {
		 cont+=1;
		 
		 listapermisos[cont]=document.form.elements[i].value; 
		//alert(document.form.elements[i].value);
		 generar=true;
		 
		 } 
	  }
  }

}
   

for(j=1;j<=listapermisos.length-1;j++)
{
//alert(document.getElementById('labelNRC'+listacursos[j]));
if(j==1){
permisos+=listapermisos[j];
permisos+="^";
//alert(id);
}
else{
permisos+=listapermisos[j];
permisos+="^";
//alert(idcurso);
}
}
   
if(generar==true){
	
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=roles/permisosrol&method=permitirPermisos&Rol="+rol+"&permisos="+permisos,  
    success: function(msg){  
	
	
	        buscar();
			
			    $('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Los permisos han sido permitidos"); 
			

               } 
   
           });
		   }else{
	 $('#titlemodal').html('¡Alerta!');
	 $('#bodymodal').html('Debe elegir al menos un permiso a modificar');
	 $("#cancelarmodal").hide();
	 $("#aceptarmodal").attr("data-dismiss", "modal");
     $('#myModal').modal('show');  	
	}
	
  }
  
  
  
    function restringirPermisos(){
  var generar=false;
  
  var listapermisos = new Array() 
  var cont=0;
  
   var permisos ="";
   var rol= gup('Rol');
   
   if(document.form.checkboxall.checked==1)
{
 for (i=0;i<document.form.elements.length;i++)
 { 
      if(document.form.elements[i].type == "checkbox")
	  { 
         if(document.form.elements[i].checked==1)
		 {
		   listapermisos[cont]=document.form.elements[i].value; 
		   cont+=1;
		 // alert(document.form.elements[i].value);
		 generar=true;
		 } 
	  }
  }
}
else if(document.form.checkboxall.checked==0)
{
 listapermisos[cont]=document.form.checkboxall.value; 
for (i=0;i<document.form.elements.length;i++)
 { 
      if(document.form.elements[i].type == "checkbox")
	  { 
         if(document.form.elements[i].checked==1)
		 {
		 cont+=1;
		 
		 listapermisos[cont]=document.form.elements[i].value; 
		//alert(document.form.elements[i].value);
		 generar=true;
		 
		 } 
	  }
  }

}
   

for(j=1;j<=listapermisos.length-1;j++)
{
//alert(document.getElementById('labelNRC'+listacursos[j]));
if(j==1){
permisos+=listapermisos[j];
permisos+="^";
//alert(id);
}
else{
permisos+=listapermisos[j];
permisos+="^";
//alert(idcurso);
}
}
   
if(generar==true){
	
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=roles/permisosrol&method=restringirPermisos&Rol="+rol+"&permisos="+permisos,  
    success: function(msg){  
	
	

	        buscar();
			
			    $('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Los permisos han sido restringidos"); 
			

               } 
   
           });
		   }else{
	 $('#titlemodal').html('¡Alerta!');
	 $('#bodymodal').html('Debe elegir al menos un permiso a modificar');
	 $("#cancelarmodal").hide();
	 $("#aceptarmodal").attr("data-dismiss", "modal");
     $('#myModal').modal('show');  	
	}
	
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





function seleccionarTodo(){
//alert("Seleccionar Todo");
 if(document.getElementById('checkboxall').checked==1)
   {
   
   for (i=0;i<document.form.elements.length;i++){ 
      if(document.form.elements[i].type == "checkbox"){ 
         document.form.elements[i].checked=1 
		 }
		 }
   }
    else{
	
	for (i=0;i<document.form.elements.length;i++) 
      if(document.form.elements[i].type == "checkbox") 
         document.form.elements[i].checked=0 
	}
}




function EliminarRol(id,confirm){
      
	 if(!confirm){
	 $('#titlemodal').html('Eliminar Rol');
	 $('#bodymodal').html('¿Esta seguro de eliminar el rol:<strong> '+id+'</strong>?');
	  $("#aceptarmodal").attr("onClick", "javascript:EliminarRol('"+id+"',true);return false;")
	 
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
    data: "execute=rolesadmin&method=Eliminar&id="+id,  
    success: function(msg){  
	
    	// alert(msg);
  
     // $('div.table').unblock();
	  
	  //$.unblockUI();
	  
	  $('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha eliminado el rol"); 
      
	  
               } 
   
           });
		
	 }
	}
