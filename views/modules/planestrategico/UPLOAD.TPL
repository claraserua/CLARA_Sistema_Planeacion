<script src="skins/default/js/planestrategico/adjuntarfile.js"></script>
<script>
function eviarform(){
$('#frmaddusuarios').submit();	
}
	
</script>


<div id="alerta" class="alert alert-block " style="display:none;">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<h4 id="headAlerta" class="alert-heading">!CORRECTO!</h4>
							<p><div id="bodyAlerta">El plan estrategico se ha guardado correctamente.</div></p>
</div>


				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h1 class="left">#TITULO#</h1><br>
						
						
					</div>
					<!-- End Box Head -->	
             
             
               <!-- Pagging -->
			       
                        <div class="pagging">
                         <div class="left">
						 <ul class="Menu" style="margin-top:15px;">
                       <li ><a href="#MENUURL#">L&iacute;neas y Objetivos</a></li>
                       <li id="active"> Documentos Adjuntos</li>
                    
                       </ul>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
             
             
                    
                    <!-- Pagging -->
						
                     
                      
                        <div class="pagging">
                         <div class="left">
                         <h1>Adjuntar Archivo <span style="font-size:12px;"> (<i class="icon-asterisk"></i> Indica un campo obligatorio.)</span></h1>
						</div>
                        <div class="right">
                        <a href="#URLCANCELAR#" class="btn btn-large">Cancelar</a>
						<input type="button" id="btnenviaform1" onclick="eviarform();"  class="btn-warning btn-large" value="Adjuntar">
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="box-content">
						<div class="form-horizontal">
						  <form enctype="multipart/form-data" name="frmaddusuarios" method="post" id="frmaddusuarios" action="?execute=planestrategico/adjuntos&method=UploadFile&Menu=F1&SubMenu=SF11&IDPlan=PE51B9FA975CFAB#&p=1&s=25&sort=1&q=" target="iframe-post-form">  
                          <fieldset>
							<legend>1.   Informaci&oacute;n general</legend>
							<input  type="hidden" id="idplan" name="idplan" value="#IDPLAN#"/>
							 
							 <input type="hidden" value="FALSE" name="editar" id="editar">
							 
							<div class="control-group">
								<label for="focusedInput" class="control-label">Titulo:</label>
								<div class="controls">
								  <input type="text" value="" name="titulo" id="titulo" class="input-xlarge focused">
								</div>
							  </div>
							
							
							<div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Descripci&oacute;n:</label>
								<div class="controls">
									<textarea id="descripcion" name="descripcion" class="cleditor" rows="3" style="width: 500px; height: 140x;"></textarea>
								</div>
							  </div>
							  
							  
							 <div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Autor:</label>
								<div class="controls">
								  <input type="text" value="" name="autor" id="apellidos" class="input-xlarge focused">
								</div>
							 </div>
							 
							
							 
							
							 
							 <legend>3.   Seleccionar archivo</legend>
							 
							 
							  <div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Archivo:</label>
								<div class="controls">
								<input type="file"  id="imagearticulo" name="imagearticulo"  />
								</div>
							 </div>
							 
							
							 
							 
							 
							 
						
						    


							  
						  </fieldset>
                          </form>
						</div>   

					</div>
					<!-- Table -->
					
					
					 <!-- Pagging -->
						
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
              		
                        <div class="right">
                        <a href="?execute=planestrategico/adjuntos&Menu=F1&SubMenu=SF4#&p=1&s=25&sort=1&q=" class="btn btn-large">Cancelar</a>
						<input type="button" id="btnenviaform2" onclick="eviarform();" class="btn-warning btn-large" value="Adjuntar"/>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
					
					
				</div>
				<!-- End Box -->           
                  