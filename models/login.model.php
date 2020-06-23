<?php

class loginModel {
	
	var $articulos;
	var $tutoriales;
	var $links;

	
	
	function __construct() {
		
	}

    function getArticulos(){
		
		$this->articulos = array();
        $sql = "SELECT * FROM ARTICULOS ORDER BY FECHA_R DESC";
       
		$objdb = new database();
		//$result = $objdb->executeQuery($sql);
	
	  //  while ($row = mysql_fetch_array($result)) {
	  foreach(database::getRows($sql) as $row){ 
		
	   $this->articulos[] = $row;
		
        }

     	}
		
		
		function getArticulo($id){
		
		 $sql = "SELECT * FROM ARTICULOS WHERE PK1='$id'";   
		$objdb = new database();
	    $row = $objdb->getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}
		
		
		
		 function getTutoriales(){
		
		$this->tutoriales = array();
        $sql = "SELECT * FROM TUTORIALES";
       
		$objdb = new database();
		//$result = $objdb->executeQuery($sql);
	
	   // while ($row = mysql_fetch_array($result)) {
	   foreach(database::getRows($sql) as $row){ 
		
	   $this->tutoriales[] = $row;
		
        }

     	}
		
		
		function getTutorial($id){
		
		 $sql = "SELECT * FROM TUTORIALES WHERE PK1='$id'";   
		$objdb = new database();
	    $row = $objdb->getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}
		
	
	 function getLinks(){
		
		$this->links = array();
        $sql = "SELECT * FROM LINKS";
       
		$objdb = new database();
		//$result = $objdb->executeQuery($sql);
	
	   // while ($row = mysql_fetch_array($result)) {
	   foreach(database::getRows($sql) as $row){ 
		
	   $this->links[] = $row;
		
        }

     	}
		
		

	
}

?>