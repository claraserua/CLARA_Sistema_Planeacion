
<script src="skins/default/js/planesoperativo/seguimientoobjetivos.js"></script>
<script type="text/javascript" src="skins/default/js/comentarios/jquery.oembed.js"></script>
<script type="text/javascript" src="skins/default/js/comentarios/jquery.watermarkinput.js"></script>


<script>
function eviarform(){

$('#frmaddusuarios').submit();	
}
	
</script>
 

<div id="alerta" class="alert alert-block" style="display: none;"> <button type="button" class="close" data-dismiss="alert">x</button>
<h4 id="headAlerta" class="alert-heading">!CORRECTO!</h4>
<p></p>
<div id="bodyAlerta">El plan estrategico se ha guardado
correctamente.</div>
<p></p>
</div>
<div class="box"><!-- Box Head -->
<div class="box-head">
<h1 class="left">#TITULOPLAN#</h1>
<span class="right">#ESTADO#</span>
<br>
<p>Seguimiento de objetivos t&aacute;cticos correspondientes al plan. </p>
</div>
<!-- End Box Head --><!-- Pagging -->
<div class="pagging">
<div class="left" id="menucontent">
<ul class="subMenu" style="margin-top: 15px;" id="myTablab">
<li class=""><a href="#lineasyobjetivos" onclick="HideBtnRegresar();">Líneas
y Resultados</a></li>

#TABRESUMENEJECUTIVO#

<li class=""> <a href="#evidencias" onclick="ShowBtnRegresar();">Evidencias</a></li>
</ul>
</div>

<div class="right"> 

<!--id="btninfr-'.$idinforme.'" onClick="EnviarInforme(false,\''.$rowobj['PK1'].'\',\''.$rowperiodos['PK1'].'\',\''.$rowperiodos['PERIODO'].'\',\''.$contmedio.'\',\''.$idinforme.'\');"-->

<a href="?execute=operativo&amp;method=default&amp;Menu=F2&amp;SubMenu=SF21#&amp;p=1&amp;s=25&amp;sort=1&amp;q=" class="btn btn-large"><i class="icon-off"></i> Salir del Plan</a>

<span id="btnlr">
<a href="#" onclick="ShowLR();"  class="btn btn-large" ><i class="icon-chevron-left"></i> Regresar a Líneas y Resultados</a> 
</span>

#BOTONENVIOINFORME#


 
</div>

</div>
<!-- End Pagging --><!-- CONTENT LINEA -->
<div id="TabContent" class="tab-content">
<div class="tab-pane" id="lineasyobjetivos">
<div class="box-content"><!--====================OBJETIVO=====================-->
<div id="L0-C0" class="wellstrong" style="display: none;">
<div class="box-icon"> </div>
<table width="100%">
<tbody>
<tr>
<td>Resultado</td>
<td> Objetivo estratégico</td>
<td> Responsable</td>
</tr>
<tr>
<td>
<div class="input-prepend"> <span class="add-on" id="LABEL-L0-O0">1.1</span> <input style="width: 400px;" id="L0-O0" type="text"> </div>
</td>
<td>
<select style="width: 300px;" id="L0-OE0"><option>L1 Objetivo estrategico 1</option></select>
</td>
<td><input id="L0-OR0" type="text"></td>
</tr>
</tbody>
</table>
<div class="box-objectivos" id="BOX-L0-C0">
<div class="well">
<table width="100%">
<tbody>
<tr>
<td width="30">&nbsp; </td>
<td>Medios</td>
<td>Responsable</td>
</tr>
<tr id="L0-O0-M0-C0">
<td>&nbsp; </td>
<td width="520">
<div class="input-prepend"> <span class="add-on" id="LABEL-L0-O0-M0">1.1.1</span> <input style="width: 470px;" id="L0-O0-M0" type="text">
</div>
</td>
<td><input id="L0-O0-M0-R0" type="text"></td>
</tr>
<tr>
<td colspan="2">
<div style="margin-left: 30px;" class="left">

 </div>
</td>
</tr>
</tbody>
</table>
</div>
<div class="well">
<table width="100%">
<tbody>
<tr>
<td width="30">&nbsp; </td>
<td>Evidencias </td>
</tr>
<tr id="L0-O0-E0-C0">
<td>&nbsp; </td>
<td>
<div class="input-prepend"> <span class="add-on" id="LABEL-L0-O0-E0">1.1.1</span> <input style="width: 470px;" id="L0-O0-E0" type="text">
</div>
</td>
</tr>
<tr>
<td colspan="2">
<div style="margin-left: 30px;" class="left">


