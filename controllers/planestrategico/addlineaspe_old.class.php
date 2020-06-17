<?php
include "models/planestrategico/addlineaspe.model.php";
include "libs/resizeimage/class.upload.php";


class addlineaspe {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $image;
	var $targetPathumbail;
	

	function addlineaspe() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("option");
	 $this->Model = new addlineaspeModel();
		
	 switch($_GET['method']){
	 	
		case "GuardarLinea":
			$this->GuardarLinea();
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
	 	
		$contenido = $this->View->Template(TEMPLATE.'modules/planestrategico/ADDLINEAS.TPL');
		
		$plan =  $this->Model->getPlanEstrategico($_GET['IdPlan']);
		$contenido =  $this->View->replace('/\#TITULOPLAN\#/ms' ,htmlentities($plan['TITULO']),$contenido);	
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 }
	 
	 
	 
	 
	 
    function GuardarLinea(){
			 
			 $lineas = explode("^",$_POST['lineas']);
			 $objetivos = explode("^", $_POST['objetivos']);
			 
		
		    $this->Model->lineas =  $lineas;
			$this->Model->objetivos = $objetivos;
			$this->Model->idplan = $_POST['IdPlan'];
			
			$this->Model->GuardarLinea();
				 
	
          }
		  
		  
	

	
}

?>