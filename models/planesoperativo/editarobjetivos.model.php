<?php

require 'libs/PHPMailer/PHPMailerAutoload.php';

class editarobjetivosModel {
	

	var $titulo;
	var $descripcion;
	var $jerarquia;
    var $disponible;
	var $fechai;
	var $fechat;
    var $usuario;
	var $idplan;
	var $idplane;
	
	var $idPlanOpe;
	var $resumenejecutivo;
	var $lineas;
	var $objetivos;
	var $objetivosE;
	var $medios;
	var $evidencias;
	var $estado;

	var $campos;
	
	var $areas;
	var $fortalezas;
	var $comentarios;
	
	

	
	
	function __construct() {
		
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
	
	
	function setActive($idplan){
		
		$user = $_SESSION['session']['user'];
		
		$sql = "SELECT * FROM PL_POPERATIVOS WHERE PK1='$idplan' AND ACTIVO = NULL";
		$row = database::getRow($sql);
	
		if($row){
			$sql = "UPDATE PL_POPERATIVOS SET ACTIVO = '$user' WHERE PK1='$idplan'";	
	        $result = database::executeQuery($sql);
		}else{
			return FALSE;
		}
		
	}
	
	
	function getPlanOperativo($id){
		
		$camposM = array(
	              'APLICACION'=>'PLAN OPERATIVO',
			      'MODULO'=>'EDICION',
				  'MENSAJE'=>'INGRESO PLAN OPERATIVO: '.$id,
				  'PK_USUARIO'=>$_SESSION['session']['user'],
				  'FECHA_R'=>date("Y-m-d H:i:s"),
							               );
	
	    database::insertRecords("PL_ACTIVIDAD_USUARIO",$camposM);
		
		
		
		$sql = "SELECT * FROM PL_POPERATIVOS WHERE PK1='$id'";   
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
		
        $sql = "SELECT A.ROL,U.PK1,U.APELLIDOS, U.NOMBRE  FROM PL_POPERATIVOS_ASIGNACIONES A, PL_USUARIOS U  WHERE U.PK1 = A.PK_USUARIO AND A.PK_POPERATIVO = '$planoperativo'";
       
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
		//	$sql = "SELECT * FROM PL_POPERATIVOS_AREAS WHERE PK_POPERATIVO = '$planoperativo' ORDER BY ORDEN";	
			$sql = "SELECT * FROM PL_POPERATIVOS_AREAS WHERE PK_POPERATIVO = '$planoperativo' ORDER BY FECHA_R";
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
		
		
		 

    function GuardarObjetivos(){
		
		
	//$this->EliminarObjetivos();
		
		$fecha = date("Y-m-d H:i:s");
		$usuario = $_SESSION['session']['user'];
		
		$plano = $this->idPlanOpe;
		
		$plane = $this->idplane;
		
		
		$camposM = array(
	              'APLICACION'=>'PLAN OPERATIVO',
			      'MODULO'=>'EDICION',
				  'MENSAJE'=>'GUARDA PLAN OPERATIVO: '.$plano,
				  'PK_USUARIO'=>$_SESSION['session']['user'],
				  'FECHA_R'=>date("Y-m-d H:i:s"),
							               );
	
	
	    database::insertRecords("PL_ACTIVIDAD_USUARIO",$camposM);
		
		

	 for($i=0;$i<sizeof($this->lineas)-1;$i++){
		
		
		$lineae =  $this->lineas[$i];
		
		
		$objetivos =  explode("^",$this->objetivos[$i]);
		$medios = explode("~",$this->medios[$i]);
		$evidencias = explode("~",$this->evidencias[$i]);

		          
		$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST WHERE PK_POPERATIVO = '$plano' AND PK_LESTRATEGICA = '$lineae' ";
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
				 
		/*$this->campos = array('ESTADO'=>$this->estado,
							               );								   
		$condition = "PK1='".$this->idPlanOpe."'"; 
		database::updateRecords("PL_POPERATIVOS",$this->campos,$condition);*/
		
		
	}
	
	
	function EnviarRevision($idplan,$idplane){
		//REVISADO POR LA ORUA
	    $sql = "UPDATE PL_POPERATIVOS SET ESTADO = 'E' WHERE PK1 = '$idplan'";
	    $result = database::executeQuery($sql);
		
		
		$camposM = array(
	              'APLICACION'=>'PLAN OPERATIVO',
			      'MODULO'=>'ELABORACION',
				  'MENSAJE'=>'ENVIO PLAN OPERATIVO: '.$idplan,
				  'PK_USUARIO'=>$_SESSION['session']['user'],
				  'FECHA_R'=>date("Y-m-d H:i:s"),
							               );
	
	    database::insertRecords("PL_ACTIVIDAD_USUARIO",$camposM);  
		
		$parametros = "ESTADO=E,PLAN=".$idplan;
		
		$sql = "SELECT * FROM PL_POPERATIVOS_ASIGNACIONES WHERE PK_POPERATIVO = '".$idplan."' ";
		$rows = database::getRows($sql);
		
		foreach($rows as $row){
		             
					 $passport = new Authentication();
					 
					 
					  if($passport->getPrivilegioRol($row['ROL'],'P141')){ 
					  	
					               $this->EnviarCorreo($_SESSION['session']['user'],$row['PK_USUARIO'],$idplan);
					               
								    }
					 
					 
					 if($passport->getPrivilegioRol($row['ROL'],'P116')){
					              
								  
					 
	                 //insertamos alertas
					 $campos = array('OBJETIVO'=>"Se ha enviado un Plan Operativo para REVISAR..",
							 'TIPO'=>"ALERT",
							 'VISTO'=>'0',
							 'URL'=>"?execute=planesoperativo/revisionobjetivos&method=default&estado=E&Menu=F2&SubMenu=SF21&IDPlan=".$idplan."&IDPlanE=".$idplane."",
							 'PK_JERARQUIA'=>NULL,
							 'PARAMETROS'=>$parametros,
							 'PK_USUARIO'=>$row['PK_USUARIO'],
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'ENVIADO'=>$_SESSION['session']['user'],
							 );
	
		database::insertRecords("PL_NOTIFICACIONES",$campos);
		}
					 
		
        }
		
	 	
	}
	
	
	function EnviarCorreo($de,$para,$idplao){
		
		
	$sql = "SELECT * FROM PL_USUARIOS WHERE PK1 = '$de'";   
    $rowde = database::getRow($sql);
	
	$sql = "SELECT * FROM PL_USUARIOS WHERE PK1 = '$para'";   
    $rowpara = database::getRow($sql);
	
	
	$sql = "SELECT TITULO FROM PL_POPERATIVOS WHERE PK1 = '$idplao'";   
    $row = database::getRow($sql);
	$operativo = $row['TITULO'];
	
	$mail = new PHPMailer;
    $para = trim($rowpara['EMAIL']);


//$mail->SMTPDebug  = 2;
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.office365.com';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'planeacion@redanahuac.mx';                            // SMTP username
$mail->Password = 'Pl@neaci0n';                           // SMTP password
$mail->SMTPSecure = 'tls';
$mail->Port = '587';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'planeacion@redanahuac.mx';
$mail->FromName = 'Sistema de Planeación RUA';
$mail->addAddress($para);  // Add a recipient
//$mail->addAddress('jose.ruiz@redanahuac.mx');               // Name is optional
//$mail->addReplyTo('planeacion@redanahuac.mx');
//$mail->addCC('cc@example.com');
$mail->addBCC('planeacion@redanahuac.mx');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Plan operativo enviado a revisión';
$mail->Body    = '
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Sistema de Planeación RUA</title>

<style>
	table td {border-collapse:collapse;margin:0;padding:0;}
</style>
</head>

<body>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" width="50%"></td>
		<td valign="top">
		

<table width="640" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="1" style="background:#E66500; border-top:1px solid #e3e3e3;"></td>
		<td width="24" style="background:#E66500; border-top:1px solid #e3e3e3;">&nbsp;</td>
		<td width="365" align="left" valign="middle" style="background:#E66500; border-top:1px solid #e3e3e3; color:#ffffff; padding:18px 0;">
<h1 style="font-family:Segoe UI, Tahoma, sans-serif; margin:0px; font-size:12pt; line-height:19px; color:#072B60; font-weight:normal;color:#ffffff;">Se ha enviado un plan operativo para su revisi&oacute;n</h1>
<p style="margin:0;font-size:11pt;font-family:Segoe UI, Tahoma, sans-serif;color:#000;color:#ffffff;">Ahora puede ingresar y revisar el plan</p>
		</td>
		<td width="15" style="background:#E66500; border-top:1px solid #e3e3e3;">&nbsp;</td>
		<td width="205" align="right" valign="middle" style="background:#E66500; border-top:1px solid #e3e3e3; padding:18px 0; line-height:1px;">
<img src="'.$config['site_url']
.'/skins/default/img/logo_anahuac.png"  alt="Red de Universidades Anahuac" border="0">
		</td>
		<td width="29" style="background:#E66500; border-top:1px solid #e3e3e3;">&nbsp;</td>
		<td width="1" style="background:#E66500; border-top:1px solid #e3e3e3;"></td>
	</tr>
</table>
<!---->

<table width="640" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="1" style="background:#e3e3e3;"></td>
		<td width="24">&nbsp;</td>
		<td width="585" valign="top" colspan="2" style="border-bottom:1px solid #e3e3e3; padding:20px 0;">
		
			<table width="585" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
<p style="margin-top:20px;font-family:Segoe UI, Tahoma, sans-serif;color:#000;font-size:10pt;">

<p style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;"> El plan operativo: <strong>'.$operativo.'</strong> ha sido enviado para su revisión por el usuario:  </p>


<!-- START AMPSCRIPT  -->
<table cellpadding="0" cellspacing="0" border="0" style="font-family:\'Segoe UI\', Tahoma, sans-serif; font-size:10pt; margin:0px;">


	<tr>
		
		<td><img src="'.$config['site_url']
.'/media/usuarios/'.$rowde['IMAGEN'].'" height="40"  widht="40" />  </td>
		
		<td style="font-family:\'Segoe UI\', Segoe, Tahoma, sans-serif; font-size:10pt; line-height:15px; color:#000000;">
		<strong> &nbsp;'.$rowde['NOMBRE'].' '.$rowde['APELLIDOS'].'</strong></td>
        
        
	</tr>
	
	<!---->
</table>
<!-- END AMPSCRIPT -->
<div style="margin-top:20px;font-family:\'Segoe UI\', Tahoma, sans-serif; font-size:10pt; line-height:13pt; color:#000;"> 


                  <p style="color:#000; font-size:10pt;font-family:Segoe UI, Tahoma, sans-serif;">Tenga en cuenta que:</p>

                  <ul style="font-family:Segoe UI, Tahoma, sans-serif;color:#000;font-size:10pt;">
                    <li>Puede comentar en cada resultado del plan, en el diagnóstico inicial y agregar comentarios generales.</li>

                    <li>Sólo los usuarios que tengan permiso podrán enviar el plan revisado al centro.</li>
                  </ul>


<br><p style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">Por favor vaya a la página de inicio de sesión del Sistema de Planeación e ingrese con su usuario y contraseña:  </p>

  <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">
	<tr>

	  <td style="font-family:Segoe UI, Tahoma, sans-serif; font-size:12pt; text-align:center; color:#557eb9; padding:5px 0px 5px 15px;">&nbsp;</td>
	
	  <td style="padding:0px 15px; font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">
	  <a href="'.$config['site_url']
.'"  title="'.$config['site_url']
.'" style="color:#072b60;">'.$config['site_url']
.'</a>.</td>
	</tr>
  </table>



<p style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">Atentamente, <br />Dirección de Estrategia y Desarrollo Corporativo <br/>
Secretaría Ejecutiva de la Red de Universidades Anáhuac</p>
					</td>
				</tr>
			</table>

		</td>
		<td width="29">&nbsp;</td>
		<td width="1" style="background:#e3e3e3;"></td>
	</tr>
	<tr>
		<td width="1" style="background:#e3e3e3; border-bottom:1px solid #e3e3e3;"></td>
		<td width="24" style="border-bottom:1px solid #e3e3e3;">&nbsp;</td>
		<td width="585" valign="top" colspan="2" style="border-bottom:1px solid #e3e3e3; padding:20px 0;">
		
			<table cellpadding="0" cellspacing="0" border="0" width="585">
				<tr>
					<td width="438">
						<p style="font-family:Segoe UI, Tahoma, sans-serif; margin:0px 0px 0px 5px; color:#000; font-size:10px;">Red de Universidades An&agrave;huac | &copy; Copyright 2013. Todos los derechos reservados. <br /> Este mensaje se ha enviado desde una direcci&oacute;n de correo electr&oacute;nico no supervisada. No responda a este mensaje.<br /> <span style="color:#072B60;"><a href="#"  title="Privacidad" style="color:#072B60; text-decoration:none">Privacidad</a> | <a href="#"  title="Informaci&oacute;n legal" style="color:#072B60; text-decoration:none">Informaci&oacute;n legal</a></span></p>
					</td>
					<td width="20">&nbsp;</td>
					<td width="127"><img src="'.$config['site_url']
.'portal/img/logo.png"  alt="Red de Universidades Anáhuac" border="0"></td>
				</tr>
			</table>
		
		</td>
		<td width="29" style="border-bottom:1px solid #e3e3e3;">&nbsp;</td>
		<td width="1" style="background:#e3e3e3; border-bottom:1px solid #e3e3e3;"></td>
	</tr>
</table>

<!--  -->

		</td>
		<td valign="top" width="50%"></td>
	</tr>
</table>



</body>
</html>
';
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


$mail->send();

//if(!$mail->send()) {
  // echo 'Message could not be sent.';
  // echo 'Mailer Error: ' . $mail->ErrorInfo;
  // exit;
//}
		
		
		
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
        
         $sql = "DELETE FROM PL_POPERATIVOS_AREAS WHERE PK_POPERATIVO = '$idplao' ";		
	    database::executeQuery($sql);
		
	    $sql = "DELETE FROM PL_POPERATIVOS_FORTALEZAS WHERE PK_POPERATIVO = '$idplao' ";		
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
	
	
	     function getComentariosGenerales($id){
		
		$this->comentarios = array();
		$sql = "SELECT * FROM PL_POPERATIVOS_COMENTARIOS WHERE PK_POPERATIVO = '$id' ORDER BY FECHA_R DESC";	
	    
	   $rows = database::getRows($sql);
		
		foreach($rows as $row){
		
	    $this->comentarios[] = $row;
		
        }
        }
		 
	      function insertarComentarioGeneral($comentario,$idplan,$tipo){
	   	
			$fechar = date("Y-m-d H:i:s");
		    $usuario = $_SESSION['session']['user'];
			
			$this->campos = array('COMENTARIO'=>$comentario,
							               'PK_POPERATIVO'=>$idplan,
										   'PK_USUARIO'=>$usuario,
							               'FECHA_R'=>$fechar,
										   'TIPO'=>$tipo,
							               );
	
		   database::insertRecords("PL_POPERATIVOS_COMENTARIOS",$this->campos);
			  

         $sql = "SELECT TOP 1 PK1 FROM PL_POPERATIVOS_COMENTARIOS WHERE PK_USUARIO = '$usuario' AND PK_POPERATIVO = '$idplan' AND FECHA_R = '$fechar' ";  
		 
		
		 $row = database::getRow($sql); 
	

	   		if(!empty($row))
	   		{
	    		$data=$row['PK1'];
				return $data;
         	}
			
			
			
			//Agregarmos la alerta
		/*
		$this->campos = array('OBJETIVO'=>$comentario,
							 'TIPO'=>"COMEN",
							 'VISTO'=>'0',
							 'URL'=>"?execute=operativo&method=default&Menu=F2&SubMenu=SF21#&p=1&s=25&sort=1&q=&filter=".$JERARQUIA."",
							 'PK_JERARQUIA'=>$this->jerarquia,
							 'PK_USUARIO'=>$_SESSION['session']['user'],
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 );
	
		database::insertRecords("PL_NOTIFICACIONES",$this->campos);*/
			
			
     
   }
	
	
	      function eliminarComentarioGeneral($id_comentario){
		
		echo $id_comentario;
		$sql = "DELETE FROM PL_POPERATIVOS_COMENTARIOS WHERE PK1 = '$id_comentario'";
	    $result = database::executeQuery($sql);   
		return true;
	}
}

?>