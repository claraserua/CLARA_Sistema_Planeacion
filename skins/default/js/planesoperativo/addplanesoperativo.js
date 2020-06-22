

var arrayperiodos = new Array();
 arrayperiodos.push("1");


$(function(){
		
	$( ".finicio" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd' 
    });

   $( ".ftermino" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd' 
    });
	 
	 
	 var dates = $( "#finicio, #ftermino" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd' ,
			//numberOfMonths: 3,
			onSelect: function( selectedDate ) {
				var option = this.id == "finicio" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	 
	
	  	  

});//End function jquery



function AgregarPeriodo(){
	
	 var numperiodos = arrayperiodos.length; //obtenemos el numero de periodos 
	
	 arrayperiodos.push("1");
	
	 var clon = $("#P1").clone(false).insertAfter("#P"+numperiodos);
	    clon.attr('id','P'+parseInt(numperiodos+1));
	
	 clon.find('#LABEL-P1').html(parseInt(numperiodos+1));
	 clon.find('#LABEL-P1').attr('id','LABEL-P'+parseInt(numperiodos+1));
	 clon.find('#P1-S1').val("");
	 clon.find('#P1-S1').attr('id','P'+parseInt(numperiodos+1)+'-S'+parseInt(numperiodos+1));
	 clon.find('#P1-I1').val("");
	 clon.find('#P1-T1').val("");
	 clon.find('#P1-I1').removeClass('hasDatepicker');
	 clon.find('#P1-I1').attr('id','P'+parseInt(numperiodos+1)+'-I'+parseInt(numperiodos+1));
	 clon.find('#P1-T1').removeClass('hasDatepicker');
     clon.find('#P1-T1').attr('id','P'+parseInt(numperiodos+1)+'-T'+parseInt(numperiodos+1));
	
	
	
     $('#P'+parseInt(numperiodos+1)+'-I'+parseInt(numperiodos+1)).datepicker({dateFormat: 'yy-mm-dd',changeYear: true,changeMonth: true });
	 $('#P'+parseInt(numperiodos+1)+'-T'+parseInt(numperiodos+1)).datepicker({dateFormat: 'yy-mm-dd',changeYear: true,changeMonth: true });
	 $('#BEP').removeAttr("disabled");	   
}



function EliminarPeriodo(){
	
	var numperiodos = arrayperiodos.length;


	if(numperiodos==2){
	 	$('#BEP').attr('disabled','disabled');
	 }
	 
	 $("#P"+numperiodos).remove(); 
	 arrayperiodos.pop();
	 
}




function validarFormulario(){
	
	var valido = true;
	
	if($('#titulo').val()==""){ valido = false;}
	if($('#finicio').val()==""){ valido = false;}
	if($('#ftermino').val()==""){ valido = false;}
	
	
   
	cont = 1;
	for(i=0;i<arrayperiodos.length;i++){
       
	  if($('#P'+cont+'-S'+cont).val()==""){ valido = false;}
	   if($('#P'+cont+'-I'+cont).val()==""){ valido = false;}
	    if($('#P'+cont+'-T'+cont).val()==""){ valido = false;}
	  cont++;
	}
	
	
	return valido;
	
}



function GuardarPlanOperativo(){
	
    var idplan = $('#idplan').val();	
	var titulo = $('#titulo').val();
	var descripcion = $('#descripcion').val();
	var disponible = $('input[name=disponible]:checked').val();
	var finicio = $('#finicio').val();
	var ftermino = $('#ftermino').val();
	var idplanE = gup('IDPlanEstrategico');
	var jerarquia = $('input[name=jerarquia]:checked').val();
	
	
	
    var seguimiento = "";
	
	cont = 1;
	for(i=0;i<arrayperiodos.length;i++){
       
	   seguimiento += $('#P'+cont+'-S'+cont).val();
	       seguimiento += "^"+$('#P'+cont+'-I'+cont).val();
	           seguimiento += "^"+ $('#P'+cont+'-T'+cont).val();
			   
	  seguimiento += "|";
	  cont++;
	}
		

	
	if(validarFormulario()){
		
		 $.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
		
	$.ajax({ 
	 
	 // type: "POST",
     //data: { name: "John", location: "Boston" }
	 
    type: "POST",  
    url: "index.php?execute=planesoperativo/addplano&Menu=F1&SubMenu=SF4&method=GuardarPlan",  
    data: { titulo: titulo, descripcion: descripcion, disponible : disponible, finicio:finicio, ftermino:ftermino,seguimiento:seguimiento, IDPlanEstrategico:idplanE, idplan:idplan,jerarquia:jerarquia},  
    success: function(msg){  
	

      
	setTimeout("window.location.href = '?execute=operativo&method=default&Menu=F2&SubMenu=SF21#&p=1&s=25&sort=1&q=&alert=1'",100);
	  
               } 
   
           });

     }else{
	 	
		$('html, body').animate({scrollTop:0}, 10);
				$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-block");
				$("#headAlerta").html("¡Advertencia!");
				$("#bodyAlerta").html("Debes de ingresar todos los campos obligatorios");
	 	
	 }
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
	