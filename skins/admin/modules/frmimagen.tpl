	<script src="skins/admin/js/fileManagerImagen.js" type="text/javascript"></script>
<!--
<form enctype="multipart/form-data" method="post" id="frmimagenes" action="index.php?execute=fileManager&handle=fileManager&action=add&method=saveImagen" target="iframe-post-form"> -->

 <!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h1 class="left">Crear Usuario</h1><br>
						<p>La información sobre usuarios se almacena en un perfil de usuario. Es posible establecer perfiles de usuario. 
						</p>
						
					</div>
					<!-- End Box Head -->	
             
                    
                    <!-- Pagging -->
						
                        <div class="pagging">
                         <div class="left">
						 <i class="icon-asterisk"></i> Indica un campo obligatorio.</div>
                        <div class="right">
                        <a href="?execute=usuarios&Menu=F3&SubMenu=SF8" class="btn btn-large">Cancelar</a>
						<button class="btn-warning btn-large">Aceptar</button>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="box-content">
						<form class="form-horizontal">
						  <fieldset>
							<legend>1.   Información personal</legend>
									
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
								  <input type="text" value="" id="focusedInput" class="input-xlarge focused">
								</div>
							  </div>
							
							
							<div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Nombre:</label>
								<div class="controls">
								  <input type="text" value="" id="focusedInput" class="input-xlarge focused">
								</div>
							  </div>
							  
							  
							 <div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Apellidos:</label>
								<div class="controls">
								  <input type="text" value="" id="focusedInput" class="input-xlarge focused">
								</div>
							 </div>
							 
							  <div class="control-group">
								<label for="focusedInput" class="control-label">Correo:</label>
								<div class="controls">
								  <input type="text" value="" id="focusedInput" class="input-xlarge focused">
								</div>
							 </div>
							 
							 <legend>2.   Información de cuenta</legend>
							 
							 
							  <div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Usuario:</label>
								<div class="controls">
								  <input type="text" value="" id="focusedInput" class="input-xlarge focused">
								</div>
							 </div>
							 
							  <div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Contraseña:</label>
								<div class="controls">
								  <input type="text" value="" id="focusedInput" class="input-xlarge focused">
								</div>
							 </div>
							 
							   <div class="control-group">
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Confirmar Contraseña:</label>
								<div class="controls">
								  <input type="text" value="" id="focusedInput" class="input-xlarge focused">
								</div>
							 </div>
							 
							 
							  <legend>3.   Nodos de jerarquía institucional</legend>
							  <p>Haga clic en Buscar nodo para buscar los nodos que desee añadir a este usuario.</p>
							 
						
						      <legend>4.   Roles del Sistema</legend>
							  <p>Seleccione uno o varios roles del sistema para el usuario.</p><br>
							  
							  <div class="control-group" >
							  <div class="controls">
							  <label><strong>Roles disponibles</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Roles Seleccionados</strong></label>
							  <select id="sel1" size="5"> 
<option value="1">Uno</option> 
<option value="2">Dos</option> 
<option value="3">Tres</option> 
<option value="4">Cuatro</option> 
<option value="5">Cinco</option> 
</select> 

<a href="javascript:pasarRoles()" class="btn btn-small" ><i class="icon-chevron-right"></i> Agregar</a>
<a href="javascript:quitarRoles()" class="btn btn-small" ><i class="icon-chevron-left"></i> Eliminar</a>


<select id="sel2" size="5"> 
</select> 
</div>
</div>
							  
						  </fieldset>
						</form>   

					</div>
					<!-- Table -->
					
					
					 <!-- Pagging -->
						
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
              		
                        <div class="right">
                        <a href="?execute=usuarios&Menu=F3&SubMenu=SF8" class="btn btn-large">Cancelar</a>
						<button class="btn-warning btn-large">Aceptar</button>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
					
					
				</div>
				<!-- End Box -->           
                  