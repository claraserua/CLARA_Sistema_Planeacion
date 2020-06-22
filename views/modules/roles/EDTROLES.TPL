

<script type="text/javascript">

function GuardarRole(){
	
	 $.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
				 
				 setTimeout("document.forms.item(0).submit()",600);
	
}

</script>




<div id="alerta" class="alert alert-block " style="display:none;">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<h4 id="headAlerta" class="alert-heading">!CORRECTO!</h4>
							<p><div id="bodyAlerta">El plan estrategico se ha guardado correctamente.</div></p>
</div>


				<!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h1 class="left"> Editar rol de sistema
</h1><br>
<p>Los roles contienen permisos para administrar el sistema. 
						</p>
						
						
					</div>
					<!-- End Box Head -->	
                    
                    
                    <!-- Pagging -->
						
                        <div class="pagging">
                         <div class="left">
						 <i class="icon-asterisk"></i> Indica un campo obligatorio.</div>
                        <div class="right">
                        <a href="?execute=rolesadmin&method=default&Menu=F3&SubMenu=SF32#&p=1&s=25&sort=1&q=" class="btn btn-large">Cancelar</a>
						<button class="btn-warning btn-large" onclick="GuardarRole();">Guardar</button>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="box-content">
						<form class="form-horizontal" method="post" action="?execute=rolesadmin&method=Actualizar&Menu=F3&SubMenu=SF32#&p=1&s=25&sort=1&q=" name="frmaddniveles" id="frmaddniveles">
						  <fieldset>
							<legend>1.   Propiedades de rol </legend>
									
						 <input type="hidden" name="idrol" value="#IDROL#" />
								
							<div class="control-group">
								<label for="focusedInput" class="control-label"> <i class="icon-asterisk"></i>Nombre de rol:</label>
								<div class="controls">
								  <input type="text" value="#NOMBRE#" id="rol" name="rol" class="input-xlarge focused">
								</div>
							  </div>
							
							
							<div class="control-group">
								<label for="focusedInput" class="control-label">Tipo:</label>
								<div class="controls">
			                    <input type="radio" #DISPONIBLE# name="tipo" value="G" >&nbsp;General&nbsp;
                                <input type="radio" #NODISPONIBLE# name="tipo" value="P">&nbsp;Principal
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
                        <a href="?execute=rolesadmin&method=default&Menu=F3&SubMenu=SF32#&p=1&s=25&sort=1&q=" class="btn btn-large">Cancelar</a>
						<button class="btn-warning btn-large" onclick="GuardarRole();">Guardar</button>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
					
					
				</div>
				<!-- End Box -->
                  