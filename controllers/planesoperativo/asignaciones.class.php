<?php
include "models/planesoperativo/asignaciones.model.php";


class asignaciones {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $passport;
	

	function asignaciones() {
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("filtro");
	 $this->Model = new asignacionesModel();
	 $this->passport = new Authentication();
	 
     		
	  switch($_GET['method']){
	 	
		case "Buscar":
			$this->Buscar();
			break;
			
		case "Eliminar":
			$this->Eliminar();
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
		//$this->loadNodos();
		$this->loadMenu();
		 if($this->passport->privilegios->hasPrivilege('P06')){
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
		
	  $section = TEMPLATE.'modules/planesoperativo/GRDASIGNACIONES.TPL';
	  $section = $this->View->loadSection($section);
	  
	   $urlbtnaddusuario ='<a href="?execute=planesoperativo/asignarusuario&method=default&Menu=F2&SubMenu=SF21&IDPlan='.$_GET['IDPlan'].'&IDJerarquia='.$_GET['IDJerarquia'].'#&p=1&s=25&sort=1&q="><button type="submit" class="btn btn-small btn-warning"><i class="icon-user icon-white"></i>&nbsp;Asignar Usuario</button></a>';
	 
	  
	  $urlbtndelusuario ='<button class="btn btn-small btn-danger" onclick="EliminarUsuario(false);" type="submit"><i class="icon-trash icon-white"></i>&nbsp;Eliminar Usuario</button>';
	  
	  
	  if($this->passport->privilegios->hasPrivilege('P66')){
	  $section =  $this->View->replace('/\#BTNELIMINARUSUARIO\#/ms' ,$urlbtndelusuario,$section);
	  }else{
	  $section =  $this->View->replace('/\#BTNELIMINARUSUARIO\#/ms' ,"",$section);
	  }
	  
	  
	  if($this->passport->privilegios->hasPrivilege('P67')){
	  $section =  $this->View->replace('/\#BTNAGREGARUSUARIO\#/ms' ,$urlbtnaddusuario,$section);
	  }else{
	  $section =  $this->View->replace('/\#BTNAGREGARUSUARIO\#/ms' ,"",$section);
	  }
	  
	  
	  $this->View->replace_content('/\#CONTENT\#/ms' ,$section);	 
	  }
		 
		 
		 
	function Buscar(){
		
		$this->Model->buscarUsuarios();
		$recurso = $this->getPaginadoHeader();
		$recurso .= "#%#";
	
		$numrecursos = sizeof($this->Model->usuarios);
		$total = $this->Model->totalnum;
		
		if($numrecursos != 0){
			
		foreach($this->Model->usuarios as $row)
		{
			$imagen = ($row['IMAGEN'] == "avatar.jpg") ? "user.png" : "thum_40x40_".$row['IMAGEN'];
			
			
			if($row['DISPONIBLE']==0){ $clase = 'class="nodisponible"'; }else{ $clase = " "; }
			
			if($row['DISPONIBLE']!=0 || $this->passport->privilegios->hasPrivilege('P39')){
			 	// <td><img src="media/usuarios/'.$imagen.'" widht="40" height="40"  title="Imagen"></td>
				$recurso .= '<tr '.$clase.'>
			                    <td><input type="checkbox" name="inscripciones" id="'.$row['ID'].'" /></td>
								<td><img src="media/usuarios/$imagen" style="width:40px; height:40px; " onerror="this.src=\'media/usuarios/user.png\';">
								<td><h3>'.$row['PK1'].'</h3></td>
								<td><h3>'.htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1").'</h3></td>
								<td><h3>'.htmlentities($row['APELLIDOS'], ENT_QUOTES, "ISO-8859-1").'</h3></td>
								<td><h3>'.$row['EMAIL'].'</h3></td>
								<td><h3>'.htmlentities($row['PK_JERARQUIA'], ENT_QUOTES, "ISO-8859-1").'</td>
								<td>
                                <h3><strong>'.$this->Model->getRol($row['ROL']).'</strong></h3>
								</td>
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
		$recurso .= '<tr> <td colspan="8"><div class="empty_results">NO EXISTEN RESULTADOS</div></td></tr>';
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
	  <div id="sort-panel">  
	  <input type="hidden" name="Search" value="recursos" />
	  <input type="hidden" name="p" value="'.$_GET['p'].'" />
	  <input type="hidden" name="s" value="'.$_GET['s'].'" />';
	 
	   if(isset($_GET['q'])){
	   	$paginadoHeader .=' <input type="hidden" name="q" value="'.$_GET['q'].'" />';
	   }
	 
	 
       $paginadoHeader.='<select id="sort-menu" name="sort" onchange="Ordenar(this.value)">
          <option'; 
		  
	if($_GET['sort']==1){$paginadoHeader .=' selected="selected" '; }
		  
		$paginadoHeader.=' value="1">Ordenar por: Reciente adición</option>
		  <option'; if($_GET['sort']==2){$paginadoHeader .=' selected="selected" '; }
		$paginadoHeader.=' value="2">Ordenar por: Nombre</option>
		    <option'; if($_GET['sort']==3){$paginadoHeader .=' selected="selected" '; }
	    $paginadoHeader.=' value="3">Ordenar por: Apellidos</option>
        </select>
     
	  </div>
	  </div>
	  
	  
      <div class="bar_seperator"></div>
      
	  <div id="search_page_size-panel">
	    
        <div class="page_size_25" onClick="showLimitPage(25,this);" id="page_size_25-panel"></div>
		<div class="page_size_50" onClick="showLimitPage(50,this);" id="page_size_50-panel"></div>
        <div class="page_size_100" onClick="showLimitPage(100,this);" id="page_size_100-panel"></div>
        <div class="page_size_200" onClick="showLimitPage(200,this);" id="page_size_200-panel"></div>
	
     
	 </div>
     
	 <div class="bar_seperator"></div>
	 
	   <div id="results_text">
               0 resultados
               </div>
	    
      <div class="search_pagination">
	  
	  <button class="btn btn-small" style="float:left; margin-right:10px;"><i class="icon-list-alt"></i> Mostrar Todos</button>';
		 
	  
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
  </div>';	
		 #---------------------END PAGINADO FOOTER---------------------------#
		
		//$this->View->replace_content('/\#FILTERFOOTER\#/ms' ,$paginadoFooter);
		
		return $paginadoFooter;
	}
	
	
	function Eliminar(){
	 
	 $ids = explode(",",$_GET['ids']);
	 
	 $this->Model->ids = $ids;
	 
	 $this->Model->Eliminar();
		
		}
	
}

?>