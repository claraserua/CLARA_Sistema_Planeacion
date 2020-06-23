<?php
require 'libs/PHPMailer/PHPMailerAutoload.php';

class revisionobjetivosModel {
	

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
	var $indicadoresO;
	var $indicadoresMeta;
	var $medios;
	var $evidencias;
	var $estado;
	
	var $comentarios;

	var $campos;
	var $amenazas;
	var $oportunidades;
	

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
	
	
	
	function getPlanOperativo($id){
		
		$camposM = array(
	              'APLICACION'=>'PLAN OPERATIVO',
			      'MODULO'=>'REVISION',
				  'MENSAJE'=>'INGRESO PLAN OPERATIVO: '.$id,
				  'PK_USUARIO'=>$_SESSION['session']['user'],
				  'FECHA_R'=>date("Y-m-d H:i:s"),
							               );
	
	    database::insertRecords("PL_ACTIVIDAD_USUARIO",$camposM);
		
		
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
			return $row['OBJETIVO'];
		}else{
			return FALSE;
		}
     	}
		
		
		function getObjetivoEst($id){
        $sql = "SELECT * FROM PL_PESTRATEGICOS_OBJETIVOSE WHERE PK1 = '$id' ";	
		$row = database::getRow($sql);
		if($row){
			return $row;
		}else{
			return FALSE;
		}
     	}



         function getResponsable($id){
		$sql = "SELECT * FROM PL_USUARIOS WHERE PK1 = '$id' ";	
		$row = database::getRow($sql);
		if($row){
			return $row['APELLIDOS']." ".$row['NOMBRE'];
		}else{
			return FALSE;
		}
		 }
		function getIndicadoresByObj($idResul,$idObj){
			$this->indicadoresO = array();
		
			$sql = "SELECT oe.PK1,oe.INDICADOR,oe.META,oe.ORDEN,oe.PK_OESTRATEGICO
			FROM PL_PESTRATEGICOS_OBJETIVOSE_INDICADORESMETAS AS oe, 
			     PL_POPERATIVOS_OBJETIVOS_INDICADORES AS oi
			WHERE oe.PK1 = oi.PK_INDICADORMETA
			AND oi.PK_OTACTICO = '$idResul'
			AND oe.PK_OESTRATEGICO = '$idObj'
			ORDER BY oe.orden ASC";	
			$rows = database::getRows($sql);
			
			//echo '<input type="hidden" value="'.$sql.'"></input>';
			foreach($rows as $row){
				$this->indicadoresO[] = $row;
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
		

		function getIndicadoresMetas($id){
		
			$this->indicadoresMeta = array();
			$sql = "SELECT * FROM PL_POPERATIVOS_INDICADORESMETAS WHERE PK_OTACTICO = '$id' ORDER BY ORDEN";	
			$rows = database::getRows($sql);
			
		   	foreach($rows as $row){
				$this->indicadoresMeta[] = $row;
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
     	
     	
     	
     	
     	
     	
     	
     	
     	//-----------------------------------nuevo
     	
     	
     	
     		/*NUEVO*/
		
		function getAmenazas(){//AMENAZAS
		
		$this->amenazas = array();
       
	    $planoperativo =  $_GET['IDPlan'];
		$sql = "SELECT * FROM PL_POPERATIVOS_AMENAZAS WHERE PK_POPERATIVO = '$planoperativo' ORDER BY ORDEN";

        //echo $sql ;		
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->amenazas[] = $row;
		
        }
     	}
		
			
		
		function getOportunidades(){
		
		$this->oportunidades = array();
       
	    $planoperativo =  $_GET['IDPlan'];
		$sql = "SELECT * FROM PL_POPERATIVOS_OPORTUNIDADES WHERE PK_POPERATIVO = '$planoperativo' ORDER BY ORDEN";	
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->oportunidades[] = $row;
		
        }
     	}
		
		
		
		
			//--------------------------------------
		
		
		
		function getComentarios($id){
		
		$this->comentarios = array();
		$sql = "SELECT * FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS WHERE PK_OTACTICO = '$id' ORDER BY FECHA_R DESC";	
	    
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
	    $this->comentarios[] = $row;
		
        }
        }
     	
		
		
		
		function insertarComentario($comentario,$idobjetivo,$tipo){
	   	
			$fechar = date("Y-m-d H:i:s");
		    $usuario = $_SESSION['session']['user'];
			
			$this->campos = array('COMENTARIO'=>str_replace("'","''",$comentario),
							               'PK_OTACTICO'=>$idobjetivo,
										   'PK_USUARIO'=>$usuario,
							               'FECHA_R'=>$fechar,
										   'TIPO'=>$tipo,
							               );
	
		   database::insertRecords("PL_POPERATIVOS_OBJETIVOST_COMENTARIOS",$this->campos);
			  

         $sql = "SELECT TOP 1 PK1 FROM PL_POPERATIVOS_OBJETIVOST_COMENTARIOS WHERE PK_USUARIO = '$usuario' AND PK_OTACTICO = '$idobjetivo' AND FECHA_R = '$fechar' ";  
		 
		
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
	 
	 
	 
	 
	 function insertarComentarioResumen($comentario,$idplan,$tipo){
	   	   		
			$fechar = date("Y-m-d H:i:s");
		    $usuario = $_SESSION['session']['user'];
			
			$this->campos = array('COMENTARIO'=>str_replace("'","''",$comentario),
							               'PK_POPERATIVO'=>$idplan,
										   'PK_USUARIO'=>$usuario,
							               'FECHA_R'=>$fechar,
										   'TIPO'=>$tipo,
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
			
			$this->campos = array('COMENTARIO'=>str_replace("'","''",$comentario),
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
	 
	 
	 
    function EnviarRevision($idplan,$idplane){
		//REVISADO POR LA ORUA
	    $sql = "UPDATE PL_POPERATIVOS SET ESTADO = 'R' WHERE PK1 = '$idplan'";
	    $result = database::executeQuery($sql);
		
		
		
		$camposM = array(
	              'APLICACION'=>'PLAN OPERATIVO',
			      'MODULO'=>'REVISION',
				  'MENSAJE'=>'ENVIO PLAN OPERATIVO: '.$idplan,
				  'PK_USUARIO'=>$_SESSION['session']['user'],
				  'FECHA_R'=>date("Y-m-d H:i:s"),
							               );
	
	    database::insertRecords("PL_ACTIVIDAD_USUARIO",$camposM);  
		
		$this->setAlertar($idplan,$idplane);
		 
	 	
	}
	
	
	function setAlertar($idplan,$idplane){
		
		
		$sql = "SELECT * FROM PL_POPERATIVOS_ASIGNACIONES WHERE PK_POPERATIVO = '".$idplan."'";
       
	    $parametros = "ESTADO=R,PLAN=".$idplan;
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		              
					 $passport = new Authentication();
					 
					 
					 if($passport->getPrivilegioRol($row['ROL'],'P142')){ 	
					              
								   $this->EnviarCorreo($_SESSION['session']['user'],$row['PK_USUARIO'],$idplan);
					        }
					 
					 
					 if($passport->getPrivilegioRol($row['ROL'],'P115')){

						
	                 //insertamos alertas
					 $this->campos = array('OBJETIVO'=>"Se ha enviado un Plan Operativo REVISADO..",
							 'TIPO'=>"ALERT",
							 'VISTO'=>'0',
							 'URL'=>"?execute=planesoperativo/revisionobjetivos&method=default&estado=R&Menu=F2&SubMenu=SF21&IDPlan=".$idplan."&IDPlanE=".$idplane."",
							 'PK_JERARQUIA'=>NULL,
							 'PARAMETROS'=>$parametros,
							 'PK_USUARIO'=>$row['PK_USUARIO'],
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'ENVIADO'=>$_SESSION['session']['user'],
							 );
	
		database::insertRecords("PL_NOTIFICACIONES",$this->campos);
					 }
		
        }
		
		
		
	}
	
	
	
	 function PasarSeguimiento($idplan,$idplane){
		//PASAMOS ASEGUIMIENTO
	    $sql = "UPDATE PL_POPERATIVOS SET ESTADO = 'S' WHERE PK1 = '$idplan'";
	    $result = database::executeQuery($sql);
		
		
		$sql = "SELECT * FROM PL_POPERATIVOS WHERE PK1 = '$idplan'";   
		$rowplan = database::getRow($sql);
		
		
		$sql = "SELECT * FROM PL_POPERATIVOS_ASIGNACIONES WHERE PK_POPERATIVO = '".$idplan."'";
       
	    $parametros = "ESTADO=R,PLAN=".$idplan;
	    $rows = database::getRows($sql);
		
	   foreach($rows as $row){
		
		
		             $passport = new Authentication();
					 
					 if($passport->getPrivilegioRol($row['ROL'],'P116')){
	                 //insertamos alertas
					 $this->campos = array('OBJETIVO'=>"Plan Operativo ha pasado a SEGUIMIENTO..",
							 'TIPO'=>"ALERT",
							 'VISTO'=>'0',
							 'URL'=>"?execute=operativo&method=default&Menu=F2&SubMenu=SF21#&p=1&s=25&sort=1&q=".$rowplan['TITULO']."&filter=".$rowplan['PK_JERARQUIA']."",
							 'PK_JERARQUIA'=>NULL,
							 'PARAMETROS'=>NULL,
							 'PK_USUARIO'=>$row['PK_USUARIO'],
							 'FECHA_R'=>date("Y-m-d H:i:s"),
							 'ENVIADO'=>$_SESSION['session']['user'],
							 );
	
		database::insertRecords("PL_NOTIFICACIONES",$this->campos);
					 }
		
        }
		 	
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
$mail->FromName = 'Sistema de Planeaci�n RUA';
$mail->addAddress($para);  // Add a recipient
//$mail->addAddress('jose.ruiz@redanahuac.mx');               // Name is optional
//$mail->addReplyTo('planeacion@redanahuac.mx');
//$mail->addCC('cc@example.com');
$mail->addBCC('planeacion@redanahuac.mx');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Plan operativo revisado';
$mail->Body    = '
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin tÃ­tulo</title>

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
<h1 style="font-family:Segoe UI, Tahoma, sans-serif; margin:0px; font-size:12pt; line-height:19px; color:#072B60; font-weight:normal;color:#ffffff;">Se ha enviado un plan operativo revisado</h1>
<p style="margin:0;font-size:11pt;font-family:Segoe UI, Tahoma, sans-serif;color:#000;color:#ffffff;">Ahora puede ingresar y ver los comentarios.</p>
		</td>
		<td width="15" style="background:#E66500; border-top:1px solid #e3e3e3;">&nbsp;</td>
		<td width="205" align="right" valign="middle" style="background:#E66500; border-top:1px solid #e3e3e3; padding:18px 0; line-height:1px;">
<img src="'.$config['site_url']
.'skins/default/img/logo_anahuac.png"  alt="Red de Universidades Anahuac" border="0">
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

<p style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;"> El plan operativo: <strong>'.$operativo.'</strong> ha sido enviado revisado por el usuario:  </p>


<!-- START AMPSCRIPT  -->
<table cellpadding="0" cellspacing="0" border="0" style="font-family:\'Segoe UI\', Tahoma, sans-serif; font-size:10pt; margin:0px;">

	<tr>
		
		<td><img src="'.$config['site_url']
.'media/usuarios/'.$rowde['IMAGEN'].'" height="40"  widht="40" />  </td>
		
		<td style="font-family:\'Segoe UI\', Segoe, Tahoma, sans-serif; font-size:10pt; line-height:15px; color:#000000;">
		<strong> &nbsp;'.$rowde['NOMBRE'].' '.$rowde['APELLIDOS'].'</strong></td>
        
        
	</tr>
	
	<!---->
</table>
<!-- END AMPSCRIPT -->
<div style="margin-top:20px;font-family:\'Segoe UI\', Tahoma, sans-serif; font-size:10pt; line-height:13pt; color:#000;"> 


                  <p style="color:#000; font-size:10pt;font-family:Segoe UI, Tahoma, sans-serif;">Tenga en cuenta que:</p>

                  <ul style="font-family:Segoe UI, Tahoma, sans-serif;color:#000;font-size:10pt;">
                  <li>Todos los usuarios del centro pueden ver los comentarios de los resultados.</li>
                    <li>S�lo los usuarios con permiso pueden editar y finalizar el plan.</li>

                    <li>El plan debe ser finalizado para que pase a la fase de seguimiento. El rector debe ser el �ltimo usuario de la universidad que verifique el plan con todos los cambios y observaciones.</li>
                  </ul>


<br><p style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">Por favor vaya a la p�gina de inicio de sesi�n del Sistema de Planeaci�n e ingrese con su usuario y contrase�a:  </p>

  <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">
	<tr>

	  <td style="font-family:Segoe UI, Tahoma, sans-serif; font-size:12pt; text-align:center; color:#557eb9; padding:5px 0px 5px 15px;">&nbsp;</td>
	
	  <td style="padding:0px 15px; font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;"><a href="'.$config['site_url']
.'"  title="'.$config['site_url']
.'" style="color:#072b60;">'.$config['site_url']
.'</a>.</td>
	</tr>
  </table>



<p style="font-family:Segoe UI, Tahoma, sans-serif; font-size:10pt; color:#000;">Atentamente, <br />Direcci�n de Estrategia y Desarrollo Corporativo <br/>
Secretar�a Ejecutiva de la Red de Universidades An�huac
</p>
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
	
}

?>