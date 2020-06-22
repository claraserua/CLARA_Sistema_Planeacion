

var arraylineas_objetivos = new Array();

var lineas_objetivos_medios = new Array();

var lineas_objetivos_evidencias = new Array();


var array_areas = new Array();

var array_fortalezas = new Array();



$(function(){

	$('#myTablab a:first').tab('show');
	$('#myTablab a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	});
	
	inicializarInputsIndicadores();

	
	//iOS / iPhone style toggle switch
	//$('.iphone-toggle').iphoneStyle();
	
	/*$('.iphone-toggle').iphoneStyle({
  checkedLabel: 'SI',
  uncheckedLabel: 'NO'
});*/

$( ".sortable" ).sortable({
      placeholder: "ui-state-highlight",
	  scroll: true,
	  scrollSensitivity: 100, scrollSpeed: 100,
	  start: function( event, ui ) {    
	  ui.placeholder.height(ui.item.height());
	  //$( this ).find(".wellstrong").removeClass( "wellstrong" ).addClass( "wellstronglight" );
	  },
	  beforeStop: function( event, ui ) { 
	  //$( this ).find(".wellstronglight").removeClass( "wellstronglight" ).addClass( "wellstrong" );
	  
	  
	  
      var idsInOrder = $(this).sortable("toArray");
	  
	  var idsorder = idsInOrder.toString();
	  
	  idsorder = idsorder.replace(",,",",");
	  
	  OrdenarResultados(idsorder);
	  
	  },
	  revert: true
    });
    
    $( ".sortable" ).disableSelection();

    $('.sortable').sortable('disable'); 
	
	$('.iphone-toggle').iphoneStyle({
		
		onChange: function(elem, data) {
			//alert(elem.attr('id')); 
			//alert(data);
         if(data){
		 	 $(".sortable").sortable("enable"); 
         }else{
		    $('.sortable').sortable('disable'); 
		
	    }
			}
	
	});
	
	$('#myTab a:first').tab('show');
	$('#myTab a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	});
	
	
	$('[rel="popover"],[data-rel="popover"]').popover();
	
	
	
	
	
	
	
	
	
	/*$( ".wellstrong" ).draggable({ containment: "parent", scroll: true, cursor: 'move' });/*
	
	/*
	$(".wellstrong").draggable({
				grid: [200, 50],
				  
			});*/
	
	
 	
});//End function jquery


/*
$('.fullcombo').live('click', function() {
       alert(this.id); 
    });
*/




     function OrdenarResultados(idResultados){
	 
	 idResultados =  idResultados;
	 var idPlanO = gup('IDPlan');
	
	 $.ajax({ 	 	 
    type: "POST",  
    url: "?execute=planesoperativo/addobjetivos&method=OrdenarResultados",  
    data: { idResultados:idResultados,idPlanO:idPlanO},  
    success: function(msg){

    	if(!__validasesion(msg)){

      	    _openlogin();

      }else{

			   $.growlUI('Resultados', 'Ordenados correctamente!');
			}
          
    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });


	}
	
	//	LABEL-L1-O1
	//	LABEL-L1-O11
	var __last_id_created=0;
	function newID(prefijo){
		for(__last_id_created=999; __last_id_created>0; __last_id_created--){
			var new_id = prefijo + __last_id_created;
			
			//alert(new_id);
			if($('#'+new_id).length){
				__last_id_created++;
				return __last_id_created;
			}
		}
		return -1;
	}
	
    function AgregarResultado(contline,id,pklinea,pos){
	
	 var explode = id.split('-'); 
	 var linea = explode[1];
	 var lineaid = parseInt(linea.substring(1,linea.length));
	 if(console)console.log('lineaid='+lineaid);
	 
	 var aux = newID('LABEL-L'+contline+'-O');
	 if(aux==-1) aux=1;
	 var label_id   = 'LABEL-L'+contline+'-O'+aux;	
	 var label_html = contline+'.'+aux;
	
	var resultado = '<li id="RESULTADO"> <!--====================OBJETIVO=====================--> ';
          
		 resultado += ' <div class="wellstrong" id="RE-NONE">';
                   
         resultado += '<table width="100%">';
	     resultado += '<tbody><tr>';
	     resultado += '<td colspan="2"><b><font size="2">Objetivo Estratégico:</font></b>';
	     resultado += '<select class="fullcombo" id="OE-NONE" style="width: 100%;  tabindex="0">';
         resultado += '</select></td>';
	  
	     resultado += '</tr>';
		//Indicadores Inicio
		resultado += '<tr>';
		resultado += '<td colspan="2">';
		resultado += '</br>';
		resultado += '<div class="box-icon">';
		resultado += '<a href="javascript:void(0)" onclick="Toogle(this.id,this);" class="btn btn-minimize btn-round" id="TOGME2">'
		resultado += '<i class="icon-chevron-down"></i> Indicadores-Metas 2024 (objetivo estratégico)</a>';				
		resultado += '</br>';
		resultado += '</div>';
		resultado += '<div class="box-objectivos" id="BOXME2" style="display: none;"><div class="well">';
		resultado += '<p>Seleccione un Objetivo Estratégico</p>';


		resultado += '</div></div>';
		resultado += '</td>';
	   	resultado += '</tr>';
	  	//Indicadores Fin
	  
	     resultado += '<tr>';
         resultado += '<td><b><font size="2">Resultado :</font></b></td>';
         resultado += '<td><b><font size="2"> Responsable:</font></b></td>';
         resultado += '</tr>';
                    
         resultado += '<tr>';
         resultado += '<td width="70%">';  
		 resultado += '<div class="input-prepend">';
		 resultado += '<span class="add-on" id="'+label_id+'">'+label_html+'</span>';
		 resultado += '<textarea name="resultado" style="width: 90%;" id="IRES-NONE" class="objetivo"></textarea>';
		   
		 resultado += '</div>';
         resultado += '</td>';
      
         resultado += '<td width="30%">';
         resultado += '<select id="RRES-NONE" style="width:100%;">';
         resultado += '</select></td>';
         resultado += '</tr>';
         resultado += '</tbody></table>';
           
	     resultado += '<div class="box-icon">';
         resultado += '<a href="javascript:void(0)" onclick="Toogle(this.id,this);" class="btn btn-minimize btn-round" id="TOGME"><i class="icon-chevron-down"></i> Medios, Evidencias e Indicadores-Metas (anuales)</a>';				
         resultado += '</div>';
		   
		 resultado += '<div class="box-objectivos" id="BOXME" style="display: none;">';
		 
         resultado += '<div class="well"><h2>Medios</h2>';
         resultado += '<ul id="MEDIOS-NONE" style="list-style-type: none;"></ul>';
         resultado += '<button class="btn btn-small" id="BAM-NONE"  onclick="AgregarMedio(this.id);"><i class="icon-plus"></i>Agregar Medio</button>';
         resultado += '</div>';
                                                                 
         resultado += '<div class="well"> <h2>Evidencias</h2>';
         resultado += '<ul id="EVIDENCIAS-NONE" style="list-style-type: none;"></ul>';
         resultado += '<button class="btn btn-small" id="BAE-NONE"  onclick="AgregarEvidencia(this.id);"><i class="icon-plus"></i>Agregar Evidencia</button>	';
		 resultado += '</div> ';
		 
		 resultado += '<div class="well"> <h2>Indicadores-Metas</h2>';
         resultado += '<ul id="INDICADORESME-NONE" style="list-style-type: none;"></ul>';
         resultado += '<button class="btn btn-small" id="BAI-NONE"  onclick="AgregarIndicadorMeta(this.id);"><i class="icon-plus"></i>Agregar Indicador</button>	';
		 resultado += '</div> ';
		  		
		  
		 resultado += '</div>';
				
         resultado += '<div style="height:30px;">';
		 resultado += '<div style="float:right;">';
		 resultado += '<button class="btn-danger btn-large" id="DELETE-NONE"><span class="icon icon-white icon-close"></span> Eliminar</button> ';
		 resultado += '<button class="btn-success btn-large" id="SAVE-NONE"><span class="icon icon-white icon-save"></span> Guardar</button> ';
		 resultado += '</div>';
		 resultado += '</div>';
          
         resultado += '</div>';
         resultado += '<!--====================END OBJETIVO=====================--></li>';
	
	
	if(pos==0){
		$("#SORT-"+lineaid).prepend(resultado);
	}else{
		$("#SORT-"+lineaid).append(resultado);
	}
	
	
	InsertResultado(pklinea,lineaid,contline,aux);
	
	
}
function getAndDelIndicadoresByObj(idResultado, obj){

	var valObj = $(obj).val();
	var resultado; 
	var numeroObjetivo = $(obj).children("option:selected").text();
	numeroObjetivo = numeroObjetivo.substring(0, 3);
	//console.log("idResultado"+ idResultado+ ","+valObj);
	var indi  = "";
	if(valObj != "0"){
		$.ajax({ 	 	 
			type: "POST",  
			url: "index.php?execute=planesoperativo/addobjetivos&method=getAndDelIndicadoresByObj",  
			data: { idResultado:idResultado,idObjetivo:valObj,numeroObjetivo:numeroObjetivo},  
			success: function(msg){
				$('#BOXMEDIO-'+idResultado+'I').find('div').html('');
				
				indi=msg;
				
				$('#BOXMEDIO-'+idResultado+'I').find('div').html(indi);
				inicializarInputsIndicadores();
				updateResultado(idResultado);


			},error: function (jqXHR, exception) {
					console.log("Hubo un error revise su conexión de internet e intentelo de nuevo.",exception);
				}
		
				});
	}else{
		indi +='<p>Selecciona un objetivo estratégico.</p>';
		$('#BOXMEDIO-'+idResultado+'I').find('div').html(indi);
	}

}

    function updateResultado(id){
	
	var idPlanO = gup('IDPlan');
	idResultado = id;
	resultado = $("#IRES-"+id).val();
	objetivo = $("#OE-"+id).val();
	responsable = $("#RRES-"+id).val();

	var indicadores = "";
	$( "[id*='IND-"+id+"']:checked" ).each ( function () {
		//console.log("indicadores", $( this ));
		var objI = $( this ).val();
		indicadores += objI + ',';
	} );
	indicadores = indicadores.substring(0, indicadores.length - 1);	
	console.log("indicadores",indicadores);
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=updateResultado",  
    data: { idPlanO:idPlanO,idResultado:idResultado,resultado:resultado,objetivo:objetivo,responsable:responsable,indicadores:indicadores},  
    success: function(msg){
    	if(!__validasesion(msg)){

      	    _openlogin();

      }else{

			   $.growlUI('Resultado', 'Guardado con exito!');
          }
    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        }
           });
	
	
	}



    function deleteResultado(id){
	
	var idPlanO = gup('IDPlan');
	idResultado = id;
	
	 var flagdelete = confirm("¿Confirma eliminar el resultado?");
	  
	 if(flagdelete)
	  	
	  
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=deleteResultado",  
    data: { idPlanO:idPlanO,idResultado:idResultado},  
    success: function(msg){
    	if(!__validasesion(msg)){

      	    _openlogin();

      }else{
              $( "#"+id ).slideUp( "slow", function() {
			   //$.growlUI('Resultado', 'Eliminado con exito!');		   
			   $( "#"+id ).remove();
           });	
          }

    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });	
	
	
	}

	
	function InsertResultado(pklinea,lineaid,contlinea,contres){
	
	var idPlanO = gup('IDPlan');
	var idPlanE = gup('IDPlanE');
	var idLinea =  pklinea;	
	
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=InsertarResultado",  
    data: { idPlanO:idPlanO,idPlanE:idPlanE,idLinea:idLinea},  
    success: function(id){ 

    	if(!__validasesion(id)){

      	    _openlogin();

      }else{

    id = id.trim();
	  
	 
	  
	  $("#RESULTADO").attr("id",id);
	  $("#RE-NONE").attr("id","RE-"+id);
	  
	  $('#OE-NONE').attr('onchange', 'getAndDelIndicadoresByObj(\''+id+'\',this)');
	  $("#OE-NONE").attr("id","OE-"+id);
	  
	  $('#IRES-NONE').attr('onblur', 'updateResultado(\''+id+'\')');
	  $("#IRES-NONE").attr("id","IRES-"+id);
	  
	  
	  $('#RRES-NONE').attr('onchange', 'updateResultado(\''+id+'\')');
	  $("#RRES-NONE").attr("id","RRES-"+id);
	  
	  $("#BOXME").attr("id","BOXMEDIO-"+id);
	  $("#BOXME2").attr("id","BOXMEDIO-"+id+"I");

	  $("#MEDIOS-NONE").attr("id","MEDIOS-"+id);
	  $("#EVIDENCIAS-NONE").attr("id","EVIDENCIAS-"+id);
	  $("#INDICADORESME-NONE").attr("id","INDICADORESME-"+id);
	  
	  $('#TOGME').attr('onclick', 'Toogle(\''+id+'\',this)');
	  $("#TOGME").attr("id","TOG-"+id);

	  $('#TOGME2').attr('onclick', 'Toogle(\''+id+'I\',this)');
	  $("#TOGME2").attr("id","TOG-"+id+'I');	  
	  
	  $('#BAM-NONE').attr('onclick', 'AgregarMedio(\''+id+'\','+contlinea+','+contres+')');
	  $("#BAM-NONE").attr("id","BAM-"+id);
	  
	  $('#BAE-NONE').attr('onclick', 'AgregarEvidencia(\''+id+'\','+contlinea+','+contres+')');
	  $("#BAE-NONE").attr("id","BAE-"+id);

	  $('#BAI-NONE').attr('onclick', 'AgregarIndicadorMeta(\''+id+'\','+contlinea+','+contres+')');
	  $("#BAI-NONE").attr("id","BAI-"+id);
	  
	  
	 $('#SAVE-NONE').attr('onclick', 'updateResultado(\''+id+'\')');
	 $('#DELETE-NONE').attr('onclick', 'deleteResultado(\''+id+'\')');
	 
	 $("#DELETE-NONE").attr("id","DELETE-"+id);
	 $("#SAVE-NONE").attr("id","SAVE-"+id);
	 
	  getObjetivosEstrategicos(id,idLinea,lineaid);
	  
	  //$.growlUI('Resultado', 'Agregado con exito!');
	}
      
    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });		
	}
	
	
	function getObjetivosEstrategicos(id,pklinea,lineaid){
	
	
	var idLinea =  pklinea;
	var lineaid = lineaid;
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=getObjetivosEstrategicos",  
    data: { idLinea:idLinea,lineaid:lineaid},  
    success: function(msg){  
	 
	  $("#OE-"+id).html(msg);
	  getResponsables(id);
	  
    } 
           });

	}
	
	
	function getResponsables(id){
	
	//RRES-NONE
	var idPlanO = gup('IDPlan');
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=getResponsables",  
    data: { idPlanO:idPlanO},  
    success: function(msg){  
	
	  
	  var combo = '<option value="ALL"></option>'+msg;
	  $("#RRES-"+id).html(combo);
	  
    } 
           });
	
	}
	
	
	function getResponsablesMedios(id){
	
	//RRES-NONE
	var idPlanO = gup('IDPlan');
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=getResponsables",  
    data: { idPlanO:idPlanO},  
    success: function(msg){  
	
	  var combo = '<option value="ALL"></option>'+msg;
	  $("#RMEDIO-"+id).html(combo);
	  
    } 
           });
	
	}

	



