<?php


class reportespe {

    var $View;
	var $Model;
	var $menu;
	

	function reportespe() {
	 $this->menu = new Menu();
	
   			
	  switch($_GET['method']){
	 	
		case "Buscar":
			$this->Buscar();
			break;
		
		case "Eliminar":
			$this->Eliminar();
			break;
			
		case "Actualizar":
		$this->Actualizar();
		break;
		
		case "Insertar":
			$this->Insertar();
			break;
			
			
		default:	
	      $this->View = new View(); 
          $this->loadPage();
		  break;
		}	
						 
		 
	}
	
	
	
	 function loadPage(){
	
		$this->View->template = TEMPLATE.'PRINCIPAL.TPL';	
		$this->View->loadTemplate();
		$this->loadHeader();
		$this->loadMenu();
		$this->loadContent();
		$this->loadFooter();
		$this->View->viewPage();
		
	 }
	 
	 
	   function loadHeader(){

	  $section = TEMPLATE.'sections/header.tpl';
	  $section = $this->View->loadSection($section);
	 $nombre = htmlentities($_SESSION['session']['titulo'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($_SESSION['session']['nombre'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($_SESSION['session']['apellidos'], ENT_QUOTES, "ISO-8859-1");
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
	 
	 
	
	 function  loadMenu(){
	 $menu =  $this->menu->menu; 
	 $this->View->replace_content('/\#MENU\#/ms' ,$menu);
	 }
	 
	
  
	 function loadContent(){
		
	  $section = TEMPLATE.'modules/reportes/pe/PRINCIPAL.TPL';
	  $section = $this->View->loadSection($section);
	  $this->View->replace_content('/\#CONTENT\#/ms' ,$section);
				 
		 }
	 
	  
	 function Buscar(){
		
		$this->Model->buscarRoles();
		$recurso = $this->getPaginadoHeader();
		$recurso .= "#%#";
	
		$numrecursos = sizeof($this->Model->roles);
		$total = $this->Model->totalnum;
		
		if($numrecursos != 0){
			
		foreach($this->Model->roles as $row){
			
			 $recurso .= '<tr>
								<td><h3>'.htmlentities($row['ROLE'], ENT_QUOTES, "ISO-8859-1").'</h3></td>
								<td><h3>'.htmlentities($row['DESCRIPCION'], ENT_QUOTES, "ISO-8859-1").'</h3></td>
								<td><h3>'.date('d-m-Y', strtotime($row['FECHA_R'])).'</h3></td>
								<td><h3>Sistema</h3></td>
								<td>
									<div class="btn-group">
									
								  <a href="?execute=roles/permisosrol&method=default&Menu=F3&SubMenu=SF32&Rol='.$row['PK1'].'&Tipo='.$row['TIPO'].'#&p=1&s=25&sort=1&q=" class="btn"><i class="icon-hand-left"></i> Permisos</a>
								  <a href="#" data-toggle="dropdown" class="btn dropdown-toggle" ><span class="caret"></span></a>
								  <ul class="dropdown-menu">
									<li><a href="?execute=roles/editroles&method=default&Menu=F3&SubMenu=SF32&Rol='.$row['PK1'].'"><i class="icon-pencil"></i> Editar</a></li>
									<li><a href="#" onClick="javascript:EliminarRol(\''.$row['PK1'].'\',false);return false;"><i class="icon-trash"></i> Borrar</a></li>
									
								  </ul>
								</div>
									
									
								</td>
							</tr>';
			}	
		
		$recurso .= "#%#";
		$recurso .= $this->getpaginadoFooter();
		$recurso .= "#%#";
		$recurso .= $total;
	    echo $recurso;	
	   
		}else{
		
		$recurso =$this->getPaginadoHeader();
		$recurso .= "#%#";
		$recurso .= "NO EXISTEN RESULTADOS";
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
	
	
	
	function Insertar(){
		 	
			$this->Model->rol = $_POST['rol'];
			$this->Model->descripcion = $_POST['descripcion'];
			$this->Model->tipo = $_POST['tipo'];
			
			$this->View = new View(); 
            $this->loadPage();
			
			
			if($this->Model->Insertar()){
			  	 echo '<script>
			    $("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha agregado el rol de sistema"); 
				</script>
			 ';
			  }
			 
		
          }
	
	
	
	
	function Actualizar(){
		
			$this->Model->idrol = $_POST['idrol'];
			$this->Model->rol = $_POST['rol'];
			$this->Model->tipo = $_POST['tipo'];
			$this->Model->descripcion = $_POST['descripcion'];
			
			$this->View = new View(); 
            $this->loadPage();
			
			
			if($this->Model->ActualizarRol()){
		
			  echo '<script>
			    $("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha actualizado el rol de sistema"); 
				</script>
			 ';
			}
			
	}
	
	
	function Eliminar(){
	 
	 $this->Model->Eliminar($_GET['id']);
		
		}
	
	
}

?>