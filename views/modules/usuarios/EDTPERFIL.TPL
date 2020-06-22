 <script src="skins/default/js/usuarios/editperfil.js"></script>


<div id="alerta" class="alert alert-block " style="display:none;">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<h4 id="headAlerta" class="alert-heading">!CORRECTO!</h4>
							<p><div id="bodyAlerta">El plan estrategico se ha guardado correctamente.</div></p>
</div>


				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h1 class="left">Editar Perfil</h1><br>
						<p>La informaci&oacute;n sobre usuarios se almacena en un perfil de usuario. Es posible establecer perfiles de usuario. 
						</p>
						
					</div>
					<!-- End Box Head -->	
             
                    
                    <!-- Pagging -->
						
                     
                      
                        <div class="pagging">
                         <div class="left">
						 <i class="icon-asterisk"></i> Indica un campo obligatorio.</div>
                        <div class="right">
                      <a href="javascript:history.back(1);" class="btn btn-large">Cancelar</a>
                       <!-- <a href="?execute=operativo&method=default&Menu=F2&SubMenu=SF21#&p=1&s=25&sort=1&q=" class="btn btn-large">Cancelar</a>-->
                        
						<input type="button" id="btnenviaform1"  class="btn-warning btn-large" value="Guardar">
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="box-content">
						<div class="form-horizontal">
						  <form enctype="multipart/form-data" name="frmaddusuarios" method="post" id="frmaddusuarios" action="?execute=usuarios/perfil&Menu=F3&SubMenu=SF8&method=Actualizar" target="iframe-post-form">  
                          <fieldset>
							<legend>1.   Informaci&oacute;n personal</legend>
									
								<input  type="hidden" name="idusuario" id="idusuario" value="#IDUSUARIO#"/>
								<div class="control-group">
								<label for="focusedInput" class="control-label">Imagen:</label>
								<div class="controls">
								  <input type="file" style="display:none;" id="imagearticulo" name="imagearticulo" onchange="readURL(this);" />
                           <img id="thumbailarticulo" src="#IMAGEN#" />
							
							<input type="hidden" id="editimagen" name="editimagen" value="FALSE" />
							<input type="hidden" id="imageold" name="imageold" value="#IMAGENOLD#" />
							
							
							<a href="#" class="btn btn-small" id="btncancelimage"><i class="icon-picture"></i> Cambiar</a>

						
								</div>
							  </div>
							
							
							
							<div class="control-group">
								<label for="focusedInput" class="control-label">Titulo:</label>
								<div class="controls">
								  <input type="text" value="#TITULO#" name="titulo" id="titulo" class="input-xlarge focused">
								</div>
							  </div>
							
							
							<div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Nombre:</label>
								<div class="controls">
								  <input type="text" value="#NOMBRE#" name="nombre" id="nombre"  class="input-xlarge focused">
								</div>
							  </div>
							  
							  
							 <div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Apellidos:</label>
								<div class="controls">
								  <input type="text" value="#APELLIDOS#" name="apellidos" id="apellidos" class="input-xlarge focused">
								</div>
							 </div>
							 
							  <div class="control-group">
								<label for="focusedInput" class="control-label">Correo:</label>
								<div class="controls">
								  <input type="text" value="#CORREO#" name="correo" id="correo" class="input-xlarge focused">
								</div>
							 </div>
							 
							 
							 
							 
							 
							 <legend>2.   Contrase&ntilde;a de la cuenta</legend>
							 
							 <div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Usuario:</label>
								<div class="controls">
								  <input type="text" value="#USUARIO#" readonly="readonly" maxlength="15" style="width: 130px;" name="usuario" id="usuario" class="input-xlarge focused">
								</div>
							 </div>
							 
							 
							  <div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Contrase&ntilde;a:</label>
								<div class="controls">
								  <input type="text" value="#PASSWORD#" name="password" maxlength="15" style="width: 130px;" id="password" class="input-xlarge focused">
								</div>
							 </div>
							 
							   <div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Confirmar Contrase&ntilde;a:</label>
								<div class="controls">
								  <input type="text" value="#PASSWORD#" name="password2" maxlength="15" style="width: 130px;" id="password2" class="input-xlarge focused">
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
                       <!-- <a href="?execute=operativo&method=default&Menu=F2&SubMenu=SF21#&p=1&s=25&sort=1&q=" class="btn btn-large">Cancelar</a>-->
                       
                         <a href="javascript:history.back(1);" class="btn btn-large">Cancelar</a>
						<input type="button" id="btnenviaform2" class="btn-warning btn-large" value="Guardar"/>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
					
					
				</div>
				<!-- End Box -->           
                  