function AgregarMedio(id,contline,contres){
	
	 var aux = newID('LABEL-L'+contline+'-O'+contres+'-M');
	 if(aux==-1) aux=1;
	 var label_id   = 'LABEL-L'+contline+'-O'+contres+'-M'+aux;	
	 var label_html = contline+'.'+contres+'.'+aux;
	
	
	
	var medio = '<li id="MEDIO"> <!--====================MEDIO=====================--> ';
          
		 medio += '<div class="wellstrong">';
                   
         medio += '<table width="100%">';
	       
         medio += '<tbody><tr>';
         medio += '<td width="2%">&nbsp;	</td>';
         medio += '<td width="70%"><b><font size="2">Medio:</font></b></td>';
         medio += '<td width="28%"><b><font size="2">Responsable:</font></b></td>';
         medio += '</tr> <tr>';
         medio += '<td>&nbsp; </td>';
         medio += '<td>';
         medio += '<div class="input-prepend">';
		 medio += '<span class="add-on" id="'+label_id+'">'+label_html+'</span>';
		 
      
		
		 medio += '<textarea name="medio" style="width: 86%;" id="MTEXT" class="medio"></textarea>';
		
		 medio += '</div>';
         medio += '</td>';                         
         medio += '<td>';
		 medio += '<select id="RMEDIO">';
		
		
		 medio += '</select></td>';
         medio += '</tr> <tr>';
         medio += '<td colspan="3">';
         medio += '<div class="right" style="margin-right:30px;">';         
         medio += '<button class="btn btn-small"  id="DELETE-MEDIO"  style="float:left; margin-right:10px;"><i class="icon icon-remove"></i> Eliminar medio</button>';
                    
		
         medio += '<button class="btn btn-small"  id="SAVE-MEDIO"><i class="icon icon-save"></i>Salvar Medio</button>';				
		 medio += '</div>';         
         medio += '</td>';
         medio += '</tr>';
         medio += '</tbody></table>';
         medio += '</div>';
                      
          
         medio += '</div>';
         medio += '<!--====================END MEDIO=====================--></li>';
	
	
	
	$("#MEDIOS-"+id).append(medio);
	
	InsertMedio(id);
	
	
}


