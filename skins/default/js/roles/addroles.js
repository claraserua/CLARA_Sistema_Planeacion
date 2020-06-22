$(function(){
		  

});//End function jquery



function GuardarRole(){
	
	rol = $('#rol').val();
	descripcion = $('#descripcion').val();
	
	
	if(rol!=""){
	 $.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
	
	$.ajax({ 
    type: "GET",  
    url: "index.php",  
    data: "execute=roles/addroles&method=Insertar&rol="+rol+"&descripcion="+descripcion,  
    success: function(msg){  
	
	
	$("#frmaddroles")[0].reset();
	
	$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha guardado el rol del sistema");
	

     window.setTimeout("window.location.href='?execute=rolesadmin&method=default&Menu=F3&SubMenu=SF32#&p=1&s=25&sort=1&q='",700)

	 
 $.unblockUI();
               } 
   
           });
		   }else{
		   	
			$("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-block");
				$("#headAlerta").html("¡Advertencia!");
				$("#bodyAlerta").html("Debes de ingresar todos los campos obligatorios");
			
		   }
	
	
}









