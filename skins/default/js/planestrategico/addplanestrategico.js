

var nexilinea=1;
var arrayLineas = new Array();
arrayLineas.push(nexilinea);


var nexitem=1;
var arrayobjetivos = new Array();
arrayobjetivos.push(nexitem);


var arrayindicadores = new Array();





$(function(){
	  	  
		 
	$( "#finicio" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd' 
    });
	
	
	$( "#ftermino" ).datepicker({
      changeMonth: true,
      changeYear: true,
	    dateFormat: 'yy-mm-dd' 
    });	
	
	 
	//POST FRAME ADD IMAGE USER
	$('#frmaddplanese').iframePostForm
	({
		json : false,
		post : function ()
		{
			var message;
			
				
			if ($('#titulo').val().length && $('#finicio').val().length && $('#ftermino').val().length)
			{
				//GUARDANDO ARCHIVOS
					
				$('html, body').animate({scrollTop:0}, 'slow');
               $.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
				
			}else{
				
				$('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-block");
				$("#headAlerta").html("¡Advertencia!");
				$("#bodyAlerta").html("Debes de ingresar todos los campos obligatorios");
				
				return false;
			}
			
			
			
			
		},
		complete : function (response)
		{
			
			
	//alert(response);
			if (response.trim()=="false")
			{
			
				$('html, body').animate({scrollTop:0}, 10);
				$.unblockUI();
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-error");
				$("#headAlerta").html("!Error!");
				$("#bodyAlerta").html("Se ha producido un error al guardar los datos, intentelo nuevamente.");
				
				return false;
			}
			
			else
			{
				
				$.unblockUI();
				/*$('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha guardado el Plan Estratégico");*/
				
				
				//$("#frmaddusuarios")[0].reset();
				
				//$('#sel2').empty();
				
				//window.setTimeout("window.location.href='?execute=usuarios&Menu=F3&SubMenu=SF8#&p=1&s=25&sort=1&q='",1000)
	  var id = $('#idplan').val();
	  $('#titlemodal').html('El Plan Estratégico se ha guardado con exito');
	  $('#bodymodal').html('<strong>¿Desea agregar las lineas estratégicas y los objetivos a este plan?</strong>');
	  $("#aceptarmodal").attr("onClick", "javascript:AgregarLineas('"+id+"',true);return false;")
	  $("#cancelarmodal").attr("onClick", "javascript:AgregarLineas('"+id+"',false);return false;")
      $('#myModal').modal('show');
			 
			 
				return false;	
				
			}
		}
	});
	
		//END POST FRAME ADD IMAGE USER
	
	
	
$('#btnenviaform1').click(function() {
	
$('#frmaddplanese').submit();
});

$('#btnenviaform2').click(function() {

$('#frmaddplanese').submit();
});
	  
	  
	 	  

});//End function jquery




	


function EliminarObjetivo(id){

	idlinea = id.substring(1,id.length).toString();
	id = id.substring(2,id.length);
	id = parseInt(id);
	
	 if(arrayobjetivos[id].length==1){
	 	$('#OL'+id).attr('disabled','disabled');
		
	 }
	
	  objetivo = arrayobjetivos[id].length+1;
	  
	 
	  $("#"+idlinea+"-controlobjetivo"+objetivo).remove();
		
		
		arrayobjetivos[id].pop();
	}




function EliminarLinea(){
	
     if(arrayLineas.length==2){
	 	$('#btndeleteline').attr('disabled','disabled');
	 }
	id = arrayLineas.length;
	$("#linea"+id).remove();
	arrayLineas.pop();
	nexilinea--;
}



