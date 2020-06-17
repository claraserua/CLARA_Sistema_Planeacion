<?php
include "models/planesoperativo/addplano.model.php";
include "libs/resizeimage/class.upload.php";


class addplano {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $image;
	var $targetPathumbail;
	var $nodoprincipal;
	

	function addplano() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->Model = new addplanoModel();
	 $this->nodoprincipal = new Niveles("option");
		
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
		
		if($this->passport->privilegios->hasPrivilege('P25')){
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
	 	
		
		$contenido = $this->View->Template(TEMPLATE.'modules/planesoperativo/ADDPLAN.TPL');
		
		$idplan =  strtoupper(substr(uniqid('PO'), 0, 15));
		$contenido =  $this->View->replace('/\#IDPLAN\#/ms' ,$idplan,$contenido);	
		
		$contenido =  $this->View->replace('/\#IDPlanEstrategico\#/ms' ,$_GET['IDPlanEstrategico'],$contenido);	
		
		$row = $this->getPlanE();
		$contenido = $this->View->replace('/\#PLANESTRATEGICO\#/ms' ,htmlentities($row['TITULO'], ENT_QUOTES, "ISO-8859-1"),$contenido);
			
		$contenido =  $this->View->replace('/\#NODOSPRINCIPAL\#/ms' ,$this->nodoprincipal->nodos,$contenido);
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 }
	 

         function GuardarPlan(){
		
		    $this->Model->idplan = $_POST['idplan'];
			$this->Model->titulo = $_POST['titulo'];
			$this->Model->descripcion = $_POST['descripcion'];
			$this->Model->disponible = $_POST['disponible'];
			$this->Model->fechai = $_POST['finicio'];
			$this->Model->fechat = $_POST['ftermino'];
			$this->Model->plane = $_POST['IDPlanEstrategico'];
			$this->Model->jerarquia = $_POST['jerarquia'];
			
			
			$this->Model->seguimiento = explode("|",$_POST['seguimiento']);
			
		
			
			
			$this->Model->GuardarPlan();
			
		
		 
	
          }
		  
		  
		
	
		function getPlanE(){
	
	$row = $this->Model->getPlanE($_GET['IDPlanEstrategico']);
	
	return $row;
			
	}
	
	  
	  
	
	
	
	

	
}

?>