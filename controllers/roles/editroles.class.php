<?php
include "models/roles/editroles.model.php";


class editroles{

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	

	function editroles() {
	 $this->menu = new Menu();
	 $this->View = new View();
	 $this->Model = new editrolesModel();
	 
	 
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
	 	$row = $this->Model->ObtenerRol($_GET['Rol']);
		$contenido = $this->View->Template(TEMPLATE.'modules/roles/EDTROLES.TPL');
		
		$contenido = $this->View->replace('/\#IDROL\#/ms' ,$row['PK1'],$contenido);
		$contenido = $this->View->replace('/\#NOMBRE\#/ms' ,htmlentities($row['ROLE'], ENT_QUOTES, "ISO-8859-1"),$contenido);
		
		/*tipo*/
	    if(trim($row['TIPO'])=="P"){
		$contenido =  $this->View->replace('/\#NODISPONIBLE\#/ms' ,'checked="checked"',$contenido);
		}else{
		$contenido =  $this->View->replace('/\#DISPONIBLE\#/ms' ,'checked="checked"',$contenido);
		}
		
		
		$contenido = $this->View->replace('/\#DESCRIPCION\#/ms' ,htmlentities($row['DESCRIPCION'], ENT_QUOTES, "ISO-8859-1"),$contenido);
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		
		 }
	 
	  
	 
	
}

?>