function agregarLinea(){
 var itemlinea = arrayLineas.length;
		
		//alert(arrayLineas.length)
		
		 $("#linea0").css("display","block");
		
		  var clon = $("#linea0").clone(false).insertAfter("#linea"+itemlinea);
		 
		  nexilinea++;
		  
		  arrayLineas.push(nexilinea);
		  arrayobjetivos[nexilinea]= new Array();
		  clon.attr('id','linea'+nexilinea);
		  clon.find('#linea0').attr('id','linea'+itemlinea);
		  clon.find('#legenda0').html(nexilinea+'. Línea Estratégica');
		  clon.find('#legenda0').attr('id','legenda'+nexilinea);
		  clon.find('#titulo0').attr('id','titulo'+nexilinea);
		  clon.find('#controlobjetivo0').attr('id','controlobjetivo'+nexilinea);
		  clon.find('#L0').attr('id','L'+nexilinea);
		  clon.find('#textobjetivo00').html(nexilinea+'.1');//nuevo 	
          clon.find('#textobjetivo00').attr('id','textobjetivo'+nexilinea+'1');//nuevo			  
		  clon.find('#L0-controlobjetivo1').attr('id','L'+nexilinea+'-controlobjetivo1');
		  clon.find('#L0-objetivo1').attr('id','L'+nexilinea+'-objetivo1');
		  clon.find('#OL0').attr('id','OL'+nexilinea); 		  
		  
		  
          clon.find('#TOGOE-L0-objetivo1').attr('onclick','ToogleOE('+nexilinea+',\'1\');');//nuevo	 
	      clon.find('#TOGOE-L0-objetivo1').attr('id','TOGOE'+'-L'+nexilinea+'-objetivo1');//nuevo
	      clon.find('#BOXOBJETIVOE-L0-objetivo1').attr('id','BOXOBJETIVOE'+'-L'+nexilinea+'-objetivo1');//nuevo
		  
		  arrayindicadores[nexilinea-1]= new Array();
		  arrayindicadores[nexilinea-1][0]= new Array();// *checar si va a nacer desde objetivo	y linea
		  arrayindicadores[nexilinea-1][0].push("1");//*checar si va a nacer desde objetivo,	es lo mismo  arrayindicadores[nexilinea-1][0][n]  		  
		  clon.find('#WL0-objetivo1-indicador1').attr('id',"WL"+nexilinea+"-objetivo1-indicador1");	
		  clon.find('#L0-controlobjetivo1-controlindicador1').attr('id',"L"+nexilinea+"-controlobjetivo1-controlindicador1");//*quitar		
          clon.find('#textindicador000').html(nexilinea+'.1.1');
          clon.find('#textindicador000').attr('id','textindicador'+nexilinea+'11');		
		  clon.find('#L0-objetivo1-indicador1').attr('id',"L"+nexilinea+"-objetivo1-indicador1"); 
		  clon.find('#L0-objetivo1-meta1').attr('id','L'+nexilinea+'-objetivo1-meta1');	//nuevo 
		  //botones	
		  clon.find('#EIL0-O1').attr('id',"EIL"+nexilinea+'-O1');	
		  clon.find('#AIL0-O1').attr('onclick','agregarIndice('+nexilinea+',\'1\');');
		  clon.find('#AIL0-O1').attr('id',"AIL"+nexilinea+'-O1');  
		  
		  		  
		
   	      $("#linea0").css("display","none");
		  
		  $('#btndeleteline').removeAttr("disabled");
		  
		  
		   
		 
		  
}


