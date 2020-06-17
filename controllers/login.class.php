<?php
include "models/login.model.php";

class login {

    var $View;
	var $Model;
	
	
	function login() 
	{
	 $this->View = new View();
	 $this->Model = new loginModel();
	 $this->loadPage();
     $this->View->viewPage();
	}
		 

	 function loadPage()
	 {
		 
	 $this->View->template = TEMPLATE.'login.tpl';
	 $this->View->loadTemplate();
	 $this->loadLogin();	
	 } 
		
		

	 function loadLogin()
	 {
	  
	  if(isset($_GET['preview'])){
		 
		  $section = TEMPLATE.'sections/loginpreview.tpl';
	  }
	  
	  else{
		  
       
	  if(isset($_GET['error'])){
         if($_GET['error']=="login"){
			//$section = TEMPLATE.'sections/login_mantenimiento.tpl';
            $section = TEMPLATE.'sections/logine.tpl';
         }
		 else if($_GET['error']=="recordarpassword"){
            $section = TEMPLATE.'sections/olvido.tpl';
         }
         else if($_GET['error']=="enviado"){
            $section = TEMPLATE.'sections/olvido.tpl';
         }
        
		 }
		 
		 else{
			//$section = TEMPLATE.'sections/login_mantenimiento.tpl';
			$section = TEMPLATE.'sections/login.tpl';	
		 }
		 
	  }
	 
	 $section = $this->View->loadSection($section);
	 $section = $this->View->replace('/\#TOKEN\#/ms' ,md5(uniqid(mt_rand(), true)),$section);
	 $this->View->replace_content('/\#LOGIN\#/ms' ,$section);	
	 }
	 

}//END CLASS

?>