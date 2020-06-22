<script type="text/javascript">

function GuardarFicha(){
	
	 $.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
				 
				 setTimeout("document.forms.item(0).submit()",600);
	
}

</script>

				<!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h1 class="left"> Editar ficha de sistema
</h1><br>
<p>Las fichas contienen permisos para administrar el sistema. 
						</p>
						
						
					</div>
					<!-- End Box Head -->	
                    
                    
                    <!-- Pagging -->
						
                        <div class="pagging">
                         <div class="left">
						 <i class="icon-asterisk"></i> Indica un campo obligatorio.</div>
                        <div class="right">
                        <a href="?execute=fichas&method=default&Menu=F3&SubMenu=SF33#&p=1&s=25&sort=1&q=" class="btn btn-large">Cancelar</a>
						<button class="btn-warning btn-large" onclick="GuardarFicha();">Guardar</button>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="box-content">
						<form class="form-horizontal" method="post" action="?execute=fichas&method=Actualizar&Menu=F3&SubMenu=SF33#&p=1&s=25&sort=1&q=" name="frmaddniveles" id="frmaddniveles">
						  <fieldset>
							<legend>1.   Propiedades de ficha </legend>
									
							<input type="hidden" name="idficha" value="#IDFICHA#" />
								
							<div class="control-group">
								<label for="focusedInput" class="control-label"> <i class="icon-asterisk"></i>Nombre de la ficha:</label>
								<div class="controls">
								  <input type="text" value="#NOMBRE#" id="ficha" name="ficha" class="input-xlarge focused">
								</div>
							  </div>
							
							
							<div class="control-group">
								<label for="focusedInput" class="control-label">Descripci&oacute;n :</label>
								<div class="controls">
				<textarea id="descripcion" name="descripcion" class="cleditor" rows="3" style="width: 500px; height: 140x;">#DESCRIPCION#</textarea>
								</div>
							  </div>
							  
							  
							  
						  </fieldset>
						</form>   

					</div>
					<!-- Table -->
					
					
					 <!-- Pagging -->
						
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
              		
                        <div class="right">
                        <a href="?execute=fichas&method=default&Menu=F3&SubMenu=SF33#&p=1&s=25&sort=1&q=" class="btn btn-large">Cancelar</a>
						<button class="btn-warning btn-large" onclick="GuardarFicha();">Guardar</button>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
					
					
				</div>
				<!-- End Box -->
                  