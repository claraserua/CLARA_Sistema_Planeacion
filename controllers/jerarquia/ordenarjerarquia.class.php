<?php
include "models/jerarquia/ordenarjerarquia.model.php";



class ordenarjerarquia {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $image;
	var $targetPathumbail;
	

	function ordenarjerarquia() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("option");
	 $this->Model = new ordenarjerarquiaModel();
		
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
	 	$row = $this->Model->ObtenerJerarquia($_GET['Padre']);
		$niveles = $this->ObtenerJerarquias($_GET['Padre']);
		
		
		$contenido = $this->View->Template(TEMPLATE.'modules/jerarquia/ORDENARJERARQUIA.TPL');
		$urlbtncancelar = "?execute=jerarquia&method=default&Menu=F3&SubMenu=SF34&Nivel=".$_GET['Padre']."#&p=1&s=25&sort=1&q=";
		$urlformaction = "?execute=jerarquia&method=Ordenar&Menu=F3&SubMenu=SF34&Nivel=".$_GET['Padre']."#&p=1&s=25&sort=1&q=";
		
		$contenido = $this->View->replace('/\#NOMBRENIVEL\#/ms' ,htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1"),$contenido);
		$contenido = $this->View->replace('/\#NIVELES\#/ms' ,$niveles,$contenido);
		
		$contenido = $this->View->replace('/\#URLCANCELAR\#/ms' ,$urlbtncancelar,$contenido);
		$contenido = $this->View->replace('/\#PADRE\#/ms' ,$_GET['Padre'],$contenido);
		$contenido = $this->View->replace('/\#URLFORMACTION\#/ms' ,$urlformaction,$contenido);
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 
		 }
	 
       
	   
	   function ObtenerJerarquias($id){
	   	
		
		$this->Model->ObtenerJerarquias($_GET['Padre']);
		
		$numrecursos = sizeof($this->Model->niveles);
		
		
		$recurso = "";
		if($numrecursos != 0){
		
		foreach($this->Model->niveles as $row){
			
			$recurso .= "<option value=\"".$row['PK1']."\">".htmlentities($row['NOMBRE'])."</option> ";
		
		   }	
			
		}
		
		
		return $recurso;	
	    }
	
}

?>