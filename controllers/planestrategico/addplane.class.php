<?php
include "models/planestrategico/addplane.model.php";
include "libs/resizeimage/class.upload.php";


class addplane {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $image;
	var $targetPathumbail;
	

	function addplane() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("option");
	 $this->Model = new addplaneModel();
		
	 switch($_GET['method']){
	 	
		case "GuardarPlan":
			$this->GuardarPlan();
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
		
		
	
	
		if($this->passport->privilegios->hasPrivilege('P20')){
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
	 	
		
		$contenido = $this->View->Template(TEMPLATE.'modules/planestrategico/ADDPLAN.TPL');
		
		$idplan =  strtoupper(substr(uniqid('PE'), 0, 15));
		$contenido =  $this->View->replace('/\#IDPLAN\#/ms' ,$idplan,$contenido);	
		
		$contenido =  $this->View->replace('/\#NODOS\#/ms' ,$this->nodos->nodos,$contenido);	
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
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
		  
		  
		
	
	
	
	  
	  
	
	
	
	

	
}

?>