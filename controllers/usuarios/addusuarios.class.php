<?php
include "models/usuarios/addusuarios.model.php";
include "libs/resizeimage/class.upload.php";
include "core/storage-blobs-php-quickstart/phpQS_Class.php";


class addusuarios {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $nodoprincipal;
	var $nodosreportes;
	var $image;
	var $targetPathumbail;
	var $object_Blob;
	

	function addusuarios() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->nodos = new Niveles("filtro");
	 $this->nodoprincipal = new Niveles("option");
	 $this->nodosreportes = new Niveles("reportes");
	 $this->Model = new addusuariosModel();
	 $this->object_Blob = new phpQS();
		
	 switch($_GET['method']){
	 	
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
	 	
		$contenido = $this->View->Template(TEMPLATE.'modules/usuarios/ADDUSUARIO.TPL');
		$contenido =  $this->View->replace('/\#NODOS\#/ms' ,$this->nodos->nodos,$contenido);	
		
		$contenido =  $this->View->replace('/\#NODOSPRINCIPAL\#/ms' ,$this->nodoprincipal->nodos,$contenido);

		$contenido =  $this->View->replace('/\#NODOSREPORTES\#/ms' ,$this->nodosreportes->nodos,$contenido);
		
		$this->Model->obtenerRoles();
		$roles = "";
		foreach($this->Model->roles as $row){
		    $roles .= '<option value="'.$row['PK1'].'">'.htmlentities($row['ROLE'], ENT_QUOTES, "ISO-8859-1").'</option>';
			}
		
		$contenido =  $this->View->replace('/\#ROLES\#/ms' ,$roles,$contenido);	
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 
		 }
	 

         function GuardarUsuario(){
		 
		 if($this->Model->ExisteUsuario($_POST['usuario'])){
		 	
			echo "existe";//ERROR
			
		 }else{
		 	
		 if($this->uploadImage()){
		 	$this->Model->image = $this->image;
			$this->Model->titulo = $_POST['titulo'];
			$this->Model->nombre = $_POST['nombre'];
			$this->Model->apellidos = $_POST['apellidos'];
			$this->Model->correo = $_POST['correo'];
			$this->Model->usuario = $_POST['usuario'];
			$this->Model->password = $_POST['password'];
			$this->Model->jerarquia = $_POST['jerarquia'];
			
			$this->Model->rolesUsuario = $_POST['sel2'];
			$this->Model->disponible =  ($_POST['disponible']=="") ? 0 : $_POST['disponible'];
			$this->Model->niveles = $_POST['niveles'];
			$this->Model->reportes = $_POST['reportes'];
	      	$this->Model->GuardarUsuario();
			
			}else{
				echo "false";//ERROR
			}
		 }
	
          }
		  
		  
	function uploadImage(){
		 	
		
	if($_FILES['imagearticulo']['name']){
		
	$this->targetPathumbail = "media/usuarios";
	setlocale(LC_CTYPE, 'es');
	$this->image = strtolower(basename($_FILES['imagearticulo']['name']));
    $handle = $_FILES["imagearticulo"]["tmp_name"];	
	$imagensinext = explode(".",$this->image);
	$name =  strtolower(uniqid('user'));
	$this->image = strtolower($name.'.'.$imagensinext[1]);
	$imageupload = new Upload($_FILES['imagearticulo']);
	$imageupload->file_new_name_body = $name;
	//$this->object_Blob->cargandoBlob($this->image, $handle, "/".$this->targetPathumbail);
	if ($imageupload->uploaded) {
	
         $imageupload->Process($this->targetPathumbail);
            if ($imageupload->processed) {


			//Escalamos la imagen para thumbail
		 $imageupload->file_new_name_body = 'thum_100x100_'.$name;
	     $imageupload->image_resize = true;
         $imageupload->image_ratio_fill = true;
         $imageupload->image_y = 100;
		 $imageupload->image_x = 100;
		 
		 $imageupload->Process($this->targetPathumbail);
		 //$this->object_Blob->cargandoBlob('thum_100x100_'.$this->image, $this->targetPathumbail."/".'thum_100x100_'.$this->image, "/".$this->targetPathumbail);
		 //unlink($this->targetPathumbail."/".'thum_100x100_'.$this->image);
		 if ($imageupload->processed) {
             //creamos la imagen pequeña
	    
		 $imageupload->file_new_name_body =  'thum_40x40_'.$name; 
	     $imageupload->image_resize = true;
         $imageupload->image_y = 40;
         $imageupload->image_x = 40;
		 $imageupload->Process($this->targetPathumbail);
		 //$this->object_Blob->cargandoBlob('thum_40x40_'.$this->image, $this->targetPathumbail."/".'thum_40x40_'.$this->image, "/".$this->targetPathumbail);
		 //unlink($this->targetPathumbail."/".'thum_40x40_'.$this->image);
		 unlink($this->targetPathumbail."/".$this->image);
		 if ($imageupload->processed) {
			
			return TRUE;

					 }
				
				}
			 	 
    
         } else {
         return FALSE; //ERROR THUMBAIL
          }
			
             } else {
               return FALSE; //echo 'error : ' . $foo->error;
             }
			 
			 //SI NO ANEXARON  IMAGEN
			 }else{
			 	$this->image= "avatar.jpg";
				return TRUE;
			 }
			
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