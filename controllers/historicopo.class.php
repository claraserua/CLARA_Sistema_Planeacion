<?php
include "models/historicopo.model.php";

class historicopo {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	

	function historicopo() {
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("filtro");
	 $this->Model = new historicopoModel();
	 $this->passport = new Authentication();
	 $this->alertas = new Alertas();
	 
     switch($_GET['method']){
	 	
		case "Buscar":
			$this->Buscar();
			break;
		
		case "BuscarPlanesEstrategicos":
			$this->BuscarPlanesEstrategicos();
			break;
		
			
		case "Eliminar":
			$this->Eliminar();
			break;
			
		case "Desarchivar":
			$this->Desarchivar();
			break;
			
		
		
		case "Salir":
			$this->Model->Salir();
			$this->View = new View(); 
            $this->loadPage();
			break;
		
		
		case "Omitir":
			$this->Model->Omitir();
			break;
		
			
		default:	
	      $this->View = new View(); 
          $this->loadPage();
		  break;
		}	
						 
		 
	}
	
	
	
	 function loadPage(){
	
		$this->View->template = TEMPLATE.'/modules/planesoperativo/PLAN.TPL';	
		$this->View->loadTemplate();
		$this->loadHeader();
		$this->loadNodos();
		$this->loadMenu();
		 if($this->passport->privilegios->hasPrivilege('P05')){
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
	 
	 
	 function loadNodos(){
	
	$nodos =  $this->nodos->nodos;	 
	$this->View->replace_content('/\#NODOS\#/ms' ,$nodos);
	 
	 
	 }
	
	 function  loadMenu(){
	
	  $menu =  $this->menu->menu; 
	 $this->View->replace_content('/\#MENU\#/ms' ,$menu);
	 
	 
	 }
	 
	
	function error(){
		
		$contenido = $this->View->Template(TEMPLATE.'modules/error.tpl');
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
	}
    
	
	 function loadContent(){
	 	
		 
	 $section = TEMPLATE.'modules/planesoperativo/GRDPLANH.TPL';
	 $section = $this->View->loadSection($section);
	 
	 $urlbtnaddplan ='<button type="button" onclick="AsignarPlanEstrategico(false);" class="btn btn-small btn-warning"><i class="icon-book icon-white"></i>&nbsp;Agregar nuevo Plan</button>';
	  
	   if($this->passport->privilegios->hasPrivilege('P25')){
	  $section =  $this->View->replace('/\#BTNAGREGARPLANE\#/ms' ,$urlbtnaddplan,$section);
	  }else{
	  $section =  $this->View->replace('/\#BTNAGREGARPLANE\#/ms' ,"",$section);
	  }
	 
	 
	  $this->View->replace_content('/\#CONTENT\#/ms' ,$section);
		 
		 }
	 
	   //=================================BUSCAR PLANES OPERATIVOS================================//
	 
	 
	 function periodos($idPO,$estado){	  	
	  	$this->Model->periodos = array();
	  	
	  	$periodo ='';
	  	$this->Model->getPeriodos($idPO);

		$numperiodos = sizeof($this->Model->periodos); 
		
		$i = 1;
		
		 
		 if($numperiodos != 0){
		 	
	        foreach($this->Model->periodos as $rowperiodos){
	        	
	        	
	     $periodo ='';
		      	
	       if(trim($estado)=='S' && ( $rowperiodos['ENVIADO']==0 && $rowperiodos['ORDEN']== 1)){
	        	 
	        						
					$periodo = $rowperiodos['PERIODO'];
					break;
				
			
			}
			
			else if(trim($estado)=='S' && $rowperiodos['ENVIADO']==2){
				 $periodo = $rowperiodos['PERIODO'];
				 break;
			}
			
			else if(trim($estado)=='I' && $rowperiodos['ENVIADO']==1){
				
				  $periodo = $rowperiodos['PERIODO'];
				  break;
			}
	  	
	  	
	  	
	  	  }
	  	}
	  	
	  	return $periodo;
	  	
	  	
	  }
	 
	 
	 
	 function Buscar(){
		
		$this->Model->buscarPlanesOperativos();
		$recurso = $this->getPaginadoHeader();
		$recurso .= "#%#";
	    
		$usuario = $_SESSION['session']['user'];
		
		$numrecursos = sizeof($this->Model->planes);
		$total = $this->Model->totalnum;
		
		
				
				
				
		
		if($numrecursos != 0){
			
		foreach($this->Model->planes as $row){
			
			
	   $urlEditObjetivos="?execute=planesoperativo/editarobjetivos&method=default&Menu=F2&SubMenu=SF21&IDPlan=".$row['PK1']."&IDPlanE=".$row['PK_PESTRATEGICO']."&IDJerarquia=".$row['PK_JERARQUIA'];
		
		
		
		     $periodo = '';
		
		     $estado = (string)$row['ESTADO'];
			 $estado = trim($estado);
			 
			 
			  $rowAsignacion =  $this->Model->getAsignacion($row['PK1'],$usuario);
		     
			
			  switch($estado){
			  	
				case 'P':
				if($this->passport->getPrivilegio($row['PK1'],'P79')){
					$url="?execute=planesoperativo/addobjetivos&method=default&Menu=F2&SubMenu=SF21&IDPlan=".$row['PK1']."&IDPlanE=".$row['PK_PESTRATEGICO'];
					$bodyestado = "En elaboración por el centro";
					}else{
					$url= "#&p=1&s=25&sort=1&q=";
					$bodyestado = "No tiene permisos para ingresar";
					}
					$estado = '<span class="label label-warning">Pendiente</span> <span class="label label-info">Elaborando</span>';
					$titlestado = "Estado: Pendiente";
					
			  		break;
				
				
				case "G":
				if($this->passport->getPrivilegio($row['PK1'],'P79')){
					$url="?execute=planesoperativo/editobjetivos&method=default&Menu=F2&SubMenu=SF21&IDPlan=".$row['PK1']."&IDPlanE=".$row['PK_PESTRATEGICO'];
					$bodyestado = "En elaboración por el centro";
					}else{
					$url= "#&p=1&s=25&sort=1&q=";
					$bodyestado = "No tiene permisos para ingresar";
					}
				    
					$estado = '<span class="label label-warning">Pendiente:</span> <span class="label label-info">Elaborando</span>';
					$titlestado = "Estado: Pendiente ";
					
			  		break;
				
					
			    case "E":
					if($this->passport->getPrivilegio($row['PK1'],'P80')){
				    $url="?execute=planesoperativo/revisionobjetivos&method=default&estado=E&Menu=F2&SubMenu=SF21&IDPlan=".$row['PK1']."&IDPlanE=".$row['PK_PESTRATEGICO'];
					$bodyestado = "En revisión";
					}else{
					$url= "#&p=1&s=25&sort=1&q=";
					$bodyestado = "No tiene permisos para ingresar";
					}
					$estado = '<span class="label label-warning">Pendiente</span> <span class="label label-revision">Revisando</span>';
					$titlestado = "Estado: Pendiente";
					
			  		break;
					
				case "R":
				  if($this->passport->getPrivilegio($row['PK1'],'P137')){
				    $url="?execute=planesoperativo/revisionobjetivos&method=default&estado=R&Menu=F2&SubMenu=SF21&IDPlan=".$row['PK1']."&IDPlanE=".$row['PK_PESTRATEGICO'];
					$bodyestado = "Pendiente Revisar por el Centro";
					}else{
					$url= "#&p=1&s=25&sort=1&q=";
					$bodyestado = "No tiene permisos para ingresar";
					}
					
					$estado = '<span class="label label-warning">Pendiente</span> <span class="label label-revision">Revisando Centro</span>';
					$titlestado = "Estado: Pendiente";
					
			  		break;
					
					
				case "S":
				if($this->passport->getPrivilegio($row['PK1'],'P90')){
				    $url="?execute=planesoperativo/seguimiento&method=default&Menu=F2&SubMenu=SF21&IDPlan=".$row['PK1']."&IDPlanE=".$row['PK_PESTRATEGICO'];
					$bodyestado = "Operando en seguimiento";
					}else{
					$url= "#&p=1&s=25&sort=1&q=";
					$bodyestado = "No tiene permisos para ingresar";
					}
					$estado = '<span class="label label-success">Operando</span> <span class="label label-info">Elaborando Informe</span>';
					$titlestado = "Estado: Operando";										
					
					/*  */
					
					 $periodo = $this->periodos($row['PK1'],'S');						
					
					/*   */					
					
					
			  		break;
			  	
				
				case "I":
				if($this->passport->getPrivilegio($row['PK1'],'P91')){
				    $url="?execute=planesoperativo/seguimiento&method=default&Menu=F2&SubMenu=SF21&IDPlan=".$row['PK1']."&IDPlanE=".$row['PK_PESTRATEGICO'];
					$bodyestado = "En revisión";
					}else{
					$url= "#&p=1&s=25&sort=1&q=";
					$bodyestado = "No tiene permisos para ingresar";
					}
					$estado = '<span class="label label-success">Operando</span> <span class="label label-revision">Revisando Informe</span>';
					$titlestado = "Estado: Operando";
					
					 $periodo = $this->periodos($row['PK1'],'I');		
			  		break;
					
				case "T":
				if($this->passport->getPrivilegio($row['PK1'],'P90')){
				    $url="?execute=planesoperativo/seguimiento&method=default&Menu=F2&SubMenu=SF21&IDPlan=".$row['PK1']."&IDPlanE=".$row['PK_PESTRATEGICO'];
					$bodyestado = "Plan Operativo Terminado";
					}else{
					$url= "#&p=1&s=25&sort=1&q=";
					$bodyestado = "No tiene permisos para ingresar";
					}
					$estado = '<span class="label label-important">Terminado</span>';
					$titlestado = "Estado: Terminado";
					
			  		break;
				
				
			  	default:
				// $url="?execute=planesoperativo/previewplan&method=default&Menu=F2&SubMenu=SF21&IDPlan=".$row['PK1']."&IDPlanE=".$row['PK_PESTRATEGICO'];
				$url= "#&p=1&s=25&sort=1&q=";
				$estado = '<span class="label label-warning">Pendiente</span>';
				$titlestado = "Estado: Pendiente";
				$bodyestado = "En elaboración por el Centro";
			  		break;
			  }
		
		
		    if($row['DISPONIBLE']==0){ $clase = 'class="nodisponible"'; }else{ $clase = " "; }
			
		    if($this->passport->getPrivilegio($row['PK1'],'P78')){
			 	
		
			$recurso .= '<tr '.$clase.'>
			                    <td>	
								<div  data-rel="popover" data-content="'.$bodyestado.'" title="'.$titlestado.'">
								<a href="'.$url.'" target="_blank"><span  style="float:left; margin-top:8px;"><h3>'.htmlentities($row['TITULO'], ENT_QUOTES, "ISO-8859-1").'</h3></span></a>
								
								<div class="btn-group" style="float:left; margin-left:10px;">
								  <a href="#" data-toggle="dropdown" class="btn dropdown-toggle"><span class="caret"></span></a>
								  <ul class="dropdown-menu">';
								  
								  
								  if($this->passport->getPrivilegio($row['PK1'],'P29')){
								$recurso .='<li><a href="#" onClick="javascript:ImprimirPlanHtml(\''.$row['PK1'].'\',\''.$row['PK_PESTRATEGICO'].'\');return false;"><i class=" icon-print"></i> Imprimir</a></li>';
								}
								  
								  
								 
								if($this->passport->getPrivilegio($row['PK1'],'P29')){
								$recurso .='<li><a href="#" onClick="javascript:ImprimirPlan(\''.$row['PK1'].'\',\''.$row['PK_PESTRATEGICO'].'\');return false;"><i class=" icon-print"></i> Exportar PDF</a></li>';
								}
								 
								 
								if($this->passport->getPrivilegio($row['PK1'],'P28')){
								$recurso .='  <li><a href="?execute=planesoperativo/exportexcel&IDPlan='.$row['PK1'].'&IDPlanE='.$row['PK_PESTRATEGICO'].'" target="_blank"><i class="icon-file"></i> Exportar Excel</a></li>
								  <li class="divider"></li>';
								  }
								  
								  
								 if($this->passport->getPrivilegio($row['PK1'],'P35')){
								
								$body = htmlentities($row['TITULO'], ENT_QUOTES, "ISO-8859-1").': http://www.redanahuac.mx/app/planeacion/shared.app?execute=PO51927619CDB8A/PE518EA2F51B620/PO';		
								$recurso .='  <li><a href="mailto:info@example.com?subject=\'Plan operativo: '.htmlentities($row['TITULO'], ENT_QUOTES, "ISO-8859-1").' \'&body='.$body.'" ><i class="icon-envelope"></i> Compartir</a></li>
								  <li class="divider"></li>';
								  }
								  
								  
								  /*if($this->passport->getPrivilegio($row['PK1'],'P65')){
								  $recurso .='
<li><a href="?execute=planesoperativo/asignaciones&method=default&Menu=F2&SubMenu=SF21&IDPlan='.$row['PK1'].'&IDPlanE='.$row['PK_PESTRATEGICO'].'&IDJerarquia='.$row['PK_JERARQUIA'].'#&p=1&s=25&sort=1&q=" target="_blank"><i class="icon-th-list"></i> Asignaciones</a></li>';
								  
								  }*/
								  
								  /*
								  if($this->passport->getPrivilegio($row['PK1'],'P40')){
								$recurso .='
<li><a href="?execute=planesoperativo/editestado&method=default&Menu=F2&SubMenu=SF21&IDPlan='.$row['PK1'].'&IDPlanE='.$row['PK_PESTRATEGICO'].'&IDJerarquia='.$row['PK_JERARQUIA'].'" target="_blank"><i class="icon-flag"></i> Cambiar estado</a></li> <li class="divider"></li>';
}
								 */
					if($this->passport->privilegios->hasPrivilege('P008')){
								$recurso .='<li><a href="#" onClick="javascript:DesarchivarPlanOperativo(\''.$row['PK1'].'\',false);return false;"><i class="icon-arrow-left"></i> Desarchivar</a></li>';
								}
								  
								  /*
								if($this->passport->getPrivilegio($row['PK1'],'P26')){
								$recurso .='
<li><a href="?execute=planesoperativo/editplano&method=default&Menu=F2&SubMenu=SF21&IDPlan='.$row['PK1'].'&nodo='.$row['PK_JERARQUIA'].'" target="_blank"><i class="icon-pencil"></i> Editar</a></li>';
}*/
/*
                				if($this->passport->getPrivilegio($row['PK1'],'P30')){
								$recurso .='<li><a href="'.$urlEditObjetivos.'" target="_blank"><i class=" icon-pencil"></i> Editar Objetivos</a></li>';
								}*/
								/*
								if($this->passport->getPrivilegio($row['PK1'],'P27')){
								$recurso .='<li><a href="#" onClick="javascript:EliminarPlanOperativo(\''.$row['PK1'].'\',false);return false;"><i class="icon-trash"></i> Borrar</a></li>';
								}*/
									
								 $recurso .=' </ul>
								  
								 
								</div>
								 </div>
								</td>
								<td><h3>'.$row['PK_JERARQUIA'].'</h3></td>
                                <td><h3>'.$row['FECHA_I']->format('Y-m-d').'</h3></td>
                                <td>'.$estado.'
                                  <div class="periodo">
                                   <h5>'.htmlentities($periodo, ENT_QUOTES, "ISO-8859-1").'</h5>
                                  </div>                                
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
	    $paginadoHeader.=' value="3">Ordenar por: Estado</option>
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
	
	    //=================================BUSCAR PLANES OPERATIVOS================================//
	  
	  
	  
	  
	  
	  
	  //=================================BUSCAR PLANES ESTRATEGICOS================================//
	   function BuscarPlanesEstrategicos(){
		
		$this->Model->buscarPlanesEstrategicos();
		$recurso = $this->getPaginadoHeaderModal();
		$recurso .= "#%#";
	
		$numrecursos = sizeof($this->Model->planes);
		$total = $this->Model->totalnum;
		
		if($numrecursos != 0){
			
		foreach($this->Model->planes as $row){
			
		
			 $recurso .= '<tr>
			 
			                     <td width="20"><input type="radio" value="'.$row['PK1'].'|'.$row['PK_JERARQUIA'].'" name="rbtplane" /></td>
			                    <td><h3>'.htmlentities($row['TITULO'], ENT_QUOTES, "ISO-8859-1").'</h3>
								</td>
			<td width="100"><h3>'.$row['PK_JERARQUIA'].'</h3></td>
								
								';
			
			}	
		
		$recurso .= "#%#";
		$recurso .= $this->getpaginadoFooterModal();
		$recurso .= "#%#";
		$recurso .= $total;
	    echo $recurso;	
	   
		}else{
		
		$recurso =$this->getPaginadoHeaderModal();
		$recurso .= "#%#";
		$recurso .= '<tr> <td colspan="5"><div class="empty_results">NO EXISTEN RESULTADOS</div></td></tr>';
		$recurso .= "#%#";
		$recurso .=$this->getpaginadoFooterModal();
		$recurso .= "#%#";
		$recurso .= $total;
		echo $recurso;	
		
		}
		
		
	}
	
	
	
	 function getPaginadoHeaderModal(){	
	 

		// $this->Model->buscarUsuarios();
		 	
	#---------------------PAGINADO---------------------------#
			 $q = (isset($_GET['q']))? "&q=".$_GET['q'] : ""; 
			$paginadoHeader ='
			
		
     <div class="left">
	  
            <input type="text" name="searchbarpe" id="searchbarpe"    />
							<button class="btn btn-small" onclick="buscarPE();"   id="search_go-button-pe"><i class="icon-search"></i> Buscar</button>
                        
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
		
		
		
		function getpaginadoFooterModal(){
		
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
	  //===============================END BUSCAR PLANES ESTRATEGICOS================================//
	

      function Eliminar(){
	 
	   $this->Model->Eliminar($_GET['id']);
		
	  }
	  
	  
	  function Desarchivar(){
	 
	   $this->Model->Desarchivar($_GET['id']);
		
	  }
	  
	  
	  



}

?>