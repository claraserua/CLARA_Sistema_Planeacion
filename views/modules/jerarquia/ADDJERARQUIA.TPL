
<script src="skins/default/js/jerarquia/addjerarquia.js"></script>

<script type="text/javascript">

function GuardarNivel(){
	
	if(document.getElementById('idnivel').value == "" || document.getElementById('nivel').value == ""){
		
		document.getElementById("alerta").style.display="block";
		$('html, body').animate({scrollTop:0}, 10);
	
	}else{
		
	 document.forms.item(0).submit();	
	}
	
 
}

</script>


<!-- Alerta -->
<div id="alerta" class="alert alert-block " style="display:none;">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<h4 id="headAlerta" class="alert-heading">!Advertencia!</h4>
							<p><div id="bodyAlerta">Debe de llenar los campos obligatorios.</div></p>
</div>

<!--End Alerta -->


				<!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h1 class="left"> Crear nivel
</h1><br>
<p>Los niveles sirven para administrar el nivel de acceso a las partes del sistema. 
						</p>
						
						
					</div>
					<!-- End Box Head -->	
                    
                    
                    <!-- Pagging -->
						
                        <div class="pagging">
                         <div class="left">
						 <i class="icon-asterisk"></i> Indica un campo obligatorio.</div>
                        <div class="right">
                        <a href="#URLCANCELAR#" class="btn btn-large">Cancelar</a>
						<button class="btn-warning btn-large" onclick="GuardarNivel();">Aceptar</button>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="box-content">
						<form class="form-horizontal" method="post" action="#URLFORMACTION#" enctype="multipart/form-data" name="frmaddniveles" id="frmaddniveles">
						  <fieldset>
							<legend>1.   Propiedades de nivel</legend>
                            
                            <input type="hidden" name="padre" value="#PADRE#" />
									
							   <div class="control-group">
								<label for="focusedInput" class="control-label">Logo:</label>
								<div class="controls">
								  <input type="file" style="display:none;" id="imagearticulo" name="imagearticulo" onchange="readURL(this);" />
                           <img id="thumbailarticulo" src="skins/admin/images/avatar-anonimo.png" />
							
							<input type="hidden" id="editimagen" name="editimagen" value="FALSE" />
							<input type="hidden" id="imageold" name="imageold" value="#IMAGENOLD#" />
							
							
							<a href="#" class="btn btn-small" id="btncancelimage"><i class="icon-picture"></i> Cambiar</a>

						
								</div>
							  </div>
									
                             <div class="control-group">
								<label for="focusedInput" class="control-label"> <i class="icon-asterisk"></i>ID de nivel:</label>
								<div class="controls">
								  <input type="text" value="" id="idnivel" onKeyUp="this.value=this.value.toUpperCase();" maxlength="15" style="width: 130px;" name="idnivel" class="input-xlarge focused">
								</div>
							  </div>
								
							<div class="control-group">
								<label for="focusedInput" class="control-label"> <i class="icon-asterisk"></i>Nombre de nivel:</label>
								<div class="controls">
								  <input type="text" value="" id="nivel" name="nivel" class="input-xlarge focused">
								</div>
							  </div>
							
							
							<div class="control-group">
								<label for="focusedInput" class="control-label">Descripci&oacute;n :</label>
								<div class="controls">
				<textarea id="descripcion" name="descripcion" class="cleditor" rows="3" style="width: 500px; height: 140x;"></textarea>
								</div>
							  </div>
							  
							  
							  
						  </fieldset>
						</form>   

					</div>
					<!-- Table -->
					
					
					 <!-- Pagging -->
						
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
              		
                        <div class="right">
                        <a href="#URLCANCELAR#" class="btn btn-large">Cancelar</a>
						<button class="btn-warning btn-large" onclick="GuardarNivel();">Aceptar</button>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
					
					
				</div>
				<!-- End Box -->
                  