function updateMedio(id){
	
	var idPlanO = gup('IDPlan');
	idMedio = id;
	medio = $("#MTEXT-"+id).val();
	responsable = $("#RMEDIO-"+id).val();
	
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=updateMedio",  
    data: { idPlanO:idPlanO,idMedio:idMedio,medio:medio,responsable:responsable},  
    success: function(msg){
    
               if(!__validasesion(msg)){

      	    _openlogin();

      }else{
			   $.growlUI('Medio', 'Guardado con exito!');
			}
          
    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });
	}


function EliminarMedio(id){
	
	
	var idPlanO = gup('IDPlan');
	idMedio = id;
	
	var flagdelete = confirm("¿Confirma eliminar el medio?");
	  
	 if(flagdelete)
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=deleteMedio",  
    data: { idMedio:idMedio,idPlanO:idPlanO},  
    success: function(msg){

    	if(!__validasesion(msg)){

      	    _openlogin();

      }else{

            $( "#"+id ).slideUp( "slow", function() {
              // Animation complete.
			  
			   //$.growlUI('Medio', 'Eliminado con exito!');
			    $( "#"+id ).remove();
			   
			   
           });	
        }

    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });	
	
	}



function InsertMedio(idResultado){
	
	
	var idPlanO = gup('IDPlan');
	var idPlanE = gup('IDPlanE');
	var idResultado =  idResultado;
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=InsertarMedio",  
    data: { idPlanO:idPlanO,idPlanE:idPlanE,idResultado:idResultado},  
    success: function(id){ 

    	if(!__validasesion(id)){

      	    _openlogin();

      }else{
   
      id = id.trim();
	  
	  $("#MEDIO").attr("id",id);
	  
	  $("#MTEXT").attr('onblur','updateMedio(\''+id+'\')');
	  $("#MTEXT").attr("id","MTEXT-"+id);
	  
	  $("#RMEDIO").attr('onchange','updateMedio(\''+id+'\')');
	  $("#RMEDIO").attr("id","RMEDIO-"+id);
	  
	  
	 $('#SAVE-MEDIO').attr('onclick', 'updateMedio(\''+id+'\')');
	 $("#SAVE-MEDIO").attr("id","SAVE-MEDIO-"+id);
	 
	 $('#DELETE-MEDIO').attr('onclick', 'EliminarMedio(\''+id+'\')');
	 $("#DELETE-MEDIO").attr("id","DELETE-MEDIO-"+id);
	 
	 getResponsablesMedios(id);

	}
	 
	  
	  //$.growlUI('Medio', 'Agregado con exito al Resultado!');
      
    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });		
	}

		/****----------Indicadores Operativos Metas ****/
		function AgregarIndicadorMeta(id,contline,contres){
	
			var aux = newID('LABEL-L'+contline+'-O'+contres+'-IM');
			if(aux==-1) aux=1;
			var label_id   = 'LABEL-L'+contline+'-O'+contres+'-IM'+aux;	
			var label_html = contline+'.'+contres+'.'+aux;
		   
		   
		   
		   var indicadorMeta = '<li id="INDICADORMETA"> <!--====================Indicador Operativo META=====================--> ';
				 
				indicadorMeta += '<div class="wellstrong">';
						  
				indicadorMeta += '<table width="100%">';
				  
				indicadorMeta += '<tbody><tr>';
				indicadorMeta += '<td width="2%">&nbsp;	</td>';
				indicadorMeta += '<td width="60%"><b><font size="2">Indicador Anual:</font></b></td>';
				indicadorMeta += '<td width="38%"><b><font size="2">Meta Anual:</font></b></td>';
				indicadorMeta += '</tr> <tr>';
				indicadorMeta += '<td>&nbsp; </td>';
				indicadorMeta += '<td>';
				indicadorMeta += '<div class="input-prepend">';
				indicadorMeta += '<span class="add-on" id="'+label_id+'">'+label_html+'</span>';
				
			 
			   
				indicadorMeta += '<textarea name="indicadorMetaText" style="width: 86%;" id="INDICAMETATEXT" class="medio"></textarea>';
			   
				indicadorMeta += '</div>';
				indicadorMeta += '</td>';                         
				indicadorMeta += '<td>';
				indicadorMeta += '<textarea name="indicadorMetaMeta" style="width: 86%;" id="INDICAMETAMETA" class="medio"></textarea>';
				indicadorMeta += '</tr> <tr>';
				indicadorMeta += '<td colspan="3">';
				indicadorMeta += '<div class="right" style="margin-right:30px;">';         
				indicadorMeta += '<button class="btn btn-small"  id="DELETE-INDICAMETA"  style="float:left; margin-right:10px;"><i class="icon icon-remove"></i> Eliminar Indicador</button>';
						   
			   
				indicadorMeta += '<button class="btn btn-small"  id="SAVE-INDICAMETA"><i class="icon icon-save"></i>Salvar Indicador</button>';				
				indicadorMeta += '</div>';         
				indicadorMeta += '</td>';
				indicadorMeta += '</tr>';
				indicadorMeta += '</tbody></table>';
				indicadorMeta += '</div>';
							 
				 
				indicadorMeta += '</div>';
				indicadorMeta += '<!--====================END Indicador Operativo Meta=====================--></li>';
		   
		   
		   
		   $("#INDICADORESME-"+id).append(indicadorMeta);
		   
		   InsertIndicadorMeta(id);
		   
		   
	   }
	   
	   
	   function updateIndicadorMeta(id){
		   
		   var idPlanO = gup('IDPlan');
		   idIndicadorM = id;
		   indicadorMeta = $("#INDICAMETATEXT-"+id).val();
		   meta = $("#INDICAMETAMETA-"+id).val();
	
		   //console.log("idIndicadorM",idIndicadorM);
		   //console.log("indicadorMeta",indicadorMeta);
		   //console.log("meta",meta);
			var numOrden = $("#INDICAMETATEXT-"+id).prev().attr("id");
			numOrden = numOrden.substr(numOrden.length - 1);
		   $.ajax({ 	 	 
		   type: "POST",  
		   url: "index.php?execute=planesoperativo/addobjetivos&method=updateIndicadorMeta",  
		   data: { idPlanO:idPlanO,idIndicadorM:idIndicadorM,indicadorMeta:indicadorMeta,meta:meta,numOrden:numOrden},  
		   success: function(msg){
		   
					  if(!__validasesion(msg)){
	   
					 _openlogin();
	   
			 }else{
					  $.growlUI('Indicador', 'Guardado con exito!');
				   }
				 
		   },error: function (jqXHR, exception) {
				   alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
			   } 
				  });
		   }
	   
	   
	   function EliminarIndicadorMeta(id){
		   
		   
		   var idPlanO = gup('IDPlan');
		   idIndicadorM = id;
		   
		   var flagdelete = confirm("¿Confirma eliminar el indicador?");
			 
			if(flagdelete)
		   
		   $.ajax({ 	 	 
		   type: "POST",  
		   url: "index.php?execute=planesoperativo/addobjetivos&method=deleteIndicadorMeta",  
		   data: { idIndicadorM:idIndicadorM,idPlanO:idPlanO},  
		   success: function(msg){
	   
			   if(!__validasesion(msg)){
	   
					 _openlogin();
	   
			 }else{
	   
				   $( "#"+id ).slideUp( "slow", function() {
					 // Animation complete.
					 
					  //$.growlUI('Medio', 'Eliminado con exito!');
					   $( "#"+id ).remove();
					  
					  
				  });	
			   }
	   
		   },error: function (jqXHR, exception) {
				   alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
			   }
				  });	
		   
		   }
	   
	   
	   
	   function InsertIndicadorMeta(idResultado){
		   
		   
		   var idPlanO = gup('IDPlan');
		   var idPlanE = gup('IDPlanE');
		   var idResultado =  idResultado;
		   
		   $.ajax({ 	 	 
		   type: "POST",  
		   url: "index.php?execute=planesoperativo/addobjetivos&method=InsertarIndicadorMeta",  
		   data: { idPlanO:idPlanO,idPlanE:idPlanE,idResultado:idResultado},  
		   success: function(id){ 
	   
			console.log(id);
			   if(!__validasesion(id)){
	   
					 _openlogin();
	   
			 }else{
		  
			id = id.trim();
			
			$("#INDICADORMETA").attr("id",id);
			
			$("#INDICAMETATEXT").attr('onblur','updateIndicadorMeta(\''+id+'\')');
			$("#INDICAMETATEXT").attr("id","INDICAMETATEXT-"+id);
			
			$("#INDICAMETAMETA").attr('onblur','updateIndicadorMeta(\''+id+'\')');
			$("#INDICAMETAMETA").attr("id","INDICAMETAMETA-"+id);
			 
			 
			$('#SAVE-INDICAMETA').attr('onclick', 'updateIndicadorMeta(\''+id+'\')');
			$("#SAVE-INDICAMETA").attr("id","SAVE-INDICAMETA-"+id);
			
			$('#DELETE-INDICAMETA').attr('onclick', 'EliminarIndicadorMeta(\''+id+'\')');
			$("#DELETE-INDICAMETA").attr("id","DELETE-INDICAMETA-"+id);
	
			 //$.growlUI('Medio', 'Agregado con exito al Resultado!');
		   }
			 
		   },error: function (jqXHR, exception) {
				   alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
			   } 
				  });		
		   }
	
	
	/*--------------EVIDENCIAS------------------------*/
	
	function AgregarEvidencia(id,contline,contres){
	
	
	 var aux = newID('LABEL-L'+contline+'-O'+contres+'-E');
	 if(aux==-1) aux=1;
	 var label_id   = 'LABEL-L'+contline+'-O'+contres+'-E'+aux;	
	 var label_html = contline+'.'+contres+'.'+aux;
	
	
	
	var evidencia = '<li id="EVIDENCIA"> <!--====================EVIDENCIA=====================--> ';
          
		 evidencia += '<div class="wellstrong">';
                   
         evidencia += '<table width="100%">';
	       
         evidencia += '<tbody><tr>';
         evidencia += '<td width="2%">&nbsp;	</td>';
         evidencia += '<td width="70%"><b><font size="2">Evidencia:</font></b></td>';
         evidencia += '</tr> <tr>';
         evidencia += '<td>&nbsp; </td>';
         evidencia += '<td>';
         evidencia += '<div class="input-prepend">';
		 evidencia += '<span class="add-on" id="'+label_id+'">'+label_html+'</span>';
        
		
		 evidencia += '<input type="text" name="evidencia" style="width: 90%;" id="ETEXT" class="evidencia"/>';
		
		 evidencia += '</div>';
         evidencia += '</td>';                         
         evidencia += '<td>';
		 
         evidencia += '</tr> <tr>';
         evidencia += '<td colspan="2">';
         evidencia += '<div class="right" style="margin-right:30px;">';         
         evidencia += '<button class="btn btn-small"  id="DELETE-EVIDENCIA"  style="float:left; margin-right:10px;"><i class="icon icon-remove"></i> Eliminar Evidencia</button>';
                    
		
         evidencia += '<button class="btn btn-small" id="SAVE-EVIDENCIA" ><i class="icon icon-save"></i>Salvar Eviencia</button>';				
		 evidencia += '</div>';         
         evidencia += '</td>';
         evidencia += '</tr>';
         evidencia += '</tbody></table>';
         evidencia += '</div>';
                      
          
         evidencia += '</div>';
         evidencia += '<!--====================END EVIDENCIA=====================--></li>';
	
	
	
	$("#EVIDENCIAS-"+id).append(evidencia);
	
	InsertEvidencia(id);
	
	
}


