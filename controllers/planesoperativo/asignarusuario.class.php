<?php
include "models/planesoperativo/asignarusuario.model.php";


class asignarusuario {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $nodoprincipal;
	var $image;
	var $targetPathumbail;
	

	function asignarusuario() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->Model = new asignarusuarioModel();
		
	 switch($_GET['method']){
	 	
		
		case "Buscar":
			$this->Buscar();
			break;
			
		
	 	
		case "GuardarUsuario":
			$this->GuardarUsuario();
			break;
			
		default:	
	      $this->View = new View(); 
          $this->loadPage();
		  break;
		}
				 
		 
	}
	
	
	
	 function loadPage(){
	
		$this->View->template = TEMPLATE.'FRMPRINCIPAL.TPL';	
		$this->View->loadTemplate();
        $this->loadHeader();		
		$this->loadMenu();
		
		if($this->passport->privilegios->hasPrivilege('P12')){
		$this->loadContent();
		}else{
		$this->error();
		}
		$this->loadFooter();
		$this->View->viewPage();
		
	 }
	 
	 
	  function loadHeader(){
	  $section = TEMPLATE.'sections/header.tpl';
	  $section = $this->View->loadSection($section);
	  $nombre = $_SESSION['session']['titulo'].' '.htmlentities($_SESSION['session']['nombre']).' '.htmlentities($_SESSION['session']['apellidos']);
	  $imagen = 'thum_40x40_'.$_SESSION['session']['imagen'];
	  $section = $this->View->replace('/\#AVATAR\#/ms' ,$imagen,$section);
	  $section = $this->View->replace('/\#USUARIO\#/ms' ,$nombre,$section);
	  $this->View->replace_content('/\#HEADER\#/ms' ,$section);
	  }
	 
	 
	 function loadFooter(){
      $section = TEMPLATE.'sections/footer.tpl';
	  $section = $this->View->loadSection($section);
	  $this->View->replace_content('/\#FOOTER\#/ms' ,$section);
	 }
	 
	 
	
	 function loadMenu(){
	 $menu =  $this->menu->menu; 
	 $this->View->replace_content('/\#MENU\#/ms' ,$menu);
	 }
	 
	

	function error(){
		
		$contenido = $this->View->Template(TEMPLATE.'modules/error.tpl');
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
	}


  
	 function loadContent(){
	 	
		$contenido = $this->View->Template(TEMPLATE.'modules/planesoperativo/ASIGNARUSUARIO.TPL');
		
		
	  $url = "?execute=planesoperativo/asignaciones&method=default&Menu=F2&SubMenu=SF21&IDPlan=".$_GET['IDPlan']."&IDJerarquia=".$_GET['IDJerarquia']."#&p=1&s=25&sort=1&q=";
		
		$roles = "";
		$this->Model->obtenerRoles();
		foreach($this->Model->roles as $row){
		$roles .= '<option value="'.$row['PK1'].'">'.htmlentities($row['ROLE'], ENT_QUOTES, "ISO-8859-1").'</option>';
		}
		
		$contenido =  $this->View->replace('/\#ROLES\#/ms' ,$roles,$contenido);	
		
		
		$contenido =  $this->View->replace('/\#URLCANCELAR\#/ms' ,$url,$contenido);
		
		$contenido =  $this->View->replace('/\#IDPLAN\#/ms' ,$_GET['IDPlan'],$contenido);
		
		$contenido =  $this->View->replace('/\#JERARQUIA\#/ms' ,$_GET['IDJerarquia'],$contenido);
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 
		 }
	 

         function GuardarUsuario(){
		    $usuarios  = explode(",",$_POST['usuarios']);
			
			$this->Model->poperativo = $_POST['idplan'];
			$this->Model->usuarios = $usuarios;
			$this->Model->rol = $_POST['roles'];
			$this->Model->jerarquia = $_POST['jerarquia'];
			
	      	$this->Model->GuardarUsuario();
			

          }
		  
		  

	
	
	  function Buscar(){
		
		$this->Model->buscarUsuarios();
		$recurso = $this->getPaginadoHeader();
		$recurso .= "#%#";
	
		$numrecursos = sizeof($this->Model->usuarios);
		$total = $this->Model->totalnum;
		
		if($numrecursos != 0){
			
		foreach($this->Model->usuarios as $row){
			
		$imagen = ($row['IMAGEN'] == "avatar.jpg") ? "user.png" : "thum_40x40_".$row['IMAGEN'];
			
			
			 if($row['DISPONIBLE']==0){ $clase = 'class="nodisponible"'; }else{ $clase = " "; }
			
		     if($row['DISPONIBLE']!=0 || $this->passport->privilegios->hasPrivilege('P39')){  
			 	
			 $recurso .= '<tr '.$clase.'>
								<td><input type="checkbox" name="user" id="'.$row['PK1'].'" /></td>
								<td><img src="media/usuarios/'.$imagen.'" widht="40" height="40"  title="Imagen"></td>
								<td><h3>'.htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1").'</h3></td>
								<td><h3>'.htmlentities($row['APELLIDOS'], ENT_QUOTES, "ISO-8859-1").'</h3></td>
								
								<td><h3>'.htmlentities($row['PK_JERARQUIA'], ENT_QUOTES, "ISO-8859-1").'</td>
								
							</tr>';
							
							}
			}	
		
		$recurso .= "#%#";
		$recurso .= $this->getpaginadoFooter();
		$recurso .= "#%#";
		$recurso .= $total;
	    echo $recurso;	
	   
		}else{
		
		$recurso =$this->getPaginadoHeader();
		$recurso .= "#%#";
		$recurso .= '<tr> <td colspan="7"><div class="empty_results">NO EXISTEN RESULTADOS</div></td></tr>';
		$recurso .= "#%#";
		$recurso .=$this->getpaginadoFooter();
		$recurso .= "#%#";
		$recurso .= $total;
		echo $recurso;	
		
		}
		
		
	}
	
	
	
	 function getPaginadoHeader(){	
	 
		// $this->Model->buscarUsuarios();
		 	
	#---------------------PAGINADO---------------------------#
			 $q = (isset($_GET['q']))? "&q=".$_GET['q'] : ""; 
			$paginadoHeader ='
			
		
     <div class="left">
	  
            <input type="text" name="searchbar" id="searchbar"    />
							<button class="btn btn-small" onclick="BuscarInput();"  id="search_go-button-pe"><i class="icon-search"></i> Buscar</button>
                        
	  </div>
	  
	  
      <div class="bar_seperator"></div>
      
	  <div id="search_page_size-panel">
	    
        <div class="page_size_25" onClick="showLimitPage2(25,this);" id="page_size_25-panel2"></div>
		<div class="page_size_50" onClick="showLimitPage2(50,this);" id="page_size_50-panel2"></div>
        <div class="page_size_100" onClick="showLimitPage2(100,this);" id="page_size_100-panel2"></div>
        <div class="page_size_200" onClick="showLimitPage2(200,this);" id="page_size_200-panel2"></div>
	
     
	 </div>
     
	 
	 
	   
	    
      <div class="search_pagination">
	  ';
		 
	  
      $prevpag = (int)$_GET["p"]-1;
	 
	  if($prevpag>$this->Model->totalPag || $prevpag<1){
	  
	  $prevbutton  ='<div class="page_button left button_disable"></div>';
	  }else{
	 
	  $prevbutton = '<a href="javascript:void(0)" onclick="showPage('.$prevpag.');"> <div class="page_button left"></div></a>';
	  }
	  
	   
     
	   $paginadoHeader.=  $prevbutton.' <div class="page_overview_display">
          <input type="text" value="'.$_GET["p"].'" class="page_number-box">
          &nbsp;de&nbsp;'.$this->Model->totalPag.'</div>';
       
	  $nextpag = (int)$_GET["p"]+1;
	  
	  if($nextpag>$this->Model->totalPag){
	  	$nextbutton = '<div class="page_button right button_disable"></div>';
	  }else{
	  	$nextbutton = '<a href="javascript:void(0)" onclick="showPage('.$nextpag.');"> <div class="page_button right "></div></a>';
	  }
	   
	 $paginadoHeader .= $nextbutton.' 
	  </div>';
		#--------------------- END PAGINADO---------------------------#
		
			
		
		//$this->View->replace_content('/\#FILTERHEADER\#/ms' ,$paginadoHeader);
		return $paginadoHeader;
		}
		
		
		
		function getpaginadoFooter(){
		
		#---------------------PAGINADO FOOTER---------------------------#
		$paginadoFooter ='<div class="search_navigation">
    <div class="search_pagination">';
      
	  $prevpag = (int)$_GET["p"]-1;
	  
	  if($prevpag>$this->Model->totalPag || $prevpag<1){
	  
	  $prevbutton  ='<div class="page_button left button_disable"></div>';
	  }else{
	  $prevbutton = '<a href="javascript:void(0)" onclick="showPage('.$prevpag.');"> <div class="page_button left"></div></a>';
	  }
	  
	   $paginadoFooter.=  $prevbutton.' <div class="page_overview_display">
          <input type="text" value="'.$_GET["p"].'" class="page_number-box">
          &nbsp;de&nbsp;'.$this->Model->totalPag.'</div>';
       
	  $nextpag = (int)$_GET["p"]+1;
	  
	  if($nextpag>$this->Model->totalPag){
	  	$nextbutton = '<div class="page_button right button_disable"></div>';
	  }else{
	  	$nextbutton = '<a href="javascript:void(0)" onclick="showPage('.$nextpag.');"> <div class="page_button right "></div></a>';
	  }
	   
	 $paginadoFooter .= $nextbutton.'
    </div>
	
	  <div class="left"> 
                        <div id="results_textModal">
               0 resultados
               </div>
               </div>
	
  </div>';	
		 #---------------------END PAGINADO FOOTER---------------------------#
		
		//$this->View->replace_content('/\#FILTERFOOTER\#/ms' ,$paginadoFooter);
		
		return $paginadoFooter;
	}
	  
	
	
	
	
 function cortar_string ($string, $largo) {
   $marca = "<!--corte-->";

   if (strlen($string) > $largo) {
       
       $string = wordwrap($string, $largo, $marca);
       $string = explode($marca, $string);
       $string = $string[0];
   }
   return $string." ...";

} 
	
}

?>