<?php
/**
 * Config
 *
 * Core system configuration file
 *
 * @package		Aprende
 * @author		Ruiz Garcia Jose Carlos
 * @copyright	(c) 2012 Portal Aprende
 * @license		http://www.cte.anahuac.mx/license
 ********************************** 80 Columns *********************************
 */


/*define('HOST','172.19.11.38');//claradb.database.windows.net
define('DB', 'prospectos');
define('USERDB', 'sqladminclara');
define('PWDDB', 'C@rlos6132000');
define('TYPE', 'sqlsrv');*/


define('HOST','claradbp.database.windows.net');//claradbp.database.windows.net  service-claradb.database.windows.net
define('DB', 'prospectos-php73');//prospectos    prospectos-prod
define('USERDB', 'testprospecto');//adminserver    claradb-01
define('PWDDB', 'Pr0sp3ct0-t3sT');//U_p1ck_1T      Cl@r@-DB-01
define('TYPE', 'sqlsrv');


define('MODULO', 'usuarios\\');

# controladores
define('ADMIN', 'admin.class');
define('SET_USER', 'set');
define('GET_USER', 'get');
define('DELETE_USER', 'delete');
define('EDIT_USER', 'edit');


# vistas
define('VIEW_ADMIN', 'admin');
define('VIEW_SET_USER', 'agregar');
define('VIEW_GET_USER', 'buscar');
define('VIEW_DELETE_USER', 'borrar');
define('VIEW_EDIT_USER', 'modificar');

 $TreeMenuXL_PHPLIBPATH='\\libs\\tree\\';
/**/
define('RAIZ', dirname(__FILE__).'\\');

define('TEMPLATE',"views\\");
define('TEMPLATEADMIN',"skins\\admin\\");

//predifined fetch constants
define('MYSQL_BOTH',MYSQLI_BOTH);
define('MYSQL_NUM',MYSQLI_NUM);
define('MYSQL_ASSOC',MYSQLI_ASSOC);

$config['site_url'] = '\\';

// Enable debug mode?
$config['debug_mode'] = TRUE;

// Load boostrap file?
$config['bootstrap'] = FALSE;

// Available translations (Array of Locales)
$config['languages'] = array('es');

/**
 * Database
 *
 * This system uses PDO to connect to MySQL, SQLite, or PostgreSQL.
 */
$config['database'] = array(
	'dns' => "mysql:host=127.0.0.1;port=3306;dbname=micromvc",
	'username' => 'root',
	'password' => '',
	'host' => 'localhost',
	'dbname' => 'aprende',
	//'dns' => "pgsql:host=localhost;port=5432;dbname=micromvc",
	//'username' => 'postgres',
	//'password' => 'postgres',
	'params' => array()
);


/**
 * System Events
 */
$config['events'] = array(
	//'pre_controller'	=> 'Class::method',
	//'post_controller'	=> 'Class::method',
);

/**
 * Cookie Handling
 *
 */
$config['cookie'] = array(
	'key' => 'very-secret-key',
	'timeout' => time()+(60*60*4), // Ignore submitted cookies older than 4 hours
	'expires' => 0, // Expire on browser close
	'path' => '\\',
	'domain' => '',
	'secure' => '',
	'httponly' => '',
);

//$__forWindows = true;  

function __toHtml($string, $extra_1=ENT_QUOTES, $extra_2="ISO-8859-1")
{
	if (is_string($string))
		return htmlentities($string, $extra_1, $extra_2);
	else
		return 'string';
}

function __formatDate($obj)
{
	return $obj->format('d/m/Y');
}

function __formatDateTime($obj)
{
	// return date("d-m-Y",strtotime($obj));
	if(isset($obj))
		return $obj->format('d/m/Y, h:m:s');
	else
		return '---';
}

ini_set('session.cookie_httponly', 1);

// **PREVENTING SESSION FIXATION**
// Session ID cannot be passed through URLs
ini_set('session.use_only_cookies', 1);

// Uses a secure connection (HTTPS) if possible
ini_set('session.cookie_secure', 1);

$rutaActual='https://testprospectos.redanahuac.mx/';

error_reporting(E_ALL ^ E_NOTICE);

 ini_set('session.cookie_httponly', 1);
 ini_set('session.use_only_cookies', 1);
 ini_set('session.cookie_secure', 1); 
 
?>