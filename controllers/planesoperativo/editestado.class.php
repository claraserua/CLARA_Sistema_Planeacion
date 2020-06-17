<?php
include "models/planesoperativo/editestado.model.php";
include "libs/resizeimage/class.upload.php";


class editestado {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $image;
	var $targetPathumbail;
	var $script;
	var $estado;
	

	function editestado() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->Model = new editestadoModel();
		
	 switch($_GET['method']){
	 	
		case "GuardarPlan":
			$this->GuardarPlan();
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
		
		if($this->passport->privilegios->hasPrivilege('P40')){
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
	 	
		
		$contenido = $this->View->Template(TEMPLATE.'modules/planesoperativo/ESTADO.TPL');
		
		$row = $this->Model->getPlanO($_GET['IDPlan']);
		
		
		$contenido =  $this->View->replace('/\#IDPLAN\#/ms' ,htmlentities($row['PK1']),$contenido);
		
		$contenido =  $this->View->replace('/\#TITULO\#/ms' ,htmlentities($row['TITULO'], ENT_QUOTES, "ISO-8859-1"),$contenido);
		$this->estado = $row['ESTADO'];
		
		
		$estadoseguimiento = '';
		$this->Model->getPeriodos($_GET['IDPlan']);

		$numperiodos = sizeof($this->Model->periodos); 
		
		$i = 1;
		
		 
		 if($numperiodos != 0){
		 	
	        foreach($this->Model->periodos as $rowperiodos){
	        	
	        	
	     $barcheckS ='';
		 $barcheckI ='';      	
	       if(trim($this->estado)=='S' && ( $rowperiodos['ENVIADO']==0 && $rowperiodos['ORDEN']== 1)){
	        	 
	        						
					$barcheckS .='checked="checked"';
				
			
			}
			
			else if(trim($this->estado)=='S' && $rowperiodos['ENVIADO']==2){
				 $barcheckS .='checked="checked"';
				
			}
			
			else if(trim($this->estado)=='I' && $rowperiodos['ENVIADO']==1){
				
				  $barcheckI .='checked="checked"';
			}
	        	
				
			$estadoseguimiento .= '<div><p>'.$rowperiodos['PERIODO'].'</p></div><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" '.$barcheckS.' value="S#%#'.$rowperiodos['PK1'].'#%#'.$i.'" name="estado" class="input-xlarge focused">


							   &nbsp;<span class="label label-success">Seguimiento</span> <span class="label label-revision">Elaborando Informe</span><br/><br/>					   
							   
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" '.$barcheckI.' value="I#%#'.$rowperiodos['PK1'].'#%#'.$i.'" name="estado" class="input-xlarge focused">
							   &nbsp;<span class="label label-success">Seguimiento</span> <span class="label label-revision">Revisando Informe</span><br/><br/>';
							   
							   $i++;
			
				
				
		   }
		   
		  
			
			
		}
		
			
				$contenido =  $this->View->replace('/\#PERIODOESTADO\#/ms' ,$estadoseguimiento,$contenido);		   
		
		
		/*ESTADO*/
	    
		$estado = trim($row['ESTADO']);
		

		switch($estado){
			
			case "G":
			$contenido =  $this->View->replace('/\#PENDIENTE\#/ms' ,'checked="checked"',$contenido);
			break;
			
			case "E":
			$contenido =  $this->View->replace('/\#REVISIONORUA\#/ms' ,'checked="checked"',$contenido);
			break;
			
			case "R":
			$contenido =  $this->View->replace('/\#REVISIONUNI\#/ms' ,'checked="checked"',$contenido);
			break;
			
			
			case "S":
			//$contenido =  $this->View->replace('/\#SEGUIMIENTO\#/ms' ,'checked="checked"',$contenido);
			break;
			
			
			case "I":
			//$contenido =  $this->View->replace('/\#INFORME\#/ms' ,'checked="checked"',$contenido);
			break;
			
			
			case "T":
			$contenido =  $this->View->replace('/\#TERMINADO\#/ms' ,'checked="checked"',$contenido);
			break;
			
		}
	
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 }
	 

         function GuardarPlan(){
		
		    $this->Model->idplan = $_POST['idplan'];
			$this->Model->estado = trim($_POST['estado']);
			$this->Model->idPeriodo = $_POST['idPeriodo'];
			$this->Model->contador = (int)$_POST['contador'];
			$this->Model->GuardarPlan();
			
          }
		  	  
	

	
}

?>