</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<!--====================END OBJETIVO=====================-->
#CONTENIDO# </div>
<!-- END CONTENT LINEA --> </div>
<div class="tab-pane" id="resumen">
<div class="box-content">
<p style="padding: 10px; background: rgb(245, 245, 245) none repeat scroll 0% 50%; -moz-background-clip: initial; -moz-background-origin: initial; -moz-background-inline-policy: initial;">En este apartado  se expone un resumen general de los logros o dificultades que tuvo la universidad en el periodo.</p>
<br>

#BTNDIAGNOSTICOI#

<br>

<div  id="BOXRESUMENANUAL" style="display: none">
 <!--#VALUEDESCRIPCION#-->
					 
					 
					 <br />
<!-- COMENTARIOS RESUMEN EJECUTIVO-->

#COMENTARIOSDIAGNOSTICOINICIAL#


<div  id="BOXRESUMEN" style="display: none">
#COMENTARIOSRESUMENEJECUTIVO# 
</div>
</div>
<br>
#COMENTARIOSRESUMENEJECUTIVOPERIODOS#
<br>
</div>
</div>

<div class="tab-pane" id="evidencias">
<div class="box-content">


#EVIDENCIAS#


<!--MODAL-->
<div class="container">
	<div class="modal hide fade" id="myModalupload">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<br/>
			<span id="titlemodal">
			 <h1>Agregar Evidencia</h1>
			</span>
		</div>
			<div class="modal-body">
				<div id="bodymodal" >
					<!--BODY MODAL-->
					<!-- Table -->
					<div class="form-horizontal" style="width: 450px;" >
						<form enctype="multipart/form-data" name="frmaddusuarios" method="post" id="frmaddusuarios" action="?execute=planesoperativo/seguimiento&Menu=F3&SubMenu=SF8&method=UploadFile" target="iframe-post-form">  
                          <fieldset>
							
								<input  type="hidden" id="idplan" name="idplan" value="#IDPLAN#"/>
								<input  type="hidden" id="editar" name="editar" value="FALSE"/>						
								<input  type="hidden" id="idevidencia" name="idevidencia" value=""/>	
								
								<input  type="hidden" id="lineasfilter" name="lineasfilter" />
					        	<input  type="hidden" id="objetivosfilter" name="objetivosfilter" />	
														
							    
							<div class="control-group">
								<label for="focusedInput" class="control-label"><small><i class="icon-asterisk"></i>Titulo:</small></label>
								<div class="controls">
								<input type="text" value="" name="titulo" id="titulo" class="input-xlarge focused" />
								</div>
							</div>

							<div class="control-group">
								<label for="focusedInput" class="control-label"><small>Descripcion:</small></label>
								<div class="controls">
								<textarea id="descripcion" name="descripcion" class="cleditor" rows="3" style="width: 300px;">
								</textarea>
								</div>
							</div>

							<div class="control-group">
								<label for="focusedInput" class="control-label"><small><i class="icon-asterisk"></i>Autor:</small></label>
								<div class="controls">
								<input type="text" value="" name="autor" id="autor" class="input-xlarge focused" />
								</div>
							</div>
							 
							<div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i><small>Linea:</small></label>
								<div class="controls">
								<select name="linea" onchange="getObjetivos(this);" id="linea">
								<option value="NONE">Selecciona la linea</option>
									#LINEAS#
								</select>
								</div>
							</div>

							<div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i><small>Resultado:</small></label>
								<div class="controls">
								<select name="objetivo" id="objetivo" disabled="disabled">
								</select>
								</div>
							</div>

							<div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i><small>Archivo:</small></label>
								<div class="controls">
								<input type="file"  id="imagearticulo" name="imagearticulo" />
								</div>
							 </div>

						  </fieldset>
                        </form>
					</div>
					<!-- Table -->
					<!--END BODYMODAL-->
				</div>
			</div>
		<div class="modal-footer">
				<a href="#" id="cancelarmodal" class="btn" data-dismiss="modal">Cerrar</a>
				<!--<a href="#" id="adjuntarmodal" class="btn btn-warning" data-dismiss="modal">Adjuntar Archivo</a>-->
				<input type="submit" data-dismiss="modal" class="btn btn-warning" onclick="eviarform();" value="Adjuntar Archivo" />
		</div>
	</div>
</div>

<!--END MODAL-->



</div>
</div>


<!-- Pagging -->
<div class="pagging" style="border-top: 1px solid rgb(187, 187, 187);">
<div class="right"> 

<a href="?execute=operativo&amp;method=default&amp;Menu=F2&amp;SubMenu=SF21#&amp;p=1&amp;s=25&amp;sort=1&amp;q=" class="btn btn-large"><i class="icon-chevron-left"></i> Salir del Plan</a>

#BOTONENVIOINFORME#

 </div>
</div>

</div>

<!-- End Pagging --> </div>
<!-- End Box -->
