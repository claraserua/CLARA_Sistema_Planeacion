<?php
include "models/administrador.model.php";

class administrador {

    var $View;
	var $Model;
	var $menu;
	

	function administrador() {
	 $this->menu = new Menu();
	 $this->View = new View();
	 $this->Model = new administradorModel();
	 
     $this->loadPage();		
						  
	}
	
	
	
	 function loadPage(){
	
		$this->View->template = TEMPLATE.'principal.tpl';	
		$this->View->loadTemplate();
		$this->loadHeader();
		$this->loadMenu();
		$this->loadContent();
		$this->loadFooter();
		$this->View->viewPage();
		
	 }
	 
	 
	   function loadHeader(){

	  $section = TEMPLATE.'sections/header.tpl';
	  $section = $this->View->loadSection($section);
	 $nombre = $_SESSION['session']['titulo'].' '.htmlentities($_SESSION['session']['nombre']).' '.htmlentities($_SESSION['session']['apellidos']);
	  $imagen = 'thum_100x100_'.$_SESSION['session']['imagen'];
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
	
	 $menu =  $this->menu->menu; 
	 $this->View->replace_content('/\#MENU\#/ms' ,$menu);
	 
	 
	 }
	 
	
  
	 function loadContent(){
		 $contenido=' <a href="addpe.html">
                <button type="submit" data-rel="popover" data-content="Agregar planes Estrategicos correspondientes..." title="Plan Estrategico" class="btn btn-small btn-warning">Añadir un nuevo Plan Estrategico</button></a>
                <br /><br />
                
                
				<!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h2 class="left">Lista de Planes Estratégicos</h2>
						<div class="right">
						
							<input type="text" class="field small-field" />
							<button class="btn btn-small"><i class="icon-search"></i> Buscar</button>
						</div>
					</div>
					<!-- End Box Head -->	
                    
                    
                    <!-- Pagging -->
						
                        <div class="pagging">
                        <div class="left">Mostrando 1-12 de 44</div>
                        <div class="right">
                        <div class="pagination pagination-centered">
						  <ul>
							<li class="prev disabled"><a href="#">Prev</a></li>
							<li class="active">
							  <a href="#">1</a>
							</li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">Next</a></li>
						  <li><a href="#">Mostrar Todos</a></li>
                          </ul>
                     
						</div>
                        </div>
                        </div>
              
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="table">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<th width="13"><input type="checkbox" class="checkbox" /></th>
								<th>Titulo</th>
								<th>Fecha</th>
								<th>Agregado por</th>
								<th width="240" class="ac">Control</th>
							</tr>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td><h2><a href="#">Plan estratégico 2007-2015</a></h2></td>
								<td>12.05.09</td>
								<td><a href="#">Administrator</a></td>
								<td><button class="btn btn-small"><i class="icon-trash"></i> Borrar</button>&nbsp;<button class="btn btn-small"><i class="icon-pencil"></i> Editar</button></td>
							</tr>
							<tr class="odd">
								<td><input type="checkbox" class="checkbox" /></td>
								<td><h2><a href="#">Plan estratégico 2007-2015</a></h2></td>
								<td>12.05.09</td>
								<td><a href="#">Administrator</a></td>
								<td><button class="btn btn-small"><i class="icon-trash"></i> Borrar</button>&nbsp;<button class="btn btn-small"><i class="icon-pencil"></i> Editar</button></td>
							</tr>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td><h2><a href="#">Plan estratégico 2007-2015</a></h2></td>
								<td>12.05.09</td>
								<td><a href="#">Administrator</a></td>
								<td><button class="btn btn-small"><i class="icon-trash"></i> Borrar</button>&nbsp;<button class="btn btn-small"><i class="icon-pencil"></i> Editar</button></td>
							</tr>
							<tr class="odd">
								<td><input type="checkbox" class="checkbox" /></td>
								<td><h2><a href="#">Plan estratégico 2007-2015</a></h2></td>
								<td>12.05.09</td>
								<td><a href="#">Administrator</a></td>
								<td><button class="btn btn-small"><i class="icon-trash"></i> Borrar</button>&nbsp;<button class="btn btn-small"><i class="icon-pencil"></i> Editar</button></td>
							</tr>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td><h2><a href="#">Plan estratégico 2007-2015</a></h2></td>
								<td>12.05.09</td>
								<td><a href="#">Administrator</a></td>
								<td><button class="btn btn-small"><i class="icon-trash"></i> Borrar</button>&nbsp;<button class="btn btn-small"><i class="icon-pencil"></i> Editar</button></td>
							</tr>
							<tr class="odd">
								<td><input type="checkbox" class="checkbox" /></td>
								<td><h2><a href="#">Plan estratégico 2007-2015</a></h2></td>
								<td>12.05.09</td>
								<td><a href="#">Administrator</a></td>
								<td><button class="btn btn-small"><i class="icon-trash"></i> Borrar</button>&nbsp;<button class="btn btn-small"><i class="icon-pencil"></i> Editar</button></td>
							</tr>
							<tr>
								<td><input type="checkbox" class="checkbox" /></td>
								<td><h2><a href="#">Plan estratégico 2007-2015</a></h2></td>
								<td>12.05.09</td>
								<td><a href="#">Administrator</a></td>
								<td><button class="btn btn-small"><i class="icon-trash"></i> Borrar</button>&nbsp;<button class="btn btn-small"><i class="icon-pencil"></i> Editar</button></td>
							</tr>
							<tr class="odd">
								<td><input type="checkbox" class="checkbox" /></td>
								<td><h2><a href="#">Plan estratégico 2007-2015</a></h2></td>
								<td>12.05.09</td>
								<td><a href="#">Administrator</a></td>
								<td><button class="btn btn-small"><i class="icon-trash"></i> Borrar</button>&nbsp;<button class="btn btn-small"><i class="icon-pencil"></i> Editar</button></td>
							</tr>
						</table>
						
						
						  <!-- Pagging -->
						
                        <div class="pagging">
                        <div class="left">Mostrando 1-12 de 44</div>
                        <div class="right">
                        <div class="pagination pagination-centered">
						  <ul>
							<li class="prev disabled"><a href="#">Prev</a></li>
							<li class="active">
							  <a href="#">1</a>
							</li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">Next</a></li>
						  <li><a href="#">Mostrar Todos</a></li>
                          </ul>
                     
						</div>
                        </div>
                        </div>
              
						<!-- End Pagging -->
						
					</div>
					<!-- Table -->
					
				</div>
				<!-- End Box -->
				';
		 
		 $this->View->replace_content('/\#CONTENT\#/ms' ,$contenido);
		 
		 }
	 
	  
	  function showNoticias(){
		$section = $this->View->Template(TEMPLATEADMIN.'modules/slider.tpl');
		
		$this->Model->getNoticias();
		$numnoticias = sizeof($this->Model->noticias); 
        
		
		if($numnoticias != 0){ 
		foreach($this->Model->noticias as $row){
	        $id = $row['PK1'];		
            $imagen = $row['IMAGEN'];
	        $titulo = $row['TITULO'];
            $categoria = $row['PK1_CATEGORIA'];
        	$fechap = $row['FECHA_D'];
            $fechav = $row['FECHA_H'];
	    
		    $content .= '<li> <a class="various fancybox.ajax" href="index.php?pag=noticia&view='.$id.'"> <img src="media/noticias/'.$imagen.'" title="'.$titulo.'" ></a></li>';
			$thumcontent .= ' <li><img src="media/noticias/thumbnails/thum_'.$imagen.'" /></li>';
		
		}
		 $slider =  $this->View->replace('/\#NOTICIAS\#/ms' ,$content,$section);
		 $slider =  $this->View->replace('/\#THUMBNOTICIAS\#/ms' ,$thumcontent,$slider);
		 
		}else{
		 $slider .='<h4 class="alert_info">No existen noticias registradas</h4><br><br>';
		}
		 
		 return $slider;
	}
	
	  
	  
