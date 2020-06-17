<?php
include "models/planestrategico/previewplan.model.php";


class previewplan {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	


	function previewplan() {
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("filtro");
	 $this->View = new View();
	 $this->Model = new previewplanModel();
	 
     $this->loadPage();		
						 
	}
	
	
	
	 function loadPage(){
	
		$this->View->template = TEMPLATE.'PRINCIPAL.TPL';	
		$this->View->loadTemplate();
		$this->loadHeader();
		$this->loadNodos();
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
	 
	
	function loadNodos(){
	
	$nodos =  $this->nodos->nodos;	 
	$this->View->replace_content('/\#NODOS\#/ms' ,$nodos);
	 
	 
	 }
	
  
	 function loadContent(){
	   //$contenido = $this->View->Template(TEMPLATE.'modules/previewPlane.tpl');
		
	   $section = TEMPLATE.'modules/planestrategico/PREVIEW.TPL';
	   $section = $this->View->loadSection($section);
		
	   $row = $this->getPlan();
	   $section = $this->View->replace('/\#TITULO\#/ms' ,htmlentities($row['TITULO'], ENT_QUOTES, "ISO-8859-1"),$section);
	   
	   $html = $this->getLineas();
	   $section = $this->View->replace('/\#LINEAS\#/ms' ,$html,$section);
	  
	  
	   $compartir = "<button class=\"btn btn-large\" onclick=\"javascript:ImprimirPlan('".$_GET['IDPlan']."');return false;\"><i class=\"icon-envelope\"></i> Compartir</button>";
	   $section = $this->View->replace('/\#COMPARTIR\#/ms' ,$compartir,$section);
	  
	   
	   
	   $imprimir = "<button class=\"btn btn-large\" onclick=\"javascript:ImprimirPlan('".$_GET['IDPlan']."');return false;\"><i class=\"icon-print\"></i> Imprimir</button>";
	   $section = $this->View->replace('/\#IMPRIMIR\#/ms' ,$imprimir,$section);
	   
	   
	   $exportar = "<a href=\"?execute=planestrategico/exportexcel&IDPlan=".$_GET['IDPlan']."\" class=\"btn btn-large\"><i class=\"icon-download-alt\"></i> Exportar </a>";
	   
	   $section = $this->View->replace('/\#EXPORTAR\#/ms' ,$exportar,$section);
	   
	   
	   $urlmenu = '?execute=planestrategico/adjuntos&method=default&Menu=F1&SubMenu=SF11&IDPlan='.$row['PK1'].'#&p=1&s=25&sort=1&q=';
	   
	   $section = $this->View->replace('/\#MENUURL\#/ms' ,$urlmenu,$section);
	   
	   $this->View->replace_content('/\#CONTENT\#/ms' ,$section);
		 
		 }
	 
	  
	
	   function getLineas(){
		   
		 
		   if($this->Model->getLineas()!=""){
		     
			 	return $this->Model->getLineas();
		   
		   }else{
		    
			    return '<div class="empty_results" style="padding:60px;">NO EXISTEN AUN LINEAS REGISTRADAS<br><small>Edite el plan estratégico para ingresar lineas</small></div>';	
		   }
		   
		   
		   }
	
	  
	  
	function getPlan(){
	
	$row = $this->Model->getPlan($_GET['IDPlan']);
	
	return $row;
			
	}
	  
	  
	  
	 
	
}

?>