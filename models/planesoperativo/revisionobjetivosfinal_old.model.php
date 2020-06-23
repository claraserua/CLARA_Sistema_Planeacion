<?php

class revisionobjetivosfinalModel {
	

	var $titulo;
	var $descripcion;
	var $jerarquia;
    var $disponible;
	var $fechai;
	var $fechat;
    var $usuario;
	var $idplan;
	
	var $idPlanOpe;
	var $resumenejecutivo;
	var $lineas;
	var $objetivos;
	var $objetivosE;
	var $medios;
	var $evidencias;
	var $estado;
    var $areas;
    var $fortalezas;
	
	var $comentarios;

	var $campos;
	

	
	
	function revisionobjetivosfinalModel() {
		
	}
	
	
    function getImagen($id){
		$sql = "SELECT * FROM PL_USUARIOS WHERE PK1 = '$id'";   
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
	  }
	
	
	function getPlanOperativo($id){
		$sql = "SELECT * FROM PL_POPERATIVOS WHERE PK1 = '$id'";   
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
	}
	

       function getLineasPlane($id){
		
		$this->lineas = array();
   	
		$sql = "SELECT * FROM PL_PESTRATEGICOS_LINEASE WHERE PK_PESTRATEGICO = '$id' ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	   $this->lineas[] = $row;
		
        }

     	}


        function getObjetivoE($id){
        $sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK1 = '$id' ";	
		$row = database::getRow($sql);
		if($row){
			return htmlentities($row['OBJETIVO'], ENT_QUOTES, "ISO-8859-1");
		}else{
			return FALSE;
		}
     	}
     	
         
		  function getObjetivosE($id){
		
		
		$this->objetivosE = array();
    
		$sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK_LESTRATEGICA = '$id' ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->objetivosE[] = $row;
		
        }
     	}


         
	 function getObjetivosTacticos($idPLAN,$idlINEA){
		
		$this->objetivos = array();
        $sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$idPLAN' AND PK_LESTRATEGICA = '$idlINEA' ORDER BY ORDEN";	
	    
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->objetivos[] = $row;
		
        }
     	}
		
		
	function getMedios($id){
		
		$this->medios = array();
        $sql = "SELECT * FROM PL_POPERATIVOS_MEDIOS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->medios[] = $row;
		
        }
     	}
		
		
		
		
		function getEvidencias($id){
		
		$this->evidencias = array();
        $sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->evidencias[] = $row;
		
        }
     	}
		

		 function getResponsables(){
		
		$this->responsables = array();
       $planoperativo =  $_GET['IDPlan'];
		
        $sql = "SELECT A.ROL, U.PK1,U.APELLIDOS, U.NOMBRE  FROM PL_POPERATIVOS_ASIGNACIONES A, PL_USUARIOS U  WHERE U.PK1 = A.PK_USUARIO AND A.PK_POPERATIVO = '$planoperativo'";
       
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	           $rol = $row['ROL'];
		       $sql = "SELECT * FROM PL_ROLES_PERMISOS WHERE PK_ROL='$rol' AND PK_PERMISO = 'P129'";
		       $rowpermiso = database::getRow($sql);
		       
			   if($rowpermiso){
			   	$this->responsables[] = $row;
			   }
		
        }
     	}
		
		
        
       	function getAreas(){
		
		$this->areas = array();
       
	   $planoperativo =  $_GET['IDPlan'];
		$sql = "SELECT * FROM PL_POPERATIVOS_AREAS WHERE PK_POPERATIVO = '$planoperativo' ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->areas[] = $row;
		
        }
     	}
		
		
		
		function getFortalezas(){
		
		$this->fortalezas = array();
       
	    $planoperativo =  $_GET['IDPlan'];
		$sql = "SELECT * FROM PL_POPERATIVOS_FORTALEZAS WHERE PK_POPERATIVO = '$planoperativo' ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->fortalezas[] = $row;
		
        }
     	}
		
		
		
		function getComentarios($id){
		
		$this->comentarios = array();
		$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS WHERE PK_OTACTICO = '$id' ORDER BY FECHA_R DESC";	
	    
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->comentarios[] = $row;
		
        }
        }
		
		
		
		function insertarComentario($comentario,$idobjetivo){
	   
	  	 
	   		
			$fechar = date("Y-m-d H:i:s");
		    $usuario = $_SESSION['session']['user'];
			
			$this->campos = array('COMENTARIO'=>$comentario,
							               'PK_OTACTICO'=>$idobjetivo,
										   'PK_USUARIO'=>$usuario,
							               'FECHA_R'=>$fechar,
							               );
	
		   database::insertRecords("PL_POPERATIVOS_OBJETIVOST_COMENTARIOS",$this->campos);
			  

         $sql = "SELECT TOP 1 PK1 FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS WHERE PK_USUARIO = '$usuario' AND PK_OTACTICO = '$idobjetivo' AND FECHA_R = '$fechar' ";  
		 
		
		 $row = database::getRow($sql); 
	

	   		if(!empty($row))
	   		{
	    		$data=$row['PK1'];
				return $data;
         	}
     
   }
		
		
	
	function eliminarComentarioResumen($id_comentario){
		
		$sql = "DELETE FROM PL_POPERATIVOS_RESUMENE_COMENTARIOS WHERE PK1 = '$id_comentario'";
	    $result = database::executeQuery($sql);   
		return true;
	}
	
	
	
	function eliminarComentario($id_comentario)
	{
		
	    $sql = "DELETE FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS WHERE PK1 = '$id_comentario'";
	    $result = database::executeQuery($sql);
        return true;
      	       
    }


      function getNumeroComentarios($id){
		$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS WHERE PK_OTACTICO = '$id'";	
		$num = database::getNumRows($sql);  	
		return $num;
		}
	 
	 function getNumeroComentariosResumenEjecutivo($id){
		$sql = "SELECT * FROM PL_POPERATIVOS_RESUMENE_COMENTARIOS WHERE PK_POPERATIVO = '$id'";	
		$num = database::getNumRows($sql);  	
		return $num; 	
	 }



     function getComentariosResumen($id){
		
		$this->comentarios = array(); 
		$sql = "SELECT * FROM PL_POPERATIVOS_RESUMENE_COMENTARIOS WHERE PK_POPERATIVO = '$id' ORDER BY FECHA_R DESC";	
	   $rows = database::getRows($sql);
		
	   foreach($rows as $row){
	    $this->comentarios[] = $row;
        }
     	}
	 
	 
	 
	 
	function insertarComentarioResumen($comentario,$idplan){
	   	   		
			$fechar = date("Y-m-d H:i:s");
		    $usuario = $_SESSION['session']['user'];
			
			$this->campos = array('COMENTARIO'=>$comentario,
							               'PK_POPERATIVO'=>$idplan,
										   'PK_USUARIO'=>$usuario,
							               'FECHA_R'=>$fechar,
							               );
	
		   database::insertRecords("PL_POPERATIVOS_RESUMENE_COMENTARIOS",$this->campos);
			
		
		 $sql = "SELECT TOP 1 PK1 FROM PL_POPERATIVOS_RESUMENE_COMENTARIOS WHERE PK_USUARIO = '$usuario' AND PK_POPERATIVO = '$idplan' AND FECHA_R = '$fechar' ";  
		
		 
		 $row = database::getRow($sql); 
	 
		
	   		if(!empty($row))
	   		{
	    		$data = $row['PK1'];
				return $data;
         	}
       
   }
		 

    function GuardarObjetivos(){
		
	//$this->EliminarObjetivos();
		

	$fecha = date("Y-m-d H:i:s");
		$usuario = $_SESSION['session']['user'];
		
		$plano = $this->idPlanOpe;
		

	 for($i=0;$i<sizeof($this->lineas)-1;$i++){
		
		
		$lineae =  $this->lineas[$i];
		
		
		$objetivos =  explode("^",$this->objetivos[$i]);
		$medios = explode("~",$this->medios[$i]);
		$evidencias = explode("~",$this->evidencias[$i]);

		          
		$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$plano'AND PK_LESTRATEGICA = '$lineae' ";
	    $numobjetivosbase =  database::getNumRows($sql);
		$numobjetivos = sizeof($objetivos)-1;
		
		if($numobjetivosbase>$numobjetivos){
		for($x=$numobjetivos;$x<=$numobjetivosbase;$x++){
		$sql = "DELETE FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$plano' AND PK_LESTRATEGICA = '$lineae' AND ORDEN='$x'";	
		database::executeQuery($sql);
		
		
		 }
		}
				  
				for($j=0;$j<sizeof($objetivos)-1;$j++){
		                   
						   
						 //GUARDAMOS LOS OBJETIVOS DEL PLAN OPERATIVO
						  
						$objetivo =  explode("¬",$objetivos[$j]);
						  
						$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$plano' AND ORDEN = '$j' AND PK_LESTRATEGICA = '$lineae'";
		                $row = database::getRow($sql);
						
		
	                    if($row){
		                 $idObjT = $row['PK1'];
		                 
						                  
			             $this->campos = array('OBJETIVO'=>str_replace("'","''",$objetivo[0]),
						            	 'PK_OESTRATEGICO'=>$objetivo[1],
							             'PK_RESPONSABLE'=>$objetivo[2],
						            	 'FECHA_M'=>$fecha,
						            	 'PK_USUARIO'=>$_SESSION['session']['user'],
							 );
		
		                 $condition = "PK_POPERATIVO = '$plano' AND ORDEN = '$j' AND PK_LESTRATEGICA = '$lineae'";
		 
		                 database::updateRecords("PL_POPERATIVOS_OBJETIVOST",$this->campos,$condition);
			
		                  }else{
						  
						  $idObjT =  (string)strtoupper(substr(uniqid('OT'), 0, 15));
						
						   $this->campos = array('PK1'=>$idObjT,
	                                       'OBJETIVO'=>str_replace("'","''",$objetivo[0]),
							               'ORDEN'=>$j,
										   'PK_POPERATIVO'=>$this->idPlanOpe,
							               'PK_LESTRATEGICA'=>$this->lineas[$i],
							               'PK_OESTRATEGICO'=>$objetivo[1],
							               'PK_RESPONSABLE'=>$objetivo[2],
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	
		                   
			               database::insertRecords("PL_POPERATIVOS_OBJETIVOST",$this->campos);
				          }		   
                /////////EMPEZAMOS A GUARDAR LOS MEDIOS///////
								   
						   
					     $medios_objetivo = explode("^",$medios[$j]);
						
						 
						 $sql = "SELECT * FROM PL_POPERATIVOS_MEDIOS WHERE PK_OTACTICO = '$idObjT'";
	                     $numobjetivosbase =  database::getNumRows($sql);
		                 $numobjetivos = sizeof($medios_objetivo)-1;
		
	                    	if($numobjetivosbase>$numobjetivos){
		                    for($x=$numobjetivos;$x<=$numobjetivosbase;$x++){
	                     	$sql = "DELETE FROM PL_POPERATIVOS_MEDIOS WHERE PK_OTACTICO = '$idObjT' AND ORDEN='$x'";	
		                    database::executeQuery($sql);
		                       }
		                    }
						 
						 
						 
						 for($k=0;$k<sizeof($medios_objetivo)-1;$k++){
						 	
						       $medio = explode("¬",$medios_objetivo[$k]);
							   $idMedio =  strtoupper(substr(uniqid('M'), 0, 15));					
							   
							   $sql = "SELECT * FROM PL_POPERATIVOS_MEDIOS WHERE PK_OTACTICO = '$idObjT' AND ORDEN = '$k'";
		                       $row = database::getRow($sql);
		                       
							   
	                           if($row){
							   
			                   $this->campos = array('MEDIO'=>str_replace("'","''",$medio[0]),
							                         'PK_RESPONSABLE'=>$medio[1],
						                         	 'FECHA_M'=>$fecha,
						                   	         'PK_USUARIO'=>$_SESSION['session']['user'],
							    );
		
		                       $condition = "PK_OTACTICO = '$idObjT' AND ORDEN = '$k'";
		 
		                       database::updateRecords("PL_POPERATIVOS_MEDIOS",$this->campos,$condition);
			
		                        }else{
							   
							   
							   $this->camposM = array('PK1'=>$idMedio,
	                                       'MEDIO'=>str_replace("'","''",$medio[0]),
							               'ORDEN'=>$k,
							               'PK_OTACTICO'=>$idObjT,
							               'PK_RESPONSABLE'=>$medio[1],
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	                      
						 database::insertRecords("PL_POPERATIVOS_MEDIOS",$this->camposM);
							}				
						  }    
						  
						     /////////EMPEZAMOS A GUARDAR LAS EVIDENCIAS///////
						  
						 
						
						 $evidencias_objetivo = explode("^",$evidencias[$j]);
						 
						 
						 $sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$idObjT'";
	                     $numobjetivosbase =  database::getNumRows($sql);
		                 $numobjetivos = sizeof($evidencias_objetivo)-1;
		
	                    	if($numobjetivosbase>$numobjetivos){
		                    for($x=$numobjetivos;$x<=$numobjetivosbase;$x++){
	                     	$sql = "DELETE FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$idObjT' AND ORDEN='$x'";	
		                    database::executeQuery($sql);
		                       }
		                    }
						 
						 
						 for($k=0;$k<sizeof($evidencias_objetivo)-1;$k++){
						 	
							 
							   $sql = "SELECT * FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$idObjT' AND ORDEN = '$k'";
		                       $row = database::getRow($sql);
		                       
	                           if($row){
							   
			                   $this->campos = array('EVIDENCIA'=>str_replace("'","''",$evidencias_objetivo[$k]),
						                         	 'FECHA_M'=>$fecha,
						                   	         'PK_USUARIO'=>$_SESSION['session']['user'],
							    );
		
		                       $condition = "PK_OTACTICO = '$idObjT' AND ORDEN = '$k'";
		 
		                       database::updateRecords("PL_POPERATIVOS_EVIDENCIAS",$this->campos,$condition);
			
		                        }else{
							 
							   $idEvidencia =  strtoupper(substr(uniqid('E'), 0, 15));					
							   $this->camposM = array('PK1'=>$idEvidencia,
	                                       'EVIDENCIA'=>str_replace("'","''",$evidencias_objetivo[$k]),
							               'ORDEN'=>$k,
							               'PK_POPERATIVO'=>$this->idPlanOpe,
										   'PK_LESTRATEGICA'=>$this->lineas[$i],
										   'PK_OTACTICO'=>$idObjT,
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	

						  database::insertRecords("PL_POPERATIVOS_EVIDENCIAS",$this->camposM);
						    }					
						  } 
						 
						   						   
			     }
		
		}
		
		
		 /////////GUARDAMOS EL RESUMEN EJECUTIVO///////
		 
		$idplano = $this->idPlanOpe;
        $sql = "DELETE FROM PL_POPERATIVOS_AREAS WHERE PK_POPERATIVO = '$idplano' ";		
	    database::executeQuery($sql);
        
        for($k=0;$k<sizeof($this->areas)-1;$k++){
						 	
						       
							   $idArea =  strtoupper(substr(uniqid('A'), 0, 15));					
							   $this->camposM = array('PK1'=>$idArea,
	                                       'AREA'=>$this->areas[$k],
							               'ORDEN'=>$k,
							               'PK_POPERATIVO'=>$this->idPlanOpe,
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	

						  database::insertRecords("PL_POPERATIVOS_AREAS",$this->camposM);
											
       }
       
       
       $sql = "DELETE FROM PL_POPERATIVOS_FORTALEZAS WHERE PK_POPERATIVO = '$idplano' ";		
       database::executeQuery($sql);	
       
       for($k=0;$k<sizeof($this->fortalezas)-1;$k++){
						 	
						       
							   $idFortaleza =  strtoupper(substr(uniqid('F'), 0, 15));					
							   $this->camposM = array('PK1'=>$idFortaleza,
	                                       'FORTALEZA'=>$this->fortalezas[$k],
							               'ORDEN'=>$k,
							               'PK_POPERATIVO'=>$this->idPlanOpe,
							               'FECHA_R'=>date("Y-m-d H:i:s"),
							               'PK_USUARIO'=>$_SESSION['session']['user'],
							               );
	

						  database::insertRecords("PL_POPERATIVOS_FORTALEZAS",$this->camposM);
											
       }
		
		 	 			  
						  
		 //////ACTUALIZAMOS EL ESTADO DEL PLAN OPERATIVO A GUARDADO///
		 
		$this->campos = array('ESTADO'=>$this->estado,
							               );								   
		$condition = "PK1='".$this->idPlanOpe."'"; 
		database::updateRecords("PL_POPERATIVOS",$this->campos,$condition);
		
	}
	
	  
	    function EliminarObjetivos(){
	   	
		$idplao = $this->idPlanOpe;
		$sql = "SELECT PK1 FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$idplao' ";	
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
			  $id = $row['PK1'];
		      $sql = "DELETE FROM PL_POPERATIVOS_MEDIOS WHERE PK_OTACTICO = '$id' ";	
	          database::executeQuery($sql);
			  
			  
			  $sql = "DELETE FROM PL_POPERATIVOS_EVIDENCIAS WHERE PK_OTACTICO = '$id' ";	
	          database::executeQuery($sql);
			  		 
		           
        }
	
		
		$sql = "DELETE FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$idplao' ";		
	    database::executeQuery($sql);
		
	   }
	
	
	
	    function getResumenEjecutivo($id){
        $sql = "SELECT * FROM PL_POPERATIVOS_RESUMENE WHERE PK_POPERATIVO = '$id'";   
		$row = database::getRow($sql);
	
		if($row){
			return $row;
		}else{
			return FALSE;
		}
     	}
	
	function getEstadoPlanOperativo($id){
		 	
			
			$estado="";
			$sql = "SELECT ESTADO FROM PL_POPERATIVOS WHERE PK1 = '$id' ";  
		 
		 
		    $row = database::getRow($sql);
	    
		    switch(trim($row['ESTADO'])){
			  	
				case 'P':
					$estado = '<span class="label label-warning">Elaborando</span>';
			  		break;
				
				
				case "G":
					$estado = '<span class="label label-warning">Elaborando</span>';
			  		break;
				
					
			    case "E":
					$estado = '<span class="label label-revision">Revisando</span>';
					
			  		break;
					
				case "R":
					$estado = '<span class="label label-warning">Revisando Centro</span>';
			  		break;
					
					
				case "S":
					$estado = '<span class="label label-success">Elaborando Informe</span>';
			  		break;
			  	
				
				case "I":
					$estado = '<span class="label label-revision">Revisando Informe</span>';
			  		break;
					
				case "T":
					$estado = '<span class="label label-important">Terminado</span>';
			  		break;
				
			  	default:
				$estado = '<span class="label label-warning">Pendiente</span>';
			  		break;
			  }
			  
			  
			  return $estado;
			
		 }
	
}

?>