	  function getNoticia(){
	
	 
	$row = $this->Model->getNoticia($_GET['view']);
	$image = 'media/noticias/'.$row[3];  
	$content = $this->View->Template(TEMPLATE.'modules/noticia_slider.tpl');
	
	$content = $this->View->replace('/\#TITLEARTICULO\#/ms' ,$row[1],$content);
	
	$content = $this->View->replace('/\#IMGARTICULO\#/ms' ,$image,$content);
	
	$content = $this->View->replace('/\#CONTENTARTICULO\#/ms' ,$row[2],$content);
	
	echo $content;
			
	}
	  
	  
	  
	   function loadArticulos(){

      $this->loadPage();
	  
	  $this->Model->getArticulos();
		$numarticulos = sizeof($this->Model->articulos);
		
		if($numarticulos != 0){
			
				foreach($this->Model->articulos as $row){
	$id = $row['PK1'];		
    $imagen = $row['IMAGEN'];
	$titulo = $row['TITULO'];
    $descripcion = $row['DESCRIPCION'];

	
	$section .= '
	     <div class="resumen_articulo" >
                <div class="thumb"><img src="media/articulos/thumbnails/thum_'.$imagen.'" width="66" height="65" /></div>
	  <div class="resumen">'.$this->cortar_string (strip_tags($descripcion),250).'</div>
                <div class="leer_btn"><a href="?view='.$id.'"><span>Leer</span> art&iacute;culo completo</a></div>
              </div>';
	
				}
		
		}else{
			
			$section = '
	  <div class="alert">NO EXISTEN ARTICULOS PUBLICADOS</div>
              ';
			
			}
	  
	  
	  //$section = $this->View->loadSection($section);
	  $this->View->replace_content('/\#ARTICULOS\#/ms' ,$section);
 	  $this->View->viewPage();
	 }
	 
	 
	 function viewRecurso(){
	    $row = $this->Model->getRecurso($_GET['id']);
		$tiporecurso = $row[3];
		$clasificacion = $row[4];
		$url  = explode("/",$row[11]);	
		$imagen  = explode(".",$row[9]);
		$adjunto = $row[10];
		
		
	 	
	   switch($tiporecurso){
	   case "IMG":
	   $formato = strtoupper($imagen[1]);
	   $dirdownload = "media/galeria/".$url [7]."/".$url [8]."/";
	   $preview = "<img src='media/galeria/".$url [7]."/".$url [8]."/preview/".$row[9]."'/>";
	   $linkdescarga = "descargar('".$dirdownload."','".$row[9]."','".$tiporecurso."');return false;";
	   $opciondescarga= '<select name="optiondescarga" id="optiondescarga">
                            <option value="'.$row[9].'">Original_548x2323</option>
                            <option value="'.$imagen[0].'_mediana.'.$imagen[1].'">Mediano_548x2323</option>
                            <option value="'.$imagen[0].'_chica.'.$imagen[1].'">Chico_548x2323</option>
                          </select>';
	   break;
	   
	   
	   case "VID":
	   
	   $dirdownload = "media/galeria/videos/".$row[10];
	   $linkdescarga = "descargar('".$dirdownload."','null','".$tiporecurso."');return false;";
	   
	   $adjuntoex = explode(".",$row[10]);
	   $formato = strtoupper($adjuntoex[1]);
	   
	   switch($adjuntoex[1]){
	   	case "mp4":
		case "m4v":
		case "flv":
		case "avi":
		case "mov":
	
		$video = 'http://cte.anahuac.mx/aprende/media/galeria/videos/'.$adjunto;
		$imagenpreview = 'media/galeria/videos/preview/'.$row[9];
		


        $preview .='<video width="340" height="220" src="'.$video.'" type="video/mp4" 
	id="player1" poster="'.$imagenpreview.'" 
	controls="controls" preload="none"></video><span id="player1-mode" style="display:none;"></span>';
		
		break;
		
		case "wmv":
		$video = 'media/galeria/videos/'.$adjunto;
		$preview ='<OBJECT ID="MediaPlayer" WIDTH="340" HEIGHT="220" CLASSID="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95"
STANDBY="Loading Windows Media Player components..." TYPE="application/x-oleobject">
<PARAM NAME="FileName" VALUE="'.$video.'">
<PARAM name="autostart" VALUE="false">
<PARAM name="ShowControls" VALUE="true">
<param name="ShowStatusBar" value="false">
<PARAM name="ShowDisplay" VALUE="false">
<EMBED TYPE="application/x-mplayer2" SRC="'.$video.'" NAME="MediaPlayer"
WIDTH="340" HEIGHT="220" ShowControls="1" ShowStatusBar="0" ShowDisplay="0" autostart="0"> </EMBED>
</OBJECT>';
		break;
		
		
		
	    }
		
		break;
		
		case "DOC":
	   $dirdownload = "media/galeria/documentos/".$row[10];
	   $linkdescarga = "descargar('".$dirdownload."','null','".$tiporecurso."');return false;";
	   
	    if($row[9]==""){
	    switch($clasificacion){
	   	     case "PDF":
			  $formato = "PDF";
			 $preview = "<div style='width:340px; height:220px; background:#FFFFFF;'><img src='media/galeria/".$url [7]."/thumbnails/thum_ik_pdf.png' style='margin: 20px 80px 0;' /></div>";
			 break;
			
			 case "WRD":
			 $formato = "WORD";
			 $preview = "<div style='width:340px; height:220px; background:#FFFFFF;'><img src='media/galeria/".$url [7]."/thumbnails/thum_ik_word.png' style='margin: 20px 80px 0;' /></div>";
			 break;
			 
			 case "PWP":
			 $formato = "POWER POINT";
			  $preview = "<div style='width:340px; height:220px; background:#FFFFFF;'><img src='media/galeria/".$url [7]."/thumbnails/thum_ik_ppt.png' style='margin: 20px 80px 0;' /></div>";
			 break;
			 
			 
			 case "EBO":
			 $formato = "eBOOK";
			  $preview = "<div style='width:340px; height:220px; background:#FFFFFF;'><img src='media/galeria/".$url [7]."/thumbnails/thum_ik_book.png' style='margin: 20px 80px 0;' /></div>";
			 break;
			 
	         }
			 }else{
			 $preview = "<img src='media/galeria/documentos/preview/".$row[9]."'/>";
			 }
	   
		
	   break;
		
		
		case "TPL":
	   $dirdownload = "media/galeria/templates/".$row[10];
	   $linkdescarga = "descargar('".$dirdownload."','null','".$tiporecurso."');return false;";
	   
	    if($row[9]==""){
	    switch($clasificacion){
	   	     case "HTM":
			 $formato = "HTML/CSS";
			 $preview = "<div style='width:340px; height:220px; background:#FFFFFF;'><img src='media/galeria/".$url [7]."/thumbnails/thum_ikp_html.png' style='margin: 20px 80px 0;' /></div>";
			 break;
			
			 case "PTS":
			 $formato = "Photoshop (PSD)";
			 $preview = "<div style='width:340px; height:220px; background:#FFFFFF;'><img src='media/galeria/".$url [7]."/thumbnails/thum_ik_ps.png' style='margin: 20px 80px 0;' /></div>";
			 break;
			 
			 case "TPT":
			 $formato = "Power Point (ppt,pptx)";
			  $preview = "<div style='width:340px; height:220px; background:#FFFFFF;'><img src='media/galeria/".$url [7]."/thumbnails/thum_ikp_ppt.png' style='margin: 20px 80px 0;' /></div>";
			 break;
			 
			 
			 case "TWD":
			 $formato = "Word (doc,docx)";
			  $preview = "<div style='width:340px; height:220px; background:#FFFFFF;'><img src='media/galeria/".$url [7]."/thumbnails/thum_ikp_word.png' style='margin: 20px 80px 0;' /></div>";
			 break;
			 
			 
			  case "OHT":
			  $formato = "HTML/Jquery (html,css,js)";
			  $preview = "<div style='width:340px; height:220px; background:#FFFFFF;'><img src='media/galeria/".$url [7]."/thumbnails/thum_ikp_jq.png' style='margin: 20px 80px 0;' /></div>";
			 break;
			 
			 
			 case "OFL":
			 $formato = "Flash (fla,swf)";
			 $preview = "<div style='width:340px; height:220px; background:#FFFFFF;'><img src='media/galeria/".$url [7]."/thumbnails/thum_ik_flash.png' style='margin: 20px 80px 0;' /></div>";
			 break;
			 
	         }
			 }else{
			 $preview = "<img src='media/galeria/templates/preview/".$row[9]."'/>";
			 }
	   
	         break;
		
	         }
	
	
	     if($row[2]==""){
		   $descripcion = "No existe descripción";	
		 }else{
		 	$descripcion = $row[2];
		 }
     

		$this->View->template = TEMPLATE.'popup.tpl';
		$this->View->loadTemplate();
		$this->View->replace_content('/\#TITULO\#/ms' ,$row[1]);
		$this->View->replace_content('/\#PREVIEW\#/ms' ,$preview);
		$this->View->replace_content('/\#DESCRIPCION\#/ms' ,$descripcion);

		$this->View->replace_content('/\#FORMATO\#/ms' ,$formato);
	
		$this->View->replace_content('/\#AUTOR\#/ms' ,$row[12]);
		$this->View->replace_content('/\#FECHA\#/ms' ,$row[7]);
		$this->View->replace_content('/\#LINKDESCARGA\#/ms' ,$linkdescarga);
		$this->View->replace_content('/\#OPCIONDESCARGA\#/ms' ,$opciondescarga);
		$this->View->viewPage();
	
	 }
	 
	 
	 
