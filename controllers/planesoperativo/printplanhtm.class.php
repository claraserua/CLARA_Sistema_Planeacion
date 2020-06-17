<?php
include "models/planesoperativo/printplanhtm.model.php";


class printplanhtm {

    var $View;
	var $Model;
		

	function printplanhtm() {
		
	 $this->Model = new printplanhtmModel(); 
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
 
$html .= $this->Model->getLineas();

echo $html;
		
	 }
	 
	 
	  
	  
	function getPlan(){
	
	$row = $this->Model->getPlan($_GET['IDPlan']);
	
	return $row['TITULO'];
			
	}
	  
	
}





?>