<?php
include "models/jerarquia.model.php";
include "libs/resizeimage/class.upload.php";


class jerarquia {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	

	function jerarquia() {
	 $this->menu = new Menu();
	 $this->nodos = new Niveles();
	 $this->Model = new jerarquiaModel();
	 $this->passport = new Authentication();
	 
	 
	 
	  switch($_GET['method']){
	 	
		case "Buscar":
			$this->Buscar();
			break;
			
		case "Eliminar":
			$this->Eliminar();
			break;
		
		case "Guardar":
		$this->Guardar();
		break;
		
		case "Actualizar":
		$this->Actualizar();
		break;
		
		case "Mover":
		$this->Mover();
		break;
		
		
		case "Ordenar":
		$this->Ordenar();
		break;
			
	   default:	
	   $this->View = new View(); 
           $this->loadPage();
		  break;
		}	
						 
		 
	}
	
	
	
	 function loadPage(){
	
		$this->View->template = TEMPLATE.'modules/jerarquia/JERARQUIA.TPL';	
		$this->View->loadTemplate();
		$this->loadHeader();
		$this->loadNodos();
		$this->loadMenu();
		$this->loadContent();
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
	 
	
	function loadNodos(){
	
	$nodos =  $this->nodos->nodos;	 
	$this->View->replace_content('/\#NODOS\#/ms' ,$nodos);
	 
	 
	 }
	
  
	 function loadContent(){
	 	
	   $section = TEMPLATE.'modules/jerarquia/GRDJERARQUIA.TPL';
	   $section = $this->View->loadSection($section);
	   $row = $this->Model->getNivel($_GET['Nivel']);
	   $section = $this->View->replace('/\#NIVEL\#/ms' ,htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1"),$section);
	   $url = "?execute=jerarquia/addjerarquia&method=default&Menu=F3&SubMenu=SF34&Nivel=".$_GET['Nivel'];
	   $section = $this->View->replace('/\#URL\#/ms' ,$url,$section);
	  
	   $this->View->replace_content('/\#CONTENT\#/ms' ,$section);
		
		 
		 }
	 
	 function Buscar(){
		
		$this->Model->buscarNiveles();
		$recurso = $this->getPaginadoHeader();
		$recurso .= "#%#";
	
		$numrecursos = sizeof($this->Model->niveles);
		$total = $this->Model->totalnum;
		
		if($numrecursos != 0){
			
		foreach($this->Model->niveles as $row){
					
		$recurso .= '<tr>';
		
	if(isset($row['ADJUNTO'])){	
		if(($row['ADJUNTO']=="NULL" || $row['ADJUNTO']=="")){
				$imagen = "skins/admin/images/avatar-anonimo.png";
			}else{
			     $imagen = "media/jerarquias/".$row['PK1']."/".$row['ADJUNTO'];
			}
		}else{
		$imagen = "skins/admin/images/avatar-anonimo.png";
		
		}	
		
		$recurso .= '<td><img src="'.$imagen.'" widht="40" height="40" title="LOGO"></td>';
		
		
		$recurso .= '<td><h3>'.$row['PK1'].'</h3></td>
			<td><h3><a href="?execute=jerarquia&method=default&Menu=F3&SubMenu=SF34&Nivel='.$row['PK1'].'#&p=1&s=25&sort=1&q=">'.htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1").'</a></h3></td>
			<td><h3><a href="?execute=jerarquia&method=default&Menu=F3&SubMenu=SF34&Nivel='.$row['PK1'].'#&p=1&s=25&sort=1&q=">'.htmlentities($row['DESCRIPCION'], ENT_QUOTES, "ISO-8859-1").'</a></h3></td>
								
			<td><button class="btn btn-small" onclick="EliminarNivel(\''.$row['PK1'].'\',false)" ><i class="icon-trash"></i> Borrar</button>&nbsp;<a href="?execute=jerarquia/editjerarquia&method=default&Menu=F3&SubMenu=SF34&Nivel='.$row['PK1'].'&Padre='.$row['PADRE'].'"><button class="btn btn-small"><i class="icon-pencil"></i> Editar</button></a>
			&nbsp;';
			
		if($this->passport->privilegios->hasPrivilege('P42')){	
		
		$recurso .='<a href="?execute=jerarquia/movejerarquia&method=default&Menu=F3&SubMenu=SF34&Nivel='.$row['PK1'].'&Padre='.$row['PADRE'].'"><button class="btn btn-small"><i class="icon-resize-vertical"></i> Mover</button></a>';
			
			}
			
			
			
		$recurso .='</td>
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
		$recurso .= '<tr> <td colspan="5"><div class="empty_results">El nivel no contiene subniveles</div></td></tr>';
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
	    
      <div class="search_pagination">';
	  
	   if($this->passport->privilegios->hasPrivilege('P43')){
	   	
		$paginadoHeader.='<a href="?execute=jerarquia/ordenarjerarquia&method=default&Menu=F3&SubMenu=SF34&Padre='.$_GET['Nivel'].'">
	  <button class="btn btn-small" style="float:left; margin-right:10px;"><i class="icon-list-alt"></i> Ordenar</button></a>';
		
		}
	  
	  
		 
	  
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
	
	
	
	function Guardar(){
	
	         $adjunto= "NULL";
				
	         if(isset($_FILES['imagearticulo']['name']) && !empty($_FILES['imagearticulo']['name'])){
			 
			    
			    $logo = strtolower(basename($_FILES['imagearticulo']['name']));
			    $carpeta = "media/jerarquias/".$_POST['idnivel'];
		
	             if(!file_exists($carpeta)){
	                  if(!mkdir($carpeta, 0777)) {
                           die('Fallo al crear las carpetas...');
                          }
	               }
				   
				   
		 $file = new Upload($_FILES['imagearticulo']);
	     if ($file->uploaded) {
	
	     $file->Process($carpeta);
         if ($file->processed) {
		        
			   $adjunto = $file->file_dst_name;
		       
         }
	
	    }
	
	
			 
			 
			 }
	
		
			$this->Model->idnivel = $_POST['idnivel'];
			$this->Model->nivel = $_POST['nivel'];
			$this->Model->descripcion = $_POST['descripcion'];
			$this->Model->padre = $_POST['padre'];
			$this->Model->adjunto = $adjunto;
			
			
			if($this->Model->GuardarNivel()){
				
		      $this->View = new View(); 
              $this->loadPage();
			  
			  echo '<script>
			 $("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha creado el nivel"); 
				</script>
			 ';
			}
			
	}
	
	
	
	function Actualizar(){
	            
				
			$adjunto= "NULL";
				
	         if(isset($_FILES['imagearticulo']['name']) && !empty($_FILES['imagearticulo']['name'])){
			 
			
			    $logo = strtolower(basename($_FILES['imagearticulo']['name']));
			    $carpeta = "media/jerarquias/".$_POST['idnivel'];
		
	             if(!file_exists($carpeta)){
	                  if(!mkdir($carpeta, 0777)) {
                           die('Fallo al crear las carpetas...');
                          }
	               }
				   
				   
		 $file = new Upload($_FILES['imagearticulo']);
	     if ($file->uploaded) {
	
	     $file->Process($carpeta);
         if ($file->processed) {
		        
			   $adjunto = $file->file_dst_name;
		       
         }
	
	    }
	
	
			 
			 
			 }
	        
			
		
			$this->Model->idnivel = $_POST['idnivel'];
			$this->Model->nivel = $_POST['nivel'];
			$this->Model->descripcion = $_POST['descripcion'];
			$this->Model->padre = $_POST['padre'];
			$this->Model->adjunto = $adjunto;
			
			
			
			if($this->Model->ActualizarNivel()){
				
		      $this->View = new View(); 
              $this->loadPage();
			  
			  echo '<script>
			 $("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha actualizado el nivel"); 
				</script>
			 ';
			}
			
	}
	
	
	
	
	
	
	
	function  Mover(){
		
			$this->Model->idnivel = $_POST['idnivel'];
			$this->Model->padre = $_POST['jerarquia'];
			
			
			if($this->Model->MoverNivel()){
				
		      $this->View = new View(); 
              $this->loadPage();
			  
			  echo '<script>
			 $("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se ha actualizado el nivel"); 
				</script>
			 ';
			}
			
	}
	
	
	
	function Ordenar(){
		
		$this->Model->jerarquias =  $_POST['jerarquias'];
		
		$this->Model->Ordenar();
		
		$this->View = new View(); 
        $this->loadPage();
	       
		    echo '<script>
			 $("#alerta").fadeIn();
				$("#alerta").removeClass();
                $("#alerta").addClass("alert alert-success");
				$("#headAlerta").html("¡Correcto!");
				$("#bodyAlerta").html("Se han ordenado los niveles"); 
				</script>
			 ';
		   	
	}
	
	
	
	function Eliminar(){
	 
	 $this->Model->Eliminar($_GET['id']);
		
		}
	
	
}

?>