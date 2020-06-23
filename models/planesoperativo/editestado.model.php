<?php

class editestadoModel {
	

	
	var $idplan;
	var $estado;
	var $idPeriodo;
	var $contador;

	var $campos;
	
	
	function __construct() {
		
	}

    function GuardarPlan(){
    	
    	
    	if($this->estado == 'S' && $this->idPeriodo != "" && $this->contador != 0){
			
			$this->getPeriodos($this->idplan);
			$numperiodos = sizeof($this->periodos); 
			
			 if($this->contador == 1 ){
			 	
			 
			    	
			    	foreach($this->periodos as $rowperiodos){
			 	 	
			 	 	
	                      $this->campos = array('ENVIADO'=>'0',
						                        'FECHA_M'=>date("Y-m-d H:i:s"),
							                    'PK_USUARIO'=>$_SESSION['session']['user'],
						                       );
		
		                  $condition = "PK1='".$rowperiodos['PK1']."'";
		 
		                  database::updateRecords("PL_POPERATIVOS_PERIODOS",$this->campos,$condition);			 	 	
			 	 	
			 	 	
			 	 	
			 	    }
			 	
			 	
			 }else if($this->contador >1 && $this->contador < $numperiodos){
			 	
			 
			 	 //se asigna 3(terminado) a todos antes del periodo seleccionado
			    	for($i=($this->contador)-1;$i>=0;$i--){
			 		
			 			 		
                       			 		
			 		     $rowperiodo = $this->getPeriodOrden($this->idplan, $i);
			 		
			 		
			 		     $this->campos = array('ENVIADO'=>'3',
						                        'FECHA_M'=>date("Y-m-d H:i:s"),
							                    'PK_USUARIO'=>$_SESSION['session']['user'],
						                       );
		
		                  $condition = "PK1='".$rowperiodo['PK1']."'";
		 
		                  database::updateRecords("PL_POPERATIVOS_PERIODOS",$this->campos,$condition);			 	 	
			 	 	
			 		
			 		
			 	   }
			 	   
			 	   
			 	   //se asigna 0 a todos despues del periodo seleccionado
			    	for($i=($this->contador)+1;$i<=$numperiodos;$i++){
			 		
			 			 		
                       			 		
			 		     $rowperiodo = $this->getPeriodOrden($this->idplan, $i);
			 		
			 		
			 		     $this->campos = array('ENVIADO'=>'0',
						                        'FECHA_M'=>date("Y-m-d H:i:s"),
							                    'PK_USUARIO'=>$_SESSION['session']['user'],
						                       );
		
		                  $condition = "PK1='".$rowperiodo['PK1']."'";
		 
		                  database::updateRecords("PL_POPERATIVOS_PERIODOS",$this->campos,$condition);			 	 	
			 	 	
			 		
			 		
			 	   } 	   
			 	   
			 	   
			 	   //periodo seleccionado pasa a elaborando
			 	       $this->campos = array('ENVIADO'=>'2',
							                 'FECHA_M'=>date("Y-m-d H:i:s"),
							                 'PK_USUARIO'=>$_SESSION['session']['user'],
							                );
		
		                $condition = "PK1='".$this->idPeriodo."'";
		 
		                database::updateRecords("PL_POPERATIVOS_PERIODOS",$this->campos,$condition);
			 	   
			 	   
			 	   			 	   
			 	
			 	
			 }else {		
			 	 
			 	  
			 	   
			 	   //se asigna 3 a todos antes del periodo seleccionado
			    	for($i=($this->contador)-1;$i>=0;$i--){
			 		
			 			 		
                       			 		
			 		     $rowperiodo = $this->getPeriodOrden($this->idplan, $i);
			 		
			 		
			 		     $this->campos = array('ENVIADO'=>'3',
						                        'FECHA_M'=>date("Y-m-d H:i:s"),
							                    'PK_USUARIO'=>$_SESSION['session']['user'],
						                       );
		
		                  $condition = "PK1='".$rowperiodo['PK1']."'";
		 
		                  database::updateRecords("PL_POPERATIVOS_PERIODOS",$this->campos,$condition);			 	 	
			 	 	
			 		
			 		
			 	   } 	   
			 	   
			 	   
			 	   //periodo seleccionado pasa a elaborando
			 	       $this->campos = array('ENVIADO'=>'2',
							                 'FECHA_M'=>date("Y-m-d H:i:s"),
							                 'PK_USUARIO'=>$_SESSION['session']['user'],
							                );
		
		                $condition = "PK1='".$this->idPeriodo."'";
		 
		                database::updateRecords("PL_POPERATIVOS_PERIODOS",$this->campos,$condition);
			 	   
			 	   
			 	   			 	   
			 	
			 	
			 }
			
			
			
		                  $this->campos = array('ESTADO'=>'S',
							                    'FECHA_M'=>date("Y-m-d H:i:s"),
							                    'PK_USUARIO'=>$_SESSION['session']['user'],
							                    );
		
		                  $condition = "PK1='".$this->idplan."'";
		 
		                  database::updateRecords("PL_POPERATIVOS",$this->campos,$condition);
		
		
		
			
			
			
		}else if($this->estado == 'I' && $this->idPeriodo != "" && $this->contador != 0){
			
			
			
			$this->getPeriodos($this->idplan);
			$numperiodos = sizeof($this->periodos); 
			//echo 'entros';
			 if($this->contador == 1 ){
			 	
			 //	echo 'entro1';
			 
			   
		
		
		           $this->campos = array('ENVIADO'=>'1',
							 'FECHA_M'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
		
		            $condition = "PK1='".$this->idPeriodo."'";
		 
		            database::updateRecords("PL_POPERATIVOS_PERIODOS",$this->campos,$condition);
			 	   
			    	
			    	//se asigna 0 a todos despues del periodo seleccionado y 1 al 1er periodo
			    	for($i=2;$i<=$numperiodos;$i++){
			 		
			 			 		
                       			 		
			 		     $rowperiodo = $this->getPeriodOrden($this->idplan, $i);
			 		
			 		
			 		     $this->campos = array('ENVIADO'=>'0',
						                        'FECHA_M'=>date("Y-m-d H:i:s"),
							                    'PK_USUARIO'=>$_SESSION['session']['user'],
						                       );
		
		                  $condition = "PK1='".$rowperiodo['PK1']."'";
		 
		                  database::updateRecords("PL_POPERATIVOS_PERIODOS",$this->campos,$condition);			 	 	
			 	 	
			 		
			 		
			 	   } 	   
			 	   
			 	   
			 	  
			 	
			 	
			 }else if($this->contador >1 && $this->contador < $numperiodos){
			 	
			 
			 
			 	 //se asigna 3(terminado) a todos antes del periodo seleccionado
			    	for($i=($this->contador)-1;$i>=0;$i--){
			 		
			 			 		
                       			 		
			 		     $rowperiodo = $this->getPeriodOrden($this->idplan, $i);
			 		
			 		
			 		     $this->campos = array('ENVIADO'=>'3',
						                        'FECHA_M'=>date("Y-m-d H:i:s"),
							                    'PK_USUARIO'=>$_SESSION['session']['user'],
						                       );
		
		                  $condition = "PK1='".$rowperiodo['PK1']."'";
		 
		                  database::updateRecords("PL_POPERATIVOS_PERIODOS",$this->campos,$condition);			 	 	
			 	 	
			 		
			 		
			 	   }
			 	   
			 	   
			 	   //se asigna 0 a todos despues del periodo seleccionado
			    	for($i=($this->contador)+1;$i<=$numperiodos;$i++){
			 		
			 			 		
                       			 		
			 		     $rowperiodo = $this->getPeriodOrden($this->idplan, $i);
			 		
			 		
			 		     $this->campos = array('ENVIADO'=>'0',
						                        'FECHA_M'=>date("Y-m-d H:i:s"),
							                    'PK_USUARIO'=>$_SESSION['session']['user'],
						                       );
		
		                  $condition = "PK1='".$rowperiodo['PK1']."'";
		 
		                  database::updateRecords("PL_POPERATIVOS_PERIODOS",$this->campos,$condition);			 	 	
			 	 	
			 		
			 		
			 	   } 	   
			 	   
			 	   
			 	   //periodo seleccionado pasa a elaborando
			 	       $this->campos = array('ENVIADO'=>'1',
							                 'FECHA_M'=>date("Y-m-d H:i:s"),
							                 'PK_USUARIO'=>$_SESSION['session']['user'],
							                );
		
		                $condition = "PK1='".$this->idPeriodo."'";
		 
		                database::updateRecords("PL_POPERATIVOS_PERIODOS",$this->campos,$condition);
			 	   
			 	   
			 	   			 	   
			 	
			 	
			 }else {		
			 	 
			 	  
			 	   
			 	   //se asigna 3 a todos antes del periodo seleccionado
			    	for($i=($this->contador)-1;$i>=0;$i--){
			 		
			 			 		
                       			 		
			 		     $rowperiodo = $this->getPeriodOrden($this->idplan, $i);
			 		
			 		
			 		     $this->campos = array('ENVIADO'=>'3',
						                        'FECHA_M'=>date("Y-m-d H:i:s"),
							                    'PK_USUARIO'=>$_SESSION['session']['user'],
						                       );
		
		                  $condition = "PK1='".$rowperiodo['PK1']."'";
		 
		                  database::updateRecords("PL_POPERATIVOS_PERIODOS",$this->campos,$condition);			 	 	
			 	 	
			 		
			 		
			 	   } 	   
			 	   
			 	   
			 	   //periodo seleccionado pasa a revision
			 	       $this->campos = array('ENVIADO'=>'1',
							                 'FECHA_M'=>date("Y-m-d H:i:s"),
							                 'PK_USUARIO'=>$_SESSION['session']['user'],
							                );
		
		                $condition = "PK1='".$this->idPeriodo."'";
		 
		                database::updateRecords("PL_POPERATIVOS_PERIODOS",$this->campos,$condition);
			 	   
			 	   
			 	   			 	   
			 	
			 	
			 }
			
			
			
			             $this->campos = array('ESTADO'=>'I',
							                   'FECHA_M'=>date("Y-m-d H:i:s"),
						                       'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
		
		                    $condition = "PK1='".$this->idplan."'";
		 
		                   database::updateRecords("PL_POPERATIVOS",$this->campos,$condition);
			
			
		}else{
			
			
			
			if($this->estado == 'T'){
								
			$this->getPeriodos($this->idplan);
			$numperiodos = sizeof($this->periodos); 		
			 	
			 
			   if($numperiodos != 0){
			   	
			   	
			    	foreach($this->periodos as $rowperiodos){
			 	 	
			 	 	
	                      $this->campos = array('ENVIADO'=>'3',
						                        'FECHA_M'=>date("Y-m-d H:i:s"),
							                    'PK_USUARIO'=>$_SESSION['session']['user'],
						                       );
		
		                  $condition = "PK1='".$rowperiodos['PK1']."'";
		 
		                  database::updateRecords("PL_POPERATIVOS_PERIODOS",$this->campos,$condition);			 	 	
			 	 	
			 	 	
			 	 	
			 	    }
			   } 	
			    	
				
				
			}
			
			
		$this->campos = array('ESTADO'=>$this->estado,
							 'FECHA_M'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
		
		$condition = "PK1='".$this->idplan."'";
		 
		database::updateRecords("PL_POPERATIVOS",$this->campos,$condition);
		
			
			
		}
    	
    	
		
		
		
	}
	
	

	
	function getPlanO($id){
		
		$sql = "SELECT * FROM PL_POPERATIVOS WHERE PK1='$id'";   
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		
	}
	
	
	function getPeriodos($id){
		
		
		$this->periodosall = array();       
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$id'  ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
		foreach($rows as $row){
		
	    $this->periodos[] = $row;
		
        }
     	}
     	
     	function getPeriodOrden($id, $i){
		
		$sql = "SELECT * FROM PL_POPERATIVOS_PERIODOS WHERE PK_POPERATIVO = '$id' AND ORDEN = '$i' ";	  
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
		
	    }
	
	
		
	
}

?>