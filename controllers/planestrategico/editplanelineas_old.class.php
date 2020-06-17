<?php
include "models/planestrategico/editplanelineas.model.php";
include "libs/resizeimage/class.upload.php";


class editplanelineas {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $image;
	var $targetPathumbail;
	

	function editplanelineas() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->Model = new editplanelineasModel();
		
	 switch($_GET['method']){
	 	
		case "GuardarLinea":
			$this->GuardarLinea();
			break;
		
		case "Activo":
			$this->isActivo();
			break;
		
			
		default:	
	      $this->View = new View(); 
          $this->loadPage();
		  break;
		}
				 
		 
	}
	
	
	
	 function loadPage(){
	
		$this->View->template = TEMPLATE.'FRMPRINCIPAL.TPL';	
		$this->View->loadTemplate();
		$this->loadHeader();
		$this->loadMenu();
		if($this->passport->privilegios->hasPrivilege('P12')){
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
	 	
		
		$section = TEMPLATE.'modules/planestrategico/EDTLINEAS.TPL';
	    $section = $this->View->loadSection($section);
		
		$row = $this->getPlan();
		$section = $this->View->replace('/\#TITULO\#/ms' ,htmlentities($row['TITULO'], ENT_QUOTES, "ISO-8859-1"),$section);
	    $urlmenu = '?execute=planestrategico/editplane&method=default&Menu=F1&SubMenu=SF11&IDPlan='.$row['PK1'];
	   
	    $section =  $this->View->replace('/\#CONTENIDO\#/ms' ,$this->getLineas(),$section);
	    $section = $this->View->replace('/\#MENUURL\#/ms' ,$urlmenu,$section);
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$section);
		
	
		 }
	 

         function GuardarPlan(){
		
		     $this->Model->idplan = $_POST['idplan'];
			$this->Model->titulo = $_POST['titulo'];
			$this->Model->descripcion = $_POST['descripcion'];
			$this->Model->disponible = $_POST['disponible'];
			$this->Model->fechai = $_POST['finicio'];
			$this->Model->fechat = $_POST['ftermino'];
			$this->Model->jerarquia = $_POST['jerarquia'];
			
			
			$this->Model->GuardarPlan();
			
	
          }
		  
		  
		
	     function getPlan(){
	     
		 $row = $this->Model->getPlan($_GET['IDPlan']);
       	 return $row;
			
	     }
		 
		 
		 function getLineas(){
		 	
		$this->Model->getLineasPlane($_GET['IDPlan']);
		$numlineas = sizeof($this->Model->lineas);
		
		$panelcontent = "";
	    $section = "";

		$script ='<script> ';
			  $cont = 1;
		      $loop = 0;
		
		
		$disabledlinea = ($numlineas>1)? "" : "disabled=\"disabled\"";
		
		if($numlineas != 0){ 
		      
		foreach($this->Model->lineas as $row){
			
			$script .='
			arrayLineas.push('.$cont.');
			arrayobjetivos['.$loop.'] = new Array();';
			
			$idlinea = $row['PK1'];		
			$linea = $row['LINEA'];
			
			
			$panelcontent .= '<div id="linea'.$cont.'" class="box" style="display: block;">
                            <legend id="legenda'.$cont.'">'.$cont.'. L&iacute;nea Estrat&eacute;gica</legend>
									
                             <div class="well"> 
							<div class="control-group">
                            
								<label class="control-label" for="focusedInput"><i class="icon-asterisk"></i>Titulo:</label>
								<div class="controls">
								  
								  
								  
						<textarea style="width:700px;" class="input-xlarge focused" id="titulo'.$cont.'" name="titulo" >'.htmlentities($linea, ENT_QUOTES, "ISO-8859-1").'</textarea>
								  
								</div>
							  </div>
                              </div>
							
							 
							 <legend>Objetivos estrat&eacute;gicos:</legend>
							 
							<div class="well">'; 
                             
							
							
		 $this->Model->getObjetivosE($idlinea);
		 
		
			$contobjetivo = 1;
		    $loopobjetivo = 0;
			
			$numobjetivos = sizeof($this->Model->objetivosE);	
		    $disabledobjetivo = ($numobjetivos>1)? "" : "disabled=\"disabled\"";
			
	        foreach($this->Model->objetivosE as $rowObjE){  	
	        
	         $script .='
			arrayobjetivos['.$loop.']['.$loopobjetivo.'] = "1";
			 ';	
	        
			$panelcontent .='<div id="L'.$cont.'-controlobjetivo'.$contobjetivo.'" class="control-group">
							<div class="controls">
<div class="input-prepend">
<span id="textobjetivo" class="add-on">'.$contobjetivo.'</span>


<textarea style="width:700px;" name="L'.$cont.'-objetivo" id="L'.$cont.'-objetivo'.$contobjetivo.'" >'.htmlentities($rowObjE['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</textarea>

</div>
                                
							</div>
							</div> ';
			
			$contobjetivo++;
		    $loopobjetivo++;
			}
							
						
                         $panelcontent .='<div class="controls">
                            
                               
           <button style="float:left; margin-right:10px;" onclick="EliminarObjetivo(this.id);" id="OL'.$cont.'" '.$disabledobjetivo.' class="btn btn-small"><i class="icon-remove"></i> Eliminar Objetivo</button>
                                        
                                        
                             <a class="btn btn-small" onclick="agregarObjetivo(this.id);" id="L'.$cont.'" href="javascript:void(0)"><i class="icon-plus"></i> Agregar Objetivo</a>
                            </div>
                            </div>
                             
                    
                             </div>
							 
							 ';
			
			
			$cont++;
			$loop++;
			
			}//END FOR LINEAS
		
		 
		
		   }else{//if num lineas >0
			
			$script .='
			arrayLineas.push('.$cont.');
			arrayobjetivos['.$loop.'] = new Array();';
			
		
			
			$panelcontent .= '<div id="linea'.$cont.'" class="box" style="display: block;">
                            <legend id="legenda'.$cont.'">'.$cont.'. L&iacute;nea Estrat&eacute;gica</legend>
									
                             <div class="well"> 
							<div class="control-group">
                            
								<label class="control-label" for="focusedInput"><i class="icon-asterisk"></i>Título:</label>
								<div class="controls">
								  
								  
								  
						<textarea style="width:700px;" class="input-xlarge focused" id="titulo'.$cont.'" name="titulo" ></textarea>
								  
								</div>
							  </div>
                              </div>
							
							 
							 <legend>Objetivos estrat&eacute;gicos:</legend>
							 
							<div class="well">'; 
			
			
			
			  $script .='
			arrayobjetivos[0][0] = "1";
			 ';	
	        
			$panelcontent .='<div id="L'.$cont.'-controlobjetivo1" class="control-group">
							<div class="controls">
<div class="input-prepend">
<span id="textobjetivo" class="add-on">1</span>


<textarea style="width:700px;" name="L'.$cont.'-objetivo" id="L'.$cont.'-objetivo1" ></textarea>

</div>
                                
							</div>
							</div>
							
							<div class="controls">
                            
                               
           <button style="float:left; margin-right:10px;" onclick="EliminarObjetivo(this.id);" id="OL'.$cont.'" disabled="disabled" class="btn btn-small"><i class="icon-remove"></i> Eliminar Objetivo</button>
                                        
                                        
                             <a class="btn btn-small" onclick="agregarObjetivo(this.id);" id="L'.$cont.'" href="javascript:void(0)"><i class="icon-plus"></i> Agregar Objetivo</a>
                            </div>
                            </div>
                             
                    
                             </div> ';
			
			
			}
			
			
		  $script .='</script>';
		  
		  $panelcontent .= '<div class="right">
                               
 
  <button class="btn btn-large" '.$disabledlinea.' id="btndeleteline" onclick="EliminarLinea();" style="float:left; margin-right:10px;"><i class="icon-remove"></i> Eliminar Linea</button>
                               
<a href="javascript:void(0)" onclick="agregarLinea();" class="btn btn-large"><i class="icon-plus"></i> Agregar Linea</a>
                          
                          </div>';
						  
		  $section .= $panelcontent;
		  $section .= $script;
			
			
			return $section;
		 }//end function
	  

     
       function GuardarLinea(){
			 
			$lineas = explode("^",$_POST['lineas']);
			$objetivos = explode("^", $_POST['objetivos']);
			  
		
		    $this->Model->lineas =  $lineas;
			$this->Model->objetivos = $objetivos;
			$this->Model->idplan = $_POST['IdPlan'];
			
			$this->Model->GuardarLinea();
				 
	
          }
		  
		  
	function isActivo(){
		
		
	if($this->Model->isActivo($_POST['IdPlan'])){
		echo 'TRUE';
	}	
		
	
	}


}

?>