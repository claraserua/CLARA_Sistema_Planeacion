
<script src="skins/default/js/planesoperativo/seguimientoobjetivos.js"></script>
<script type="text/javascript" src="skins/default/js/comentarios/jquery.oembed.js"></script>
<script type="text/javascript" src="skins/default/js/comentarios/jquery.watermarkinput.js"></script>


<script>
function eviarform(){

$('#frmaddusuarios').submit();	
}
	
</script>
 


<div class="box"><!-- Box Head -->
<div class="box-head">
<h1 class="left">#TITULOPLAN#</h1>
<br>
<p>Evidencias correspondientes al plan. </p>
</div>
<!-- End Box Head --><!-- Pagging -->
<div class="pagging">
<div class="left" id="menucontent">
<ul class="subMenu" style="margin-top: 15px;" id="myTablab">

<li class=""> <a href="#evidencias" onclick="ShowBtnRegresar();">Evidencias</a></li>
</ul>
</div>

<div class="right"> 

<!--id="btninfr-'.$idinforme.'" onClick="EnviarInforme(false,\''.$rowobj['PK1'].'\',\''.$rowperiodos['PK1'].'\',\''.$rowperiodos['PERIODO'].'\',\''.$contmedio.'\',\''.$idinforme.'\');"-->

<a href="?execute=operativo&amp;method=default&amp;Menu=F2&amp;SubMenu=SF21#&amp;p=1&amp;s=25&amp;sort=1&amp;q=" class="btn btn-large"><i class="icon-off"></i>Salir de Evidencias</a>



 
</div>

</div>
<!-- End Pagging --><!-- CONTENT LINEA -->
<div id="TabContent" class="tab-content">

<div class="tab-pane" id="evidencias">
<div class="box-content">


#EVIDENCIAS#

	

<!--MODAL-->
<div class="modal hide fade" id="myModalupload" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">x</button>
				<span id="titlemodal"></span>
			</div>
			<div class="modal-body">
				<div id="bodymodal" >
					<!--BODY MODAL-->
					 
					

					<!-- Table -->
						<div class="form-horizontal" style="width: 400px;" >
						  <form enctype="multipart/form-data" name="frmaddusuarios" method="post" id="frmaddusuarios" action="?execute=planesoperativo/seguimiento&Menu=F3&SubMenu=SF8&method=UploadFile" target="iframe-post-form">  
                          <fieldset>
							<legend>Agregar Evidencia</legend>
							
							
					
								<input  type="hidden" id="idplan" name="idplan" value="#IDPLAN#"/>
								<input  type="hidden" id="editar" name="editar" value="FALSE"/>						
								<input  type="hidden" id="idevidencia" name="idevidencia" value=""/>
								
						        <input  type="hidden" id="lineasfilter" name="lineasfilter" />
					        	<input  type="hidden" id="objetivosfilter" name="objetivosfilter" />								
							    
							<div class="control-group">
								<label for="focusedInput" class="control-label"><small><i class="icon-asterisk"></i>Titulo:</small></label>
								<div class="controls">
								  <input type="text" value="" name="titulo" id="titulo" class="input-xlarge focused">
								</div>
							  </div>
							
							
							<div class="control-group">
								<label for="focusedInput" class="control-label"><small>Descripcion:</small></label>
								<div class="controls">
						<textarea id="descripcion" name="descripcion" class="cleditor" rows="3" style="width: 350px; height: 140x;"></textarea>
								</div>
							  </div>
							  
							  
							 <div class="control-group">
								<label for="focusedInput" class="control-label"><small><i class="icon-asterisk"></i>Autor:</small></label>
								<div class="controls">
								  <input type="text" value="" name="autor" id="autor" class="input-xlarge focused">
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
		<!--		<a href="#" id="adjuntarmodal" class="btn btn-warning" data-dismiss="modal">Adjuntar Archivo</a>-->
				
				<input type="submit" data-dismiss="modal" class="btn btn-warning" onclick="eviarform();" value="Adjuntar Archivo"/>
				
			</div>
		</div>

<!--END MODAL-->



</div>
</div>




</div>
<!-- Pagging -->

<!-- End Pagging --> </div>
<!-- End Box -->
