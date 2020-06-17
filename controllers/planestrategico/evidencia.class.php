<?php
include "models/planestrategico/evidencia.model.php";


class evidencia {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $passport;
	

	function evidencia() {
		
	   $this->Model = new evidenciaModel();
	   $this->passport = new Authentication();
	   	
	   
	   
	   switch($_GET['method']){
	   	
		case "insertarComentario":
			$this->insertarComentario();
			break;
			
		case "descargar":
			$this->descargar();
			break;
			
		default:	
	      $this->View = new View();
          $this->viewRecurso();
		  break;
	
			
		}
		
	
	    
	   						 
	
	}
	

	function viewRecurso(){
	
	    $row = $this->Model->getRecurso($_GET['id']);
		$titulo = $row['TITULO'];
		$tiporecurso = $row['TIPO'];
		$imagen  = $row['IMAGEN'];
		$adjunto = $row['ADJUNTO'];
		$preview = "<img src='".STORAGE_ACCOUNT_CONTAINER."/".CONTAINER_NAME."/"."media/planesestrategicos/thum_340x220_".$imagen.KEY_ACCESS_BLOBS."'/>";
		//STORAGE_ACCOUNT_CONTAINER."/".CONTAINER_NAME."/media/planesestrategicos/thum_170x170_".$row['IMAGEN'].KEY_ACCESS_BLOBS;
		$autor = $row['AUTOR'];
		$formato = "";
		
		$categoria = "";
		$linkdescarga  = "";
		$opciondescarga  = "";
		
		 if($row['DESCRIPCION']==""){
		   $descripcion = "No existe descripci�n";	
		 }else{
		 	$descripcion = $row['DESCRIPCION'];
		 }
		
	 	
	   switch(trim($tiporecurso)){
	   case "IMG":
	   $formato = strtoupper($imagen[1]);
	   
	    $dirdownload = $row['ADJUNTO'];
	   $linkdescarga = "descargar('".$dirdownload."');return false;";
	   
	   break;
	   
	   
	   
	   case "AUD":
	   $dirdownload = $row['ADJUNTO'];
	   $linkdescarga = "descargar('".$dirdownload."');return false;";
	   
	   $adjuntoex = explode(".",$row['ADJUNTO']);
	   $formato = strtoupper($adjuntoex[1]);
	   
	   switch($adjuntoex[1]){
		case "mp3":
		

        $preview ='<div id="myElement">Loading the player...</div>

<script type="text/javascript">


    jwplayer("myElement").setup({
      file: "'.$adjunto.'",
      width: "100%",
      height: 30
    });


	
	
</script>';
	
	   break;
	   }
	   break;
	   
	   case "VID":
	   
	   $dirdownload = $row['ADJUNTO'];
	   $linkdescarga = "descargar('".$dirdownload."');return false;";
	   
	   $adjuntoex = explode(".",$row['ADJUNTO']);
	   $formato = strtoupper($adjuntoex[1]);
	   
	  
	   
	   switch($adjuntoex[1]){
		case "mp4":
		case "m4v":
		case "flv":
		case "avi":
		
	
		
		//$imagenpreview = 'media/galeria/videos/preview/'.$row[9];
		$imagenpreview = "";


        $preview ='
		
			<div id="myElement">Loading the player...</div>

<script type="text/javascript">
    jwplayer("myElement").setup({
        file: "'.$adjunto.'",
		width: \'100%\',
        height: \'360\'
    });
</script>
			';
		
		break;
		
		case "mov":
		
        $preview ='<embed width="100%" height="360" name="plugin" src="'.$adjunto.'" type="video/quicktime"></embed>
        <p>Si no puedes ver el video baja <a target="_blank" href="http://www.apple.com/es/quicktime/download/">Quicktime</a></p>';
		
		break;
		
		case "wmv":
		
		$preview ='<OBJECT ID="MediaPlayer" WIDTH="340" HEIGHT="220" CLASSID="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95"
STANDBY="Loading Windows Media Player components..." TYPE="application/x-oleobject">
<PARAM NAME="FileName" VALUE="'.$adjunto.'">
<PARAM name="autostart" VALUE="false">
<PARAM name="ShowControls" VALUE="true">
<param name="ShowStatusBar" value="false">
<PARAM name="ShowDisplay" VALUE="false">
<EMBED TYPE="application/x-mplayer2" SRC="'.$video.'" NAME="MediaPlayer"
WIDTH="340" HEIGHT="220" ShowControls="1" ShowStatusBar="0" ShowDisplay="0" autostart="0"> </EMBED>
</OBJECT>';
       $dirdownload = $row['ADJUNTO'];
       $linkdescarga = "descargar('".$dirdownload."');return false;";	
		break;
		
		
		
	    }
		
		break;
		
		
		
	   case "DOC":
	   $preview ='<img src="'.$row['IMAGEN'].'"  />';
	   $dirdownload = $row['ADJUNTO'];
	   $linkdescarga = "descargar('".$dirdownload."');return false;";	
	   break;
		
		
	  case "TXT":
	   $preview ='<img src="'.$row['IMAGEN'].'"  />';
	   $dirdownload = $row['ADJUNTO'];
	   $linkdescarga = "descargar('".$dirdownload."');return false;";	
	   break;
	   
	   
	   default:
	    $preview ='<img src="'.$row['IMAGEN'].'"  />';
	   $dirdownload = $row['ADJUNTO'];
	   $linkdescarga = "descargar('".$dirdownload."');return false;";	
	   break;
		
	
		
	         }
	
	
	  
	    if(!$this->passport->getPrivilegio($_GET['IDPlan'],'P34')){
         $linkdescarga = "void(0);return false;";
		 }

		 $dirdownload_file = STORAGE_ACCOUNT_CONTAINER."/".CONTAINER_NAME."/".$dirdownload.KEY_ACCESS_BLOBS;
		 $btndescargar = '<a type="button"  style="text-decoration: none;" class="btn btn-warning" href="'.$dirdownload_file.'" value="Descargar"/>Descargar</a>';


		$this->View->template = TEMPLATE.'modules/planestrategico/EVIDENCIA.TPL';
		$this->View->loadTemplate();
		
		
		$this->View->replace_content('/\#TITULO\#/ms' ,$titulo);
		$this->View->replace_content('/\#PREVIEW\#/ms' ,$preview);
        
		$this->View->replace_content('/\#AUTOR\#/ms' ,htmlentities($autor));
		$this->View->replace_content('/\#DESCRIPCION\#/ms' ,htmlentities($descripcion));	

		$this->View->replace_content('/\#FORMATO\#/ms' ,$formato);
		$this->View->replace_content('/\#CATEGORIA\#/ms' ,$categoria);
		
	
		$this->View->replace_content('/\#AUTOR\#/ms' ,$row['AUTOR']);
		$this->View->replace_content('/\#FECHA\#/ms' ,$row['FECHA_R']->format('Y-m-d'));
		$this->View->replace_content('/\#BTNDESCARGAR\#/ms' ,$btndescargar);
		//$this->View->replace_content('/\#LINKDESCARGA\#/ms' ,$linkdescarga);
		$this->View->replace_content('/\#OPCIONDESCARGA\#/ms' ,$opciondescarga);
		
		$this->View->replace_content('/\#COMENTARIOS\#/ms' ,$this->getComentarios());
		
		$this->View->viewPage();
	
	 }
	  
	  
	  
	  
	  function insertarComentario(){
	  	
			$id = $this->Model->insertarComentario($_POST['comentario'],$_POST['idevidencia']);
			$usuario = $_SESSION['session']['titulo'].' '.$_SESSION['session']['nombre'].' '.$_SESSION['session']['apellidos'];
		    $imagen = 'media/usuarios/thum_40x40_'.$_SESSION['session']['imagen'];
			
			$fecha = date("d/m/Y H:i:s");
			
			echo '<div class="stbody" style="background:#FFF" id="stbody'.$id.'">
    <div class="sttimg"><img src="'.$imagen.'" class="big_face"/></div> 
    <div class="sttext"><a class="stdeleter" href="#" id="'.$id.'" title="Borrar comentario"><i class="icon-remove"></i></a>
	<strong><a href="#">'.htmlentities($usuario).'</a></strong><br/>
    '.$_POST['comentario'].'
   	<div class="sttime">'.$fecha.'</div> 
</div>';
	  }
	  
	  
	  function getComentarios(){
	  	
	 $panelcontent ="";
	  $this->Model->getComentarios($_GET['id']);
		       $numcomentarios = sizeof($this->Model->comentarios); 
		  
		            
					if($numcomentarios != 0){
			
						foreach($this->Model->comentarios as $rowcomentariosr){
 						{
							
							
							$comentario_id=$rowcomentariosr['PK1'];
							$usuario_id=$rowcomentariosr['PK_USUARIO'];
							$fecha = $rowcomentariosr['FECHA_R'];
							
							$comentario = stripslashes(htmlentities($rowcomentariosr['COMENTARIO']));
						     
							 $comentario = $comentario;	
						
							$rowusuario	= $this->Model->getImagen($usuario_id);	
							$imagen =  "media/usuarios/".$rowusuario['IMAGEN'];
							
							$usuario = $rowusuario['NOMBRE']." ".$rowusuario['APELLIDOS'];
							 
							 
							
							 
				$panelcontent .='<div class="stbody" style="background:#FFF" id="stbody'.$comentario_id.'">
    		<div class="sttimg"><img src="'.$imagen.'" class="big_face"/></div> 
    		<div class="sttext">';
			
			//if($this->passport->privilegios->hasPrivilege('P52')){
		   $panelcontent .='<a class="stdeleter" href="#" id="'.$comentario_id.'" title="Borrar comentario"><i class="icon-remove"></i></a>';
		   //}
			
			 $panelcontent .= '<strong><a href="#" class="comentuser">'.htmlentities($usuario).'</a></strong><br/>
						'.$comentario.'
   						<div class="sttime">'.date('d/m/Y H:i:s', strtotime($fecha->format('Y-m-d'))).'</div> 
    				</div>  
				</div>';
    
 		}
	 }
	
	}
	
	  return $panelcontent;
	}
	 
	
	function youtube($string,$autoplay=0,$width=480,$height=390)
{
    preg_match('#(?:http://)?(?:www\.)?(?:youtube\.com/(?:v/|watch\?v=)|youtu\.be/)([\w-]+)(?:\S+)?#', $string, $match,0);
    $embed = <<<YOUTUBE
        <div align="center">
            <iframe title="YouTube video player" width="$width" height="$height" src="http://www.youtube.com/embed/$match[1]?autoplay=$autoplay" frameborder="0" allowfullscreen></iframe>
        </div>
YOUTUBE;

    return str_replace($match[0], $embed, $string);
}




      function descargar(){
	      
		 // Definimos el nombre de archivo a descargar.
	     $url = explode("/",$_GET['file']);
	     $filename = trim(array_pop($url));
		 
        // Ahora guardamos otra variable con la ruta del archivo
        $file = trim($_GET['file']);
        // Aqu�, establecemos la cabecera del documento
        header("Content-Description: Descargar imagen");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/force-download");
        header("Content-Length: " . filesize($file));
        header("Content-Transfer-Encoding: binary");
        readfile($file);
      
	  }
	
	
}

?>