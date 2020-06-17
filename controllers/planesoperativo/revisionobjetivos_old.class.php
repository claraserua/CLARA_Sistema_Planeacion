<?php
include "models/planesoperativo/revisionobjetivos.model.php";
include "libs/resizeimage/class.upload.php";


class revisionobjetivos {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $image;
	var $targetPathumbail;
	

	function revisionobjetivos() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("option");
	 $this->Model = new revisionobjetivosModel();
		
	 switch($_GET['method']){
	 	
		case "EnviarRevision":
			$this->EnviarRevision();
			break;
			
	    case "PasarSeguimiento":
			$this->PasarSeguimiento();
			break;
			
		case "BuscarComentarios":
		    $this->BuscarComentarios();
			break;
			
			
		case "insertarComentario":
		      $this->insertarComentario();
			  break;
			  
	   
	   	case "insertarComentarioResumen":
		      $this->insertarComentarioResumen();
			  break;
	   	   		  
			  
	   case "eliminarComentario":
	        $this->eliminarComentario();
			break;
			
			
	   case "eliminarComentarioResumen":
	        $this->eliminarComentarioResumen();
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
	
		$this->View->template = TEMPLATE.'modules/planesoperativo/REVISION.TPL';	
		$this->View->loadTemplate();
		$this->loadHeader();
		

		
		$this->loadMenu();
		
		//if($this->passport->privilegios->hasPrivilege('P12')){
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
	 	

		$contenido = $this->View->Template(TEMPLATE.'modules/planesoperativo/FRMREVISION.TPL');
		$plan =  $this->Model->getPlanOperativo($_GET['IDPlan']);
		$contenido =  $this->View->replace('/\#TITULOPLAN\#/ms' ,htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1"),$contenido);
		
		$contenido =  $this->View->replace('/\#ESTADO\#/ms' ,$this->Model->getEstadoPlanOperativo($_GET['IDPlan']),$contenido);
		
		$contenido =  $this->View->replace('/\#CONTENIDO\#/ms' ,$this->obtenerLineas(),$contenido);
		$contenido =  $this->View->replace('/\<!--#VALUEDESCRIPCION#-->/ms' ,htmlspecialchars_decode($this->getResumenEjecutivo()),$contenido);
		
		
		//MOSTRAR RESUMEN EJECUTIVO
		$permiso = ($_GET['estado']=="R") ? "P131" : "P131";
		if($this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){
		
	    $fresumen ='<li class=""> <a href="#resumen">Diagnóstico Inicial</a></li>';
		$contenido =  $this->View->replace('/\<!--#FRESUMENEJECUTIVO#-->/ms' ,$fresumen,$contenido);	
			}
		
		
		//EDITAR PLAN
		$permiso = ($_GET['estado']=="R") ? "P83" : "P47";
		
		if($this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){
			
		 $urlbteditar="<a href=\"?execute=planesoperativo/revisionobjetivosfinal&method=default&estado=".$_GET['estado']."&Menu=F2&SubMenu=SF21&IDPlan=".$_GET['IDPlan']."&IDPlanE=".$_GET['IDPlanE']."\" class=\"btn btn-large\"><i class=\"icon-pencil\"></i> Editar</a>";
		 
		 $contenido =  $this->View->replace('/\<!--BUTTONEDITAR-->/ms' ,$urlbteditar,$contenido);
		
		 }
		 
		 //TODOS COMENTARIOS AGRUPADOS
		 
		 $urlcomentarios ='
		 <button class="btn btn-large btn-primary" data-rel="tooltip" data-original-title="Revisar todos los comentarios" onclick="TodosComentarios(\''.$_GET['IDPlan'].'\',\''.$_GET['IDPlanE'].'\',\''.$_GET['estado'].'\');"><span class="icon icon-white icon-comment"></span> Comentarios</button>';	
		 $contenido =  $this->View->replace('/\<!--BUTTONCOMENTARIOSALL-->/ms' ,$urlcomentarios,$contenido);	
		 
		 
		$urlenviar ="";
		 
		 if($_GET['estado']=="R"){
		 if($this->passport->getPrivilegio($_GET['IDPlan'],'P81')){
		 $urlenviar ='
		 <button class="btn btn-large btn-primary" data-rel="tooltip" data-original-title="El plan operativo pasara a seguimiento" onclick="PasaraSeguimiento();"><span class="icon icon-white icon-sent"></span> Finalizar</button>';	
		 }
		 $mostrarcomeng = "";
		 
		 if(!$this->passport->getPrivilegio($_GET['IDPlan'],'P147')){
		 $mostrarcomeng ='style="display:none;"';	
		 }
		 
	
		 $contenido =  $this->View->replace('/\#OCULTARCOMENTARIOSG\#/mss' ,$mostrarcomeng,$contenido);	
		 
		 $contenido =  $this->View->replace('/\<!--BUTTONENVIAR-->/ms' ,$urlenviar,$contenido);		
		}else{
			
			//ENVIAR REVISION
		if($this->passport->getPrivilegio($_GET['IDPlan'],'P54')){
		 $urlenviar ='<button class="btn-warning btn-large" onclick="EnviarRevision();"><span class="icon icon-white icon-sent"></span> Enviar Revisión</button>';	
		 }
		 
		 $mostrarcomeng = "";
		 
		 if(!$this->passport->getPrivilegio($_GET['IDPlan'],'P148')){
		 $mostrarcomeng ='style="display:none;"';	
		 }
		 
		 $contenido =  $this->View->replace('/\#OCULTARCOMENTARIOSG\#/mss' ,$mostrarcomeng,$contenido);
		 
		 
		 $contenido =  $this->View->replace('/\<!--BUTTONENVIAR-->/ms' ,$urlenviar,$contenido);
		  }
		
		
		$permiso = ($_GET['estado']=="R") ? "P89" : "P53";
		if(!$this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){ 
		 $mostrarcom = 'style="display: none;"';
		 $contenido =  $this->View->replace('/\#MOSTRARCOM\#/ms' ,$mostrarcom,$contenido);
		 
		 }
		 
	
		 
		$contenido =  $this->View->replace('/\#COMENTARIOSRESUMENEJECUTIVO\#/ms' ,$this->getComentariosResumenEjecutivo(),$contenido);
		
		$contenido =  $this->View->replace('/\#NR\#/ms' ,$this->Model->getNumeroComentariosResumenEjecutivo($_GET['IDPlan']),$contenido);
		
		
		$contenido =  $this->View->replace('/\#COMENTARIOSGENERALES\#/ms' ,$this->getComentariosGenerales(),$contenido);
		
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 }
	 
       
	   
	   function getResumenEjecutivo(){
	   			
		$this->Model->getAreas();
		$this->Model->getFortalezas();
		$numareas = sizeof($this->Model->areas);
		$numfortalezas = sizeof($this->Model->fortalezas); 
					
		$htmLcontent = '<div class="box-objectivos" id="BOX-AREAS">
      
        <div class="wellwhite">
         <table width="100%">
         <tbody><tr>
         <td width="30">&nbsp;	</td>
         <td><strong>Áreas de oportunidad:</strong>	</td>            
         </tr>';           
          
		$loop = 1;
		if($numareas != 0){ 	
		foreach($this->Model->areas as $row){
          
		
		 $htmLcontent .= ' <tr id="AREA-'.$loop.'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  '.$loop.'.
          '.htmlentities($row['AREA'], ENT_QUOTES, "ISO-8859-1").'
		  </div> 
          </td>
          </tr>';
		  $loop++;
		 }
		 }
                    
        $htmLcontent .= '    
          </tbody></table>
          </div>
                      
                                 
         <div class="wellwhite">
         <table width="100%">
         <tbody><tr>
         <td width="30">&nbsp;	</td>
         <td><strong>Fortalezas:	</strong></td>            
         </tr>';           
          
          
		$loop = 1;
		if($numfortalezas != 0){ 
		
		foreach($this->Model->fortalezas as $row){
          
		 $htmLcontent .= ' <tr id="FORTALEZA-'.$loop.'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  '.$loop.'.
          '.htmlentities($row['FORTALEZA'], ENT_QUOTES, "ISO-8859-1").'
		  </div> 
          </td>
          </tr>';
		  $loop++;
		 }
         }
	                
          $htmLcontent .='    
          </tbody></table>
          </div> 
                     </div>';
		
		
		
		   
		
			return $htmLcontent;
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
		if($numobjetivos != 0){
			
			foreach($this->Model->objetivos as $rowobj){
				
				if(trim($rowobj['OBJETIVO'])=="Agregar un resultado..." || trim($rowobj['OBJETIVO'])=="Agregar un objetivo..."  ){
					$ocultar = 'style="display:none;"';
				}else{
					$ocultar = '';
				}
			
	  $script .='
	  
	        arraylineas_objetivos['.$loop.'].push("1");
			lineas_objetivos_medios['.$loop.']['.$loopobjetivo.'] = new Array();
			lineas_objetivos_evidencias['.$loop.']['.$loopobjetivo.'] = new Array();
		    
			
						
		    $("#inputField-L'.$cont.'-'.$contobjetivo.'").bind("blur focus keydown keypress keyup", function(){recount(\''.$cont.'-'.$contobjetivo.'\');});
	        $("#update_button-L'.$cont.'-'.$contobjetivo.'").attr("disabled","disabled");
		    $("#inputField-L'.$cont.'-'.$contobjetivo.'").Watermark("Agrega tu comentario ...");
			 ';
			
			
				
				
	   $rowobjes = 	$this->Model->getObjetivoEst($rowobj['PK_OESTRATEGICO']);
	   $numobjes =  intval($rowobjes['ORDEN']);
	   $numobjes++;
	   
       $panelcontent .='<!--====================OBJETIVO=====================--> 
   <div class="wellwhite" id="L'.$cont.'-C'.$contobjetivo.'">
                   
	  
   <table width="100%" '.$ocultar.'>
   
      <tr><td></td><td bgcolor="#D9D9D9" style="color:#000; padding:5px; background-color: #D9D9D9; font-size:12px; font-weight: bold;" colspan="2">Resultado</td><td width="400px;" bgcolor="#D9D9D9" style="color:#000; background-color: #D9D9D9; padding:5px; font-size:12px; font-weight: bold;">Objetivo Estratégico</td><td width="200px;" bgcolor="#D9D9D9" style="color:#000; padding:5px; background-color: #D9D9D9; font-size:12px; font-weight: bold;">Responsable</td></tr>
      
	  <tr><td style="color:#000; padding:5px;  font-size:11px;" align="right">'.$cont.'.'.$numobjes.'</td><td style="color:#000; padding:5px;  font-size:11px;" colspan="2">'.htmlentities($rowobj['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</td><td style="color:#000;  padding:5px; font-size:11px;">'.htmlentities(($rowobjes['OBJETIVO']), ENT_QUOTES, "ISO-8859-1").'</td><td style="color:#000; padding:5px;  font-size:11px;">'.htmlentities($this->Model->getResponsable($rowobj['PK_RESPONSABLE']),ENT_QUOTES, "ISO-8859-1").'</td></tr>
	   
    </table>
                    
      <div class="box-icon" '.$ocultar.'>';
	  
	  $this->Model->getMedios($rowobj['PK1']);
	  $nummedios = sizeof($this->Model->medios); 
	  
	  
	 $panelcontent .= '<span style="float:left; position:relative; left:10px;" class="notification">'.$nummedios.'</span>
<a href="javascript:void(0)" onclick="Toogle(this.id);" class="btn btn-minimize btn-round" id="TOG-L'.$cont.'-C'.$contobjetivo.'"><i class="icon-chevron-down"></i> Medios</a>						
</div>
      
      <div class="box-objectivos" style="display:none;" id="BOX-L'.$cont.'-C'.$contobjetivo.'">
       <div>
       
	   <table width="100%">
      <tr><td></td><td width="100px;"></td><td colspan="2" bgcolor="#D9D9D9"  style="color:#000; background-color: #D9D9D9; padding:5px; font-size:12px; font-weight: bold;">Medios</td><td bgcolor="#D9D9D9" width="200px;" style="color:#000; padding:5px; background-color: #D9D9D9; font-size:12px; font-weight: bold;">Responsable</td></tr>
		';
         
		
		$contmedio = 1;
		$loopmedio = 0;
		if($nummedios != 0){
			
			
			foreach($this->Model->medios as $rowmedios){
		    $script .='
			lineas_objetivos_medios['.$loop.']['.$loopobjetivo.']['.$loopmedio.'] = "1";
			 ';	
		
	  $panelcontent .= '<tr id="L'.$cont.'-O'.$contobjetivo.'-M'.$contmedio.'-C'.$contobjetivo.'"><td></td><td  align="right" style="color:#000; float:right;  padding:5px; font-size:11px; ">'.$cont.'.'.$contobjetivo.'.'.$contmedio.'</td><td colspan="2"  style="color:#000;  padding:5px; font-size:11px; ">'.htmlentities($rowmedios['MEDIO'], ENT_QUOTES, "ISO-8859-1").'</td><td  style="color:#000; padding:5px;  font-size:11px; ">'.htmlentities($this->Model->getResponsable($rowmedios['PK_RESPONSABLE']), ENT_QUOTES, "ISO-8859-1").'</td></tr>';
		
		$contmedio++;
		$loopmedio++;
		   }
		}
                    
       $panelcontent .=' <tr>	
        <td colspan="2">
        <div class="left" style="margin-left:30px;">           
        			
		</div>            
        </td>
        </tr>
        </table>
        </div>
                      
                      
         <div>
         <table width="100%">
         <tr><td></td><td width="100px;"></td><td colspan="2" bgcolor="#D9D9D9"  style="color:#000; background-color: #D9D9D9; padding:5px; font-size:12px; font-weight: bold;">Evidencias</td><td></td></tr>
		 ';
		 
		 
		$this->Model->getEvidencias($rowobj['PK1']);
		$numevidencias = sizeof($this->Model->evidencias); 
		
		$contevidencia = 1;
		$loopevidencia = 0;
		if($numevidencias != 0){
			
			
			foreach($this->Model->evidencias as $rowevidencias){
		    $script .='
			lineas_objetivos_evidencias['.$loop.']['.$loopobjetivo.']['.$loopevidencia.'] = "1";
			 ';	           
          
		$panelcontent .= '<tr id="L'.$cont.'-O'.$contobjetivo.'-E'.$contevidencia.'-C'.$contobjetivo.'"><td></td><td  align="right" style="color:#000; float:right;  padding:5px; font-size:11px; ">'.$cont.'.'.$contobjetivo.'.'.$contevidencia.'</td><td colspan="2"  style="color:#000;  padding:5px; font-size:11px; ">'.htmlentities($rowevidencias['EVIDENCIA'], ENT_QUOTES, "ISO-8859-1").'</td><td  style="color:#000; padding:5px;  font-size:11px; "></td></tr>';
		    
		$contevidencia++;
		$loopevidencia++;
                    }
				}
					
          $panelcontent .='<tr>
          <td colspan="2">
          <div class="left" style="margin-left:30px;">         
         			
		  </div>
          </td>
          </tr>     
          </table>
          </div> 
		  
                </div>     
				
				
			 <!--====================BOTON DE COMENTARIOS=====================-->';
				 
				
				 $permiso = ($_GET['estado']=="R") ? "P86" : "P50";
				 if($this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){
				 
				$panelcontent .=' <div class="box-icon" align="right">
				  <span style="float:right; position:relative; left:-10px;" class="notification">'.$this->Model->getNumeroComentarios($rowobj['PK1']).'</span>
<a href="javascript:void(0)" onclick="Tooglecomentarios(this.id);" class="btn btn-minimize btn-round" id="COM-L'.$cont.'-C'.$contobjetivo.'"><i class="icon-chevron-down"></i> Comentarios</a>
						
					
</div>';
        }
		
		$panelcontent .= '<!--====================BOTON DE COMENTARIOS=====================-->
		  
		  <!--====================COMENTARIOS=====================-->
		  
		 <div class="box-objectivos" style="display:none;" id="BOXCOM-L'.$cont.'-C'.$contobjetivo.'">';
			
			 $permiso = ($_GET['estado']=="R") ? "P84" : "P48";
			   if($this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){
			   
			   $panelcontent .='<div id="twitter-container"> <span class="counter" id="counter-L'.$cont.'-'.$contobjetivo.'"></span>
			    <textarea name="inputField" id="inputField-L'.$cont.'-'.$contobjetivo.'"   tabindex="1" rows="2" cols="40"></textarea>';
			   
			  
			  if($this->passport->getPrivilegio($_GET['IDPlan'],'P82')){ 
			   $panelcontent .= '<label class="checkbox inline">
			   <div class="checker"><span><input type="checkbox" value="option1" id="mandatorio-objetivo-L'.$cont.'-'.$contobjetivo.'" style="opacity: 0;"></span></div><h3>Mandatorio</h3>
				</label>';
	            }			
			   
			   
			   
			  
			 $panelcontent .='<input class="submitButton inact" name="submit" type="button" onClick="guardarComentario(this.id,\''.$rowobj['PK1'].'\');" value="comentar" disabled="disabled" id="update_button-L'.$cont.'-'.$contobjetivo.'" />
			 
			 </div><div class="clear"></div>';
			   
				}
				
				
	$panelcontent .='
		  
		
          <div id="flashmessage">	
    <div id="flash"></div>
	  		</div>
   		  <div class="comentarios" id="comentarios-L'.$cont.'-'.$contobjetivo.'">';
		  
		  
		            //  echo $rowobj['PK1']."<";
	           $this->Model->getComentarios($rowobj['PK1']);
		       $numcomentarios = sizeof($this->Model->comentarios); 
					
					if($numcomentarios != 0){
					
						foreach($this->Model->comentarios as $rowcomentarios){
 						{
                             
							 
							$tipo = trim($rowcomentarios['TIPO']);							 
							$comentario_id= $rowcomentarios['PK1'];
							$usuario_id=$rowcomentarios['PK_USUARIO'];
							$fecha = $rowcomentarios['FECHA_R'];
							$comentario = stripslashes(htmlentities($rowcomentarios['COMENTARIO'], ENT_QUOTES, "ISO-8859-1"));
												
							$rowusuario	= $this->Model->getImagen($usuario_id);	
							$imagen =  "media/usuarios/".$rowusuario['IMAGEN'];
							
							$usuario = $rowusuario['NOMBRE']." ".$rowusuario['APELLIDOS'];
				             
							 
							if($tipo=="M"){$class = "stbody2"; $class2='<span class="label label-important">Mandatorio</span>';}else{ $class = "stbody"; $class2=""; }
							 
							 
				$panelcontent .='<div class="'.$class.'" id="stbody'.$comentario_id.'">
    		<div class="sttimg"><img src="'.$imagen.'" class="big_face"/></div> 
    		<div class="sttext">';
			
			  $permiso = ($_GET['estado']=="R") ? "P85" : "P49";
			 if($this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){
		      $panelcontent .='<a class="stdelete" href="#" id="'.$comentario_id.'" title="Borrar comentario"><i class="icon-remove"></i></a>';
		      }
			
	$panelcontent .=' 
    					<strong><a href="#" class="comentuser">'.htmlentities($usuario, ENT_QUOTES, "ISO-8859-1").'</a></strong>
						'.$class2.'
						<br/>
						'.$comentario.'
   						<div class="sttime">'.date('d/m/Y H:i:s', strtotime($fecha->format('Y-m-d H:i:s'))).'</div> 
    				</div>  
				</div>';
    
 		}
	 }
	
	}
	
   $panelcontent .=' </div></div>
           <!--====================END COMENTARIOS=====================-->
		  
		  
          </div>
		  
		    
		  
           <!--====================END OBJETIVO=====================-->';
           $contobjetivo++;
		   $loopobjetivo++;
		    }
			
		   }          
		
           $panelcontent .='<!-- Pagging -->
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
                        <div class="right">
        
                        </div>
						</div>
						<!-- End Pagging --> 
    
						</div>  ';
			$panelcontent .='</div>';
			$cont++;
			$loop++;
			}
		    $script .='
			</script>';	
			$tabs .='</ul>';
			$panelcontent .='</div>';
		
		}
		
		$section .= $tabs;
		$section .= $panelcontent;
		$section .= $script;
										
		return $section;
	   }


         function insertarComentario(){
	
			
			if(isset($_POST['tipo'])){$tipo = $_POST['tipo'];}else{ $tipo = "R";}
			
			if($tipo=="M"){$class = "stbody2"; $class2='<span class="label label-important">Mandatorio</span>';}else{ $class = "stbody"; $class2=""; }
			
			$id = $this->Model->insertarComentario($_POST['comentario'],$_POST['idobjetivo'],$tipo);
		    $usuario = $_SESSION['session']['titulo'].' '.$_SESSION['session']['nombre'].' '.$_SESSION['session']['apellidos'];
		    $imagen = 'media/usuarios/thum_40x40_'.$_SESSION['session']['imagen'];
			
			$fecha = date("d/m/Y H:i:s");
			
			echo '<div class="'.$class.'" id="stbody'.$id.'">
    <div class="sttimg"><img src="'.$imagen.'" class="big_face"/></div> 
    <div class="sttext"><a class="stdelete" href="#" id="'.$id.'" title="Borrar comentario"><i class="icon-remove"></i></a>
	
	<strong><a href="#">'.htmlentities($usuario, ENT_QUOTES, "ISO-8859-1").'</a></strong>
	'.$class2.'
	<br/>
    '.$_POST['comentario'].'
   	<div class="sttime">'.$fecha.'</div> 
</div>';
		 	
		 }

          
		  function eliminarComentario(){
	
			$this->Model->eliminarComentario($_POST['idcomentario']);
		
		  }
		  
		  
		  
		 function insertarComentarioResumen(){
		 	
			
			if(isset($_POST['tipo'])){$tipo = $_POST['tipo'];}else{ $tipo = "R";}
			
			if($tipo=="M"){$class = "stbody2"; $class2='<span class="label label-important">Mandatorio</span>';}else{ $class = "stbody"; $class2=""; }
			
			$id = $this->Model->insertarComentarioResumen($_POST['comentario'],$_POST['idplan'],$tipo);
			 $usuario = $_SESSION['session']['titulo'].' '.$_SESSION['session']['nombre'].' '.$_SESSION['session']['apellidos'];
		    $imagen = 'media/usuarios/thum_40x40_'.$_SESSION['session']['imagen'];
			
			$fecha = date("d/m/Y H:i:s");
			
			echo '<div class="'.$class.'" id="stbodyr'.$id.'">
    <div class="sttimg"><img src="'.$imagen.'" class="big_face"/></div> 
    <div class="sttext"><a class="stdeleter" href="#" id="r'.$id.'" title="Borrar comentario"><i class="icon-remove"></i></a>
	
	<strong><a href="#">'.htmlentities($usuario, ENT_QUOTES, "ISO-8859-1").'</a></strong>
	'.$class2.'
	<br/>
    '.$_POST['comentario'].'
   	<div class="sttime">'.$fecha.'</div> 
</div>';
		 	
		 }
		  
		  
		  function getComentariosResumenEjecutivo(){
		  	
			$panelcontent = "";
			$permiso = ($_GET['estado']=="R") ? "P87" : "P51";
			   if($this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){
			$panelcontent = '<!--====================COMENTARIOS=====================-->
		  
		   <div id="twitter-container">
			
			    <span class="counter" id="counter-resumen">140</span>
			    <textarea name="inputField" id="inputField-resumen"   tabindex="1" rows="2" cols="40"></textarea>';
			   
			   if($this->passport->getPrivilegio($_GET['IDPlan'],'P82')){ 
				  $panelcontent .= '<label class="checkbox inline">
			   <div class="checker"><span><input type="checkbox" value="option1" id="mandatorio-resumen" style="opacity: 0;"></span></div><h3>Mandatorio</h3>
				</label>';
				}
			   
			  $panelcontent .= '<input class="submitButton inact" name="submit" type="button" onClick="guardarComentarioResumen();" value="comentar" disabled="disabled" id="update_button-resumen" />
			    <div class="clear"></div>
		    
		  </div>';
		  
		  }
		  
       $panelcontent .='<div id="flashmessage">	
    <div id="flash"></div>
	  		</div>
   		  <div class="comentarios" id="comentarios-resumen">';
		  
		  
		            
	           $this->Model->getComentariosResumen($_GET['IDPlan']);
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
							 
				$panelcontent .='<div class="'.$class.'" id="stbodyr'.$comentario_id.'">
    		<div class="sttimg"><img src="'.$imagen.'" class="big_face"/></div> 
    		<div class="sttext">';
			
			
			$permiso = ($_GET['estado']=="R") ? "P88" : "P52";
			if($this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){
		   $panelcontent .='<a class="stdeleter" href="#" id="r'.$comentario_id.'" title="Borrar comentario"><i class="icon-remove"></i></a>';
		   }
			
			 $panelcontent .= ' 
    					<strong><a href="#" class="comentuser">'.htmlentities($usuario, ENT_QUOTES, "ISO-8859-1").'</a></strong>
						'.$class2.'<br>
						'.$comentario.'
   						<div class="sttime">'.date('d/m/Y H:i:s', strtotime($fecha->format('Y-m-d H:i:s'))).'</div> 
    				</div>  
				</div>';
    
 		}
	 }
	
	}
	