function agregarObjetivo(id){
	
	
	
	
	 r = id.substring(1,id.length);
	 arrayobjetivos[r].push(nexitem);
	 var itemobj = arrayobjetivos[r].length;  
	 nextitem= parseInt(itemobj)+parseInt(1);
 
     idlinea = r;
	 
     var clon = $("#L0-controlobjetivo1").clone(true).insertAfter("#"+id+"-controlobjetivo"+itemobj);

     clon.attr('id',id+"-controlobjetivo"+nextitem); 
	 //clon.find('#textobjetivo').html(nextitem);	  
	 clon.find('#textobjetivo00').html(idlinea+'.'+nextitem);//nuevo
     clon.find('#textobjetivo00').attr('id','textobjetivo'+idlinea+nextitem);//nuevo	 
	 clon.find('#L0-objetivo1').attr('id',id+'-objetivo'+nextitem);
	 
	 
	
	 //nuevo
	 clon.find('#TOGOE-L0-objetivo1').attr('onclick','ToogleOE('+idlinea+','+nextitem+');');//nuevo	 
	 clon.find('#TOGOE-L0-objetivo1').attr('id','TOGOE'+'-'+id+'-objetivo'+nextitem);//nuevo
	 clon.find('#BOXOBJETIVOE-L0-objetivo1').attr('id','BOXOBJETIVOE'+'-'+id+'-objetivo'+nextitem);//nuevo	
	 
	// indicadores
	 arrayindicadores[r-1][nextitem-1]= new Array();// *checar si va a nacer desde objetivo	
	 arrayindicadores[r-1][nextitem-1].push("1");//*checar si va a nacer desde objetivo		  
	  
	 clon.find('#WL0-objetivo1-indicador1').attr('id',"WL"+idlinea+"-objetivo"+nextitem+"-indicador1");	
	 clon.find('#L0-controlobjetivo1-controlindicador1').attr('id',"L"+idlinea+"-controlobjetivo"+nextitem+"-controlindicador1");//quitar
	
     clon.find('#textindicador000').html(idlinea+'.'+nextitem+'.1');//nuevo
     clon.find('#textindicador000').attr('id','textindicador'+idlinea+nextitem+'1');	
	 clon.find('#L0-objetivo1-indicador1').attr('id',"L"+idlinea+"-objetivo"+nextitem+"-indicador1"); 
	 clon.find('#L0-objetivo1-meta1').attr('id',"L"+idlinea+'-objetivo'+nextitem+"-meta1");	//nuevo 
	//botones	
	 clon.find('#EIL0-O1').attr('id',"EI"+id+'-O'+nextitem);	
	 clon.find('#AIL0-O1').attr('onclick','agregarIndice('+idlinea+','+nextitem+');');//nuevo	
	 clon.find('#AIL0-O1').attr('id',"AI"+id+'-O'+nextitem); //id=Ln
    
	 
	  $('#OL'+r).removeAttr("disabled");
	  
	 
     
	// $('#btndeleteline').removeAttr("disabled");

}



/***********inicio nuevo*****************/

function ToogleOE(contlinea,contobjetivo){
	
	//TOGOE-L'.$cont.'-objetivo'.$contobjetivo
	//BOXOBJETIVOE-L'.$cont.'-objetivo'.$contobjetivo
	  //alert('entro');
	
		//var local = id.split("-");		
		
		
		if($('#BOXOBJETIVOE-L'+contlinea+'-objetivo'+contobjetivo).is(':visible')) $('#TOGOE-L'+contlinea+'-objetivo'+contobjetivo).html('<i class="icon-chevron-down"></i> Indicador de objetivo');
		else $('#TOGOE-L'+contlinea+'-objetivo'+contobjetivo).html('<i class="icon-chevron-up"></i> Indicador de objetivo');
		
		$('#BOXOBJETIVOE-L'+contlinea+'-objetivo'+contobjetivo).toggle();
}
	
	
	
	function agregarIndice(countlinea,countobjetivo){	
	
	 
	 r = countlinea -1;
	 idlinea = countlinea;
	 
     var itemind = arrayindicadores[r][countobjetivo-1].length;  
	 nextitem= parseInt(itemind)+parseInt(1);
 
   
     arrayindicadores[r][countobjetivo-1].push("1");	 
	 
	 
 
	 var clon = $("#WL0-objetivo1-indicador1").clone(true).insertAfter("#WL"+countlinea+"-objetivo"+countobjetivo+"-indicador"+itemind);	
     clon.attr('id',"WL"+countlinea+"-objetivo"+countobjetivo+"-indicador"+nextitem);	    
    
	 clon.find('#L0-controlobjetivo1-controlindicador1').attr('id',"L"+countlinea+"-controlobjetivo"+countobjetivo+"-controlindicador"+nextitem);//*quitar
	
	 clon.find('#textindicador000').html(countlinea+'.'+countobjetivo+'.'+nextitem);//nuevo
     clon.find('#textindicador000').attr('id','textindicador'+countlinea+countobjetivo+nextitem);	
	 
	 clon.find('#L0-objetivo1-indicador1').attr('id',"L"+countlinea+"-objetivo"+countobjetivo+"-indicador"+nextitem);
	 
	 clon.find('#L0-objetivo1-meta1').attr('id',"L"+countlinea+"-objetivo"+countobjetivo+"-meta"+nextitem);//nuevo

	
	 
	 $('#EIL'+countlinea+'-O'+countobjetivo).removeAttr("disabled");
	  
	     

}