	 function viewArticulo(){
	  
	  $this->loadPage();
	  $row = $this->Model->getArticulo($_GET['view']);
	  
	  $enlace = '?'; 
	 
	  $content = $this->View->Template(TEMPLATE.'modules/articulo.tpl');
	  $content = $this->View->replace('/\#TITLEARTICULO\#/ms' ,$row[1],$content);
	  $content = $this->View->replace('/\#IMGARTICULO\#/ms' ,'media/articulos/'.$row[3],$content);
	  $content = $this->View->replace('/\#CONTENTARTICULO\#/ms' ,$row[2],$content);
	  $content = $this->View->replace('/\#LINK\#/ms' ,$enlace,$content);
	  
	  
	  $this->View->replace_content('/\#ARTICULOS\#/ms' ,$content);
 	  $this->View->viewPage();
	  
	  }
	 
	 

	   function loadTutoriales(){

    $this->loadPage();
	  
	  $this->Model->getTutoriales();
		$numarticulos = sizeof($this->Model->tutoriales);
		
		if($numarticulos != 0){
			
				foreach($this->Model->tutoriales as $row){
	$id = $row['PK1'];		
    $imagen = $row['IMAGEN'];
	$titulo = $row['TITULO'];
    $descripcion = $row['DESCRIPCION'];

	
	$section .= '
	     <div class="resumen_articulo" >
                <div class="thumb"><img src="media/tutoriales/thumbnails/thum_'.$imagen.'" width="66" height="65" /></div>
	  <div class="resumen">'.substr(strip_tags($descripcion),0,250).'</div>
                <div class="leer_btn"><a href="?pag=tutoriales&view='.$id.'"><span>Leer</span> Tutorial completo</a></div>
              </div>';
	
				}
		
		}else{
			
			$section = '
	  <div class="alert">NO EXISTEN TUTORIALES PUBLICADOS</div>
              ';
			
			}
	  
	  
	  //$section = $this->View->loadSection($section);
	  $this->View->replace_content('/\#ARTICULOS\#/ms' ,$section);
 	  $this->View->viewPage();
	 }
	 
	 
	  function showArticulo(){
	  
	  $row = $this->Model->getArticulo($_GET['view']);
	  $enlace = '?pag='.$_GET[pag]; 
	  $content = $this->View->Template(TEMPLATEADMIN.'modules/prevarticulo.tpl');
	  $content = $this->View->replace('/\#TITLEARTICULO\#/ms' ,$row[1],$content);
	  $content = $this->View->replace('/\#IMGARTICULO\#/ms' ,$row[3],$content);
	  $content = $this->View->replace('/\#CONTENTARTICULO\#/ms' ,$row[2],$content);

      echo $content;
	   
	  }
	  
	  
	  function showTutorial(){
	  
	  $row = $this->Model->getTutorial($_GET['view']);
	  $enlace = '?pag='.$_GET[pag]; 
	  $content = $this->View->Template(TEMPLATEADMIN.'modules/prevtutorial.tpl');
	  $content = $this->View->replace('/\#TITLEARTICULO\#/ms' ,$row[1],$content);
	  $content = $this->View->replace('/\#IMGARTICULO\#/ms' ,$row[3],$content);
	  $content = $this->View->replace('/\#CONTENTARTICULO\#/ms' ,$row[2],$content);

      echo $content;
	   
	  }
	  
