<?php
include "models/planesoperativo/printplanhtmcomentarios.model.php";


class printplanhtmcomentarios {

    var $View;
	var $Model;
		

	function printplanhtmcomentarios() {
		
	 $this->Model = new printplanhtmcomentariosModel(); 
      $this->loadPage();		
						 
	}
	
	
	 function loadPage(){

$html = '
<!-- EXAMPLE OF CSS STYLE -->
<style>  
  body{
  	font-family: Tahoma;
  	font-size:8px;
  }


	td{
	border:0px;
	}
	
	td.title{
	background:#E5E5E5;
	padding:10px;
	}
   
</style> <br />';
 
       
	   
	   $html .= $this->Model->getComentarios();

echo $html;
		
	 }
	 
	 
	  
	  
	function getPlan(){
	
	$row = $this->Model->getPlan($_GET['IDPlan']);
	
	return $row['TITULO'];
			
	}
	  
	
}





?>