<?php
require 'config.php';
require 'core/dbaccess.php';

$obj = databaseCheck::getInstance();

if($obj->connected){
	echo "OK";
}else{
	http_response_code(404);
}


class databaseCheck {
	
	
	public $pdo=false;
	public $type='mssql';
	public $username='';
	public $password='';
	public $host='localhost';
	public $database='';
	public $persistent=false;
	public $showErrors=false;
	public $queryCounter=0;
	public $connected=false;
	public $filas = '';
	public $error = '';
 
    private static $instance = null; 
    private $connection;
    var $queryCache = array();
    var $dataCache = array();
    var $result;
	public static $debug = '';
	 
    
    public static function getInstance() 

    { 
        if(self::$instance == null) 
        { 
            self::$instance = new self; 
        }    
        return self::$instance;          
    } 
    
	 
    
    public function __construct($type=TYPE,$host=HOST,$database=DB,$username=USERDB,$password=PWDDB,$showErrors=true,$persistent=false)
    {
    	$this->type=$type;
		$this->host=$host;
		$this->database=$database;
		$this->username=$username;
		$this->password=$password;
		$this->showErrors=$showErrors;
		$this->persistent=$persistent;
    	
         $this->newConnection();		
    }
 
 
    public function __destruct(){
		$this->dbDisconnect();
	}
 
    
    function newConnection()
    {
		 
	   switch($this->type){
			case 'mysql':
				
				if(extension_loaded('pdo_mysql')){
					$this->pdo=new PDO('mysql:'.$connectLine,$this->username,$this->password,array(PDO::ATTR_PERSISTENT=>$this->persistent,PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES \'UTF8\''));
					if($this->pdo){
						$this->connected=true;
					} else {
						
						$this->connected=false;
						$this->error = 'Cannot connect to database';
						
					}
				} else {
					
					   $this->connected=false;
					   $this->error = 'PDO MySQL extension not enabled';
					
				}
				break;
			case 'sqlite':
				
				if(extension_loaded('pdo_sqlite')){
					$this->pdo=new PDO('sqlite:'.$connectLine,$this->username,$this->password,array(PDO::ATTR_PERSISTENT=>$this->persistent));
					if($this->pdo){
						$this->connected=true;
					} else {
						$this->connected=false;
						$this->error = 'Cannot connect to database';
					}
				} else {
					
					$this->connected=false;
				    $this->error = 'PDO SQLite extension not enabled';
				}
				break;
			case 'postgresql':
				
				if(extension_loaded('pdo_pgsql')){
					$this->pdo=new PDO('pgsql:'.$connectLine,$this->username,$this->password,array(PDO::ATTR_PERSISTENT=>$this->persistent));
					if($this->pdo){
						$this->pdo->exec('SET NAMES \'UTF8\'');
						$this->connected=true;
					} else {
						$this->connected=false;
						$this->error = 'Cannot connect to database';
					}
				} else {
					
					$this->connected=false;
				    $this->error = 'PDO PostgreSQL extension not enabled';
				}
				break;
			case 'oracle':
				
				if(extension_loaded('pdo_oci')){
					$this->pdo=new PDO('oci:'.$connectLine.';charset=AL32UTF8',$this->username,$this->password,array(PDO::ATTR_PERSISTENT=>$this->persistent));
					if($this->pdo){
						$this->connected=true;
					} else {
						$this->connected=false;
						$this->error = 'Cannot connect to database';
					}
				} else {
					
					$this->connected=false;
					$this->error = 'PDO Oracle extension not enabled';
				}
				break;
			case 'mssql':
				
				if(extension_loaded('pdo_mssql')){
					$this->pdo=new PDO('dblib:'.$connectLine,$this->username,$this->password,array(PDO::ATTR_PERSISTENT=>$this->persistent));
					if($this->pdo){
						$this->pdo->exec('SET NAMES \'UTF8\'');
						$this->connected=true;
					} else {
						$this->connected=false;
						$this->error = 'Cannot connect to database';
					}
				} else if(extension_loaded('mssql')){
					
					
					if(!($this->connection = mssql_connect($this->host, $this->username, $this->password))){
		    
				        $this->connected=false;
						$this->error = 'Cannot connect to database';
				exit();
				
      
	  
                 }else{
	   	
		           mssql_select_db($this->database, $this->connection);
	   	
	              }
					

					
				}else if(extension_loaded('sqlsrv')){
				
									
				$connectionInfo = array( "Database"=>$this->database, "UID"=>$this->username, "PWD"=>$this->password);
				
				   $this->connection = sqlsrv_connect($this->host, $connectionInfo);
				   if($this->connection){
				   	
				   	$this->connected=true;
				   }else{
				   	$this->connected=false;
				    $this->error = 'Cannot connect to database';
                    //die(print_r( sqlsrv_errors(), true));
				   }
				   	 
					
				}
				
				break;
			default:
				
				trigger_error('This database type is not supported',E_USER_ERROR);
				break;
		}
	   
       
    }
 
      
       public function dbDisconnect($resetQueryCounter=false){
	
		
		if($this->connected && !$this->persistent){
			
			if($resetQueryCounter){
				$this->queryCounter=0;
			}
			$this->pdo=null;
			$this->connected=false;
			return true;
		} else {
			return false;
		}
		
	}
	

}




?>