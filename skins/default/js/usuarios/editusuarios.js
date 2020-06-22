$(function(){

// ----- FUNCION IMAGE PREVIEW USUARIOS--//
	  $('#btncancelimage').click(function(){
	  $('#thumbailarticulo').hide();
	  $('#imagearticulo').show();
	  $(this).hide();
      });
      // ----- END FUNCION IMAGE PREVIEW USUARIOS--//
	  
	  
	 //VENTANA MODAL PARA ELIMINAR USUARIO
	  $('#eliminar-usuario').click(function(e){
		e.preventDefault();
		$('#myModalDeleteUser').modal('show');
	});
    //END VENTANA MODAL
	
	//POST FRAME ADD IMAGE USER
	$('#frmaddusuarios').iframePostForm
	({
		json : false,
		post : function ()
		{
			var message;
			
						
			if ($('#nombre').val().length && $('#apellidos').val().length && $('#usuario').val().length && $('#password').val().length )
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
				
              
		//console.log(response);		
	  window.setTimeout("window.location.href='?execute=usuarios&method=null&Menu=F3&SubMenu=SF31#&p=1&s=25&sort=1&q=&alert=trueadduser'",700)
			 
				return false;
				
				
			}
		}
	});
	
		//END POST FRAME ADD IMAGE USER
	
	
	
$('#btnenviaform1').click(function() {
selectAll("sel2",true);
$('#frmaddusuarios').submit();
});

$('#btnenviaform2').click(function() {
selectAll("sel2",true);
$('#frmaddusuarios').submit();
});
	  

});//End function jquery



function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                $('#thumbailarticulo')
                        .attr('src', e.target.result)
                        .width(100)
                        .height(100)
						.show();
                };
				
				
				$('#editimagen').val('TRUE');
				$('#btncancelimage').show();
				$('#imagearticulo').hide();
				
               reader.readAsDataURL(input.files[0]);
            }
        }



function pasarRoles() { 
    obj=document.getElementById('sel1'); 
    if (obj.selectedIndex==-1) return; 
    valor=obj.value; 
    txt=obj.options[obj.selectedIndex].text; 
    obj.options[obj.selectedIndex]=null; 
    obj2=document.getElementById('sel2'); 
    opc = new Option(txt,valor); 
    eval(obj2.options[obj2.options.length]=opc);     
} 


function quitarRoles() { 
    obj=document.getElementById('sel2'); 
    if (obj.selectedIndex==-1) return; 
    valor=obj.value; 
    txt=obj.options[obj.selectedIndex].text; 
    obj.options[obj.selectedIndex]=null; 
    obj2=document.getElementById('sel1'); 
    opc = new Option(txt,valor); 
    eval(obj2.options[obj2.options.length]=opc);     
} 


/*
function enviarFormulario(){
	
	selectAll("sel2",true);
	document.frmaddusuarios.submit();
	
}*/


function selectAll(selectBox,selectAll) { 
  
    // have we been passed an ID 
    if (typeof selectBox == "string") { 
        selectBox = document.getElementById(selectBox);
    } 
    // is the select box a multiple select box? 
    if (selectBox.type == "select-multiple") { 
        for (var i = 0; i < selectBox.options.length; i++) { 
             selectBox.options[i].selected = selectAll; 
        } 
    }
}