<?php
include "models/usuarios/perfil.model.php";
include "libs/resizeimage/class.upload.php";


class perfil{

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $nodoprincipal;
	var $image;
	var $targetPathumbail;
	

	function perfil() {
		
     $this->passport = new Authentication();
	 $this->menu = new Menu();
	 $this->Model = new perfilModel();
		
	 switch($_GET['method']){
	 	
		case "Actualizar":
			$this->Actualizar();
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
		
		//if($this->passport->privilegios->hasPrivilege('P12')){
		$this->loadContent();
		//}else{
		//$this->error();
		//}
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
	 
	

	function error(){
		
		$contenido = $this->View->Template(TEMPLATE.'modules/error.tpl');
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
	}


  
	 function loadContent(){
	 	
		
		$row = $this->Model->ObtenerUsuario($_SESSION['session']['user']);
		$contenido = $this->View->Template(TEMPLATE.'modules/usuarios/EDTPERFIL.TPL');
		
		$imagen = $this->obtenerImagen($row['IMAGEN']);
		$contenido = $this->View->replace('/\#IMAGEN\#/ms' ,$imagen,$contenido);
		$contenido = $this->View->replace('/\#IMAGENOLD\#/ms' ,$row['IMAGEN'],$contenido);
		$contenido = $this->View->replace('/\#IDUSUARIO\#/ms' ,$_SESSION['session']['user'],$contenido);
		$contenido = $this->View->replace('/\#TITULO\#/ms' ,$row['TITULO'],$contenido);
		$contenido = $this->View->replace('/\#NOMBRE\#/ms' ,htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1"),$contenido);
		$contenido = $this->View->replace('/\#APELLIDOS\#/ms' ,htmlentities($row['APELLIDOS'], ENT_QUOTES, "ISO-8859-1"),$contenido);
		$contenido = $this->View->replace('/\#CORREO\#/ms' ,$row['EMAIL'],$contenido);
		$contenido = $this->View->replace('/\#USUARIO\#/ms' ,$row['PK1'],$contenido);
		
		$contenido = $this->View->replace('/\#PASSWORD\#/ms' ,$row['PASSWORD'],$contenido);
		
		
		$this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 
		 }
		 
		 
		 
		 function obtenerImagen($imagen){
		  	
			$imagenusuario ="media/usuarios/thum_100x100_";
			$imagendefault = "skins/admin/images/avatar-anonimo.png";
			
			if($imagen=="avatar.jpg"){
				$imagenusuario = $imagendefault;
				
			}else{
				$imagenusuario .= $imagen;
			}
		  	return $imagenusuario;
		  }
		 
	 

      function Actualizar(){
		 
		  if($_POST['editimagen']=="TRUE"){
		 	
		 	$this->uploadImage();
			$this->Model->image = $this->image;
		 }else{
		 	
		 $row = $this->Model->ObtenerUsuario($_POST['idusuario']);
		 
		 $this->Model->image = $row['IMAGEN'];
		 }
		
		
		//htmlentities($row['NOMBRE'], ENT_QUOTES, "ISO-8859-1")
		 
			$this->Model->usuario = $_POST['idusuario'];
			$this->Model->titulo = $_POST['titulo'];
			$this->Model->nombre = $_POST['nombre'];
			$this->Model->apellidos = $_POST['apellidos'];
			$this->Model->correo = $_POST['correo'];
			$this->Model->usuario = $_POST['usuario'];
			$this->Model->password = $_POST['password'];
			
			$_SESSION['session']['titulo'] = $_POST['titulo'];
			$_SESSION['session']['nombre'] = $_POST['nombre'];
			$_SESSION['session']['apellidos'] = $_POST['apellidos'];
			$_SESSION['session']['email'] = $_POST['correo'];
			$_SESSION['session']['imagen'] = $this->image;
			
			
			
	      	$this->Model->ActualizarUsuario();
			
	
		 
	
          }
		  
		  
		 function uploadImage(){
		
		//ELIMINAMOS IMAGEN ANTERIOR
		unlink("media/usuarios/".$_POST['imageold']);
		unlink("media/usuarios/thum_100x100_".$_POST['imageold']);
		unlink("media/usuarios/thum_40x40_".$_POST['imageold']);
		
	if($_FILES['imagearticulo']['name']){
		
	$this->targetPathumbail = "media/usuarios/";
	setlocale(LC_CTYPE, 'es');
	$this->image = strtolower(basename($_FILES['imagearticulo']['name']));
    
	$imagensinext = explode(".",$this->image);
	$name =  strtolower(uniqid('USER'));
	$this->image = strtolower($name.'.'.$imagensinext[1]);
	$imageupload = new Upload($_FILES['imagearticulo']);
	$imageupload->file_new_name_body = $name;
	
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
		 if ($imageupload->processed) {
             //creamos la imagen pequeña
	    
		 $imageupload->file_new_name_body =  'thum_40x40_'.$name; 
	     $imageupload->image_resize = true;
         $imageupload->image_y = 40;
         $imageupload->image_x = 40;
		 $imageupload->Process($this->targetPathumbail);
		 
		 if ($imageupload->processed) {
			unlink("media/usuarios/".$this->image);
			
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