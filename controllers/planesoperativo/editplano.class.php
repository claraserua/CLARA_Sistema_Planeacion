<?php
include "models/planesoperativo/editplano.model.php";
include "libs/resizeimage/class.upload.php";


class editplano {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $image;
	var $targetPathumbail;
	var $script;
	var $nodoprincipal;
	

	function editplano() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->Model = new editplanoModel();
	 $this->nodoprincipal = new Niveles("option");
		
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
		
		if($this->passport->privilegios->hasPrivilege('P26')){
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
	 	
		
		$contenido = $this->View->Template(TEMPLATE.'modules/planesoperativo/EDTPLAN.TPL');
		
		$row = $this->Model->getPlanO($_GET['IDPlan']);
		
		
		$contenido =  $this->View->replace('/\#IDPLAN\#/ms' ,htmlentities($row['PK1']),$contenido);
		
		$contenido =  $this->View->replace('/\#TITULO\#/ms' ,htmlentities($row['TITULO'], ENT_QUOTES, "ISO-8859-1"),$contenido);
		
		$contenido =  $this->View->replace('/\#DESCRIPCION\#/ms' ,htmlentities($row['DESCRIPCION'], ENT_QUOTES, "ISO-8859-1"),$contenido);
		
		/*DISPONIBILIDAD*/
	    if($row['DISPONIBLE']==0){
		$contenido =  $this->View->replace('/\#NODISPONIBLE\#/ms' ,'checked="checked"',$contenido);
		}else{
		$contenido =  $this->View->replace('/\#DISPONIBLE\#/ms' ,'checked="checked"',$contenido);
		}
		
		
		$contenido =  $this->View->replace('/\#FECHAINICIO\#/ms' ,$row['FECHA_I']->format('Y-m-d'),$contenido);
		$contenido =  $this->View->replace('/\#FECHATERMINO\#/ms' ,$row['FECHA_T']->format('Y-m-d'),$contenido);
		
	
		
	
		$contenido = $this->View->replace('/\#PERIODOSDESEGUIMIENTO\#/ms' ,$this->getPeriodos(),$contenido);
			
		$contenido = $this->View->replace('/\#SCRIPT\#/ms' ,$this->script,$contenido);	
		
		
		$contenido =  $this->View->replace('/\#NODOSPRINCIPAL\#/ms' ,$this->nodoprincipal->nodos,$contenido);
			
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 }
	 

         function GuardarPlan(){
		
		    $this->Model->idplan = $_POST['idplan'];
			$this->Model->titulo = $_POST['titulo'];
			$this->Model->descripcion = $_POST['descripcion'];
			$this->Model->disponible = $_POST['disponible'];
			$this->Model->fechai = $_POST['finicio'];
			$this->Model->fechat = $_POST['ftermino'];
			$this->Model->jerarquia = $_POST['jerarquia'];
			$this->Model->plan = $_POST['IDPlanEstrategico'];
			
			
			
			$this->Model->seguimiento = explode("|",$_POST['seguimiento']);
			
			$this->Model->GuardarPlan();
			

          }
		  
		  
		
	
		function getPlanE(){
	    $row = $this->Model->getPlanE($_GET['IDPlanEstrategico']);
	    return $row;	
      	}
	
	  
	  
	  function getPeriodos(){
	  	
		$panelcontent = "";
		$script = "<script>";
		
		
		$this->Model->idplan = $_GET['IDPlan'];
		
		$this->Model->getPeriodos();
		$numperiodos = sizeof($this->Model->periodos); 
        
		
		if($numperiodos != 0){
		
		$cont=1;
		foreach($this->Model->periodos as $row){
		
		$id = $row['PK1'];		
        $periodo = $row['PERIODO'];
	    $fechai = $row['FECHA_I'];
		$fechat = $row['FECHA_T'];
		
		$script .= "arrayperiodos.push('1');";
		
	   	$panelcontent .=' 
        <tr id="P'.$cont.'">
        <td>&nbsp; </td>
        <td width="505">  
        <div class="input-prepend">
		<span class="add-on" id="LABEL-P'.$cont.'">'.$cont.'.</span>
        <input type="text" value="'.htmlentities($periodo, ENT_QUOTES, "ISO-8859-1").'" style="width:400px;" id="P'.$cont.'-S'.$cont.'">
		</div> 
        </td>                          
        <td width="135"><input type="text" value="'.$fechai->format('Y-m-d').'"  style="width:130px;" class="finicio" id="P'.$cont.'-I'.$cont.'"></td>
        <td><input type="text" value="'.$fechat->format('Y-m-d').'" style="width:130px;" class="ftermino" id="P'.$cont.'-T'.$cont.'"></td>
        </tr>';
		
		
		$cont++;
		  }
		}
		
		
		$script .= "</script>";
		
		$this->script = $script;
			
		
		return $panelcontent;
		
	  }
	  
	
	
	
	

	
}

?>