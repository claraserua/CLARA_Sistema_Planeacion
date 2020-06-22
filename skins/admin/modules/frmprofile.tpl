<script src="skins/admin/js/profile.js" type="text/javascript"></script>

<form enctype="multipart/form-data" method="post" id="frmprofile" action="index.php?execute=profile&handle=profile&action=view&method=updateProfile" target="iframe-post-form">
                        
                         <fieldset style="width:48%; float:left; margin-right: 3%;"> 
							<label>Rol:</label>
								<select style="width:92%;" name="cborol" id="cborol">
								#ROL#
							</select>
						</fieldset>
                        
                        
                        <fieldset style="width:32%; height:150px; right:40px; margin-right:24px; position:absolute; float:right;"> 
                        
                        <label>Avatar</label>
							#IMAGEN#
						</fieldset>
                        
                        
                        
                     
                        <fieldset style="width:48%; float:left; margin-right: 3%;"> 
							<label style="width:70px; margin-top:2px; text-align:right;">Usuario:</label>
							<input type="text" value="#USUARIO#" name="txtusuario" id="txtusuario" style="width:22%; float:left;">
                         	<div class="clear"></div>
                            <label style="width:70px; margin-top:2px; text-align:right;">Password:</label>
                          <input type="text" value="#PASSWORD#" name="txtpassword" id="txtpassword" style="width:22%; float:left;">
						</fieldset>
                        
						
                     
                     
                     
                        
                         <fieldset style="width:48%; float:left; margin-right: 3%;"> 
							<label style="width:70px; margin-top:2px; text-align:right;">Nombre:</label>
							<input type="text" value="#NOMBRE#" name="txtnombre" id="txtnombre" style="width:60%;">
						</fieldset>
                        
						<fieldset style="width:48%; float:left;"> 
							<label style="width:70px; margin-top:2px; text-align:right;">Apellidos:</label>
                          <input type="text" name="txtapellidos" value="#APELLIDOS#" id="txtapellidos" style="width:70%;">
						</fieldset>	
						
						
				        <fieldset style="width:48%; float:left; margin-right: 3%;"> 
							<label>Universidad:</label>
							<select style="width:92%;" name="cbouni" id="cbouni">
						    #UNIVERSIDADES#
							</select>
						</fieldset>
                        
						<fieldset style="width:48%; float:left;"> 
							<label style="width:70px; margin-top:2px; text-align:right;">Email:</label> 
                          <input type="text" name="txtmail" id="txtmail" value="#EMAIL#" style="width:50%;">
						</fieldset>		
					

						
					
						<div class="clear"></div>
						
						<div class="submit_link">
					
					<input type="submit" value="Guardar" id="btn_save_profile" class="alt_btn">
					<input type="button" value="Cancelar" onclick="history.back(-1);">
					
				</div>
</form>