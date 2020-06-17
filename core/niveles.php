<?php
/**
 * Niveles
 *
 * Niveles system file
 *
 * @package		App
 * @author		Ruiz Garcia Jose Carlos
 * @copyright	(c) 2012 Red de Universidades Anáhuac
 * @license		http://www.redanahuac.mx/license
 *******************************************************************
 */


require_once("libs/tree/TreeMenuXL.php");

class Niveles
{
    var $nodos;
	var $menu;
	var $nodo;
	var $nodeProperties;
	var $nodo_Principal;
	var $nodosusuario;
	var $nodosreportes;
	var $type;
	var $nodospermitidos;
	var $passport;
	

    //Constructor
	function Niveles($tipo="",$reporte=FALSE) {

	   $this->type = $reporte;
       
	   $this->passport = new Authentication();
	   
	   $this->NivelesUsuario($_SESSION['session']['user']);

	   

	   if(isset($_GET['user'])){ $this->NivelesReportesUsuario($_GET['user']); }else{ 

         
	   	$this->NivelesReportesUsuario($_SESSION['session']['user']);  }


	   
	   
       switch($tipo){
	   	case "filtro":
		$this->nodos = $this->initNivelesFiltro();
	   		break;

	   	case "reportes":
		$this->nodos = $this->initNivelesReportes();
	   		break;
			
		case "option":
		$this->nodos = $this->initNivelesOption();
	   		break;
			
		case "move":
		$this->nodos = $this->initNivelesMove();
	   		break;
	   		
	   case "documentos":
		$this->nodos = $this->initNivelesDocumentos();
	   		break;	
	   		
	   
	    case "documentosempresas":
		$this->nodos = $this->initNivelesDocumentosEmpresas();
	   		break;	
	   		
	   	 case "documentosreportes":
		$this->nodos = $this->initNivelesDocumentosReportes();
	   		break;	
	   
			
	   	default:
		$this->nodos = $this->initNiveles();
	   		break;
	   }
	   
    }
	
	
	function NivelesUsuario($user){
		
		$this->nodosusuario = array();
		$sql = "SELECT PK_JERARQUIA FROM PL_USUARIOS_JERARQUIA WHERE PK_USUARIO = '$user'";
		$rows = database::getRows($sql);
		
	    foreach ($rows as $row) { 
	    $this->nodosusuario[] = $row['PK_JERARQUIA'];
        }
		
	}

	// revisamos si tiene asignado el nivel
    function hasNivel($nivel) {
        return in_array($nivel, $this->nodosusuario); //isset($this->nodosusuario[$nivel]);
    }



    /*+++++REPORTES***/

    function NivelesReportesUsuario($user){
		
		$this->nodosreportes = array();
		$sql = "SELECT PK_JERARQUIA FROM PL_REPORTES_JERARQUIA WHERE PK_USUARIO = '$user'";
		$rows = database::getRows($sql);
		
         

	    foreach ($rows as $row) { 
	    $this->nodosreportes[] = $row['PK_JERARQUIA'];
        }
		
	}	


	 function hasNivelReporte($nivel) {
        return in_array($nivel, $this->nodosreportes); //isset($this->nodosusuario[$nivel]);
    }
	
	
	function NivelesUsuarioPermitidos($user){
		
		$this->nodospermitidos = array();
		$sql = "SELECT PK_JERARQUIA FROM PL_USUARIOS_JERARQUIA WHERE PK_USUARIO = '$user'";
		
		$rows = database::getRows($sql);
	    foreach ($rows as $row) { 
	    $this->nodospermitidos[] = $row['PK_JERARQUIA'];
	    }
		
	}

	// revisamos si tiene asignado el nivel
    function hasNivelPermitido($nivel) {
        return in_array($nivel, $this->nodospermitidos); //isset($this->nodosusuario[$nivel]);
    }
	
	  
	
	
	
