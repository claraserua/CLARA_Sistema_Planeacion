<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Sistema de Planeación</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

<link rel="stylesheet" href="skins/default/css/header.css" type="text/css" media="all" />
<link rel="stylesheet" href="skins/default/css/style.css" type="text/css" media="all" />
<link  href="skins/default/css/bootstrap-cerulean.css" rel="stylesheet">
<link  href="skins/default/css/opa-icons.css" rel="stylesheet">
<link href="skins/default/css/dropdownmenu.css" rel="stylesheet">
<link href="skins/default/css/comentarios.css" rel="stylesheet">
<link href="skins/default/css/minsearch.css" rel="stylesheet">

<link rel="stylesheet" href="skins/default/js/jquery/themes/base/jquery.ui.all.css" />

<!-- jQuery -->
	<script src="skins/default/js/jquery-1.7.2.min.js"></script>
	<!-- jQuery UI -->
	<script src="skins/default/js/jquery-ui-1.8.21.custom.min.js"></script>
    
    
    <script src="skins/default/js/jquery/ui/i18n/jquery.ui.datepicker-es.js"></script>
    
    
    <script type="text/javascript" src="libs/ckeditor/ckeditor.js"></script>
   
<!-- TREE MENU-->
<script src="libs/tree/TreeMenu.js" language="JavaScript" type="text/javascript"></script>
<link href="libs/tree/TreeMenu.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
<!--End Tree Menu-->
   
</head>

<body>
	
<!--Header -->
#HEADER#
<!-- End Header -->

<!-- Container -->
<div id="container">

	<div class="shell">

		<!-- Main -->
		<div id="main">
        
        
        	<!-- Main Nav -->
	<div id="navMenu">
              #MENU#
    </div>
     		<!-- End Main Nav -->
        
               
        
              	
			<!-- Content -->
			<div id="content">
				
               #CONTENT#
				

			</div>
			<!-- End Content -->
			

			
			<div class="cl">&nbsp;</div>			
		</div>
		<!-- Main -->
	</div>
</div>
<!-- End Container -->

<!--MODAL-->
<div class="modal hide fade" id="myModal1">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<span id="titlemodal1">Eliminar Usuario</span>
			</div>
			<div class="modal-body">
				<p><span id="bodymodal1">¿Esta seguro de eliminar el Usuario?</span></p>
			</div>
			<div class="modal-footer">
				<a href="#" id="cancelarmodal1" class="btn" data-dismiss="modal">Cancelar</a>
				<a href="#" id="aceptarmodal1"  class="btn btn-warning">Aceptar</a>
			</div>
		</div>

<!--END MODAL-->





<!--MODAL-->
<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<span id="titlemodalR">Anotaciones del centro y revisón</span>
			</div>
			<div class="modal-body">
				<div id="bodymodal">
					<!--BODY MODAL-->
					 <div id="twitter-container">
		
			    <span class="counter" id="counterpo"></span>
			    <textarea name="inputField" id="inputFieldpo" tabindex="1" rows="2" cols="40"></textarea>
			   
			    <input class="submitButton" name="submit" type="button" onClick="guardarComentarioPeriodo();" value="comentar"  id="update_buttonpo" />
			    <div class="clear"></div>
		    
		  </div>
		  
		  
		  
		
          <div id="flashmessage">	
    <div id="flash"></div>
	  		</div>
   		  <div class="comentarios" id="comentariospo" style="min-height: 250px;">	
					
		  
		  </div>
					
					<!--END BODYMODAL-->
				</div>
			</div>
			<div class="modal-footer" id="modal-footerl">
				<a href="#" id="cancelarmodal" class="btn" data-dismiss="modal">Cerrar</a>
                <a href="#" id="aceptarmodal"  class="btn btn-warning">Aceptar</a>
				
			</div>
		</div>

<!--END MODAL-->



<!--MODAL COMENTARIOS-->
<div class="modal hide fade" id="myModalcomentarios" style="width:900px; left:480px; ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<span id="titlemodalplane">COMENTARIOS</span>
			</div>
			<div class="modal-body">
				
                <!-- BUSQUEDA DE COMENTARIOS-->
                	
						
					<!-- CONTENIDO -->
					<div class="tableModal" id="results-panel-Modal" style="height: 350px; width:100%; overflow-y: auto;">
						
						</div>
					<!-- END CONTENIDO -->
						
						  
						
					
					
				
                <!-- END BUSQUEDA COMENTARIOS-->
                
                
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Cerrar</a>
				
			</div>
		</div>

<!--END MODAL COMENTARIOS-->



<!-- Footer -->
#FOOTER#
<!-- End Footer -->


<!--------------LIBRERIA DE JAVASCRIPT---------------->


	<!-- transition / effect library -->
	<script src="skins/default/js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="skins/default/js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="skins/default/js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="skins/default/js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="skins/default/js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="skins/default/js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="skins/default/js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="skins/default/js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="skins/default/js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="skins/default/js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="skins/default/js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="skins/default/js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="skins/default/js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="skins/default/js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='skins/default/js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='skins/default/js/jquery.dataTables.min.js'></script>
	

<!-- select or dropdown enhancer -->
	<script src="skins/default/js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="skins/default/js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="skins/default/js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="skins/default/js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="skins/default/js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="skins/default/js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="skins/default/js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="skins/default/js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="skins/default/js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="skins/default/js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="skins/default/js/jquery.history.js"></script>
	
	<!-- application script for Charisma demo -->
	
    <script src="skins/default/js/alertas.js"></script>
    
    
    <script src="skins/admin/js/jquery.blockUI.js" type="text/javascript"></script>
    <script src="skins/admin/js/jquery.iframe-post-form.js" type="text/javascript"></script>


<!------------END LIBRERIA DE JAVASCRIPT-------------->


</body>
</html>