function updateEvidencia(id){
	var idPlanO = gup('IDPlan');
	idEvidencia = id;
	evidencia = $("#ETEXT-"+id).val();
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=updateEvidencia",  
    data: { idEvidencia:idEvidencia,evidencia:evidencia,idPlanO:idPlanO},  
    success: function(msg){
    
     if(!__validasesion(msg)){

      	    _openlogin();

      }else{
			   $.growlUI('Evidencia', 'Guardada con exito!');

			}
          
    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });
	}


function EliminarEvidencia(id){
	
	
	var idPlanO = gup('IDPlan');
	idEvidencia = id;
	var flagdelete = confirm("¿Confirma eliminar la evidencia?");
	  
	 if(flagdelete)
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=deleteEvidencia",  
    data: { idEvidencia:idEvidencia,idPlanO:idPlanO},  
    success: function(msg){


if(!__validasesion(msg)){

      	    _openlogin();

      }else{
            $( "#"+id ).slideUp( "slow", function() {
              // Animation complete.
			  
			  $( "#"+id ).remove();
           });	
        }

    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        }
           });	
	
	}



function InsertEvidencia(idResultado){
	
	
	var idPlanO = gup('IDPlan');
	var idPlanE = gup('IDPlanE');
	var idResultado =  idResultado;
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=InsertarEvidencia",  
    data: { idPlanO:idPlanO,idPlanE:idPlanE,idResultado:idResultado},  
    success: function(id){ 

    	if(!__validasesion(id)){

      	    _openlogin();

      }else{
      
      id = id.trim();
	  
	  $("#EVIDENCIA").attr("id",id);
	  
	  $("#ETEXT").attr('onblur', 'updateEvidencia(\''+id+'\')');
	  $("#ETEXT").attr("id","ETEXT-"+id);
	  
	  
	 $('#SAVE-EVIDENCIA').attr('onclick', 'updateEvidencia(\''+id+'\')');
	 $("#SAVE-EVIDENCIA").attr("id","SAVE-EVIDENCIA-"+id);
	 
	 
	 $('#DELETE-EVIDENCIA').attr('onclick', 'EliminarEvidencia(\''+id+'\')');
	 $("#DELETE-EVIDENCIA").attr("id","DELETE-EVIDENCIA-"+id);
	 
	 
	  
	  //$.growlUI('Evidencia', 'Agregada con exito al Resultado!');
	}
      
    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });		
	}
	
	