	function initNiveles($nivel = "0"){
		
	$menu  = new HTML_TreeMenuXL();
    $this->nodeProperties = array("icon"=>"nodo.png"); 
	
    $sql = sprintf("SELECT PK1, NOMBRE,DESCRIPCION, PADRE,DISPONIBLE,FECHA_R,ORDEN FROM PL_JERARQUIAS WHERE PADRE = '$nivel' ORDER BY ORDEN");
	
	$rows = database::getRows($sql);
	
	$i=1;
	foreach ($rows as $row) {
	 
	$nodo = 'nodo'.$i; 
	  
    $$nodo = new HTML_TreeNodeXL(htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1"), "?execute=jerarquia&Menu=F3&SubMenu=SF34&method=default&Nivel=".$row['PK1']."#&p=1&s=25&sort=1&q=", $this->nodeProperties); 
    $this->initSubNiveles($row['PK1'],$$nodo);
    $menu->addItem($$nodo);
		
	}
	
	$arbol = new HTML_TreeMenu_DHTMLXL($menu, array("images"=>"libs/tree/TMimages"));  
    $nodos = $arbol->toHTML();
	 
	return $nodos;	
   
	  
	}
	  
	  
	function initSubNiveles($padre, &$nodo) { 
   $sql="SELECT * FROM PL_JERARQUIAS WHERE PADRE = '$padre' ORDER BY ORDEN"; 
     
   $rows = database::getRows($sql);
 
     $i=0; 
   foreach ($rows as $row) { 
    $i++;
	$subNode='subNode'.$i;
     $$subNode=&$nodo->addItem(new HTML_TreeNodeXL(htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1"), "?execute=jerarquia&method=default&Menu=F3&SubMenu=SF34&Nivel=".$row['PK1']."#&p=1&s=25&sort=1&q=",
    $this->nodeProperties)); 
      $this->initSubNiveles($row['PK1'],$$subNode);
   } 
}
	  
	  
	 	  
	  
	 function initNivelesFiltro($nivel = "0"){
    
	$menu  = new HTML_TreeMenuXL();
    $this->nodeProperties = array("icon"=>"nodo.png"); 
	
    $sql = sprintf("SELECT PK1, NOMBRE,DESCRIPCION, PADRE,DISPONIBLE,FECHA_R,ORDEN FROM PL_JERARQUIAS WHERE PADRE = '$nivel' ORDER BY ORDEN");
    
    
    $rows = database::getRows($sql);	
	$i=1;
	foreach ($rows as $row) { 
	
	$nodo = 'nodo'.$i;	
    $$nodo = new HTML_TreeNodeXL("<input type='checkbox' name=\"niveles[]\" value=\"".$row['PK1']."\" id='".$row['PK1']."' onClick='filtrar(this.id)'>&nbsp;".htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1"), "", $this->nodeProperties); 
    
	 
	$this->initSubNivelesFiltro($row['PK1'],$$nodo);
    $menu->addItem($$nodo);
		
	}
	
	$arbol = new HTML_TreeMenu_DHTMLXL($menu, array("images"=>"libs/tree/TMimages"));  
    $nodos = $arbol->toHTML();
	 
	return $nodos;	 
	  
	} 
	
	
	function initSubNivelesFiltro($padre, &$nodo){
	
      
       $sql="SELECT * FROM PL_JERARQUIAS WHERE PADRE = '$padre' ORDER BY ORDEN"; 
       $rows = database::getRows($sql);
   
       $user = $nombre = $_SESSION['session']['user'];
       $nivel = (isset($_GET['nodo'])) ? $_GET['nodo'] : $_SESSION['session']['nodo'];
	   
	
	   if(isset($_GET['nodo'])){ $this->NivelesUsuarioPermitidos($_GET['user']); }
	
       $i=0; 
       
       foreach ($rows as $row) { 
       $i++;
	   $subNode='subNode'.$i;
        
	 
	   if($this->hasNivel($row['PK1']) || isset($this->passport->privilegios->roles['R00']) ){
	 	
		$checkbox = "<input type='checkbox' name=\"niveles[]\" ";
		
		if(isset($_GET['nodo'])){
			
			if($this->hasNivelPermitido($row['PK1'])){
			 $checkbox .= "checked=\"checked\" ";	
			}
			   
		}else{
		    if($nivel==$row['PK1']){
		    $checkbox .= "checked=\"checked\" ";	
		    }	
		}
		
		$checkbox .= " value=\"".$row['PK1']."\" id='".$row['PK1']."' onClick='filtrar(this.id)'>";


        //VALIDAMOS PARA REPORTES

        if($this->type==TRUE){  



                  if(!$this->hasNivelReporte($row['PK1'])){

                  	   $checkbox ="";
			           	
		           }

        }



		$checkbox .= "&nbsp;".htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1");
		
     $$subNode=&$nodo->addItem(new HTML_TreeNodeXL($checkbox, "",$this->nodeProperties));      
	 
	 }
	 
      $this->initSubNivelesFiltro($row['PK1'],$$subNode);
   } 
}




function initNivelesReportes($nivel = "0"){
    
	$menu  = new HTML_TreeMenuXL();
    $this->nodeProperties = array("icon"=>"nodo.png"); 
	
    $sql = sprintf("SELECT PK1, NOMBRE,DESCRIPCION, PADRE,DISPONIBLE,FECHA_R,ORDEN FROM PL_JERARQUIAS WHERE PADRE = '$nivel' ORDER BY ORDEN");
    
    
    $rows = database::getRows($sql);	
	$i=1;
	foreach ($rows as $row) { 
	
	$nodo = 'nodo'.$i;	
    $$nodo = new HTML_TreeNodeXL("<input type='checkbox' name=\"reportes[]\"  value=\"".$row['PK1']."\" id='".$row['PK1']."' >&nbsp;".htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1"), "", $this->nodeProperties); 
    
	 
	$this->initSubNivelesReportes($row['PK1'],$$nodo);
    $menu->addItem($$nodo);
		
	}
	
	$arbol = new HTML_TreeMenu_DHTMLXL($menu, array("images"=>"libs/tree/TMimages"));  
    $nodos = $arbol->toHTML();
	 
	return $nodos;	 
	  
	} 
	
	
	function initSubNivelesReportes($padre, &$nodo) { 
	
      
       $sql="SELECT * FROM PL_JERARQUIAS WHERE PADRE = '$padre' ORDER BY ORDEN"; 
       $rows = database::getRows($sql);
   
       $user =  $_SESSION['session']['user'];
       
	   
	
       $i=0; 
       
       foreach ($rows as $row) { 
       $i++;
	   $subNode='subNode'.$i;
        
	 
	   if($this->hasNivel($row['PK1']) || isset($this->passport->privilegios->roles['R00']) ){
	 	
		$checkbox = "<input type='checkbox' name=\"reportes[]\" ";
		
		
			
	   if($this->hasNivelReporte($row['PK1'])){
			 $checkbox .= "checked=\"checked\" ";	
		}
			   
	
		
		
		$checkbox .= " value=\"".$row['PK1']."\" id='".$row['PK1']."'>&nbsp;".htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1");
		
     $$subNode=&$nodo->addItem(new HTML_TreeNodeXL($checkbox, "",$this->nodeProperties));      
	 
	 }
	 
      $this->initSubNivelesReportes($row['PK1'],$$subNode);
   } 
}
	
	
	
	function initNivelesOption($nivel = "0"){
 
    
	$menu  = new HTML_TreeMenuXL();
    $this->nodeProperties = array("icon"=>"nodo.png"); 
	
    $sql = sprintf("SELECT PK1, NOMBRE,DESCRIPCION, PADRE,DISPONIBLE,FECHA_R,ORDEN FROM PL_JERARQUIAS WHERE PADRE = '$nivel' ORDER BY ORDEN");
    
    
    $rows = database::getRows($sql);
	
	$i=1;
	foreach ($rows as $row) { 
	 
	$nodo = 'nodo'.$i; 
	  
    $$nodo = new HTML_TreeNodeXL("<input type='radio' name='jerarquia' value='".$row['PK1']."' />&nbsp;".htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1"), "", $this->nodeProperties); 
    $this->initSubNivelesOption($row['PK1'],$$nodo);
    $menu->addItem($$nodo);
		
	}
	
	$arbol = new HTML_TreeMenu_DHTMLXL($menu, array("images"=>"libs/tree/TMimages"));  
    $nodos = $arbol->toHTML();
	 
	return $nodos;	 	 
	  
	} 
	 
	  
	function initSubNivelesOption($padre, &$nodo) { 
        
		$nivel = (isset($_GET['nodo'])) ? $_GET['nodo'] : $_SESSION['session']['nodo'];
		$user = $nombre = $_SESSION['session']['user'];
	    
		$sql="SELECT * FROM PL_JERARQUIAS WHERE PADRE = '$padre' ORDER BY ORDEN"; 
        $rows = database::getRows($sql);
   
    
        $i=0; 
        foreach ($rows as $row) { 
        $i++;
	$subNode='subNode'.$i;
 
        if($this->hasNivel($row['PK1']) || isset($this->passport->privilegios->roles['R00']) ){
	 	
		$checkbox = "<input type='radio' name='jerarquia' ";
		
		if($nivel==$row['PK1']){
		$checkbox .= "checked=\"checked\" ";	
		}
		
		$checkbox .= " value=\"".$row['PK1']."\" id='".$row['PK1']."' >&nbsp;".htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1");
		
     $$subNode=&$nodo->addItem(new HTML_TreeNodeXL($checkbox, "",$this->nodeProperties));      
	 
	 }
		
		
		//$$subNode=&$nodo->addItem(new HTML_TreeNodeXL("<input type='radio' name='jerarquia' value='".$row['PK1']."' />&nbsp;".$row['NOMBRE'], "",$this->nodeProperties)); 
		
		
		
        $this->initSubNivelesOption($row['PK1'],$$subNode);
        } 
}





function initNivelesMove($nivel = "0"){
 
    
	$menu  = new HTML_TreeMenuXL();
    $this->nodeProperties = array("icon"=>"nodo.png"); 
	
	
    $sql = sprintf("SELECT PK1, NOMBRE,DESCRIPCION, PADRE,DISPONIBLE,FECHA_R,ORDEN FROM PL_JERARQUIAS WHERE PADRE = '$nivel' ORDER BY ORDEN");
  //  $result = database::executeQuery($sql);
	
	$i=1;
	//while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
	foreach(database::getRows($sql) as $row){ 
	
	 
	$nodo = 'nodo'.$i; 
	  
   
	  if($this->hasNivel($row['PK1']) || isset($this->passport->privilegios->roles['R00']) ){
	 	
		$checkbox = "<input type='radio' name='jerarquia' ";
		
		if($row['PK1']==$_GET['Padre']){
		$checkbox .= "checked=\"checked\" ";	
		}
		
		$checkbox .= " value=\"".$row['PK1']."\" id='".$row['PK1']."' >&nbsp;".htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1");
		$$nodo = new HTML_TreeNodeXL($checkbox, "", $this->nodeProperties); 
	 
	    }
	
	

	$this->initSubNivelesMove($row['PK1'],$$nodo);
    $menu->addItem($$nodo);
		
	}
	
	$arbol = new HTML_TreeMenu_DHTMLXL($menu, array("images"=>"libs/tree/TMimages"));  
    $nodos = $arbol->toHTML();
	 
	return $nodos;	 	 
	  
	} 
	 
	  
	  
	  
	function initSubNivelesMove($padre, &$nodo) { 
        
		$nivel = (isset($_GET['nodo'])) ? $_GET['nodo'] : $_SESSION['session']['nodo'];
		$user = $nombre = $_SESSION['session']['user'];
	    
		$sql="SELECT * FROM PL_JERARQUIAS WHERE PADRE = '$padre' ORDER BY ORDEN"; 
       // $result = database::executeQuery($sql);
   
    
        $i=0; 
        //while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) { 
		foreach(database::getRows($sql) as $row){ 
        $i++;
	    $subNode='subNode'.$i;
 
        if($this->hasNivel($row['PK1']) || isset($this->passport->privilegios->roles['R00']) ){
	 	
		$checkbox = "<input type='radio' name='jerarquia' ";
		
		if($row['PK1']==$_GET['Padre']){
		$checkbox .= "checked=\"checked\" ";	
		}
		
		$checkbox .= " value=\"".$row['PK1']."\" id='".$row['PK1']."' >&nbsp;".htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1");
		
        $$subNode=&$nodo->addItem(new HTML_TreeNodeXL($checkbox, "",$this->nodeProperties));      
	 
	    }
		
	
        $this->initSubNivelesMove($row['PK1'],$$subNode);
        } 
}




function initNivelesDocumentos($nivel = "0"){
		
	$menu  = new HTML_TreeMenuXL();
    $this->nodeProperties = array("icon"=>"nodo.png"); 
	
    $sql = sprintf("SELECT PK1, NOMBRE,DESCRIPCION, PADRE,DISPONIBLE,FECHA_R,ORDEN FROM PL_JERARQUIAS WHERE PADRE = '$nivel' ORDER BY ORDEN");
	
	$rows = database::getRows($sql);
	
	$i=1;
	foreach ($rows as $row) {
	 
	$nodo = 'nodo'.$i; 
	  
    $$nodo = new HTML_TreeNodeXL(htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1"), "?execute=documentos/alumnos&Menu=F4&SubMenu=SF41&method=default&Nivel=".$row['PK1']."#&p=1&s=25&sort=1&q=", $this->nodeProperties); 
    $this->initSubNivelesDocumentos($row['PK1'],$$nodo);
    $menu->addItem($$nodo);
		
	}
	
	$arbol = new HTML_TreeMenu_DHTMLXL($menu, array("images"=>"libs/tree/TMimages"));  
    $nodos = $arbol->toHTML();
	 
	return $nodos;	
   
	  
	}
	  
	  
	function initSubNivelesDocumentos($padre, &$nodo) { 
   $sql="SELECT * FROM PL_JERARQUIAS WHERE PADRE = '$padre' ORDER BY ORDEN"; 
     
   $rows = database::getRows($sql);
 
     $i=0; 
   foreach ($rows as $row) { 
    $i++;
	$subNode='subNode'.$i;
     $$subNode=&$nodo->addItem(new HTML_TreeNodeXL(htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1"), "?execute=documentos/alumnos&method=default&Menu=F4&SubMenu=SF41&Nivel=".$row['PK1']."#&p=1&s=25&sort=1&q=",
    $this->nodeProperties)); 
      $this->initSubNivelesDocumentos($row['PK1'],$$subNode);
   } 
}



function initNivelesDocumentosEmpresas($nivel = "0"){
		
	$menu  = new HTML_TreeMenuXL();
    $this->nodeProperties = array("icon"=>"nodo.png"); 
	
    $sql = sprintf("SELECT PK1, NOMBRE,DESCRIPCION, PADRE,DISPONIBLE,FECHA_R,ORDEN FROM PL_JERARQUIAS WHERE PADRE = '$nivel' ORDER BY ORDEN");
	
	$rows = database::getRows($sql);
	
	$i=1;
	foreach ($rows as $row) {
	 
	$nodo = 'nodo'.$i; 
	  
    $$nodo = new HTML_TreeNodeXL(htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1"), "?execute=documentos/organizaciones&Menu=F4&SubMenu=SF41&method=default&Nivel=".$row['PK1']."#&p=1&s=25&sort=1&q=", $this->nodeProperties); 
    $this->initSubNivelesDocumentosEmpresas($row['PK1'],$$nodo);
    $menu->addItem($$nodo);
		
	}
	
	$arbol = new HTML_TreeMenu_DHTMLXL($menu, array("images"=>"libs/tree/TMimages"));  
    $nodos = $arbol->toHTML();
	 
	return $nodos;	
   
	  
	}
	  
	  
	function initSubNivelesDocumentosEmpresas($padre, &$nodo) { 
   $sql="SELECT * FROM PL_JERARQUIAS WHERE PADRE = '$padre' ORDER BY ORDEN"; 
     
   $rows = database::getRows($sql);
 
     $i=0; 
   foreach ($rows as $row) { 
    $i++;
	$subNode='subNode'.$i;
     $$subNode=&$nodo->addItem(new HTML_TreeNodeXL(htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1"), "?execute=documentos/organizaciones&method=default&Menu=F4&SubMenu=SF41&Nivel=".$row['PK1']."#&p=1&s=25&sort=1&q=",
    $this->nodeProperties)); 
      $this->initSubNivelesDocumentosEmpresas($row['PK1'],$$subNode);
   } 
}


	
	
	
	function initNivelesDocumentosReportes($nivel = "0"){
		
	$menu  = new HTML_TreeMenuXL();
    $this->nodeProperties = array("icon"=>"nodo.png"); 
	
    $sql = sprintf("SELECT PK1, NOMBRE,DESCRIPCION, PADRE,DISPONIBLE,FECHA_R,ORDEN FROM PL_JERARQUIAS WHERE PADRE = '$nivel' ORDER BY ORDEN");
	
	$rows = database::getRows($sql);
	
	$i=1;
	foreach ($rows as $row) {
	 
	$nodo = 'nodo'.$i; 
	  
    $$nodo = new HTML_TreeNodeXL(htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1"), "?execute=documentos/reportes&Menu=F4&SubMenu=SF41&method=default&Nivel=".$row['PK1']."#&p=1&s=25&sort=1&q=", $this->nodeProperties); 
    $this->initSubNivelesDocumentosReportes($row['PK1'],$$nodo);
    $menu->addItem($$nodo);
		
	}
	
	$arbol = new HTML_TreeMenu_DHTMLXL($menu, array("images"=>"libs/tree/TMimages"));  
    $nodos = $arbol->toHTML();
	 
	return $nodos;	
   
	  
	}
	  
	  
	function initSubNivelesDocumentosReportes($padre, &$nodo) { 
   $sql="SELECT * FROM PL_JERARQUIAS WHERE PADRE = '$padre' ORDER BY ORDEN"; 
     
   $rows = database::getRows($sql);
 
     $i=0; 
   foreach ($rows as $row) { 
    $i++;
	$subNode='subNode'.$i;
     $$subNode=&$nodo->addItem(new HTML_TreeNodeXL(htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1"), "?execute=documentos/reportes&method=default&Menu=F4&SubMenu=SF41&Nivel=".$row['PK1']."#&p=1&s=25&sort=1&q=",
    $this->nodeProperties)); 
      $this->initSubNivelesDocumentosReportes($row['PK1'],$$subNode);
   } 
}
 
   
}
?>