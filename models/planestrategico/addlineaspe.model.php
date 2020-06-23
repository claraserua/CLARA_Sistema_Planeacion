<?php

class addlineaspeModel {
	

	var $titulo;
	var $descripcion;
	var $jerarquia;
    var $disponible;
	var $fechai;
	var $fechat;
    var $usuario;
	var $idplan;
	
	var $lineas;
	var $objetivos;
	var $indicadores;
	
	
	var $campos;
	var $camposI;
	

	
	
	function __construct() {
		
	}

    
	
	
	function GuardarLinea(){
		
	
		for($i=0;$i<sizeof($this->lineas)-1;$i++){
				
			$idlineae =  strtoupper(substr(uniqid('LE'), 0, 15));
			$this->campos = array('PK1'=>$idlineae,
	                         'LINEA'=>$this->lineas[$i],
							 'ORDEN'=>$i,
							 'PK_PESTRATEGICO'=>$this->idplan,
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
	

		$result = database::insertRecords("PL_PESTRATEGICOS_LINEASE",$this->campos);
			
	     $this->GuardarObjetivos($idlineae,$i);
			
			}
		
		
		}
	
	
	
	
	function GuardarObjetivos($idlineae,$i){
		
	
        $objetivosestrategicos = explode("|",$this->objetivos[$i]);
		$objetivos_indicadores = explode("~",$this->indicadores[$i]);

		for($i=0;$i<sizeof($objetivosestrategicos)-1;$i++){
				
			
			$idobjetivo =  strtoupper(substr(uniqid('OE'), 0, 15));
			$this->campos = array('PK1'=>$idobjetivo,
	                         'OBJETIVO'=>$objetivosestrategicos[$i],
							 'ORDEN'=>$i,
							 'PK_LESTRATEGICA'=>$idlineae,
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
	
		$result = database::insertRecords("PL_PESTRATEGICOS_OBJETIVOSE",$this->campos);
		
		
		   $this->GuardarIndicadores($idobjetivo,$i,$objetivos_indicadores);
		
			
			}
		
		
		}
		
		
		
		function GuardarIndicadores($idobjetivo,$i,$objetivos_indicadores){
			
			
			   /////////EMPEZAMOS A GUARDAR LOS INDICADORES///////
								   
						   
					     $indicador_meta = explode("¬",$objetivos_indicadores[$i]);						
						 
						 for($k=0;$k<sizeof($indicador_meta)-1;$k++){						 	
							
							
						       $indicador = explode("|",$indicador_meta[$k]);							  				
							   $this->camposI = array(
	                                       'INDICADOR'=>str_replace("'","''",$indicador[0]),
										  'META'=>str_replace("'","''",$indicador[1]),
							               'ORDEN'=>$k,
							               'PK_OESTRATEGICO'=>$idobjetivo,							             
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	                      
						 database::insertRecords("PL_PESTRATEGICOS_OBJETIVOSE_INDICADORESMETAS",$this->camposI);
											
						  }    
			
			
			
			
			
			
			
			
		}
	
	
	
	
	
		function getPlanEstrategico($id){
	
      	$sql = "SELECT * FROM PL_PESTRATEGICOS WHERE PK1 = '$id' ";   
		$row = database::getRow($sql);

		if($row){
			return $row;
		}else{
			return FALSE;
		}
     	}
	
	
}

?>