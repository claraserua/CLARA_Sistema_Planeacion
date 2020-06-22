

var arraylineas_objetivos = new Array();
var lineas_objetivos_medios = new Array();
var lineas_objetivos_evidencias = new Array();


$(function(){


   $('[rel="popover"],[data-rel="popover"]').popover();
	
	$('#myTablab a:first').tab('show');
	$('#myTablab a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	});
	
	
	$('#myTab a:first').tab('show');
	$('#myTab a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	});
	
	
	$('#inputField-resumen').bind("blur focus keydown keypress keyup", function(){recountr();});
	$('update_button-resumen').attr('disabled','disabled');
	$("#inputField-resumen").Watermark("Agrega tu comentario ...");

	

});//End function jquery




function recount(id)
{  

$('#update_button-L'+id).removeAttr('disabled').removeClass('inact');
	/*var maxlen=140;
	var current = maxlen-$('#inputField-L'+id).val().length;
	$('#counter-L'+id).html(current);
	
	//|| current==maxlen
	if(current<0)
	{
		$('#counter-L'+id).css('color','#D40D12');
		$('#update_button-L'+id).attr('disabled','disabled').addClass('inact');
	}
	else
		$('#update_button-L'+id).removeAttr('disabled').removeClass('inact');
	
	if(current<10)
		$('#counter-L'+id).css('color','#D40D12');
	
	else if(current<20)
		$('#counter-L'+id).css('color','#5C0002');

	else
		$('#counter-L'+id).css('color','#3a3a3b');*/
	
}


function recountr()
{  
$('#update_button-resumen').removeAttr('disabled').removeClass('inact');
    
/*	var maxlen=140;
	var current = maxlen-$('#inputField-resumen').val().length;
	$('#counter-resumen').html(current);
	
	//|| current==maxlen
	if(current<0)
	{
		$('#counter-resumen').css('color','#D40D12');
		$('#update_button-resumen').attr('disabled','disabled').addClass('inact');
	}
	else
		$('#update_button-resumen').removeAttr('disabled').removeClass('inact');
	
	if(current<10)
		$('#counter-resumen').css('color','#D40D12');
	
	else if(current<20)
		$('#counter-resumen').css('color','#5C0002');

	else
		$('#counter-resumen').css('color','#3a3a3b');*/
	
}


function guardarComentario(id,idobjetivo){
	
	
	id = id.substring(13)
	id = id.split("-");
	var tipo = "R";
	
  	
	if($("#mandatorio-objetivo-"+id[1]+"-"+id[2]).is(':checked')){
		tipo = "M";
	}
	
    var comentario = $("#inputField-"+id[1]+"-"+id[2]).val();
	
	$("#counter-"+id[1]+"-"+id[2]).html('<img src="skins/default/img/spinner-mini.gif" />');
	
		$.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/revisionobjetivos&method=insertarComentario",  
			data: { comentario: comentario, idobjetivo: idobjetivo, tipo:tipo},  
			cache: false,
			success: function(html)
			{
				
				$("#comentarios-"+id[1]+"-"+id[2]).prepend($(html).fadeIn('slow'));
				$("#inputField-"+id[1]+"-"+id[2]).val('');	
				$("#inputField-"+id[1]+"-"+id[2]).focus();
				$("#counter-"+id[1]+"-"+id[2]).html('');
				//$("#stexpand").oembed(html);
  			}
 		});
	return false;

}



$('.stdelete').live("click",function() 
{
var ID = $(this).attr("id");

if(confirm("¿Estás seguro que deseas  borrar el comentario?"))
{
	
	$("#stbody"+ID).prepend('<img src="skins/default/img/spinner-mini.gif" />');
	$.ajax({
		type: "POST",
		url: "index.php?execute=planesoperativo/revisionobjetivos&method=eliminarComentario",  
		data: {idcomentario: ID},  
		cache: false,
		success: function(html){
			
		$("#stbody"+ID).slideUp();
		}
 	});
}
return false;
});



$('.stdeleter').live("click",function() 
{
var ID = $(this).attr("id");
var idcomentario =  ID.substring(1);
    

if(confirm("¿Estás seguro que deseas  borrar el comentario?"))
{
	
	$("#stbody"+ID).prepend('<img src="skins/default/img/spinner-mini.gif" />');
	$.ajax({
		type: "POST",
		url: "index.php?execute=planesoperativo/revisionobjetivos&method=eliminarComentarioResumen",  
		data: {idcomentario: idcomentario},  
		cache: false,
		success: function(html){
			
			
			
		$("#stbody"+ID).slideUp();
		}
 	});
}
return false;
});




