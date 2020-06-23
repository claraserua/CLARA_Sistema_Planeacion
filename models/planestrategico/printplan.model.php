<?php

class printplanModel {
	

	var $idplan;
	
	function __construct() {
		
	}
     
	 
    function getPlan($id){
		
		$sql = "SELECT * FROM PL_PESTRATEGICOS WHERE PK1 = '$id'";   
		$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		}



    function getLineas(){
		
	
		 if(isset($_GET['IDPlan'])){
			$plan = $this->getPlan($_GET['IDPlan']);
		}else{
            $planes =  explode("/",$_GET['execute']);
			$plan = $planes[1];		
			$plan = $this->getPlan($plan);
		}
		 
		
		$html = "<div align=\"center\"><h2>".htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1")."</h2></div><br/>";
	    
		$html .="<table>";
		
		
		if(isset($_GET['IDPlan'])){
			$id = $_GET['IDPlan'];
		}else{
            $planes =  explode("/",$_GET['execute']);
			$id = $planes[1];		
		}
		
		
		
		$sql = "SELECT * FROM PL_PESTRATEGICOS_LINEASE WHERE PK_PESTRATEGICO = '$id' ORDER BY ORDEN";
		
       // $result = database::executeQuery($sql);
		
		
		$i=1;
		$rows = database::getRows($sql);
		
		
	 // while($row = mssql_fetch_array($result, MSSQL_ASSOC)){
		  
		    foreach($rows as $row){
		  
		  
		       $html .= '
			   
			   <tr><td bgcolor="#F8991D" style="color:#7C430B;"><strong>Linea Estrategica:</strong></td></tr>
			   <tr>
							<td class="title"><strong>'.$i.'.   '.htmlentities($row['LINEA'], ENT_QUOTES, "ISO-8859-1").'</strong></td></tr>';
					
					 $html .= '<tr><td><br /></td></tr>';	  
							  
				  $html .= '<tr><td bgcolor="#F8991D" style="color:#7C430B;"><strong>Objetivos Estrategicos:</strong></td></tr>';
				     
					  
				      $html .= $this->getObjetivos($row['PK1']);
				 $html .= '<tr><td><br /></td></tr>';	
			   $i++;
			   
			 }  
			   
			   
		//  }
		  
		  
		  
		  $html .="</table>";	
		
		
		return $html;
		}
	
	
	
	
	  function getObjetivos($idlinea){
		$html = "";
		$sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$idlinea'  ORDER BY ORDEN";
		  
	
       /* $result = database::executeQuery($sql);
		  $i=1;
		    while($row = mssql_fetch_array($result, MSSQL_ASSOC)){
		  
		   $html .= '	<tr><td>'.$i.'.  '.htmlentities($row["OBJETIVO"], ENT_QUOTES, "ISO-8859-1").'</td></tr>';
			$i++;
			} */
			 $i=1;
			  $rows = database::getRows($sql);
			   foreach($rows as $row){			   
			   
			    $html .= '	<tr><td>'.$i.'.  '.htmlentities($row["OBJETIVO"], ENT_QUOTES, "ISO-8859-1").'</td></tr>';
			    $i++;
			   
			   }
			
			
			
			 return $html;
			}
}

?>