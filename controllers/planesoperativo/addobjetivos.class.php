<?php
include "models/planesoperativo/addobjetivos.model.php";
include "libs/resizeimage/class.upload.php";


class addobjetivos {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $image;
	var $targetPathumbail;
	

	function addobjetivos() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("option");
	 $this->Model = new addobjetivosModel();
		
	 switch($_GET['method']){
	 	
		case "GuardarObjetivos":
			$this->GuardarObjetivos();
			break;
			
		case "InsertarResultado":
			$this->InsertarResultado();
			break;
			
	    case "InsertarMedio":
			$this->InsertarMedio();
			break;
			
	   	case "InsertarArea":
			$this->InsertarArea();
			break;
			
	  	case "InsertarFortaleza":
			$this->InsertarFortaleza();
			break;

		case "InsertarIndicadorMeta":
			$this->InsertarIndicadorMeta();
			break;	
			
		
			
		case "getObjetivosEstrategicos":
		     $this->getObjetivosEstrategicos();
			 break;
			 
			 
		case "getResponsables":
		     $this->getResponsables();
			 break;
			 
		case "deleteResultado";
		     $this->deleteResultado();
			 break;
			 
	    case "deleteMedio";
		     $this->deleteMedio();
			 break;

		case "deleteIndicadorMeta";
		     $this->deleteIndicadorMeta();
			 break;
			 
			 
		 case "deleteArea";
		     $this->deleteArea();
			 break;
			 
	     case "deleteFortaleza";
		     $this->deleteFortaleza();
			 break;
			 
	
		case "updateMedio";
		     $this->updateMedio();
			 break;

		case "updateIndicadorMeta";
		     $this->updateIndicadorMeta();
			 break;		 
			 
	   case "updateResultado";
		     $this->updateResultado();
			 break;
			 
	   case "updateEvidencia";	
	         $this->updateEvidencia();
			 break;	 
			 
	   case "deleteEvidencia";	
	         $this->deleteEvidencia();
			 break;	
			 
		case "InsertarEvidencia";	
	         $this->InsertarEvidencia();
			 break;
			 
	   case "updateArea";
		     $this->updateArea();
			 break;
			 
	  case "updateFortaleza";
		     $this->updateFortaleza();
			 break;
			 
			 
		//-----inicio nuevo---	 
		
		
		   case "updateOportunidades";
		     $this->updateOportunidades();
			 break;	

       case "deleteOportunidades";
		     $this->deleteOportunidades();
			 break;	


       case "InsertarOportunidades";
		     $this->InsertarOportunidades();
			 break;		

			
			
	  case "updateDebilidades";
		     $this->updateDebilidades();
			 break;
			 
			 
	 case "deleteDebilidades";	
	         $this->deleteDebilidades();
			 break;	
			 
			 
			 
	 case "InsertarDebilidades":
			$this->InsertarDebilidades();
			break;	
			
			
	case "getAndDelIndicadoresByObj":
			$this->getAndDelIndicadoresByObj();
			break;
			 
	//------nuevo fin		 
			 
			 
		case "OrdenarResultados";
		     $this->OrdenarResultados();
			 break;
			
		default:	
	      $this->View = new View(); 
          $this->loadPage();
		  break;
		}
				 
		 
	}
	
	
	
	 function loadPage(){
	
		$this->View->template = TEMPLATE.'modules/planesoperativo/OBJETIVOS.TPL';	
		$this->View->loadTemplate();
		$this->loadHeader();
		$this->loadMenu();
		
		if($this->passport->privilegios->hasPrivilege('P34')){
		$this->loadContent();
		}else{
		$this->error();
		}
		$this->loadFooter();
		$this->View->viewPage();
		
	 }
	 
	 
	  function loadHeader(){

	  $section = TEMPLATE.'sections/header.tpl';
	  $section = $this->View->loadSection($section);
	  $nombre = $_SESSION['session']['titulo'].' '.$_SESSION['session']['nombre'].' '.$_SESSION['session']['apellidos'];
	  $imagen = 'thum_40x40_'.$_SESSION['session']['imagen'];
	  $section = $this->View->replace('/\#AVATAR\#/ms' ,$imagen,$section);
	  $section = $this->View->replace('/\#USUARIO\#/ms' ,htmlentities($nombre, ENT_QUOTES, "ISO-8859-1"),$section);
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
	 	 $this->Model->setActive($_GET['IDPlan']);
		$contenido = $this->View->Template(TEMPLATE.'modules/planesoperativo/ADDOBJETIVOS.TPL');
		$plan =  $this->Model->getPlanOperativo($_GET['IDPlan']);
		$contenido =  $this->View->replace('/\#TITULOPLAN\#/ms' ,htmlentities($plan['TITULO']),$contenido);
		
		$user = $_SESSION['session']['user'];
		$salida = "&IDPlan=".$_GET['IDPlan']."&user=".$user;
		$contenido =  $this->View->replace('/\#SALIDA\#/ms' ,$salida,$contenido);
		
		if($this->passport->isActivo($_GET['IDPlan'])){
			
			$alertaactivo = "<script type=\"text/javascript\">$.blockUI({ 
            message: '<strong>!oh! El plan operativo esta siendo modificado por el usuario: ".$plan['ACTIVO'].".</strong><br/> Se recomienda editarlo más tarde. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0)\" onclick=\"Omitir();\" style=\"color:#FFFFFF;\"><strong>Omitir y editar</strong> <span title=\".icon  .icon-white  .icon-cross \" class=\"icon icon-white icon-cross\"></a></span>', 
            fadeIn: 700, 
            fadeOut: 700, 
            timeout: false, 
            showOverlay: false, 
            centerY: false, 
            css: { 
                width: '420px', 
                border: 'none', 
                padding: '10px', 
                backgroundColor: '#FA0000', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: .8, 
                color: '#fff' 
            } 
        }); 
	
