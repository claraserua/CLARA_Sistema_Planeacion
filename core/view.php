<?php
include_once('html.php');

class View extends html
{
	var  $html;
	var  $template;
	
	function View(){
	 		
	}
	
	
	function loadTemplate()
	{ 
		$this->html = file_get_contents($this->template);
	}
	  
	  
	 
	 function Template($dir)
	  { 
		return file_get_contents($dir);
	  }
	
	
	 
	 function loadTemplatesss($template){
		$pagina = $this->load_page('app/views/default/page.php');
		$header = $this->load_page('app/views/default/sections/s.header.php');
		$pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
		$pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);				
		$menu_left = $this->load_page('app/views/default/sections/s.menuizquierda.php');
		$pagina = $this->replace_content('/\#MENULEFT\#/ms' ,$menu_left , $pagina);
		return $pagina;
	}
	
	

	
	
	
	 /* METODO QUE CARGA UNA PAGINA DE LA SECCION VIEW Y LA MANTIENE EN MEMORIA
		INPUT
		$page | direccion de la pagina 
		OUTPUT
		STRING | devuelve un string con el codigo html cargado*/
	 
	 function loadSection($section)
	  {
		return file_get_contents($section);
	  }
	  
	  
	 
	function replace($in='/\#CONTENIDO\#/ms', $out, $string)
	{
		return $html = preg_replace($in, $out , $string);	 	
	}
	  
	  
	  
	function replace_content($in='/\#CONTENIDO\#/ms', $out)
	{
		 $this->html = preg_replace($in, $out, $this->html);	 	
	}
	  
	  
	
	  
    function viewPage()
	  {
		echo $this->html;
	  }
	
	

}

// END
