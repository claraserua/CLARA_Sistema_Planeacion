<?php
include "models/planesoperativo/seguimiento.model.php";
include "libs/resizeimage/class.upload.php";
include "core/storage-blobs-php-quickstart/phpQS_Class.php";


class seguimiento
{
    
    var $View;
    var $Model;
    var $menu;
    var $nodos;
    var $image;
    var $targetPathumbail;
    var $adjunto;
    var $object_Blob; 
    var $adjuntor;

    private $userG; 
    private $isAdm;
    private $permisosArray;
    private $permisoG; 
    function seguimiento()
    {
        
        $this->passport = new Authentication();
        $this->menu     = new Menu();
        $this->nodos    = new Niveles("option");
        $this->Model    = new seguimientoModel();
        $this->View     = new View();
        $this->alertas  = new Alertas();
        $this->object_Blob = new phpQS();
       

        switch ($_GET['method']) {
            
            case "Buscar":
                $this->Buscar();
                break;
            
            case "BuscarResultados":
                $this->BuscarResultados();
                break;
            
            case "BuscarEvidencias":
                $this->BuscarEvidencias();
                break;
            
            case "BuscarEvidencias2":
                $this->BuscarEvidencias2();
                break;
            
            
            case "EnviarInforme":
                $this->EnviarInforme();
                break;
            
            case "RevisarInforme":
                $this->RevisarInforme();
                break;
            
            case "GuardarResumenPeriodo":
                $this->GuardarResumenPeriodo();
                break;
            
            case "insertarColaborador":
                $this->insertarColaborador();
                break;
            
            case "eliminarColaborador":
                $this->eliminarColaborador();
                break;
            
            case "insertarComentario":
                $this->insertarComentario();
                break;
            
            case "insertarComentarioPeriodo":
                $this->insertarComentarioPeriodo();
                break;
            
            
            case "insertarComentarioResumenPeriodo":
                $this->insertarComentarioResumenPeriodo();
                break;
            
            
            case "eliminarComentario":
                $this->eliminarComentario();
                break;
            
            
            case "eliminarComentarioResumenPeriodos":
                $this->eliminarComentarioResumenPeriodos();
                break;
            
            
            case "GuardarAvanceObjetivo":
                $this->GuardarAvanceObjetivo();
                break;
            
            case "GuardarAvanceMedio":
                $this->GuardarAvanceMedio();
                break;
            
            
            case "ObtenerComentariosSeguimiento":
                $this->ObtenerComentariosSeguimiento();
                break;
            
            case "UploadFile":
                $this->UploadFile();
                break;
            
            case "UploadFileResumen":
                $this->UploadFileResumen();
                break;
            
            case "Buscarobjetivos":
                $this->Buscarobjetivos();
                break;
            
            case "EliminarAdjuntoResumen":
                $this->EliminarAdjuntoResumen();
                break;
            
            case "EliminarEvidencia":
                $this->EliminarEvidencia();
                break;
            
            case "EliminarEvidenciaArchivo":
                $this->EliminarEvidenciaArchivo();
                break;
            
            default:
                $this->loadPage();
                break;
        }
        
        
    }
    
    
    
    function loadPage()
    {
        //Permisos
        $this->userG = $_SESSION['session']['user'];
        $this->isAdm = $this->passport->isAdmin($this->userG);
        $this->permisosArray = $this->passport->getPrivilegio2($_GET['IDPlan']);
        $this->permisoG = $this->Model->obtenerEstadoPlan($_GET['IDPlan']);

        $this->View->template = TEMPLATE . 'modules/planesoperativo/SEGUIMIENTO.TPL';
        $this->View->loadTemplate();
        $this->loadHeader();
        $this->loadMenu();
        
        //if($this->passport->privilegios->hasPrivilege('P12')){
        $this->loadContent();
        //}else{
        $this->error();
        //}
        $this->loadFooter();
        $this->View->viewPage();
        
    }
    
    
    function loadHeader()
    {
        
        $section = TEMPLATE . 'sections/header.tpl';
        $section = $this->View->loadSection($section);
        $nombre  = htmlentities($_SESSION['session']['titulo'], ENT_QUOTES, "ISO-8859-1") . ' ' . htmlentities($_SESSION['session']['nombre'], ENT_QUOTES, "ISO-8859-1") . ' ' . htmlentities($_SESSION['session']['apellidos'], ENT_QUOTES, "ISO-8859-1");
        $imagen  = 'thum_40x40_' . $_SESSION['session']['imagen'];
        $section = $this->View->replace('/\#AVATAR\#/ms', $imagen, $section);
        $section = $this->View->replace('/\#USUARIO\#/ms',  $nombre, $section);
        
        $section = $this->View->replace('/<!--\#NUMNOTIFICACIONES\#-->/ms', $this->alertas->getNumAlertas(), $section);
        $section = $this->View->replace('/<!--\#NOTIFICACIONES\#-->/ms', $this->alertas->getAlertas(), $section);
        
        
        $this->View->replace_content('/\#HEADER\#/ms', $section);
        
    }
    
    
    function loadFooter()
    {
        
        $section = TEMPLATE . 'sections/footer.tpl';
        $section = $this->View->loadSection($section);
        $this->View->replace_content('/\#FOOTER\#/ms', $section);
        
    }
    
    
    
    function loadMenu()
    {
        
        $menu = $this->menu->menu;
        $this->View->replace_content('/\#MENU\#/ms', $menu);
        
        
    }
    
    
    
    function error()
    {
        
        $contenido = $this->View->Template(TEMPLATE . 'modules/error.tpl');
        $this->View->replace_content('/\#CONTENT\#/ms', $contenido);
    }
    
    
    
    function loadContent()
    {
        
        
        $contenido = $this->View->Template(TEMPLATE . 'modules/planesoperativo/FRMSEGUIMIENTO.TPL');
        $plan      = $this->Model->getPlanOperativo($_GET['IDPlan']);

        
        
        $contenido = $this->View->replace('/\#IDPLAN\#/ms', $_GET['IDPlan'], $contenido);
        
        $contenido = $this->View->replace('/\#ESTADO\#/ms', $this->Model->getEstadoPlanOperativo($_GET['IDPlan']), $contenido);
        
        
        //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P135" : "P134";
        $permiso = ($this->permisoG == "R") ? "P135" : "P134";
        //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
        if ($this->isAdm || in_array($permiso,$this->permisosArray) ) {
            $tabresumenejecutivo = '<li class=""> <a href="#resumen">Resumen
Ejecutivo</a></li>';
        } else {
            $tabresumenejecutivo = "";
        }
        
        $contenido = $this->View->replace('/\#TABRESUMENEJECUTIVO\#/ms', $tabresumenejecutivo, $contenido);
        
        
        $contenido = $this->View->replace('/\#TITULOPLAN\#/ms', htmlentities($plan['TITULO'], ENT_QUOTES, "ISO-8859-1"), $contenido);
        $contenido = $this->View->replace('/\#CONTENIDO\#/ms', $this->obtenerLineas(), $contenido);
        
        $contenido = $this->View->replace('/\#COMENTARIOSRESUMENEJECUTIVOPERIODOS\#/ms', $this->getPeriodosResumen(), $contenido);
        
        
        $btndiagnosticoi = '<div class="box-icon">
<a href="javascript:void(0)" onclick="Toogleresumenanual(this.id);" class="btn btn-minimize btn-round" id="BTNTOGRESUMENANUAL"><i class="icon-chevron-down"></i> Diagnóstico Inicial</a>                        
</div>';
        
        //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P133" : "P132";
        $permiso = ($this->permisoG == "R") ? "P133" : "P132";
        //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
        if ($this->isAdm || in_array($permiso,$this->permisosArray)) {
            $btndiagnosticoi = '<div class="box-icon">
<a href="javascript:void(0)" onclick="Toogleresumenanual(this.id);" class="btn btn-minimize btn-round" id="BTNTOGRESUMENANUAL"><i class="icon-chevron-down"></i> Diagnóstico Inicial</a>                        
</div>';
        } else {
            $btndiagnosticoi = '';
        }
        
        $contenido = $this->View->replace('/\#BTNDIAGNOSTICOI\#/ms', $btndiagnosticoi, $contenido);
        
        
        
        
        $contenido = $this->View->replace('/\<!--#VALUEDESCRIPCION#-->/ms', htmlspecialchars_decode($this->getResumenEjecutivo()), $contenido);
        
        
        $contenido = $this->View->replace('/\#BOTONENVIOINFORME\#/ms', $this->Model->validarPeriodosCompletos($_GET['IDPlan'], $this->passport), $contenido);
        
        $contenido = $this->View->replace('/\#LINEAS\#/ms', $this->getLineasPlan(), $contenido);
        
        $contenido = $this->View->replace('/\#EVIDENCIAS\#/ms', $this->getEvidencias(), $contenido);
        
        
        
        
        //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P118" : "P117";
        $permiso = ($this->permisoG == "R") ? "P118" : "P117";
        //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
        if ($this->isAdm || in_array($permiso,$this->permisosArray)) {
            $btncomendiagno = '<div class="box-icon" align="right">
<span style="float:right; position:relative; left:-10px;" class="notification">#NUMCOMENTARIOSRESUMEN#</span>
<a href="javascript:void(0)" onclick="Toogleresumen(this.id);" class="btn btn-minimize btn-round" id="BTNTOGRESUMEN"><i class="icon-chevron-down"></i> Comentarios</a>                        
</div>';
        } else {
            $btncomendiagno = '';
        }
        
        $contenido = $this->View->replace('/\#COMENTARIOSDIAGNOSTICOINICIAL\#/ms', $btncomendiagno, $contenido);
        
        
        
        $contenido = $this->View->replace('/\#NUMCOMENTARIOSRESUMEN\#/ms', $this->Model->getNumeroComentariosResumenEjecutivo($_GET['IDPlan']), $contenido);
        
        $contenido = $this->View->replace('/\#COMENTARIOSRESUMENEJECUTIVO\#/ms', $this->getComentariosResumenEjecutivo(), $contenido);
        
        
        
        $this->View->replace_content('/\#CONTENT\#/ms', $contenido);
    }
    
    
    
