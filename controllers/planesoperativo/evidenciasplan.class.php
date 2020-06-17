<?php
include "models/planesoperativo/seguimiento.model.php";
include "libs/resizeimage/class.upload.php";


class evidenciasplan {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $image;
	var $targetPathumbail;
	var $adjunto;
	

	function evidenciasplan() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("option");
	 $this->Model = new seguimientoModel();
	 $this->View = new View();
	 $this->alertas = new Alertas();
	
	 switch($_GET['method']){
	 	
		case "Buscar":
			$this->Buscar();
			break;

		case "BuscarResultados":
             $this->BuscarResultados();
             break;

        case "BuscarEvidencias":
             $this->BuscarEvidencias();
             break;
	 	
		case "EnviarInforme":
			$this->EnviarInforme();
			break;
			
		case "RevisarInforme":
			$this->RevisarInforme();
			break;
			
		case "GuardarResumenPeriodo":
		     $this->GuardarResumenPeriodo();
			 break;
			
	     case "insertarColaborador":
		    $this->insertarColaborador();
			break;	
			
		case "eliminarColaborador":
		      $this->eliminarColaborador();
			  break;	
	
		case "insertarComentario":
		      $this->insertarComentario();
			  break;
			  
	    case "insertarComentarioPeriodo":
		      $this->insertarComentarioPeriodo();
			  break;
		
	   
	   	case "insertarComentarioResumenPeriodo":
		      $this->insertarComentarioResumenPeriodo();
			  break;
	   	   		  
			  
	   case "eliminarComentario":
	        $this->eliminarComentario();
			break;
			
			
	   case "eliminarComentarioResumenPeriodos":
	        $this->eliminarComentarioResumenPeriodos();
			break;
			
			
	   case "GuardarAvanceObjetivo":
	        $this->GuardarAvanceObjetivo();
			break;
	   	
	   case "GuardarAvanceMedio":
	        $this->GuardarAvanceMedio();
			break;
	
	
	   case "ObtenerComentariosSeguimiento":
	        $this->ObtenerComentariosSeguimiento();
			break;
			
	  case "UploadFile":
	        $this->UploadFile();
			break;
			
	  case "UploadFileResumen":
			$this->UploadFileResumen();
			break;
			
	  case "Buscarobjetivos":
			$this->Buscarobjetivos();
			break;
				
	  case "EliminarAdjuntoResumen":
	        $this->EliminarAdjuntoResumen();
			break;
	  
	  case "EliminarEvidencia":
	        $this->EliminarEvidencia();
			break;
			
	 case "EliminarEvidenciaArchivo":
	       $this->EliminarEvidenciaArchivo();
		   break;
		
		default:	
          $this->loadPage();
		  break;
		}
				 
		 
	}
	
	
	
	 function loadPage(){
	
		$this->View->template = TEMPLATE.'modules/planesoperativo/SEGUIMIENTO.TPL';	
		$this->View->loadTemplate();
		$this->loadHeader();
		$this->loadMenu();
		
		//if($this->passport->privilegios->hasPrivilege('P12')){
		$this->loadContent();
		//}else{
		$this->error();
		//}
		$this->loadFooter();
		$this->View->viewPage();
		
	 }
	 
	 
	   function loadHeader(){

	  $section = TEMPLATE.'sections/header.tpl';
	  $section = $this->View->loadSection($section);
	  $nombre = htmlentities($_SESSION['session']['titulo'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($_SESSION['session']['nombre'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($_SESSION['session']['apellidos'], ENT_QUOTES, "ISO-8859-1");
	  $imagen = 'thum_40x40_'.$_SESSION['session']['imagen'];
	  $section = $this->View->replace('/\#AVATAR\#/ms' ,$imagen,$section);
	  $section = $this->View->replace('/\#USUARIO\#/ms' ,$nombre,$section);
	  
	  $section = $this->View->replace('/<!--\#NUMNOTIFICACIONES\#-->/ms' ,$this->alertas->getNumAlertas(),$section);
	  $section = $this->View->replace('/<!--\#NOTIFICACIONES\#-->/ms' ,$this->alertas->getAlertas(),$section);
	  
	  
	  $this->View->replace_content('/\#HEADER\#/ms' ,$section);
	  
	 }
	 
	 
	 function loadFooter(){
	 	
      $section = TEMPLATE.'sections/footer.tpl';
	  $section = $this->View->loadSection($section);
	  $this->View->replace_content('/\#FOOTER\#/ms' ,$section);
		
	 }
	 
	 
	
	 function loadMenu(){
	
	 $menu =  $this->menu->menu; 
	 $this->View->replace_content('/\#MENU\#/ms' ,$menu);
	 
	 
	 }
	 
	

	function error(){
		
		$contenido = $this->View->Template(TEMPLATE.'modules/error.tpl');
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
	}


  
	 function loadContent(){
	 	
        
		$contenido = $this->View->Template(TEMPLATE.'modules/planesoperativo/FRMEVIDENCIASP.TPL');
		$plan =  $this->Model->getPlanOperativo($_GET['IDPlan']);
		
		
		$contenido =  $this->View->replace('/\#IDPLAN\#/ms' ,$_GET['IDPlan'],$contenido);
		
					
		
		$contenido =  $this->View->replace('/\#TITULOPLAN\#/ms' ,htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1"),$contenido);
	
	  
	    $contenido = $this->View->replace('/\#LINEAS\#/ms' ,$this->getLineasPlan(),$contenido);
        $contenido =  $this->View->replace('/\#EVIDENCIAS\#/ms' ,$this->getEvidencias(),$contenido);
		 
		 
		 $contenido =  $this->View->replace('/\<!--#LINEASMENU#-->/ms' ,'Lineas',$contenido);  	
		
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 }
	 
       
         function getLineasPlan(){
	 	
	 	$this->Model->getLineasPlane($_GET['IDPlanE']);
		$numlineas = sizeof($this->Model->lineas);
		$lineas = "";
		$i = 1;
		if($numlineas != 0){
		foreach($this->Model->lineas as $row){
			
		    $lineas .= "<option value=\"".$row['PK1']."\">".$i++.".- ".htmlentities($row['LINEA'], ENT_QUOTES, "ISO-8859-1")."</option>";

			}
		}
		return $lineas;
	   }
       
	   
		 function getEvidencias(){
		 	
			$panelcontent = ' <!-- Content RIGHT -->
			<div id="content">
               <!--End Alerta -->
                <!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head" >';
					/*
					<div class="left">
					<label>
					<small>Línea Estratégica:  </small>
					<select name="lineasfilter" id="lineasfilter" onchange="getObjetivosfilter(this);" style="width:80%; z-index:1000;">
		<option value="ALL">Todas las Líneas ...................................................................................................................</option>';
					
					
   $panelcontent .= $this->getLineasPlan();				
									
    $panelcontent .='</select>
	</label>
	  
	 
	  <label>
	 &nbsp;&nbsp;<small>Resultado:</small>
	  <select name="objetivosfilter" id="objetivosfilter" disabled="disabled" onchange="filterObjetivo(this);"  style="width:80%; z-index:1000;">
		
									
      </select>
					</label>
					
					</div>
					<br/>
				*/
					
						
					$panelcontent .='	<div class="right" >';                            
                       
					  $permiso =  ( $this->Model->obtenerEstadoPlan($_GET['IDPlan'])=="R" )? "P108":"P61";
												
						if($this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){

      

						$panelcontent .='<button type="button" onClick="uploadEvidencias();" class="btn btn-small btn-warning"><i class="icon-upload icon-white"></i>&nbsp;Agregar Evidencia</button>&nbsp;
						
						
						
		<a class="btn btn-small btn-warning" type="button" href="?execute=planesoperativo/EXCEL_Evidencias&IDPlan='.$_GET['IDPlan'].'&IDPlanE='.$_GET['IDPlanE'].'"><i class="icon-upload icon-white"></i> Exportar</a>
		
		
		
		
		
		
		<!--<a class="btn btn-small btn-warning" type="button" onClick="javascript:ExportarExcel(\''.$_GET['IDPlan'].'\',\''.$_GET['IDPlanE'].'\');return false;"><i class="icon-upload icon-white"></i> Exportar</a>-->
		
							                ';
						    
						}
						
						$panelcontent .='</div>
						
					 
					    <div class="right" style="margin-right:10px;">
					
                        <input type="text" name="searchbar" id="searchbar"    />
							<button class="btn btn-small" id="search_go-button-pe"><i class="icon-search"></i> Buscar</button>
						
						</div>
						
						 
						
						
						
						
					    </div>
					<!-- End Box Head -->	
                    
                    
                    <!-- Pagging -->
					
					
					
					
						<div class="pagging" id="pagginghead">
							<table style="width:100%;">
								<tbody><tr>
									<td style="width:88%;">
										<div class="left">
											<div id="sort-panel-lines">
												<div id="toolbar" style="top:0px; margin-bottom: 0px;">
													<a class="" href="#" onClick="buscar()">L&iacute;neas</a>
												</div>
											</div>
										</div>
									</td>
									<td style="width:2%;">
										<div class="bar_seperator"></div>
									</td>
									<td style="width:10%;">
										<div class="right">
											<div id="results_text">0 resultados</div>
										</div>
									</td>
								</tr>
							</tbody></table>
						</div>
						<br/>
					
					
					<!--
                        <div class="pagging" id="pagginghead">         
                    <div class="left">  
                        

                         <div id="sort-panel-lines">  
                         <div id="toolbar"><a class="subnavigation" href="#" onClick="buscar()">L&iacute;neas</a></div>
	                    </div> 
	                    
	                    
                     </div>
                        
                        
               <div class="bar_seperator"></div>
                        
               
                        
              <div class="right">
				<div id="results_text">0 resultadosdiv>
			  </div>
			  
                        
                        
                        </div>
						-->
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div id="results-panel" style="position: relative;overflow:;">
					</div>
					<!-- Table -->
						
						  <!-- Pagging -->
						
                        <div class="pagging" id="barfilterfooter">
                       
                     
                       <!--<div class="search_pagination">
                       
                       <div class="page_button left button_disable">
                       </div> <div class="page_overview_display">
          <input type="text" class="page_number-box"  value="1">
          &nbsp;de&nbsp;1</div><div class="page_button right button_disable"></div> 
	                  </div>    -->                   
                        
                        
                        </div>
						<!-- End Pagging -->
						
					
					
				</div>
				<!-- End Box -->
               
				

			</div>
			<!-- End Conten RIGHTt -->
			
			
			<!--
			<div id="sidebar">
      
				<div class="box">
					
					
					<div class="box-head">
						<h2><i class="icon-search"></i>&nbsp;Acotar Búsqueda</h2>
						
					</div>
				
					
                    
                  
					<div>
						
                        
                <div id="category-filter">
					<ul>
                    
    
    <li>
    <li>
    <input type="checkbox" class="any" id="all" value="all" onclick="filtrarTodo(this.id);" name="all" checked="checked">
    Todo
    </li>                
     <li>
     <input id="AUD" class="any" type="checkbox" onclick="filtrar(this.id);" value="AUD" name="tipos[]">
Audio
     </li>
	 <li>
     <input id="VID" class="any" type="checkbox" onclick="filtrar(this.id);" value="VID" name="tipos[]">
Videos
     </li>
     
     <li>
     <input id="IMG" class="any" type="checkbox" onclick="filtrar(this.id);" value="IMG" name="tipos[]">
Imágenes
     </li>
     
	<li>
    <input type="checkbox" class="any" id="DOCS" value="DOCS" onclick="archivos(this.id);" name="DOCS" >
    Documentos / Archivos
    
	<ul>
	<li><input type="checkbox" class="any" id="PPT" value="PPT" onclick="filtrar(this.id);" name="tipos[]">
    Presentaciones</li>
	<li><input type="checkbox" class="any" id="DOC" value="DOC" onclick="filtrar(this.id);" name="tipos[]">
    Word</li>
	<li><input type="checkbox" class="any" id="XLS" value="XLS" onclick="filtrar(this.id);" name="tipos[]" >
    Excel</li>
    <li><input type="checkbox" class="any" id="PDF" value="PDF" onclick="filtrar(this.id);" name="tipos[]" >
    Pdf</li>
    <li><input type="checkbox" class="any" id="ZIP" value="ZIP" onclick="filtrar(this.id);" name="tipos[]" >
    Zip</li>
	</ul>
	</li>

</ul>
<br>
      

		</div>	-->			
						
					</div>
                    <!-- End Box Content-->
                    
				</div>
				<!-- End Box -->
        </div>';
		
		
		return $panelcontent;
			
		 }
	   
	   

	
}

?>