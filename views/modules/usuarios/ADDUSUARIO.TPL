 <script src="skins/default/js/usuarios/addusuarios.js"></script>


<div id="alerta" class="alert alert-block " style="display:none;">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<h4 id="headAlerta" class="alert-heading">!CORRECTO!</h4>
							<p><div id="bodyAlerta">El plan estrategico se ha guardado correctamente.</div></p>
</div>

				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h1 class="left">Crear Usuario</h1><br>
						<p>La informaci&oacute;n sobre usuarios se almacena en un perfil de usuario. Es posible establecer perfiles de usuario. 
						</p>
						
					</div>
					<!-- End Box Head -->	
                     
                    <!-- Pagging -->
			
                        <div class="pagging">
                         <div class="left">
						 <i class="icon-asterisk"></i> Indica un campo obligatorio.</div>
                        <div class="right">
                        <a href="?execute=usuarios&method=default&Menu=F3&SubMenu=SF31#&p=1&s=25&sort=1&q=" class="btn btn-large">Cancelar</a>
						<input type="button" id="btnenviaform1"  class="btn-warning btn-large" value="Aceptar">
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="box-content">
						<div class="form-horizontal">
						  <form enctype="multipart/form-data" name="frmaddusuarios" method="post" id="frmaddusuarios" action="?execute=usuarios/addusuarios&Menu=F3&SubMenu=SF8&method=GuardarUsuario" target="iframe-post-form">  
                          <fieldset>
							<legend>1.   Informaci&oacute;n personal</legend>
									
								<div class="control-group">
								<label for="focusedInput" class="control-label">Imagen:</label>
								<div class="controls">
								  <input type="file" style="display:none;" id="imagearticulo" name="imagearticulo" onchange="readURL(this);" />

                            <img id="thumbailarticulo" src="skins/admin/images/avatar-anonimo.png" />
							
							
							<a href"#" class="btn btn-small" id="btncancelimage"><i class="icon-picture"></i> Cambiar</a>

						
								</div>
							  </div>
							
							
							
							<div class="control-group">
								<label for="focusedInput" class="control-label">Titulo:</label>
								<div class="controls">
								  <input type="text" value="" name="titulo" id="titulo" class="input-xlarge focused">
								</div>
							  </div>
							
							
							<div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Nombre:</label>
								<div class="controls">
								  <input type="text" value="" name="nombre" id="nombre"  class="input-xlarge focused">
								</div>
							  </div>
							  
							  
							 <div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Apellidos:</label>
								<div class="controls">
								  <input type="text" value="" name="apellidos" id="apellidos" class="input-xlarge focused">
								</div>
							 </div>
							 
							  <div class="control-group">
								<label for="focusedInput" class="control-label">Correo:</label>
								<div class="controls">
								  <input type="text" value="" name="correo" id="correo" class="input-xlarge focused">
								</div>
							 </div>
							 
							 
							  <legend>2.   Disponibilidad</legend>
							 
							 
							  <div class="control-group">
								<label for="focusedInput" class="control-label">Disponible:</label>
								<div class="controls"> 
								  <input type="radio" name="disponible" value="1" checked="checked">&nbsp;Si&nbsp;
                                   <input type="radio" name="disponible" value="0">&nbsp;No
								</div>
							 </div>
							 
							 
							 <legend>3.   Informaci&oacute;n de cuenta</legend>
							 
							 
							  <div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Usuario:</label>
								<div class="controls">
								  <input type="text" value="" maxlength="15" style="width: 130px;" name="usuario" maxlength="20" id="usuario" class="input-xlarge focused">
								</div>
							 </div>
							 
							  <div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Contrase&ntilde;a:</label>
								<div class="controls">
								  <input type="password" value="" name="password" maxlength="15" style="width: 130px;" id="password" class="input-xlarge focused">
								</div>
							 </div>
							 
							   <div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Confirmar Contrase&ntilde;a:</label>
								<div class="controls">
								  <input type="password" value="" name="password2" maxlength="15" style="width: 130px;" id="password2" class="input-xlarge focused">
								</div>
							 </div>
							 
							 
							 <legend>4.   Nodo principal de jerarqu&iacute;a institucional</legend>
							  <p>Seleccione el nivel principal al que pertenece el usuario dentro de la jerarquia institucional.</p>
                              <div class="control-group">
                              <div class="controls">
                              #NODOSPRINCIPAL#
                              </div>
                              </div>
							 
							 
							 
							  <legend>5.   Nodos de jerarqu&iacute;a institucional</legend>
							  <p>Seleccione los niveles de acceso que desea agregar al usuario dentro de la jerarqu&iacute;a institucional para los planes estrategicos y operativos.</p>
                              <div class="control-group">
                              <div class="controls">
                              #NODOS#
                              </div>
                              </div>



                                <legend>5.   Acceso a Reportes</legend>
							  <p>Seleccione los niveles de acceso para reportes.</p>
                              <div class="control-group">
                              <div class="controls">
                              #NODOSREPORTES#
                              </div>
                              </div>


                              
							 
						
						      <legend>6.   Roles del Sistema</legend>
							  <p>Seleccione uno o varios roles del sistema para el usuario.</p><br>
							  
							  <div class="control-group" >
							  <div class="controls">
							  <label><strong>Roles disponibles</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Roles Seleccionados</strong></label>
							  <select id="sel1" name="sel1" size="5"> 
#ROLES#
</select> 

<a href="javascript:pasarRoles()" class="btn btn-small" ><i class="icon-chevron-right"></i> Agregar</a>
<a href="javascript:quitarRoles()" class="btn btn-small" ><i class="icon-chevron-left"></i> Eliminar</a>


<select name="sel2[]" size="5" multiple="multiple" id="sel2"> 
</select> 
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
                        <a href="?execute=usuarios&method=default&Menu=F3&SubMenu=SF8#&p=1&s=25&sort=1&q=" class="btn btn-large">Cancelar</a>
						<input type="button" id="btnenviaform2" class="btn-warning btn-large" value="Aceptar"/>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
					
					
				</div>
				<!-- End Box -->           
                  