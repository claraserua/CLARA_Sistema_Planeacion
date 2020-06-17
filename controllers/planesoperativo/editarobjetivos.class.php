<?php
include "models/planesoperativo/editarobjetivos.model.php";
include "libs/resizeimage/class.upload.php";


class editarobjetivos {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $image;
	var $targetPathumbail;
	var $passport;
	

	function editarobjetivos() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->Model = new editarobjetivosModel();
		
	 switch($_GET['method']){
	 	
		case "EnviarRevision":
			$this->EnviarRevision();
			break;
	 	
		case "GuardarObjetivos":
			$this->GuardarObjetivos();
			break;
			
		case "insertarComentarioGeneral":
		     $this->insertarComentarioGeneral();
			 break;
			 
	    case "eliminarComentarioGeneral":
	        $this->eliminarComentarioGeneral();
			break;
			
		default:	
	      $this->View = new View(); 
          $this->loadPage();
		  break;
		}
				 
	}
	
	
	
	 function loadPage(){
	 	
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
	
		$this->View->template = TEMPLATE.'modules/planesoperativo/OBJETIVOS.TPL';	
		$this->View->loadTemplate();
		$this->loadHeader();
		$this->loadMenu();
		
		//if($this->passport->privilegios->hasPrivilege('P30')){
		$this->loadContent();
		//}else{
		//$this->error();
		//}
		$this->loadFooter();
		$this->View->viewPage();
		
	 }
	 
	 
	   function loadHeader(){

	  $section = TEMPLATE.'sections/header.tpl';
	  $section = $this->View->loadSection($section);
	  $nombre = $_SESSION['session']['titulo'].' '.htmlentities($_SESSION['session']['nombre']).' '.htmlentities($_SESSION['session']['apellidos']);
	  $imagen = 'thum_40x40_'.$_SESSION['session']['imagen'];
	  $section = $this->View->replace('/\#AVATAR\#/ms' ,$imagen,$section);
	  $section = $this->View->replace('/\#USUARIO\#/ms' ,$nombre,$section);
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
		
		
		$contenido = $this->View->Template(TEMPLATE.'modules/planesoperativo/EDT2OBJETIVOS.TPL');
		$plan =  $this->Model->getPlanOperativo($_GET['IDPlan']);
		$contenido =  $this->View->replace('/\#TITULOPLAN\#/ms' ,htmlentities($plan['TITULO']),$contenido);
		
		$user = $_SESSION['session']['user'];
		$salida = "&IDPlan=".$_GET['IDPlan']."&user=".$user;
		$contenido =  $this->View->replace('/\#SALIDA\#/ms' ,$salida,$contenido);
		
		if($this->passport->isActivo($_GET['IDPlan'])){
			
			$alertaactivo = "<script type=\"text/javascript\">$.blockUI({ 
            message: '<strong>!oh!</strong> El plan operativo esta siendo modificado por el usuario: <strong>".$plan['ACTIVO']."</strong><br/> Se recomienda editarlo más tarde. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0)\" onclick=\"Omitir();\" style=\"color:#FFFFFF;\"><strong>Omitir y editar</strong> <span title=\".icon  .icon-white  .icon-cross \" class=\"icon icon-white icon-cross\"></a></span>', 
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
		
		$contenido =  $this->View->replace('/\#ESTADO\#/ms' ," ",$contenido);
		
		
		if($this->passport->getPrivilegio($_GET['IDPlan'],'P46')){
		
	    $fresumen ='<li class=""> <a href="#resumen">Diagnóstico Inicial</a></li>';
		$contenido =  $this->View->replace('/\<!--#FRESUMENEJECUTIVO#-->/ms' ,$fresumen,$contenido);	
			}
		
		
		
		if($this->passport->getPrivilegio($_GET['IDPlan'],'P44')){
		
	    $btnguardar ='<button class="btn-warning btn-large" onclick="Salvar2();"><span class="icon icon-white icon-save"></span> Guardar</button>';
		$contenido =  $this->View->replace('/\<!--#BTNGUARDAR#-->/ms' ,$btnguardar,$contenido);	
			}
			
		
	    $btnenviar ='';
		
		$contenido =  $this->View->replace('/\<!--#BTNENVIARREVISION#-->/ms' ,$btnenviar,$contenido);	

		
		
		$mostrarcomeng = "";
		 
		 if(!$this->passport->getPrivilegio($_GET['IDPlan'],'P151')){
		 $mostrarcomeng ='style="display:none;"';	
		 }
		 
	
		 $contenido =  $this->View->replace('/\#OCULTARCOMENTARIOSG\#/mss' ,$mostrarcomeng,$contenido);
		
		
		
		$contenido =  $this->View->replace('/\#RESPONSABLES\#/ms' ,$this->obtenerResponsables(),$contenido);
		$contenido =  $this->View->replace('/\#CONTENIDO\#/ms' ,$this->obtenerLineas(),$contenido);
		$contenido =  $this->View->replace('/\<!--#VALUEDESCRIPCION#-->/ms' ,htmlspecialchars_decode($this->getResumenEjecutivo()),$contenido);
		
		
		$contenido =  $this->View->replace('/\#COMENTARIOSGENERALES\#/ms' ,$this->getComentariosGenerales(),$contenido);
		
		
		
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
		  <span class="add-on" id="LABEL-AREA-'.$loop.'">'.$loop.'.</span>
          <input type="text" class="area" style="width:85%;" value="'.htmlentities($row['AREA']).'"  id="INPUT-AREA-'.$loop.'">
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
		  <span class="add-on" id="LABEL-FORTALEZA-'.$loop.'">'.$loop.'.</span>
          <input type="text" class="fortaleza" style="width:85%;" value="'.htmlentities($row['FORTALEZA']).'"  id="INPUT-FORTALEZA-'.$loop.'">
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
			$(".area").Watermark("Agrega area de oportunidad...");
			$(".fortaleza").Watermark("Agrega fortaleza...");
			</script>';	
	    	$htmLcontent .= $script;
		
			return $htmLcontent;
	   }
	   
	   
	   
	   function obtenerResponsables($responsable=NULL){
	   	
		$panelcontent = "";
		$this->Model->getResponsables();
		
		foreach($this->Model->responsables as $row){
				
		$panelcontent .=' <option value="'.$row['PK1'].'"';     
		
		if($responsable==$row['PK1']){
			$panelcontent .= 'selected="selected"';
		}
		
		$panelcontent .='>'.htmlentities($row['APELLIDOS'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1").'</option>';
			
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
			lineas_objetivos_medios['.$loop.'] = new Array();
			lineas_objetivos_evidencias['.$loop.'] = new Array();
			
			 ';
			
			$idlinea = $row['PK1'];		
			$linea = $row['LINEA'];		
			
			$bodyestado =  htmlentities($linea, ENT_QUOTES, "ISO-8859-1");
			$titlestado = "Linea ".$cont.":";
	
			
			$tabs .='<li data-rel="popover" data-content="'.$bodyestado.'" title="'.$titlestado.'"><a href="#linea'.$cont.'">Linea '.$cont.'</a></li>';
			$panelcontent .='<div class="tab-pane" id="linea'.$cont.'">';
			$panelcontent .='<div class="box" id="L'.$cont.'" >
                     <div class="box-head" >
					 <h2 class="left">Línea estratégica '.$cont.': '.htmlentities($linea, ENT_QUOTES, "ISO-8859-1").'</h2>	
			          <input type="hidden" id="PK_LINEA_'.$cont.'" value="'.$idlinea.'"/>		 
					</div>';
            
			
		$this->Model->getObjetivosTacticos($_GET['IDPlan'],$idlinea);
		$numobjetivos = sizeof($this->Model->objetivos); 
		
		$contobjetivo = 1;
		$loopobjetivo = 0;
		$disabledobjetivo = ($numobjetivos>1)? "" : "disabled=\"disabled\"";
		
		if($numobjetivos != 0){
			
		foreach($this->Model->objetivos as $rowobj){
				
			
	    $script .='
	        arraylineas_objetivos['.$loop.'].push("1");
			lineas_objetivos_medios['.$loop.']['.$loopobjetivo.'] = new Array();
			lineas_objetivos_evidencias['.$loop.']['.$loopobjetivo.'] = new Array();
			 ';
			
			
          $panelcontent .='<!--====================OBJETIVO=====================--> 
          
		  <div class="wellstrong" id="L'.$cont.'-C'.$contobjetivo.'">
                   
          <table width="100%">
	      <tr>
	      <td colspan="2"><b><font size="2">Objetivo Estratégico:</font></b>
	      <select id="L'.$cont.'-OE'.$contobjetivo.'" style="width:100%;">';
	    
	        $this->Model->getObjetivosE($idlinea);
			$contobe=1;
	        foreach($this->Model->objetivosE as $rowObjE){  	
			$panelcontent .='<option value="'.$rowObjE['PK1'].'"';
			
			if($rowobj['PK_OESTRATEGICO']==$rowObjE['PK1']){
			$panelcontent .= 'selected="selected"';
		    }
			
			$panelcontent .='>'.$cont.'.'.$contobe++.' '.htmlentities($rowObjE['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</option>';
			}
		
			
	   $panelcontent .='</select> </td>
	  
	   </tr>
	  
	  
	   <tr>
       <td><b><font size="2">Resultado:</font></b></td>
       <td><b><font size="2"> Responsable:</font></b></td>
       </tr>
                    
       <tr>
       <td width="70%">   
		<div class="input-prepend">
		   <span class="add-on" id="LABEL-L'.$cont.'-O'.$contobjetivo.'">'.$cont.'.'.$contobjetivo.'</span>
		   <textarea name="resultado" style="width:90%;" id="L'.$cont.'-O'.$contobjetivo.'" class="objetivo">'.htmlentities($rowobj['OBJETIVO']).'</textarea>
		   
		</div>
       </td>
      
       <td width="30%"><select id="L'.$cont.'-OR'.$contobjetivo.'" style="width:100%;" >';
	   
	   $panelcontent .= $this->obtenerResponsables($rowobj['PK_RESPONSABLE']);      
	   $panelcontent .='</select></td>
       </tr>
       </table>
           
	<div class="box-icon">
<a href="javascript:void(0)" onclick="Toogle(this.id);" class="btn btn-minimize btn-round" id="TOG-L'.$cont.'-C'.$contobjetivo.'"><i class="icon-chevron-up"></i></a>						
</div>
		   
      <div class="box-objectivos" id="BOX-L'.$cont.'-C'.$contobjetivo.'">
       <div class="well" >
       <table width="100%">
        <tr>
        <td width="2%">&nbsp;	</td>
        <td width="70%"><b><font size="2">Medios:</font></b></td>
        <td width="28%"><b><font size="2">Responsable:</font></b></td>
        </tr>';
         
		 
		 
		$this->Model->getMedios($rowobj['PK1']);
		$nummedios = sizeof($this->Model->medios); 
		
		$contmedio = 1;
		$loopmedio = 0;
		
		$disabled = ($nummedios>1)? "" : "disabled=\"disabled\"";
		
		if($nummedios != 0){
			
			
			foreach($this->Model->medios as $rowmedios){
		    $script .='
			lineas_objetivos_medios['.$loop.']['.$loopobjetivo.'].push("1");
			 ';	
		 
       $panelcontent .=' <tr id="L'.$cont.'-O'.$contobjetivo.'-M'.$contmedio.'-C'.$contobjetivo.'">
        <td>&nbsp; </td>
        <td>  
        <div class="input-prepend">
		<span class="add-on" id="LABEL-L'.$cont.'-O'.$contobjetivo.'-M'.$contmedio.'">'.$cont.'.'.$contobjetivo.'.'.$contmedio.'</span>
        
		
		<textarea name="medio" style="width:86%;" id="L'.$cont.'-O'.$contobjetivo.'-M'.$contmedio.'" class="medio">'.htmlentities($rowmedios['MEDIO']).'</textarea>
		
		</div> 
        </td>                          
        <td>
		<select id="L'.$cont.'-O'.$contobjetivo.'-M'.$contmedio.'-R'.$contmedio.'"> ';
		
		$panelcontent .= $this->obtenerResponsables($rowmedios['PK_RESPONSABLE']);    
		
		$panelcontent .= '</select></td>
        </tr>';
		
		$contmedio++;
		$loopmedio++;
		   }
		}
                    
       $panelcontent .=' <tr>	
        <td colspan="2">
        <div class="left" style="margin-left:30px;">           
        <button class="btn btn-small" '.$disabled.' id="BEM-L'.$cont.'-O'.$contobjetivo.'"  onclick="EliminarMedio(this.id);" style="float:left; margin-right:10px;"><i class="icon-remove"></i> Eliminar medio</button>
                    
		
         <button class="btn btn-small" id="BAM-L'.$cont.'-O'.$contobjetivo.'"  onclick="AgregarMedio(this.id);"><i class="icon-plus"></i>Agregar Medio</button>				
		</div>            
        </td>
        </tr>
        </table>
        </div>
                      
                      
                      
         <div class="well">
         <table width="100%">
         <tr>
         <td width="30">&nbsp;	</td>
         <td><b><font size="2">Evidencias</b></font>	</td>            
         </tr>';
		 
		 
		$this->Model->getEvidencias($rowobj['PK1']);
		$numevidencias = sizeof($this->Model->evidencias); 
		
		$contevidencia = 1;
		$loopevidencia = 0;
		
		$disabled = ($numevidencias>1)? "" : "disabled=\"disabled\"";
			
		if($numevidencias != 0){
			
			
		foreach($this->Model->evidencias as $rowevidencias){
		
		$script .='
		        lineas_objetivos_evidencias['.$loop.']['.$loopobjetivo.']['.$loopevidencia.'] = "1";
			     ';	           
          
         $panelcontent .=' <tr id="L'.$cont.'-O'.$contobjetivo.'-E'.$contevidencia.'-C'.$contobjetivo.'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  <span class="add-on" id="LABEL-L'.$cont.'-O'.$contobjetivo.'-E'.$contevidencia.'">'.$cont.'.'.$contobjetivo.'.'.$contevidencia.'</span>
          <input id="L'.$cont.'-O'.$contobjetivo.'-E'.$contevidencia.'" class="evidencia" value="'.htmlentities($rowevidencias['EVIDENCIA']).'"   style="width:90%;" type="text">
		  </div> 
          </td>
          </tr>';
		  
		  
		$contevidencia++;
		$loopevidencia++;
                    }
				}
					
          $panelcontent .='<tr>
          <td colspan="2">
          <div class="left" style="margin-left:30px;">         
          <button class="btn btn-small" '.$disabled.' id="BEE-L'.$cont.'-O'.$contobjetivo.'"  onclick="EliminarEvidencia(this.id);" style="float:left; margin-right:10px;"><i class="icon-remove"></i> Eliminar Evidencia</button>
	      <button class="btn btn-small" id="BAE-L'.$cont.'-O'.$contobjetivo.'"  onclick="AgregarEvidencia(this.id);"><i class="icon-plus"></i>Agregar Evidencia</button>			
		  </div>
          </td>
          </tr>     
          </table>
          </div> 
                </div>     
          
          
          </div>
           <!--====================END OBJETIVO=====================-->';
           $contobjetivo++;
		   $loopobjetivo++;
		    }
			
		 }else{
		 	
			   //NO EXISTE OBJETIVO
			   
			   $script .='
	        arraylineas_objetivos['.$loop.'].push("1");
			lineas_objetivos_medios['.$loop.']['.$loopobjetivo.'] = new Array();
			lineas_objetivos_evidencias['.$loop.']['.$loopobjetivo.'] = new Array();
			 ';
			
			
          $panelcontent .='<!--====================OBJETIVO=====================--> 
          
		  <div class="wellstrong" id="L'.$cont.'-C'.$contobjetivo.'">
                   
          <table width="100%">
	      <tr>
	      <td colspan="2">Objetivo Estratégico:
	      <select id="L'.$cont.'-OE'.$contobjetivo.'" style="width:100%;">';
	    
	        $this->Model->getObjetivosE($idlinea);
			
	        foreach($this->Model->objetivosE as $rowObjE){  	
			$panelcontent .='<option value="'.$rowObjE['PK1'].'"';
			
			if($rowobj['PK_OESTRATEGICO']==$rowObjE['PK1']){
			$panelcontent .= 'selected="selected"';
		    }
			
			$panelcontent .='>'.htmlentities($rowObjE['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</option>';
			}
		
			
	   $panelcontent .='</select> </td>
	  
	   </tr>
	  
	  
	   <tr>
       <td><b><font size="2">Resultado:</font></b></td>
       <td><b><font size="2">Responsable:</font></b></td>
       </tr>
                    
       <tr>
       <td width="70%">   
		<div class="input-prepend">
		   <span class="add-on" id="LABEL-L'.$cont.'-O'.$contobjetivo.'">'.$cont.'.'.$contobjetivo.'</span>
           
		   <textarea name="resultado" style="width:90%;" id="L'.$cont.'-O'.$contobjetivo.'" class="objetivo"></textarea>
		   
		</div>
       </td>
      
       <td width="30%"><select id="L'.$cont.'-OR'.$contobjetivo.'" style="width:100%;" >';
	   
	   $panelcontent .= $this->obtenerResponsables($rowobj['PK_RESPONSABLE']);      
	   
	   $panelcontent .='</select></td>
       </tr>
       </table>
           
	<div class="box-icon">
<a href="javascript:void(0)" onclick="Toogle(this.id);" class="btn btn-minimize btn-round" id="TOG-L'.$cont.'-C'.$contobjetivo.'"><i class="icon-chevron-up"></i></a>						
</div>
		   
      <div class="box-objectivos" id="BOX-L'.$cont.'-C'.$contobjetivo.'">
       <div class="well" >
       <table width="100%">
        <tr>
        <td width="2%">&nbsp;	</td>
        <td width="70%"><b><font size="2">Medios:</font></b></td>
        <td width="28%"><b><font size="2">Responsable:</font></b></td>
        </tr>';
         
		 
	     //MEDIOS	
		$contmedio = 1;
		
		$disabled = ($nummedios>1)? "" : "disabled=\"disabled\"";
		
			
		    $script .='
			lineas_objetivos_medios['.$loop.']['.$loopobjetivo.'].push("1");
			 ';	
		 
       $panelcontent .=' <tr id="L'.$cont.'-O'.$contobjetivo.'-M'.$contmedio.'-C'.$contobjetivo.'">
        <td>&nbsp; </td>
        <td width="540">  
        <div class="input-prepend">
		<span class="add-on" id="LABEL-L'.$cont.'-O'.$contobjetivo.'-M'.$contmedio.'">'.$cont.'.'.$contobjetivo.'.'.$contmedio.'</span>
        
		<textarea name="medio" style="width:86%;" id="L'.$cont.'-O'.$contobjetivo.'-M'.$contmedio.'" class="medio"></textarea>
		
		</div> 
        </td>                          
        <td>
		<select id="L'.$cont.'-O'.$contobjetivo.'-M'.$contmedio.'-R'.$contmedio.'"> ';
		
		$panelcontent .= $this->obtenerResponsables($rowmedios['PK_RESPONSABLE']);    
		
		$panelcontent .= '</select></td>
        </tr>';
		
		
		   
		
                    
       $panelcontent .=' <tr>	
        <td colspan="2">
        <div class="left" style="margin-left:30px;">           
        <button class="btn btn-small" '.$disabled.' id="BEM-L'.$cont.'-O'.$contobjetivo.'"  onclick="EliminarMedio(this.id);" style="float:left; margin-right:10px;"><i class="icon-remove"></i> Eliminar medio</button>
                    
		
         <button class="btn btn-small" id="BAM-L'.$cont.'-O'.$contobjetivo.'"  onclick="AgregarMedio(this.id);"><i class="icon-plus"></i>Agregar Medio</button>				
		</div>            
        </td>
        </tr>
        </table>
        </div>
                      
                      
                      
         <div class="well">
         <table width="100%">
         <tr>
         <td width="30">&nbsp;	</td>
         <td><b><font size="2">Evidencias:	</font></b></td>            
         </tr>';
		 
		 
		//EVIDENCIAS
		
		$contevidencia = 1;
		$loopevidencia = 0;
		
		//$disabled = ($numevidencias>1)? "" : "disabled=\"disabled\"";
			
		$script .='
		        lineas_objetivos_evidencias['.$loop.']['.$loopobjetivo.']['.$loopevidencia.'] = "1";
			     ';	           
          
         $panelcontent .=' <tr id="L'.$cont.'-O'.$contobjetivo.'-E'.$contevidencia.'-C'.$contobjetivo.'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  <span class="add-on" id="LABEL-L'.$cont.'-O'.$contobjetivo.'-E'.$contevidencia.'">'.$cont.'.'.$contobjetivo.'.'.$contevidencia.'</span>
          <input id="L'.$cont.'-O'.$contobjetivo.'-E'.$contevidencia.'" class="evidencia" value=""   style="width:90%;" type="text">
		  </div> 
          </td>
          </tr>';
		  
		  
					
          $panelcontent .='<tr>
          <td colspan="2">
          <div class="left" style="margin-left:30px;">         
          <button class="btn btn-small" '.$disabled.' id="BEE-L'.$cont.'-O'.$contobjetivo.'"  onclick="EliminarEvidencia(this.id);" style="float:left; margin-right:10px;"><i class="icon-remove"></i> Eliminar Evidencia</button>
	      <button class="btn btn-small" id="BAE-L'.$cont.'-O'.$contobjetivo.'"  onclick="AgregarEvidencia(this.id);"><i class="icon-plus"></i>Agregar Evidencia</button>			
		  </div>
          </td>
          </tr>     
          </table>
          </div> 
                </div>     
          
          
          </div>
           
		   <!--====================END OBJETIVO=====================-->';
			   
			   //$contobjetivo++;
		       //$loopobjetivo++;
			   //END NO EXISTE OBJETIVO
			
		 }          
		
           $panelcontent .='<!-- Pagging -->
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
                        <div class="right">';
                      
					  
	if($this->passport->getPrivilegio($_GET['IDPlan'],'P68')){
		$panelcontent .='<button class="btn btn-large" '.$disabledobjetivo.' id="BEO-L'.$cont.'" onclick="EliminarObjetivo(this.id);" style="float:left; margin-right:10px;"><i class="icon-remove"></i> Eliminar Resultado
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
			$loop++;
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



       function EnviarRevision(){
			 
			$this->Model->EnviarRevision($_POST['idPlanOperativo'],$_POST['idPlanE']);
				 
          }


      function GuardarObjetivos(){
			
			 $this->Model->EliminarObjetivos($_POST['idPlanOperativo']);
			 
			 $lineas = explode("^",$_POST['lineas']);
			 $lineas_objetivos = explode("|",$_POST['objetivos']);
			 $objetivos_medios = explode("|",$_POST['medios']);
			 $objetivos_evidencias = explode("|",$_POST['evidencias']);
             $areas = explode("¬",$_POST['areas']);
             $fortalezas = explode("¬",$_POST['fortalezas']);
             
			
			
			$this->Model->idplane = $_POST['idPlanE'];;
		
			$this->Model->idPlanOpe = $_POST['idPlanOperativo'];
		    $this->Model->lineas =  $lineas;
			$this->Model->objetivos = $lineas_objetivos;
			$this->Model->medios = $objetivos_medios;
			$this->Model->evidencias = $objetivos_evidencias;
            $this->Model->areas = $areas;
            $this->Model->fortalezas = $fortalezas;
		    $this->Model->estado = 	$_POST['estado'];
		 
			
			
			$this->Model->GuardarObjetivos();
				 
	
          }
		  
          
		  function getComentariosGenerales(){
		  	
			$panelcontent = "";
			
			$permiso = 'P149'; //($_GET['estado']=="R") ? "P87" : "P51";
			   if($this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){
			$panelcontent = '<!--====================COMENTARIOS=====================-->
		  
		   <div id="twitter-container">
			
			    <span class="counter" id="counter-general">&nbsp;</span>
			    <textarea name="inputField" id="inputField-general"   tabindex="1" rows="2" cols="40"></textarea>';
			   
			   if($this->passport->getPrivilegio($_GET['IDPlan'],'P82')){ 
				  $panelcontent .= '<label class="checkbox inline">
			   <div class="checker"><span><input type="checkbox" value="option1" id="mandatorio-general" style="opacity: 0;"></span></div><h3>Mandatorio</h3>
				</label>';
				}
			   
			  $panelcontent .= '<input class="submitButton inact" name="submit" type="button" onClick="guardarComentarioGeneral();" value="comentar" disabled="disabled" id="btncomentariogeneral" />
			    <div class="clear"></div>
		    
		  </div>';
		  
		  }
		  
       $panelcontent .='<div id="flashmessage">	
    <div id="flash"></div>
	  		</div>
   		  <div class="comentarios" id="comentarios-general">';
		  
		  
		            
	           $this->Model->getComentariosGenerales($_GET['IDPlan']);
		       $numcomentarios = sizeof($this->Model->comentarios); 
		  
		            
					if($numcomentarios != 0){
			
						foreach($this->Model->comentarios as $rowcomentariosr){
 						{
							
							$tipo = trim($rowcomentariosr['TIPO']);
							$comentario_id=$rowcomentariosr['PK1'];
							$usuario_id=$rowcomentariosr['PK_USUARIO'];
							$fecha = $rowcomentariosr['FECHA_R'];
							$comentario = stripslashes(htmlentities($rowcomentariosr['COMENTARIO']));
							
							$rowusuario	= $this->Model->getImagen($usuario_id);	
							$imagen =  "media/usuarios/".$rowusuario['IMAGEN'];
							
							$usuario = $rowusuario['NOMBRE']." ".$rowusuario['APELLIDOS'];
							 
							 
							if($tipo=="M"){$class = "stbody2"; $class2='<span class="label label-important">Mandatorio</span>'; }else{ $class = "stbody"; $class2=""; }
							 
				$panelcontent .='<div class="'.$class.'" id="stbodyg'.$comentario_id.'">
    		<div class="sttimg"><img src="'.$imagen.'" class="big_face"/></div> 
    		<div class="sttext">';
			
			
			$permiso = "P150"; // ($_GET['estado']=="R") ? "P88" : "P52";
			if($this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){
		   $panelcontent .='<a class="stdeleteg" href="#" id="g'.$comentario_id.'" title="Borrar comentario"><i class="icon-remove"></i></a>';
		   }
			
			 $panelcontent .= ' 
    					<strong><a href="#" class="comentuser">'.htmlentities($usuario).'</a></strong>
						'.$class2.'<br>
						'.$comentario.'
   						<div class="sttime">'.date('d/m/Y H:i:s', strtotime($fecha)).'</div> 
    				</div>  
				</div>';
    
 		}
	 }
	
	}
	
   $panelcontent .=' </div>
        
                     <!--====================END COMENTARIOS=====================-->';
		  
			return $panelcontent;
		  }
		  		  
		  
		  function insertarComentarioGeneral(){
	
			
			if(isset($_POST['tipo'])){$tipo = $_POST['tipo'];}else{ $tipo = "R";}
			
			if($tipo=="M"){$class = "stbody2"; $class2='<span class="label label-important">Mandatorio</span>';}else{ $class = "stbody"; $class2=""; }
			
			$id = $this->Model->insertarComentarioGeneral($_POST['comentario'],$_POST['idplan'],$tipo);
		    $usuario = $_SESSION['session']['titulo'].' '.$_SESSION['session']['nombre'].' '.$_SESSION['session']['apellidos'];
		    $imagen = 'media/usuarios/thum_40x40_'.$_SESSION['session']['imagen'];
			
			$fecha = date("d/m/Y H:i:s");
			
			echo '<div class="'.$class.'" id="stbodyg'.$id.'">
    <div class="sttimg"><img src="'.$imagen.'" class="big_face"/></div> 
    <div class="sttext"><a class="stdeleteg" href="#" id="g'.$id.'" title="Borrar comentario"><i class="icon-remove"></i></a>
	
	<strong><a href="#">'.htmlentities($usuario).'</a></strong>
	'.$class2.'
	<br/>
    '.$_POST['comentario'].'
   	<div class="sttime">'.$fecha.'</div> 
</div>';
		 	
		 }

          
		  function eliminarComentarioGeneral(){
	
			$this->Model->eliminarComentarioGeneral($_POST['idcomentario']);
		
		  }

	
}

?>