   $panelcontent .=' </div>
        
                     <!--====================END COMENTARIOS=====================-->';
		  
			return $panelcontent;
		  }
		  
		  
		  
		  function eliminarComentarioResumen(){
		  	
			$this->Model->eliminarComentarioResumen($_POST['idcomentario']);
			
		  }
		  
		  

         function EnviarRevision(){
			 
			$this->Model->EnviarRevision($_POST['IDPlan'],$_POST['IDPlanE']);
				 
          }
		  
		  
		 function PasarSeguimiento(){
			 
			$this->Model->PasarSeguimiento($_POST['IDPlan'],$_POST['idplane']);
				 
          }
		  
		  
	function getComentariosGenerales(){
		  	
			$panelcontent = "";
			
			$permiso = ($_GET['estado']=="R") ? "P143" : "P144";
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
							$comentario = stripslashes(htmlentities($rowcomentariosr['COMENTARIO'], ENT_QUOTES, "ISO-8859-1"));
							
							$rowusuario	= $this->Model->getImagen($usuario_id);	
							$imagen =  "media/usuarios/".$rowusuario['IMAGEN'];
							
							$usuario = $rowusuario['NOMBRE']." ".$rowusuario['APELLIDOS'];
							 
							 
							if($tipo=="M"){$class = "stbody2"; $class2='<span class="label label-important">Mandatorio</span>'; }else{ $class = "stbody"; $class2=""; }
							 
				$panelcontent .='<div class="'.$class.'" id="stbodyg'.$comentario_id.'">
    		<div class="sttimg"><img src="'.$imagen.'" class="big_face"/></div> 
    		<div class="sttext">';
			
			
			$permiso = ($_GET['estado']=="R") ? "P145" : "P146";
			if($this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){
		   $panelcontent .='<a class="stdeleteg" href="#" id="g'.$comentario_id.'" title="Borrar comentario"><i class="icon-remove"></i></a>';
		   }
			//$fecha->format('Y-m-d H:i:s')
			 $panelcontent .= ' 
    					<strong><a href="#" class="comentuser">'.htmlentities($usuario, ENT_QUOTES, "ISO-8859-1").'</a></strong>
						'.$class2.'<br>
						'.$comentario.'
						
   						<div class="sttime">'.date('d/m/Y H:i:s', strtotime($fecha->format('Y-m-d'))).'</div> 
    				</div>  
				</div>';
    
 		}//end for
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
		  
		  
		  
		  
		 function BuscarComentarios(){
		 
		 $html="";
		 $this->Model->getLineasPlane($_GET['IDPlanE']);
		 $numlineas = sizeof($this->Model->lineas); 
		 
		 $cont=1;
		 
		 foreach($this->Model->lineas as $row){
		
		$idlinea = $row['PK1'];		
		$linea = $row['LINEA'];	
		
		
		 
		       $this->Model->getObjetivosTacticos($_GET['IDPlan'],$idlinea);
		       $numobjetivos = sizeof($this->Model->objetivos); 
			   
			     if($numobjetivos != 0){
			      
				  $contobjetivo = 1;
				  foreach($this->Model->objetivos as $rowobj){
			      
				   $rowobjes = 	$this->Model->getObjetivoEst($rowobj['PK_OESTRATEGICO']);
				   $html .= '<div style="color:#000; background-color: #D9D9D9; padding:5px; font-size:12px; "><strong>Linea '.$cont.':</strong>&nbsp;'.htmlentities($linea, ENT_QUOTES, "ISO-8859-1").'</div>';
				   $html .= '<div style="color:#000; background-color: #EBEBEB; padding:5px; font-size:12px;"><strong>Resultado '.$cont.'.'.$contobjetivo.':</strong>&nbsp;'.htmlentities($rowobj['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</div>';
				   //$html .= '<div style="color:#000; background-color: #EBEBEB; padding:5px; font-size:12px;"><strong>Objetivo:</strong>&nbsp;'.htmlentities($rowobjes['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</div>';
				   $html .= '<div style="float:right; margin-right:30px;"><a id="COMODAL-L1-C1" class="btn btn-minimize btn-round" onclick="ComentarModal(this.id);" href="javascript:void(0)"><i class="icon-comment"></i> Comentar</a></div>';
				  
				  $html .= '<!--====================BOTON DE COMENTARIOS=====================-->
		  
		  <!--====================COMENTARIOS=====================-->
		  
		 <div class="box-objectivos" style="display:block;" id="BOXCOM-L'.$cont.'-C'.$contobjetivo.'">';
			
			 $permiso = ($_GET['estado']=="R") ? "P84" : "P48";
			   if($this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){
			   
			   $html .='<div id="twitter-container" style="display:none;"> <span class="counter" id="counter-L'.$cont.'-'.$contobjetivo.'"></span>
			    <textarea name="inputField" id="inputField-L'.$cont.'-'.$contobjetivo.'"   tabindex="1" rows="2" cols="40"></textarea>';
			   
			  
			  if($this->passport->getPrivilegio($_GET['IDPlan'],'P82')){ 
			   $html .= '<label class="checkbox inline">
			   <div class="checker"><span><input type="checkbox" value="option1" id="mandatorio-objetivo-L'.$cont.'-'.$contobjetivo.'" style="opacity: 0;"></span></div><h3>Mandatorio</h3>
				</label>';
	            }			
			   
			   
			   
			  
			 $html .='<input class="submitButton inact" name="submit" type="button" onClick="guardarComentario(this.id,\''.$rowobj['PK1'].'\');" value="comentar" disabled="disabled" id="update_button-L'.$cont.'-'.$contobjetivo.'" />
			 
			 </div><div class="clear"></div>';
			   
				}
				
				
	  $html .='
		  
		
          <div id="flashmessage">	
    <div id="flash"></div>
	  		</div>
   		  <div class="comentarios" id="comentarios-L'.$cont.'-'.$contobjetivo.'">';
		  
		  
		            //  echo $rowobj['PK1']."<";
	           $this->Model->getComentarios($rowobj['PK1']);
		       $numcomentarios = sizeof($this->Model->comentarios); 
					
					if($numcomentarios != 0){
					
						foreach($this->Model->comentarios as $rowcomentarios){
 						{
                             
							 
							$tipo = trim($rowcomentarios['TIPO']);							 
							$comentario_id= $rowcomentarios['PK1'];
							$usuario_id=$rowcomentarios['PK_USUARIO'];
							$fecha = $rowcomentarios['FECHA_R'];
							$comentario = stripslashes(htmlentities($rowcomentarios['COMENTARIO'], ENT_QUOTES, "ISO-8859-1"));
												
							$rowusuario	= $this->Model->getImagen($usuario_id);	
							$imagen =  "media/usuarios/".$rowusuario['IMAGEN'];
							
							$usuario = $rowusuario['NOMBRE']." ".$rowusuario['APELLIDOS'];
				             
							 
							if($tipo=="M"){$class = "stbody2"; $class2='<span class="label label-important">Mandatorio</span>';}else{ $class = "stbody"; $class2=""; }
							 
							 
				$html .='<div class="'.$class.'" id="stbody'.$comentario_id.'">
    		<div class="sttimg"><img src="'.$imagen.'" class="big_face"/></div> 
    		<div class="sttext">';
			
			  $permiso = ($_GET['estado']=="R") ? "P85" : "P49";
			 if($this->passport->getPrivilegio($_GET['IDPlan'],$permiso)){
		      $html .='<a class="stdelete" href="#" id="'.$comentario_id.'" title="Borrar comentario"><i class="icon-remove"></i></a>';
		      }
			
	$html .=' 
    					<strong><a href="#" class="comentuser">'.htmlentities($usuario, ENT_QUOTES, "ISO-8859-1").'</a></strong>
						'.$class2.'
						<br/>
						'.$comentario.'
   						<div class="sttime">'.date('d/m/Y H:i:s', strtotime($fecha->format('Y-m-d'))).'</div> 
    				</div>  
				</div>';
    
 		}
	 }
	
	}
	
   $html .=' </div></div>
           <!--====================END COMENTARIOS=====================-->';
				  
				  
				  $contobjetivo++;
				  }// end for objetivos
				  
			  
			  }else{
			  $html .= '<div style="color:#000; background-color: #D9D9D9; padding:5px; font-size:12px; "><strong>Linea:</strong>&nbsp;'.htmlentities($linea, ENT_QUOTES, "ISO-8859-1").'</div>';
			  //NO EXISTEN OBJETIVOS
			  
			  }
		
		 $cont++;
		 }//end for lineas
		 echo $html;
		 
		 }
		  
	
	
	

	function relativeTime($dt,$precision=2)
{
	
	
	$times=array(	365*24*60*60	=> "year",
					30*24*60*60		=> "month",
					7*24*60*60		=> "week",
					24*60*60		=> "day",
					60*60			=> "hour",
					60				=> "minute",
					1				=> "second");
	
	
	$time_difference=time()-strtotime($dt);
	$seconds = $time_difference ; 
	$minutes = round($time_difference / 60 );
	$hours = round($time_difference / 3600 ); 
	$days = round($time_difference / 86400 ); 
	$weeks = round($time_difference / 604800 ); 
	$months = round($time_difference / 2419200 ); 
	$years = round($time_difference / 29030400 ); 

	if($seconds <= 60)
	{
		$output = "Hace $seconds segundos"; 
	}
	else if($minutes <=60)
		{
   		if($minutes==1)
   		{
     		$output = "Hace un minuto"; 
   		}
   		else
   		{
   		$output = "Hace $minutes minutos"; 
   		}
	}
	else if($hours <=24)
	{
  		if($hours==1)
   		{
   			$output = "Hace una hora";
   			}
 			else
  			{
  			$output = "Hace $hours horas";
  			}
		}
		else if($days <=7)
		{
  			if($days==1)
   			{
   				$output = "Hace un d&iacutea";
   			}
  			else
  			{
 			$output = "Hace $days d&iacuteas";
  			}
	}
	else if($weeks <=4)
	{
  		if($weeks==1)
   		{
   			$output = "Hace una semana";
   		}
  		else
  		{
  			$output = "Hace $weeks semanas";
  		}
 	}
	else if($months <=12)
	{
   		if($months==1)
   		{
   			$output = "Hace un mes";	
   		}
  		else
  		{
  			$output = "Hace $months meses";
  		} 
	}
	else
	{
		if($years==1)
   		{
   			$output = "Hace un a&ntildeo";
   		}
  		else
  		{
  		$output = "Hace $years a&ntildeos";
  		}
	}
	
	return $output;
}
	
	
}

?>