<?php
require 'config.php';
require 'core/dbaccess.php';


if(!isset($_SESSION)){

session_start();


 if(!empty($_SESSION)){
$campos = array('ACTIVO'=>0,
							    );
		$user = $_SESSION['session']['user'];
		$condition = "PK1 = '$user' ";
		database::updateRecords("PL_USUARIOS",$campos,$condition);


$campos = array(
	              'APLICACION'=>'SISTEMA',
			      'MODULO'=>'SALIDA',
				  'MENSAJE'=>'LOGOUT SISTEMA',
				  'PK_USUARIO'=>$_SESSION['session']['user'],
				  'FECHA_R'=>date("Y-m-d H:i:s"),
							               );
//database::insertRecords("PL_ACTIVIDAD_USUARIO",$campos);


session_destroy();
session_unset();

 }
}

header('Location:index.php');
exit;

?>