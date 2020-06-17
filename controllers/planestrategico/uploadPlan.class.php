<?php
include "models/planestrategico/uploadPlan.model.php";
include "libs/resizeimage/class.upload.php";


class uploadPlan {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $image;
	var $targetPathumbail;
	var $adjunto;
	

	function uploadPlan() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("option");
	 $this->Model = new uploadPlanModel();
		
	 switch($_GET['method']){
	 	
		case "UploadFile":
			$this->UploadFile();
			break;
		
		case "Buscarobjetivos":
			$this->Buscarobjetivos();
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
		$this->loadContent();
		
		/*if($this->passport->privilegios->hasPrivilege('P12')){
		$this->loadContent();
		}else{
		$this->error();
		}*/
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
	 
		
	  $section = TEMPLATE.'modules/planestrategico/UPLOAD.TPL';
	  $section = $this->View->loadSection($section);
	  
	   $row = $this->getPlan();
	   $section = $this->View->replace('/\#TITULO\#/ms' ,htmlentities($row['TITULO']),$section);
	   $urlmenu = '?execute=planestrategico/previewplan&method=default&Menu=F1&SubMenu=SF11&IDPlan='.$row['PK1'].'';
	   $section = $this->View->replace('/\#MENUURL\#/ms' ,$urlmenu,$section);
	   
	   $section = $this->View->replace('/\#IDPLAN\#/ms' ,$_GET['IDPlan'],$section);
	   
	  
	   $urlcancelar = '?execute=planestrategico/adjuntos&method=default&Menu=F1&SubMenu=SF11&IDPlan='.$row['PK1'].'#&p=1&s=25&sort=1&q=';
	   $section = $this->View->replace('/\#URLCANCELAR\#/ms' ,$urlcancelar,$section);
	   
	   $this->View->replace_content('/\#CONTENT\#/ms' ,$section);
	 
	  }
	 
	 
	
	
	function getPlan(){
	
	$row = $this->Model->getPlan($_GET['IDPlan']);
	
	return $row;
			
	}
	 
	 
	 function getLineasPlan(){
	 	
	 	$this->Model->getLineasPlan();
		$numlineas = sizeof($this->Model->lineas);
		$lineas = "";
		if($numlineas != 0){
		foreach($this->Model->lineas as $row){
			
		    $lineas .= "<option value=\"".$row['PK1']."\">".htmlentities($row['LINEA'])."</option>";
			
			}
		}
		return $lineas;
	   }
	   
	   
	   
	   
	   
	   function Buscarobjetivos(){
	 	
	 	$this->Model->getObjetivosPlan($_GET['linea']);
		$numlineas = sizeof($this->Model->objetivos);
		$objetivos = "";
		if($numlineas != 0){
		foreach($this->Model->objetivos as $row){
			
		    $objetivos .= "<option value=\"".$row['PK1']."\">".htmlentities($row['OBJETIVO'])."</option>";
			
			}
		}
		echo $objetivos;
	   }
	   
	   
	 
	 

      function UploadFile(){
		
		
	  $filext = strtolower(basename($_FILES['imagearticulo']['name']));
	  $filext = explode(".",$filext);
	  $tipofile = $filext[1];
		
	   switch($tipofile){
	   	
		case "jpg":
		case "png":
		    $this->Model->tipo = "IMG";
			$this->UploadImagen();
			break;
		
		   	
		case "doc":
		case "docx":
			$this->UploadArchivo();
			$this->Model->tipo = "DOC";
			$this->image = "media/thumbnails/thum_ik_word.png";
			break;
		
		case "ppt":
		case "pptx":
			$this->UploadArchivo();
			$this->Model->tipo = "PPT";
			$this->image = "media/thumbnails/thum_ik_ppt.png";
			break;
		
		case "pdf":
		$this->UploadArchivo();
		$this->Model->tipo = "PDF";
		$this->image = "media/thumbnails/thum_ik_pdf.png";
			break;
		
		
		case "zip":
		$this->UploadArchivo();
		$this->Model->tipo = "ZIP";
			break;
			
			
		default:	
	      $this->View = new View(); 
          $this->loadPage();
		  break;
		}
			
		   
		     
			$this->Model->idplan = $_POST['idplan'];
			$this->Model->titulo = $_POST['titulo'];
			$this->Model->autor = $_POST['autor'];
			$this->Model->descripcion = $_POST['descripcion'];
			$this->Model->imagen = $this->image;
			$this->Model->adjunto = $this->adjunto;
			
			$this->Model->UploadFile();
			
	
          }


     function UploadImagen(){
		 	
	
	if($_FILES['imagearticulo']['name']){
		
	$this->targetPathumbail = "media/planesestrategicos/";
	setlocale(LC_CTYPE, 'es');
	$image = strtolower(basename($_FILES['imagearticulo']['name']));
    $this->adjunto = $this->targetPathumbail.$image;
	$imagensinext = explode(".",$image);
	$name =  strtolower(uniqid('IMG'));
	$image = strtolower($name.'.'.$imagensinext[1]);
	$imageupload = new Upload($_FILES['imagearticulo']);
	$imageupload->file_new_name_body = $name;
	
	if ($imageupload->uploaded) {
	
         $imageupload->Process($this->targetPathumbail);
            if ($imageupload->processed) {


			//Escalamos la imagen para thumbail
		 $imageupload->file_new_name_body = 'thum_170x170_'.$name;
	     $imageupload->image_resize = true;
         $imageupload->image_ratio_fill = true;
         $imageupload->image_y = 170;
         $imageupload->image_x = 170;
		 $this->image = $this->targetPathumbail.'thum_170x170_'.$name.	'.'.$imagensinext[1];
		 $imageupload->Process($this->targetPathumbail);
		 if ($imageupload->processed) {
             //creamos la imagen pequeña
	    
		 $imageupload->file_new_name_body =  'thum_40x40_'.$name; 
	     $imageupload->image_resize = true;
         $imageupload->image_y = 40;
         $imageupload->image_x = 40;
		 $imageupload->Process($this->targetPathumbail);
		 
		 if ($imageupload->processed) {
			
			return TRUE;

				}
			 	 
    
         } else {
         return FALSE; //ERROR THUMBAIL
          }
			
             } else {
               return FALSE; //echo 'error : ' . $foo->error;
             }
			 
			 //SI NO ANEXARON  IMAGEN
			 }else{
			 	
				return TRUE;
			 }
			
     }
		  
		  }
		
	
	
	
	 function UploadArchivo(){
		 	
	
	if($_FILES['imagearticulo']['name']){
		
	$this->targetPathumbail = "media/planesestrategicos/";
	setlocale(LC_CTYPE, 'es');
	$this->image = strtolower(basename($_FILES['imagearticulo']['name']));
    $this->adjunto = $this->image;
	$imagensinext = explode(".",$this->image);
	$name =  strtolower(uniqid(file));
	$this->image = strtolower($name.'.'.$imagensinext[1]);
	$imageupload = new Upload($_FILES['imagearticulo']);
	$imageupload->file_new_name_body = $name;
	
	if ($imageupload->uploaded) {
	
         $imageupload->Process($this->targetPathumbail);
            if ($imageupload->processed) {

                 return TRUE;
			
             } else {
               return FALSE; //echo 'error : ' . $foo->error;
             }
			 
			 //SI NO ANEXARON  IMAGEN
			 }else{
			 	
				return TRUE;
			 }
			
     }
		  
		  }
	
	  
	  
	
	
	
	

	
}

?>