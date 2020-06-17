<?php
include "models/planestrategico/editplane.model.php";
include "libs/resizeimage/class.upload.php";


class editplane {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $image;
	var $targetPathumbail;
	

	function editplane() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("option");
	 $this->Model = new editplaneModel();
		
	 switch($_GET['method']){
	 	
		case "Actualizar":
			$this->Actualizar();
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
	 	
		
		$section = TEMPLATE.'modules/planestrategico/EDTPLAN.TPL';
	    $section = $this->View->loadSection($section);
		
	
		
		$row = $this->Model->getPlan($_GET['IDPlan']);
		$section = $this->View->replace('/\#IDPLAN\#/ms' ,$_GET['IDPlan'],$section);
	    $urlmenu = '?execute=planestrategico/editplanelineas&method=default&Menu=F1&SubMenu=SF11&IDPlan='.$row['PK1'];
	    $section = $this->View->replace('/\#MENUURL\#/ms' ,$urlmenu,$section);
		
		/*DISPONIBILIDAD*/
	    if($row['DISPONIBLE']==0){
		$section =  $this->View->replace('/\#NODISPONIBLE\#/ms' ,'checked="checked"',$section);
		}else{
		$section =  $this->View->replace('/\#DISPONIBLE\#/ms' ,'checked="checked"',$section);
		}
		
		
		$section = $this->View->replace('/\#TITULO\#/ms' ,htmlentities($row['TITULO'], ENT_QUOTES, "ISO-8859-1"),$section);
		$section = $this->View->replace('/\#DESCRIPCION\#/ms',htmlentities($row['DESCRIPCION'], ENT_QUOTES, "ISO-8859-1"),$section);
		$section = $this->View->replace('/\#FECHA_I\#/ms' ,$row['FECHA_I']->format('Y-m-d'),$section);
		$section = $this->View->replace('/\#FECHA_T\#/ms' ,$row['FECHA_T']->format('Y-m-d'),$section);
		
		
		$section =  $this->View->replace('/\#NODOS\#/ms' ,$this->nodos->nodos,$section);	
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$section);
		 }
	 

         function Actualizar(){
		
		     $this->Model->idplan = $_POST['idplan'];
			$this->Model->titulo = $_POST['titulo'];
			$this->Model->descripcion = $_POST['descripcion'];
			$this->Model->disponible = $_POST['disponible'];
			$this->Model->fechai = $_POST['finicio'];
			$this->Model->fechat = $_POST['ftermino'];
			$this->Model->jerarquia = $_POST['jerarquia'];
			
			
			$this->Model->ActualizarPlan();
			
		
		 
	
          }
		  
		 	
	

	
}

?>