</script>";
			
		}else{
			$alertaactivo = "";
		}
		
		
		
		$contenido =  $this->View->replace('/\#ALERTAACTIVO\#/ms' ,$alertaactivo,$contenido);
		
		
		
		$contenido =  $this->View->replace('/\#ESTADO\#/ms' ,$this->Model->getEstadoPlanOperativo($_GET['IDPlan']),$contenido);
		
		if($this->passport->getPrivilegio($_GET['IDPlan'],'P46')){
		
	    $fresumen ='<li class=""> <a href="#resumen">Diagnóstico Inicial</a></li>';
		$contenido =  $this->View->replace('/\<!--#FRESUMENEJECUTIVO#-->/ms' ,$fresumen,$contenido);	
			}
		
		
		if($this->passport->getPrivilegio($_GET['IDPlan'],'P44')){
	    $btnguardar ='<button class="btn-warning btn-large" onclick="Salvar();"><span class="icon icon-white icon-save"></span> Guardar</button>';
		$contenido =  $this->View->replace('/\<!--#BTNGUARDAR#-->/ms' ,$btnguardar,$contenido);	
			}
			
		if($this->passport->getPrivilegio($_GET['IDPlan'],'P45')){
	    $btnenviar ='<button class="btn btn-large btn-primary" onclick="Enviar();"><span class="icon icon-white icon-sent"></span> Enviar P/Revisión</button>';
		$contenido =  $this->View->replace('/\<!--#BTNENVIARREVISION#-->/ms' ,$btnenviar,$contenido);	
			}
		
		
		$contenido =  $this->View->replace('/\#RESPONSABLES\#/ms' ,$this->obtenerResponsables(),$contenido);
		$contenido =  $this->View->replace('/\#CONTENIDO\#/ms' ,$this->obtenerLineas(),$contenido);
		$contenido =  $this->View->replace('/\<!--#VALUEDESCRIPCION#-->/ms' ,$this->getResumenEjecutivo(),$contenido);
		
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 }
	 
       
	   
	   
	    function getResumenEjecutivo(){
		
		$script = "<script>";
		
		$this->Model->getAreas();
		$this->Model->getFortalezas();
		$numareas = sizeof($this->Model->areas);
		$numfortalezas = sizeof($this->Model->fortalezas); 
			
		
				
		$htmLcontent = '<div class="box-objectivos" id="BOX-AREAS">
      
        <div class="well">
         <table width="100%">
         <tbody><tr>
         <td width="30">&nbsp;	</td>
         <td>Áreas de oportunidad	</td>            
         </tr>';           
          
		  
		$loop = 1;
		if($numareas != 0){ 
		
		
		if($numareas>2){
		$script .='$(\'#BEAREA\').removeAttr("disabled");';
		}
		
		foreach($this->Model->areas as $row){
          
		 $script .='array_areas.push("1");';
		 $htmLcontent .= ' <tr id="AREA-'.$loop.'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  <span class="add-on" id="LABEL-AREA-'.$loop.'">1.</span>
          <input type="text" class="area" style="width:85%;"  id="INPUT-AREA-'.$loop.'">
		  </div> 
          </td>
          </tr>';
		  $loop++;
		 }
		 }else{
		    $script .='array_areas.push("1");';	
			$htmLcontent .= ' <tr id="AREA-1">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  <span class="add-on" id="LABEL-AREA-1">1.</span>
          <input type="text" class="area" style="width:85%;"  id="INPUT-AREA-1">
		  </div> 
          </td>
          </tr>';
			
		 }
                    
        $htmLcontent .= '  <tr>
          <td colspan="2">
          <div style="margin-left:30px;" class="left">';
		           
		 if($this->passport->getPrivilegio($_GET['IDPlan'],'P128')){
				   
          $htmLcontent .= '<button style="float:left; margin-right:10px;" onclick="EliminarArea();" id="BEAREA" disabled="disabled" class="btn btn-small"><i class="icon-remove"></i> Eliminar Área</button>';
	      }
		  
		  if($this->passport->getPrivilegio($_GET['IDPlan'],'P127')){
				   
          $htmLcontent .= '
		  <button onclick="AgregarArea();" id="BAAREA"  class="btn btn-small"><i class="icon-plus"></i>Agregar Área</button>';			   }
		  
		  $htmLcontent .= '</div>
          </td>
          </tr>     
          </tbody></table>
          </div>
                      
                                 
         <div class="well">
         <table width="100%">
         <tbody><tr>
         <td width="30">&nbsp;	</td>
         <td>Fortalezas	</td>            
         </tr>';           
          
          
		$loop = 1;
		if($numfortalezas != 0){ 
		
		
		if($numfortalezas>2){
		$script .='$(\'#BEFORTALEZA\').removeAttr("disabled");';
		}
		
		foreach($this->Model->fortalezas as $row){
          
		 $script .='array_fortalezas.push("1");';
		 $htmLcontent .= ' <tr id="FORTALEZA-'.$loop.'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  <span class="add-on" id="LABEL-FORTALEZA-'.$loop.'">1.</span>
          <input type="text" class="fortaleza" style="width:85%;"  id="INPUT-FORTALEZA-'.$loop.'">
		  </div> 
          </td>
          </tr>';
		  $loop++;
		 }
		 }else{
		    $script .='array_fortalezas.push("1");';	
			$htmLcontent .= ' <tr id="FORTALEZA-1">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  <span class="add-on" id="LABEL-FORTALEZA-1">1.</span>
          <input type="text" class="fortaleza" style="width:85%;"  id="INPUT-FORTALEZA-1">
		  </div> 
          </td>
          </tr>';
			
		 }
		  
		  
		  
                    
          $htmLcontent .='<tr>
          <td colspan="2">
          <div style="margin-left:30px;" class="left">';         
          
		   if($this->passport->getPrivilegio($_GET['IDPlan'],'P139')){
		  $htmLcontent .='<button style="float:left; margin-right:10px;" onclick="EliminarFortaleza();" id="BEFORTALEZA" disabled="disabled" class="btn btn-small"><i class="icon-remove"></i> Eliminar Fortaleza</button>';
		  }
		  
	       if($this->passport->getPrivilegio($_GET['IDPlan'],'P138')){
		  $htmLcontent .='<button onclick="AgregarFortaleza();" id="BAFORTALEZA"  class="btn btn-small"><i class="icon-plus"></i>Agregar Fortaleza</button>';
		  }		
		  $htmLcontent .='</div>
          </td>
          </tr>     
          </tbody></table>
          </div> 
                     </div>';
		
		
		
		    $script .='
			$("#INPUT-AREA-'.$loop.'").Watermark("Agrega area de oportunidad...");
			$(".fortaleza").Watermark("Agrega fortaleza...");
			</script>';	
	    	$htmLcontent .= $script;
		
			return $htmLcontent;
			
		}
	   
	   
	   function obtenerResponsables(){
	   	
		$panelcontent = "";
		$this->Model->getResponsables($_GET['IDPlan']);
		
		foreach($this->Model->responsables as $row){
		  	
		$panelcontent .=' <option value="'.$row['PK1'].'">'.htmlentities($row['APELLIDOS'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1").'</option>';
			
		}
		
		
		return $panelcontent;
	   }
	   
	   
	   function obtenerLineas(){
	   	
		
		$script = "";
		$section = "";
		$tabs = "";
		$panelcontent = "";
		
		$this->Model->getLineasPlane($_GET['IDPlanE']);
		$numlineas = sizeof($this->Model->lineas); 
			
		if($numlineas != 0){ 
	    $script ='<script> ';
		$tabs ='<ul class="nav nav-tabs" id="myTab">';
		$panelcontent = '<div id="myTabContent" class="tab-content">';
		$cont = 1;
		$loop = 0;
		
		foreach($this->Model->lineas as $row){
			
			$script .='
			arraylineas_objetivos['.$loop.'] = new Array(); 
			arraylineas_objetivos['.$loop.'][0]= "1";
			
		
			lineas_objetivos_medios['.$loop.'] = new Array();
			lineas_objetivos_medios['.$loop.'][0] = new Array();
			lineas_objetivos_medios['.$loop.'][0][0] = 1;
			
			lineas_objetivos_evidencias['.$loop.'] = new Array();
			lineas_objetivos_evidencias['.$loop.'][0] = new Array();
			lineas_objetivos_evidencias['.$loop.'][0][0] = 1;
			
			
			 ';
			 
			$loop++;
			$idlinea = $row['PK1'];		
			$linea = $row['LINEA'];		
			
			$bodyestado =  htmlentities($linea, ENT_QUOTES, "ISO-8859-1");
			$titlestado = "Linea ".$cont.":";
            
		
			$tabs .='<li class="" data-rel="popover" data-content="'.$bodyestado.'" title="'.$titlestado.'"><a href="#linea'.$cont.'">Linea '.$cont.'</a></li>';
			$panelcontent .='<div class="tab-pane" id="linea'.$cont.'">';
			$panelcontent .='<div class="box" id="L'.$cont.'" >
                     <div class="box-head" >
					 <h2 class="left"><div class="clean">Línea estratégica '.$cont.': '.htmlentities($linea, ENT_QUOTES, "ISO-8859-1").'</div></h2>	
			          <input type="hidden" id="PK_LINEA_'.$cont.'" value="'.$idlinea.'"/>		 
					</div>
                    
           <!--====================OBJETIVO=====================--> 
   <div class="wellstrong" id="L'.$cont.'-C1">
                   
   <table width="100%">
       <tr>
	   <td colspan="2"><b><font size="2">Objetivo Estratégico:</font></b>
	   
       <select class="fullcombo" id="L'.$cont.'-OE1" style="width:100%;">';
	    
		$this->Model->getObjetivosE($idlinea);
	   
	      foreach($this->Model->objetivos as $rowObj){
		  	
			$panelcontent .=' <option value="'.$rowObj['PK1'].'">'.htmlentities($rowObj['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</option>';
			}
		   
			
	   $panelcontent .='</select> 
		
	   </td>
	   </tr>
	   
	   <tr>
       <td><b><font size="2">Resultado:</font></b></td>
       <td><b><font size="2">Responsable</font></b></td>
       </tr>
                    
       <tr>
       <td width="70%">   
		<div class="input-prepend">
		   <span class="add-on" id="LABEL-L'.$cont.'-O'.$cont.'">'.$cont.'.1</span>
           
		    <textarea name="resultado" style="width:90%;" class="objetivo" id="L'.$cont.'-O1"></textarea>
		</div>
       </td>
       
       <td width="30%"><select id="L'.$cont.'-OR1"  style="width:100%;">
       <option value="ALL"></option>';
	   	
	    $panelcontent .= $this->obtenerResponsables();
		
		$panelcontent .='</select>
	   </td>
       </tr>
       </table>
                   
	<div class="box-icon">
<a href="javascript:void(0)" onclick="Toogle(this.id);" class="btn btn-minimize btn-round" id="TOG-L'.$cont.'-C1"><i class="icon-chevron-up"></i></a>						
</div> 
            
      <div class="box-objectivos" id="BOX-L'.$cont.'-C1">
       <div class="well" >
       <table width="100%">
        <tr>
        <td width="2%">&nbsp;</td>
        <td width="70%"><b><font size="2">Medios</font></b></td>
        <td width="28%"><b><font size="2">Responsable</font></b></td>
        </tr>
         
        <tr id="L'.$cont.'-O1-M1-C1">
        <td>&nbsp; </td>
        <td>  
        <div class="input-prepend">
		<span class="add-on" id="LABEL-L'.$cont.'-O'.$cont.'-M1">'.$cont.'.1.1</span>
        
		<textarea name="medio" style="width:86%;" class="medio" id="L'.$cont.'-O1-M1"></textarea>
		</div> 
        </td>                          
        <td><select id="L'.$cont.'-O1-M1-R1" >
        <option value="ALL"></option>';
		
		$panelcontent .= $this->obtenerResponsables();
		
		
		$panelcontent .= '</select></td>
        </tr>
                    
        <tr>	
        <td colspan="2">
        <div class="left" style="margin-left:30px;">           
        <button class="btn btn-small" disabled="disabled" id="BEM-L'.$cont.'-O1"  onclick="EliminarMedio(this.id);" style="float:left; margin-right:10px;"><i class="icon-remove"></i> Eliminar medio</button>
                    
		
        <button class="btn btn-small" id="BAM-L'.$cont.'-O1"  onclick="AgregarMedio(this.id);"><i class="icon-plus"></i>Agregar Medio</button>				
		</div>            
        </td>
        </tr>
        </table>
        </div>
                      
                      
                      
         <div class="well">
         <table width="100%">
         <tr>
         <td width="30">&nbsp;	</td>
         <td><b><font size="2">Evidencias</font></b></td>            
         </tr>           
          
          <tr id="L'.$cont.'-O1-E1-C1">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  <span class="add-on" id="LABEL-L'.$cont.'-O'.$cont.'-E1">'.$cont.'.1.1</span>
          <input id="L'.$cont.'-O1-E1" class="evidencia"  style="width:470px;" type="text">
		  </div> 
          </td>
          </tr>
                    
          <tr>
          <td colspan="2">
          <div class="left" style="margin-left:30px;">         
          <button class="btn btn-small" disabled="disabled" id="BEE-L'.$cont.'-O1"  onclick="EliminarEvidencia(this.id);" style="float:left; margin-right:10px;"><i class="icon-remove"></i> Eliminar Evidencia</button>
	      <button class="btn btn-small" id="BAE-L'.$cont.'-O1"  onclick="AgregarEvidencia(this.id);"><i class="icon-plus"></i>Agregar Evidencia</button>			
		  </div>
          </td>
          </tr>     
          </table>
          </div> 
                </div>     
          
          
          </div>
           <!--====================END OBJETIVO=====================-->
                     
		
                       <!-- Pagging -->
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
                        <div class="right">';
						
			if($this->passport->getPrivilegio($_GET['IDPlan'],'P68')){
             $panelcontent .='<button class="btn btn-large" disabled="disabled" id="BEO-L'.$cont.'" onclick="EliminarObjetivo(this.id);" style="float:left; margin-right:10px;"><i class="icon-remove"></i> Eliminar Resultado
           </button>';
		   }
            
			
			if($this->passport->getPrivilegio($_GET['IDPlan'],'P69')){                   
		$panelcontent .='<button class="btn btn-large"  id="BAO-L'.$cont.'" onclick="AgregarObjetivo(this.id);" style="float:left; margin-right:10px;"><i class="icon-plus"></i> Agregar Resultado
           </button>';		   
			}
	
              $panelcontent .='</div>
						</div>
						<!-- End Pagging --> 
    
						</div>  ';
			$panelcontent .='</div>';
			$cont++;
			}
		    $script .='
			$(".objetivo").Watermark("Agregar un resultado...");
			$(".medio").Watermark("Agregar un medio...");
			$(".evidencia").Watermark("Agregar una evidencia...");
			</script>';	
			$tabs .='</ul>';
			$panelcontent .='</div>';
		
		}
		
		
		
		$section .= $tabs;
		$section .= $panelcontent;
		$section .= $script;
		
										
	    return $section;
				
	   }




         function GuardarObjetivos(){
			 
			 $lineas = explode("^",$_POST['lineas']);
			 $lineas_objetivos = explode("|",$_POST['objetivos']);
			 $objetivos_medios = explode("|",$_POST['medios']);
			 $objetivos_evidencias = explode("|",$_POST['evidencias']);
             
             $areas = explode("¬",$_POST['areas']);
             $fortalezas = explode("¬",$_POST['fortalezas']);			
		
			$this->Model->idPlanOpe = $_POST['idPlanOperativo'];
		    $this->Model->lineas =  $lineas;
			$this->Model->objetivos = $lineas_objetivos;
			$this->Model->medios = $objetivos_medios;
			$this->Model->evidencias = $objetivos_evidencias;
			$this->Model->estado = 	$_POST['estado'];
			$this->Model->areas = $areas;
            $this->Model->fortalezas = $fortalezas;
            
            
			$this->Model->GuardarObjetivos();
				 
	
          }
		  
		  
		  function InsertarResultado(){
		  
		  $this->Model->idPlanOpe = $_POST['idPlanO'];
		  $this->Model->idPlanEst = $_POST['idPlanE'];
		  $this->Model->idlinea = $_POST['idLinea'];
		  
		  echo $this->Model->InsertarResultado();

		  }
		  
		  
		  function InsertarMedio(){
		  
		  $this->Model->idPlanOpe = $_POST['idPlanO'];
		  $this->Model->idPlanEst = $_POST['idPlanE'];
		  $this->Model->idResultado = $_POST['idResultado'];
		  
		  echo $this->Model->InsertarMedio();

		  }
		  function InsertarIndicadorMeta(){
		  
			$this->Model->idPlanOpe = $_POST['idPlanO'];
			$this->Model->idPlanEst = $_POST['idPlanE'];
			$this->Model->idResultado = $_POST['idResultado'];
			
			echo $this->Model->InsertarIndicadorMeta();
  
			}

		  
		  
		  
		  function InsertarEvidencia(){
		  
		  $this->Model->idPlanOpe = $_POST['idPlanO'];
		  $this->Model->idPlanEst = $_POST['idPlanE'];
		  $this->Model->idResultado = $_POST['idResultado'];
		  
		  echo $this->Model->InsertarEvidencia();

		  }
		  
		  
		  
		    function InsertarArea(){
		  
		  $this->Model->idPlanOpe = $_POST['idPlanO'];
		  $this->Model->idPlanEst = $_POST['idPlanE'];
		  
		  
		  echo $this->Model->InsertarArea();

		  }
		  
		  
		    function InsertarFortaleza(){
		  
		  $this->Model->idPlanOpe = $_POST['idPlanO'];
		  $this->Model->idPlanEst = $_POST['idPlanE'];
		  
		  
		  echo $this->Model->InsertarFortaleza();

		  }
		  
		  
		  function getObjetivosEstrategicos(){
		  
		  $this->Model->getObjetivosE($_POST['idLinea']);
		  $html = "";
		  $lineaid = $_POST['lineaid'];
		  
		  $contobe = 1;
		
		  $html .='<option value="0">Selecciona Objetivo Estratégico </option>';
		  foreach($this->Model->objetivos as $rowObjE){
		  $html .='<option value="'.$rowObjE['PK1'].'"';
		  $html .='>'.$lineaid.'.'.$contobe++.' '.htmlentities($rowObjE['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</option>';
		  }
		  
		  echo $html;
		  
		  }
		  
		  
		  function getResponsables(){
		  
		  $this->Model->getResponsables($_POST['idPlanO']);
		  $html = "";
		  
		  foreach($this->Model->responsables as $row){
		  
		  $html .=' <option value="'.$row['PK1'].'"';
		  $html .='>'.htmlentities($row['APELLIDOS'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1").'</option>';
			
		  }
		  
		  echo $html;
		  
		  }
		  
		  
		  function deleteResultado(){
		  
		  $this->Model->deleteResultado($_POST['idResultado']);
		  
		  }
		  
		  function deleteMedio(){
		  
		  $this->Model->deleteMedio($_POST['idMedio']);
		  
		  }

		  function deleteIndicadorMeta(){
		  
			$this->Model->deleteIndicadorMeta($_POST['idIndicadorM']);
			
			}
		  
		  
		  function deleteEvidencia(){
		  	
		  	$this->Model->deleteEvidencia($_POST['idEvidencia']);
		  	
		  }
		  
		  
		  function deleteArea(){
		  	
		  	$this->Model->deleteArea($_POST['idArea']);
		  	
		  }
		  
		  
		   function deleteFortaleza(){
		  	
		  	$this->Model->deleteFortaleza($_POST['idFortaleza']);
		  	
		  }
		  
		  
		  
		  
		  
		  function updateResultado(){
		  
		   $this->Model->updateResultado($_POST['idResultado'],$_POST['resultado'],$_POST['objetivo'],$_POST['responsable'],$_POST['indicadores']);
		  
		  
		  }
		  
		function getAndDelIndicadoresByObj(){
			$this->Model->getAndDelIndicadoresByObj($_POST['idResultado'],$_POST['idObjetivo']);
			$html= "";

			if(count($this->Model->indicadoresByObj) > 0){
				foreach($this->Model->indicadoresByObj as $rowObjE){
					if($rowObjE['INDICADOR'] == "" || $rowObjE['INDICADOR'] == null){
						$html ='<p>No existen Indicadores para este Objetivo Estratégico.</p>';
					}else{
						$html .= '<div class="input-prepend INDdiv" style="width:95%;background: #ffffff;;border-bottom: 1px solid #BBBBBB;padding:4px;border-radius:4px;">'
						.'<span id="textindicador111" class="" style="display: inline-block;margin-bottom: -1px;">'
							.'<input id="IND-'.$_POST['idResultado'].'-'.$rowObjE['PK1'].'" idObje="'.$_POST['idResultado'].'"  idObjeEstra="'.$_POST['idObjetivo'].'"type="checkbox" value="'.$rowObjE['PK1'].'" name="" style="margin-bottom:5px;margin-right:15px;">'
						.'</span>'
						.'<span class="add-on" style="margin-top: -10px;">'.$_POST['numeroObjetivo'].'.'.($rowObjE['ORDEN']+1).'</span>'
						.'<p style="margin-left:3px;height:auto;display:inline-block;width:45%;" name="L1-objetivo" readonly=""><b>Indicador al 2024</b><br>'.htmlentities($rowObjE['INDICADOR'], ENT_QUOTES, "ISO-8859-1").'</p>'
						.'<p style="margin-left:3px;height:auto;display:inline-block;width:40%;" name="L1-meta" readonly=""><b>Meta al 2024</b><br>'.htmlentities($rowObjE['META'], ENT_QUOTES, "ISO-8859-1").'</p>'
						.'</div>';

					}

					

				}
			}else{
				$html ='<p>No existen Indicadores para este Objetivo Estratégico.</p>';
			}
			echo $html;
		}
		  function updateMedio(){
		  
		   $this->Model->updateMedio($_POST['idMedio'],$_POST['medio'],$_POST['responsable']);
		  
		  
		  }
		  function updateIndicadorMeta(){
		  
			$this->Model->updateIndicadorMeta($_POST['idIndicadorM'],$_POST['indicadorMeta'],$_POST['meta'],$_POST['numOrden']);
		   
		   
		   }
		  
		  
		  
		  function updateEvidencia(){
		  
		   $this->Model->updateEvidencia($_POST['idEvidencia'],$_POST['evidencia']);
		  
		  
		  }
		  
		  
		  function updateArea(){
		  	
		  	$this->Model->updateArea($_POST['idArea'],$_POST['area']);
		  	
		  }
		  
		  function updateFortaleza(){
		  	
		  	$this->Model->updateFortaleza($_POST['idFortaleza'],$_POST['fortaleza']);
		  	
		  }
		  
		  
		   //---nuevo inicio
		   
		      function InsertarOportunidades(){
		  
		  $this->Model->idPlanOpe = $_POST['idPlanO'];
		  $this->Model->idPlanEst = $_POST['idPlanE'];
		  
		  
		  echo $this->Model->InsertarOportunidades();

		  }
		  
		  
		   function updateOportunidades(){
		  	
		  	$this->Model->updateOportunidades($_POST['idOportunidades'],$_POST['oportunidades']);
		  	
		  }
		  
		  
		    function deleteOportunidades(){
		  	
		  	$this->Model->deleteOportunidades($_POST['idOportunidades']);
		  	
		  }
		  
		  
		  
		  
		    function InsertarDebilidades(){//AMENAZAS
		  
		  $this->Model->idPlanOpe = $_POST['idPlanO'];
		  $this->Model->idPlanEst = $_POST['idPlanE'];
		  
		  
		  echo $this->Model->InsertarDebilidades();

		  }
		  
		  
		   function updateDebilidades(){//AMENAZAS
		  	
		  	$this->Model->updateDebilidades($_POST['idDebilidades'],$_POST['debilidades']);
		  	
		  }
		  
		  
		    function deleteDebilidades(){//AMENAZAS
		  	
		  	$this->Model->deleteDebilidades($_POST['idDebilidades']);
		  	
		  }
		  
		  
		  //--fin nuevo	
		  
		  
		  
		  
		  
		  function OrdenarResultados(){
		  
		      $resultados =  $_POST['idResultados'];
			  $idplanO = $_POST['idPlanO'];
			  
			  $this->Model->OrdenarResultados($idplanO,$resultados);
		  
		  
           }
		  
		  
	

	
}

?>