<?php

class previewplanModel {
	

	var $idplan;
	
	function __construct() {
		
	}
     
	 
	 
    function getPlan($id){
		
		$sql = "SELECT * FROM PL_PESTRATEGICOS WHERE PK1 = '$id' ";   
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}



    function getLineas(){
		
	 
		$html = "";
		$id = $_GET['IDPlan'];
		$sql = "SELECT * FROM PL_PESTRATEGICOS_LINEASE WHERE PK_PESTRATEGICO = '$id' ORDER BY ORDEN";
		
		
     /*   $result = database::executeQuery($sql);
		
		
		$i=1;
	  while($row = mssql_fetch_array($result, MSSQL_ASSOC)){
		  
		  
		       $html .= '<fieldset>
							<legend>'.$i.'.   '.htmlentities($row['LINEA'], ENT_QUOTES, "ISO-8859-1").'</legend>';
				
					 
					 $html .= $this->getObjetivos($row['PK1']);
				
							  
				 $html .= '</fieldset>';
			   $i++;
			   
			   
		  }	*/
		  
		  
		  
		   $rows = database::getRows($sql);
	       $i=1;
	         foreach($rows as $row){		
	            $html .= '<fieldset>
							<legend>'.$i.'.   '.htmlentities($row['LINEA'], ENT_QUOTES, "ISO-8859-1").'</legend>';
				
					 
					 $html .= $this->getObjetivos($row['PK1']);
				
							  
				 $html .= '</fieldset>';
			   $i++;
		
        }	
		
		
		return $html;
		}
	
	
	  function getObjetivos($idlinea){
	  	$html = "";
		$sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$idlinea'  ORDER BY ORDEN";
		  
		
       /* $result = database::executeQuery($sql);
		  $i=1;
		    while($row = mssql_fetch_array($result, MSSQL_ASSOC)){
		  
		   $html .= '	<div class="controls">'.$i.'.  '.htmlentities($row['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</div>';
			$i++;
			}*/
			
			 $rows = database::getRows($sql);
	        $i=1;
	        foreach($rows as $row){		
	            $html .= '	<div class="controls">'.$i.'.  '.htmlentities($row['OBJETIVO'], ENT_QUOTES, "ISO-8859-1").'</div>';
			    $i++;		
            }	
			
			
			
			 
			 return $html;
			 }
	
}

?>