function EliminarIndice(id){
    
    //id = EIL1-O5
	var explode = id.split('-'); 	
	var linea = explode[0];
	
	idlinea = linea.substring(2,linea.length).toString();
	idl = linea.substring(3,linea.length);
	id = parseInt(idl)-1;
	
	 var objetivo = explode[1];
	idobjetivo = objetivo.substring(1,objetivo.length);
	
	
	 arrayindicadores[id][idobjetivo-1].pop();
	
	 if(arrayindicadores[id][idobjetivo-1].length==1){
	 	$('#EIL'+idl+'-O'+idobjetivo).attr('disabled','disabled');		
	 }
	
	indicador = arrayindicadores[id][idobjetivo-1].length+1;
	  
	 
	$("#W"+idlinea+"-objetivo"+idobjetivo+"-indicador"+indicador).remove();
	   
		
		
		
	}



/*************fin***************/








function AgregarLineas(id,confirm){
	
	if(confirm){
	window.location.href='?execute=planestrategico/addlineaspe&method=default&Menu=F1&SubMenu=SF11&IdPlan='+id;	
	}else{
	window.location.href='?execute=principal&method=default&Menu=F1&SubMenu=SF11#&p=1&s=25&sort=1&q=';	
	}
	
}


$(window).load(function(){
 ////////////////////////CLONE LINEA/////////////////////
	 
	     var itemlinea = arrayLineas.length;
		 itemlinea = itemlinea-1;
		 
		  var clon = $("#linea0").clone(false).insertAfter("#linea"+itemlinea);
		  arrayLineas.splice(0,1);
		 
		  arrayLineas.push(nexilinea);
		  arrayobjetivos[nexilinea]= new Array();
		  
		  clon.attr('id','linea'+nexilinea);
		  clon.find('#legenda0').html(nexilinea+'. Línea Estratégica');
		  clon.find('#legenda0').attr('id','legenda'+nexilinea);
		  clon.find('#titulo0').attr('id','titulo'+nexilinea);
		  
		  clon.find('#controlobjetivo0').attr('id','controlobjetivo'+nexilinea);
		  clon.find('#L0').attr('id','L'+nexilinea);
		  clon.find('#L0-controlobjetivo1').attr('id','L'+nexilinea+'-controlobjetivo1');
		  clon.find('#textobjetivo00').html(nexilinea+'.1');//nuevo 	
          clon.find('#textobjetivo00').attr('id','textobjetivo'+nexilinea+'1');//nuevo		
		  clon.find('#L0-objetivo1').attr('id','L'+nexilinea+'-objetivo1');
		  clon.find('#OL0').attr('id','OL'+nexilinea);
		  
		  //nuevo	nexilinea = 1 cuando la ira vez 
          clon.find('#TOGOE-L0-objetivo1').attr('onclick','ToogleOE('+nexilinea+',\'1\');');//nuevo	 
	      clon.find('#TOGOE-L0-objetivo1').attr('id','TOGOE'+'-L'+nexilinea+'-objetivo1');//nuevo
	      clon.find('#BOXOBJETIVOE-L0-objetivo1').attr('id','BOXOBJETIVOE'+'-L'+nexilinea+'-objetivo1');//nuevo
		  
		  arrayindicadores[nexilinea-1]= new Array();
		  arrayindicadores[nexilinea-1][0]= new Array();// *checar si va a nacer desde objetivo	y linea
		  arrayindicadores[nexilinea-1][0].push("1");//*checar si va a nacer desde objetivo,	es lo mismo  arrayindicadores[nexilinea-1][0][n]  		  
		  clon.find('#WL0-objetivo1-indicador1').attr('id',"WL"+nexilinea+"-objetivo1-indicador1");	
		  clon.find('#L0-controlobjetivo1-controlindicador1').attr('id',"L"+nexilinea+"-controlobjetivo1-controlindicador1");//*quitar		
          clon.find('#textindicador000').html(nexilinea+'.1.1');
          clon.find('#textindicador000').attr('id','textindicador'+nexilinea+'11');		
		  clon.find('#L0-objetivo1-indicador1').attr('id',"L"+nexilinea+"-objetivo1-indicador1"); 
		  clon.find('#L0-objetivo1-meta1').attr('id','L'+nexilinea+'-objetivo1-meta1');	//nuevo 
		  //botones	
		  clon.find('#EIL0-O1').attr('id',"EIL"+nexilinea+'-O1');	
		  clon.find('#AIL0-O1').attr('onclick','agregarIndice('+nexilinea+',\'1\');');
		  clon.find('#AIL0-O1').attr('id',"AIL"+nexilinea+'-O1');  
		  
		
		  
		 
   	      $("#linea0").css("display","none");
	 //////////////END CLONE LINEA//////////////
});


