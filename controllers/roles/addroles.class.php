<?php
include "models/roles/addroles.model.php";


class addroles {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	

	function addroles() {
	 $this->menu = new Menu();
	 $this->View = new View();
	 $this->Model = new addrolesModel();
	 
	 
	  switch($_GET['method']){
	 	
			
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
		$this->loadContent();
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
	 

  
	 function loadContent(){
	 
		$contenido = $this->View->Template(TEMPLATE.'modules/roles/ADDROLES.TPL');
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		
		 }
	 
	  
	  
	
}

?>