    function getResumenEjecutivo()
    {
        
         $this->Model->getAreas();
        $this->Model->getFortalezas();
        $numareas      = sizeof($this->Model->areas);
        $numfortalezas = sizeof($this->Model->fortalezas);
		
		
		$this->Model->getAmenazas();//amenazas   nuevo
		$this->Model->getOportunidades();//nuevo
		
		$numoportunidades = sizeof($this->Model->oportunidades); //nuevo	
		
		$numamenazas = sizeof($this->Model->amenazas); //nuevo
		
		
	//	$htmLcontent ="";
		
		
	$htmLcontent = '<div class="box-objectivos" id="BOX-AREAS">
	
	
		</br>
		 <div>
		 <span  style="color: #e68376;  font-size:14px; font-weight: bold; ">Análisis Interno </span>
		 </div>	
      
        <div class="wellwhite">
         <table width="100%">
         <tbody><tr>
         <td width="30">&nbsp;	</td>
         <td><strong>Fortalezas:</strong>	</td>            
         </tr>';           
          
		$loop = 1;
		if($numfortalezas != 0){ 	
		foreach($this->Model->fortalezas as $row){
          
		
		 $htmLcontent .= ' <tr id="FORTALEZA-'.$loop.'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  '.$loop.'.
          '.htmlentities($row['FORTALEZA'], ENT_QUOTES, "ISO-8859-1").'
		  </div> 
          </td>
          </tr>';
		  $loop++;
		 }
		 }
                    
        $htmLcontent .= '    
          </tbody></table>
          </div>';
                      
        //Áreas de Oportunidad (Debilidades)             
        $htmLcontent .= '  <div class="wellwhite">
         <table width="100%">
         <tbody><tr>
         <td width="30">&nbsp;	</td>
         <td><strong>Debilidades:	</strong></td>            
         </tr>';           
          
          
		$loop = 1;
		if($numareas != 0){ 
		
		foreach($this->Model->areas as $row){
          
		 $htmLcontent .= ' <tr id="AREA-'.$loop.'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  '.$loop.'.
          '.htmlentities($row['AREA'], ENT_QUOTES, "ISO-8859-1").'
		  </div> 
          </td>
          </tr>';
		  $loop++;
		 }
         }
	                
          $htmLcontent .='    
          </tbody></table>
          </div>';
		  
		  
		  
                                         
        $htmLcontent .= '  
		 <div>
		 <span  style="color: #e68376;  font-size:14px; font-weight: bold; ">Análisis Externo </span>
		 </div>
		
		<div class="wellwhite">
		
         <table width="100%">
         <tbody>
		 <tr>
         <td width="30">&nbsp;	</td>
         <td><strong>Oportunidades:	</strong></td>            
         </tr>';           
          
          
		$loop = 1;
		if($numoportunidades != 0){ 
		
		foreach($this->Model->oportunidades as $row){
          
		 $htmLcontent .= ' <tr id="OPORTUNIDADES-'.$loop.'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  '.$loop.'.
          '.htmlentities($row['OPORTUNIDADES'], ENT_QUOTES, "ISO-8859-1").'
		  </div> 
          </td>
          </tr>';
		  $loop++;
		 }
         }
	                
        $htmLcontent .='    
          </tbody></table>
          </div>';
		  
		  
		  
        $htmLcontent .= '  <div class="wellwhite">
         <table width="100%">
         <tbody><tr>
         <td width="30">&nbsp;	</td>
         <td><strong>Amenazas:	</strong></td>            
         </tr>';           
          
          
		$loop = 1;
		if($numamenazas != 0){ 
		
		foreach($this->Model->amenazas as $row){
          
		 $htmLcontent .= ' <tr id="DEBILIDADES-'.$loop.'">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  '.$loop.'.
          '.htmlentities($row['AMENAZAS'], ENT_QUOTES, "ISO-8859-1").'
		  </div> 
          </td>
          </tr>';
		  $loop++;
		 }
         }
	                
          $htmLcontent .='    
          </tbody></table>
          </div>';
		  
		    $htmLcontent .=' </div>';

        
        
        
        return $htmLcontent;
    }
    
    
    function obtenerLineas()
    {
        
        $script       = "";
        $tabs         = "";
        $panelcontent = "";
        $section      = "";
        $arraycolores = array(
            "Blue",
            "Purple",
            "Teal",
            "Aqua",
            "Fuchsia",
            "Navy",
            "Red",
            "Green",
            "Lime",
            "Maroon",
            "Olive"
        );
        
        $this->Model->getLineasPlane($_GET['IDPlanE']);
        $numlineas = sizeof($this->Model->lineas);
        
        if ($numlineas != 0) {
            
            $script       = '<script> ';
            $tabs         = '<ul class="nav nav-tabs" id="myTab">';
            $panelcontent = '<div id="myTabContent" class="tab-content">';
            $cont         = 1;
            $loop         = 0;
            foreach ($this->Model->lineas as $row) {
                
                $script .= '
            arraylineas_objetivos[' . $loop . '] = new Array(); 
            lineas_objetivos_medios[' . $loop . '] = new Array();
            lineas_objetivos_evidencias[' . $loop . '] = new Array();
             ';
                $idlinea = $row['PK1'];
                $linea   = $row['LINEA'];
                
                $bodyestado = htmlentities($linea, ENT_QUOTES, "ISO-8859-1");
                $titlestado = "Linea " . $cont . ":";
                
                $tabs .= '<li class="" data-rel="popover" data-content="' . $bodyestado . '" title="' . $titlestado . '" ><a href="#linea' . $cont . '">Linea ' . $cont . '</a></li>';
                $panelcontent .= '<div class="tab-pane" id="linea' . $cont . '">';
                $panelcontent .= '<div class="box" id="L' . $cont . '" >
                     <div class="box-head" >
                     <h2 class="left">Línea estratégica ' . $cont . ': ' . htmlentities($linea, ENT_QUOTES, "ISO-8859-1") . '</h2>    
                      <input type="hidden" id="PK_LINEA_' . $cont . '" value="' . $idlinea . '"/>         
                    </div>';
                
                
                $this->Model->getObjetivosTacticos($_GET['IDPlan'], $idlinea);
                
                
                $numobjetivos = sizeof($this->Model->objetivos);
                
                
                
                $contobjetivo = 1;
                $loopobjetivo = 0;
                if ($numobjetivos != 0) {
                    
                    
                    /**
                     * 
                     * @var ***************OBJETIVOS TACTICOS************************
                     * 
                     */
                    foreach ($this->Model->objetivos as $rowobj)
                        if (trim($rowobj['OBJETIVO']) == "Agregar un resultado..." || trim($rowobj['OBJETIVO']) == "Agregar un objetivo...") {
                        } else {
                            {
                                
                                
                                $script .= '
      
            arraylineas_objetivos[' . $loop . '].push("1");
            lineas_objetivos_medios[' . $loop . '][' . $loopobjetivo . '] = new Array();
            lineas_objetivos_evidencias[' . $loop . '][' . $loopobjetivo . '] = new Array();
            
            
                        
            $("#inputField-L' . $cont . '-' . $contobjetivo . '").bind("blur focus keydown keypress keyup", function(){recount(\'' . $cont . '-' . $contobjetivo . '\');});
            $("#update_button-L' . $cont . '-' . $contobjetivo . '").attr("disabled","disabled");
            $("#inputField-L' . $cont . '-' . $contobjetivo . '").Watermark("Agrega tu comentario ...");
             ';
                                
                                
                                $this->Model->getMedios($rowobj['PK1']);
                                $nummedios = sizeof($this->Model->medios);

                                $this->Model->getIndicadoresMetas($rowobj['PK1']);
                                $numIndicadoresMeta = sizeof($this->Model->indicadoresMeta);
                                
                                $colspan = (int) $nummedios * 2 + 7;
                                $colspan2 = (int) $numIndicadoresMeta * 2 + 7;

                                
                                $this->Model->getPeriodos($_GET['IDPlan']);
                                
                                $numperiodos = sizeof($this->Model->periodos);
                                
                                $widhttable = 600 + (((int) $this->Model->getPeriodosActivos($_GET['IDPlan'])) * 400);
                                
                                $panelcontent .= '<!--====================OBJETIVO=====================--> 
       
      
   <div class="wellwhite" id="L' . $cont . '-C' . $contobjetivo . '">
   
       <table width="100%" class="tablelight">
       
       <tr>
       <th>
       <table><tr class="periodo">';
                                
                                $this->Model->getPeriodosAll($_GET['IDPlan']);
                                $fecha_i = date("Y-m-d");
                                
                                
                                foreach ($this->Model->periodosall as $rowperiodos) {
								
								  if($rowperiodos['FECHA_I'] == null||$rowperiodos['FECHA_I'] == ""){ $fechap = $rowperiodos['FECHA_I']; }
	                              else{ $fechap = $rowperiodos['FECHA_I']->format('Y-m-d');}
	   
								
                                    
                                    if ($fechap <= $fecha_i) {
                                        
                                        if ($rowperiodos['ORDEN'] == 1 && $rowperiodos['ENVIADO'] == 0 || $rowperiodos['ENVIADO'] == 1) {
                                            $panelcontent .= '<th class="periodoactivo" >' . $rowperiodos['PERIODO'] . '</h3></th>';
                                        } else {
                                            
                                            if ($rowperiodos['ENVIADO'] == 2) {
                                                $panelcontent .= '<th class="periodoactivo" >' . $rowperiodos['PERIODO'] . '</h3></th>';
                                            }
                                            
                                            if ($rowperiodos['ENVIADO'] == 3) {
                                                $panelcontent .= '<th>' . $rowperiodos['PERIODO'] . '</h3></th>';
                                            }
                                            
                                            if ($rowperiodos['ENVIADO'] == 0) {
                                                $panelcontent .= '<th class="periodopasado">' . $rowperiodos['PERIODO'] . '</h3></th>';
                                            }
                                            
                                        }
                                    } else {
                                        
                                        $panelcontent .= '<th class="periodopasado">' . $rowperiodos['PERIODO'] . '</h3></th>';
                                    }
                                    
                                }
                                
                                $rowobjestr = $this->Model->getObjetivoEst($rowobj['PK_OESTRATEGICO']);
                                $idobjestr  = intval($rowobjestr['ORDEN']);
                                $idobjestr++;
								
								
								   $sustituye   = array("\r\n", "\n", "\r");
                                
                                
                                $panelcontent .= '</tr></table>
       </th>
       </tr>
       
       <tr>
       <th ><strong>Objetivo Estratégico&nbsp;' . $cont . '.' . $idobjestr . ':</strong>&nbsp;<h3>' . htmlentities($rowobjestr['OBJETIVO'], ENT_QUOTES, "ISO-8859-1") . '</h3>
                                                                                                                                                                                                                                             
      
	     
			
       <div class="right" style="margin-top:-65px;"><span class="notification">' . $this->Model->getNumeroEvidencias($rowobj['PK1']) . '</span> <button class="btn" onClick="ShowEvidencias(\'' . $rowobj['PK1'] . '\',\'' . $rowobj['PK_LESTRATEGICA'] . '\',\'' . $_GET['IDPlan'] . '\',\'' . trim(htmlentities(str_replace($sustituye," ",$rowobj['OBJETIVO']), ENT_QUOTES, "ISO-8859-1")) . '\',\'' . trim(htmlentities(str_replace($sustituye," ",$linea), ENT_QUOTES, "ISO-8859-1")) . '\');"> <i class="icon-eye-open"></i> Evidencias </button>
      
      </div>
       
       </th>
       </tr>
       <tr>
        <td>
            <a id="TOGI-L' . $cont . '-C' . $contobjetivo . '" class="btn btn-minimize btn-round" onclick="ToogleIndicadores(this.id);" href="javascript:void(0)"><i class="icon-chevron-up"></i> Ocultar Indicadores de Objetivo Estratégico </a>
        </td>
       </tr>
       <tr>
        <td>
            <div class="box-seguimiento" id="BOXI-L' . $cont . '-C' . $contobjetivo . '">
            <table class="tablelight"  style="margin: auto;width:520px;">
            <thead>
            <tr>
              <th>Indicador de Objetivo</th>
              <th>Meta al 2024</th>                   
            </tr>
            </thead>
            <tbody>';
            $this->Model->getIndicadoresByObj($rowobj['PK1'],$rowobj['PK_OESTRATEGICO']);
            $contadorIndicadores = 0;
            foreach($this->Model->indicadoresByObj as $indC){
                $contadorIndicadores ++;
                $panelcontent .= '<tr>'.'<td>'.$cont.'.'.$contobjetivo.'.'.$contadorIndicadores.' '.htmlentities($indC['INDICADOR'], ENT_QUOTES, "ISO-8859-1").'</td><td>'.$indC['META'].'</td><tr>';

            }

            
        $panelcontent.=    '
            </tbody>
            </table>
            </div>
        </td>
       </tr>   
       <tr>
        <td>
            <a id="TOGS-L' . $cont . '-C' . $contobjetivo . '" class="btn btn-minimize btn-round" onclick="ToogleSeguimiento(this.id);" href="javascript:void(0)"><i class="icon-chevron-up"></i> Ocultar Seguimiento de Avances </a>
        </td>
       </tr>
       
       
       </table>
                  
      <div class="box-seguimiento" id="BOXS-L' . $cont . '-C' . $contobjetivo . '">
   <table style="margin: auto;width:300px;" width="' . $widhttable . '" class="tablelight">
   
   <tbody>      
    <tr>';
                                
                                /* <th width="800">Objetivo Estrategico</th>
                                <th width="400">Resposansable</th>*/
                                
                                
                                $panelcontent .= '<!-- <td colspan="1" class="cell" rowspan=""></td>-->
      ';
                                
                                
                                if ($numperiodos != 0) {
                                    foreach ($this->Model->periodos as $rowperiodos) {
                                        
                                        if ($rowperiodos['ORDEN'] == 1 || $rowperiodos['ENVIADO'] == 1 || $rowperiodos['ENVIADO'] == 2 || $rowperiodos['ENVIADO'] == 3) {
                                            $panelcontent .= '
      <th width="500" >' . $rowperiodos['PERIODO'] . '</th>
      
       <!--<td colspan="1" class="cell" rowspan=""></td>-->';
                                            
                                        }
                                    }
                                }
                                
                                
                                $panelcontent .= '</tr>';
                                
                                
                                $panelcontent .= '<tr>';
                                
                                if ($numperiodos != 0) {
                                    foreach ($this->Model->periodos as $rowperiodos) {
                                        
                                        
                                        if ($rowperiodos['ORDEN'] == 1 || $rowperiodos['ENVIADO'] == 1 || $rowperiodos['ENVIADO'] == 2 || $rowperiodos['ENVIADO'] == 3) {
                                            $panelcontent .= '
      <td width="500" >
        <table width="100%">
            <tr>
                <th width="70%">Resultado</th>
                <th width="30%">Responsable</th>
            </tr>
            <tr>
                <td><h3>' . $cont . '.' . $contobjetivo . '&nbsp;' . htmlentities($rowobj['OBJETIVO'], ENT_QUOTES, "ISO-8859-1") . '</h3></td>
                <td>&nbsp;' . htmlentities($this->Model->getResponsable($rowobj['PK_RESPONSABLE']), ENT_QUOTES, "ISO-8859-1") . '</td>
            </tr>
        </table>
    </td>';
                                            
                                            
                                            
                                        }
                                    }
                                }
                                
                                $panelcontent .= '</tr>';
                                $contperiodo = 1;
                                if ($numperiodos != 0) {
                                    
                                    $valor1 = 0;
                                    foreach ($this->Model->periodos as $rowperiodos) {
                                        
                                        if ($rowperiodos['ENVIADO'] == 2) {
                                            
                                            
                                            if ($this->Model->getPorcentajeObjetivo($rowobj['PK1'], $rowperiodos['PK1'])) {
                                                $valor    = $this->Model->getPorcentajeObjetivo($rowobj['PK1'], $rowperiodos['PK1']);
                                                $minvalor = $valor1;
                                                
                                            } else {
                                                
                                                $this->Model->setPorcentajeObjetivo($rowobj['PK1'], $rowperiodos['PK1'], $valor1);
                                                
                                                $valor    = $valor1;
                                                $minvalor = $valor1;
                                            }
                                            
                                            
                                            
                                        } else {
                                            
                                            
                                            
                                            
                                            
                                            $valor1   = $this->Model->getPorcentajeObjetivo($rowobj['PK1'], $rowperiodos['PK1']);
                                            $valor    = $valor1;
                                            $minvalor = $valor1;
                                            
                                            
                                            
                                        }
                                        
                                        $minvalor = ($minvalor == "") ? 0 : $minvalor;
                                        $valor    = ($valor == "") ? 0 : $valor;
                                        
                                        $script .= ' $("#' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-application-progress").slider({
    
    value: ' . $valor . ',
    range: "min",
    min: 0,
    max: 100,
    animate: true,
    slide: function(event,ui){';
                                        
                                        if ($rowperiodos['ENVIADO'] == 2) {
                                            
                                            $script .= 'if(ui.value <= ' . $minvalor . ' ){
            return false;
        }else{
    $("#slider-value-' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-application-progress").html(ui.value+"%");            
        
        }';
                                        } else {
                                            
                                            $script .= '
     $("#slider-value-' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-application-progress").html(ui.value+"%"); ';
                                        }
                                        
                                        $script .= '},stop: function(event, ui) {
        
        guardarPorcentajeObjetivo(\'' . $rowobj['PK1'] . '\',\'' . $rowperiodos['PK1'] . '\',ui.value);
        
        }
     }); ';
                                        
                                        $permisomodificaravance = false;
                                        
                                        if ($rowperiodos['ENVIADO'] == 1 || $rowperiodos['ENVIADO'] == 3) {
                                            
                                            //echo "PERIODOS = ".$rowperiodos['ENVIADO'];
											
											
                                            //SI NO TIENE PERMISO PARA REGISTRAR AVANCE DE OBJETIVO EN REVISION
                                            if (!$this->passport->getPrivilegio($_GET['IDPlan'], 'P95')) {
                                            //if ($this->isAdm || !in_array('P95',$this->permisosArray)) {
												//echo "No tiene permiso ".$cont . '-' . $contobjetivo . '-' . $contperiodo." |";
                                                $script .= ' $("#' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-application-progress").slider( "disable" );';
                                            }
                                            
                                            
                                        } else {
                                            
                                            
                                            
                                            //SI TIENE PERMISO PARA ENVIAR PUEDE REGSITAR TODOS LOS AVANCES
                                            if ($this->passport->getPrivilegio($_GET['IDPlan'], 'P70')) {
                                            //if ($this->isAdm|| in_array('P70',$this->permisosArray)) {
                                                $permisomodificaravance = true;
                                            } else {
                                                
                                              // echo strtolower($rowobj['PK1']."-".$rowobj['PK_RESPONSABLE']."-".$_SESSION['session']['user']." | ");  
                                                //echo strtolower($_SESSION['session']['user']);
                                                
                                                if (strtolower($rowobj['PK_RESPONSABLE']) != strtolower($_SESSION['session']['user'])) {
                                                                                                         
                                                   
												   $script .= ' $("#' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-application-progress").slider( "disable" );';
                                                    
                                                    
                                                } else {
                                                    
                                                    $permisomodificaravance = true;
                                                }
                                                //SI NO TIENE PERMISO PARA REGISTRAR AVANCE DE OBJETIVO EN ELABORACION
                                                if (!$this->passport->getPrivilegio($_GET['IDPlan'], 'P92')) {
                                                //if ($this->isAdm || !in_array('P92',$this->permisosArray)){
                                                       // echo "No tiene permiso";
                                                    $script .= ' $("#' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-application-progress").slider( "disable" );';
                                                }
                                            }
                                        }
                                        
                                        
                                        
                                        
                                        $color = $arraycolores[$contperiodo - 1];
                                        $script .= '$("#' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-application-progress .ui-slider-range").css( "background", "' . $color . '" );';
                                        
                                        if ($rowperiodos['ORDEN'] == 1 || $rowperiodos['ENVIADO'] == 1 || $rowperiodos['ENVIADO'] == 2 || $rowperiodos['ENVIADO'] == 3) {
                                            
                                            $panelcontent .= '
      <td> 
      <table width="100%">
      <tr>
      <td class="cell2" width="10%">' . $cont . '.' . $contobjetivo . '</td>
      <td class="cell2" width="80%"><div class="application-progress" id="' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-application-progress"></div></td>
      <td class="cell2" width="10%"><span id="slider-value-' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-application-progress">' . $valor . '%</span></td>
      </tr>
      </table>
      </td>';
                                        }
                                        $contperiodo++;
                                    }
                                }
                                
                                
    $panelcontent .= '</tr>
    <!-- Indicadores de Resultado-->
    <tr>';
                                
                                
                                
                                if ($numperiodos != 0) {
                                    foreach ($this->Model->periodos as $rowperiodos) {
                                        
                                        if ($rowperiodos['ORDEN'] == 1 || $rowperiodos['ENVIADO'] == 1 || $rowperiodos['ENVIADO'] == 2 || $rowperiodos['ENVIADO'] == 3) {
                                            $panelcontent .= '
        <td>
            <table width="100%">
                <tr>
                    <th width="70%">Indicador de Resultado</th>
                    <th width="30%">Meta Anual</th>
                </tr>
            
            </table>
        </td>';
                                        }
                                    }
                                }
        $panelcontent .= '</tr>
        <!-- Indicadores-->';
                                    
            $contIndicadorMeta= 1;
            $loopIndicadorMeta = 0;
            if ($numIndicadoresMeta != 0) {  
            foreach ($this->Model->indicadoresMeta as $rowIndicadorMeta) {
            ##########  INDICADORES DE RESULTADOS ###########                        
                $panelcontent .= '<tr>';
                                            
                if ($numperiodos != 0) {
                    foreach ($this->Model->periodos as $rowperiodos) {
                                                    
                        if ($rowperiodos['ORDEN'] == 1 || $rowperiodos['ENVIADO'] == 1 || $rowperiodos['ENVIADO'] == 2 || $rowperiodos['ENVIADO'] == 3) {
                            $panelcontent .= '
                                        <td>
                            <table width="500">
                            <tr>
                            <td width="70%">&nbsp;<h3>
                            ' . $cont . '.' . $contobjetivo . '.' . $contIndicadorMeta . '&nbsp;
                            ' . htmlentities($rowIndicadorMeta['INDICADOR'], ENT_QUOTES, "ISO-8859-1") . '</h3></td>
                            <td  width="30%"><h3>' . htmlentities($rowIndicadorMeta['META'], ENT_QUOTES, "ISO-8859-1") . '</h3></td>
                            </tr>
                            </table>
                            </td>
                            <!-- fin Indicadores de Resultados-->
                            ';
                        }
                        $contIndicadorMeta++;
                    }
                }
            }
            }
        $panelcontent .= '</tr>
        <tr>';
                                    
                                    
                                    
                                    if ($numperiodos != 0) {
                                        foreach ($this->Model->periodos as $rowperiodos) {
                                            
                                            if ($rowperiodos['ORDEN'] == 1 || $rowperiodos['ENVIADO'] == 1 || $rowperiodos['ENVIADO'] == 2 || $rowperiodos['ENVIADO'] == 3) {
                                                $panelcontent .= '
            <td>
                <table width="100%">
                    <tr>
                        <th width="70%">Medios</th>
                        <th width="30%">Responsable</th>
                    </tr>
                
                </table>
            </td>
            ';
                                            }
                                        }
                                    }
                                
                                
     $panelcontent .= '</tr>
    <!-- MEDIOS-->';
                                
                                $contmedio = 1;
                                $loopmedio = 0;
                                if ($nummedios != 0) {
                                    
                                    foreach ($this->Model->medios as $rowmedios) {
                                        $script .= '
            lineas_objetivos_medios[' . $loop . '][' . $loopobjetivo . '][' . $loopmedio . '] = "1";
             ';
                                        
                                        ##########  MEDIOS ###########    
                                        
                                        $panelcontent .= '<tr>';
                                        
                                        if ($numperiodos != 0) {
                                            foreach ($this->Model->periodos as $rowperiodos) {
                                                
                                                if ($rowperiodos['ORDEN'] == 1 || $rowperiodos['ENVIADO'] == 1 || $rowperiodos['ENVIADO'] == 2 || $rowperiodos['ENVIADO'] == 3) {
                                                    $panelcontent .= '
                                    <td>
                                     <table width="500">
      <tr>
      <td width="70%">&nbsp;<h3>
        ' . $cont . '.' . $contobjetivo . '.' . $contmedio . '&nbsp;
        ' . htmlentities($rowmedios['MEDIO'], ENT_QUOTES, "ISO-8859-1") . '</h3></td>
      <td  width="30%"><h3>' . htmlentities($this->Model->getResponsable($rowmedios['PK_RESPONSABLE']), ENT_QUOTES, "ISO-8859-1") . '</h3></td>
      </tr>
      </table>
        </td>';
                                                }
                                            }
                                        }
                                        $panelcontent .= '</tr>';
                                        
                                        ##########  MEDIOS END   ###########     
                                        
                                        $panelcontent .= '
             <tr id="L' . $cont . '-O' . $contobjetivo . '-M' . $contmedio . '-C' . $contobjetivo . '">';
                                        
                                        
                                        
                                        
                                        $contperiodo = 1;
                                        if ($numperiodos != 0) {
                                            
                                            $valor1 = "";
                                            foreach ($this->Model->periodos as $rowperiodos) {
                                                
                                                
                                                
                                                if ($rowperiodos['ENVIADO'] == 2) {
                                                    //$this->Model->setPorcentajeMedio($rowmedios['PK1'],$rowperiodos['PK1'],$valor);    
                                                    if ($this->Model->getPorcentajeMedio($rowmedios['PK1'], $rowperiodos['PK1'])) {
                                                        $valor    = $this->Model->getPorcentajeMedio($rowmedios['PK1'], $rowperiodos['PK1']);
                                                        $minvalor = $valor1;
                                                    } else {
                                                        
                                                        
                                                        
                                                        $this->Model->setPorcentajeMedio($rowmedios['PK1'], $rowperiodos['PK1'], $valor1);
                                                        $valor    = $valor1;
                                                        $minvalor = $valor1;
                                                    }
                                                } else {
                                                    $valor1   = $valor = $this->Model->getPorcentajeMedio($rowmedios['PK1'], $rowperiodos['PK1']);
                                                    $valor    = $valor1;
                                                    $minvalor = $valor1;
                                                }
                                                
                                                $valor = ($valor == "") ? 0 : $valor;
                                                
                                                $script .= ' $("#' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-' . $contmedio . '-application-progress").slider({
    value:' . $valor . ',
    range: "min",
    min: 0,
    max: 100,
    animate: true,
    slide: function(event,ui){';
                                                
                                                
                                                $minvalor = ($minvalor == "") ? 0 : $minvalor;
                                                
                                                
                                                if ($rowperiodos['ENVIADO'] == 2) {
                                                    $script .= 'if(ui.value <= ' . $minvalor . ' ){
            return false;
        }else{
    $("#slider-value-' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-' . $contmedio . '-application-progress").html(ui.value+"%");        
        
        }';
                                                } else {
                                                    $script .= '$("#slider-value-' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-' . $contmedio . '-application-progress").html(ui.value+"%");';
                                                }
                                                
                                                
                                                
                                                $script .= '},stop: function(event, ui) {
        
        guardarPorcentajeMedio(\'' . $rowmedios['PK1'] . '\',\'' . $rowperiodos['PK1'] . '\',ui.value);
        }
     }); ';
                                                
                                                
                                                if ($rowperiodos['ENVIADO'] == 1 || $rowperiodos['ENVIADO'] == 3) {
                                                    if (!$this->passport->getPrivilegio($_GET['IDPlan'], 'P95')) {
                                                    //if ($this->isAdm || !in_array('P95',$this->permisosArray)){
                                                        $script .= ' $("#' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-' . $contmedio . '-application-progress").slider( "disable" );';
                                                    }
                                                } else {
                                                    
                                                    if (!$permisomodificaravance) {
                                                        
                                                        if (strtolower($rowmedios['PK_RESPONSABLE']) != strtolower($_SESSION['session']['user'])) {
                                                            $script .= ' $("#' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-' . $contmedio . '-application-progress").slider( "disable" );';
                                                        }
                                                    }
                                                    
                                                    if (!$this->passport->getPrivilegio($_GET['IDPlan'], 'P92')) {
                                                    //if ($this->isAdm || !in_array('P92',$this->permisosArray)){
                                                        $script .= ' $("#' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-' . $contmedio . '-application-progress").slider( "disable" );';
                                                    }
                                                    
                                                }
                                                
                                                $color = $arraycolores[$contperiodo - 1];
                                                $script .= '$("#' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-' . $contmedio . '-application-progress .ui-slider-range").css( "background", "' . $color . '" );';
                                                
                                                if ($rowperiodos['ORDEN'] == 1 || $rowperiodos['ENVIADO'] == 1 || $rowperiodos['ENVIADO'] == 2 || $rowperiodos['ENVIADO'] == 3) {
                                                    $panelcontent .= '
                                    <td>
                                     <table width="100%">
      <tr>
      <td class="cell2" width="10%"><div data-rel="popover" data-content="' . htmlentities($rowmedios['MEDIO'], ENT_QUOTES, "ISO-8859-1") . '" title="Medio ' . $cont . '.' . $contobjetivo . '.' . $contmedio . '">' . $cont . '.' . $contobjetivo . '.' . $contmedio . '</div></td>
      <td class="cell2" width="80%"><div class="application-progress" id="' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-' . $contmedio . '-application-progress"></div></td>
      <td class="cell2" width="10%"><span id="slider-value-' . $cont . '-' . $contobjetivo . '-' . $contperiodo . '-' . $contmedio . '-application-progress">' . $valor . '%</span></td>
      </tr>
      </table>
        </td>';
                                                    
                                                    
                                                    $contperiodo++;
                                                }
                                            }
                                        }
                                        
                                        
                                        
                                        $panelcontent .= '</tr>';
                                        
                                        
                                        
                                        
                                        $contmedio++;
                                        $loopmedio++;
                                    }
                                    
                                    $panelcontent .= '<tr>
            ';
                                    
                                    /*<td colspan="2"></td>*/
                                    
                                    
                                    $contperiodo = 1;
                                    if ($numperiodos != 0) {
                                        foreach ($this->Model->periodos as $rowperiodos) {
                                            
                                            $idinforme = $cont . '-' . $contobjetivo . '-' . $contperiodo;
                                            
                                            if ($rowperiodos['ORDEN'] == 1 || $rowperiodos['ENVIADO'] == 1 || $rowperiodos['ENVIADO'] == 2 || $rowperiodos['ENVIADO'] == 3) {
                                                $panelcontent .= '
                                    <td>';
                                                
                                                
                                                //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P96" : "P55";
                                                $permiso = ($this->permisoG == "R") ? "P96" : "P55";

                                                //$permiso =  ( $rowperiodos['ENVIADO']==1 || $rowperiodos['ENVIADO']==3 )? "P96":"P55";
                                                
                                                //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                                                if ($this->isAdm || in_array('P92',$this->permisosArray)){
                                                    
                                                    
                                                    $panelcontent .= ' 
    <div><span class="notification">' . $this->Model->getNumeroComentariosPeriodo($rowobj['PK1'], $rowperiodos['PK1']) . '</span>
     <button class="btn" onClick="OpenAnotaciones(\'' . $rowobj['PK1'] . '\',\'' . $rowperiodos['PK1'] . '\',\'' . $rowperiodos['PERIODO'] . '\');">Anotaciones del centro y revisión <i class="icon-comment"></i></button> </div>';
                                                    
                                                }
                                                
                                                $panelcontent .= '</td>';
                                                $contperiodo++;
                                                
                                            }
                                            
                                            
                                        }
                                    }
                                    
                                    $panelcontent .= ' </tr>';
                                    
                                }
                                
                                
                                $panelcontent .= '<!-- MEDIOS-->
       
       </tbody>
    </table>
                    
      </div>
      <br>';
                                
                                
                                //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P97" : "P41";
                                $permiso = ($this->permisoG == "R") ? "P97" : "P41";
                                
                                
                                //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                                if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                                    $panelcontent .= '<div class="box-icon">
<a href="javascript:void(0)" onclick="Toogle(this.id);" class="btn btn-minimize btn-round" id="TOG-L' . $cont . '-C' . $contobjetivo . '"><i class="icon-chevron-down"></i>&nbsp;Comentarios&nbsp;<i class="icon-comment"></i></a><span class="notification">' . $this->Model->getNumeroComentarios($rowobj['PK1']) . '</span>                        
</div>';
                                }
                                
                                $panelcontent .= ' <div class="box-objetivos" style="display:none;" id="BOX-L' . $cont . '-C' . $contobjetivo . '">
       
   ';
                                
                                
                                
                                /* EVIDENCIAS $panelcontent .=' 
                                
                                <div class="well">
                                <table width="100%">
                                <tr>
                                <td width="30">&nbsp;    </td>
                                <td><strong>Evidencias</strong>    </td>            
                                </tr>';
                                
                                
                                $this->Model->getEvidencias($rowobj['PK1']);
                                $numevidencias = sizeof($this->Model->evidencias); 
                                
                                $contevidencia = 1;
                                $loopevidencia = 0;
                                if($numevidencias != 0){
                                
                                
                                foreach($this->Model->evidencias as $rowevidencias){
                                $script .='
                                lineas_objetivos_evidencias['.$loop.']['.$loopobjetivo.']['.$loopevidencia.'] = "1";
                                ';               
                                
                                $panelcontent .=' <tr id="L'.$cont.'-O'.$contobjetivo.'-E'.$contevidencia.'-C'.$contobjetivo.'">
                                <td>&nbsp; </td>       
                                <td>  
                                &nbsp;
                                '.$contobjetivo.'.'.$contevidencia.'&nbsp;
                                '.$rowevidencias['EVIDENCIA'].'
                                
                                </td>
                                </tr>';
                                
                                
                                $contevidencia++;
                                $loopevidencia++;
                                }
                                }
                                
                                
                                $panelcontent .='<tr>
                                <td colspan="2">
                                <div class="left" style="margin-left:30px;">         
                                
                                </div>
                                </td>
                                </tr>     
                                </table>
                                </div>                          END EVIDENCIAS */
                                
                                
                                $panelcontent .= '  <!--====================COMENTARIOS=====================-->
          
          <div id="twitter-container">';
                                
                                //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P98" : "P93";
                                $permiso = ($this->permisoG == "R") ? "P98" : "P93";
                                //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                                if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                                    
                                    $panelcontent .= ' <span class="counter" id="counter-L' . $cont . '-' . $contobjetivo . '"></span>
                <textarea name="inputField" id="inputField-L' . $cont . '-' . $contobjetivo . '"   tabindex="1" rows="2" cols="40"></textarea>
               
               
        <input class="submitButton inact" name="submit" type="button" onClick="guardarComentario(this.id,\'' . $rowobj['PK1'] . '\');" value="comentar" disabled="disabled" id="update_button-L' . $cont . '-' . $contobjetivo . '" />';
                                    
                                }
                                
                                $panelcontent .= '<div class="clear"></div>
            
          </div>
          
          
          
        
          <div id="flashmessage">    
    <div id="flash"></div>
              </div>
             <div class="comentarios" id="comentarios-L' . $cont . '-' . $contobjetivo . '">';
                                
                                
                                //  echo $rowobj['PK1']."<";
                                $this->Model->getComentarios($rowobj['PK1']);
                                $numcomentarios = sizeof($this->Model->comentarios);
                                
                                if ($numcomentarios != 0) {
                                    
                                    foreach ($this->Model->comentarios as $rowcomentarios) { {
                                            
                                            $comentario_id = $rowcomentarios['PK1'];
                                            $usuario_id    = $rowcomentarios['PK_USUARIO'];
                                            $fecha         = $rowcomentarios['FECHA_R']; //date_format() 
                                            $comentario    = stripslashes(htmlentities($rowcomentarios['COMENTARIO'], ENT_QUOTES, "ISO-8859-1"));
                                            
                                            $rowusuario = $this->Model->getImagen($usuario_id);
                                            $imagen     = "media/usuarios/" . $rowusuario['IMAGEN'];
                                            
                                            $usuario = $rowusuario['NOMBRE'] . "" . $rowusuario['APELLIDOS'];
                                            
                                            
                                            $panelcontent .= '<div class="stbody" id="stbody' . $comentario_id . '">
            <div class="sttimg"><img src="' . $imagen . '" class="big_face"/></div> 
            <div class="sttext">';
                                            
                                            
                                            //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P99" : "P94";
                                            $permiso = ($this->permisoG == "R") ? "P99" : "P94";
                                            //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                                            if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                                                $panelcontent .= '<a class="stdelete" href="#" id="' . $comentario_id . '" title="Borrar comentario"><i class="icon-remove"></i></a>';
                                            }
                                            $panelcontent .= '<strong><a href="#" class="comentuser">' . htmlentities($usuario, ENT_QUOTES, "ISO-8859-1") . '</a></strong>
                        ' . $comentario . '
                           <div class="sttime">' . date('d/m/Y H:i:s', strtotime($fecha->format('Y-m-d'))) . '</div> 
                    </div>  
                </div>';
                                            
                                        }
                                    }
                                    
                                }
                                
                                $panelcontent .= ' </div>
        
           <!--====================END COMENTARIOS=====================-->
          
                </div>             
          </div>
          
           
          
           <!--====================END OBJETIVO=====================-->';
                                $contobjetivo++;
                                $loopobjetivo++;
                            }
                        }
                }
                /**
                 * 
                 * @var *************** END OBJETIVOS TACTICOS************************
                 * 
                 */
                $panelcontent .= '<!-- Pagging -->
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
                        <div class="right">
        
                        </div>
                        </div>
                        <!-- End Pagging --> 
                        </div>  ';
                $panelcontent .= '</div>';
                $cont++;
                $loop++;
            }
            $tabs .= '</ul>';
            $panelcontent .= '</div>';
        }
        
        
        $script .= "</script>";
        $section .= $tabs;
        $section .= $panelcontent;
        $section .= $script;
        
        return $section;
    }
    
    
    
    function insertarColaborador()
    {
        
        
        $this->Model->nombre       = $_POST['nombre'];
        $this->Model->puesto       = $_POST['puesto'];
        $this->Model->departamento = $_POST['departamento'];
        $this->Model->valoracion   = $_POST['valoracion'];
        
        $this->Model->idPlanOpe = $_POST['plano'];
        $this->Model->idperiodo = $_POST['periodo'];
        
        
        $id = $this->Model->insertarColaborador();
        
        $num = $this->Model->getNumColaborador();
        
        
        
        echo '
<table width="100%" id="col-' . $id . '">
        <tbody>
        <tr>
        <td colspan="3" style="background:#EEEEEE; border-bottom:1px solid #D2D1CB; padding:4px;"><h2><strong>' . $num . '. Colaborador:</strong></h2></td>
        </tr>
        
        <tr>
        
        <td width="40%"><h2><strong>Nombre:</strong></h2></td>
        <td width="30%"><h2><strong>Puesto:</strong></h2>  </td>
        <td width="30%"><h2><strong>Área/departamento:</strong></h2></td>
        
        </tr>
         
        <tr>
        
        <td>  
        <h3>' . $_POST["nombre"] . '</h3>  
        </td>
        <td>
        <h3>' . $_POST["puesto"] . '</h3>        
        </td>
        <td>
        <h3>' . $_POST["departamento"] . '</h3>
        </td>                          
        
        </tr>
        
        <tr>
        <td colspan="3">
        <h2><strong>Valoración:</strong></h2>
        </td>
        </tr>
        
        <tr>
        <td colspan="3">
            
        <h3>' . $_POST["valoracion"] . '</h3>
        </td>
        </tr>
                    
        <tr>    
        <td colspan="3" style="border-bottom:1px solid #999;">
        <div class="right" style="margin-right:30px;">        
           
          <button onclick="EliminarColaborador(this.id);" id="' . $_POST['periodo'] . '-' . $id . '" class="btn btn-small"><i class="icon-remove"></i> Eliminar Colaborador</button>
         
         
        </div>            
        </td>
        </tr>
        </tbody></table>';
        
    }
    
    
    function eliminarColaborador()
    {
        
        $this->Model->eliminarColaborador($_POST['idcolaborador']);
        
    }
    
    
    
    function insertarComentario()
    {
        
        
        $id      = $this->Model->insertarComentario($_POST['comentario'], $_POST['idobjetivo']);
        $usuario = $_SESSION['session']['titulo'] . ' ' . $_SESSION['session']['nombre'] . ' ' . $_SESSION['session']['apellidos'];
        $imagen  = 'media/usuarios/thum_40x40_' . $_SESSION['session']['imagen'];
        $fecha   = date("Y-m-d H:i:s");
        
        echo '<div class="stbody" id="stbody' . $id . '">
    <div class="sttimg"><img src="' . $imagen . '" class="big_face"/></div> 
    <div class="sttext"><a class="stdelete" href="#" id="' . $id . '" title="Borrar comentario"><i class="icon-remove"></i></a>
    <strong><a href="#">' . htmlentities($usuario, ENT_QUOTES, "ISO-8859-1") . '</a></strong>
    ' . $_POST['comentario'] . '
       <div class="sttime">' . $fecha . '</div> 
</div>';
        
    }
    
    
    function eliminarComentario()
    {
        
        $this->Model->eliminarComentario($_POST['idcomentario']);
        
    }
    
    
    
    function insertarComentarioPeriodo()
    {
        
        $id      = $this->Model->insertarComentarioPeriodo($_POST['comentario'], $_POST['idobjetivo'], $_POST['idperiodo']);
        $usuario = $_SESSION['session']['titulo'] . ' ' . $_SESSION['session']['nombre'] . ' ' . $_SESSION['session']['apellidos'];
        $imagen  = 'media/usuarios/thum_40x40_' . $_SESSION['session']['imagen'];
        $fecha   = date("Y-m-d H:i:s");
        
        echo '<div class="stbody" id="stbody' . $id . '">
    <div class="sttimg"><img src="' . $imagen . '" class="big_face"/></div> 
    <div class="sttext"><a class="stdelete" href="#" id="' . $id . '" title="Borrar comentario"><i class="icon-remove"></i></a>
    <strong><a href="#">' . htmlentities($usuario, ENT_QUOTES, "ISO-8859-1") . '</a></strong>
    ' . $_POST['comentario'] . '
       <div class="sttime">' . $fecha . '</div> 
</div>';
        
    }
    
    
    
    function insertarComentarioResumenPeriodo()
    {
        
        
        $id      = $this->Model->insertarComentarioResumenPeriodo($_POST['comentario'], $_POST['idpoperativo'], $_POST['idperiodo'], $_POST['tipo']);
        $usuario = $_SESSION['session']['titulo'] . ' ' . $_SESSION['session']['nombre'] . ' ' . $_SESSION['session']['apellidos'];
        $imagen  = 'media/usuarios/thum_40x40_' . $_SESSION['session']['imagen'];
        $fecha   = date("Y-m-d H:i:s");
        
        echo '<div class="stbody" id="stbodyr' . $id . '">
    <div class="sttimg"><img src="' . $imagen . '" class="big_face"/></div> 
    <div class="sttext"><a class="stdeleter" href="#" id="r' . $id . '" title="Borrar comentario"><i class="icon-remove"></i></a>
    <strong><a href="#">' . htmlentities($usuario, ENT_QUOTES, "ISO-8859-1") . '</a></strong>
    ' . $_POST['comentario'] . '
       <div class="sttime">' . $fecha . '</div> 
</div>';
        
    }
    
    
    function getComentariosResumenEjecutivo()
    {
        
        
        $panelcontent = "";
        
        //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P120" : "P119";
        $permiso = ($this->permisoG == "R") ? "P120" : "P119";

        //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
        if ($this->isAdm || in_array($permiso,$this->permisosArray)){
            
            $panelcontent .= '<!--====================COMENTARIOS=====================-->
          
          <div id="twitter-container">
            
                <span class="counter" id="counter-resumen"></span>
                <textarea name="inputField" id="inputField-resumen"   tabindex="1" rows="2" cols="40"></textarea>
               
                <input class="submitButton inact" name="submit" type="button" onClick="guardarComentarioResumen();" value="comentar" disabled="disabled" id="update_button-resumen" />
                <div class="clear"></div>
            
          </div>';
            
        }
        
        $panelcontent .= '  <div id="flashmessage">    
    <div id="flash"></div>
              </div>
             <div class="comentarios" id="comentarios-resumen">';
        
        
        
        $this->Model->getComentariosResumen($_GET['IDPlan']);
        $numcomentarios = sizeof($this->Model->comentarios);
        
        
        if ($numcomentarios != 0) {
            
            foreach ($this->Model->comentarios as $rowcomentariosr) { {
                    
                    $comentario_id = $rowcomentariosr['PK1'];
                    $usuario_id    = $rowcomentariosr['PK_USUARIO'];
                    $fecha         = $rowcomentariosr['FECHA_R'];
                    $comentario    = stripslashes(htmlentities($rowcomentariosr['COMENTARIO'], ENT_QUOTES, "ISO-8859-1"));
                    
                    
                    $rowusuario = $this->Model->getImagen($usuario_id);
                    $imagen     = "media/usuarios/" . $rowusuario['IMAGEN'];
                    
                    $usuario = $rowusuario['NOMBRE'] . "" . $rowusuario['APELLIDOS'];
                    
                    
                    
                    $panelcontent .= '<div class="stbody" id="stbodyr' . $comentario_id . '">
            <div class="sttimg"><img src="' . $imagen . '" class="big_face"/></div> 
            <div class="sttext">';
                    
                    //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P122" : "P121";
                    $permiso = ($this->permisoG == "R") ? "P122" : "P121";

                    //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                    if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                        
                        $panelcontent .= '<a class="stdeleter" href="#" id="r' . $comentario_id . '" title="Borrar comentario"><i class="icon-remove"></i></a>';
                    }
                    
                    $panelcontent .= '<strong><a href="#" class="comentuser">' . htmlentities($usuario, ENT_QUOTES, "ISO-8859-1") . '</a></strong>
                        ' . $comentario . '
                           <div class="sttime">' . date('d/m/Y H:i:s', strtotime($fecha->format('Y-m-d'))) . '</div> 
                    </div>  
                </div>';
                    
                }
            }
            
        }
        
        $panelcontent .= ' </div>
        
                     <!--====================END COMENTARIOS=====================-->';
        
        return $panelcontent;
    }
    
    
    
    
    function getPeriodosResumen()
    {
        
        $this->Model->getPeriodos($_GET['IDPlan']);
        $numperiodos = sizeof($this->Model->periodos);
        
        $panelcontent = '';
        
        $contperiodo = 1;
        $cont        = 0;
        if ($numperiodos != 0) {
            foreach ($this->Model->periodos as $rowperiodos) {
                
                
                if ($rowperiodos['ORDEN'] == 1 || $rowperiodos['ENVIADO'] == 1 || $rowperiodos['ENVIADO'] == 2 || $rowperiodos['ENVIADO'] == 3) {
                    
                    $panelcontent .= '<table class="table" width="100%">
                        <tr>
                            <th><a id="TOG-P' . $contperiodo . '" class="btn btn-minimize btn-round" onclick="ToogleR(this.id);" href="javascript:void(0)"><i class="icon-chevron-down"></i></a> ' . $rowperiodos['PERIODO'] . '</th>    
                        </tr>
                        </table>
                        
                        
                        <div id="BOX-P' . $contperiodo . '" class="resumencontent" style="display:none;">
                        <ul class="subMenu" style="margin-top: 15px;" id="myTabR' . $contperiodo . '">';
                    //<li id="tbularv'.$contperiodo.'" class="active"><a href="javascript:void(0);" onClick="cambiarTab(\''.$contperiodo.'\',\'V\');"> Valoración de Colaboradores</a></li>
                    $panelcontent .= ' <li id="tbulare' . $contperiodo . '" class="active"><a href="javascript:void(0);" onClick="cambiarTab(\'' . $contperiodo . '\',\'E\');"> Resumen Ejecutivo del Periodo</a></li>
                        </ul>
                        
                        <div class="tab-pane" id="valoracion' . $contperiodo . '" style="display:none;">
                         <div class="box-content">
                         
                        
                         <!--====================COLABORADORES=====================-->
                        
                        <div class="well">';
                    
                    //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P101" : "P58";
                    $permiso = ($this->permisoG == "R") ? "P101" : "P58";

                    
                    //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                    if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                        
                        
                        //if ($rowperiodos['ENVIADO'] == 2 || ($rowperiodos['ENVIADO'] == 0 && $rowperiodos['ORDEN'] == 1) || $this->passport->isAdmin()) {
                        if ($rowperiodos['ENVIADO'] == 2 || ($rowperiodos['ENVIADO'] == 0 && $rowperiodos['ORDEN'] == 1) || $this->isAdm){

                            $panelcontent .= '
        <table width="100%">
        <tbody><tr>
        
        <td width="40%"><h2><strong>Nombre:</strong></h2></td>
        <td width="30%"><h2><strong>Puesto:</strong></h2>  </td>
        <td width="30%"><h2><strong>Área/departamento:</strong></h2></td>
        
        </tr>
         
        <tr>
        
        <td>  
        <div class="input-prepend">
    
        <input type="text" style="width:97%;" class="medio" id="N-' . $rowperiodos['PK1'] . '">
        </div> 
        </td>
        <td><span class="input-prepend">
          <input type="text" style="width:97%;" class="medio" id="P-' . $rowperiodos['PK1'] . '" />
        </span></td>
        <td><span class="input-prepend">
          <input type="text" style="width:97%;" class="medio" id="D-' . $rowperiodos['PK1'] . '" />
        </span></td>                          
        
        </tr>
        
        <tr>
        <td colspan="3">
        <h2><strong>Valoración:</strong></h2>
        </td>
        </tr>
        
        <tr>
        <td colspan="3">
            
        <textarea name="valoracion" style="width: 100%;" id="V-' . $rowperiodos['PK1'] . '"></textarea>
        </td>
        </tr>
                    
        <tr>    
        <td colspan="3">
        <div style="margin-right:30px;" class="right">        
           
        
         <button onclick="AgregarColaborador(this.id);" id="A-' . $rowperiodos['PK1'] . '" class="btn btn-small"><i class="icon-plus"></i>Agregar Colaborador</button>
         
         
        <div id="counter-' . $rowperiodos['PK1'] . '"></div>            
        </div>            
        </td>
        </tr>
        </tbody></table>';
                            
                        }
                    }
                    
                    
                    $panelcontent .= '<div id="colaboradores-' . $rowperiodos['PK1'] . '">';
                    
                    
                    $this->Model->getColaboradores($_GET['IDPlan'], $rowperiodos['PK1']);
                    
                    $numcolaboradores = sizeof($this->Model->colaboradores);
                    
                    $contcol = 1;
                    if ($numcolaboradores != 0) {
                        foreach ($this->Model->colaboradores as $rowcolaborador) {
                            
                            
                            $panelcontent .= '
                        
    <table width="100%" id="col-' . $rowcolaborador['PK1'] . '">
        <tbody>
        <tr>
        <td colspan="3" style="background:#EEEEEE; border-bottom:1px solid #D2D1CB; padding:4px;"><h2><strong>' . $contcol . '. Colaborador:</strong></h2></td>
        </tr>
        
        <tr>
        
        <td width="40%"><h2><strong>Nombre:</strong></h2></td>
        <td width="30%"><h2><strong>Puesto:</strong></h2>  </td>
        <td width="30%"><h2><strong>Área/departamento:</strong></h2></td>
        
        </tr>
         
        <tr>
        
        <td>  
        <h3>' . htmlentities($rowcolaborador['NOMBRE'], ENT_QUOTES, "ISO-8859-1") . '</h3>  
        </td>
        <td>
        <h3>' . htmlentities($rowcolaborador['PUESTO'], ENT_QUOTES, "ISO-8859-1") . '</h3>        
        </td>
        <td>
        <h3>' . htmlentities($rowcolaborador['DEPARTAMENTO'], ENT_QUOTES, "ISO-8859-1") . '</h3>
        </td>                          
        
        </tr>
        
        <tr>
        <td colspan="3">
        <h2><strong>Valoración:</strong></h2>
        </td>
        </tr>
        
        <tr>
        <td colspan="3">
            
        <h3>' . htmlentities($rowcolaborador['VALORACION'], ENT_QUOTES, "ISO-8859-1") . '</h3>
        </td>
        </tr>
                    
        <tr>    
        <td colspan="3" style="border-bottom:1px solid #999;">
        <div class="right" style="margin-right:30px;">';
                            
                            //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P100" : "P60";
                            $permiso = ($this->permisoG == "R") ? "P100" : "P60";

                            //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                            if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                                $panelcontent .= ' <button onclick="EliminarColaborador(this.id);" id="' . $rowperiodos['PK1'] . '-' . $rowcolaborador['PK1'] . '" class="btn btn-small"><i class="icon-remove"></i> Eliminar Colaborador</button>';
                            }
                            
                            
                            $panelcontent .= '    </div>            
        </td>
        </tr>
        </tbody></table>
        ';
                            
                            $contcol++;
                        }
                        
                    } else {
                        
                        $panelcontent .= '<h1>No existen colaboradores registrados..</h1>';
                        
                    }
                    
                    $panelcontent .= '</div></div>
                        
                        
                         <!--====================END COLABORADORES=====================-->
                        
                        
                        
                         <!--====================COMENTARIOS=====================-->
                        ';
                    
                    //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P102" : "P72";
                    $permiso = ($this->permisoG == "R") ? "P102" : "P72";

                    //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                    if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                        $panelcontent .= '<div class="box-icon">
<a href="javascript:void(0)" onclick="ToogleCol(this.id);" class="btn btn-minimize btn-round" id="TOG-C-' . $rowperiodos['PK1'] . '"><i class="icon-chevron-down"></i>&nbsp;Comentarios&nbsp;<i class="icon-comment"></i></a><span class="notification">' . $this->Model->getNumeroComentariosColaboradores($_GET['IDPlan'], $rowperiodos['PK1'], "C") . '</span>                        
</div>';
                    }
                    
                    
                    
                    $panelcontent .= '<div id="COMR-C-' . $rowperiodos['PK1'] . '" style="display:none;">  
<div id="twitter-container">';
                    
                    //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P103" : "P73";
                    $permiso = ($this->permisoG == "R") ? "P103" : "P73";

                    //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                    if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                        $panelcontent .= '  <span class="counter" id="counterC-' . $rowperiodos['PK1'] . '"></span>
                <textarea name="inputField" id="inputFieldC-' . $rowperiodos['PK1'] . '"   tabindex="1" rows="2" cols="40"></textarea>
                        
        <input class="submitButton" name="submit" type="button" onClick="guardarComentarioResumenPeriodo(\'' . $_GET['IDPlan'] . '\',\'' . $rowperiodos['PK1'] . '\',\'C\');" value="comentar"  id="update_buttonR-' . $contperiodo . '" />';
                    }
                    
                    
                    $panelcontent .= '<div class="clear"></div>
          </div>
          
          <div id="flashmessage">    
    <div id="flash"></div>
              </div>
             <div class="comentarios" id="comentariosC-' . $rowperiodos['PK1'] . '">';
                    
                    
                    $this->Model->getComentariosResumenSeguimiento($_GET['IDPlan'], $rowperiodos['PK1'], "C");
                    $numcomentarios = sizeof($this->Model->comentarios);
                    
                    if ($numcomentarios != 0) {
                        
                        foreach ($this->Model->comentarios as $rowcomentarios) { {
                                
                                $comentario_id = $rowcomentarios['PK1'];
                                $usuario_id    = $rowcomentarios['PK_USUARIO'];
                                $fecha         = $rowcomentarios['FECHA_R'];
                                $comentario    = stripslashes(htmlentities($rowcomentarios['COMENTARIO'], ENT_QUOTES, "ISO-8859-1"));
                                
                                $rowusuario = $this->Model->getImagen($usuario_id);
                                $imagen     = "media/usuarios/" . $rowusuario['IMAGEN'];
                                
                                $usuario = $rowusuario['NOMBRE'] . "" . $rowusuario['APELLIDOS'];
                                
                                $panelcontent .= '<div class="stbody" id="rstbodyrs' . $comentario_id . '">
            <div class="sttimg"><img src="' . $imagen . '" class="big_face"/></div> 
            <div class="sttext">';
                                
                                
                                //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P104" : "P74";
                                $permiso = ($this->permisoG == "R") ? "P104" : "P74";

                                //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                                if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                                    $panelcontent .= '<a class="stdeleters" href="#" id="' . $comentario_id . '" title="Borrar comentario"><i class="icon-remove"></i></a>';
                                }
                                $panelcontent .= '<strong><a href="#" class="comentuser">' . htmlentities($usuario, ENT_QUOTES, "ISO-8859-1") . '</a></strong>
                        ' . $comentario . '
                           <div class="sttime">' . date('d/m/Y H:i:s', strtotime($fecha->format('Y-m-d'))) . '</div> 
                    </div>  
                </div>';
                                
                            }
                        }
                        
                    }
                    
                    $panelcontent .= ' </div></div>
        
           <!--====================END COMENTARIOS=====================-->
                         
                  
                         </div>
                        </div>                        
                        
                        
                        <div class="tab-pane" style="display:block;" id="estadogeneral' . $contperiodo . '">
                         <div class="box-content">
                         
                <div>
                <br/>';
                    
                    
                    
                    //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P114" : "P113";
                    $permiso = ($this->permisoG == "R") ? "P114" : "P113";

                    //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                    if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                        
                        $panelcontent .= '<form enctype="multipart/form-data" class="adjuntarfile" id="FORM-' . $rowperiodos['PK1'] . '" name="frmadjuntar" method="post" id="frmadjuntar" action="?execute=planesoperativo/seguimiento&Menu=F3&SubMenu=SF31&method=UploadFileResumen" target="iframe-post-form">';
                        $panelcontent .= '<input type="hidden" name="periodo" value="' . $rowperiodos['PK1'] . '"/>';
                        $panelcontent .= '<input type="hidden" name="plan" value="' . $_GET['IDPlan'] . '"/>';
                        $panelcontent .= '<div align="center" class="box-head"> <h2>ARCHIVO ADJUNTO</h2></div>';
                        
                        $this->adjuntor = $this->Model->getResumenArchivoPeriodo($_GET['IDPlan'], $rowperiodos['PK1']);
                        
                        if ($this->adjuntor == "" || $this->adjuntor == "NULL") {
                            $panelcontent .= '<div class="empty_results" ><span id="R' . $rowperiodos['PK1'] . '">NO EXISTE ARCHIVO ADJUNTO</span>  <span id="I' . $rowperiodos['PK1'] . '"><input type="file" class="adjunto" id="' . $rowperiodos['PK1'] . '" name="fileresumen"> </span></div></br>';
                        } else {
                            $panelcontent .= '<div class="empty_results">
                            <span id="R' . $rowperiodos['PK1'] . '">
                            <a href="'.STORAGE_ACCOUNT_CONTAINER."/".CONTAINER_NAME."/media/planesoperativos/". $_GET['IDPlan'] . '/' . $rowperiodos['PK1'] . '/' . $this->adjuntor .KEY_ACCESS_BLOBS.'" target="_blank">' . $this->adjuntor . '</a>
                            </span>  <span id="I' . $rowperiodos['PK1'] . '" style="display:none;"><input type="file" class="adjunto" id="' . $rowperiodos['PK1'] . '" name="fileresumen"> 
                            </span> &nbsp; <a href="javascript:void(0)" id="BE-' . $rowperiodos['PK1'] . '" onClick="EliminarAdjuntoR(\''.$rowperiodos['PK1']. '\',\''.$this->adjuntor.'\')" class="btn btn-small btn-warning">Eliminar</a></div></br>';
                        }//OK4
                        $panelcontent .= '</form>';
                        
                        //if ($rowperiodos['ENVIADO'] == 2 || ($rowperiodos['ENVIADO'] == 0 && $rowperiodos['ORDEN'] == 1) || $this->passport->isAdmin()) {
                        if ($rowperiodos['ENVIADO'] == 2 || ($rowperiodos['ENVIADO'] == 0 && $rowperiodos['ORDEN'] == 1) || $this->isAdm) {
                            $panelcontent .= '<button onclick="GuardarResumenPeriodo(\'' . $rowperiodos['PK1'] . '\');" id="btnresumen-' . $rowperiodos['PK1'] . '" class="btn btn-warning"><i class="icon icon-white icon-check"></i>&nbsp;Guardar Resumen Ejecutivo </button>';
                        }
                        
                    }
                    
                    
                    $panelcontent .= '<div style="float:right" id="loadr-' . $rowperiodos['PK1'] . '"></div>
                </div>
                <br/>     
                <textarea id="' . $rowperiodos['PK1'] . 'estado' . $contperiodo . '"';
                    
                    //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P114" : "P113";
                    $permiso = ($this->permisoG == "R") ? "P114" : "P113";

                    //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                    if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                        //if (($rowperiodos['ENVIADO'] == 3) && !$this->passport->isAdmin()) {
                        if (($rowperiodos['ENVIADO'] == 3) && !$this->isAdm) {
                            $panelcontent .= 'disabled="disabled" ';
                        }
                    } else {
                        $panelcontent .= 'disabled="disabled" ';
                        
                    }
                    
                    $panelcontent .= ' name="txtdescripcion"  >';
                    
                    
                    $panelcontent .= $this->Model->getResumenPeriodo($_GET['IDPlan'], $rowperiodos['PK1']);
                    
                    $panelcontent .= '  </textarea>
                            <script type="text/javascript">
                            var ' . $rowperiodos['PK1'] . ' =   CKEDITOR.replace( \'' . $rowperiodos['PK1'] . 'estado' . $contperiodo . '\',
                    {
                        skin : \'moono\'
                    });
                             </script>

                 <!--====================COMENTARIOS=====================-->
                 ';
                    
                    //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P105" : "P75";
                    $permiso = ($this->permisoG == "R") ? "P105" : "P75";

                    //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                    if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                        $panelcontent .= '<br/><div class="box-icon">