function Salvar(){
	
	var objetivos = "";
	var lineas = "";
	var indicadores = "";
	var metas = "";
	
	for(i=0;i<arrayLineas.length;i++){//OBTENEMOS LOS LINEAS 
		
		value = $('#titulo'+arrayLineas[i]).val();
		value = value.replace("|","");
	    value = value.replace("^","");
		lineas += value+"^";
		

		
		      for(j=1;j<=(arrayobjetivos[i+1].length)+1;j++){//OBTENEMOS LOS OBJETIVOS ESTRATÉGICOS
				  
				  id = parseInt(i+1);
				  
				  val = $('#L'+id+'-objetivo'+j).val(); 
				  val = val.replace("|","");
				  val = val.replace("^","");
				  
				  objetivos +=  val+"|";			  
				  
				  
					  
					  for(k=1;k<=(arrayindicadores[i][j-1].length);k++){//OBTENEMOS LOS INDICADORES Y METAS					  
						 
						  
						  val = $('#L'+id+'-objetivo'+j+'-indicador'+k).val(); //INDICADORES
						  val = val.replace("¬","");
						  val = val.replace("~","");
						  val = val.replace("^","");
						  val = val.replace("|","");
						  
						  val2 = $('#L'+id+'-objetivo'+j+'-meta'+k).val(); //METAS
						  val2 = val2.replace("¬","");
						  val2 = val2.replace("~","");
						  val2 = val2.replace("^","");
						  val2 = val2.replace("|","");
						  
						  val += "|"+ val2;                         					  
						  
						  indicadores +=  val+"¬";
					  
					  
					  }			   
					  indicadores +=  "~";
				  
			  }
              objetivos += "^";
			  indicadores +=  "^";
	}
	          
			  
			 
	 
	 GuardarLineas(lineas,objetivos,indicadores);
		
	 }
	
	
function GuardarLineas(lineas,objetivos,indicadores){
	
	
	  $.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
	
	
    var IdPlan = gup('IdPlan');
	
	$.ajax({ 
	 
	 // type: "POST",
     //data: { name: "John", location: "Boston" }
	 
    type: "POST",  
    url: "index.php?execute=planestrategico/addlineaspe&method=GuardarLinea",  
    data: { lineas: lineas, objetivos: objetivos, indicadores: indicadores, IdPlan : IdPlan},  
    success: function(msg){  
	
  
	  $.unblockUI();	  
	 
	  
	  window.location.href='?execute=principal&method=default&Menu=F1&SubMenu=SF11#&p=1&s=25&sort=1&q=&alert=1';
               
			   } 
   
           });
}
	
	
	
	function GuardarObjetivos(){
		
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
	