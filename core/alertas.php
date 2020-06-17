<?php


class Alertas
    {	
    
	//Constructor
    function Alertas() {
       $this->passport = new Authentication();   
    }
      
	
	function getMensajes() {
    
       $usuario = $_SESSION['session']['user'];
	  
	    $this->mensajes = array();   
	    $sql = sprintf("SELECT * FROM PL_NOTIFICACIONES WHERE TIPO = 'ALERT' AND PK_USUARIO = '$usuario' ORDER BY FECHA_R"); 
	
        $result = database::executeQuery($sql);
 
    
         /*while ($r = mssql_fetch_array($result, MSSQL_ASSOC))  {
               
			   
                
		 }*/
		
		
		}



    function getNumAlertas(){
		
		$usuario = $_SESSION['session']['user'];
	    $sql = sprintf("SELECT * FROM PL_NOTIFICACIONES WHERE TIPO = 'ALERT' AND PK_USUARIO = '$usuario' AND VISTO='0' ORDER BY FECHA_R"); 
        $result = database::getNumRows($sql);
		
		return $result;
	}

   


    function getAlertas(){
		
		/*$usuario = $_SESSION['session']['user'];
		
		$alertas ="";
	    $sql = sprintf("SELECT * FROM PL_NOTIFICACIONES WHERE TIPO = 'ALERT' AND PK_USUARIO = '$usuario' ORDER BY VISTO, FECHA_R DESC"); 
	
        $result = database::executeQuery($sql);
        $rows = database::getNumRows($sql);
		 
		
		if($rows>0){
	   
	   
	   $alertas .='<ul id="themes" class="dropdown-menu"  style="width: 320px; height: 373px;  overflow-y: auto;">';
        
        while ($r = mssql_fetch_array($result, MSSQL_ASSOC))  {
               
			   $USER = $r['ENVIADO'];
			   $sql2 = "SELECT IMAGEN,concat(TITULO,' ',NOMBRE,' ',APELLIDOS) AS NOMBRE FROM PL_USUARIOS WHERE PK1='".$USER."'";   
		       
			   $rowu = database::getRow($sql2);
			   
			  
			   
			$alertas .='<li ';
			$imagen =  $rowu['IMAGEN'];    
				   
			if(trim($r['VISTO'])=="1"){ 
			  $objetivo = "<strike>".$r['OBJETIVO']."</strike>";
			  $fecha = "<strike>".$r['FECHA_R']."</strike>"; 
			   $nombre  = "<strike>".htmlentities($rowu['NOMBRE'])."</strike>";
			}else{ 
			 
			  $objetivo = $r['OBJETIVO'];
			  $fecha = $r['FECHA_R'];
			  $nombre  = htmlentities($rowu['NOMBRE']);
			}
		
			   $alertas .='><a href="javascript:void(0)" onclick="goAlerta(\''.$r['PK1'].'\');" data-value="cerulean"> 
						<img src="media/usuarios/'.$imagen.'" height="45" width="45"  style="margin-top: 6px; position: absolute;" alt="">
						<span style="margin-left: 48px; font-size: 11px;"><i class="icon-hand-right"></i> '.$objetivo.'</span><br/>
					    <span style="margin-left: 48px; font-size: 11px;"><i class="icon-user"></i> '.$nombre.'</span><br/>
						<span style="font-size: 10px; margin-left: 48px;"><i class="icon-time"></i> '.$fecha.'</span>
						</a>
						</li>
						<li class="divider"></li>';
		 	}
			
		
		$alertas .='</ul>';	
		}else{
		$alertas .='<ul id="themes" class="dropdown-menu"  style="width: 300px; height:60px;  overflow-y: auto;">';
		$alertas .='<li><a data-value="cerulean"  href="javascript:void(0)"> 
						<span style="margin-top: 18px; position: absolute;" class="icon icon-red icon-time"></span> 
						<br/>
					    <span style="margin-left: 18px; font-size: 11px;">&nbsp; No existen alertas por el momento....</span><br>
						<br/>
						</a>
						</li>';
		$alertas .='</ul>';	
		}
		
		*/
		return "0";
			
		
	}        
		
  
  
      
    
	
}
 
   
?>