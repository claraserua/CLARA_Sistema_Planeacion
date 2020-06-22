<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Sistema de Planeación</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

<link rel="stylesheet" href="skins/default/css/header.css" type="text/css" media="all" />
<link rel="stylesheet" href="skins/default/css/style.css" type="text/css" media="all" />
<link  href="skins/default/css/bootstrap-cerulean.css" rel="stylesheet">
<link href="skins/default/css/dropdownmenu.css" rel="stylesheet">
<!-- jQuery -->
	<script src="skins/default/js/jquery-1.7.2.min.js"></script>
	<!-- jQuery UI -->
	<script src="skins/default/js/jquery-ui-1.8.21.custom.min.js"></script>

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
        
              
              <!-- Nav ToolBar -->
            
            <!--  <div id="toolbar">
              
              <a href="addpe.html">
                <button type="submit" data-rel="popover" data-content="Agregar planes Estrategicos correspondientes..." title="Plan Estrategico" class="btn btn-small btn-warning">Añadir un nuevo Plan Estrategico</button></a>
              
              </div> 
              
               <!-- End Nav ToolBar -->
       
              	
			<!-- Content -->
			<div id="contentright">
				
               #CONTENT#
				

			</div>
			<!-- End Content -->
			
             <div id="sidebar">
        <!-- Box -->
				<div class="box">
					
					<!-- Box Head -->
					<div class="box-head">
						<h2><i class="icon-search"></i>&nbsp;Acotar Búsqueda</h2>
					</div>
					<!-- End Box Head-->
					
					<div class="box-content" style="overflow: auto;">
						
						<div class="cl">&nbsp;</div>
						<p>#NODOS#</p>
						
						<!-- Sort -->
						<div class="sort">
							
						</div>
						<!-- End Sort -->
						
					</div>
				</div>
				<!-- End Box -->
        </div>

			
			<div class="cl">&nbsp;</div>			
		</div>
		<!-- Main -->
	</div>
</div>
<!-- End Container -->

<!--MODAL-->
<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<span id="titlemodal">Eliminar Usuario</span>
			</div>
			<div class="modal-body">
				<p><span id="bodymodal">¿Esta seguro de eliminar el Usuario?</span></p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
				<a href="#" id="aceptarmodal"  class="btn btn-warning">Aceptar</a>
			</div>
		</div>

<!--END MODAL-->



<!--MODAL PLANES ESTRATEGICOS-->
<div class="modal hide fade" id="myModalplanese" style="width:700px; ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<span id="titlemodalplane">Elige el Plan Estrategico:</span>
			</div>
			<div class="modal-body">
				
                <!-- BUSQUEDA DE PLANES ESTRATEGICOS-->
                
              
                    
                    
                    <!-- Pagging -->
                        <div class="pagging" id="paggingheadModal">         
                        <div class="left">  
            <input type="text" name="searchbar" id="searchbar"    />
							<button class="btn btn-small" onclick="buscarPE();"  id="search_go-button-pe"><i class="icon-search"></i> Buscar</button>
                        </div>
                        
                        <div class="bar_seperator"></div>
                        
       <div id="search_page_size-panel">
        <div id="page_size_25-panel2" onClick="showLimitPage2(25,this);" class="page_size_25 page_size_25-selected"></div>
		<div id="page_size_50-panel2" onClick="showLimitPage2(50,this);" class="page_size_50"></div>
        <div id="page_size_100-panel2" onClick="showLimitPage2(100,this);" class="page_size_100"></div>
        <div id="page_size_200-panel2" onClick="showLimitPage2(200,this);" class="page_size_200"></div>
	 </div>
                        
             
             
             
             
  
               <div class="search_pagination">
               <!-- <button class="btn btn-small" style="float:left; margin-right:10px;"><i class="icon-list-alt"></i> Mostrar Todos</button>-->
                <div class="page_button left button_disable"></div> 
                <div class="page_overview_display">
                <input type="text" class="page_number-box"  value="1">&nbsp;de&nbsp;1
                </div>
               <div class="page_button right button_disable"></div>
	            </div>    
                        
                        
                        </div>
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="tableModal" style="height: 250px; width:100%; overflow-y: auto;">
						<table width="100%"  border="0" cellspacing="0" cellpadding="0">
							<thead>
							<tr>
							   <th width="20">&nbsp;</th>
								<th align="left">Titulo</th>
                                <th width="100">Centro</th>
                                
							</tr>
							</thead>
							 <tbody id="results-panel-Modal">
							
							
							</tbody>
							
						</table>
						</div>
					<!-- Table -->
						
						  <!-- Pagging -->
						
                        <div class="pagging" id="barfilterfooterModal">
                       
                     
                       <div class="search_pagination">
                       
                     
                       
                       <div class="page_button left button_disable">
                       </div> <div class="page_overview_display">
          <input type="text" class="page_number-box"  value="1">
          &nbsp;de&nbsp;1</div><div class="page_button right button_disable"></div> 
	                  </div>                       
                        
                          <div class="left"> 
                        <div id="results_textModal">
               0 resultados
               </div>
               </div>
                        
                        </div>
						<!-- End Pagging -->
						
					
					
				
                <!-- END BUSQUEDA DE PLANES ESTRATEGICOS-->
                
                
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
				<a href="#" id="aceptarmodalpe"  class="btn btn-warning">Aceptar</a>
			</div>
		</div>

<!--END MODAL PLANES ESTRATEGICOS-->



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

    <script src="skins/default/js/alertas.js"></script>
    
  

    <script src="skins/admin/js/jquery.blockUI.js" type="text/javascript"></script>
    <script src="skins/admin/js/jquery.iframe-post-form.js" type="text/javascript"></script>


<!------------END LIBRERIA DE JAVASCRIPT-------------->


</body>
</html>