/*-------------END EVIDENCIAS -------------*/


function UpdateArea(id){
	
	var idPlanO = gup('IDPlan');
	idArea = id;
	area = $("#AREA-"+id).val();
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=updateArea",  
    data: { idArea:idArea,area:area,idPlanO:idPlanO},  
    success: function(msg){
    
      if(!__validasesion(msg)){

      	    _openlogin();

      }else{
			   $.growlUI('Debilidades', 'Guardada con exito!');
			}
          
    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });
	}


function EliminarArea(id){
	
	var idPlanO = gup('IDPlan');
	idArea = id;
	var flagdelete = confirm("¿Confirma eliminar la debilidad?");
	  
	if(flagdelete)
	
	$('#BEAREA-'+idArea).html('<img src="skins/default/img/ajax-loader.gif" />');
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=deleteArea",  
    data: { idArea:idArea,idPlanO:idPlanO},  
    success: function(msg){

    	if(!__validasesion(msg)){

      	    _openlogin();

      }else{
	
	 $( "#"+id ).remove();	

            /*$( "#"+id ).slideUp( "slow", function() {
              // Animation complete.
			  
			   //$.growlUI('Evidencia', 'Eliminada con exito!');
           });	*/
       }

    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });
	 
}



function UpdateFortaleza(id){
	
	var idPlanO = gup('IDPlan');
	idFortaleza = id;
	fortaleza = $("#FORTALEZA-"+id).val();
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=updateFortaleza",  
    data: { idFortaleza:idFortaleza,fortaleza:fortaleza,idPlanO:idPlanO},  
    success: function(msg){
	
	if(!__validasesion(msg)){

      	    _openlogin();

      }else{
               
               if(msg.trim()==1){
			     $.growlUI('Fortaleza', 'Guardada con exito!');	
			   }else{
			   	  
			   	  alert("Se ha producido un error intentelo nuevamente");
			   }
			}
			   
          
    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });
	}
	
	
	

function EliminarFortaleza(id){
	
	var idPlanO = gup('IDPlan');
	idFortaleza = id;
	
	var flagdelete = confirm("¿Confirma eliminar la Fortaleza?");
	  
    if(flagdelete)
	
	$('#BEFORTALEZA-'+idFortaleza).html('<img src="skins/default/img/ajax-loader.gif" />');
	
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=deleteFortaleza",  
    data: { idFortaleza:idFortaleza,idPlanO:idPlanO},  
    success: function(msg){

    	if(!__validasesion(msg)){

      	    _openlogin();

      }else{
	
	$( "#"+id ).remove();	

            /*$( "#"+id ).slideUp( "slow", function() {
              // Animation complete.
			   //$.growlUI('Evidencia', 'Eliminada con exito!');
           });	*/
       }

    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });
	 
}





function AgregarArea(){
	
	 var rowCount = $('#AREAST tr').length;
	 
	  var areas = '<tr id="IDAREA">';
          areas += '<td>&nbsp;</td>';       
          areas += '<td>';  
          areas += '<div class="input-prepend" style="margin-right:-50px;">';
		  areas += '<span class="add-on" id="LABEL-AREA">'+rowCount+'</span>';
          areas += '<input type="text" class="area" id="AREA-ID" style="width:85%;" >';
          
		  areas += '</div>'; 
          areas += '</td>';
          areas += '<td>';
          areas += '<button style="float:left; margin-right:10px;" id="BEAREA" class="btn btn-small"><i class="icon icon-remove"></i> </button>';
          
           areas += '<button id="BSAREA"  class="btn btn-small"><i class="icon icon-save"></i></button>';
          
          areas += '</td></tr>';
          
	 
	$("#AREAST").append(areas);
	
	InsertArea();

	
}


function InsertArea(){
	
	var idPlanO = gup('IDPlan');
	var idPlanE = gup('IDPlanE');
	
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=InsertarArea",  
    data: { idPlanO:idPlanO,idPlanE:idPlanE},  
    success: function(id){ 

    	if(!__validasesion(id)){

      	    _openlogin();

      }else{
      
      id = id.trim();
	  
	  $("#IDAREA").attr("id",id);
	  
	  $("#AREA-ID").attr('onblur', 'UpdateArea(\''+id+'\')');
	  $("#AREA-ID").attr("id","AREA-"+id);
	  
	  
	 $('#BSAREA').attr('onclick', 'UpdateArea(\''+id+'\')');
	 $("#BSAREA").attr("id","BSAREA-"+id);
	 
	 
	 $('#BEAREA').attr('onclick', 'EliminarArea(\''+id+'\')');
	 $("#BEAREA").attr("id","BEAREA-"+id);
	 
	 
	  
	  //$.growlUI('Evidencia', 'Agregada con exito al Resultado!');

	}
      
    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });		
	}








function AgregarFortaleza(){

 var rowCount = $('#FORTALEZAST tr').length;
	
	  var fortaleza = '<tr id="IDFORTALEZA">';
          fortaleza += '<td>&nbsp; </td>';      
          fortaleza += '<td>';  
          fortaleza += '<div class="input-prepend" style="margin-right:-50px;">';
		  fortaleza += '<span class="add-on"  id="LABEL-FORTALEZA">'+rowCount+'</span>';
          fortaleza += '<input type="text" id="FORTALEZA" class="fortaleza" style="width:85%;" >';
		  fortaleza += '</div>';
          fortaleza += '</td>';
          
          fortaleza += '<td>';
          
          fortaleza += '<button style="float:left; margin-right:10px;" id="BEFORTALEZA" class="btn btn-small"><i class="icon icon-remove"></i> </button>';
          
          fortaleza += '<button id="BSFORTALEZA"  class="btn btn-small"><i class="icon icon-save"></i></button></td></tr>';
          
          $("#FORTALEZAST").append(fortaleza);
	
	   InsertFortaleza();
	
}


