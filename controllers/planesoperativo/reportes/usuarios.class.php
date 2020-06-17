<?php
include "models/planesoperativo/reportes/usuarios.model.php";
include "libs/resizeimage/class.upload.php";


class usuarios {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $nodoprincipal;
	var $image;
	var $targetPathumbail;
	

	function usuarios() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	  $this->nodos = new Niveles("filtro",TRUE);
	 $this->nodoprincipal = new Niveles("option");
	 $this->Model = new usuariosModel();
		
		
	   if(isset($_GET['method'])){		
		
		 switch($_GET['method']){
		 	
			case "Reporte":
				$this->Reporte();
				break;
				
			default:	
		      $this->View = new View(); 
	          $this->loadPage();
			  break;
			}
		
	  }	
				 
		 
	}
	
	
	
	 function loadPage(){
	
		$this->View->template = TEMPLATE.'FRMPRINCIPAL.TPL';	
		$this->View->loadTemplate();
        $this->loadHeader();		
		$this->loadMenu();
		
		//if($this->passport->privilegios->hasPrivilege('P12')){
		$this->loadContent();
		/*}else{
		$this->error();
		}*/
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
	 
	 
	
	 function loadMenu(){
	 $menu =  $this->menu->menu; 
	 $this->View->replace_content('/\#MENU\#/ms' ,$menu);
	 }
	 
	

	function error(){
		
		$contenido = $this->View->Template(TEMPLATE.'modules/error.tpl');
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
	}


  
	 function loadContent(){
	 	
		$contenido = $this->View->Template(TEMPLATE.'modules/reportes/po/USUARIOS.TPL');
		$contenido =  $this->View->replace('/\#NODOS\#/ms' ,$this->nodos->nodos,$contenido);	
		
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 
		 }
	 

	  
	  
	function Reporte(){
		
		$this->Model->getUsuarios($_GET['nodos'],$_GET['anos']);
		$html='<div class="datagrid"><table>';
		$numusuarios = sizeof($this->Model->usuarios); 
		
		 if($numusuarios != 0){
		 	 
		 	  $html.='<thead><tr>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">No.</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">USUARIO</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">NOMBRE</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">EMAIL</th>';
		 	  $html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">CENTRO</th>';
		 	  $html.='</tr>';
		 	
		 	$i=1;
		 	  foreach($this->Model->usuarios as $usuario){
		 
		 	
		 	      $this->Model->getUsuarioPlanesOperativos($_GET['nodos'],$usuario['PK1'],$_GET['anos']);
		 	      $numplanes = sizeof($this->Model->planes);
		 	      if($numplanes != 0){
		 	      	
		 	      		$html.='<tr>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.$i++.'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.$usuario['PK1'].'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.htmlentities($usuario['NOMBRE'], ENT_QUOTES, "ISO-8859-1").' '.htmlentities($usuario['APELLIDOS'], ENT_QUOTES, "ISO-8859-1").'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.$usuario['EMAIL'].'</th>';
		 	$html.='<th style="border:1px #999999 solid; background:#FF4712; color:#FFF;">'.$usuario['PK_JERARQUIA'].'</th>';
		 	$html.='</tr>';
		 	      	
		 	      	
		 	      	
		 	      	   $html.='<tr>';
		 	      	   $html.='<td colspan="5">';
		 	      	   $html.='<table>';
		 	      	   $html.='<tr>';
		 	      	   $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;">No.</td>';
		 	           $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;">CLAVE.</td>';
		 	           $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;">PLAN OPERATIVO</td>';
		 	           $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;">CENTRO</td>';
		 	           $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;">ESTADO</td>';
		 	           $html.='<td style="border:1px #999999 solid; background:#CCC; color:#333;">ROL</td>';
		 	           $html.='</tr>';
		 	           $j=1;
		 	      	   foreach($this->Model->planes as $plan){
		 	      	   	         
		 	      	   	         $html.='<tr>';
		 	                     $html.='<td style="border:1px #999999 solid; font-size:12px;">'.$j++.'</td>';
		 	                     $html.='<td style="border:1px #999999 solid; font-size:12px;">'.$plan['PK1'].'</td>';
		 	                     $html.='<td style="border:1px #999999 solid; font-size:12px;">'.htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1").'</td>';
		 	                     $html.='<td style="border:1px #999999 solid; font-size:12px;">'.$plan['PK_JERARQUIA'].'</td>';
		 	 					 $html.='<td style="border:1px #999999 solid; font-size:12px;">'.$plan['ESTADO'].'</td>';
		 	 					 $html.='<td style="border:1px #999999 solid; font-size:12px;">'.$plan['ROL'].'</td>';
		 	                     $html.='</tr>';
		 	      	   	
		 	      	   	
		 	      	   	}
		 	      	   	$html.='</table>';
		 	      	   	$html.='</td>';
		 	      	   	$html.='</tr>';
		 	      }else{
				  	// $html.='<tr><td colspan="5"><div class="empty_results">NO ESTA INSCRITO(A) EN UN PLAN OPERATIVO</div></td></tr>';
		 	      	  
				  	
				  }
		 	
		 	
		      }
		      $html.='</thead>';
		      
		 }
		
		$html.='</div></table>';
		
		echo $html;
	}
	
	
	

	
}

?>