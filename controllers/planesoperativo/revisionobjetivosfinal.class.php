<?php
include "models/planesoperativo/revisionobjetivosfinal.model.php";
include "libs/resizeimage/class.upload.php";


class revisionobjetivosfinal {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $image;
	var $targetPathumbail;
	var $passport;

	private $userG; 
    private $isAdm;
    private $permisosArray;
    private $permisoG;
	

	function revisionobjetivosfinal() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->Model = new revisionobjetivosfinalModel();

	 //Permisos
	 $this->userG = $_SESSION['session']['user'];
	 $this->isAdm = $this->passport->isAdmin($this->userG);
	 if(isset($_GET['IDPlan'])){
		 $this->permisosArray = $this->passport->getPrivilegio2($_GET['IDPlan']);
		 //$this->permisoG = $this->Model->obtenerEstadoPlan($_GET['IDPlan']);


	 }else if(isset($_POST['IDPlan'])){
		 $this->permisosArray = $this->passport->getPrivilegio2($_POST['IDPlan']);
		 //$this->permisoG = $this->Model->obtenerEstadoPlan($_POST['IDPlan']);
	 }
		
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
		//Permisos
		//$this->userG = $_SESSION['session']['user'];
		//$this->isAdm = $this->passport->isAdmin($this->userG);
		//$this->permisosArray = $this->passport->getPrivilegio2($_GET['IDPlan']);
		$this->Model->getResponsables();


