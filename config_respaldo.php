<?php
/**
 * Config
 *
 * Core system configuration file
 *
 * @package		App
 * @author		Ruiz Garcia Jose Carlos
 * @copyright	(c) 2012 Red de Universidades Anáhuac
 * @license		http://www.redanahuac.mx/license
 *******************************************************************
 */



/**
 * Database
 *
 * This system uses PDO to connect to MySQL, SQLite, or PostgreSQL, SQLSERVER , ORACLE.
 */
   
# Conexion DB
// define('HOST','service-claradb.database.windows.net');	
// define('DB', 'planeacion-prod');
// define('USERDB', 'planeacion');
// define('PWDDB', '*******');
// define('TYPE', 'mssql');

define('HOST','tcp:claradbp.database.windows.net,1433');
define('DB', 'planeacion');
define('USERDB', 'planeacion2');
define('PWDDB', 'Pl@n3ac10n02');
define('TYPE', 'mssql');

# STORAGE AZURE
//TEST
define('STORAGE_ACCOUNT_CONTAINER', 'https://seruabackup.blob.core.windows.net');
define('CONTAINER_NAME', 'docs-planeacion');
define('CONNECTION_STRING', 'DefaultEndpointsProtocol=https;AccountName=seruabackup;AccountKey=mno/n6tZ+eP5FCzgwip1r44+gxDmuA13UfebKn23/qQBJ5PQ34M5KMyjSc5kzwwwGGJ72KfxjP4nN38047eNAg==;');
define('KEY_ACCESS_BLOBS','?sv=2018-03-28&si=docs-planeacion-1697E9B3AB3&sr=c&sig=6mRMpNQ2SOvpwscWt7MljXyNaaPwLPS2cdMN3ARK6mQ%3D');


//PRODUCCIÓN
// define('STORAGE_ACCOUNT_CONTAINER', 'https://claradocs.blob.core.windows.net');
// define('CONTAINER_NAME', 'docs-planeacion');
// define('CONNECTION_STRING', 'DefaultEndpointsProtocol=https;AccountName=claradocs;AccountKey=WBOhWmzKoYuw8sRJlYtdwBIE1k1cXGub9H1dgIJUpWpRlfZY02ZL+ZZjSKkWWaS/dipI/5+eZHsjnDmwMnKaGg==;');
// define('KEY_ACCESS_BLOBS','?sv=2018-03-28&si=docs-planeacion-16A99300774&sr=c&sig=MqK7a4s%2BFE3rfLtDF5G6G6k3oun%2FqfT8AnUlCJClDxE%3D');

// define('APPDIRECTORY', '\\app\\planeacion\\');
define('APPDIRECTORY', '\\planeacion\\');


define('RAIZ', dirname(__FILE__).'\\');

define('TEMPLATE',"views\\");
define('TEMPLATEADMIN',"skins\\admin\\");


/*register_shutdown_function( "check_for_fatal" );
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );
ini_set( "display_errors", "off" );*/
error_reporting( E_ALL );


ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

date_default_timezone_set("America/Mexico_City");

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 3000);

ini_set('session.cookie_httponly', 1);

// **PREVENTING SESSION FIXATION**
// Session ID cannot be passed through URLs
ini_set('session.use_only_cookies', 1);

// Uses a secure connection (HTTPS) if possible
ini_set('session.cookie_secure', 1);



$config['site_url'] = '\\';

$config['app_dir'] = '\\planeacion';

$config['error_page'] = 'error.app';




// Enable debug mode?
$config['debug'] = TRUE;

// Load boostrap file?
$config['bootstrap'] = FALSE;

// Available translations (Array of Locales)
$config['languages'] = array('es');

$nameHost='https://testplaneacion.redanahuac.mx/';


?>