function InsertFortaleza(){
	
	var idPlanO = gup('IDPlan');
	var idPlanE = gup('IDPlanE');
	
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=InsertarFortaleza",  
    data: { idPlanO:idPlanO,idPlanE:idPlanE},  
    success: function(id){ 

    	if(!__validasesion(id)){

      	    _openlogin();

      }else{
      
      id = id.trim();
	  
	  $("#IDFORTALEZA").attr("id",id);
	  
	  $("#FORTALEZA").attr('onblur', 'UpdateFortaleza(\''+id+'\')');
	  $("#FORTALEZA").attr("id","FORTALEZA-"+id);
	  
	  
	 $('#BSFORTALEZA').attr('onclick', 'UpdateFortaleza(\''+id+'\')');
	 $("#BSFORTALEZA").attr("id","BSFORTALEZA-"+id);
	 
	 
	 $('#BEFORTALEZA').attr('onclick', 'EliminarFortaleza(\''+id+'\')');
	 $("#BEFORTALEZA").attr("id","BEFORTALEZA-"+id);
	 
	 
	  
	  //$.growlUI('Evidencia', 'Agregada con exito al Resultado!');
	}
      
    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });		
	}


/*--------------AMENAZAS INICIO ------------------------*/
	
	
	
	

function UpdateDebilidades(id){//AMENAZAS
	
	var idPlanO = gup('IDPlan');
	idDebilidades = id;
	debilidades = $("#DEBILIDADES-"+id).val();
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=updateDebilidades",  
    data: { idDebilidades:idDebilidades,debilidades:debilidades,idPlanO:idPlanO},  
    success: function(msg){
	
	if(!__validasesion(msg)){

      	    _openlogin();

      }else{
               
               if(msg.trim()==1){
			     $.growlUI('Amenazas', 'Guardada con exito!');	
			   }else{
			   	  
			   	  alert("Se ha producido un error intentelo nuevamente");
			   }

			}
			   
          
    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });
	}
	
	
	

function EliminarDebilidades(id){//AMENAZAS
	
	var idPlanO = gup('IDPlan');
	idDebilidades = id;
	
	var flagdelete = confirm("¿Confirma eliminar la Amenaza?");
	  
    if(flagdelete)
	
	$('#BEDEBILIDADES-'+idDebilidades).html('<img src="skins/default/img/ajax-loader.gif" />');
	
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=deleteDebilidades",  
    data: { idDebilidades:idDebilidades,idPlanO:idPlanO},  
    success: function(msg){

    	if(!__validasesion(msg)){

      	    _openlogin();

      }else{
	
	$( "#"+id ).remove();	

            /*$( "#"+id ).slideUp( "slow", function() {
              // Animation complete.
			   //$.growlUI('Evidencia', 'Eliminada con exito!');
           });	*/
       }

    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });
	 
}
	
	
function AgregarDebilidades(){//AMENAZAS

 var rowCount = $('#DEBILIDADEST tr').length;
	
	  var debilidades = '<tr id="IDDEBILIDADES">';
          debilidades += '<td>&nbsp; </td>';      
          debilidades += '<td>';  
          debilidades += '<div class="input-prepend" style="margin-right:-50px;">';
		  debilidades += '<span class="add-on"  id="LABEL-DEBILIDADES">'+rowCount+'</span>';
          debilidades += '<input type="text" id="DEBILIDADES" class="debilidades" style="width:85%;" >';
		  debilidades += '</div>';
          debilidades += '</td>';
          
          debilidades += '<td>';
          
          debilidades += '<button style="float:left; margin-right:10px;" id="BEDEBILIDADES" class="btn btn-small"><i class="icon icon-remove"></i> </button>';
          
          debilidades += '<button id="BSDEBILIDADES"  class="btn btn-small"><i class="icon icon-save"></i></button></td></tr>';
          
          $("#DEBILIDADEST").append(debilidades);
	
	   InsertDebilidades();
	
}


function InsertDebilidades(){//AMENAZAS
	
	var idPlanO = gup('IDPlan');
	var idPlanE = gup('IDPlanE');
	
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=InsertarDebilidades",  
    data: { idPlanO:idPlanO,idPlanE:idPlanE},  
    success: function(id){ 

    	if(!__validasesion(id)){

      	    _openlogin();

      }else{
      
      id = id.trim();
	  
	  $("#IDDEBILIDADES").attr("id",id);
	  
	  $("#DEBILIDADES").attr('onblur', 'UpdateDebilidades(\''+id+'\')');
	  $("#DEBILIDADES").attr("id","DEBILIDADES-"+id);
	  
	  
	 $('#BSDEBILIDADES').attr('onclick', 'UpdateDebilidades(\''+id+'\')');
	 $("#BSDEBILIDADES").attr("id","BSDEBILIDADES-"+id);
	 
	 
	 $('#BEDEBILIDADES').attr('onclick', 'EliminarDebilidades(\''+id+'\')');
	 $("#BEDEBILIDADES").attr("id","BEDEBILIDADES-"+id);
	 
	 }
	 
	  
	  //$.growlUI('Evidencia', 'Agregada con exito al Resultado!');
      
    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });		
	}
	
	
	
	
	
	
	/*--------------AMENAZAS------------------------*/
	
	
	
	/*--------------OPORTUNIDADES INICIO ------------------------*/
	
	
	
	

function UpdateOportunidades(id){
	
	var idPlanO = gup('IDPlan');
	idOportunidades = id;
	oportunidades = $("#OPORTUNIDADES-"+id).val();
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=updateOportunidades",  
    data: { idOportunidades:idOportunidades,oportunidades:oportunidades,idPlanO:idPlanO},  
    success: function(msg){
	
	if(!__validasesion(msg)){

      	    _openlogin();

      }else{
               
               if(msg.trim()==1){
			     $.growlUI('Oportunidades', 'Guardada con exito!');	
			   }else{
			   	  
			   	  alert("Se ha producido un error intentelo nuevamente");
			   }

			}
			   
          
    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });
	}
	
	
	

function EliminarOportunidades(id){
	
	var idPlanO = gup('IDPlan');
	idOportunidades = id;
	
	var flagdelete = confirm("¿Confirma eliminar la Oportunidad?");
	  
    if(flagdelete)
	
	$('#BEOPORTUNIDADES-'+idOportunidades).html('<img src="skins/default/img/ajax-loader.gif" />');
	
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=deleteOportunidades",  
    data: { idOportunidades:idOportunidades,idPlanO:idPlanO},  
    success: function(msg){

    	if(!__validasesion(msg)){

      	    _openlogin();

      }else{
	
	$( "#"+id ).remove();	

            /*$( "#"+id ).slideUp( "slow", function() {
              // Animation complete.
			   //$.growlUI('Evidencia', 'Eliminada con exito!');
           });	*/
       }

    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });
	 
}
	
	
function AgregarOportunidades(){

 var rowCount = $('#OPORTUNIDADEST tr').length;
	
	  var oportunidades = '<tr id="IDOPORTUNIDADES">';
          oportunidades += '<td>&nbsp; </td>';      
          oportunidades += '<td>';  
          oportunidades += '<div class="input-prepend" style="margin-right:-50px;">';
		  oportunidades += '<span class="add-on"  id="LABEL-OPORTUNIDADES">'+rowCount+'</span>';
          oportunidades += '<input type="text" id="OPORTUNIDADES" class="oportunidades" style="width:85%;" >';
		  oportunidades += '</div>';
          oportunidades += '</td>';
          
          oportunidades += '<td>';
          
          oportunidades += '<button style="float:left; margin-right:10px;" id="BEOPORTUNIDADES" class="btn btn-small"><i class="icon icon-remove"></i> </button>';
          
          oportunidades += '<button id="BSOPORTUNIDADES"  class="btn btn-small"><i class="icon icon-save"></i></button></td></tr>';
          
          $("#OPORTUNIDADEST").append(oportunidades);
	
	   InsertOportunidades();
	
}


