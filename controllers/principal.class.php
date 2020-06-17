<?php
include "models/principal.model.php";

class principal {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $alertas;

	
	function principal() {
		
	 $this->menu = new Menu("F1","SF11");
	 $this->nodos = new Niveles("filtro");
	 $this->View = new View();
	 $this->Model = new principalModel();
	 $this->passport = new Authentication();
	 $this->alertas = new Alertas();
	 
	
	if(isset($_GET['method'])){
	 switch($_GET['method']){
	 	
		case "Buscar":
			$this->Buscar();
			break;
			
		case "Eliminar":
			$this->Eliminar();
			break;
			
		case "Archivar":
			$this->Archivar();
			break;
			
		default:	
	        $this->View = new View(); 
                $this->loadPage();
		break;
		}
	}else{
	  $this->View = new View(); 
          $this->loadPage();
	}
	
				 
		 
	}
	
	
	
	 function loadPage(){
	
	    $this->View->template = TEMPLATE.'modules/planestrategico/PLAN.TPL';	
	    $this->View->loadTemplate();
	    $this->loadHeader();
	    $this->loadMenu();
	    $this->loadNodos();
	    if($this->passport->privilegios->hasPrivilege('P04')){
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
	  $nombre = $_SESSION['session']['titulo'].' '.htmlentities($_SESSION['session']['nombre'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($_SESSION['session']['apellidos'], ENT_QUOTES, "ISO-8859-1");
	  $imagen = 'thum_40x40_'.$_SESSION['session']['imagen'];
	  $section = $this->View->replace('/\#AVATAR\#/ms' ,$imagen,$section);
	  $section = $this->View->replace('/\#USUARIO\#/ms' ,$nombre,$section);
	  
      $section = $this->View->replace('/<!--\#NUMNOTIFICACIONES\#-->/ms' ,$this->alertas->getNumAlertas(),$section);
	  $section = $this->View->replace('/<!--\#NOTIFICACIONES\#-->/ms' ,$this->alertas->getAlertas(),$section);
	  
	  $this->View->replace_content('/\#HEADER\#/ms' ,$section);
	  
	  
	  }
	 
	 
	  
	  function loadFooter(){
	 	
      $section = TEMPLATE.'sections/footer.tpl';
	  $section = $this->View->loadSection($section);
	  $this->View->replace_content('/\#FOOTER\#/ms' ,$section);
		
	 }
	 
	
	 function  loadMenu(){

	 $menu =   $this->menu->menu; 
	 $this->View->replace_content('/\#MENU\#/ms' ,$menu);
	  
	 }
	 
	
    function loadNodos(){
	
	$nodos =  $this->nodos->nodos;	 
	$this->View->replace_content('/\#NODOS\#/ms' ,$nodos);
	 
	 
	 }
	
	 function error(){
		
		$contenido = $this->View->Template(TEMPLATE.'modules/error.tpl');
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
	}
 
 
	 function loadContent(){
	 	
	  $section = TEMPLATE.'modules/planestrategico/GRDPLAN.TPL';
	  $section = $this->View->loadSection($section);
	  
	  $urlbtnaddplan ='<a href="?execute=planestrategico/addplane&method=default&Menu=F1&SubMenu=SF11"><button type="submit" class="btn btn-small btn-warning"><i class="icon-book icon-white"></i>&nbsp;Agregar nuevo Plan</button></a>';
	  
	   if($this->passport->privilegios->hasPrivilege('P20')){
	  $section =  $this->View->replace('/\#BTNAGREGARPLANE\#/ms' ,$urlbtnaddplan,$section);
	  }else{
	  $section =  $this->View->replace('/\#BTNAGREGARPLANE\#/ms' ,"",$section);
	  }
	  
	  $this->View->replace_content('/\#CONTENT\#/ms' ,$section);
		 
		 
		 }
	 
	 function Buscar(){
		
		$this->Model->buscarPlanesEstrategicos();
		$recurso = $this->getPaginadoHeader();
		$recurso .= "#%#";
	
		$numrecursos = sizeof($this->Model->planes);
		$total = $this->Model->totalnum;
		
		if($numrecursos != 0){
			
		foreach($this->Model->planes as $row){
			
			 if($row['DISPONIBLE']==0){ $clase = 'class="nodisponible"'; }else{ $clase = " "; }
			
		     if($row['DISPONIBLE']!=0 || $this->passport->privilegios->hasPrivilege('P37')){  
			 	
			 $recurso .= '<tr '.$clase.'>
			                    <td>	
								<div>
								<div style="float:left; margin-top:8px;"><a href="?execute=planestrategico/previewplan&Menu=F1&SubMenu=SF11&IDPlan='.$row['PK1'].'" target="_blank"><h3>'.htmlentities($row['TITULO'], ENT_QUOTES, "ISO-8859-1").'</h3></a></div>
								
								<div class="btn-group" style="float:left; margin-left:10px;">
								  <a href="#" data-toggle="dropdown" class="btn dropdown-toggle" ><span class="caret"></span></a>
								  <ul class="dropdown-menu">';
								  
			 if($this->passport->privilegios->hasPrivilege('P25')){
								$recurso .='<li><a href="?execute=planesoperativo/addplano&method=default&Menu=F2&SubMenu=SF21&IDPlanEstrategico='.$row['PK1'].'&IDJerarquia='.$row['PK_JERARQUIA'].'"><i class="icon-plus-sign"></i> Plan Operativo</a></li>
								  <li class="divider"></li>';
								  }
						
						 if($this->passport->privilegios->hasPrivilege('P24')){
								$recurso .='  <li><a href="#" onClick="javascript:ImprimirPlan(\''.$row['PK1'].'\');return false;"><i class=" icon-print"></i> Imprimir</a></li>';
								  }
									
						if($this->passport->privilegios->hasPrivilege('P23')){
									$recurso .='<li><a href="?execute=planestrategico/exportexcel&IDPlan='.$row['PK1'].'"><i class="icon-file"></i> Exportar</a></li>';
									}
						$recurso .='<li class="divider"></li>';
								  
					
					if($this->passport->privilegios->hasPrivilege('P36')){
						        
								$body = htmlentities($row['TITULO'], ENT_QUOTES, "ISO-8859-1").': http://www.redanahuac.mx/app/planeacion/shared.app?execute=PO51927619CDB8A/'.$row['PK1'].'/PE';
						
								$recurso .='  <li><a href="mailto:info@example.com?subject=\'Plan Estratégico:'.htmlentities($row['TITULO'], ENT_QUOTES, "ISO-8859-1").' \'&body='.$body.'" ><i class="icon-envelope"></i> Compartir</a></li>
								  <li class="divider"></li>';
								  }
							

                        if($this->passport->privilegios->hasPrivilege('P007')){		
								 $recurso .= '<li><a href="#" onClick="javascript:ArchivarPlanEstrategico(\''.$row['PK1'].'\',false);return false;"><i class="icon-inbox"></i> Archivar</a></li>';
									}
							
											
						if($this->passport->privilegios->hasPrivilege('P21')){
								 $recurso .='<li><a href="?execute=planestrategico/editplane&method=default&Menu=F1&SubMenu=SF11&IDPlan='.$row['PK1'].'&nodo='.$row['PK_JERARQUIA'].'" target="_blank"><i class="icon-pencil"></i> Editar</a></li>';
									}
									
						if($this->passport->privilegios->hasPrivilege('P22')){		
								 $recurso .= '<li><a href="#" onClick="javascript:EliminarPlanEstrategico(\''.$row['PK1'].'\',false);return false;"><i class="icon-trash"></i> Borrar</a></li>';
									}
								
								 $recurso .= '  </ul>
								  
								 
								</div>
								 </div>
								</td>
								<td><h3>'.$row['PK_JERARQUIA'].'</h3></td>
                                <td><h3>'.$row['FECHA_I']->format('Y-m-d').'</h3></td>
                                <td><h3>'.$row['FECHA_T']->format('Y-m-d').'</h3></td>
								';
			
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
		$recurso .= '<tr> <td colspan="5"><div class="empty_results">NO EXISTEN RESULTADOS</div></td></tr>';
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
		$paginadoHeader.=' value="2">Ordenar por: Titulo</option>
		    <option'; if($_GET['sort']==3){$paginadoHeader .=' selected="selected" '; }
	    $paginadoHeader.=' value="3">Ordenar por: Centro</option>
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
	 
	 $this->Model->Eliminar($_GET['id']);
		
		}
		
		
		function Archivar(){
	 
	    $this->Model->Archivar($_GET['id']);
		
		}
	  
	
}

?>