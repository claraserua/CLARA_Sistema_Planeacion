var arraylineas_objetivos = new Array();
var lineas_objetivos_medios = new Array();
var lineas_objetivos_evidencias = new Array();
const STORAGE_ACCOUNT_CONTAINER='https://claradocs.blob.core.windows.net';
const CONTAINER_NAME = 'docs-planeacion';
const KEY_ACCESS_BLOBS = '?sv=2018-03-28&si=docs-planeacion-16A99300774&sr=c&sig=MqK7a4s%2BFE3rfLtDF5G6G6k3oun%2FqfT8AnUlCJClDxE%3D';
var file = "";

var estadogeneral = new Array();

function EliminarAdjuntoR(idPeriodo, file_){
	
	var idplan = gup('IDPlan');
	var idPeriodo = idPeriodo;
	file = file_;
	//alert('datajs: ');
	$('#R'+idPeriodo).html('<img src="skins/default/img/loading.gif"/>');
	//$('#I'+id).hide();
	
	$.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/seguimiento&method=EliminarAdjuntoResumen",  
			data: { idplan: idplan, idPeriodo: idPeriodo, file: file},  
			cache: false,
			success: function(html)
			{
				//alert('html: '+html);
				$('#R'+idPeriodo).html('NO EXISTE ARCHIVO ADJUNTO');
				$('#I'+idPeriodo).show();
				$('#BE-'+idPeriodo).hide();
  			}
 		});
	}

	/*****************BUSCAR EVIDENCIAS**********************/
	

$(document).ready(function(){

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
	window.location.hash = urltag;
    ObtenerEvidenciasBuscar();
			});

  });






$(function(){

$('[rel="tooltip"],[data-rel="tooltip"]').tooltip({"placement":"bottom",delay: { show: 400, hide: 200 }});

$('#btnlr').hide();

	//POST FRAME ADD IMAGE USER
	$('#frmaddusuarios').iframePostForm
	({
		json : false,
		post : function ()
		{
			var message;
			
						
			if ($('#titulo').val().length&&$('#autor').val().length&&($('#linea').val().length&&$('#linea').val()!="NONE")&&($('#objetivo').val().length&&$('#objetivo').val()!="ALL"))
			{
				//GUARDANDO ARCHIVOS
					
			// $('html, body').animate({scrollTop:0}, 'slow');
              $.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
				
			}else{
				
				alert("Debes de ingresar todos los campos obligatorios");
				
				return false;
			}			
			
			
			
		},
		complete : function (response)
		{
			
			
	//alert(response);	
	
			if ( response.indexOf("Warning: preg_match()") != -1  ||  response == ""/*response.trim()=="false"*/)
			{
				
				
			    var plan = $('#idplan').val();
				var linea = $('#linea').val();
				var resultado = $('#objetivo').val();
				var txtlinea = $("#linea option:selected").text();
				var txtarraylinea = txtlinea.split(".-");
				txtlinea = txtarraylinea[1];
				
				var txtresultado = $("#objetivo option:selected").text();
				var txtarrayresultado = txtresultado.split(".-");
				txtresultado = txtarrayresultado[1];
				
			
				
				
				ObtenerEvidencias(plan,linea,resultado,txtresultado.trim(),txtlinea.trim());
				//buscar();
				$.unblockUI();
				//$('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha guardado la evidencia");
				
				$.growlUI('Muy bien!', 'Se ha guardado la evidencia'); 					
				
			 
				return false;
				
				//$('html, body').animate({scrollTop:0}, 10);
				/*$.unblockUI();
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-error");
				$("#headAlerta").html("!Error!");
				$("#bodyAlerta").html("Se ha producido un error al guardar los datos, intentelo nuevamente.");   
				$.growlUI('Error', 'Se ha producido un error al guardar los datos, intentelo nuevamente.'); 
				
				return false;*/
			}		
			
			
			else
			{
				
				//$('html, body').animate({scrollTop:0}, 10);
				$.unblockUI();
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-error");
				$("#headAlerta").html("!Error!");
				$("#bodyAlerta").html("Se ha producido un error al guardar los datos, intentelo nuevamente.");   
				$.growlUI('Error', 'Se ha producido un error al guardar los datos, intentelo nuevamente.'); 
				
				return false;
				
				
				
				
								
				/*var plan = $('#idplan').val();
				var linea = $('#linea').val();
				var resultado = $('#objetivo').val();
				var txtlinea = $("#linea option:selected").text();
				var txtarraylinea = txtlinea.split(".-");
				txtlinea = txtarraylinea[1];
				
				var txtresultado = $("#objetivo option:selected").text();
				var txtarrayresultado = txtresultado.split(".-");
				txtresultado = txtarrayresultado[1];
				
			
				
				
				ObtenerEvidencias(plan,linea,resultado,txtresultado.trim(),txtlinea.trim());
				//buscar();
				$.unblockUI();
				//$('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha guardado la evidencia");
				
				$.growlUI('Muy bien!', 'Se ha guardado la evidencia'); 
				
				
				
				
				//$("#frmaddusuarios")[0].reset();
				
				//$('#sel2').empty();
				
				//window.setTimeout("window.location.href='?execute=usuarios&Menu=F3&SubMenu=SF8#&p=1&s=25&sort=1&q='",1000)
			 
				return false;*/
				
				
			}
		}
	});
	
		//ADJUNTAR ARCHIVO RESUMEN
	var id = null;	
		
		$('.adjuntarfile').iframePostForm
	({
		json : false,
		post : function ()
		{
			
			//var postData = $(this).serializeArray();
            var formURL = $(this).attr("id");
			id =  formURL.substring(5);
					
				
			$('#R'+id).html('<img src="skins/default/img/loading.gif"/>');
			$('#I'+id).hide();
		         
			
		},
		complete : function (response)
		{
			
			
			
	      //  var idplan = gup('IDPlan');
			// $('#R'+id).html('<a href="media/planesoperativos/'+idplan+'/'+id+'/'+response+'" target="_blank">'+response+'</a> &nbsp;<a href="javascript:void(0)" id="BE-'+id+'" onClick="EliminarAdjuntoR(\''+id+'\')" class="btn btn-small btn-warning">Eliminar</button>');
			    var idplan = gup('IDPlan');
			 
			if ( response.indexOf("Warning: preg_match()") != -1  ||  response == ""/*response.trim()=="false"*/)
			{
				
				
				var explode = response.split('#%#');
							var name_archiv = explode[1];
				     //$('#R'+id).html('<a href="media_/planesoperativos/'+idplan+'/'+id+'/'+name_archiv+'" target="_blank">'+name_archiv+'</a> &nbsp;<a href="javascript:void(0)" id="BE-'+id+'" onClick="EliminarAdjuntoR(\''+id+'\')" class="btn btn-small btn-warning">Eliminar</button>'); \''+id+'\' name_archiv
					 $('#R'+id).html('<a href="'+STORAGE_ACCOUNT_CONTAINER+'/'+CONTAINER_NAME+'/media/planesoperativos/'+idplan+'/'+id+'/'+name_archiv+KEY_ACCESS_BLOBS+'" target="_blank">'+name_archiv+'</a> &nbsp;<a href="javascript:void(0)" id="BE-'+id+'" onClick="EliminarAdjuntoR(\''+id+'\',\''+name_archiv.trim()+'\')" class="btn btn-small btn-warning">Eliminar</button>');		
			}else{
				
				//$('html, body').animate({scrollTop:0}, 10);
				//$.unblockUI();
				
				
				var explode = response.split('#%#'); 
	            var error = explode[0];	
				
				
			//$('#R'+id).html('<a href="media/planesoperativos/'+idplan+'/'+id+'/'+error+'" target="_blank">'+error+'</a> &nbsp;<a href="javascript:void(0)" id="BE-'+id+'" onClick="EliminarAdjuntoR(\''+id+'\')" class="btn btn-small btn-warning">Eliminar</button>');
				
				
			$('#R'+id).html('<a href="javascript:void(0)" id="BE-'+id+'" onClick="EliminarAdjuntoR(\''+id+'\')" class="btn btn-small btn-warning">Eliminar</button>');	
				
				
				//actualizar 								
				
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-error");
				$("#headAlerta").html("!Error!");
				$("#bodyAlerta").html("Se ha producido un error al guardar el adjunto, intentelo nuevamente.");   
				$.growlUI('Error', 'Se ha producido un error al guardar adjunto, intentelo nuevamente.'); 
				
				return false;
				
				
				
				
			}
			 
			 
			 
			
			
	
		}
	})
	
	
	
	
	
	
	
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

	
	$('[rel="popover"],[data-rel="popover"]').popover();
	
	

});//End function jquery