<a href="javascript:void(0)" onclick="ToogleAnal(this.id);" class="btn btn-minimize btn-round" id="TOG-U-' . $rowperiodos['PK1'] . '"><i class="icon-chevron-down"></i>&nbsp;Comentarios&nbsp;<i class="icon-comment"></i></a><span class="notification">' . $this->Model->getNumeroComentariosColaboradores($_GET['IDPlan'], $rowperiodos['PK1'], "U") . '</span>                        
</div>';
                    }
                    
                    
                    $panelcontent .= '<div id="ANAR-U-' . $rowperiodos['PK1'] . '" style="display:none;">  
                       <div id="twitter-container">';
                    
                    
                    //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P106" : "P76";
                    $permiso = ($this->permisoG == "R") ? "P106" : "P76";

                    //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                    if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                        $panelcontent .= '  <span class="counter" id="counterU-' . $rowperiodos['PK1'] . '"></span>
                <textarea name="inputField" id="inputFieldU-' . $rowperiodos['PK1'] . '"   tabindex="1" rows="2" cols="40"></textarea>
                <input class="submitButton" name="submit" type="button" onClick="guardarComentarioResumenPeriodo(\'' . $_GET['IDPlan'] . '\',\'' . $rowperiodos['PK1'] . '\',\'U\');" value="comentar"  id="update_buttonR-' . $contperiodo . '" />';
                        
                    }
                    
                    $panelcontent .= '<div class="clear"></div>
            
          </div>
          
          
          
        
          <div id="flashmessage">    
    <div id="flash"></div>
              </div>
             <div class="comentarios" id="comentariosU-' . $rowperiodos['PK1'] . '">';
                    
                    
                    //  echo $rowobj['PK1']."<";
                    $this->Model->getComentariosResumenSeguimiento($_GET['IDPlan'], $rowperiodos['PK1'], "U");
                    $numcomentarios = sizeof($this->Model->comentarios);
                    
                    if ($numcomentarios != 0) {
                        
                        foreach ($this->Model->comentarios as $rowcomentarios) { {
                                
                                $comentario_id = $rowcomentarios['PK1'];
                                $usuario_id    = $rowcomentarios['PK_USUARIO'];
                                $fecha         = $rowcomentarios['FECHA_R'];
                                $comentario    = stripslashes(htmlentities($rowcomentarios['COMENTARIO'], ENT_QUOTES, "ISO-8859-1"));
                                
                                $rowusuario = $this->Model->getImagen($usuario_id);
                                $imagen     = "media/usuarios/" . $rowusuario['IMAGEN'];
                                
                                $usuario = $rowusuario['NOMBRE'] . "" . $rowusuario['APELLIDOS'];
                                
                                $panelcontent .= '<div class="stbody" id="rstbodyrs' . $comentario_id . '">
            <div class="sttimg"><img src="' . $imagen . '" class="big_face"/></div> 
            <div class="sttext">';
                                
                                
                                //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P107" : "P77";
                                $permiso = ($this->permisoG== "R") ? "P107" : "P77";

                                //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                                if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                                    $panelcontent .= '<a class="stdeleters" href="#" id="' . $comentario_id . '" title="Borrar comentario"><i class="icon-remove"></i></a>';
                                }
                                $panelcontent .= '<strong><a href="#" class="comentuser">' . htmlentities($usuario, ENT_QUOTES, "ISO-8859-1") . '</a></strong>
                        ' . $comentario . '
                           <div class="sttime">' . date('d/m/Y H:i:s', strtotime($fecha->format('Y-m-d'))) . '</div> 
                    </div>  
                </div>';
                                
                            }
                        }
                        
                    }
                    
                    $panelcontent .= ' </div>
        
           <!--====================END COMENTARIOS=====================-->     
                     
                
                         </div>
                        </div>
                        
                        </div></div>';
                    
                    $contperiodo++;
                    
                }
                
            }
            
            
            return $panelcontent;
        }
        
        
    }
    
    
    
    function getEvidencias()
    {
        
        $panelcontent = ' <!-- Content RIGHT -->
            <div id="content">
               <!--End Alerta -->
                <!-- Box -->
                <div class="box">
                    <!-- Box Head -->
                    <div class="box-head" >';
        /*
        <div class="left">
        <label>
        <small>Línea Estratégica:  </small>
        <select name="lineasfilter" id="lineasfilter" onchange="getObjetivosfilter(this);" style="width:80%; z-index:1000;">
        <option value="ALL">Todas las Líneas ...................................................................................................................</option>';
        
        
        $panelcontent .= $this->getLineasPlan();                
        
        $panelcontent .='</select>
        </label>
        
        
        <label>
        &nbsp;&nbsp;<small>Resultado:</small>
        <select name="objetivosfilter" id="objetivosfilter" disabled="disabled" onchange="filterObjetivo(this);"  style="width:80%; z-index:1000;">
        
        
        </select>
        </label>
        
        </div>
        <br/>
        */
        
        
        $panelcontent .= '    <div class="right" >';
        
        //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P108" : "P61";
        $permiso = ($this->permisoG == "R") ? "P108" : "P61";

        
        //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
        if ($this->isAdm || in_array($permiso,$this->permisosArray)){
            
            
            
            $panelcontent .= '<button type="button" onClick="uploadEvidencias();" class="btn btn-small btn-warning"><i class="icon-upload icon-white"></i>&nbsp;Agregar Evidencia</button>&nbsp;
                        
                        
                        
        <a class="btn btn-small btn-warning" type="button" href="?execute=planesoperativo/exportexcelEvidencias&IDPlan=' . $_GET['IDPlan'] . '&IDPlanE=' . $_GET['IDPlanE'] . '"><i class="icon-upload icon-white"></i> Exportar</a>
                                            ';
            
        }
        
        $panelcontent .= '</div>
                        
                     
                        <div class="right" style="margin-right:10px;">
                    
                        <input type="text" name="searchbar" id="searchbar"    />
                            <button class="btn btn-small" id="search_go-button-pe"><i class="icon-search"></i> Buscar</button>
                        
                        </div>
                        
                         
                        
                        
                        
                        
                        </div>
                    <!-- End Box Head -->    
                    
                    
                    <!-- Pagging -->
					
					
					
						<div class="pagging" id="pagginghead">
							<table style="width:100%;">
								<tbody><tr>
									<td style="width:88%;">
										<div class="left">
											<div id="sort-panel-lines">
												<div id="toolbar" style="top:0px; margin-bottom: 0px;">
													<a class="" href="#" onClick="buscar()">L&iacute;neas</a>
												</div>
											</div>
										</div>
									</td>
									<td style="width:2%;">
										<div class="bar_seperator"></div>
									</td>
									<td style="width:10%;">
										<div class="right">
											<div id="results_text">0 resultados</div>
										</div>
									</td>
								</tr>
							</tbody></table>
						</div>
					
					
					
                        
						
						<!--
						<div class="pagging" id="pagginghead">         
							<div class="left">
								<div id="sort-panel-lines"> 
									<div id="toolbar"><a class="" href="#" onClick="buscar()">L&iacute;neas</a></div>                        
								</div>
							</div>
                        </div>
						-->
						
						
						
						<br></br>
						<input type="hidden" value="ROGELIO"/>
                        <!-- End Pagging -->
                        
                    
                    
                    <!-- Table -->
                    <div id="results-panel" style="position: relative;">
                    </div>
                    <!-- Table -->
                        
                          <!-- Pagging -->
                        
                        <div class="pagging" id="barfilterfooter">
                       
                        
                        </div>
                        <!-- End Pagging -->
                        
                    
                    
                </div>
                <!-- End Box -->
               
                

            </div>
            <!-- End Conten RIGHTt -->
            
            
            <!--
            <div id="sidebar">
      
                <div class="box">
                    
                    
                    <div class="box-head">
                        <h2><i class="icon-search"></i>&nbsp;Acotar Búsqueda</h2>
                        
                    </div>
                
                    
                    
                  
                    <div>
                        
                        
                <div id="category-filter">
                    <ul>
                    
    
    <li>
    <li>
    <input type="checkbox" class="any" id="all" value="all" onclick="filtrarTodo(this.id);" name="all" checked="checked">
    Todo
    </li>                
     <li>
     <input id="AUD" class="any" type="checkbox" onclick="filtrar(this.id);" value="AUD" name="tipos[]">
Audio
     </li>
     <li>
     <input id="VID" class="any" type="checkbox" onclick="filtrar(this.id);" value="VID" name="tipos[]">
Videos
     </li>
     
     <li>
     <input id="IMG" class="any" type="checkbox" onclick="filtrar(this.id);" value="IMG" name="tipos[]">
Imágenes
     </li>
     
    <li>
    <input type="checkbox" class="any" id="DOCS" value="DOCS" onclick="archivos(this.id);" name="DOCS" >
    Documentos / Archivos
    
    <ul>
    <li><input type="checkbox" class="any" id="PPT" value="PPT" onclick="filtrar(this.id);" name="tipos[]">
    Presentaciones</li>
    <li><input type="checkbox" class="any" id="DOC" value="DOC" onclick="filtrar(this.id);" name="tipos[]">
    Word</li>
    <li><input type="checkbox" class="any" id="XLS" value="XLS" onclick="filtrar(this.id);" name="tipos[]" >
    Excel</li>
    <li><input type="checkbox" class="any" id="PDF" value="PDF" onclick="filtrar(this.id);" name="tipos[]" >
    Pdf</li>
    <li><input type="checkbox" class="any" id="ZIP" value="ZIP" onclick="filtrar(this.id);" name="tipos[]" >
    Zip</li>
    </ul>
    </li>

</ul>
<br>
      

        </div>    -->            
                        
                    </div>
                    <!-- End Box Content-->
                    
                </div>
                <!-- End Box -->
        </div>';
        
        
        return $panelcontent;
        
    }
    
    
    function eliminarComentarioResumenPeriodos()
    {
        
        $this->Model->eliminarComentarioResumenPeriodos($_POST['idcomentario']);
        
    }
    
    
    
    function EnviarInforme()
    {
        
        $this->Model->EnviarInforme($_POST['idplan'], $_POST['planE']);
        
    }
    
    
    function RevisarInforme()
    {
        
        $this->Model->RevisarInforme($_POST['idplan'], $_POST['planE']);
        
    }
    
    function GuardarAvanceObjetivo()
    {
        
        $this->Model->idobjetivo = $_POST['idobjetivo'];
        $this->Model->idperiodo  = $_POST['idperiodo'];
        $this->Model->avance     = $_POST['avance'];
        $this->Model->GuardarAvanceObjetivo();
        
    }
    
    function GuardarAvanceMedio()
    {
        
        $this->Model->idmedio   = $_POST['idmedio'];
        $this->Model->idperiodo = $_POST['idperiodo'];
        $this->Model->avance    = $_POST['avance'];
        $this->Model->GuardarAvanceMedio();
        
    }
    
    
    
    function GuardarResumenPeriodo()
    {
        
        $this->Model->resumenejecutivo = $_POST['resumen'];
        $this->Model->idPlanOpe        = $_POST['plan'];
        $this->Model->idperiodo        = $_POST['periodo'];
        
        $this->Model->GuardarResumenPeriodo();
        
    }
    
    
    function ObtenerComentariosSeguimiento()
    {
        
        $idotactico = $_POST['idobjetivo'];
        $idperiodo  = $_POST['idperiodo'];
        
        $comentar = TRUE; //$this->Model->esperiodoActivo($idperiodo,$_POST['IDPlan']);
        
        $panelcontent = "";
        
        //$permiso = ($this->Model->obtenerEstadoPlan($_POST['IDPlan']) == "R") ? "P124" : "P123";
        $permiso = ($this->permisoG == "R") ? "P124" : "P123";
echo $permiso;
       
        
        //if ($this->passport->getPrivilegio($_POST['IDPlan'], $permiso)) {
        if ($this->isAdm || in_array('P124',$this->permisosArray)){            
            
            if ($comentar) {
                
                $panelcontent = '<div id="twitter-container">
        
                <span class="counter" id="counterpo"></span>
                <textarea name="inputField" id="inputFieldpo" tabindex="1" rows="2" cols="40"></textarea>
               
                <input class="submitButton" name="submit" type="button" onClick="guardarComentarioPeriodo();" value="comentar"  id="update_buttonpo" />
                <div class="clear"></div>
            
          </div>';
                
                
            }
        }
        
        
        $panelcontent .= ' <div id="flashmessage">    
    <div id="flash"></div>
              </div>
             <div class="comentarios" id="comentariosperiodoso">';
        
        
        $this->Model->getComentariosPeriodo($idotactico, $idperiodo);
        
        $numcomentarios = sizeof($this->Model->comentarios);
        
        if ($numcomentarios != 0) {
            
            foreach ($this->Model->comentarios as $rowcomentarios) {
                $comentario_id = $rowcomentarios['PK1'];
                $usuario_id    = $rowcomentarios['PK_USUARIO'];
                $fecha         = $rowcomentarios['FECHA_R'];
                $comentario    = stripslashes(htmlentities($rowcomentarios['COMENTARIO'], ENT_QUOTES, "ISO-8859-1"));
                
                $rowusuario = $this->Model->getImagen($usuario_id);
                $imagen     = "media/usuarios/" . $rowusuario['IMAGEN'];
                
                $usuario = $rowusuario['NOMBRE'] . " " . $rowusuario['APELLIDOS'];
                
                
                $panelcontent .= '<div class="stbody" id="stbody' . $comentario_id . '">
            <div class="sttimg"><img src="' . $imagen . '" class="big_face"/></div> 
            <div class="sttext">';
                
                
                //$permiso = ($this->Model->obtenerEstadoPlan($_POST['IDPlan']) == "R") ? "P126" : "P125";
                $permiso = ($this->permisoG == "R") ? "P126" : "P125";

                //if ($this->passport->getPrivilegio($_POST['IDPlan'], $permiso)) {
                if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                    if ($comentar) {
                        $panelcontent .= '<a class="stdeleteop" href="#" id="' . $comentario_id . '" title="Borrar comentario"><i class="icon-remove"></i></a>';
                    }
                }
                
                $panelcontent .= '<strong><a href="#" class="comentuser">' . htmlentities($usuario, ENT_QUOTES, "ISO-8859-1") . '</a></strong>
                        ' . $comentario . '
                           <div class="sttime">' . date('d/m/Y H:i:s', strtotime($fecha->format('Y-m-d'))) . '</div> 
                    </div>  
                </div>';
            }
            $panelcontent .= '</div>';
            
        }
        
        echo $panelcontent;
    }
    
    
    
    
    function Buscar_old()
    {
        
        $this->Model->buscarArchivos();
        $recurso = $this->getPaginadoHeader();
        $recurso .= "#%#";
        
        $numrecursos = sizeof($this->Model->archivos);
        $total       = $this->Model->totalnum;
        
        if ($numrecursos != 0) {
            
            $incremento = 0;
            foreach ($this->Model->archivos as $row) {
                
                
                $incremento++;
                /*if($validar)
                {
                $incremento = ((int)$row['ORDEN'] <= 0) ? 1 : 0;
                $validar = FALSE;    
                }*/
                
                
                $orden  = ($this->Model->getOrdenLestrategica($row['PK_LESTRATEGICA']) + 1) . "." . ($this->Model->getOrdenOtactico($row['PK_OTACTICO']) + 1) . "." . $incremento;
                echo "<script>alert('orden: ".$orden."<br />"."');</script>";
                $titulo = $row['EVIDENCIA'];
                
                //$imagen = $row['IMAGEN'];
                
                if (trim($row['TIPO']) == "IMG") {
                    $IMAGEN170X170 = "media/planesoperativos/evidencias/thum_170x170_" . $row['IMAGEN'];
                } else {
                    $IMAGEN170X170 = $row['IMAGEN'];
                }
                
                $imagen  = ($row['IMAGEN'] == "") ? "skins/default/img/desconocido.jpg" : $IMAGEN170X170;
                $fecha   = date('d/m/Y', strtotime($row['FECHA_R']->format('Y-m-d')));
                $formato = $row['TIPO'];
                
                $linkrecurso = "";
                
                //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P112" : "P111";
                $permiso = ($this->permisoG == "R") ? "P112" : "P111";

                //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                    
                    if ($row['IMAGEN'] == "") {
                        //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P108" : "P61";
                        $permiso = ($this->permisoG == "R") ? "P108" : "P61";

                        //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                        if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                            $linkrecurso = "editEvidencias('" . $row['PK1'] . "','" . htmlentities($row['EVIDENCIA'], ENT_QUOTES, "ISO-8859-1") . "','" . htmlentities($row['DESCRIPCION'], ENT_QUOTES, "ISO-8859-1") . "','" . htmlentities($row['AUTOR'], ENT_QUOTES, "ISO-8859-1") . "','" . $row['PK_LESTRATEGICA'] . "','" . $row['PK_OTACTICO'] . "');return false;";
                        } else {
                            $linkrecurso = "void(0);return false;";
                        }
                        
                    } else {
                        $linkrecurso = "WindowOpen('" . $row['PK1'] . "','" . $_GET['IDPlan'] . "');return false;";
                    }
                    
                    
                    
                } else {
                    $linkrecurso = "void(0);return false;";
                }
                //$linkrecurso = "WindowOpen('".$row['PK1']."');return false;";
                
                
                
                //$lindelete = "Javascript: deleteEvidencia('".$row['PK1']."');";
                
                
                
                
                $content = $this->View->Template(TEMPLATE . 'modules/planestrategico/RECURSO.TPL');
                $content = $this->View->replace('/\#TITULO\#/ms', htmlentities($this->cortar_string($titulo, 216), ENT_QUOTES, "ISO-8859-1"), $content);
                $content = $this->View->replace('/\#IMAGEN\#/ms', $imagen, $content);
                $content = $this->View->replace('/\#FORMATO\#/ms', $formato, $content);
                //$content = $this->View->replace('/\#ID\#/ms', $orden, $content);
                $content = $this->View->replace('/\#ID\#/ms', $orden . "ORDEN", $content);
                $content = $this->View->replace('/\#FECHA\#/ms', $fecha, $content);
                $content = $this->View->replace('/\#LINKRECURSO\#/ms', $linkrecurso, $content);
                
                
                //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P109" : "P63";
                $permiso = ($this->permisoG == "R") ? "P109" : "P63";

                if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                    $urledit = '<div class="action-icon price"><a href="#" onclick="editEvidencias(\'' . $row['PK1'] . '\',\'' . htmlentities($row['EVIDENCIA'], ENT_QUOTES, "ISO-8859-1") . '\',\'' . htmlentities($row['DESCRIPCION'], ENT_QUOTES, "ISO-8859-1") . '\',\'' . htmlentities($row['AUTOR'], ENT_QUOTES, "ISO-8859-1") . '\',\'' . $row['PK_LESTRATEGICA'] . '\',\'' . $row['PK_OTACTICO'] . '\');return false;"><img border="0" src="skins/default/img/icn_edit.png" width="16" height="16"></a></div>';
                    $content = $this->View->replace('/\<!--#LINKEDIT#-->/ms', $urledit, $content);
                }
                
                //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P110" : "P62";
                $permiso = ($this->permisoG == "R") ? "P110" : "P62";

                //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                if ($this->isAdm || in_array($permiso,$this->permisosArray)){
				
                    $urlborrar = '<div class="action-icon cart"><a href="javascript:void(0)" onclick="deleteEvidencia(\'' . $row['PK1'] . '\');"><img border="0" src="skins/default/img/icn_trash.png" width="16" height="14"></a></div>';
                    $content   = $this->View->replace('/\<!--#LINKDELETE#-->/ms', $urlborrar, $content);
                }
                
                
                $recurso .= $content;
                
            }
            
            $recurso .= "#%#";
            $recurso .= $this->getpaginadoFooter();
            $recurso .= "#%#";
            $recurso .= $total;
            echo $recurso;
            
        } else {
            
            $recurso = $this->getPaginadoHeader();
            $recurso .= "#%#";
            $recurso .= '<tr> <td colspan="5"><div class="empty_results">NO EXISTEN RESULTADOS</div></td></tr>';
            $recurso .= "#%#";
            $recurso .= $this->getpaginadoFooter();
            $recurso .= "#%#";
            $recurso .= $total;
            echo $recurso;
            
        }
        
        
    }
    
    
    
    
    function Buscar()
    {
        
        $this->Model->getLineasPlane($_GET['IDPlanE']);
        //OK3
        
        
        $recurso     = "";
        $numrecursos = sizeof($this->Model->lineas);
        
        $cont = 1;
        
        if ($numrecursos != 0) {
            
            $incremento = 0;
            foreach ($this->Model->lineas as $row) {
                
                
                $incremento++;
                
                
                //$titulo = '<span><a href="#" onclick="ObtenerResultados(\''.$_GET['IDPlan'].'\',\''.htmlentities($row['LINEA']).'\',\''.$row['PK1'].'\');return false;">'.$cont.'.- '.htmlentities($row['LINEA']).'</a></span>';
                
                
                
                // $urledit = '<div class="action-icon price"><a href="#" onclick="editEvidencias(\''.$row['PK1'].'\',\''.htmlentities($row['EVIDENCIA']).'\',\''.htmlentities($row['DESCRIPCION']).'\',\''.htmlentities($row['AUTOR']).'\',\''.$row['PK_LESTRATEGICA'].'\',\''.$row['PK_OTACTICO'].'\');return false;"><img border="0" src="skins/default/img/icn_edit.png" width="16" height="16"></a></div>'; 
                
                  $sustituye   = array("\r\n", "\n", "\r");
                
                $titulo = '<a href="#" onClick="ObtenerResultados(\'' . $_GET['IDPlan'] . '\',\'' . $row["PK1"] . '\',\'' . trim(htmlentities(str_replace($sustituye," ",$row['LINEA']), ENT_QUOTES, "ISO-8859-1")) . '\')">' . $cont . '.- ' . htmlentities($row['LINEA'], ENT_QUOTES, "ISO-8859-1") . '</a>';
                
                
                
                $cont++;
                
                $imagen = "skins/default/images/carpeta.png";
                
                
                $numresultados = $this->Model->getNumeroResultadosLinea($_GET['IDPlan'], $row["PK1"]);
                
                $numevidencias = $this->Model->getNumeroEvidenciasLinea($_GET['IDPlan'], $row["PK1"]);
                
                
                
                
                
                //    $linkrecurso = "";
                $linkrecurso = 'ObtenerResultados(\'' . $_GET['IDPlan'] . '\',\'' . $row["PK1"] . '\',\'' . trim(htmlentities(str_replace($sustituye," ",$row['LINEA']), ENT_QUOTES, "ISO-8859-1")) . '\')';
                //$linkrecurso = "WindowOpen('".$row['PK1']."');return false;";
                //$lindelete = "Javascript: deleteEvidencia('".$row['PK1']."');";
                
                //https://seruabackup.blob.core.windows.net/docs-planeacion/media/planesoperativos/evidencias/thum_170x170_img5c95237bea545.jpg?sv=2018-03-28&si=docs-planeacion-1697E9B3AB3&sr=c&sig=6mRMpNQ2SOvpwscWt7MljXyNaaPwLPS2cdMN3ARK6mQ%3D
                
                
                
                //echo "<script>alert('linkrecurso: ".$linkrecurso."');</script>";
                $content = $this->View->Template(TEMPLATE . 'modules/planesoperativo/EVIDENCIALINEA.TPL');
                $content = $this->View->replace('/\#TITULO\#/ms', $titulo, $content);
                $content = $this->View->replace('/\#IMAGEN\#/ms', $imagen, $content);
                $content = $this->View->replace('/\#LINKRECURSO\#/ms', $linkrecurso, $content);
                $content = $this->View->replace('/\#NUMRESULTADOS\#/ms', $numresultados, $content);
                $content = $this->View->replace('/\#NUMEVIDENCIAS\#/ms', $numevidencias, $content);
                
                
                
                
                
                $recurso .= $content;
                
            }
            
            
            echo $recurso . "#%#" . $numrecursos;
            
        } else {
            
            $recurso .= '<div class="empty_results">NO EXISTEN RESULTADOS</div>';
            echo $recurso;
            
        }
        
        
    }
    
    
    function BuscarResultados()
    {
        $this->Model->getObjetivosTacticos($_GET['IDPlan'], $_GET['IDLinea']);
        
        $recurso     = "";
        $numrecursos = sizeof($this->Model->objetivos);
        
        //$cont = 1;
        
        if ($numrecursos != 0) {
            
            $incremento = 0;
            
            
            
            foreach ($this->Model->objetivos as $row) {
                
                
                
                
                $incremento++;
                
                $linea     = $this->Model->getLineaPlane($_GET['IDLinea']);
                $contlinea = intval($linea["ORDEN"]);
                $contlinea++;
                
                
                $titulo = $contlinea . '.- ' . htmlentities($linea["LINEA"], ENT_QUOTES, "ISO-8859-1");
                
                
                
                $imagen = "skins/default/images/carpeta.png";
                
				
               
				$sustituye   = array("\r\n", "\n", "\r");
                
                $resultado = '<a href="#" onClick="ObtenerEvidencias(\'' . $_GET['IDPlan'] . '\',\'' . $_GET['IDLinea'] . '\',\'' . $row["PK1"] . '\',\'' . trim(str_replace($sustituye," ",htmlentities($row["OBJETIVO"], ENT_QUOTES, "ISO-8859-1"))) . '\',\'' . trim(str_replace($sustituye," ",htmlentities($linea["LINEA"], ENT_QUOTES, "ISO-8859-1"))) . '\')">' . $contlinea . '.' . $incremento . '.- ' . htmlentities($row["OBJETIVO"], ENT_QUOTES, "ISO-8859-1") . '</a>';
                
                
                //$linkrecurso = 'ObtenerResultados(\''.$_GET['IDPlan'].'\',\''.$row["PK1"].'\',\''.trim(htmlentities($row['LINEA'])).'\')';
                
                
                //$cont++;trim(htmlentities($row["OBJETIVO"]))   substr(htmlentities($_GET['tituloli']), 0, 40)
                //  $numevidencias =  $this->Model->getNumeroEvidenciasLinea($_GET['IDPlan'],$row["PK1"]);
                
                
                $numevidencias = $this->Model->getNumeroEvidenciasResultados($_GET['IDPlan'], $_GET['IDLinea'], $row["PK1"]);
                
                
                
                $objetivoe = $this->Model->getObjetivoEst($row['PK_OESTRATEGICO']);
                $idobjestr = intval($objetivoe['ORDEN']);
                $idobjestr++;
                
                //$linkrecurso = "";
                $linkrecurso = 'ObtenerEvidencias(\'' . $_GET['IDPlan'] . '\',\'' . $_GET['IDLinea'] . '\',\'' . $row["PK1"] . '\',\'' . trim(str_replace($sustituye," ",htmlentities($row['OBJETIVO'], ENT_QUOTES, "ISO-8859-1"))) . '\',\'' . trim(str_replace($sustituye," ",htmlentities($linea["LINEA"], ENT_QUOTES, "ISO-8859-1"))) . '\')';
                //$linkrecurso = "WindowOpen('".$row['PK1']."');return false;";
                //$lindelete = "Javascript: deleteEvidencia('".$row['PK1']."');";


                //echo "<script>alert('titulo: ".$titulo."');</script>";
                //echo "<script>alert('imagen: ".$imagen."');</script>";
                //echo "<script>alert('link: ".$linkrecurso."');</script>";
                
                $content = $this->View->Template(TEMPLATE . 'modules/planesoperativo/EVIDENCIARESULTADO.TPL');
                $content = $this->View->replace('/\#TITULO\#/ms', $titulo, $content);
                $content = $this->View->replace('/\#IMAGEN\#/ms', $imagen, $content);
                $content = $this->View->replace('/\#LINKRECURSO\#/ms', $linkrecurso, $content);
                //  $content = $this->View->replace('/\#OBJETOVOE\#/ms' ,$contlinea.'.'.$idobjestr.':'.htmlentities($objetivoe['OBJETIVO']),$content);
                $content = $this->View->replace('/\#OBJETOVOE\#/ms', htmlentities($objetivoe['OBJETIVO'], ENT_QUOTES, "ISO-8859-1"), $content);
                $content = $this->View->replace('/\#RESULTADO\#/ms', $resultado, $content);
                $content = $this->View->replace('/\#NUMEVIDENCIAS\#/ms', $numevidencias, $content);
                
                
                //$content = $this->View->replace('/\#LINKRECURSO\#/ms' ,$linkrecurso,$content);
                
                
                $recurso .= $content;
                
            }
            
            
            echo $recurso . "#%#" . $numrecursos;
            
        } else {
            
            $recurso .= '<div class="empty_results">NO EXISTEN RESULTADOS</div>';
            echo $recurso;
            
        }
        
        
    }
    
    
    function BuscarEvidencias()
    {
        
        $this->Model->getEvidenciasPlan($_GET['IDResultado'], $_GET['IDPlan']);
        
        $recurso     = "";
        $numrecursos = sizeof($this->Model->evidencias);
        
        //$cont = 1;
        
        if ($numrecursos != 0) {
             $sustituye   = array("\r\n", "\n", "\r");
            $incremento = 0;
            foreach ($this->Model->evidencias as $row) {
                //echo "<script>alert('ROWWW: '".print_r($row).");</script>";
                
                $incremento++;
                
                $linea     = $this->Model->getLineaPlane($_GET['IDLinea']);
                $contlinea = intval($linea["ORDEN"]);
                $contlinea++;
                
                
                $titulo = $contlinea . '.- ' . htmlentities($linea["LINEA"], ENT_QUOTES, "ISO-8859-1");
                
                
                $resultado = $this->Model->getResultado($_GET['IDPlan'], $_GET['IDLinea'], $_GET['IDResultado']);
                $contres   = intval($resultado["ORDEN"]);
                $contres++;
                
                $titleresultado = $contres . '.- ' . htmlentities($resultado['OBJETIVO'], ENT_QUOTES, "ISO-8859-1");
                
                $objetivoe = $this->Model->getObjetivoEst2($resultado['PK_OESTRATEGICO']);              
                
                
                
                
                // $cont++;
                $evidencia = '<a href="#" onClick="Evidencias(\'' . $_GET['IDPlan'] . '\',\'' . $_GET['IDLinea'] . '\',\'' . $row["PK1"] . '\')">' . $contlinea . '.' . $incremento . '.- ' . htmlentities($row["EVIDENCIA"], ENT_QUOTES, "ISO-8859-1") . '</a>';
                
                
                $linkrecurso = "";
                
                
                
                if (trim($row['TIPO']) == "IMG") {
                   $image170X170_ = "media/planesoperativos/evidencias/thum_170x170_" . $row['IMAGEN'];		 				
			       $IMAGEN170X170 = STORAGE_ACCOUNT_CONTAINER."/".CONTAINER_NAME."/".$image170X170_.KEY_ACCESS_BLOBS;
					
                } else {
                    $IMAGEN170X170 = $row['IMAGEN'];
                }
                
                //    $imagen = ($row['IMAGEN']=="") ? "skins/default/img/desconocido.jpg" : $IMAGEN170X170 ;
                
                
                
                $imagen = ($row['IMAGEN'] == "" || is_null($IMAGEN170X170)) ? "skins/default/img/desconocido.jpg" : $IMAGEN170X170;
                
                $fecha   = date('d/m/Y', strtotime($row['FECHA_R']->format('Y-m-d')));
                $formato = $row['TIPO'];
                
                $linkrecurso = "";
				
				
				$idlinea = "";
				if($row['PK_LESTRATEGICA']==""){
                    $id_linea = $linea["PK1"];								
				}
				else{
					$id_linea = $row['PK_LESTRATEGICA'];								
				}
				
				
                
                //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P112" : "P111";
                $permiso = ($this->permisoG == "R") ? "P112" : "P111";

                //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                    
                    if ($row['IMAGEN'] == "") {
                        //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P108" : "P61";
                        $permiso = ($this->permisoG == "R") ? "P108" : "P61";

                        //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                        if ($this->isAdm || in_array($permiso,$this->permisosArray)){
							
							
							
                            $linkrecurso = "editEvidencias('" . $row['PK1'] . "','" . trim(str_replace($sustituye,"",htmlentities($row['EVIDENCIA'], ENT_QUOTES, "ISO-8859-1"))) . "','" . trim(str_replace($sustituye,"",htmlentities($row['DESCRIPCION'], ENT_QUOTES, "ISO-8859-1"))) . "','" . htmlentities($row['AUTOR'], ENT_QUOTES, "ISO-8859-1") . "','" . $id_linea . "','" . $row['PK_OTACTICO'] . "');return false;";
							
							
                        } else {
                            $linkrecurso = "void(0);return false;";
                        }
                        
                    } else {
                        $linkrecurso = "WindowOpen('" . $row['PK1'] . "','" . $_GET['IDPlan'] . "');return false;";
                    }
                    
                    
                    
                } else {
                    $linkrecurso = "void(0);return false;";
                }
                
                
                
                
                $content = $this->View->Template(TEMPLATE . 'modules/planesoperativo/EVIDENCIA.TPL');
                $content = $this->View->replace('/\#TITULO\#/ms', $titulo, $content);
                $content = $this->View->replace('/\#IMAGEN\#/ms', $imagen, $content);
                $content = $this->View->replace('/\#OBJETOVOE\#/ms', htmlentities($objetivoe, ENT_QUOTES, "ISO-8859-1"), $content);
                $content = $this->View->replace('/\#RESULTADO\#/ms', $titleresultado, $content);
                $content = $this->View->replace('/\#EVIDENCIA\#/ms', $evidencia, $content);
                $content = $this->View->replace('/\#LINKRECURSO\#/ms', $linkrecurso, $content);
                $content = $this->View->replace('/\#FORMATO\#/ms', $formato, $content);
                
                /*  checar */
                
                //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P109" : "P63";
                $permiso = ($this->permisoG == "R") ? "P109" : "P63";

                //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                    $urledit = '<div class="action-icon price"><a href="#" onclick="editEvidencias(\'' . $row['PK1'] . '\',\'' . trim(str_replace($sustituye,"",htmlentities($row['EVIDENCIA'], ENT_QUOTES, "ISO-8859-1"))) . '\',\'' . trim(str_replace($sustituye,"",htmlentities($row['DESCRIPCION'], ENT_QUOTES, "ISO-8859-1"))) . '\',\'' . htmlentities($row['AUTOR'], ENT_QUOTES, "ISO-8859-1") . '\',\'' . $id_linea . '\',\'' . $row['PK_OTACTICO'] . '\');return false;"><img border="0" src="skins/default/img/icn_edit.png" width="16" height="16"></a></div>';
                    $content = $this->View->replace('/\<!--#LINKEDIT#-->/ms', $urledit, $content);
                }
                
                //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P110" : "P62";
                $permiso = ($this->permisoG == "R") ? "P110" : "P62";

                //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                if ($this->isAdm || in_array($permiso,$this->permisosArray)){
				
				   //deleteEvidencia*_
                    $urlborrar = '<div class="action-icon cart"><a href="javascript:void(0)" onclick="deleteEvidencia(\''.$row['ADJUNTO'].'\',\''.$row['PK1'] . '\',\'' . $_GET['IDPlan'] . '\',\'' . $id_linea . '\',\'' . $row['PK_OTACTICO'] . '\',\'' . trim(str_replace($sustituye,"",htmlentities($resultado['OBJETIVO'], ENT_QUOTES, "ISO-8859-1"))) . '\',\'' . trim(str_replace($sustituye,"",htmlentities($linea["LINEA"], ENT_QUOTES, "ISO-8859-1"))) . '\');"><img border="0" src="skins/default/img/icn_trash.png" width="16" height="14"></a></div>';
                    $content   = $this->View->replace('/\<!--#LINKDELETE#-->/ms', $urlborrar, $content);
                }
                //$content = $this->View->replace('/\#LINKRECURSO\#/ms' ,$linkrecurso,$content);
                
                
                $recurso .= $content;
                
            }
            
            
            echo $recurso . "#%#" . $numrecursos;
            
        } else {
            
            $recurso .= '<div class="empty_results">NO EXISTEN RESULTADOS</div>';
            echo $recurso . "#%#" . $numrecursos;
            ;
            
        }
        
        
    }
    
    
    
    function BuscarEvidencias2()
    {
        
        //$_GET['q'] = linea
        
        $this->Model->getEvidenciasPlanBusqueda($_GET['q'], $_GET['IDPlan']);
        
        $recurso     = "";
        $numrecursos = sizeof($this->Model->evidencias);
        
        //$cont = 1;
        
        if ($numrecursos != 0) {
              $sustituye   = array("\r\n", "\n", "\r");
            $incremento = 0;
            foreach ($this->Model->evidencias as $row) {
                
                
                
                $incremento++;
                
                $linea     = $this->Model->getLineaPlane($row["PK_LESTRATEGICA"]);
                $contlinea = intval($linea["ORDEN"]);
                $contlinea++;
                
                
                $titulo = $contlinea . '.- ' . htmlentities($linea["LINEA"], ENT_QUOTES, "ISO-8859-1");
                
                
                $resultado = $this->Model->getResultado($_GET['IDPlan'], $row["PK_LESTRATEGICA"], $row["PK_OTACTICO"]);
                $contres   = intval($resultado["ORDEN"]);
                $contres++;
                
                $titleresultado = $contres . '.- ' . htmlentities($resultado['OBJETIVO'], ENT_QUOTES, "ISO-8859-1");
                
                $objetivoe = $this->Model->getObjetivoEst2($resultado['PK_OESTRATEGICO']);
                
                
                
                // $cont++;
                
                $evidencia = '<a href="#" onClick="Evidencias(\'' . $_GET['IDPlan'] . '\',\'' . $row["PK_LESTRATEGICA"] . '\',\'' . $row["PK1"] . '\')">' . $incremento . '.- ' . htmlentities($row["EVIDENCIA"], ENT_QUOTES, "ISO-8859-1") . '</a>';
                
                
                $linkrecurso = "";
                
                
                
                if (trim($row['TIPO']) == "IMG") {
                   $image170X170_ = "media/planesoperativos/evidencias/thum_170x170_" . $row['IMAGEN'];				  			
			       $IMAGEN170X170 = STORAGE_ACCOUNT_CONTAINER."/".CONTAINER_NAME."/".$image170X170_.KEY_ACCESS_BLOBS;	   
				   
                } else {
                    $IMAGEN170X170 = $row['IMAGEN'];
                }
                
                //    $imagen = ($row['IMAGEN']=="") ? "skins/default/img/desconocido.jpg" : $IMAGEN170X170 ;
                
                
                
                $imagen = ($row['IMAGEN'] == "" || is_null($IMAGEN170X170)) ? "skins/default/img/desconocido.jpg" : $IMAGEN170X170;
                
                $fecha   = date('d/m/Y', strtotime($row['FECHA_R']->format('Y-m-d')));
                $formato = $row['TIPO'];
                
                $linkrecurso = "";
                
                //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P112" : "P111";
                $permiso = ($this->permisoG == "R") ? "P112" : "P111";

                //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                    
                    if ($row['IMAGEN'] == "") {
                        //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P108" : "P61";
                        $permiso = ($this->permisoG == "R") ? "P108" : "P61";

                        //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                        if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                            $linkrecurso = "editEvidencias('" . $row['PK1'] . "','" . htmlentities($row['EVIDENCIA'], ENT_QUOTES, "ISO-8859-1") . "','" . htmlentities($row['DESCRIPCION'], ENT_QUOTES, "ISO-8859-1") . "','" . htmlentities($row['AUTOR'], ENT_QUOTES, "ISO-8859-1") . "','" . $row['PK_LESTRATEGICA'] . "','" . $row['PK_OTACTICO'] . "');return false;";
                        } else {
                            $linkrecurso = "void(0);return false;";
                        }
                        
                    } else {
                        $linkrecurso = "WindowOpen('" . $row['PK1'] . "','" . $_GET['IDPlan'] . "');return false;";
                    }
                    
                    
                    
                } else {
                    $linkrecurso = "void(0);return false;";
                }
                
                
                
                
                $content = $this->View->Template(TEMPLATE . 'modules/planesoperativo/EVIDENCIA.TPL');
                $content = $this->View->replace('/\#TITULO\#/ms', $titulo, $content);
                $content = $this->View->replace('/\#IMAGEN\#/ms', $imagen, $content);
                $content = $this->View->replace('/\#OBJETOVOE\#/ms', htmlentities($objetivoe, ENT_QUOTES, "ISO-8859-1"), $content);
                $content = $this->View->replace('/\#RESULTADO\#/ms', $titleresultado, $content);
                $content = $this->View->replace('/\#EVIDENCIA\#/ms', $evidencia, $content);
                $content = $this->View->replace('/\#LINKRECURSO\#/ms', $linkrecurso, $content);
                $content = $this->View->replace('/\#FORMATO\#/ms', $formato, $content);
                
                /*  checar */
                
                //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P109" : "P63";
                $permiso = ($this->permisoG == "R") ? "P109" : "P63";

                //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                if ($this->isAdm || in_array($permiso,$this->permisosArray)){
                    $urledit = '<div class="action-icon price"><a href="#" onclick="editEvidencias(\'' . $row['PK1'] . '\',\'' . htmlentities($row['EVIDENCIA'], ENT_QUOTES, "ISO-8859-1") . '\',\'' . htmlentities($row['DESCRIPCION'], ENT_QUOTES, "ISO-8859-1") . '\',\'' . htmlentities($row['AUTOR'], ENT_QUOTES, "ISO-8859-1") . '\',\'' . $row['PK_LESTRATEGICA'] . '\',\'' . $row['PK_OTACTICO'] . '\');return false;"><img border="0" src="skins/default/img/icn_edit.png" width="16" height="16"></a></div>';
                    $content = $this->View->replace('/\<!--#LINKEDIT#-->/ms', $urledit, $content);
                }
                
                //$permiso = ($this->Model->obtenerEstadoPlan($_GET['IDPlan']) == "R") ? "P110" : "P62";
                $permiso = ($this->permisoG == "R") ? "P110" : "P62";

                //if ($this->passport->getPrivilegio($_GET['IDPlan'], $permiso)) {
                if ($this->isAdm || in_array($permiso,$this->permisosArray)){
				   
                    $urlborrar = '<div class="action-icon cart"><a href="javascript:void(0)" onclick="deleteEvidencia_(\''.$row['PK1'].'\',\''. $_GET['IDPlan'].'\',\''.$row['PK_LESTRATEGICA'] . '\',\'' . $row['PK_OTACTICO'] . '\',\'' . trim(str_replace($sustituye,"",htmlentities($resultado['OBJETIVO'], ENT_QUOTES, "ISO-8859-1"))) . '\',\'' . trim(str_replace($sustituye,"",htmlentities($linea["LINEA"], ENT_QUOTES, "ISO-8859-1"))) . '\');"><img border="0" src="skins/default/img/icn_trash.png" width="16" height="14"></a></div>';
                    $content   = $this->View->replace('/\<!--#LINKDELETE#-->/ms', $urlborrar, $content);
                }
                //$content = $this->View->replace('/\#LINKRECURSO\#/ms' ,$linkrecurso,$content); 
                
                
                $recurso .= $content;
                
            }
            
            
            echo $recurso . "#%#" . $numrecursos;
            
        } else {
            
            $recurso .= '<div class="empty_results">NO EXISTEN RESULTADOS</div>';
            echo $recurso . "#%#" . $numrecursos;
            
        }
        
        
    }
    
    
    
    function getPaginadoHeader()
    {
        
        
        // $this->Model->buscarUsuarios();
        
        #---------------------PAGINADO---------------------------#
        $q              = (isset($_GET['q'])) ? "&q=" . $_GET['q'] : "";
        $paginadoHeader = '
            
        
     <div class="left">
      <div id="sort-panel">  
      <input type="hidden" name="Search" value="recursos" />
      <input type="hidden" name="p" value="' . $_GET['p'] . '" />
      <input type="hidden" name="s" value="' . $_GET['s'] . '" />';
        
        if (isset($_GET['q'])) {
            $paginadoHeader .= ' <input type="hidden" name="q" value="' . $_GET['q'] . '" />';
        }
        
        
        $paginadoHeader .= '<select id="sort-menu" name="sort" onchange="Ordenar(this.value)">
          <option';
        
        if ($_GET['sort'] == 1) {
            $paginadoHeader .= ' selected="selected" ';
        }
        
        $paginadoHeader .= ' value="1">Ordenar por: Reciente adición</option>
          <option';
        if ($_GET['sort'] == 2) {
            $paginadoHeader .= ' selected="selected" ';
        }
        $paginadoHeader .= ' value="2">Ordenar por: Nombre</option>
            <option';
        if ($_GET['sort'] == 3) {
            $paginadoHeader .= ' selected="selected" ';
        }
        $paginadoHeader .= ' value="3">Ordenar por: Apellidos</option>
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
        
        
        $prevpag = (int) $_GET["p"] - 1;
        
        if ($prevpag > $this->Model->totalPag || $prevpag < 1) {
            
            $prevbutton = '<div class="page_button left button_disable"></div>';
        } else {
            
            $prevbutton = '<a href="javascript:void(0)" onclick="showPage(' . $prevpag . ');"> <div class="page_button left"></div></a>';
        }
        
        
        
        $paginadoHeader .= $prevbutton . ' <div class="page_overview_display">
          <input type="text" value="' . $_GET["p"] . '" class="page_number-box">
          &nbsp;de&nbsp;' . $this->Model->totalPag . '</div>';
        
        $nextpag = (int) $_GET["p"] + 1;
        
        if ($nextpag > $this->Model->totalPag) {
            $nextbutton = '<div class="page_button right button_disable"></div>';
        } else {
            $nextbutton = '<a href="javascript:void(0)" onclick="showPage(' . $nextpag . ');"> <div class="page_button right "></div></a>';
        }
        
        $paginadoHeader .= $nextbutton . ' 
      </div>';
        #--------------------- END PAGINADO---------------------------#
        
        
        
        //$this->View->replace_content('/\#FILTERHEADER\#/ms' ,$paginadoHeader);
        return $paginadoHeader;
    }
    
    
    
    function getpaginadoFooter()
    {
        
        #---------------------PAGINADO FOOTER---------------------------#
        $paginadoFooter = '<div class="search_navigation">
        <div class="search_pagination">';
        
        $prevpag = (int) $_GET["p"] - 1;
        
        if ($prevpag > $this->Model->totalPag || $prevpag < 1) {
            
            $prevbutton = '<div class="page_button left button_disable"></div>';
        } else {
            $prevbutton = '<a href="javascript:void(0)" onclick="showPage(' . $prevpag . ');"> <div class="page_button left"></div></a>';
        }
        
        $paginadoFooter .= $prevbutton . ' <div class="page_overview_display">
          <input type="text" value="' . $_GET["p"] . '" class="page_number-box">
          &nbsp;de&nbsp;' . $this->Model->totalPag . '</div>';
        
        $nextpag = (int) $_GET["p"] + 1;
        
        if ($nextpag > $this->Model->totalPag) {
            $nextbutton = '<div class="page_button right button_disable"></div>';
        } else {
            $nextbutton = '<a href="javascript:void(0)" onclick="showPage(' . $nextpag . ');"> <div class="page_button right "></div></a>';
        }
        
        $paginadoFooter .= $nextbutton . '
        </div>
         </div>';
        #---------------------END PAGINADO FOOTER---------------------------#
        
        //$this->View->replace_content('/\#FILTERFOOTER\#/ms' ,$paginadoFooter);
        
        return $paginadoFooter;
    }
    
    
    
    function getLineasPlan()
    {
        
        $this->Model->getLineasPlane($_GET['IDPlanE']);
        $numlineas = sizeof($this->Model->lineas);
        $lineas    = "";
        $i         = 1;
        if ($numlineas != 0) {
            foreach ($this->Model->lineas as $row) {
                
                $lineas .= "<option value=\"" . $row['PK1'] . "\">" . $i++ . ".- " . htmlentities($row['LINEA'], ENT_QUOTES, "ISO-8859-1") . "</option>";
                
            }
        }
        return $lineas;
    }
    
    
    
    function Buscarobjetivos()
    {
        
        $this->Model->getObjetivosPlan($_GET['plan'], $_GET['linea']);
        $numlineas = sizeof($this->Model->objetivos);
        $objetivos = "";
        $i         = 1;
        if ($numlineas != 0) {
            
            $objetivos .= "<option value=\"ALL\">Selecciona el resultado</option>";
            
            foreach ($this->Model->objetivos as $row) {
                
                $objetivos .= "<option value=\"" . $row['PK1'] . "\">" . $i++ . ".- " . htmlentities($row['OBJETIVO'], ENT_QUOTES, "ISO-8859-1") . "</option>";
                
            }
        }
        echo $objetivos;
    }
    
    
    
    function UploadFileResumen()
    {
        //OK1
        $handle = $_FILES["fileresumen"]["tmp_name"];
        $this->adjunto = strtolower(basename($_FILES['fileresumen']['name']));
        $periodo  = $_POST['periodo'];
        $plan     = $_POST['plan'];
        
       // $carpetaplan = "media/planesoperativos/" . $plan;
        
       // $carpetaperiodo = "media/planesoperativos/" . $plan . "/" . $periodo;
		
         //$carpetatest = "media/planesoperativos/test";
		 //$carpetaplan = "media/planesoperativos/test/" . $plan;
         $carpetaperiodo = "media/planesoperativos/" . $plan . "/" . $periodo;	

         //$object_Blob = new phpQS();
        
         /*if (!file_exists($carpetatest)) {
            if (!mkdir($carpetatest, 0777)) {
                die('Fallo al crear las carpetas...');
            }
        */
        
        
        /*if (!file_exists($carpetaplan)) {
            if (!mkdir($carpetaplan, 0777)) {
                die('Fallo al crear las carpetas...');
            }
        }*/
        
        /*if (!file_exists($carpetaperiodo)) {
            if (!mkdir($carpetaperiodo, 0777)) {
                die('Fallo al crear las carpetas...');
            }
        }*/
        
        
        $file = new Upload($_FILES['fileresumen']);
        //echo "<script>alert('".$_FILES['fileresumen']."');</script>";

        //if ($file->uploaded) {
            
           // $file->Process($carpetaperiodo);
            //if ($file->processed) {
                try{
                //$adjunto = $file->file_dst_name;
                
    $this->Model->saveFileResumenPeriodo($plan, $periodo, $this->adjunto);
                echo $this->adjunto."#%#".$this->adjunto;
                
                //agrega a storage azure  					
                //$object_Blob->cargandoBlob($adjunto, getcwd()."/".$carpetaperiodo."/", "/".$carpetaperiodo);//comienza con  /  la ruta y termina sin /
    $this->object_Blob->cargandoBlob($this->adjunto,  $handle, "/".$carpetaperiodo);//comienza con  /  la ruta y termina sin /
				
				//unlink( $this->adjunto);
				
				//probar erores al subir archivos corruptos o con nombres mal
				//eliminar archivo
				//unlink($carpetaperiodo."/".$carpetaplan."/".$adjunto2);									
				
				//eliminar carpeta
				//set_error_handler("myFunctionWarningHandler", E_WARNING);
				
				
					//rmdir($carpetaperiodo);
				   // rmdir($carpetaplan);					
                }catch(Exception $e) 
                {
                    echo $e;
                    echo "<script>alert('error: ".$e."');</script>";
                }	
				//}
            
            
        //}
        
    }
	
	
	// función de gestión de errores