function guardarComentarioResumen(){

	var idplan = gup('IDPlan');
    var comentario = $("#inputField-resumen").val();
	var tipo = "R";
	
 
	if($("#mandatorio-resumen").is(':checked')){
		tipo = "M";
	}
	
		
	$("#counter-resumen").html('<img src="skins/default/img/spinner-mini.gif" />');
	
		$.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/revisionobjetivos&method=insertarComentarioResumen",  
			data: { comentario: comentario, idplan: idplan, tipo:tipo},  
			cache: false,
			success: function(html)
			{
				
				$("#comentarios-resumen").prepend($(html).fadeIn('slow'));
				$("#inputField-resumen").val('');	
				$("#inputField-resumen").focus();
				$("#counter-resumen").html('');
				//$("#stexpand").oembed(updateval);
  			}
 		});
	return false;

	
}

	

	function EnviarRevision(confirm){
	
	
	if(!confirm){
	 $('#titlemodal').html('Enviar plan operativo revisado');
	 $('#bodymodal').html('¿Está seguro de enviar el plan revisado? <br>');
	  $("#aceptarmodal").attr("onClick", "javascript:EnviarRevision(true);return false;")
	 
     $('#myModal').modal('show');
	 }else{
	 $('#myModal').modal('hide');
	 
	 
	var IDPlan =  gup('IDPlan');
	var IDPlanE = gup('IDPlanE');
	 	
       $.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
	
	 $.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/revisionobjetivos&method=EnviarRevision",  
			data: { IDPlan: IDPlan,IDPlanE:IDPlanE},  
			cache: false,
			success: function(html)
			{
			
				setTimeout("window.location.href ='?execute=operativo&method=default&Menu=F2&SubMenu=SF21#&p=1&s=25&sort=1&q=&alert=2'",0);
       
				
  			}
 		});
	return false;
	 
	 
		
	 }
		
	}
	
	
	
	
	function PasaraSeguimiento(confirm){
	
	var idplano = gup('IDPlan');
	
	var idplane = gup('IDPlanE');
	
	
	if(!confirm){
	 $('#titlemodal').html('Finalizar plan operativo');
	 $('#bodymodal').html('¿Está seguro de finalizar el plan?  El plan pasará a seguimiento.<br>');
	 $("#aceptarmodal").attr("onClick", "javascript:PasaraSeguimiento(true);return false;")
	 
     $('#myModal').modal('show');
	 }else{
	 $('#myModal').modal('hide');
	 
	 
	var IDPlan =  gup('IDPlan');
	 	
       $.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
	
	 $.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/revisionobjetivos&method=PasarSeguimiento",  
			data: { IDPlan: IDPlan,idplane:idplane},  
			cache: false,
			success: function(html)
			{
				
				
			
		setTimeout("window.location.href = '?execute=planesoperativo/seguimiento&method=default&Menu=F2&SubMenu=SF21&IDPlan="+idplano+"&IDPlanE="+idplane+"'",0);
       
				
  			}
 		});
	return false;
	 
	 
		
	 }
		
	}
	
	
	
	
	
	function Toogleresumen(id){
		var local = id.split("-");
		if($('#BOXRESUMEN').is(':visible')) $('#'+id).html('<i class="icon-chevron-down"></i> Comentarios');
		else $('#'+id).html('<i class="icon-chevron-up"></i> Comentarios');

		if ($('#BOXRESUMEN').is (':visible')) $('#BOXRESUMEN').slideUp();
		if ($('#BOXRESUMEN').is (':hidden')) $('#BOXRESUMEN').slideDown();
	}
	
	
	function Tooglecomentarios(id){
		var local = id.split("-");
		if($('#BOXCOM-'+local[1]+"-"+local[2]).is(':visible')) $('#'+id).html('<i class="icon-chevron-down"></i> Comentarios');
		else $('#'+id).html('<i class="icon-chevron-up"></i> Comentarios');
		
		if ($('#BOXCOM-'+local[1]+"-"+local[2]).is (':visible')) $('#BOXCOM-'+local[1]+"-"+local[2]).slideUp();
		if ($('#BOXCOM-'+local[1]+"-"+local[2]).is (':hidden')) $('#BOXCOM-'+local[1]+"-"+local[2]).slideDown();
	}
	
	function Toogle(obj){
		var idObj = $(obj).attr("id");
		var local = idObj.split("-");
		var contenido = $(obj).text();
		if($('#BOX-'+local[1]+"-"+local[2]).is(':visible')) $('#'+idObj).html('<i class="icon-chevron-down"></i>'+ contenido);
		else $('#'+idObj).html('<i class="icon-chevron-up"></i> '+ contenido);
		
		if ($('#BOX-'+local[1]+"-"+local[2]).is (':visible')) $('#BOX-'+local[1]+"-"+local[2]).slideUp();
		if ($('#BOX-'+local[1]+"-"+local[2]).is (':hidden')) $('#BOX-'+local[1]+"-"+local[2]).slideDown();
		
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


function TodosComentarios(idpo,idpe,estado){
      var idpo = idpo;
	  var idpe =  idpe;
	  var estado = estado;
	  
	  $('#results-panel-Modal').html('');
	  $('#myModalcomentarios').modal('show');
 	   
	  
	  setTimeout(function() {
    buscarComentarios(idpo,idpe,estado);
           }, 900)
	  
}



function buscarComentarios(idpo,idpe,estado){
  
  
  
   
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
    data: "execute=planesoperativo/revisionobjetivos&method=BuscarComentarios"+urltag+"&IDPlan="+idpo+"&IDPlanE="+idpe+"&estado="+estado,  
    success: function(msg){  
	

     $('#results-panel-Modal').html(msg);
    	
   
   
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
	