function recount(id)
{  

  $('#update_button-L'+id).removeAttr('disabled').removeClass('inact');
	
	
}

$('.adjunto').live('change', function(){ 

  //alert($(this).attr("id"));
  var id=$(this).attr("id");
  $( "#FORM-"+id).submit();

 });


function recountr()
{  
$('#update_button-resumen').removeAttr('disabled').removeClass('inact');
    
}


function guardarComentario(id,idobjetivo){
	
	
	id = id.substring(13)
	id = id.split("-");
	
	
    var comentario = $("#inputField-"+id[1]+"-"+id[2]).val();
	
	$("#counter-"+id[1]+"-"+id[2]).html('<img src="skins/default/img/spinner-mini.gif" />');
	
		$.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/revisionobjetivos&method=insertarComentario",  
			data: { comentario: comentario, idobjetivo: idobjetivo},  
			cache: false,
			success: function(html)
			{
				
				$("#comentarios-"+id[1]+"-"+id[2]).prepend($(html).fadeIn('slow'));
				$("#inputField-"+id[1]+"-"+id[2]).val('');	
				$("#inputField-"+id[1]+"-"+id[2]).focus();
				//$("#stexpand").oembed(updateval);
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
	
	$("#counter-resumen").html('<img src="skins/default/img/spinner-mini.gif" />');
	
		$.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/revisionobjetivos&method=insertarComentarioResumen",  
			data: { comentario: comentario, idplan: idplan},  
			cache: false,
			success: function(html)
			{
				
				
				$("#comentarios-resumen").prepend($(html).fadeIn('slow'));
				$("#inputField-resumen").val('');	
				$("#inputField-resumen").focus();
				//$("#stexpand").oembed(updateval);
  			}
 		});
	return false;

	
}


   function GuardarResumenPeriodo(id){
   	
	    var periodo = id;
		var valor = window[id].getData(); 
		var plan = gup('IDPlan');
		
	$("#loadr-"+periodo).html('<img src="skins/default/img/spinner-mini.gif" />');
	
		$.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/seguimiento&method=GuardarResumenPeriodo",  
			data: { resumen: valor, periodo: periodo, plan:plan},  
			cache: false,
			success: function(html)
			{
				$("#loadr-"+periodo).html('<span><i class="icon icon-red icon-check"></i>&nbsp;<h2>Guardado....</h2><span>');
  			}
 		});
	return false;
	
	
	
   }



    function EnviarInforme(confirm){
		
		if(!confirm){
      $('#titlemodal1').html('Enviar avance de plan operativo');
	  $('#bodymodal1').html('¿Está seguro de enviar el informe? <br>');
	  $("#aceptarmodal1").attr("onClick", "javascript:EnviarInforme(true);return false;")
	 

     $('#myModal1').modal('show');
	 }else{
	 $('#myModal1').modal('hide');
	 
	 var idplan =  gup('IDPlan');
	 var planE = gup('IDPlanE');
	
	$.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
	 
	 
	  $.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/seguimiento&method=EnviarInforme",  
			data: { idplan: idplan,planE:planE },  
			cache: false,
			success: function(html)
			{
			
			 //alert(html);
			pagina = "?execute=operativo&method=default&Menu=F2&SubMenu=SF21#&p=1&s=25&sort=1&q=&alert=2"
		    location.href=pagina;
       
				
  			}
 		});
	
	 
	 
	 }
	
    }
	
	
	
	
	function RevisarInforme(confirm){
		
		if(!confirm){
      $('#titlemodal1').html('Enviar revisión de avance de plan operativo');
	  $('#bodymodal1').html('¿Está seguro de enviar el informe revisado? <br>');
	  $("#aceptarmodal1").attr("onClick", "javascript:RevisarInforme(true);return false;")
	 

     $('#myModal1').modal('show');
	 }else{
	 $('#myModal1').modal('hide');
	 
	 var idplan =  gup('IDPlan');
	 var planE = gup('IDPlanE');
	
	$.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
	 
	 
	  $.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/seguimiento&method=RevisarInforme",  
			data: { idplan: idplan,planE:planE },  
			cache: false,
			success: function(html)
			{
			
			 //alert(html);
			pagina = "?execute=operativo&method=default&Menu=F2&SubMenu=SF21#&p=1&s=25&sort=1&q=&alert=2"
		    location.href=pagina;
       
				
  			}
 		});
	
	 
	 
	 }
	
    }
	

	function EnviarRevision(confirm){
	
	if(!confirm){
	 $('#titlemodal').html('Enviar revisión de avance de plan operativo');
	 $('#bodymodal').html('¿Está seguro de enviar el informe revisado? <br>');
	  $("#aceptarmodal").attr("onClick", "javascript:EnviarRevision(true);return false;")
	 
	 
	
	 
     $('#myModal').modal('show');
	 }else{
	 $('#myModal').modal('hide');
	 
	 
	var IDPlan =  gup('IDPlan');
	 	
		$.blockUI({ css: { backgroundColor: 'transparent', color: '#fff', border:"null" },
	            overlayCSS: {backgroundColor: '#000'},
                 message: '<img src="skins/admin/images/ajax-loader2.gif" /><br><h3> Espere un momento..</h3>'
                 });
	 
	 $.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/revisionobjetivos&method=EnviarRevision",  
			data: { IDPlan: IDPlan},  
			cache: false,
			success: function(html)
			{
			
				setTimeout("window.location.href = '?execute=operativo&Menu=F2&SubMenu=SF6#&p=1&s=25&sort=1&q=&alert=petrue'",0);
       
				
  			}
 		});
	return false;
	 
	 
		
	 }
		
	}
	
	
	
	function guardarPorcentajeObjetivo(idobjetivo,idperiodo,avance){
	
		
		 
		
		var idobjetivo = idobjetivo;
		var idperiodo = idperiodo;
		var avance = avance;
		
		$.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/seguimiento&method=GuardarAvanceObjetivo",  
			data: { idobjetivo: idobjetivo, idperiodo: idperiodo, avance:avance},  
			cache: false,
			success: function(html)
			{
				if(!__validasesion(html)){

      	             _openlogin();

                }else{
                          $.growlUI('Resultado', 'Avance Guardado: '+ avance+'%');  
                          }          
               				
  			},error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        }
 		});
		
	}
	
	
	
	function guardarPorcentajeMedio(idmedio,idperiodo,avance){
	
		
		 
		 
		
		var idmedio = idmedio;
		var idperiodo = idperiodo;
		var avance = avance;
		
		$.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/seguimiento&method=GuardarAvanceMedio",  
			data: { idmedio: idmedio, idperiodo: idperiodo, avance:avance},  
			cache: false,
			success: function(html)
			{       

			if(!__validasesion(html)){

      	             _openlogin();

                }else{
                  $.growlUI('Medio', 'Avance Guardado: '+ avance+'%'); 
                }            
				
				
				
  			},error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        }
 		});
		
	}
	
	

	
	function OpenAnotaciones(idobjetivo,idperiodo,titulo){
	
		$("#comentariospo").html('');
		$("#modal-footerl").html('');
		$('#myModal').modal('show');
		
		
		 $("#titlemodalR").html("Anotaciones del centro y revisón: "+titulo);
	
		var idobjetivo = idobjetivo;
		var idperiodo = idperiodo;
		var IDPlan = gup('IDPlan');
		
		
		
		$.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/seguimiento&method=ObtenerComentariosSeguimiento",  
			data: { idobjetivo: idobjetivo, idperiodo: idperiodo, IDPlan:IDPlan},  
			cache: false,
			success: function(html)
			{   
			
		     	$("#comentariospo").html(html);
				$("#update_buttonpo").attr("onClick", "guardarComentarioPeriodo('"+idobjetivo+"','"+idperiodo+"');");
               	
				
  			}
 		});
	}
	
	
	
	
	
	
	
	function guardarComentarioResumenPeriodo(idpoperativo,idperiodo,tipo){
	
	
	var idpoperativo = idpoperativo;
	var idperiodo = idperiodo;
	var tipo = tipo;
    var comentario = $("#inputField"+tipo+"-"+idperiodo).val();
	
	
	
	$("#counter"+tipo+"-"+idperiodo).html('<img src="skins/default/img/spinner-mini.gif" />');
	
		$.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/seguimiento&method=insertarComentarioResumenPeriodo",  
			data: { comentario: comentario, idpoperativo: idpoperativo,idperiodo:idperiodo,tipo:tipo}, 
			cache: false,
			success: function(html)
			{
			
				$("#comentarios"+tipo+"-"+idperiodo).prepend($(html).fadeIn('slow'));
				$("#counter"+tipo+"-"+idperiodo).html('');
				$("#inputField"+tipo+"-"+idperiodo).val('');	
				$("#inputField"+tipo+"-"+idperiodo).focus();
		
  			}
 		});
	return false;

}
	
	
	
	
	
	function guardarComentarioPeriodo(idobjetivo,idperiodo){
		
	
	var idobjetivo = idobjetivo;
	var idperiodo = idperiodo;
    var comentario = $("#inputFieldpo").val();
	
	$("#counterpo").html('<img src="skins/default/img/spinner-mini.gif" />');
	
		$.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/seguimiento&method=insertarComentarioPeriodo",  
			data: { comentario: comentario, idobjetivo: idobjetivo,idperiodo:idperiodo},  
			cache: false,
			success: function(html)
			{
				//alert(html);
				
				$("#comentariosperiodoso").prepend($(html).fadeIn('slow'));
				$("#counterpo").html('');
				$("#inputFieldpo").val('');	
				$("#inputFieldpo").focus();
		
  			}
 		});
	return false;

}
	
	
	
	$('.stdeleteop').live("click",function() 
{
var ID = $(this).attr("id");

if(confirm("¿Estás seguro que deseas  borrar el comentario?"))
{
	
	$("#stbody"+ID).prepend('<img src="skins/default/img/spinner-mini.gif" />');
	$.ajax({
		type: "POST",
		url: "index.php?execute=planesoperativo/seguimiento&method=eliminarComentario",  
		data: {idcomentario: ID},  
		cache: false,
		success: function(html){
			
		
		$("#stbody"+ID).slideUp();
		}
 	});
}
return false;
});
	
	
	$('.stdeleters').live("click",function() 
{
var ID = $(this).attr("id");

if(confirm("¿Estás seguro que deseas  borrar el comentario?"))
{
	
	$("#rstbodyrs"+ID).prepend('<img src="skins/default/img/spinner-mini.gif" />');
	$.ajax({
		type: "POST",
		url: "index.php?execute=planesoperativo/seguimiento&method=eliminarComentarioResumenPeriodos",  
		data: {idcomentario: ID},  
		cache: false,
		success: function(html){
			
		
		$("#rstbodyrs"+ID).slideUp();
		}
 	});
}
return false;
});
	
	

	
function uploadEvidencias(){
		
		 $('#myModalupload').modal('show');
		 $('#editar').val('FALSE');
		 $('#titulo').val("");
		 $('#descripcion').val("");
		 $('#autor').val("");
		 
		 linea = $('#lineasfilter').val();
		 objetivo = $('#objetivosfilter').val();
		 $('#linea option[value="'+linea+'"]').attr('selected', 'selected');
		 getObjetivosE(linea,objetivo);
		//$('#objetivo option[value="'+objetivo+'"]').attr('selected', 'selected');
}
	

	
function editEvidencias(id,titulo,descripcion,autor,linea,objetivo){
		
		
		 $('#myModalupload').modal('show');
		 $('#idevidencia').val(id);
		 $('#editar').val('TRUE');
		 $('#titulo').val(titulo);
		 $('#descripcion').val(descripcion);
		 $('#autor').val(autor);
		 
		 $('#linea option[value="'+linea+'"]').attr('selected', 'selected');
		 
		 getObjetivosE(linea,objetivo);
		 
	}
	
	
	
	function ToogleAnal(id){
	
		var local = id.split("-");
		if($('#ANAR-'+local[1]+"-"+local[2]).is(':visible')) $('#'+id).html('<i class="icon-chevron-down"></i>&nbsp;Comentarios&nbsp;<i class="icon-comment"></i>');
		else $('#'+id).html('<i class="icon-chevron-up"></i>&nbsp;Comentarios&nbsp;<i class="icon-comment"></i>');
		

		if ($('#ANAR-'+local[1]+"-"+local[2]).is (':visible')) $('#ANAR-'+local[1]+"-"+local[2]).slideUp();
		if ($('#ANAR-'+local[1]+"-"+local[2]).is (':hidden')) $('#ANAR-'+local[1]+"-"+local[2]).slideDown();
			
	}
	
	
	
	
	
	function ToogleCol(id){
	
		var local = id.split("-");
		if($('#COMR-'+local[1]+"-"+local[2]).is(':visible')) $('#'+id).html('<i class="icon-chevron-down"></i>&nbsp;Comentarios&nbsp;<i class="icon-comment"></i>');
		else $('#'+id).html('<i class="icon-chevron-up"></i>&nbsp;Comentarios&nbsp;<i class="icon-comment"></i>');
		

		if ($('#COMR-'+local[1]+"-"+local[2]).is (':visible')) $('#COMR-'+local[1]+"-"+local[2]).slideUp();
		if ($('#COMR-'+local[1]+"-"+local[2]).is (':hidden')) $('#COMR-'+local[1]+"-"+local[2]).slideDown();
			
	}
	
	function Toogle(id){
	
		var local = id.split("-");
		if($('#BOX-'+local[1]+"-"+local[2]).is(':visible')) $('#'+id).html('<i class="icon-chevron-down"></i>&nbsp;Comentarios&nbsp;<i class="icon-comment"></i>');
		else $('#'+id).html('<i class="icon-chevron-up"></i>&nbsp;Comentarios&nbsp;<i class="icon-comment"></i>');
		

		if ($('#BOX-'+local[1]+"-"+local[2]).is (':visible')) $('#BOX-'+local[1]+"-"+local[2]).slideUp();
		if ($('#BOX-'+local[1]+"-"+local[2]).is (':hidden')) $('#BOX-'+local[1]+"-"+local[2]).slideDown();
			
	}
	
	
	
	function ToogleSeguimiento(id){
	
		var local = id.split("-");
		
		if($('#BOXS-'+local[1]+"-"+local[2]).is(':visible')) $('#'+id).html('<i class="icon-chevron-down"></i>&nbsp;Mostrar Seguimiento de Avances&nbsp;</i>');
		else $('#'+id).html('<i class="icon-chevron-up"></i>&nbsp;Ocultar Seguimiento de Avances&nbsp;');
		

		if ($('#BOXS-'+local[1]+"-"+local[2]).is (':visible')) $('#BOXS-'+local[1]+"-"+local[2]).slideUp();
		if ($('#BOXS-'+local[1]+"-"+local[2]).is (':hidden')) $('#BOXS-'+local[1]+"-"+local[2]).slideDown();
			
	}
	function ToogleIndicadores(id){
	
		var local = id.split("-");
		
		if($('#BOXI-'+local[1]+"-"+local[2]).is(':visible')) $('#'+id).html('<i class="icon-chevron-down"></i>&nbsp;Mostrar Indicadores de Objetivo Estratégico&nbsp;</i>');
		else $('#'+id).html('<i class="icon-chevron-up"></i>&nbsp;Ocultar Indicadores de Objetivo Estratégico&nbsp;');
		

		if ($('#BOXI-'+local[1]+"-"+local[2]).is (':visible')) $('#BOXI-'+local[1]+"-"+local[2]).slideUp();
		if ($('#BOXI-'+local[1]+"-"+local[2]).is (':hidden')) $('#BOXI-'+local[1]+"-"+local[2]).slideDown();
			
	}
	
	
	
	function cambiarTab(id,estado){
		
		if(estado == "V"){		
			$('#tbularv'+id).attr("class","active");
			$('#tbulare'+id).removeAttr("class");
			
			$('#valoracion'+id).css("display", "block");
			$('#estadogeneral'+id).css("display", "none");
		}else{
			$('#tbularv'+id).removeAttr("class");
			$('#tbulare'+id).attr("class","active");
			$('#valoracion'+id).css("display", "none");
			$('#estadogeneral'+id).css("display", "block");
		}
		
	}
	
	function ToogleR(id){
		
		var local = id.split("-");
		if($('#BOX-'+local[1]).is(':visible')) $('#'+id).html('<i class="icon-chevron-down"></i>');
		else $('#'+id).html('<i class="icon-chevron-up"></i>');
		

		if ($('#BOX-'+local[1]).is (':visible')) $('#BOX-'+local[1]).slideUp();
		if ($('#BOX-'+local[1]).is (':hidden')) $('#BOX-'+local[1]).slideDown();
		
	}
	
	
	function Toogleresumen(id){
		var local = id.split("-");
		if($('#BOXRESUMEN').is(':visible')) $('#'+id).html('<i class="icon-chevron-down"></i> Comentarios');
		else $('#'+id).html('<i class="icon-chevron-up"></i> Comentarios');

		if ($('#BOXRESUMEN').is (':visible')) $('#BOXRESUMEN').slideUp();
		if ($('#BOXRESUMEN').is (':hidden')) $('#BOXRESUMEN').slideDown();
	}
	
	
	
	function Toogleresumenanual(id){
		
		if($('#BOXRESUMENANUAL').is(':visible')) $('#BTNTOGRESUMENANUAL').html('<i class="icon-chevron-down"></i> Diagnóstico Inicial');
		else $('#BTNTOGRESUMENANUAL').html('<i class="icon-chevron-up"></i> Diagnóstico Inicial');

		if ($('#BOXRESUMENANUAL').is (':visible')) $('#BOXRESUMENANUAL').slideUp();
		if ($('#BOXRESUMENANUAL').is (':hidden')) $('#BOXRESUMENANUAL').slideDown();
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
	
	
	

  

  
    function filtrarTodo(cat){
	
	
	if(cat=="YES"){
		 $('#all').attr('checked', true);
		 urltag = "&p=1&s="+gup('s')+"&sort="+gup('sort')+"&q="+gup('q');
		  window.location.hash = urltag;
	}else{
		
	   urltag = "&p=1&s="+gup('s')+"&sort="+gup('sort')+"&q="+gup('q');
      if(gup('objetivo')){ urltag += "&objetivo="+gup('objetivo');}
		
	   }
	
	if($('#all').is(':checked')){
	
	$("input[@name='tipos[]']:checked").each(function() {
            $(this).attr('checked', false);
        });
	
      $('#all').attr('checked', true);
	  
	  
	
      window.location.hash = urltag;
   	
      buscar();
	   
      }
		
		}
  
  function archivos(cat){
  	
	if($('#DOCS').is(':checked')){
  	   $('#PPT').attr('checked', true);
	   $('#DOC').attr('checked', true);
	   $('#XLS').attr('checked', true);
	   $('#PDF').attr('checked', true);
	   $('#ZIP').attr('checked', true);
	   $('#all').attr('checked', false);
	   }else{
	   $('#PPT').attr('checked', false);
	   $('#DOC').attr('checked', false);
	   $('#XLS').attr('checked', false);
	   $('#PDF').attr('checked', false);
	   $('#ZIP').attr('checked', false);
		
	   }
  	
	   filtrar("DOCS");
	}
  
    
  function filtrar(cat){
  
  var categorias = new Array();
  $('#all').attr('checked', false);
	
	$("input[@name='tipos[]']:checked").each(function() {
            categorias.push($(this).val());
        });
			
	urltag = "&p=1&s="+gup('s')+"&sort="+gup('sort')+"&q="+gup('q');
    if(categorias.length>0){
  	fil = categorias.join(";");	
	urltag += "&filter="+fil;
        }
    if(gup('objetivo')){ urltag += "&objetivo="+gup('objetivo');}
	
	
   window.location.hash = urltag;
   	
   buscar();	
	
  }
  
  
  function showPage(p){

  urltag = "&p="+p+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+gup('q');
  if(gup('filter')!=" "){

	urltag += "&filter="+gup('filter');
        }
        
    if(gup('objetivo')){
		urltag += "&objetivo="+gup('objetivo');
	}      
 
   window.location.hash = urltag;
   buscar();	
  }
  
  
  
  
  function showLimitPage(s,id){

  urltag = "&p="+gup('p')+"&s="+s+"&sort="+gup('sort')+"&q="+gup('q');
  if(gup('filter')!=" "){

	urltag += "&filter="+gup('filter');
        }
        
      if(gup('objetivo')){
		urltag += "&objetivo="+gup('objetivo');
	}   
        
  
   window.location.hash = urltag;	
   buscar();	
  }
  
  
  function Ordenar(value){
  	

  	
  }
  
  
  
  
  function ShowEvidencias(idobjetivo,idestretegico,plan,tituloresul,tituloli){
  	

	//getObjetivoslinea(idestretegico);
	
	var resultado = idobjetivo;
	var linea = idestretegico;
	
	$('#lineasfilter').val(linea);
	$('#objetivosfilter').val(resultado);
		
	$('#myTablab a:last').tab('show');
	
	urltag = "&p=1&s="+gup('s')+"&sort="+gup('sort')+"&q="+gup('q');
	
	urltag += "&objetivo="+idobjetivo;
	
	window.location.hash = urltag;
	
	$('html, body').animate({scrollTop:100}, 1000);
	
	
	
	ObtenerEvidencias(plan,linea,resultado,tituloresul,tituloli)
	
	
	//buscar();
		
	//$("#lineasfilter option[value="+idestretegico+"]").attr("selected",true);
	
	//setTimeout('$("#objetivosfilter option[value=\''+idobjetivo+'\']").attr("selected",true);',1500);
	
  }
  
  
  
  
  
  
  
  
  

  function buscar(){
  
				 
	 $('#results-panel').block({ css: { backgroundColor: 'transparent', color: '#EC5C00', border:"null" },
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Buscando...</h3>' });
  
  var fil="";
  var q="";
  
    q = gup('q');
	//$('#searchbar').val(q);
	
var IDPlan = gup('IDPlan');
var IDPlanE = gup('IDPlanE');
var s= parseInt(gup('s'));
  
  urltag = "&p="+gup('p')+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+q;
  
    if(gup('filter')){
		urltag += "&filter="+gup('filter');
	}
  
    if(gup('objetivo')){
		urltag += "&objetivo="+gup('objetivo');
	}  
   	
   window.location.hash = urltag;
	
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=planesoperativo/seguimiento&method=Buscar&IDPlan="+IDPlan+"&IDPlanE="+IDPlanE+urltag,  
    success: function(msg){  
	
	var contenido = msg.split('#%#');

    	// alert(msg);
   
   //$('#results-panel').html(msg);
   $('#results-panel').html(contenido[0]);
    $('#results_text').html(contenido[1]+'resultados');
   
   
   
    $('#sort-panel-lines').html('<div id="toolbar"><a class="subnavigation" style="text-decoration:underline;" href="#" onClick="buscar()">L&iacute;neas</a></div>');
    
 $('#lineasfilter').val('');   
 $('#objetivosfilter').val('');
 $('#linea option[value="NONE"]').attr('selected', 'selected');
    
      
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
	 
      $('#results-panel').unblock();	  
 // $.unblockUI();
               } 
   
           });
	
  }
  
  
  
  
  function ObtenerResultados(plan,linea,tituloli){
  
				 
	 $('#results-panel').block({ css: { backgroundColor: 'transparent', color: '#EC5C00', border:"null" },
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Buscando...</h3>' });
  
  var fil="";
  var q="";
  
    q = gup('q');
	//$('#searchbar').val(q);
	
var IDPlan = plan;
var IDLinea = linea;
//var tituloli = tituloli;

var s= parseInt(gup('s'));
  
  urltag = "&p="+gup('p')+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+q;
  
    if(gup('filter')){
		urltag += "&filter="+gup('filter');
	}
  
    if(gup('objetivo')){
		urltag += "&objetivo="+gup('objetivo');
	}  
   	
   window.location.hash = urltag;
	
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=planesoperativo/seguimiento&method=BuscarResultados&IDPlan="+IDPlan+"&IDLinea="+IDLinea+"&tituloli="+tituloli+urltag,  
    success: function(msg){  
	
	var contenido = msg.split('#%#');

    	
   $('#results-panel').html(contenido[0]);
    $('#results_text').html(contenido[1]+'resultados');
   
   
  
 $('#sort-panel-lines').html('<div id="toolbar"><a class="subnavigation" style="text-decoration:underline;" href="#" onClick="buscar()">L&iacute;neas</a> <i class="icon-chevron-right"></i> <a class="subnavigationactive" style="text-decoration:underline;" href="#" onClick="ObtenerResultados(\''+IDPlan+'\',\''+IDLinea+'\',\''+tituloli+'\')">'+tituloli+'</a> </div>');
 
 $('#lineasfilter').val(linea);
 $('#objetivosfilter').val('');
  $('#objetivo option[value="NONE"]').attr('selected', 'selected');
 
      
      
      
  
   
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
	 
      $('#results-panel').unblock();	  
 // $.unblockUI();
               } 
   
           });
	
  }


  
  
  function ObtenerEvidencias(plan,linea,resultado,tituloresul,tituloli){
  
  
  
   $('#results-panel').block({ css: { backgroundColor: 'transparent', color: '#EC5C00', border:"null" },
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Buscando...</h3>' });
  
  var fil="";
  var q="";
  
    q = gup('q');
	//$('#searchbar').val(q);
	
var IDPlan = plan;
var IDLinea = linea;
var IDResultado = resultado;
var s= parseInt(gup('s'));
  
  urltag = "&p="+gup('p')+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+q;
  
    if(gup('filter')){
		urltag += "&filter="+gup('filter');
	}
  
    if(gup('objetivo')){
		urltag += "&objetivo="+gup('objetivo');
	}  
   	
   window.location.hash = urltag;    
	
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=planesoperativo/seguimiento&method=BuscarEvidencias&IDPlan="+IDPlan+"&IDLinea="+IDLinea+"&IDResultado="+IDResultado+"&tituloresul="+tituloresul+"&tituloli="+tituloli+urltag,  
    success: function(msg){  
	
	var contenido = msg.split('#%#');

    	// alert(msg);
   
  // $('#results-panel').html(msg);
  
 
    $('#results-panel').html(contenido[0]);
    $('#results_text').html(contenido[1]+'resultados');
   
  
    
        
    
 
   if(gup('q')==""){  
   
  
     
   $('#sort-panel-lines').html('<div id="toolbar"><a class="subnavigation" style="text-decoration:underline;" href="#" onClick="buscar()">L&iacute;neas</a> <i class="icon-chevron-right"></i> <a class="subnavigation" style="text-decoration:underline;" href="#" onClick="ObtenerResultados(\''+IDPlan+'\',\''+IDLinea+'\',\''+tituloli+'\')">'+tituloli+'</a>  <i class="icon-chevron-right"></i> <a class="subnavigationactive" style="text-decoration:underline;" href="#" onClick="ObtenerEvidencias(\''+IDPlan+'\',\''+IDLinea+'\',\''+IDResultado+'\',\''+tituloresul+'\',\''+tituloli+'\')">'+tituloresul+'</a></div>');
   
   
     $('#objetivosfilter').val(IDResultado);
   
   }else{   
  
     $('#sort-panel-lines').html('<div id="toolbar"><a class="subnavigationactive" style="text-decoration:underline;" href="#" onClick="buscar()">L&iacute;neas</a></div>');
     
   
      
   }
  
  
   
   
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
	 
      $('#results-panel').unblock();	  
 // $.unblockUI();
               } 
   
           });
  
  }
  
  
  
   function ObtenerEvidenciasBuscar(){
  
  
   $('#results-panel').block({ css: { backgroundColor: 'transparent', color: '#EC5C00', border:"null" },
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Buscando...</h3>' });
  
  var fil="";
  var q="";
  
    q = gup('q');
	//$('#searchbar').val(q);
	
var IDPlan = gup('IDPlan');
var IDPlanE = gup('IDPlanE');
var s= parseInt(gup('s'));
  
  urltag = "&p="+gup('p')+"&s="+gup('s')+"&sort="+gup('sort')+"&q="+q;
  
    if(gup('filter')){
		urltag += "&filter="+gup('filter');
	}
  
    if(gup('objetivo')){
		urltag += "&objetivo="+gup('objetivo');
	}  
   	
   window.location.hash = urltag;    
	
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=planesoperativo/seguimiento&method=BuscarEvidencias2&IDPlan="+IDPlan+urltag,  
    success: function(msg){  
	
	var contenido = msg.split('#%#');

    	// alert(msg);
   
  // $('#results-panel').html(msg);
  
  
 
  
   $('#results-panel').html(contenido[0]);
    $('#results_text').html(contenido[1]+'resultados');
   
   
  
   
   $('#sort-panel-lines').html('<div id="toolbar"><a class="subnavigationactive" href="#" onClick="buscar()"><u>L&iacute;neas</u></a></div>');
   
   $('#lineasfilter').val('');   
 $('#objetivosfilter').val('');
 $('#linea option[value="NONE"]').attr('selected', 'selected')
    
   
   
    //  $('#sort-panel-lines').html('<div id="toolbar"><a class="subnavigation" style="text-decoration:underline;" href="#" onClick="buscar()"><span title=".icon .icon-blue .icon-home " class="icon icon-blue icon-home"></span>Lineas</a></div>');
    
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
	 
      $('#results-panel').unblock();	  
 // $.unblockUI();
               } 
   
           });
  
  }
  
  
  
  
  
  
  
  

function getObjetivosE(linea,objetivo){
	
	$('#objetivo').attr("disabled","disabled");
	var value = linea; 
	var plan = gup('IDPlan');
		
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=planesoperativo/seguimiento&method=Buscarobjetivos&linea="+value+"&plan="+plan,  
    success: function(msg){  
	
	//alert(msg);
	
    $('#objetivo').html(msg);
	$('#objetivo').removeAttr("disabled");
	
	$('#objetivo option[value="'+objetivo+'"]').attr('selected', 'selected');
	
               } 
      });
    }


  
  
  
  function getObjetivos(sel){
	
	$('#objetivo').attr("disabled","disabled");
	var value = sel.options[sel.selectedIndex].value; 
	var plan = gup('IDPlan');
		
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=planesoperativo/seguimiento&method=Buscarobjetivos&linea="+value+"&plan="+plan,  
    success: function(msg){  
	
	
    $('#objetivo').html(msg);
	$('#objetivo').removeAttr("disabled");
               } 
      });
    }


 function getObjetivosfilter(sel){
	$('#objetivosfilter').attr("disabled","disabled")
	var value = sel.options[sel.selectedIndex].value; 
	var plan = gup('IDPlan');
		
	if(value=="ALL"){
	
	$('#objetivosfilter').html('');
	filtrarTodo("YES");
		
	}else{
		
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=planesoperativo/seguimiento&method=Buscarobjetivos&linea="+value+"&plan="+plan,  
    success: function(msg){  
	
    $('#objetivosfilter').html(msg);
	$('#objetivosfilter').removeAttr("disabled");
               } 
      });
      }
	}

  
  
  function getObjetivoslinea(val){
	$('#objetivosfilter').attr("disabled","disabled")
	var value = val; 
	var plan = gup('IDPlan');
		
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=planesoperativo/seguimiento&method=Buscarobjetivos&linea="+value+"&plan="+plan,  
    success: function(msg){  
	
	
    $('#objetivosfilter').html(msg);
	$('#objetivosfilter').removeAttr("disabled");
               } 
      });
    }
  
  
  
  function filterObjetivo(sel){
  	
	var value = sel.options[sel.selectedIndex].value; 	
  
	urltag = "&p=1&s="+gup('s')+"&sort="+gup('sort')+"&q="+gup('q');
	
	urltag += "&objetivo="+value;
	
	window.location.hash = urltag;
		
   	buscar();
  }
  
  
  /*function ShowEvidencias(idobjetivo,idestretegico){
  	

	getObjetivoslinea(idestretegico);
		
	$('#myTablab a:last').tab('show');
	
	urltag = "&p=1&s="+gup('s')+"&sort="+gup('sort')+"&q="+gup('q');
	
	urltag += "&objetivo="+idobjetivo;
	
	window.location.hash = urltag;
	
	$('html, body').animate({scrollTop:100}, 1000);
	
	buscar();
		
	$("#lineasfilter option[value="+idestretegico+"]").attr("selected",true);
	
	setTimeout('$("#objetivosfilter option[value=\''+idobjetivo+'\']").attr("selected",true);',1500);
	
  }*/
  
  
  
  function deleteEvidencia(file,id,idplan,linea,resultado,tituloresul,tituloli){
		
	$('#ModalDeleteEvidencia').modal('show');
	
	$("#btneliminae").attr("onClick", "javascript:deleteEvidenciaall('"+file+"','"+id+"','"+idplan+"','"+linea+"','"+resultado+"','"+tituloresul+"','"+tituloli+"');return false;")
	
	
	
  }
  
  
  function deleteEvidenciaall(file,id,idplan,linea,resultado,tituloresul,tituloli){
  		
		var valor =  $('input[name=opeliminar]:checked').val();
	 
	 if(valor=="Y"){
			var evidencia = id; 
			var plan = gup('IDPlan');
			$('#ModalDeleteEvidencia').modal('hide');

			$.ajax({ 
				type: "POST",  
				//url: "index.php",  
				//data: "execute=planesoperativo/seguimiento&method=EliminarEvidenciaArchivo&idevidencia="+evidencia,  
				url: "index.php?execute=planesoperativo/seguimiento&method=EliminarEvidenciaArchivo",  
				data: { evidencia: evidencia, file: file},
				success: function(html){
				//	alert("Succes-html: "+html);
						ObtenerEvidencias(idplan,linea,resultado,tituloresul,tituloli);
						// buscar();
				}
			});
	 }else{
	 	
	 var evidencia = id; 
	 var plan = gup('IDPlan');
	 $('#ModalDeleteEvidencia').modal('hide');	
				
	 $.ajax({ 
     type: "POST",  
     //url: "index.php",  
		 //data: "execute=planesoperativo/seguimiento&method=EliminarEvidencia&idevidencia="+evidencia, 
		 url: "index.php?execute=planesoperativo/seguimiento&method=EliminarEvidencia",  
     data: { evidencia: evidencia, file: file},
     success: function(html){
		//alert("Succes-html: "+html);
			
	    ObtenerEvidencias(idplan,linea,resultado,tituloresul,tituloli);
			// buscar();
    
      }
     });
	  
	 }
	}
		function redireccionar(){
		window.location.href = document.URL;
  }
  
  
  
  function WindowOpen(id,idplan){
	    var href = "index.php?execute=planesoperativo/evidencia&method=default&id="+id+"&IDPlan="+idplan;
		var caracteristicas = "height=600,width=900,scrollTo,resizable=1,scrollbars=1,location=0";
      	nueva=window.open(href, 'Popup', caracteristicas);
      	return false;
}
	
	
	
	
	function EliminarColaborador(id){

	 var explode = id.split('-'); 
	 var periodo = explode[0];
	 var idcolaborador = explode[1];
	 
	 var eliminar = confirm('¿Se eliminara el Colaborador?');
	 
	 
	 if(eliminar){
	 	
	 $("#counter-"+periodo).html('<img src="skins/default/img/spinner-mini.gif" />');
	
		$.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/seguimiento&method=eliminarColaborador",  
			data: { idcolaborador: idcolaborador},  
			cache: false,
			success: function(html)
			{
			
			$("#col-"+idcolaborador).slideUp();
		    $("#counter-"+periodo).html('');
			
		
  			}
 		});
	}
	return false;
	 
	 
	 
}