		$this->View->template = TEMPLATE.'modules/planesoperativo/REVISION.TPL';	
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
	  $nombre = htmlentities($_SESSION['session']['titulo'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($_SESSION['session']['nombre'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($_SESSION['session']['apellidos'], ENT_QUOTES, "ISO-8859-1");
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
		
		
		$contenido = $this->View->Template(TEMPLATE.'modules/planesoperativo/FRMREVISIONFINAL.TPL');
		$plan =  $this->Model->getPlanOperativo($_GET['IDPlan']);
		$contenido =  $this->View->replace('/\#TITULOPLAN\#/ms' ,htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1"),$contenido);
		
		$user = $_SESSION['session']['user'];
		$salida = "&IDPlan=".$_GET['IDPlan']."&user=".$user;
		$contenido =  $this->View->replace('/\#SALIDA\#/ms' ,$salida,$contenido);
		
		
		$contenido =  $this->View->replace('/\#ESTADO\#/ms' ,$this->Model->getEstadoPlanOperativo($_GET['IDPlan']),$contenido);
		
		
		//if($this->passport->getPrivilegio($_GET['IDPlan'],'P46')){
		if ($this->isAdm || in_array('P46',$this->permisosArray) ) {
	    $fresumen ='<li class=""> <a href="#resumen">Diagnóstico Inicial</a></li>';
		$contenido =  $this->View->replace('/\<!--#FRESUMENEJECUTIVO#-->/ms' ,$fresumen,$contenido);	
			}
		
		
		$btnvprevia ='<button class="btn btn-large" onclick="ImprimirPlanHtml(\''.$_GET['IDPlan'].'\',\''.$_GET['IDPlanE'].'\');"><span class="icon-zoom-in"></span> Vista Previa</button>';
		$contenido =  $this->View->replace('/\<!--#BTNPREVIA#-->/ms' ,$btnvprevia,$contenido);	
		
		
		//if($this->passport->getPrivilegio($_GET['IDPlan'],'P44')){
		if ($this->isAdm || in_array('P44',$this->permisosArray) ) {
	    /*$btnguardar ='<button class="btn-warning btn-large" onclick="Salvar2();"><span class="icon icon-white icon-save"></span> Guardar</button>';*/
		$btnguardar ="";
		
		$contenido =  $this->View->replace('/\<!--#BTNGUARDAR#-->/ms' ,$btnguardar,$contenido);	
			}
			
			
		/*if($this->passport->getPrivilegio($_GET['IDPlan'],'P45')){
			
	    $btnenviar ='
		<button class="btn btn-large btn-primary" onclick="Enviar();"><span class="icon icon-white icon-sent"></span> Enviar P/Revisión</button>';
		
		$contenido =  $this->View->replace('/\<!--#BTNENVIARREVISION#-->/ms' ,$btnenviar,$contenido);	
			}*/
			
			
			$urlcancelar="<a href=\"?execute=planesoperativo/revisionobjetivos&method=default&estado=".$_GET['estado']."&Menu=F2&SubMenu=SF21&IDPlan=".$_GET['IDPlan']."&IDPlanE=".$_GET['IDPlanE']."\" class=\"btn btn-large\"><i class=\"icon-chevron-left\"></i> Regresar a Revisión</a>";
			$contenido =  $this->View->replace('/\<!--#BTNENVIARREVISION#-->/ms' ,$urlcancelar,$contenido);
		
		
		$mostrarcomeng = "";
		 
		 //if(!$this->passport->getPrivilegio($_GET['IDPlan'],'P151')){
		if (!$this->isAdm || !in_array('P151',$this->permisosArray) ) {
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
		
		$this->Model->getAreas();//debilidades
		$this->Model->getFortalezas();
		$this->Model->getAmenazas();//amenazas   nuevo
		$this->Model->getOportunidades();//nuevo		
		
		$numareas = sizeof($this->Model->areas);
		$numfortalezas = sizeof($this->Model->fortalezas); 		
	
		$numoportunidades = sizeof($this->Model->oportunidades); //nuevo		
		$numamenazas = sizeof($this->Model->amenazas); //  numamenazas nuevo		
	
				
		$htmLcontent = '<div class="box-objectivos" id="BOX-AREAS">';
		
		
		  $htmLcontent .= '  <div class="well" >';		  
		  
		   $htmLcontent .= '<div style="color: #e68376;  font-size:14px; font-weight: bold; ">Análisis Interno</div></br>';		  
		  
         $htmLcontent .= '  <table width="100%" id="FORTALEZAST">
         <tbody>
		 
		 		 
		 
		 <tr>
         <td width="30">&nbsp;	</td>
         <td>Fortalezas	</td>            
         </tr>';           
          
          
		$loop = 1;
		if($numfortalezas != 0){ 
		
		
		if($numfortalezas>2){
		$script .='$(\'#BEFORTALEZA\').removeAttr("disabled");';
		}
		
		foreach($this->Model->fortalezas as $row){
          
		 
		 $htmLcontent .= ' <tr id="'.$row['PK1'].'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend" style="margin-right:-50px;">
		  <span class="add-on"  id="LABEL-FORTALEZA-'.$loop.'">'.$loop.'.</span>
          <input type="text" onblur="UpdateFortaleza(\''.$row['PK1'].'\');" id="FORTALEZA-'.$row['PK1'].'" class="fortaleza" style="width:85%;" value="'.htmlentities($row['FORTALEZA'], ENT_QUOTES, "ISO-8859-1").'" >
		  </div> 
          </td>
          
          <td>
          <button style="float:left; margin-right:10px;" onclick="EliminarFortaleza(\''.$row['PK1'].'\');" id="BEFORTALEZA-'.$row['PK1'].'" class="btn btn-small"><i class="icon icon-remove"></i> </button>
          
           <button onclick="UpdateFortaleza(\''.$row['PK1'].'\');" id="BSFORTALEZA-'.$row['PK1'].'"  class="btn btn-small"><i class="icon icon-save"></i></button>
          
          </td>
          
          </tr>';
		  $loop++;
		 }
		 }else{
		    
		    /*$script .='array_fortalezas.push("1");';	
			$htmLcontent .= ' <tr id="FORTALEZA-1">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  <span class="add-on" id="LABEL-FORTALEZA-1">1.</span>
          <input type="text" class="fortaleza" style="width:85%;" id="INPUT-FORTALEZA-1">
		  </div> 
          </td>
          </tr>';*/
			
		 }
		  
		  
                    
          $htmLcontent .='   
          </tbody></table>
          
          <div style="margin-left:30px;" class="left">';         
          
		   //if($this->passport->getPrivilegio($_GET['IDPlan'],'P139')){
		if ($this->isAdm || in_array('P139',$this->permisosArray) ) {
		  /*$htmLcontent .='<button style="float:left; margin-right:10px;" onclick="EliminarFortaleza();" id="BEFORTALEZA" disabled="disabled" class="btn btn-small"><i class="icon-remove"></i> Eliminar Fortaleza</button>';*/
		  }
		  
	       //if($this->passport->getPrivilegio($_GET['IDPlan'],'P138')){
			if ($this->isAdm || in_array('P138',$this->permisosArray) ) {
		  $htmLcontent .='<button onclick="AgregarFortaleza();"  class="btn btn-small"><i class="icon-plus"></i>Agregar Fortaleza</button>';
		  }		
		  $htmLcontent .='</div>
          
          </div>';
			
      //Áreas de oportunidad
       $htmLcontent .= ' <div class="well">
         <table width="100%" id="AREAST">
         <tbody><tr>
         <td width="30">&nbsp;	</td>
         <td>Debilidades</td>            
         </tr>';           
          
		  
		$loop = 1;
		if($numareas != 0){ 
		
		if($numareas>2){
		$script .='$(\'#BEAREA\').removeAttr("disabled");';
		}
		
		foreach($this->Model->areas as $row){
          
		 $htmLcontent .= '<tr id="'.$row['PK1'].'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend" style="margin-right:-50px;">
		  <span class="add-on" id="LABEL-AREA-'.$loop.'">'.$loop.'.</span>
          <input type="text" onblur="UpdateArea(\''.$row['PK1'].'\');" class="area" id="AREA-'.$row['PK1'].'" style="width:85%;" value="'.htmlentities($row['AREA'], ENT_QUOTES, "ISO-8859-1").'" >
          
		  </div> 
          </td>
          <td>
          <button style="float:left; margin-right:10px;" onclick="EliminarArea(\''.$row['PK1'].'\');" id="BEAREA-'.$row['PK1'].'" class="btn btn-small"><i class="icon icon-remove"></i> </button>
          
           <button onclick="UpdateArea(\''.$row['PK1'].'\');" id="BSAREA-'.$row['PK1'].'"  class="btn btn-small"><i class="icon icon-save"></i></button>
          
          </td>
          </tr>';
		  $loop++;
		 }
		 }else{
		    
			/*$htmLcontent .= ' <tr id="AREA-1">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  <span class="add-on" id="LABEL-AREA-1">1.</span>
          
		  </div> 
          </td>
          </tr>';*/
			
		 }
                    
        $htmLcontent .= '   
          </tbody></table>
          
          <div style="margin-left:30px;" class="left">';
		  //if($this->passport->getPrivilegio($_GET['IDPlan'],'P128')){
			if ($this->isAdm || in_array('P128',$this->permisosArray) ) {
			/*	   
          $htmLcontent .= '<button style="float:left; margin-right:10px;" onclick="EliminarArea();" id="BEAREA" disabled="disabled" class="btn btn-small"><i class="icon-remove"></i> Eliminar Área</button>';*/
	      }
		  
		  //if($this->passport->getPrivilegio($_GET['IDPlan'],'P127')){
			if ($this->isAdm || in_array('P127',$this->permisosArray) ) {
				   
          $htmLcontent .= '
		  <button onclick="AgregarArea();"  class="btn btn-small"><i class="icon-plus"></i>Agregar Debilidad</button>';			   
		  }
		  
		  $htmLcontent .= '</div>
          </div>';
                  
				  
			//nuevo

	$htmLcontent .= '  <div class="well" >';
	
	 $htmLcontent .= '<div style="color: #e68376;  font-size:14px; font-weight: bold; ">Análisis Externo</div></br>';		  
	
        $htmLcontent .= '  <table width="100%" id="OPORTUNIDADEST">
         <tbody>	 
		 
		 <tr>
         <td width="30">&nbsp;	</td>
         <td>Oportunidades </td>            
         </tr>';           
          
          
		$loop = 1;
		if($numoportunidades != 0){ 
		
		
		if($numoportunidades>2){
		$script .='$(\'#BEOPORTUNIDADES\').removeAttr("disabled");';
		}
		
		foreach($this->Model->oportunidades as $row){
          
		 
		 $htmLcontent .= ' <tr id="'.$row['PK1'].'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend" style="margin-right:-50px;">
		  <span class="add-on"  id="LABEL-OPORTUNIDADES-'.$loop.'">'.$loop.'.</span>
          <input type="text" onblur="UpdateOportunidades(\''.$row['PK1'].'\');" id="OPORTUNIDADES-'.$row['PK1'].'" class="oportunidades" style="width:85%;" value="'.htmlentities($row['OPORTUNIDADES'], ENT_QUOTES, "ISO-8859-1").'" >
		  </div> 
          </td>
          
          <td>
          <button style="float:left; margin-right:10px;" onclick="EliminarOportunidades(\''.$row['PK1'].'\');" id="BEOPORTUNIDADES-'.$row['PK1'].'" class="btn btn-small"><i class="icon icon-remove"></i> </button>
          
           <button onclick="UpdateOportunidades(\''.$row['PK1'].'\');" id="BSOPORTUNIDADES-'.$row['PK1'].'"  class="btn btn-small"><i class="icon icon-save"></i></button>
          
          </td>
          
          </tr>';
		  $loop++;
		 }
		 }else{
		    
		   
			
		 }
		  
		  
                    
          $htmLcontent .='   
          </tbody></table>
          
          <div style="margin-left:30px;" class="left">';         
          
		   //if($this->passport->getPrivilegio($_GET['IDPlan'],'P139')){
		  /*$htmLcontent .='<button style="float:left; margin-right:10px;" onclick="EliminarFortaleza();" id="BEFORTALEZA" disabled="disabled" class="btn btn-small"><i class="icon-remove"></i> Eliminar Fortaleza</button>';*/
		  //}
		  
	       //if($this->passport->getPrivilegio($_GET['IDPlan'],'P138')){
			if ($this->isAdm || in_array('P138',$this->permisosArray) ) {
		  $htmLcontent .='<button onclick="AgregarOportunidades();"  class="btn btn-small"><i class="icon-plus"></i>Agregar Oportunidades</button>';
		  }		
		  $htmLcontent .='</div>
          
          </div>';

//---------------AMENAZAS(*Debilidades(*)error)-------------------

	$htmLcontent .= '  <div class="well" >
         <table width="100%" id="DEBILIDADEST">
         <tbody><tr>
         <td width="30">&nbsp;	</td>
         <td>Amenazas </td>            
         </tr>';           
          
          
		$loop = 1;
		if($numamenazas != 0){ 
		
		
		if($numamenazas>2){
		$script .='$(\'#BEDEBILIDADES\').removeAttr("disabled");';
		}
		
		foreach($this->Model->amenazas as $row){
          
		 
		 $htmLcontent .= ' <tr id="'.$row['PK1'].'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend" style="margin-right:-50px;">
		  <span class="add-on"  id="LABEL-DEBILIDADES-'.$loop.'">'.$loop.'.</span>
          <input type="text" onblur="UpdateDebilidades(\''.$row['PK1'].'\');" id="DEBILIDADES-'.$row['PK1'].'" class="debilidades" style="width:85%;" value="'.htmlentities($row['AMENAZAS'], ENT_QUOTES, "ISO-8859-1").'" >
		  </div> 
          </td>
          
          <td>
          <button style="float:left; margin-right:10px;" onclick="EliminarDebilidades(\''.$row['PK1'].'\');" id="BEDEBILIDADES-'.$row['PK1'].'" class="btn btn-small"><i class="icon icon-remove"></i> </button>
          
           <button onclick="UpdateDebilidades(\''.$row['PK1'].'\');" id="BSDEBILIDADES-'.$row['PK1'].'"  class="btn btn-small"><i class="icon icon-save"></i></button>
          
          </td>
          
          </tr>';
		  $loop++;
		 }
		 }else{
		    
		    /*$script .='array_fortalezas.push("1");';	
			$htmLcontent .= ' <tr id="FORTALEZA-1">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  <span class="add-on" id="LABEL-FORTALEZA-1">1.</span>
          <input type="text" class="fortaleza" style="width:85%;" id="INPUT-FORTALEZA-1">
		  </div> 
          </td>
          </tr>';*/
			
		 }
                    
          $htmLcontent .='   
          </tbody></table>
          
          <div style="margin-left:30px;" class="left">';         
          
		  // if($this->passport->getPrivilegio($_GET['IDPlan'],'P139')){
		  /*$htmLcontent .='<button style="float:left; margin-right:10px;" onclick="EliminarFortaleza();" id="BEFORTALEZA" disabled="disabled" class="btn btn-small"><i class="icon-remove"></i> Eliminar Fortaleza</button>';*/
		 // }
		  
	      //if($this->passport->getPrivilegio($_GET['IDPlan'],'P138')){
			if ($this->isAdm || in_array('P138',$this->permisosArray) ) {
		  $htmLcontent .='<button onclick="AgregarDebilidades();"  class="btn btn-small"><i class="icon-plus"></i>Agregar Amenazas</button>';
		  }		
		  $htmLcontent .='</div>
          
          </div>';

		  $htmLcontent .=' 
                     </div>';					 
					 
      //	fin nuevo		
		
		
		    $script .='
			$(".area").Watermark("Agrega debilidades...");
			$(".fortaleza").Watermark("Agrega fortaleza...");
			$(".debilidades").Watermark("Agrega Amenazas...");//new
			$(".oportunidades").Watermark("Agrega oportunidades...");//new
			</script>';	
	    	$htmLcontent .= $script;
		
			return $htmLcontent;
	   }
	   
	   
	   
	   function obtenerResponsables($responsable=NULL){
	   	
		$panelcontent = "";
		//$this->Model->getResponsables();
		
		foreach($this->Model->responsables as $row){
				
		$panelcontent .=' <option value="'.$row['PK1'].'"';     
		
		if($responsable==$row['PK1']){
			$panelcontent .= 'selected="selected"';
		}
		
		$panelcontent .='>'.htmlentities($row['APELLIDOS'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1").'</option>';
			
		}
		
		
		return $panelcontent;
	   }

	   function valExistInColumn($arrayS, $columnName,$valueFind){
		//echo(serialize($arrayS));
		 $exists=false;
		 foreach($arrayS as $array){
		 if(isset($array[$columnName])&& $array[$columnName] == $valueFind){
			 $exists=true;break;
		 }
	 
		 }
		 return $exists;
	 }
	   
	   
	   function obtenerLineas(){
	   	
		
		$script = "";
		$section = "";
		$tabs = "";
		$panelcontent = "";
	   	
		$this->Model->getLineasPlane($_GET['IDPlanE']);
		$numlineas = sizeof($this->Model->lineas); 
			
		if($numlineas != 0){ 
	    $script ='<script>';
		
		
		$tabs ='<ul class="nav nav-tabs" id="myTab">';
		$panelcontent = '<div id="myTabContent" class="tab-content">';
		$cont = 1;
		$loop = 0;
		foreach($this->Model->lineas as $row){
			$contObjEstrategico = 0;

			
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
					$panelcontent .='<!-- Pagging -->
                        <div class="pagging" >
                       <div class="left" style="margin-right:5px; margin-top:3px;">
                       <h2>Ordenar Resultados:</h2>
                       </div>
                        <div class="left" >
                        <input data-no-uniform="true" type="checkbox" class="iphone-toggle" id="checkordenar"></div>
                        
                        <div class="right">';
						
							 //if($this->passport->getPrivilegio($_GET['IDPlan'],'P69')){ 
								if ($this->isAdm || in_array('P69',$this->permisosArray) ) {                        
		$panelcontent .='<button class="btn btn-large btn-warning"  id="BAO2-L'.$cont.'" onclick="AgregarResultado('.$cont.',this.id,\''.$idlinea.'\');" style="float:left; margin-right:10px;"><i class="icon-plus"></i> Agregar Resultado
           </button>';
      }
						
			 $panelcontent .='</div>
						</div>
						<!-- End Pagging --> ';
					
					
				
            
			
		$this->Model->getObjetivosTacticos($_GET['IDPlan'],$idlinea);
		$numobjetivos = sizeof($this->Model->objetivos); 
		
		$contobjetivo = 1;
		$loopobjetivo = 0;
		$disabledobjetivo = ($numobjetivos>1)? "" : "disabled=\"disabled\"";
		
		
		$panelcontent .='<ul class="sortable" id="SORT-'.$cont.'"> ';
		if($numobjetivos != 0){
			
		
		foreach($this->Model->objetivos as $rowobj){
				
			
	    $script .='
	        arraylineas_objetivos['.$loop.'].push("1");
			lineas_objetivos_medios['.$loop.']['.$loopobjetivo.'] = new Array();
			lineas_objetivos_evidencias['.$loop.']['.$loopobjetivo.'] = new Array();
			 ';
			
		$panelcontent .='<li id="'.$rowobj['PK1'].'"> ';		
		
			  
		$usuario = $_SESSION['session']['user']; 
		$usuarobjetivo = $rowobj['PK_USUARIO'];	  
		  
		  $metodoresul = '';
		  $btnAgregarMedio = '';
		  $btnAgregarEvidencia = '';
		  $btnAgregarIndicadorOperativo = '';

		  $disabledresu = 'disabled';
		  $disabledOEstra = 'disabled';
		  $disabledIndicador = 'disabled';

         
		  //if($this->passport->getPrivilegio($_GET['IDPlan'],'P200')){ 
			if ($this->isAdm || in_array('P200',$this->permisosArray) ) { 			
		     $metodoresul = 'updateResultado(\''.$rowobj['PK1'].'\')';	
			 $btnAgregarMedio = '<button class="btn btn-small" id="BAM-'.$rowobj['PK1'].'"  onclick="AgregarMedio(\''.$rowobj['PK1'].'\','.$cont.','.$contobjetivo.');"><i class="icon-plus"></i>Agregar Medio</button>';	
             $btnAgregarEvidencia = '<button class="btn btn-small" id="BAE-'.$rowobj['PK1'].'"  onclick="AgregarEvidencia(\''.$rowobj['PK1'].'\','.$cont.','.$contobjetivo.');"><i class="icon-plus"></i>Agregar Evidencia</button>';
			 $btnAgregarIndicadorOperativo = '<button class="btn btn-small" id="BAI-'.$rowobj['PK1'].'"  onclick="AgregarIndicadorMeta(\''.$rowobj['PK1'].'\','.$cont.','.$contobjetivo.');"><i class="icon-plus"></i>Agregar Indicador</button>';	

			 $disabledresu = '';
			 $disabledOEstra = '';
			 $disabledIndicador = '';

		 }else{
			 
			  if( trim($usuario) == trim($usuarobjetivo) ){			  
			    $metodoresul = 'updateResultado(\''.$rowobj['PK1'].'\')';
				$btnAgregarMedio = '<button class="btn btn-small" id="BAM-'.$rowobj['PK1'].'"  onclick="AgregarMedio(\''.$rowobj['PK1'].'\','.$cont.','.$contobjetivo.');"><i class="icon-plus"></i>Agregar Medio</button>';	
			    $btnAgregarEvidencia = '<button class="btn btn-small" id="BAE-'.$rowobj['PK1'].'"  onclick="AgregarEvidencia(\''.$rowobj['PK1'].'\','.$cont.','.$contobjetivo.');"><i class="icon-plus"></i>Agregar Evidencia</button>';
				$btnAgregarIndicadorOperativo = '<button class="btn btn-small" id="BAI-'.$rowobj['PK1'].'"  onclick="AgregarIndicadorMeta(\''.$rowobj['PK1'].'\','.$cont.','.$contobjetivo.');"><i class="icon-plus"></i>Agregar Indicador</button>';	
 
				$disabledresu = '';
				$disabledOEstra = '';
				$disabledIndicador = '';
				
			  }			 
		 } 
		
		
		
		$usuariores = $this->Model->getUsuarioResultado($rowobj['PK_USUARIO']);
			
          $panelcontent .='<!--====================OBJETIVO=====================--> 
		  
		  
	 		  
          
		  <div class="wellstrong" id="L'.$cont.'-C'.$contobjetivo.'">
                   
          <table width="100%">
	      <tr>
	      <td colspan="2"><b><font size="2">Objetivo Estratégico:</font></b><div align="right"><b><font size="2">Creado por: '.$usuariores.'</font></b></div>
		  <select class="fullcombo" '.$disabledOEstra.' id="OE-'.$rowobj['PK1'].'" style="width:100%;" onchange="getAndDelIndicadoresByObj(\''.$rowobj['PK1'].'\',this)">
		  <option value="0">Selecciona Objetivo Estratégico </option>';
	    
	        $this->Model->getObjetivosE($idlinea);
			$contobe=1;
	        foreach($this->Model->objetivosE as $rowObjE){  	
			  
			$panelcontent .='<option value="'.$rowObjE['PK1'].'"';
			
			if($rowobj['PK_OESTRATEGICO']==$rowObjE['PK1']){
				$panelcontent .= 'selected="selected"';
				$contObjEstrategico = $rowObjE['ORDEN'] + 1;
		    }
			
			$panelcontent .='>'.$cont.'.'.$contobe++.' '.htmlentities($rowObjE['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</option>';
			}
		
			
	   $panelcontent .='</select> </td>
	  
	   </tr>
	   <!-- Inicio de indicadores--> 
	   <tr>
			<td colspan="2">
			</br>
				<div class="box-icon">
					<a href="javascript:void(0)" onclick="Toogle(\''.$rowobj['PK1'].'I'.'\',this);" class="btn btn-minimize btn-round" id="TOG-'.$rowobj['PK1'].'I'.'">
						<i class="icon-chevron-down"></i> Indicadores-Metas 2024 (objetivo estratégico)
					</a>						
					</br>
				</div>
				<div class="box-objectivos" id="BOXMEDIO-'.$rowobj['PK1'].'I'.'" style="display:none">
					<div class="well">';

				$this->Model->getIndicadoresByObjetivo($rowobj['PK_OESTRATEGICO']);
				if(count($this->Model->indicadores) > 0){

					$this->Model->getIndicadoresByObj($rowobj['PK1'],$rowobj['PK_OESTRATEGICO']);
					foreach($this->Model->indicadores as $rowObjInd){
						if($rowObjInd['INDICADOR'] !="" || $rowObjInd['INDICADOR'] != null){  
							if($this->valExistInColumn($this->Model->indicadoresO,"PK_INDICADORMETA",$rowObjInd['PK1'])){
								$panelcontent .= '									   
								<div class="input-prepend INDdiv'.$disabledIndicador.'" style="width:95%;background: #dd5600;border-bottom: 1px solid #BBBBBB;padding:4px;border-radius:4px;">
									<span id="textindicador111" class="" style="display: inline-block;">';
										$panelcontent .= '<input '.$disabledIndicador.' checked id="IND-'.$rowobj['PK1'].'-'.$rowObjInd['PK1'].'" idObje="'.$rowobj['PK1'].'" idObjeEstra="'.$rowobj['PK_OESTRATEGICO'].'" type="checkbox" value="'.$rowObjInd['PK1'].'" name="" style="margin-bottom:5px;margin-right:15px">';
										$panelcontent .= '<span class="add-on">'.$cont.'.'.$contObjEstrategico.'.'.($rowObjInd['ORDEN']+1).'</span>';
										$panelcontent .= '</span>
										<p style="margin-left:3px;height:auto;display:inline-block;width:45%;" name="L1-objetivo" readonly=""><b>Indicador al 2024</b><br>'.htmlentities($rowObjInd['INDICADOR'], ENT_QUOTES, "ISO-8859-1").'</p>
										<p style="margin-left:3px;height:auto;display:inline-block;width:40%;" name="L1-meta" readonly=""><b>Meta al 2024</b><br>'.htmlentities($rowObjInd['META'], ENT_QUOTES, "ISO-8859-1").'</p>
									</div>';
							}
							else{
								$panelcontent .= '									   
								<div class="input-prepend INDdiv'.$disabledIndicador.'" style="width:95%;background: #ffffff;border-bottom: 1px solid #BBBBBB;padding:4px;">
									<span id="textindicador111" class="" style="display: inline-block;">';
										$panelcontent .= '<input '.$disabledIndicador.' id="IND-'.$rowobj['PK1'].'-'.$rowObjInd['PK1'].'" idObje="'.$rowobj['PK1'].'" idObjeEstra="'.$rowobj['PK_OESTRATEGICO'].'" type="checkbox" value="'.$rowObjInd['PK1'].'" name="" style="margin-bottom:5px;margin-right:15px">';
										$panelcontent .= '<span class="add-on">'.$cont.'.'.$contObjEstrategico.'.'.($rowObjInd['ORDEN']+1).'</span>';
										$panelcontent .= '</span>
										<p style="margin-left:3px;height:auto;display:inline-block;width:45%;" name="L1-objetivo" readonly=""><b>Indicador al 2024</b><br>'.htmlentities($rowObjInd['INDICADOR'], ENT_QUOTES, "ISO-8859-1").'</p>
										<p style="margin-left:3px;height:auto;display:inline-block;width:40%;" name="L1-meta" readonly=""><b>Meta al 2024</b><br>'.htmlentities($rowObjInd['META'], ENT_QUOTES, "ISO-8859-1").'</p>
									</div>';
							}
						}else{
							$panelcontent .= '<p>No existen Indicadores para este Objetivo Estatégico. </p>';

						}
					}
				}else{
					$panelcontent .= '<p>No existen Indicadores para este Objetivo Estatégico.</p>';
				}
			$panelcontent .='
					</div>
				</div></br>
			</td>
	   </tr>
	   <!-- fin indicadores-->
	  
	   <tr>
       <td><b><font size="2">Resultado:</font></b></td>
       <td><b><font size="2"> Responsable:</font></b></td>
       </tr>';
	   
	   
        
			  
        $panelcontent .='<tr>
       <td width="70%">   
		<div class="input-prepend">
		   <span class="add-on" id="LABEL-L'.$cont.'-O'.$contobjetivo.'">'.$cont.'.'.$contobjetivo.'</span>
		   <textarea name="resultado"  '.$disabledresu.'   onblur="'.$metodoresul.'" id="IRES-'.$rowobj['PK1'].'" style="width:90%;" id="L'.$cont.'-O'.$contobjetivo.'" class="objetivo">'.htmlentities($rowobj['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</textarea>
		   
		</div>
       </td>
      
       <td width="30%">
	   <select id="RRES-'.$rowobj['PK1'].'"  '.$disabledresu.'  style="width:100%;" onchange="'.$metodoresul.'" >
	  
       <option value="ALL"></option>';
	   
	   $panelcontent .= $this->obtenerResponsables($rowobj['PK_RESPONSABLE']);      
	   $panelcontent .='</select></td>
       </tr>
       </table>
           
	<div class="box-icon">
	   </br>
	   <a href="javascript:void(0)" onclick="Toogle(\''.$rowobj['PK1'].'\',this);" class="btn btn-minimize btn-round" id="TOG-'.$rowobj['PK1'].'"><i class="icon-chevron-down"></i> Medios, Evidencias e Indicadores-Metas (anual)</a>	
	</div>
		   
	  <div class="box-objectivos" id="BOXMEDIO-'.$rowobj['PK1'].'" style="display:none">';
	  
	   $panelcontent.='
	   <!-- Inicio Medios-->
	   <div class="well" >
       
       <h2>Medios</h2>
       <ul id="MEDIOS-'.$rowobj['PK1'].'" style="list-style-type: none;">';
       
        
		$this->Model->getMedios($rowobj['PK1']);
		$nummedios = sizeof($this->Model->medios); 
		
		$contmedio = 1;
		$loopmedio = 0;
		
		$disabled = ($nummedios>1)? "" : "disabled=\"disabled\"";
		
		
		if($nummedios != 0){			
			
			
	    foreach($this->Model->medios as $rowmedios){			
			
		  $botonEliminarMedio = '';
		  $botonGuardarMedio = '';
          $metodomedio = '';
		  $disabledmedio = 'disabled';
         	  
		  //if($this->passport->getPrivilegio($_GET['IDPlan'],'P200')){
			if ($this->isAdm || in_array('P200',$this->permisosArray) ) { 					    
			 $metodomedio = 'updateMedio(\''.$rowmedios['PK1'].'\');';
			 $botonEliminarMedio = '<button class="btn btn-small" onclick="EliminarMedio(\''.$rowmedios['PK1'].'\');" style="float:left; margin-right:10px;"><i class="icon icon-remove"></i> Eliminar medio</button>'; 
		     $botonGuardarMedio = '<button class="btn btn-small"  onclick="updateMedio(\''.$rowmedios['PK1'].'\');"><i class="icon icon-save"></i>Salvar Medio</button>'; 			 
			 $disabledmedio = '';
				
		 }else{			 
			  if( trim($usuario) == trim($usuarobjetivo) ){				  
				$metodomedio = 'updateMedio(\''.$rowmedios['PK1'].'\');'; 
                $botonEliminarMedio = '<button class="btn btn-small" onclick="EliminarMedio(\''.$rowmedios['PK1'].'\');" style="float:left; margin-right:10px;"><i class="icon icon-remove"></i> Eliminar medio</button>'; 				
				$botonGuardarMedio = '<button class="btn btn-small"  onclick="updateMedio(\''.$rowmedios['PK1'].'\');"><i class="icon icon-save"></i>Salvar Medio</button>'; 			 
				 $disabledmedio = '';
			  }				 
		 } 			
		    	
	   $panelcontent .='<li id="'.$rowmedios['PK1'].'">
	   <div class="wellstrong">
	   <table width="100%">
	   <tr>
        <td width="2%">&nbsp;</td>
        <td width="70%"><b><font size="2">Medio:</font></b></td>
        <td width="28%"><b><font size="2">Responsable:</font></b></td>
        </tr>
       <tr>
        <td>&nbsp; </td>
        <td>  
        <div class="input-prepend">
		<span class="add-on" id="LABEL-L'.$cont.'-O'.$contobjetivo.'-M'.$contmedio.'">'.$cont.'.'.$contobjetivo.'.'.$contmedio.'</span>
        
		
		<textarea name="medio"  '.$disabledmedio.'   onblur="'.$metodomedio.'" style="width:86%;" id="MTEXT-'.$rowmedios['PK1'].'" class="medio">'.htmlentities($rowmedios['MEDIO'], ENT_QUOTES, "ISO-8859-1").'</textarea>
		
		</div> 
        </td>                          
        <td>
		<select id="RMEDIO-'.$rowmedios['PK1'].'"  '.$disabledmedio.'  onchange="'.$metodomedio.'"> 
		
		<option value="ALL"></option>';
		
		$panelcontent .= $this->obtenerResponsables($rowmedios['PK_RESPONSABLE']);    
		$panelcontent .= '</select></td>
        </tr>';
        
        $panelcontent .= '<tr>
         <td colspan="3">
         <div class="right" style="margin-right:30px;">        
         
         '.$botonEliminarMedio.'                    
         '.$botonGuardarMedio.'
		 
		 </div>        
         </td>
         </tr>';
        
        $panelcontent .='</table></div></li>';
		$contmedio++;
		$loopmedio++;
		   }
		}
            $panelcontent .='</ul> '      
		
		.$btnAgregarMedio.'
        
		</div>
		<!-- Fin Medio -->
		';
			 
		
		
		$panelcontent .=' 
		<!-- Inicio Evidencias -->                 
         <div class="well">
         <h2>Evidencias</h2>
         <ul id="EVIDENCIAS-'.$rowobj['PK1'].'" style="list-style-type: none;">';
		 
		 
		$this->Model->getEvidencias($rowobj['PK1']);
		$numevidencias = sizeof($this->Model->evidencias); 
		
		$contevidencia = 1;
		$loopevidencia = 0;
		
		$disabled = ($numevidencias>1)? "" : "disabled=\"disabled\"";
		
		
			
		if($numevidencias != 0){
			
			
		foreach($this->Model->evidencias as $rowevidencias){
			
		  $metodoevidencias = '';
          $botonEliminarEvi = '';
          $botonGuardarEvi = '';
          $disabledevidencia = 'disabled';		  
       	  
		 // if($this->passport->getPrivilegio($_GET['IDPlan'],'P200')){ 
			if ($this->isAdm || in_array('P200',$this->permisosArray) ) { 							
		     $metodoevidencias = 'updateEvidencia(\''.$rowevidencias['PK1'].'\');';	
             $botonEliminarEvi = '<button class="btn btn-small"  onclick="EliminarEvidencia(\''.$rowevidencias['PK1'].'\');" style="float:left; margin-right:10px;"><i class="icon icon-remove"></i> Eliminar Evidencia</button>';	      
	         $botonGuardarEvi = '<button class="btn btn-small" onclick="updateEvidencia(\''.$rowevidencias['PK1'].'\');" ><i class="icon icon-save"></i>Salvar Evidencia</button>';      
             $disabledevidencia = '';
			 
		 }else{			 
			  if( trim($usuario) == trim($usuarobjetivo) ){			  
			    $metodoevidencias = 'updateEvidencia(\''.$rowevidencias['PK1'].'\');'; 	
                $botonEliminarEvi = '<button class="btn btn-small"  onclick="EliminarEvidencia(\''.$rowevidencias['PK1'].'\');" style="float:left; margin-right:10px;"><i class="icon icon-remove"></i> Eliminar Evidencia</button>';	      
	            $botonGuardarEvi = '<button class="btn btn-small" onclick="updateEvidencia(\''.$rowevidencias['PK1'].'\');" ><i class="icon icon-save"></i>Salvar Evidencia</button>';      
                $disabledevidencia = '';
			  }			 
		 }
			
			
		
		$script .='
		        lineas_objetivos_evidencias['.$loop.']['.$loopobjetivo.']['.$loopevidencia.'] = "1";
			     ';	
	     $panelcontent .='<li id="'.$rowevidencias['PK1'].'">
	   <div class="wellstrong">';
	   		     
	     $panelcontent .='<table width="100%">
         <tr>
         <td width="30">&nbsp;	</td>
         <td><b><font size="2">Evidencia:</b></font></td>            
         </tr>';           
          
         $panelcontent .=' <tr id="L'.$cont.'-O'.$contobjetivo.'-E'.$contevidencia.'-C'.$contobjetivo.'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  <span class="add-on" id="LABEL-L'.$cont.'-O'.$contobjetivo.'-E'.$contevidencia.'">'.$cont.'.'.$contobjetivo.'.'.$contevidencia.'</span>
		  
          <input id="ETEXT-'.$rowevidencias['PK1'].'"  '.$disabledevidencia.' onblur="'.$metodoevidencias.'" class="evidencia" value="'.htmlentities($rowevidencias['EVIDENCIA'], ENT_QUOTES, "ISO-8859-1").'"   style="width:90%;" type="text">
		  </div> 
          </td>
          </tr>';
          
          $panelcontent .='<tr>
          <td colspan="2">
          <div class="right" style="margin-right:30px;">        
          
          '.$botonEliminarEvi.'
          '.$botonGuardarEvi.'
		  
		  </div>
          </td>
          </tr>     
          </table></div></li>';
		  
		  
		$contevidencia++;
		$loopevidencia++;
                    }
				}
					
          $panelcontent .='</ul>';
          
          
          $panelcontent .='
		  
		  '.$btnAgregarEvidencia.'
		  
		  </div>
		  <!-- fin evidencias -->';
		  $panelcontent .='
	  <!-- Inicio Indicadores Resultad Metas-->
	  		<div class="well" >
       
				<h2>Indicadores-Metas</h2>
				<ul id="INDICADORESME-'.$rowobj['PK1'].'" style="list-style-type: none;">';

				$this->Model->getIndicadoresMetas($rowobj['PK1']);
				$numIndicaMeta = sizeof($this->Model->indicadoresMetas); 
				$contIndiMeta = 1;
				$loopIndiMeta = 0;
				$disabled = ($numIndicaMeta>1)? "" : "disabled=\"disabled\"";
				if($numIndicaMeta != 0){			
				
				
			foreach($this->Model->indicadoresMetas as $rowindiMeta){			
				
				$botonEliminarIndicadorMeta = '';
				$botonGuardarIndicadorMeta = '';
				$metodoIndicadorMeta = '';
				$disabledIndicadorMeta = 'disabled';
					
				//if($this->passport->getPrivilegio($_GET['IDPlan'],'P200')){
				if ($this->isAdm || in_array('P200',$this->permisosArray) ) { 					    
					$metodoIndicadorMeta = 'updateIndicadorMeta(\''.$rowindiMeta['PK1'].'\');';
					$botonEliminarIndicadorMeta = '<button class="btn btn-small" onclick="EliminarIndicadorMeta(\''.$rowindiMeta['PK1'].'\');" style="float:left; margin-right:10px;"><i class="icon icon-remove"></i> Eliminar Indicador</button>'; 
					$botonGuardarIndicadorMeta = '<button class="btn btn-small"  onclick="updateIndicadorMeta(\''.$rowindiMeta['PK1'].'\');"><i class="icon icon-save"></i>Salvar Indicador</button>'; 			 
					$disabledIndicadorMeta = '';
						
				}else{			 
					if( trim($usuario) == trim($usuarobjetivo) ){				  
						$metodoIndicadorMeta = 'updateIndicadorMeta(\''.$rowindiMeta['PK1'].'\');'; 
						$botonEliminarIndicadorMeta = '<button class="btn btn-small" onclick="EliminarIndicadorMeta(\''.$rowindiMeta['PK1'].'\');" style="float:left; margin-right:10px;"><i class="icon icon-remove"></i> Eliminar Indicador</button>'; 				
						$botonGuardarIndicadorMeta = '<button class="btn btn-small"  onclick="updateIndicadorMeta(\''.$rowindiMeta['PK1'].'\');"><i class="icon icon-save"></i>Salvar Indicador</button>'; 			 
						$disabledIndicadorMeta = '';
					}				 
				} 			
						
				$panelcontent .='<li id="'.$rowindiMeta['PK1'].'">
				<div class="wellstrong">
				<table width="100%">
				<tr>
					<td width="2%">&nbsp;</td>
					<td width="60%"><b><font size="2">Indicador Anual:</font></b></td>
					<td width="38%"><b><font size="2">Meta Anual:</font></b></td>
					</tr>
				<tr>
					<td>&nbsp; </td>
					<td>  
						<div class="input-prepend">
							<span class="add-on" id="LABEL-L'.$cont.'-O'.$contobjetivo.'-IM'.$contIndiMeta.'">'.$cont.'.'.$contobjetivo.'.'.$contIndiMeta.'</span>
							<textarea name="indicadorMetaText"  '.$disabledIndicadorMeta.'   onblur="'.$metodoIndicadorMeta.'" style="width:86%;" id="INDICAMETATEXT-'.$rowindiMeta['PK1'].'" class="medio">'.htmlentities($rowindiMeta['INDICADOR'], ENT_QUOTES, "ISO-8859-1").'</textarea>
						</div> 
					</td>                          
					<td>
						<textarea name="indicadorMetaMeta"  '.$disabledIndicadorMeta.'   onblur="'.$metodoIndicadorMeta.'" style="width:86%;" id="INDICAMETAMETA-'.$rowindiMeta['PK1'].'" class="medio">'.htmlentities($rowindiMeta['META'], ENT_QUOTES, "ISO-8859-1").'</textarea>	
					</td>
				</tr>';
					
					$panelcontent .= '<tr>
					<td colspan="3">
					<div class="right" style="margin-right:30px;">        
					
					'.$botonEliminarIndicadorMeta.'                    
					'.$botonGuardarIndicadorMeta.'
					
					</div>        
					</td>
					</tr>';
					
					$panelcontent .='</table></div></li>';
					$contIndiMeta++;
					$loopIndiMeta++;
			}
		}
		$panelcontent .='</ul> 
			'.$btnAgregarIndicadorOperativo.'
        
		</div>
		<!-- Fin Indicadores de Resultado-->';
		  

		$panelcontent .='
                </div>
				
          <div style="height:30px;" >
		  <div style="float:right;">';

		  
		 // $usuario = $_SESSION['session']['user']; 
		 //$usuarobjetivo = $rowobj['PK_USUARIO'];	  
		  
		  $botonEliminar = '';
		  $botonGuardar = '';
		  
		 // if($this->passport->getPrivilegio($_GET['IDPlan'],'P200')){  
			if ($this->isAdm || in_array('P200',$this->permisosArray) ) { 			
				
		     $botonEliminar = '<button  class="btn-danger btn-large" id="DELETE-'.$rowobj['PK1'].'" onclick="deleteResultado(\''.$rowobj['PK1'].'\')"><span class="icon icon-white icon-close"></span> Eliminar</button>'; 
		     $botonGuardar = '<button  class="btn-success btn-large" id="SAVE-'.$rowobj['PK1'].'" onclick="updateResultado(\''.$rowobj['PK1'].'\')"><span class="icon icon-white icon-save"></span> Guardar</button>'; 			 
				
		 }else{
			 
			  if( trim($usuario) == trim($usuarobjetivo) ){			  
			    $botonEliminar = '<button  class="btn-danger btn-large" id="DELETE-'.$rowobj['PK1'].'" onclick="deleteResultado(\''.$rowobj['PK1'].'\')"><span class="icon icon-white icon-close"></span> Eliminar</button>'; 
			    $botonGuardar = '<button  class="btn-success btn-large" id="SAVE-'.$rowobj['PK1'].'" onclick="updateResultado(\''.$rowobj['PK1'].'\')"><span class="icon icon-white icon-save"></span> Guardar</button>'; 			  		  
			  }				 
			 
		 }		  
		 
		   
		  $panelcontent .=' 

          '.$botonEliminar.'
          '.$botonGuardar.'		  
		   
		  </div>
		  </div>
          
          </div>
           <!--====================END OBJETIVO=====================-->';
		   
		   $panelcontent .='</li> ';
           $contobjetivo++;
		   $loopobjetivo++;
		    }
			//
			
			
		 }else{
		 	
			   //NO EXISTE OBJETIVO
			   /*
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
           
		   <!--====================END OBJETIVO=====================-->';*/
			   
			   //$contobjetivo++;
		       //$loopobjetivo++;
			   //END NO EXISTE OBJETIVO
			
		 }          
		
		$panelcontent .='</ul> ';
		
           $panelcontent .='<!-- Pagging -->
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
                        <div class="right">';
                      
					  
	//if($this->passport->getPrivilegio($_GET['IDPlan'],'P68')){
	if ($this->isAdm || in_array('P68',$this->permisosArray) ) { 			

		//$panelcontent .='<button class="btn btn-large" '.$disabledobjetivo.' id="BEO-L'.$cont.'" onclick="EliminarObjetivo(this.id);" style="float:left; margin-right:10px;"><i class="icon-remove"></i> Eliminar Resultado
          // </button>';
     }
      
	 //if($this->passport->getPrivilegio($_GET['IDPlan'],'P69')){   
	if ($this->isAdm || in_array('P69',$this->permisosArray) ) { 			
	                       
		$panelcontent .='<button class="btn btn-large btn-warning"  id="BAO-L'.$cont.'" onclick="AgregarResultado('.$cont.',this.id,\''.$idlinea.'\');" style="float:left; margin-right:10px;"><i class="icon-plus"></i> Agregar Resultado
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
			   //if($this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){
				if ($this->isAdm || in_array($permiso,$this->permisosArray) ) { 			

			$panelcontent = '<!--====================COMENTARIOS=====================-->
		  
		   <div id="twitter-container">
			
			    <span class="counter" id="counter-general">&nbsp;</span>
			    <textarea name="inputField" id="inputField-general"   tabindex="1" rows="2" cols="40"></textarea>';
			   
			   //if($this->passport->getPrivilegio($_GET['IDPlan'],'P82')){ 
				if ($this->isAdm || in_array('P82',$this->permisosArray) ) { 			

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
							$comentario = stripslashes(htmlentities($rowcomentariosr['COMENTARIO'], ENT_QUOTES, "ISO-8859-1"));
							
							$rowusuario	= $this->Model->getImagen($usuario_id);	
							$imagen =  "media/usuarios/".$rowusuario['IMAGEN'];
							
							$usuario = $rowusuario['NOMBRE']." ".$rowusuario['APELLIDOS'];
							 
							 
							if($tipo=="M"){$class = "stbody2"; $class2='<span class="label label-important">Mandatorio</span>'; }else{ $class = "stbody"; $class2=""; }
							 
				$panelcontent .='<div class="'.$class.'" id="stbodyg'.$comentario_id.'">
    		<div class="sttimg"><img src="'.$imagen.'" class="big_face"/></div> 
    		<div class="sttext">';
			
			
			$permiso = "P150"; // ($_GET['estado']=="R") ? "P88" : "P52";
			//if($this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){
				if ($this->isAdm || in_array($permiso,$this->permisosArray) ) { 			

		   $panelcontent .='<a class="stdeleteg" href="#" id="g'.$comentario_id.'" title="Borrar comentario"><i class="icon-remove"></i></a>';
		   }
			
			 $panelcontent .= ' 
    					<strong><a href="#" class="comentuser">'.htmlentities($usuario, ENT_QUOTES, "ISO-8859-1").'</a></strong>
						'.$class2.'<br>
						'.$comentario.'
   						<div class="sttime">'.date('d/m/Y H:i:s', strtotime($fecha->format('Y-m-d'))).'</div> 
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
	
	<strong><a href="#">'.htmlentities($usuario, ENT_QUOTES, "ISO-8859-1").'</a></strong>
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