function InsertOportunidades(){
	
	var idPlanO = gup('IDPlan');
	var idPlanE = gup('IDPlanE');
	
	
	$.ajax({ 	 	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=InsertarOportunidades",  
    data: { idPlanO:idPlanO,idPlanE:idPlanE},  
    success: function(id){ 

    	if(!__validasesion(id)){

      	    _openlogin();

      }else{
      
      id = id.trim();
	  
	  $("#IDOPORTUNIDADES").attr("id",id);
	  
	  $("#OPORTUNIDADES").attr('onblur', 'UpdateOportunidades(\''+id+'\')');
	  $("#OPORTUNIDADES").attr("id","OPORTUNIDADES-"+id);
	  
	  
	 $('#BSOPORTUNIDADES').attr('onclick', 'UpdateOportunidades(\''+id+'\')');
	 $("#BSOPORTUNIDADES").attr("id","BSOPORTUNIDADES-"+id);
	 
	 
	 $('#BEOPORTUNIDADES').attr('onclick', 'EliminarOportunidades(\''+id+'\')');
	 $("#BEOPORTUNIDADES").attr("id","BEOPORTUNIDADES-"+id);
	 
	 }
	 
	  
	  //$.growlUI('Evidencia', 'Agregada con exito al Resultado!');
      
    },error: function (jqXHR, exception) {
            alert("Hubo un error revise su conexión de internet e intentelo de nuevo.");
        } 
           });		
	}
	
	
	
	
	
	
	/*--------------OPORTUNIDADES------------------------*/