function ShowBtnRegresar(){
	$('#btnlr').show();
}

function HideBtnRegresar(){
	$('#btnlr').hide();
}


function ShowLR(){
	
	$('#myTablab a:first').tab('show');
	$('#btnlr').hide();
	
}

function AgregarColaborador(id){
	
	
	var explode = id.split('-'); 
	var periodo = explode[1];
	var plano = gup('IDPlan');
	 
	 
    var nombre = $("#N-"+periodo).val();
	var puesto = $("#P-"+periodo).val();
	var departamento = $("#D-"+periodo).val();
	var valoracion = $("#V-"+periodo).val();
	
	$("#colaboradores-"+periodo).find('h1').remove();
	
	
	$("#counter-"+periodo).html('<img src="skins/default/img/spinner-mini.gif" />');
	
		$.ajax({
			type: "POST",
			url: "index.php?execute=planesoperativo/seguimiento&method=insertarColaborador",  
			data: { plano: plano, periodo: periodo,nombre:nombre,puesto:puesto,departamento:departamento,valoracion:valoracion},  
			cache: false,
			success: function(html)
			{
				$("#colaboradores-"+periodo).append($(html).fadeIn('slow'));
				$("#counter-"+periodo).html('');
				$("#N-"+periodo).val('');
				$("#P-"+periodo).val('');
				$("#D-"+periodo).val('');
				$("#V-"+periodo).val('');	
				//$("#inputFieldpo").focus();
  			}
 		});
	
	return false;
	 
}



function ExportarExcel(id,idestretegico){
	    var idplan = id;
	    //var href = "?planesoperativo/exportexcel&IDPlan="+idplan+"&IDPlanE="+idestretegico;
	    
	    //var url = "http://redanahuac.mx/app/planeacion/?execute=planesoperativo/exportexcel&IDPlan="+idplan+"&IDPlanE="+idestretegico;
	
	  
	    var url = "http://redanahuac.mx/app/planeacionv2/controllers/planesoperativo/exportresp/exportexcel.class.php?&IDPlan="+idplan+"&IDPlanE="+idestretegico;
        
		var myWindow = window.open(url,'_blank');
		//window.parent.opener.focus();
		myWindow.opener.document.focus();
		
		//var caracteristicas = "height=300,width=830,scrollTo,resizable=1,scrollbars=1,location=0";
      	//var myWindow=window.open(url, 'Popup', caracteristicas);
		

      	
      	//var myWindow=window.open('','','width=200,height=100');
      	
      	 	myWindow.document.write('html to write...');
      	
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
	
	