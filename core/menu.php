<?php

/**
 * Menu
 *
 * Menu system file
 *
 * @package		App
 * @author		Ruiz Garcia Jose Carlos
 * @copyright	(c) 2012 Red de Universidades Anáhuac
 * @license		http://www.redanahuac.mx/license
 *******************************************************************
 */


class Menu
{
    var $menu;
	
    //Constructor
    function Menu($idmenu="",$idsubmenu="") {
       $this->passport = new Authentication();
       $this->menu = $this->initMenu(0 ,false,$idmenu,$idsubmenu);
       
       
    }
    
    
      
	function initMenu($nivel = 0 ,$submenu = false,$idmenu="",$idsubmenu="") {
    
	$idmenu =  (isset($_GET['Menu'])) ? $_GET['Menu'] : $idmenu;
	$idsubmenu =  (isset($_GET['SubMenu'])) ? $_GET['SubMenu'] : $idsubmenu;
	
	
    $lista = '<ul';
	
	if(!$submenu){ $lista .= ' class="Menu">'; }else{ $lista .= ' class="subMenu">'; }
 
    // Obtenemos los datos los dependientes del nivel solicitado
        $sql = sprintf("SELECT PK1, NOMBRE,URL, PADRE,PK_PERMISO,NEW FROM PL_FICHAS WHERE PADRE = '$nivel' ORDER BY ORDEN"); 
        
      $rows = database::getRows($sql);
      
      // Para cada dependiente del nivel solicitado...
      foreach ($rows as $r) { 
    
 
        // Abrimos el nodo con el nombre del primer dependiente
        $lista .= '<li';
		
		
		if($r['NEW']){ $target='target="_blank"'; }else{  $target='';}

		if(!$submenu){//Agregamos las Fichas superiores del Menu
		
		
		
		//Validamos si tiene permiso
		if($this->passport->privilegios->hasPrivilege($r['PK_PERMISO'])){
		
		
		
		if($idmenu==$r['PK1']){ $lista .= ' id="active"><a href="'.$r['URL'].'"  '.$target.' class="none">'.htmlentities($r['NOMBRE'], ENT_QUOTES, "ISO-8859-1").'</a>'; 
		}
		else{ $lista .= ' id="inactive"><a href="'.$r['URL'].'"  '.$target.'>' .htmlentities($r['NOMBRE'], ENT_QUOTES, "ISO-8859-1"). '</a>';
		}
        
		}
		
		}
		else
		{
			
		if($this->passport->privilegios->hasPrivilege($r['PK_PERMISO'])){
			
			
		if($idsubmenu==$r['PK1']){ $lista .= ' id="subActive"><a href="'.$r['URL'].'" '.$target.'>'.htmlentities($r['NOMBRE'], ENT_QUOTES, "ISO-8859-1"). '</a>';}
		
		else{ $lista .= ' id="subInActive"><a href="'.$r['URL'].'" '.$target.'>'.htmlentities($r['NOMBRE'], ENT_QUOTES, "ISO-8859-1"). '</a>'; }
		
		  }
		}
        
		
		
		// Utilizaremos esta variable para ver si seguimos consultado la BDD
        $tiene_dependientes = null;
        
		$id = $r['PK1'];
        $sql = sprintf("SELECT * FROM PL_FICHAS WHERE PADRE = '$id'"); 
        $tiene_dependientes = database::getNumRows($sql);
        
        
        
        // Si tiene dependientes, ejecutamos recursivamente
        // tomando como parámetro el nuevo nivel
        if ($tiene_dependientes > 0) {
             

	    if($idmenu==$r['PK1']){
	    	
            $lista .= $this->initMenu($r['PK1'],TRUE,$idmenu,$idsubmenu);
			}
        }
 
        // Cerramos el nodo
        $lista .= '</li>';
    }
 
    // Cerramos la lista
    $lista .= '</ul>';
	 

	return $lista;		
		
    
}


   
}
?>