/*function myFunctionWarningHandler($errno, $errstr, $errfile, $errline)
{
   
    switch ($errno) {
       case E_WARNING:
                echo "Hay un WARNING.<br />\n";
                echo "El warning es: ". $errstr ."<br />\n";
                echo "El fichero donde se ha producido el warning es: ". $errfile ."<br />\n";
                echo "La línea donde se ha producido el warning es: ". $errline ."<br />\n";
              
                return true;
                break;         
            
            default:
              
                return false;
                break;
            }
}*/

	
	

    
    
    function UploadFile()
    {
        
        $filext   = strtolower(basename($_FILES['imagearticulo']['name']));
        $path     = $_FILES['imagearticulo']['name'];
        $tipofile = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        
        switch ($tipofile) {
            
            case "jpg":
            case "png":
                $this->Model->tipo = "IMG";
                $this->UploadImagen();
                break;
            
            case "mp3":
            case "wav":
                $this->UploadArchivo();
                $this->Model->tipo = "AUD";
                $this->image       = "media/thumbnails/thum_ik_audio.png";
                break;
            
            
            case "mp4":
            case "m4v":
            case "flv":
            case "avi":
            case "mov":
                
                $this->UploadArchivo();
                $this->Model->tipo = "VID";
                $this->image       = "media/thumbnails/thum_ik_video.png";
                break;
            
            
            case "doc":
            case "docx":
                $this->UploadArchivo();
                $this->Model->tipo = "DOC";
                $this->image       = "media/thumbnails/thum_ik_word.png";
                break;
            
            
            case "xls":
            case "xlsx":
                $this->UploadArchivo();
                $this->Model->tipo = "XLS";
                $this->image       = "media/thumbnails/thum_ik_excel.png";
                break;
            
            
            
            case "ppt":
            case "pptx":
                $this->UploadArchivo();
                $this->Model->tipo = "PPT";
                $this->image       = "media/thumbnails/thum_ik_ppt.png";
                break;
            
            case "pdf":
                $this->UploadArchivo();
                $this->Model->tipo = "PDF";
                $this->image       = "media/thumbnails/thum_ik_pdf.png";
                break;
            
            
            case "zip":
                $this->UploadArchivo();
                $this->Model->tipo = "ZIP";
                $this->image       = "media/thumbnails/thum_ik_zip.png";
                break;
            
            case "txt":
                $this->UploadArchivo();
                $this->image       = "media/thumbnails/thum_ik_txt.png";
                $this->Model->tipo = "TXT";
                break;
            
            
            case "msg":
                $this->UploadArchivo();
                $this->image       = "media/thumbnails/thum_ik_msg.png";
                $this->Model->tipo = "MSG";
                break;
            
            
            case "ics":
                $this->UploadArchivo();
                $this->image       = "media/thumbnails/thum_ik_ics.png";
                $this->Model->tipo = "ICS";
                break;
            
            
            /*case "tif":
            $this->UploadArchivo();
            $this->image = "media/thumbnails/thum_ik_tif.png";
            $this->Model->tipo = "TIF";
            break;*/
            
            
            case "":
                //case NULL:
                $this->UploadArchivo();
                //$this->image = "skins/default/img/desconocido.jpg";
                //$this->Model->tipo = "";
                break;
            
            
            
            default:
                
                $this->image = "media/thumbnails/thum_ik_file.png";
                $this->UploadArchivo();
                break;
                
        }
        
        
        
        $this->Model->idplan      = $_POST['idplan'];
        $this->Model->titulo      = $_POST['titulo'];
        $this->Model->autor       = $_POST['autor'];
        $this->Model->descripcion = $_POST['descripcion'];
        $this->Model->idlinea     = $_POST['linea'];
        $this->Model->idobjetivo  = $_POST['objetivo'];
        $this->Model->imagen      = $this->image;
        $this->Model->adjunto     = $this->adjunto;
        
        if ($_POST['editar'] == "TRUE") {
            $this->Model->idevidencia = $_POST['idevidencia'];
            $this->Model->EditFile();
        } else {
            $this->Model->UploadFile();
        }
        
        
        
    }
    
    
    function UploadImagen()
    {
        
        //OK2
        if ($_FILES['imagearticulo']['name']) {
            
            $this->targetPathumbail = "media/planesoperativos/evidencias/";		   
		
			
            setlocale(LC_CTYPE, 'es');
            $image = strtolower(basename($_FILES['imagearticulo']['name']));
            
            $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
            
            $name                            = strtolower(uniqid('IMG'));
            $image                           = strtolower($name . '.' . $ext);
            $imageupload                     = new Upload($_FILES['imagearticulo']);
            $imageupload->file_new_name_body = $name;
            
            
            $this->image = strtolower($name . '.' . $ext);
            $this->adjunto = $this->targetPathumbail . $this->image;
			
            
            if ($imageupload->uploaded) {
                
                $imageupload->Process($this->targetPathumbail);
                if ($imageupload->processed) {  				
                    
                    //agrega a storage azure
                    $this->object_Blob->cargandoBlob($this->image, getcwd()."/".$this->targetPathumbail."/".$this->image, substr(("/".$this->targetPathumbail), 0, -1));//comienza con  /  la ruta y termina sin /
					unlink( $this->adjunto);					
					
					
                    //Escalamos la imagen para thumbail
                    $imageupload->file_new_name_body = 'thum_170x170_' . $name;
                    $imageupload->image_resize       = true;
                    $imageupload->image_ratio_fill   = true;
                    $imageupload->image_y            = 170;
                    $imageupload->image_x            = 170;
                    
                    $imageupload->Process($this->targetPathumbail);
                    if ($imageupload->processed) {
                        //creamos la imagen pequeña						
						
						//agrega a storage azure img2
							$this->object_Blob->cargandoBlob('thum_170x170_'.$this->image, getcwd()."/".$this->targetPathumbail.'thum_170x170_'.$this->image, substr(("/".$this->targetPathumbail), 0, -1));//comienza con  /  la ruta y termina sin /
					        unlink( $this->targetPathumbail . 'thum_170x170_' . $this->image);						
						
                        
                        $imageupload->file_new_name_body = 'thum_340x220_' . $name;
                        $imageupload->image_resize       = true;
                        $imageupload->image_y            = 220;
                        $imageupload->image_x            = 340;
                        $imageupload->Process($this->targetPathumbail);
                        
                        if ($imageupload->processed) {                            
							
							//agrega a storage azure img3
							$this->object_Blob->cargandoBlob('thum_340x220_'.$this->image, getcwd()."/".$this->targetPathumbail.'thum_340x220_'.$this->image, substr(("/".$this->targetPathumbail), 0, -1));//comienza con  /  la ruta y termina sin /
					        unlink( $this->targetPathumbail . 'thum_340x220_' . $this->image);		
							
                            return TRUE;
                            
                        }
                        
                        
                    } else {
                        return FALSE; //ERROR THUMBAIL
                    }
                    
                } else {
                    return FALSE; //echo 'error : ' . $foo->error;
                }
                
                //SI NO ANEXARON  IMAGEN
            } else {
                
                return TRUE;
            }
            
        }
        
    }
    
    
    
    
    function UploadArchivo()
    {
        
        
        if ($_FILES['imagearticulo']['name']) {
            
            $this->targetPathumbail = "media/planesoperativos/evidencias/";			
			
			
            setlocale(LC_CTYPE, 'es');
            $this->image = strtolower(basename($_FILES['imagearticulo']['name']));
            
            //$path = $_FILES['imagearticulo']['name']; 
            $ext = strtolower(pathinfo($this->image, PATHINFO_EXTENSION));
            
            
            $imagensinext                    = explode(".", $this->image);
            $name                            = strtolower(uniqid('file'));
            $this->image                     = strtolower($name . '.' . $ext);
            $imageupload                     = new Upload($_FILES['imagearticulo']);
            $imageupload->file_new_name_body = $name;
            $this->adjunto                   = $this->targetPathumbail . $name . '.' . $ext;
            
			
			//$object_Blob = new phpQS();  
            
            if ($imageupload->uploaded) {
                
                $imageupload->Process($this->targetPathumbail);
                if ($imageupload->processed) {
					
					
					$this->object_Blob->cargandoBlob($this->image, getcwd()."/".$this->targetPathumbail.$this->image, substr(("/".$this->targetPathumbail), 0, -1));//comienza con  /  la ruta y termina sin /
					unlink( $this->adjunto);	
					
					
                    
                    return TRUE;
                    
                } else {
                    
                    
                    return FALSE; //echo 'error : ' . $foo->error;
                }
                
                //SI NO ANEXARON  IMAGEN
            } else {
                
                return TRUE;
            }
            
        }
        
    }
    
    
    
    function EliminarAdjuntoResumen()
    {
        $ruta_eliminar = CONTAINER_NAME."/media/planesoperativos/".$_POST['idplan']. '/'.$_POST['idPeriodo'];
        $file_eliminar = $_POST['file'];
        $this->Model->EliminarAdjuntoResumen($_POST['idplan'], $_POST['idPeriodo']);
        
        $this->object_Blob->deleteBlob($ruta_eliminar, $file_eliminar);
        
    }

      
    function EliminarEvidencia()
    {
        $ruta_eliminar = CONTAINER_NAME."/media/planesoperativos/evidencias";
        $array = explode("/", $_POST['file']);
        $file_eliminar = $array[3];
        $idevidencia = $_POST['evidencia'];

        $tipofile = strtolower(pathinfo($file_eliminar, PATHINFO_EXTENSION));

        echo "<script>alert('ruta_eliminar: '.$ruta_eliminar.');</script>";
        echo "<script>alert('file_eliminar: '.$file_eliminar.');</script>";
        echo "<script>alert('idevidencia: '.$idevidencia.');</script>";

        $this->Model->EliminarEvidenciaArchivo($idevidencia);
        $this->Model->EliminarEvidencia($idevidencia);
        
        switch ($tipofile) {
            
            case "jpg":
            case "png":
                $this->object_Blob->deleteBlob($ruta_eliminar, $file_eliminar);
                $this->object_Blob->deleteBlob($ruta_eliminar,"thum_170x170_".$file_eliminar);
                $this->object_Blob->deleteBlob($ruta_eliminar,"thum_340x220_".$file_eliminar);
                break;
            default:
                $this->object_Blob->deleteBlob($ruta_eliminar, $file_eliminar);
                break;
        }
        
        
    }
    
    
    function EliminarEvidenciaArchivo()
    {
        $ruta_eliminar = CONTAINER_NAME."/media/planesoperativos/evidencias";
        $array = explode("/", $_POST['file']);
        $file_eliminar = $array[3];
        $idevidencia = $_POST['evidencia'];


        $tipofile = strtolower(pathinfo($file_eliminar, PATHINFO_EXTENSION));
        
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
        $this->Model->EliminarEvidenciaArchivo($idevidencia);
    }
    
    
    function cortar_string($string, $largo)
    {
        $marca = "<!--corte-->";
        
        if (strlen($string) > $largo) {
            
            $string = wordwrap($string, $largo, $marca);
            $string = explode($marca, $string);
            $string = $string[0];
            $string .= " ...";
            
        } else {
            
            $string = $string;
        }
        
        return $string;
        
    }
    
}

?>
