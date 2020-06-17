<?php
include "models/apoyos/apoyos.model.php";
include "libs/resizeimage/class.upload.php";
include "core/storage-blobs-php-quickstart/phpQS_Class.php";

class apoyos {

    var $View;
	var $Model;
	var $menu;
	var $nodos;
	var $image;
	var $targetPathumbail;
	var $object_Blob;

	function apoyos() {
	 $this->menu = new Menu("F1","SF4");
	 $this->nodos = new Niveles("filtro");
	 $this->View = new View();
	 $this->Model = new apoyosModel();
	 $this->passport = new Authentication();
	 $this->object_Blob = new phpQS();

	
	
	 switch($_GET['method']){
	 	
		case "Buscar":
			$this->Buscar();
			break;
	   
	   case "UploadFile":
			$this->UploadFile();
			break;
			
	   case "popup":
			$this->viewRecurso();
			break;
			
		case "Eliminar":
			$this->Eliminar();
			break;
			
		default:	
          $this->loadPage();
		  break;
		}
	
				 
		 
	}
	
	
	
	 function loadPage(){
	
		$this->View->template = TEMPLATE.'modules/planestrategico/GALERIA.TPL';	
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
	 	 
	
	 function  loadMenu(){

	 $menu =   $this->menu->menu; 
	 $this->View->replace_content('/\#MENU\#/ms' ,$menu);
	  
	 }
	 
	
    function loadNodos(){
	
	$nodos =  $this->nodos->nodos;	 
	$this->View->replace_content('/\#NODOS\#/ms' ,$nodos);
	 
	 
	 }
	
	 
 
 
	 function loadContent(){
	 	
		
	  $section = TEMPLATE.'modules/apoyos/ADJUNTOS.TPL';
	  $section = $this->View->loadSection($section);
	  
	  
	   $urlupload = '?execute=apoyos/uploadapoyo&method=default&Menu=F4&SubMenu=SF41';
	   
	   $urlupload = '<a href="'.$urlupload.'"><button type="button" class="btn btn-small btn-warning"><i class="icon-upload icon-white"></i>&nbsp;Agregar Archivo</button></a>';
	   
	   if($this->passport->privilegios->hasPrivilege('P152')){
	   $section = $this->View->replace('/\<!--#URLUPLOAD#-->/ms' ,$urlupload,$section);
	   }
	   
	   $this->View->replace_content('/\#CONTENT\#/ms' ,$section);
		 
		 }
		 
		 
	
	
		 
		
	 function Buscar(){
		
		$this->Model->buscarArchivos();
		$recurso = $this->getPaginadoHeader();
		$recurso .= "#%#";
	
		$numrecursos = sizeof($this->Model->archivos);
		$total = $this->Model->totalnum;
		
		if($numrecursos != 0){
			
		foreach($this->Model->archivos as $row){
			
			$titulo = $row['TITULO'];
				
			
			$fecha = date('d-m-Y', strtotime($row['FECHA_R']->format('Y-m-d')));
			$formato = $row['TIPO'];
			$linkrecurso = "WindowOpen('".$row['PK1']."');return false;";
		//ok5
		    if(trim($row['TIPO'])=="IMG"){
					$imagen = STORAGE_ACCOUNT_CONTAINER."/".CONTAINER_NAME."/media/apoyos/thum_170x170_".$row['IMAGEN'].KEY_ACCESS_BLOBS;
					//$imagen = ."media/apoyos/thum_170x170_".$row['IMAGEN'];
			}else{
				$imagen = $row['IMAGEN'];
			}
		
		
		
	  $content = $this->View->Template(TEMPLATE.'modules/planestrategico/RECURSO.TPL');
	  $content = $this->View->replace('/\#TITULO\#/ms' ,$titulo,$content);
	  $content = $this->View->replace('/\#IMAGEN\#/ms' ,$imagen,$content);
	  $content = $this->View->replace('/\#FORMATO\#/ms' ,$formato,$content);
	  $content = $this->View->replace('/\#FECHA\#/ms' ,$fecha,$content);
	  $content = $this->View->replace('/\#LINKRECURSO\#/ms' ,$linkrecurso,$content);
	  
	  
	  if($this->passport->privilegios->hasPrivilege('P154')){
	  $urledit = '<div class="action-icon price"><a href="#"><img border="0" src="skins/default/img/icn_edit.png" width="16" height="16"></div>';
	  $content = $this->View->replace('/\<!--#LINKEDIT#-->/ms' ,$urledit,$content);
	  }
	  
	  
	  if($this->passport->privilegios->hasPrivilege('P153')){
	  $urlborrar = '<div class="action-icon cart"><a href="javascript:void(0)" onclick="deleteEvidencia(\''.$row['PK1'].'\',\''.$row['ADJUNTO'].'\');"><img border="0" src="skins/default/img/icn_trash.png" width="16" height="14"></div>'; 
	  $content = $this->View->replace('/\<!--#LINKDELETE#-->/ms' ,$urlborrar,$content);
	  }
	  
	  
	  $recurso .= $content;
			
			}	
		
		$recurso .= "#%#";
		$recurso .= $this->getpaginadoFooter();
		$recurso .= "#%#";
		$recurso .= $total;
	    echo $recurso;	
	   
		}else{
		
		$recurso =$this->getPaginadoHeader();
		$recurso .= "#%#";
		$recurso .= '<tr> <td colspan="5"><div class="empty_results">NO EXISTEN RESULTADOS</div></td></tr>';
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
			
		
     <div class="left">
	  <div id="sort-panel">  
	  <input type="hidden" name="Search" value="recursos" />
	  <input type="hidden" name="p" value="'.$_GET['p'].'" />
	  <input type="hidden" name="s" value="'.$_GET['s'].'" />';
	 
	   if(isset($_GET['q'])){
	   	$paginadoHeader .=' <input type="hidden" name="q" value="'.$_GET['q'].'" />';
	   }
	 
	 
       $paginadoHeader.='<select id="sort-menu" name="sort" onchange="Ordenar(this.value)">
          <option'; 
		  
	if($_GET['sort']==1){$paginadoHeader .=' selected="selected" '; }
		  
		$paginadoHeader.=' value="1">Ordenar por: Reciente adición</option>
		  <option'; if($_GET['sort']==2){$paginadoHeader .=' selected="selected" '; }
		$paginadoHeader.=' value="2">Ordenar por: Nombre</option>
		    <option'; if($_GET['sort']==3){$paginadoHeader .=' selected="selected" '; }
	    $paginadoHeader.=' value="3">Ordenar por: Apellidos</option>
        </select>
     
	  </div>
	  </div>
	  
	  
      <div class="bar_seperator"></div>
      
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
	    
      <div class="search_pagination">
	  
	  <button class="btn btn-small" style="float:left; margin-right:10px;"><i class="icon-list-alt"></i> Mostrar Todos</button>';
		 
	  
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
	
	
	function viewRecurso(){
		
		
	    $row = $this->Model->getRecurso($_GET['id']);
		$tiporecurso = $row[3];
		$clasificacion = $row[4];
		$url  = explode("/",$row[11]);	
		$imagen  = explode(".",$row[9]);
		$adjunto = $row[10];
		$categoria = $this->Model->getCategoria($row[5]);
		$categoria = $categoria[1];
		
	 	
	   

		$this->View->template = TEMPLATE.'popup.tpl';
		$this->View->loadTemplate();
		$this->View->replace_content('/\#TITULO\#/ms' ,$row[1]);
		$this->View->replace_content('/\#PREVIEW\#/ms' ,$preview);
		$this->View->replace_content('/\#DESCRIPCION\#/ms' ,$descripcion);

		$this->View->replace_content('/\#FORMATO\#/ms' ,$formato);
		$this->View->replace_content('/\#CATEGORIA\#/ms' ,$categoria);
		
	
		$this->View->replace_content('/\#AUTOR\#/ms' ,$row[12]);
		$this->View->replace_content('/\#FECHA\#/ms' ,$row[7]);
		$this->View->replace_content('/\#LINKDESCARGA\#/ms' ,$linkdescarga);
		$this->View->replace_content('/\#OPCIONDESCARGA\#/ms' ,$opciondescarga);
		$this->View->viewPage();
	
	 }
	
	
	function UploadFile(){
			
	  $filext = strtolower(basename($_FILES['imagearticulo']['name']));
	  $filext = explode(".",$filext);
	  $tipofile = $filext[1];
	  switch($tipofile){
	   	
		case "jpg":
		case "png":
		$this->UploadImagen();
		$this->Model->tipo = "IMG";
			break;
		
		case "mp3":
		case "wav":
		$this->UploadArchivo();
		$this->Model->tipo = "AUD";
		$this->image = "media/thumbnails/thum_ik_audio.png";
			break;
		
		
		case "mp4":
		case "m4v":
		case "flv":
		case "avi":
		case "mov":
		
		$this->UploadArchivo();
		$this->Model->tipo = "VID";
		$this->image = "media/thumbnails/thum_ik_video.png";
			break;
		
		
		case "doc":
		case "docx":
			$this->UploadArchivo();
			$this->Model->tipo = "DOC";
			$this->image = "media/thumbnails/thum_ik_word.png";
			break;
			
		case "xls":
		case "xlsx":
			$this->UploadArchivo();
			$this->Model->tipo = "XLS";
			$this->image = "media/thumbnails/thum_ik_excel.png";
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
		$this->image = "media/thumbnails/thum_ik_zip.png";
			break;
		
		case "txt":
		$this->UploadArchivo();
		$this->image = "media/thumbnails/thum_ik_txt.png";
		$this->Model->tipo = "TXT";
		break;
		
			
			
	    default:
		$this->image = "media/thumbnails/thum_ik_file.png";
		$this->UploadArchivo();
		break;
		
		}
			
		   
		     
			
			$this->Model->titulo = $_POST['titulo'];
			$this->Model->autor = $_POST['autor'];
			$this->Model->descripcion = $_POST['descripcion'];
			$this->Model->imagen = $this->image;
			$this->Model->adjunto = $this->adjunto;
			
			if($_POST['editar']=="TRUE"){
				$this->Model->idevidencia = $_POST['idevidencia'];
				$this->Model->EditFile();				
			}else{
				$this->Model->UploadFile();
			}
			
			
	
        }


  /*function UploadImagen(){
		 	
	
		if($_FILES['imagearticulo']['name']){
			
		$this->targetPathumbail = "media/apoyos/";
		setlocale(LC_CTYPE, 'es');
		$image = strtolower(basename($_FILES['imagearticulo']['name']));
		$imagensinext = explode(".",$image);
		$name =  strtolower(uniqid('IMG'));
		$image = strtolower($name.'.'.$imagensinext[1]);
		$imageupload = new Upload($_FILES['imagearticulo']);
		$imageupload->file_new_name_body = $name;
		
		echo "<script>alert('".$image."');</script>";
			
		
		$this->image = strtolower($name.'.'.$imagensinext[1]);

			$this->adjunto = $this->targetPathumbail.$this->image;
		
		if ($imageupload->uploaded) {
		
		
		
					$imageupload->Process($this->targetPathumbail);
			
							if ($imageupload->processed) {
	

				//Escalamos la imagen para thumbail
			$imageupload->file_new_name_body = 'thum_170x170_'.$name;
				$imageupload->image_resize = true;
					$imageupload->image_ratio_fill = true;
					$imageupload->image_y = 170;
					$imageupload->image_x = 170;
			
			$imageupload->Process($this->targetPathumbail);

			if ($imageupload->processed) {
							//creamos la imagen pequeña
				
			$imageupload->file_new_name_body =  'thum_340x220_'.$name; 
				$imageupload->image_resize = true;
					$imageupload->image_y = 220;
					$imageupload->image_x = 340;
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
		  
		  }*/
		
			function UploadImagen(){

				
				if($_FILES['imagearticulo']['name']){
				$this->targetPathumbail = "media/apoyos";
				setlocale(LC_CTYPE, 'es');
				$image = strtolower(basename($_FILES['imagearticulo']['name']));
				$imagensinext = explode(".",$image);
				$name =  strtolower(uniqid('IMG'));
				$image = strtolower($name.'.'.$imagensinext[1]);
				$imageupload = new Upload($_FILES['imagearticulo']);
				$imageupload->file_new_name_body = $name;
				$handle = $_FILES["imagearticulo"]["tmp_name"];	
				$this->adjunto = $this->targetPathumbail."/".$image;
				
				$this->image = strtolower($name.'.'.$imagensinext[1]);

					 try {
						$this->object_Blob->cargandoBlob($this->image, $handle, "/".$this->targetPathumbail);

					 } catch(Exception $e) 
					 {
							 echo $e;
							 echo "<script>alert('error: ".$e."');</script>";
					 }catch(ServiceException $e){
						// Handle exception based on error codes and messages.
						// Error codes and messages are here:
						// http://msdn.microsoft.com/library/azure/dd179439.aspx
						$code = $e->getCode();
						$error_message = $e->getMessage();
						echo $code.": ".$error_message."<br />";
						echo "<script>alert('error: ".$code.": ".$error_message."<br />"."');</script>";
					}
					catch(InvalidArgumentTypeException $e){
							// Handle exception based on error codes and messages.
							// Error codes and messages are here:
							// http://msdn.microsoft.com/library/azure/dd179439.aspx
							$code = $e->getCode();
							$error_message = $e->getMessage();
							echo $code.": ".$error_message."<br />";
							echo "<script>alert('error: ".$code.": ".$error_message."<br />"."');</script>";
							}	

				
				if ($imageupload->uploaded) {
				
				
				
							$imageupload->Process($this->targetPathumbail);
							
									if ($imageupload->processed) {
			
		
						//Escalamos la imagen para thumbail
					$imageupload->file_new_name_body = 'thum_170x170_'.$name;
						$imageupload->image_resize = true;
							$imageupload->image_ratio_fill = true;
							$imageupload->image_y = 170;
							$imageupload->image_x = 170;
					$imageupload->Process($this->targetPathumbail);
					$this->object_Blob->cargandoBlob('thum_170x170_'.$this->image, $this->targetPathumbail."/".'thum_170x170_'.$this->image, "/".$this->targetPathumbail);
					unlink($this->targetPathumbail."/".'thum_170x170_'.$this->image);
					if ($imageupload->processed) {
									//creamos la imagen pequeña
						
					$imageupload->file_new_name_body =  'thum_340x220_'.$name; 
						$imageupload->image_resize = true;
							$imageupload->image_y = 220;
							$imageupload->image_x = 340;
					$imageupload->Process($this->targetPathumbail);
					$this->object_Blob->cargandoBlob('thum_340x220_'.$this->image, $this->targetPathumbail."/".'thum_340x220_'.$this->image, "/".$this->targetPathumbail);
					unlink($this->targetPathumbail."/".'thum_340x220_'.$this->image);
					unlink($this->targetPathumbail."/".$this->image);
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
		
	$this->targetPathumbail = "media/apoyos";
	setlocale(LC_CTYPE, 'es');
	$this->image = strtolower(basename($_FILES['imagearticulo']['name']));
    
	$imagensinext = explode(".",$this->image);
	$name =  strtolower(uniqid('file'));
	$this->image = strtolower($name.'.'.$imagensinext[1]);
	$imageupload = new Upload($_FILES['imagearticulo']);
	$imageupload->file_new_name_body = $name;
	$this->adjunto = $this->targetPathumbail."/".$name.'.'.$imagensinext[1];
	$handle = $_FILES["imagearticulo"]["tmp_name"];	
	$this->object_Blob->cargandoBlob($this->image, $handle, "/".$this->targetPathumbail);
	
	
	/*if ($imageupload->uploaded) {
	
         $imageupload->Process($this->targetPathumbail);
            if ($imageupload->processed) {

                 return TRUE;
			
             } else {
               return FALSE; //echo 'error : ' . $foo->error;
             }
			 
			 //SI NO ANEXARON  IMAGEN
			 }else{
			 	
			 	
			 	echo 'error : ' . $imageupload->error;

				return TRUE;
			 }*/
			
     }
		  
		  }
	
	
	
	
	
	function Eliminar(){
		echo "<script>alert('ELIMINAR');</script>";
		try {
			$ruta_eliminar = CONTAINER_NAME."/media/apoyos";
      $array = explode("/", $_POST['file']);
      $file_eliminar = $array[2];
      $idevidencia = $_POST['evidencia'];

        $tipofile = strtolower(pathinfo($file_eliminar, PATHINFO_EXTENSION));
        echo "<script>alert('tipofile: '.$tipofile.');</script>";

        echo "<script>alert('Entro a Seguimiento-EliminarEvidencia');</script>";
        echo "<script>alert('ruta_eliminar: '.$ruta_eliminar.');</script>";
        echo "<script>alert('file_eliminar: '.$file_eliminar.');</script>";
				echo "<script>alert('idevidencia: '.$idevidencia.');</script>";
				switch ($tipofile) {
            
					case "jpg":
					case "png":
					echo "<script>alert('Entro a imagen');</script>";
							$this->object_Blob->deleteBlob($ruta_eliminar, $file_eliminar);
							$this->object_Blob->deleteBlob($ruta_eliminar,"thum_170x170_".$file_eliminar);
							$this->object_Blob->deleteBlob($ruta_eliminar,"thum_340x220_".$file_eliminar);
							break;
					default:
							echo "<script>alert('Entro a archivo');</script>";
							$this->object_Blob->deleteBlob($ruta_eliminar, $file_eliminar);
							break;
			}
			$this->Model->Eliminar($idevidencia);
		 } catch(Exception $e) 
		 {
				 echo $e;
				 echo "<script>alert('error: ".$e."');</script>";
		 }catch(ServiceException $e){
			// Handle exception based on error codes and messages.
			// Error codes and messages are here:
			// http://msdn.microsoft.com/library/azure/dd179439.aspx
			$code = $e->getCode();
			$error_message = $e->getMessage();
			echo $code.": ".$error_message."<br />";
			echo "<script>alert('error: ".$code.": ".$error_message."<br />"."');</script>";
		}
		catch(InvalidArgumentTypeException $e){
				// Handle exception based on error codes and messages.
				// Error codes and messages are here:
				// http://msdn.microsoft.com/library/azure/dd179439.aspx
				$code = $e->getCode();
				$error_message = $e->getMessage();
				echo $code.": ".$error_message."<br />";
				echo "<script>alert('error: ".$code.": ".$error_message."<br />"."');</script>";
				}
	 
		
		}
	  
	
}

?>