	function showLineamiento(){
	  
	$row = $this->Model->getLineamiento($_GET['view']);	
	$ext = explode(".",$row[3]);
	
	switch($ext[1]){
		
		case "doc":
		case "docx":
		$imagen = "ik_word.png";
		break;
		
		case "ppt":
		case "pptx":
		$imagen = "ik_ppt.png";
		break;
		
		case "pdf":
		$imagen = "ik_pdf.png";
		break;
	
	}
	
	$download = '<a href="media/lineamientos/'.$row[3].'"><img src="media/iconos/'.$imagen.'"  /></a>';
	$content = $this->View->Template(TEMPLATEADMIN.'modules/prevlineamiento.tpl');
	$content = $this->View->replace('/\#TITLEARTICULO\#/ms' ,$row[1],$content);
	$content = $this->View->replace('/\#IMGARTICULO\#/ms' ,$download,$content);
	$content = $this->View->replace('/\#CONTENTARTICULO\#/ms' ,$row[2],$content);
	
	echo $content;
	   
    }
	  
	  
	  
	 
	 
    function loadLinks(){

	$this->loadPage();
	  	  
	$this->Model->getLinks();
		$numarticulos = sizeof($this->Model->links);
		
		if($numarticulos != 0){
			
				foreach($this->Model->links as $row){
	$id = $row['PK1'];		
    $imagen = $row['IMAGEN'];
	$titulo = $row['TITULO'];
    $descripcion = $row['DESCRIPCION'];

	
	$section .= '
	     <div class="resumen_articulo" >
                <div class="thumb"><img src="media/links/thumbnails/thum_'.$imagen.'" width="66" height="65" /></div>
	  <div class="resumen">'.substr(strip_tags($descripcion),0,250).'</div>
                <div class="leer_btn"><a href="?articulo='.$id.'"><span>Leer</span> art&iacute;culo completo</a></div>
              </div>';
	
				}
		
		}else{
			
			$section = '
	  <div class="alert">NO EXISTEN ENLACES PUBLICADOS</div>
              ';
			
			}
	  
	  
	  //$section = $this->View->loadSection($section);
	  $this->View->replace_content('/\#ARTICULOS\#/ms' ,$section);
 	  $this->View->viewPage();
	 }
	 
	 

	 
	    function searchRecursos(){
		
        $recurso =$this->getPaginadoHeader();
		$recurso .= "#%#";
			
	    $this->Model->searchRecursos();
	    $numrecursos = sizeof($this->Model->recursos);
		$total = $this->Model->totalnum;
		
		if($numrecursos != 0){
			

		foreach($this->Model->recursos as $row){
	   
	    $id = $row['PK1'];
		$tiporecurso = $row['PK1_RECURSO'];
		$clasificacion = $row['PK1_CLASIFICACION'];
        $url  = explode("/",$row['URL']);
	    $linkrecurso = "WindowOpen('".$row['PK1']."');return false;";
		$imagen = $row['IMAGEN'];
		$img = $row['IMAGEN'];
		
	   switch($tiporecurso){
	   case "IMG":
	   $adjuntoex = explode(".",$imagen);
	   $formato = strtoupper($adjuntoex[1]);
	   $imagen = "media/galeria/".$url [7]."/".$url [8]."/thumbnails/thum_".$row['IMAGEN'];
	   $dir = "media/galeria/".$url [7]."/".$url [8];
	   break;
	   
	   case "VID":
	   $imagen = "media/galeria/".$url [7]."/thumbnails/thum_".$row['IMAGEN'];
	   $dir = "media/galeria/".$url [7];
	   
	   $adjuntoex = explode(".",$row['ADJUNTO']);
	   $formato = strtoupper($adjuntoex[1]);
	   
	   break;
	   
	   
	    case "DOC":
	   
	   
	         switch($clasificacion){
	   	     case "PDF":
			 $formato = "PDF";
			 $imagen = "media/galeria/".$url [7]."/thumbnails/thum_ik_pdf.png";
	         $dir = "media/galeria/".$url [7];
			 break;
			 
			 case "WRD":
			 $formato = "DOC";
			 $imagen = "media/galeria/".$url [7]."/thumbnails/thum_ik_word.png";
	         $dir = "media/galeria/".$url [7];
			 break;
			 
			 case "PWP":
			 $formato = "PPT";
			 $imagen = "media/galeria/".$url [7]."/thumbnails/thum_ik_ppt.png";
	         $dir = "media/galeria/".$url [7];
			 break;
			 
			 
			 case "EBO":
			 $formato = "EBO";
			 $imagen = "media/galeria/".$url [7]."/thumbnails/thum_ik_book.png";
	         $dir = "media/galeria/".$url [7];
			 break;
			 
	         }
	   
	   
	   
	   break;
	   
	   
	   
	   case "TPL":
	   
	         switch($clasificacion){
	   	     case "HTM":
			 $formato = "HTML";
			 if($img!=""){
			 	$imagen = "media/galeria/".$url [7]."/thumbnails/thum_".$img;
			 }else{
			 	$imagen = "media/galeria/".$url [7]."/thumbnails/thum_ikp_html.png";
			 }
	         $dir = "media/galeria/".$url [7];
			 break;
			 
			 case "PTS":
			 $formato = "PSD";
			  if($img!=""){
			 	$imagen = "media/galeria/".$url [7]."/thumbnails/thum_".$img;
			 }else{
			 	$imagen = "media/galeria/".$url [7]."/thumbnails/thum_ik_ps.png";
			 }
	         $dir = "media/galeria/".$url [7];
			 break;
			 
			 case "TPT":
			 $formato = "PPT";
			 if($img!=""){
			 	$imagen = "media/galeria/".$url [7]."/thumbnails/thum_".$img;
			 }else{
			 	$imagen = "media/galeria/".$url [7]."/thumbnails/thum_ikp_ppt.png";
			 }
	         $dir = "media/galeria/".$url [7];
			 break;
			 
			 
			 case "TWD":
			 $formato = "DOC";
			 if($img!=""){
			 	$imagen = "media/galeria/".$url [7]."/thumbnails/thum_".$img;
			 }else{
			 	$imagen = "media/galeria/".$url [7]."/thumbnails/thum_ikp_word.png";
			 }
	         $dir = "media/galeria/".$url [7];
			 break;
			 
			 
			  case "OHT":
			  $formato = "JQ";
			 if($img!=""){
			 	$imagen = "media/galeria/".$url [7]."/thumbnails/thum_".$img;
			 }else{
			 	$imagen = "media/galeria/".$url [7]."/thumbnails/thum_ikp_jq.png";
			 }
	         $dir = "media/galeria/".$url [7];
			 break;
			 
			 
			  case "OFL":
			  $formato = "FLA";
			 if($img!=""){
			    $imagen = "media/galeria/".$url [7]."/thumbnails/thum_".$img;
			 }else{
			 	$imagen = "media/galeria/".$url [7]."/thumbnails/thum_ik_flash.png";
			 }
	         $dir = "media/galeria/".$url [7];
			 break;
			 
	         }
	   
	   
	   
	   break;
	   
	   }
	
	  
	   
		
	    $titulo = $row['TITULO'];
        $fecha= $row['FECHA_C'];
		
		if($row['ADJUNTO']!=NULL){
			$adjunto = $row['ADJUNTO'];
		}else{
			$adjunto = "NULL";
		}
	
	
	  $content = $this->View->Template(TEMPLATE.'modules/recurso.tpl');
	  $content = $this->View->replace('/\#TITULO\#/ms' ,$titulo,$content);
	  $content = $this->View->replace('/\#IMAGEN\#/ms' ,$imagen,$content);
	  $content = $this->View->replace('/\#FORMATO\#/ms' ,$formato,$content);
	  $content = $this->View->replace('/\#FECHA\#/ms' ,$fecha,$content);
	  $content = $this->View->replace('/\#LINKRECURSO\#/ms' ,$linkrecurso,$content);
	  
	  	
					
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
		$recurso .= "NO EXISTEN RESULTADOS";
		$recurso .= "#%#";
		$recurso .=$this->getpaginadoFooter();
		$recurso .= "#%#";
		$recurso .= $total;
		echo $recurso;	

		}
			

	 }
	 
	 function getPaginadoHeader(){	
	 
	 

	 switch($_GET['pag']){
		 case "search":
		 $this->Model->searchRecursos();
		 break;
		 
		  case "searchNoticias":
		 $this->Model->searchNoticias();
		 break;
		 
		  case "searchTutoriales":
		 $this->Model->searchTutoriales();
		 break;
		 
		   case "searchLineamientos":
		 $this->Model->searchLineamientos();
		 break;
       		 
		 }
		 
		//  $this->Model->searchRecursos();	
	 
	
	#---------------------PAGINADO---------------------------#
			 $q = (isset($_GET['q']))? "&q=".$_GET['q'] : ""; 
			$paginadoHeader ='
			
			<div id="search_summary-actions">
    
	  <div id="sort-panel">  
	  <form action="index.php" method="get" target="_self">
	  <input type="hidden" name="Search" value="recursos" />
	  <input type="hidden" name="p" value="'.$_GET['p'].'" />
	  <input type="hidden" name="s" value="'.$_GET['s'].'" />';
	 
	   if(isset($_GET['q'])){
	   	$paginadoHeader .=' <input type="hidden" name="q" value="'.$_GET['q'].'" />';
	   }
	 
	 
       $paginadoHeader.='<select id="sort-menu" name="sort" onchange="this.form.submit()">
          <option'; 
		  
	if($_GET['sort']==1){$paginadoHeader .=' selected="selected" '; }
		  
		$paginadoHeader.=' value="1">Ordenar por: Reciente adición</option>
		  <option'; if($_GET['sort']==2){$paginadoHeader .=' selected="selected" '; }
		$paginadoHeader.=' value="2">Ordenar por: Mas visitado</option>
		    <option'; if($_GET['sort']==3){$paginadoHeader .=' selected="selected" '; }
	    $paginadoHeader.=' value="3">Ordenar por: Mas descargado</option>
        </select>
      </form>
	  </div>
      <div class="bar_seperator"></div>
      <div id="search_page_size-panel">
	  
	    
        <div class="page_size_25" onClick="showLimitPage(25,this);" id="page_size_25-panel"></div>
		<div class="page_size_50" onClick="showLimitPage(50,this);" id="page_size_50-panel"></div>
        <div class="page_size_100" onClick="showLimitPage(100,this);" id="page_size_100-panel"></div>
        <div class="page_size_200" onClick="showLimitPage(200,this);" id="page_size_200-panel"></div>
	
     
	 </div>
     
	 
	    
      <div class="search_pagination">';
		 
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
	  </div>
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
	
	 
	 

function searchNoticias(){
			
	
	   $this->Model->searchNoticias();
	   $numnoticias = sizeof($this->Model->noticias);
		
	   $recurso =$this->getPaginadoHeader();
	   $recurso .= "#%#";
	   
	   if($numnoticias != 0){
			
			
	foreach($this->Model->noticias as $row){
	   
	$id = $row['PK1'];		
    $imagen = "media/articulos/thumbnails/thum_".$row['IMAGEN'];
	$titulo = $row['TITULO'];
    $descripcion = $row['DESCRIPCION'];
	$link = 'index.php?pag=articulo&view='.$id;
	
	
	  $content = $this->View->Template(TEMPLATE.'modules/noticia.tpl');
	  $content = $this->View->replace('/\#TITULO\#/ms' ,$titulo,$content);
	  $content = $this->View->replace('/\#IMAGEN\#/ms' ,   $imagen,$content);
	  $content = $this->View->replace('/\#RESUMEN\#/ms' ,$this->cortar_string (strip_tags($descripcion),250),$content);	
	  $content = $this->View->replace('/\#LINK\#/ms' ,$link,$content);
			
			
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
		$recurso .= "NO EXISTEN RESULTADOS";
		$recurso .= "#%#";
		$recurso .=$this->getpaginadoFooter();
		$recurso .= "#%#";
		$recurso .= $total;
		echo $recurso;	

		}
			

	 }
	 
	 
	 
	 
	 function searchTutoriales(){
	
	 $this->Model->searchTutoriales();
	 $numnoticias = sizeof($this->Model->tutoriales);
	 
	 $recurso =$this->getPaginadoHeader();
	 $recurso .= "#%#";
		
	 if($numnoticias != 0){
			
			
	foreach($this->Model->tutoriales as $row){
	   
	$id = $row['PK1'];		
    $imagen = "media/tutoriales/thumbnails/thum_".$row['IMAGEN'];
	$titulo = $row['TITULO'];
    $descripcion = $row['DESCRIPCION'];
	$link = 'index.php?pag=tutoriales&view='.$id;
	
	
	  $content = $this->View->Template(TEMPLATE.'modules/noticia.tpl');
	  $content = $this->View->replace('/\#TITULO\#/ms' ,$titulo,$content);
	  $content = $this->View->replace('/\#IMAGEN\#/ms' ,   $imagen,$content);
	  $content = $this->View->replace('/\#RESUMEN\#/ms' ,$this->cortar_string (strip_tags($descripcion),250),$content);	
	   $content = $this->View->replace('/\#LINK\#/ms' ,$link,$content);
			
			
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
		$recurso .= "NO EXISTEN RESULTADOS";
		$recurso .= "#%#";
		$recurso .=$this->getpaginadoFooter();
		$recurso .= "#%#";
		$recurso .= $total;
		echo $recurso;	

		}
			

	 }
	 
	 
	 function searchLineamientos(){
	   
	 $this->Model->searchLineamientos();
	 $numlineamientos = sizeof($this->Model->lineamientos);
	 
	 $recurso =$this->getPaginadoHeader();
	 $recurso .= "#%#";
		
	 if($numlineamientos != 0){
			

	foreach($this->Model->lineamientos as $row){
	   
	$id = $row['PK1'];		
	$titulo = $row['TITULO'];
    $descripcion = $row['DESCRIPCION'];
	$link = 'index.php?pag=lineamientos&view='.$id;
	

	
	$ext = explode(".",$row['ADJUNTO']);
	
	switch($ext[1]){
		
		case "doc":
		case "docx":
		$imagen = "media/iconos/ik_word.png";
		break;
		
		case "ppt":
		case "pptx":
		$imagen = "media/iconos/ik_ppt.png";
		break;
		
		case "pdf":
		$imagen = "media/iconos/ik_pdf.png";
		break;
	
	}
	
	
	
	$content = $this->View->Template(TEMPLATE.'modules/noticia.tpl');
	$content = $this->View->replace('/\#TITULO\#/ms' ,$titulo,$content);
	$content = $this->View->replace('/\#IMAGEN\#/ms' ,$imagen,$content);
	$content = $this->View->replace('/\#RESUMEN\#/ms' ,$this->cortar_string (strip_tags($descripcion),250),$content);	
	$content = $this->View->replace('/\#LINK\#/ms' ,$link,$content);
			
			
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
		$recurso .= "NO EXISTEN RESULTADOS";
		$recurso .= "#%#";
		$recurso .=$this->getpaginadoFooter();
		$recurso .= "#%#";
		$recurso .= $total;
		echo $recurso;	

		} 	
		
	 }
	 
	 

	
	function descargaRecurso(){
	$url = $_GET["url"];
	$name = $_GET["name"];
	$tipo = $_GET["tipo"];
	
	
	switch($tipo){
	  case "IMG":
	  $url = $url.$name;
	  break;
	  
	  case "VID":
	  $url = $url;
	  break;
	  
	  case "DOC":
	  $url = $url;
	  break;
	  
	  	
	}

    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$url\"\n");
    $fp=fopen("$url", "r");
    fpassthru($fp);	
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