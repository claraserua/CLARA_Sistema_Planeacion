<?php
include "models/planestrategico/exportexcel.model.php";
require('libs/fpdf/fpdf.php');


class exportexcel{

    var $View;
	var $Model;
	
	

	function exportexcel() {
		
	 $this->Model = new exportexcelModel(); 
	 $this->View = new View();
     $this->loadPage();
	 $this->loadContent();		
						 
	}
	
	
	
	 function loadPage(){
	 $namefile = $_GET['IDPlan'].'.xls';
	 header('Content-type: application/vnd.ms-excel');
	 header("Content-Disposition: attachment; filename=".$namefile."");
     header("Pragma: no-cache");
     header("Expires: 0");
			
	 }
	 
	 
	 
	
	
	
  
	 function loadContent(){
	   	
	  
	   $this->View->template = TEMPLATE.'excel.tpl';
	   $this->View->loadTemplate();	
	  
	  
	  
	   $section = "<table>";
	   $section .= $this->getPlan();
	   $section .= $this->getLineas();
	   $section .= "</table>";
	   
	   
	   $this->View->replace_content('/\#CONTENT\#/ms' ,$section);
	
	   $this->View->viewPage();
		
	  /* $row = $this->getPlan();
	   $section = $this->View->replace('/\#TITULO\#/ms' ,htmlentities($row[1]),$section);
	   
	   $html = $this->getLineas();
	   $section = $this->View->replace('/\#LINEAS\#/ms' ,$html,$section);
	   
	   $urlmenu = '?execute=planestrategico/adjuntos&Menu=F1&SubMenu=SF4&IDPlan='.$row[0].'#&p=1&s=25&sort=1&q=';
	   
	   $section = $this->View->replace('/\#MENUURL\#/ms' ,$urlmenu,$section);
	   
	
		$this->View->replace_content('/\#CONTENT\#/ms' ,$section);
		
		*/ 
		 }
	 
	  
	
	   function getLineas(){
		   
		   
		   return $this->Model->getLineas();
		   
		   
		   }
	
	  
	  
	function getPlan(){
	
	$row = $this->Model->getPlan($_GET['IDPlan']);
		

	$titulo = '<tr><td style="color:#FFFFFF; font-size:16px; padding:10px; height:30px;" bgcolor="#7C4300" ><strong>'.htmlentities($row['TITULO'], ENT_QUOTES, "ISO-8859-1").'</strong></td></tr>';

	
	return $titulo;	
	}
	  
	  
	  
	 
	
}

?>