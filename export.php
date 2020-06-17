<?php
//header("Content-Type: text/html; charset=UTF-8");



require_once 'Spreadsheet/Excel/Writer.php';


 error_reporting(E_ALL);
 ini_set("display_errors", 1);
 ini_set('memory_limit', '-1');
 
 
 $excel = new exportexcelfast();
 

class exportexcelfast{

    
	var $Model;
	

	function exportexcelfast() {
		
	 //$this->Model = new exportexcelModel(); 
	 
     $this->loadPage();
	// $this->loadContent();		
						 
	}
	
	

	function loadPage(){
	
    $workbook = new Spreadsheet_Excel_Writer();
    
    $workbook->setVersion(8);
    $workbook->send('test.xls');
    
    
    // Creating a worksheet
$worksheet = $workbook->addWorksheet('Plan Operativo');


    
    $celda=1;
    $contlinea = 1;
    
    for($i=1;$i<10;$i++){
    	
   
		        $worksheet->writeString($celda, 2, 'Línea estratégica '.$contlinea.'Colocación pruebaAAAA');
		
		        //echo $celda.' |  (1) </br>';
		        
		        $celda++;
		     //   $worksheet->writeString($celda,2,'Resultado');
			//	$worksheet->writeString($celda,4,'Objetivo estrategico');	
			  //  $worksheet->writeString($celda,6,'otra columna');					
				 //$worksheet->write($celda,6,'Responsable');
			//$worksheet->setMerge($celda,1,$celda,6); 
    	
			
			 for($y=1;$y<5;$y++){
    	
    	
    	       $celda++;
    	       $worksheet->writeString($celda,2,'otro resultado');	
    	       $worksheet->write($celda,4,'otro obj estrategico');		
    	        $worksheet->write($celda,6,'otra columna ejemplo');	
    	         $worksheet->write($celda,7,'otra columna ejemplo');	
    	      
    	       
    	       	//echo $celda.' |  (2) </br>';
    	       
				
				//	 $celda+=2;
			  // $worksheet->writeString($celda,4,'Objetivo estrategico');	
				//	  $celda+=2;				
			//	$worksheet->write($celda,6,'Responsable');
			
			//$worksheet->writeString($celda,6,'as');	
	              
			//$celda+=2;
			
			
		
	           }
			
			
			$contlinea++;
			$celda+=2;
		
	}





// Let's send the file
$workbook->close();


	 }
	 
	 

	
	  
	
}

?>