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
	

	function revisionobjetivosfinal() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("option");
	 $this->Model = new revisionobjetivosfinalModel();
		
	 switch($_GET['method']){
	 	
		case "GuardarObjetivos":
			$this->GuardarObjetivos();
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
	  $nombre = $_SESSION['session']['titulo'].' '.htmlentities($_SESSION['session']['nombre'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($_SESSION['session']['apellidos'], ENT_QUOTES, "ISO-8859-1");
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
	 	

		$contenido = $this->View->Template(TEMPLATE.'modules/planesoperativo/FRMREVISIONFINAL.TPL');
		$plan =  $this->Model->getPlanOperativo($_GET['IDPlan']);
		$contenido =  $this->View->replace('/\#TITULOPLAN\#/ms' ,htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1"),$contenido);
		
		$contenido =  $this->View->replace('/\#ESTADO\#/ms' ,$this->Model->getEstadoPlanOperativo($_GET['IDPlan']),$contenido);
		
		$contenido =  $this->View->replace('/\#CONTENIDO\#/ms' ,$this->obtenerLineas(),$contenido);		
		$contenido =  $this->View->replace('/\#RESPONSABLES\#/ms' ,$this->obtenerResponsables(),$contenido);
		
		$contenido =  $this->View->replace('/\<!--#VALUEDESCRIPCION#-->/ms' ,htmlspecialchars_decode($this->getResumenEjecutivo()),$contenido);
		
			$contenido =  $this->View->replace('/\#COMENTARIOSRESUMENEJECUTIVO\#/ms' ,$this->getComentariosResumenEjecutivo(),$contenido);
			
			$contenido =  $this->View->replace('/\#NR\#/ms' ,$this->Model->getNumeroComentariosResumenEjecutivo($_GET['IDPlan']),$contenido);
		
		$urlcancelar="<a href=\"?execute=planesoperativo/revisionobjetivos&method=default&estado=".$_GET['estado']."&Menu=F2&SubMenu=SF21&IDPlan=".$_GET['IDPlan']."&IDPlanE=".$_GET['IDPlanE']."\" class=\"btn btn-large\"><i class=\"icon-chevron-left\"></i> Regresar a Revisión</a>";
		
		
		$contenido =  $this->View->replace('/\#BUTTONCANCELAR\#/ms' ,$urlcancelar,$contenido);
		$contenido =  $this->View->replace('/\#BUTTONCANCELAR2\#/ms' ,$urlcancelar,$contenido);
		 
		
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
		
		if($numareas>=2){
		$script .='$(\'#BEAREA\').removeAttr("disabled");';
		}
		
		foreach($this->Model->areas as $row){
          
		 $script .='array_areas.push("1");';
		 $htmLcontent .= ' <tr id="AREA-'.$loop.'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  <span class="add-on" id="LABEL-AREA-'.$loop.'">'.$loop.'.</span>
          <input type="text" class="area" style="width:85%;" value="'.htmlentities($row['AREA'], ENT_QUOTES, "ISO-8859-1").'"  id="INPUT-AREA-'.$loop.'">
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
          <div style="margin-left:30px;" class="left">         
          <button style="float:left; margin-right:10px;" onclick="EliminarArea();" id="BEAREA" disabled="disabled" class="btn btn-small"><i class="icon-remove"></i> Eliminar Área</button>
	      <button onclick="AgregarArea();" id="BAAREA"  class="btn btn-small"><i class="icon-plus"></i>Agregar Área</button>			
		  </div>
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
		
		
		if($numfortalezas>=2){
		$script .='$(\'#BEFORTALEZA\').removeAttr("disabled");';
		}
		
		foreach($this->Model->fortalezas as $row){
          
		 $script .='array_fortalezas.push("1");';
		 $htmLcontent .= ' <tr id="FORTALEZA-'.$loop.'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  <span class="add-on" id="LABEL-FORTALEZA-'.$loop.'">'.$loop.'.</span>
          <input type="text" class="fortaleza" style="width:85%;" value="'.htmlentities($row['FORTALEZA'], ENT_QUOTES, "ISO-8859-1").'"  id="INPUT-FORTALEZA-'.$loop.'">
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
          <div style="margin-left:30px;" class="left">         
          <button style="float:left; margin-right:10px;" onclick="EliminarFortaleza();" id="BEFORTALEZA" disabled="disabled" class="btn btn-small"><i class="icon-remove"></i> Eliminar Fortaleza</button>
	      <button onclick="AgregarFortaleza();" id="BAFORTALEZA"  class="btn btn-small"><i class="icon-plus"></i>Agregar Fortaleza</button>			
		  </div>
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
		
		$panelcontent .='>'.htmlentities($row['APELLIDOS'].' '.$row['NOMBRE'], ENT_QUOTES, "ISO-8859-1").'</option>';
			
		}
		
		
		return $panelcontent;
	   }
	   
	   
	   
	   
	   function obtenerLineas(){
	   	
		$script = "";
		$tabs = "";
		$panelcontent = "";
		$section = "";
		
	   	
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
			
					
		    $("#inputField-L'.$cont.'-'.$contobjetivo.'").bind("blur focus keydown keypress keyup", function(){recount(\''.$cont.'-'.$contobjetivo.'\');});
	        $("#update_button-L'.$cont.'-'.$contobjetivo.'").attr("disabled","disabled");
		    $("#inputField-L'.$cont.'-'.$contobjetivo.'").Watermark("Agrega tu comentario ...");
			 ';
					
			
			
			
       $panelcontent .='<!--====================OBJETIVO=====================--> 
   <div class="wellstrong" id="L'.$cont.'-C'.$contobjetivo.'" >
                  
   <table width="100%">
   <tr>
   <td colspan="2">Objetivo Estratégico:
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
				
	   $panelcontent .='</select> 
       </td>
   </tr>
   
       <tr>
       <td>Resultado:</td>
       <td> Responsable</td>
       </tr>
                    
       <tr>
       <td width="70%">   
		<div class="input-prepend">
		   <span class="add-on" id="LABEL-L'.$cont.'-O'.$contobjetivo.'">'.$cont.'.'.$contobjetivo.'</span>
           <input id="L'.$cont.'-O'.$contobjetivo.'" class="objetivo" style="width:90%;" value="'.htmlentities($rowobj['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'"  style="width:400px;" type="text">
		</div>
       </td>
       
       <td width="30%"><select id="L'.$cont.'-OR'.$contobjetivo.'" style="width:100%;" >';
	   
	      $panelcontent .= $this->obtenerResponsables($rowobj['PK_RESPONSABLE']);      
	   
	   $panelcontent .='</select></td>
       </tr>
       </table>';
                  
	    $this->Model->getMedios($rowobj['PK1']);
		$nummedios = sizeof($this->Model->medios); 		  
		
				  
	$panelcontent.= '<div class="box-icon">
	<span style="float:left; position:relative; left:10px;" class="notification">'.$nummedios.'</span>
<a href="javascript:void(0)" onclick="Toogle(this.id);" class="btn btn-minimize btn-round" id="TOG-L'.$cont.'-C'.$contobjetivo.'"><i class="icon-chevron-down"></i> Medios</a>						
</div>
				    
      <div class="box-objectivos" id="BOX-L'.$cont.'-C'.$contobjetivo.'" style="display:none;">
       <div class="well" >
       <table width="100%">
        <tr>
        <td width="30">&nbsp;	</td>
        <td>Medios</td>
        <td>Responsable</td>
        </tr>';
         
		 
		 
		
		
		$contmedio = 1;
		$loopmedio = 0;
		
		$disabled = ($nummedios>1)? "" : "disabled=\"disabled\"";
		
		if($nummedios != 0){
			
			
			foreach($this->Model->medios as $rowmedios){
		    $script .='
			lineas_objetivos_medios['.$loop.']['.$loopobjetivo.']['.$loopmedio.'] = "1";
			 ';	
		 
       $panelcontent .=' <tr id="L'.$cont.'-O'.$contobjetivo.'-M'.$contmedio.'-C'.$contobjetivo.'">
        <td>&nbsp; </td>
        <td width="540">  
        <div class="input-prepend">
		<span class="add-on" id="LABEL-L'.$cont.'-O'.$contobjetivo.'-M'.$contmedio.'">'.$cont.'.'.$contobjetivo.'.'.$contmedio.'</span>
        <input id="L'.$cont.'-O'.$contobjetivo.'-M'.$contmedio.'" class="medio" value="'.htmlentities($rowmedios['MEDIO'], ENT_QUOTES, "ISO-8859-1").'"  style="width:470px;" type="text">
		</div> 
        </td>                          
        <td><select id="L'.$cont.'-O'.$contobjetivo.'-M'.$contmedio.'-R'.$contmedio.'"> ';
		
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
         <td>Evidencias	</td>            
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
          <input id="L'.$cont.'-O'.$contobjetivo.'-E'.$contevidencia.'" class="evidencia" value="'.htmlentities($rowevidencias['EVIDENCIA'], ENT_QUOTES, "ISO-8859-1").'"   style="width:470px;" type="text">
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
          
		  
		   <!--====================BOTON DE COMENTARIOS=====================-->
				  <div class="box-icon" align="right" style="display:none;">
				  
				   <span style="float:right; position:relative; left:-10px;" class="notification">'.$this->Model->getNumeroComentarios($rowobj['PK1']).'</span>
<a href="javascript:void(0)" onclick="Tooglecomentarios(this.id);" class="btn btn-minimize btn-round" id="COM-L'.$cont.'-C'.$contobjetivo.'"><i class="icon-chevron-down"></i> Comentarios</a>						
</div>
          <!--====================BOTON DE COMENTARIOS=====================-->
		  
		  
		   <!--====================COMENTARIOS=====================-->
		  <div class="box-objectivos" style="display:none; background:#FFF;" id="BOXCOM-L'.$cont.'-C'.$contobjetivo.'">
		  <div id="twitter-container">
			
			    <span class="counter" id="counter-L'.$cont.'-'.$contobjetivo.'">140</span>
			    <textarea name="inputField" id="inputField-L'.$cont.'-'.$contobjetivo.'"   tabindex="1" rows="2" cols="40"></textarea>
			   
			    <label class="checkbox inline">
			   <div class="checker"><span><input type="checkbox" value="option1" id="mandatorio-objetivo-L'.$cont.'-'.$contobjetivo.'" style="opacity: 0;"></span></div><h3>Mandatorio</h3>
				</label>	
				
				
				<input class="submitButton inact" name="submit" type="button" onClick="guardarComentario(this.id,\''.$rowobj['PK1'].'\');" value="comentar" disabled="disabled" id="update_button-L'.$cont.'-'.$contobjetivo.'" />
			    <div class="clear"></div>
		    
		  </div>
		  
		  
		  
		
          <div id="flashmessage">	
    <div id="flash"></div>
	  		</div>
   		  <div class="comentarios" id="comentarios-L'.$cont.'-'.$contobjetivo.'">';
		  
		  
		          
	           $this->Model->getComentarios($rowobj['PK1']);
		       $numcomentarios = sizeof($this->Model->comentarios); 
					
					if($numcomentarios != 0){
					
						foreach($this->Model->comentarios as $rowcomentarios){
 						{

                            $tipo = trim($rowcomentarios['TIPO']);
							$comentario_id=$rowcomentarios['PK1'];
							$usuario_id=$rowcomentarios['PK_USUARIO'];
							$fecha = $rowcomentarios['FECHA_R'];
							$comentario = stripslashes(htmlentities($rowcomentarios['COMENTARIO'], ENT_QUOTES, "ISO-8859-1"));
												
							$rowusuario	= $this->Model->getImagen($usuario_id);	
							$imagen =  "media/usuarios/".$rowusuario['IMAGEN'];
							
							$usuario = $rowusuario['NOMBRE']."".$rowusuario['APELLIDOS'];
							
							if($tipo=="M"){$class = "stbody2"; $class2='<span class="stmandatorio">Mandatorio</span>';}else{ $class = "stbody"; $class2=""; }
							 
				$panelcontent .='<div class="'.$class.'" id="stbody'.$comentario_id.'">
    		<div class="sttimg"><img src="'.$imagen.'" class="big_face"/></div> 
    		<div class="sttext"><a class="stdelete" href="#" id="'.$comentario_id.'" title="Borrar comentario"><i class="icon-remove"></i></a>             &nbsp;&nbsp; '.$class2.'
    					<strong><a href="#" class="comentuser">'.htmlentities($usuario, ENT_QUOTES, "ISO-8859-1").'</a></strong><br/>
						'.$comentario.'
   						<div class="sttime">'.date('d/m/Y H:i:s', strtotime($fecha->format('Y-m-d'))).'</div> 
    				</div>  
				</div>';
    
 		}
	 }
	
	}
	
   $panelcontent .=' </div>
        </div>
           <!--====================END COMENTARIOS=====================-->
		  
		  
          
          </div>
           <!--====================END OBJETIVO=====================-->
		   
		   
		   
		  
           <!--====================END OBJETIVO=====================-->';
		   
		   
           $contobjetivo++;
		   $loopobjetivo++;
		    }
			
		   }          
		
           $panelcontent .='<!-- Pagging -->
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
                        <div class="right">
                       <button class="btn btn-large" '.$disabledobjetivo.' id="BEO-L'.$cont.'" onclick="EliminarObjetivo(this.id);" style="float:left; margin-right:10px;"><i class="icon-remove"></i> Eliminar Resultado
           </button>
                               
					<button class="btn btn-large"  id="BAO-L'.$cont.'" onclick="AgregarObjetivo(this.id);" style="float:left; margin-right:10px;"><i class="icon-plus"></i> Agregar Resultado
           </button>		   
							   
	
                        </div>
						</div>
						<!-- End Pagging --> 
    
						</div>  ';
			$panelcontent .='</div>';
			$cont++;
			$loop++;
			}
		    $script .='
			$(".objetivo").Watermark("Agregar un objetivo...");
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


         function insertarComentario(){
		 	
			if(isset($_POST['tipo'])){$tipo = $_POST['tipo'];}else{ $tipo = "R";}
			if($tipo=="M"){$class = "stbody2"; $class2='<span class="stmandatorio">Mandatorio</span>';}else{ $class = "stbody"; $class2=""; }
			
			$id = $this->Model->insertarComentario($_POST['comentario'],$_POST['idobjetivo']);
			$usuario = $_SESSION['session']['titulo'].' '.$_SESSION['session']['nombre'].' '.$_SESSION['session']['apellidos'];
		    $imagen = 'media/usuarios/thum_40x40_'.$_SESSION['session']['imagen'];
			
			$fecha = date("d/m/Y H:i:s");
			
			echo '<div class="stbody" id="stbody'.$id.'">
    <div class="sttimg"><img src="'.$imagen.'" class="big_face"/></div> 
    <div class="sttext"><a class="stdelete" href="#" id="'.$id.'" title="Borrar comentario"><i class="icon-remove"></i></a>
	'.$class2.'
	<strong><a href="#">'.htmlentities($usuario, ENT_QUOTES, "ISO-8859-1").'</a></strong><br/>
    '.$_POST['comentario'].'
   	<div class="sttime">'.$fecha.'</div> 
</div>';
		 	
		 }

          
		  function eliminarComentario(){
	
			$this->Model->eliminarComentario($_POST['idcomentario']);
		
		  }
		  
		  
		 function insertarComentarioResumen(){
		 	
			
		$id = $this->Model->insertarComentarioResumen($_POST['comentario'],$_POST['idplan']);
		$imagen = 'media/usuarios/thum_40x40_'.$_SESSION['session']['imagen'];
		$usuario = $_SESSION['session']['titulo'].' '.$_SESSION['session']['nombre'].' '.$_SESSION['session']['apellidos'];
		$fecha = date("Y-m-d H:i:s");
			
			echo '<div class="stbody" id="stbodyr'.$id.'">
    <div class="sttimg"><img src="'.$imagen.'" class="big_face"/></div> 
    <div class="sttext"><a class="stdeleter" href="#" id="r'.$id.'" title="Borrar comentario"><i class="icon-remove"></i></a>
	<strong><a href="#">'.htmlentities($usuario, ENT_QUOTES, "ISO-8859-1").'</a></strong>
    '.$_POST['comentario'].'
   	<div class="sttime">'.$this->relativeTime($fecha).'</div> 
</div>';
		 	
		 }
		  
		  
		  function getComentariosResumenEjecutivo(){
		  	
			
			$panelcontent = '<!--====================COMENTARIOS=====================-->
		  
		  <div id="twitter-container">
			
			    <span class="counter" id="counter-resumen">140</span>
			    <textarea name="inputField" id="inputField-resumen"   tabindex="1" rows="2" cols="40"></textarea>
			   
			    <input class="submitButton inact" name="submit" type="button" onClick="guardarComentarioResumen();" value="comentar" disabled="disabled" id="update_button-resumen" />
			    <div class="clear"></div>
		    
		  </div>
		  
		  
		  
          <div id="flashmessage">	
    <div id="flash"></div>
	  		</div>
   		  <div class="comentarios" id="comentarios-resumen">';
		  
		  
		            
	           $this->Model->getComentariosResumen($_GET['IDPlan']);
		       $numcomentarios = sizeof($this->Model->comentarios); 
		  
		            
					if($numcomentarios != 0){
			
						foreach($this->Model->comentarios as $rowcomentariosr){
 						{
							
							$comentario_id=$rowcomentariosr['PK1'];
							$usuario_id=$rowcomentariosr['PK_USUARIO'];
							$fecha = $rowcomentariosr['FECHA_R'];
							$comentario = stripslashes(htmlentities($rowcomentariosr['COMENTARIO'], ENT_QUOTES, "ISO-8859-1"));
							

							$rowusuario	= $this->Model->getImagen($usuario_id);	
							$imagen =  "media/usuarios/".$rowusuario['IMAGEN'];
							
							$usuario = $rowusuario['NOMBRE']."".$rowusuario['APELLIDOS'];
							 

				$panelcontent .='<div class="stbody" id="stbodyr'.$comentario_id.'">
    		<div class="sttimg"><img src="'.$imagen.'" class="big_face"/></div> 
    		<div class="sttext"><a class="stdeleter" href="#" id="r'.$comentario_id.'" title="Borrar comentario"><i class="icon-remove"></i></a>  
    					<strong><a href="#" class="comentuser">'.htmlentities($usuario).'</a></strong>
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
		  
		  
		  
		  function eliminarComentarioResumen(){
		  	
			$this->Model->eliminarComentarioResumen($_POST['idcomentario']);
			
		  }
		 
		 
		 
		 

         function GuardarObjetivos(){
			 
			 
			 $this->Model->EliminarObjetivos($_POST['idPlanOperativo']);
			 
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
            $this->Model->areas = $areas;
            $this->Model->fortalezas = $fortalezas;
		    $this->Model->estado = 	$_POST['estado'];
		 
			
			
			$this->Model->GuardarObjetivos();
				 
	
          }
		  
		 
	
}

?>