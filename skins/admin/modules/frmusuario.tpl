<script src="skins/admin/js/usuarios.js" type="text/javascript"></script>

<form enctype="multipart/form-data" method="post" id="frmusuarios" action="index.php?execute=usuarios&handle=usuarios&action=view&method=saveUsuarios" target="iframe-post-form"> 
                        
                          <fieldset style="width:48%; float:left; margin-right: 3%;"> 
							<label>Rol:</label>
								<select style="width:92%;" name="cborol" id="cborol">
								<option value="ADM">Administrador</option>
								<option value="PFS">Profesor</option>
                                <option value="ELC">Enlace</option>
								<option value="IVT">Invitado</option>
							</select>
						</fieldset>
                        
                        
                        <fieldset style="width:32%; height:150px; right:40px; margin-right:24px; position:absolute; float:right;"> 
                        
                        <label>Avatar</label>
							<input type='file' style="position:relative; display:none; left:10px;" id="imagearticulo" name="imagearticulo" onchange="readURL(this);" />
                            <img id="thumbailarticulo" src="skins/admin/images/avatar-anonimo.png" style="position:relative; right:70px; top:30px;" />
						<input type="button" id="btncancelimage" class="btncancel" style="position: relative; float: right; margin-right: 100px; top: 10px; " value="Cambiar" />
							
						</fieldset>
                        
                        
                        
                     
                        <fieldset style="width:48%; float:left; margin-right: 3%;"> 
							<label style="width:70px; margin-top:2px; text-align:right;">Usuario:</label>
							<input type="text" name="txtusuario" id="txtusuario" style="width:22%; float:left;">
                         	<div class="clear"></div>
                            <label style="width:70px; margin-top:2px; text-align:right;">Password:</label>
                          <input type="text" name="txtpassword" id="txtpassword" style="width:22%; float:left;">
						</fieldset>
                        
						
                     
                     
                     
                        
                         <fieldset style="width:48%; float:left; margin-right: 3%;"> 
							<label style="width:70px; margin-top:2px; text-align:right;">Nombre:</label>
							<input type="text" name="txtnombre" id="txtnombre" style="width:60%;">
						</fieldset>
                        
						<fieldset style="width:48%; float:left;"> 
							<label style="width:70px; margin-top:2px; text-align:right;">Apellidos:</label>
                          <input type="text" name="txtapellidos" id="txtapellidos" style="width:70%;">
						</fieldset>	
						
						
				        <fieldset style="width:48%; float:left; margin-right: 3%;"> 
							<label>Universidad:</label>
							<select style="width:92%;" name="cbouni" id="cbouni">
						<option value="UAN">Universidad Anáhuac Mexico Norte</option>
						<option value="UAS">Universidad Anáhuac Mexico Sur</option>
						<option value="UAO">Universidad Anáhuac Oaxaca</option>
                        <option value="UAC">Universidad Anáhuac Cancun</option>
                        <option value="UAP">Universidad Anáhuac Puebla</option>
                        <option value="UAQ">Universidad Anáhuac Queretaro</option>
                        <option value="UAM">Universidad Anáhuac Mayab</option>
							</select>
						</fieldset>
                        
						<fieldset style="width:48%; float:left;"> 
							<label style="width:70px; margin-top:2px; text-align:right;">Email:</label>
                          <input type="text" name="txtmail" id="txtmail" style="width:50%;">
						</fieldset>		
					

						
					
						<div class="clear"></div>
						
						<div class="submit_link">
					
					<input type="submit" value="Guardar" id="btn_save_articulo" class="alt_btn">
					<input type="submit" value="Reset">
					
				</div>
</form>