function Salvar(){
	
	
	var objetivos = "";
	var lineas = "";
	var medios = "";
	var evidencias = "";
    var areas = "";
    var fortalezas = "";
		
	var contlinea = 1;
	var contobjetivo = 1;
	var contmedio = 1;
	var contevidencia = 1; 
	
	if(ValidarLLenado()){//SI EL FORMULARIO ESTA COMPLETAMENTE LLENO
		
	
	for(i=0;i<arraylineas_objetivos.length;i++){//OBTENEMOS LAS LINEAS
		
		value = $('#PK_LINEA_'+contlinea).val();
		lineas += value+"^";
		
	    for(j=0;j<lineas_objetivos_medios[contlinea-1].length;j++){//OBTENEMOS LOS OBJETIVOS TACTICOS
				
	
			      value = $('#L'+contlinea+'-O'+contobjetivo).val();
				  value = value.replace("|","");
				  value += "¬"+ $('#L'+contlinea+'-OE'+contobjetivo).val();
				  value += "¬"+ $('#L'+contlinea+'-OR'+contobjetivo).val();
		          objetivos += value+"^";
			     
				// alert(lineas_objetivos_medios[contlinea-1][contobjetivo-1].length); 
				 
				        for(k=0;k<lineas_objetivos_medios[contlinea-1][contobjetivo-1].length;k++){//OBTENEMOS LOS MEDIOS
							    value = $('#L'+contlinea+'-O'+contobjetivo+'-M'+contmedio).val();
								value = value.replace("|","");
								value += "¬"+ $('#L'+contlinea+'-O'+contobjetivo+'-M'+contmedio+'-R'+contmedio).val();
								medios += value+"^";
								contmedio++;
							}
							medios += "~";
							contmedio = 1;
				  
				        for(k=0;k<lineas_objetivos_evidencias[contlinea-1][contobjetivo-1].length;k++){//OBTENEMOS LAS EVIDENCIAS
							    value = $('#L'+contlinea+'-O'+contobjetivo+'-E'+contevidencia).val();
								value = value.replace("|","");
								evidencias += value+"^";
								contevidencia++;
							}
							evidencias += "~";
							contevidencia = 1;
				  
				  contobjetivo++;
				 
			}
			evidencias += "|";
			medios += "|";
			objetivos += "|";
			contobjetivo  =1;
		    
		
		    contlinea++;
		
		
		}//END OBTENEMOS LINEAS
        
        
         for(k=1;k<=array_areas.length;k++){//OBTENEMOS LAS AREAS DE OPORTUNIDAD
							    value = $('#INPUT-AREA-'+k).val();
								areas += value+"¬";
							}
                            
                            
          for(k=1;k<=array_fortalezas.length;k++){//OBTENEMOS LAS FORTALEZAS
							    value = $('#INPUT-FORTALEZA-'+k).val();
								fortalezas += value+"¬";
							}
	
	
	 
	 GuardarObjetivos(lineas,objetivos,medios,evidencias,areas,fortalezas);
	 
	 }else{
	 	
		 $('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-block");
				$("#headAlerta").html("¡Advertencia!");
				$("#bodyAlerta").html("Debe de llenar todos los campos, puede eliminar objetivos, medios y/o evidencias"); 
	 	
	 }
		
	 }
	
	
function GuardarObjetivos(lineas,objetivos,medios,evidencias,areas,fortalezas){
	
	
	var idPlanOperativo = gup('IDPlan');
	var idPlanE = gup('IDPlanE');
	var estado = "G";
	
	//var resumen = encodeURIComponent(resumenEditor.getData());
	 $.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
	
	$.ajax({ 
	 
	 // type: "POST",
     //data: { name: "John", location: "Boston" }
	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addobjetivos&method=GuardarObjetivos",  
    data: { lineas: lineas, objetivos: objetivos, medios : medios, evidencias:evidencias, idPlanOperativo:idPlanOperativo,areas:areas,fortalezas:fortalezas,estado:estado,idPlanE:idPlanE},  
    success: function(msg){  
	
      
	  $.unblockUI();
	 
	 if(msg.trim()==""){
	   
	  $('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha guardado con exito el plan"); 
      
               }else{
			   	
				$('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-error");
				$("#headAlerta").html("<font size=\"3\">¡Ups! ha ocurrido un Error</font>");
				$("#bodyAlerta").html("<strong>No te alarmes</strong>!! al parecer no se ha guardado tu plan operativo correctamente, por favor intentalo guardar nuevamente."); 
	 
				}
      
	
               } 
   
           });
}
	
	
	/////////////////////////////GUARDAR PLAN OPERATIVO//////////////////////////
	
	function Salvar2(){
	
	
	var objetivos = "";
	var lineas = "";
	var medios = "";
	var evidencias = "";
    var areas = "";
    var fortalezas = "";
		
	var contlinea = 1;
	var contobjetivo = 1;
	var contmedio = 1;
	var contevidencia = 1; 
	
	if(ValidarLLenado()){//SI EL FORMULARIO ESTA COMPLETAMENTE LLENO
		
	
	for(i=0;i<arraylineas_objetivos.length;i++){//OBTENEMOS LAS LINEAS
		
		value = $('#PK_LINEA_'+contlinea).val();
		lineas += value+"^";
		
	    for(j=0;j<lineas_objetivos_medios[contlinea-1].length;j++){//OBTENEMOS LOS OBJETIVOS TACTICOS
				
	
			      value = $('#L'+contlinea+'-O'+contobjetivo).val();
				  value = value.replace("|","");
				  value += "¬"+ $('#L'+contlinea+'-OE'+contobjetivo).val();
				  value += "¬"+ $('#L'+contlinea+'-OR'+contobjetivo).val();
		          objetivos += value+"^";
			     
				// alert(lineas_objetivos_medios[contlinea-1][contobjetivo-1].length); 
				 
				        for(k=0;k<lineas_objetivos_medios[contlinea-1][contobjetivo-1].length;k++){//OBTENEMOS LOS MEDIOS
							    value = $('#L'+contlinea+'-O'+contobjetivo+'-M'+contmedio).val();
								 value = value.replace("|","");
								value += "¬"+ $('#L'+contlinea+'-O'+contobjetivo+'-M'+contmedio+'-R'+contmedio).val();
								medios += value+"^";
								contmedio++;
							}
							medios += "~";
							contmedio = 1;
				  
				        for(k=0;k<lineas_objetivos_evidencias[contlinea-1][contobjetivo-1].length;k++){//OBTENEMOS LAS EVIDENCIAS
							    value = $('#L'+contlinea+'-O'+contobjetivo+'-E'+contevidencia).val();
								value = value.replace("|","");
								evidencias += value+"^";
								contevidencia++;
							}
							evidencias += "~";
							contevidencia = 1;
				  
				  contobjetivo++;
				 
			}
			evidencias += "|";
			medios += "|";
			objetivos += "|";
			contobjetivo  =1;
		    
		
		    contlinea++;
		
		
		}//END OBTENEMOS LINEAS
	
     for(k=1;k<=array_areas.length;k++){//OBTENEMOS LAS AREAS DE OPORTUNIDAD
							    value = $('#INPUT-AREA-'+k).val();
								areas += value+"¬";
							}
	
    
    for(k=1;k<=array_fortalezas.length;k++){//OBTENEMOS LAS FORTALEZAS
							    value = $('#INPUT-FORTALEZA-'+k).val();
								fortalezas += value+"¬";
							}
	
	 //alert(fortalezas);
	
	 GuardarObjetivos2(lineas,objetivos,medios,evidencias,areas,fortalezas);
	 
	 }else{
	 	
		 $('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-block");
				$("#headAlerta").html("¡Advertencia!");
				$("#bodyAlerta").html("Debe de llenar todos los campos, puede eliminar objetivos, medios y/o evidencias"); 
	 	
	 }
		
	 }
	
	
function GuardarObjetivos2(lineas,objetivos,medios,evidencias,areas,fortalezas){
	
	
	var idPlanOperativo = gup('IDPlan');
	var idPlanE = gup('IDPlanE');
	var resumen = "";
	var estado = "G";
	
	
	 $.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
	
	$.ajax({ 
	 
	 // type: "POST",
     //data: { name: "John", location: "Boston" }
	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/editobjetivos&method=GuardarObjetivos",  
    data: { lineas: lineas, objetivos: objetivos, medios : medios, evidencias:evidencias, idPlanOperativo:idPlanOperativo,areas:areas,fortalezas:fortalezas,estado:estado,idPlanE:idPlanE},  
    success: function(msg){  
	

	  $.unblockUI();
	    
	 if(msg.trim()==""){
	   
	  $('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha guardado con exito el plan"); 
      
	 // setTimeout("window.location.href = '?execute=principal&Menu=F1&SubMenu=SF4#&p=1&s=25&sort=1&q='",1000);
               }else{
			   	
				
				$('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-error");
				$("#headAlerta").html("<font size=\"3\">¡Ups! ha ocurrido un Error</font>");
				$("#bodyAlerta").html("<strong>No te alarmes</strong>!! al parecer no se ha guardado tu plan operativo correctamente, por favor intentalo guardar nuevamente."); 
	 
				
				}
      
	 // setTimeout("window.location.href = '?execute=principal&Menu=F1&SubMenu=SF4#&p=1&s=25&sort=1&q='",1000);
               } 
   
           });
}
	
	
	//////////////////////////////END GUARDAR PLAN OPERATIVO/////////////////////
	
	
	
	//////////////////////////////ENVIAR PLAN OPERATIVO/////////////////////
	function Enviar(confirm){
		 if(!confirm){
	 $('#titlemodal').html('Enviar plan operativo para revisión');
	 $('#bodymodal').html('¿Está seguro de enviar el plan para su revisión?  <br>Se guardarán todos los resultados y no podrán ser editados.');
	  $("#aceptarmodal").attr("onClick", "javascript:Enviar(true);return false;")
	 
     $('#myModal').modal('show');
	 }else{
	 $('#myModal').modal('hide');
	 
	  Salvar3();
		
	 }
		
	}
	
	
	//////////////////////GUARDAR Y ENVIAR PLAN OPERATIVO/////////
	
	function Salvar3(){
	
	var idPlanOperativo = gup('IDPlan');
	var idPlanE = gup('IDPlanE');
	
	
	
	 $.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
	
	$.ajax({ 
	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/editobjetivos&method=EnviarRevision",  
    data: { idPlanOperativo:idPlanOperativo,idPlanE:idPlanE},  
    success: function(msg){  
	
	//alert(msg);
                     
              
               $.unblockUI();
			   
			   if(msg.trim()==""){
	           setTimeout("window.location.href = '?execute=operativo&method=default&Menu=F2&SubMenu=SF6#&p=1&s=25&sort=1&q=&alert=2'",0);
               }else{
			   		
				$('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-error");
				$("#headAlerta").html("<font size=\"3\">¡Ups! ha ocurrido un Error</font>");
				$("#bodyAlerta").html("<strong>No te alarmes</strong>!! al parecer no se ha guardado o no se ha podido enviar tu plan operativo correctamente, por favor intenta enviarlo nuevamente."); 
	 
				}
			   		   
			   } 
   
           });
		
	 }
	
	
	
	function Omitir(){
		
		var idPlanOperativo = gup('IDPlan');
		
		$.ajax({ 
	 
    type: "POST",  
    url: "index.php?execute=operativo&method=Omitir",  
    data: { idPlanOperativo:idPlanOperativo},  
    success: function(msg){  

	//alert(msg);
	
	 $.unblockUI();
			   } 
   
           });
	
		
		
	}

	
	///////////////////END GUARDAR Y ENVIAR PLAN OPERATIVO////////////////
	
	
	function Toogle(id,obj){
	
		var local = id.split("-");
		//console.log(obj);
		var contenido = $(obj).text();
		if($('#BOXMEDIO-'+id).is(':visible')) $('#TOG-'+id).html('<i class="icon-chevron-down"></i>'+ contenido);
		else $('#TOG-'+id).html('<i class="icon-chevron-up"></i> '+ contenido);
		
		$('#BOXMEDIO-'+id).toggle();
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
	
	function inicializarInputsIndicadores(){
		$( "[id*='IND-']" ).click(function(){
			if(!$(this).is(':checked')){
				$(this).prop('checked', true);
				$(this).parent().parent().css("background-color","#ffffff");
			}else{
				$(this).prop('checked', false);
				$(this).parent().parent().css("background-color","#dd5600");
			}
			updateResultado($(this).attr("idobje"));
		});
		$( ".INDdiv" ).click(function(){
			if(!$(this).find("input").is(':checked')){
				$(this).find("input").prop('checked', true);
				$(this).css("background-color","#dd5600");
			}else{
				
				$(this).find("input").prop('checked', false);
				$(this).css("background-color","#ffffff");
			}
			updateResultado($(this).find("input").attr("idobje"));

		});
	}
	