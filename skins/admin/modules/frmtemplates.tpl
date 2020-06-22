<script src="skins/admin/js/fileManagerTemplates.js" type="text/javascript"></script>

<form enctype="multipart/form-data" method="post" id="frmtemplate" action="index.php?execute=fileManager&handle=fileManager&action=add&method=saveTemplate" target="iframe-post-form">                    
                     <fieldset>
							<label>Titulo:<span>*</span></label>
							<input type="text" name="txttitulotemplate" id="txttitulotemplate">
						</fieldset>
                        
                        <fieldset>
					         <label>Descripcion de la plantilla</label>
							<textarea id="txtdescripciontemplate" name="txtdescripciontemplate" rows="5"></textarea>
							
						</fieldset>
						
						<fieldset style="width:48%; float:left; margin-right: 3%;">
							<label style="width:70px;">Imagen</label>
							<input type='file' id="imagetemplate" name="imagetemplate"  onchange="readURLTemplate(this);" />
                            <img id="thumbailtemplate" src="#" style="display:none" />
						<input type="button" id="btncanceltemplate" class="btncancel" style="display:none" value="Eliminar" />
                        <br />
                        
						</fieldset>
                                              
                        
                        <fieldset style="width:48%; float:left;"> <!-- to make two field float next to one another, adjust values accordingly -->
							<label>Clasificación</label>
                            <select name="cboclasificaciontemplate" id="cboclasificaciontemplate" style="width:92%;">
								<option value="HTM">Plantillas HTML / Cursos</option>
                                <option value="PTS">Photoshop</option>
                                <option value="TPT">Power Point</option>
                                <option value="TWD">Word</option>
                                <option value="OHT">Plantillas HTML / jQuery</option>
                                <option value="OFL">Objetos Flash</option>
                                
                               
							</select>
						</fieldset>
						
                        
                       <fieldset  style="width:48%; float:left; margin-right: 3%;">
                       <label style="width:70px;">Plantilla</label>
				<input type='file' id="adjuntotemplate" name="adjuntotemplate"  />
                       </fieldset> 
                        
                        
					<fieldset  style="width:48%; float:left;">
                    <label>Autor</label>
					<input type="text" name="txtautortemplate" id="txtautortemplate">        
					</fieldset>
						
						<fieldset>
							<label>Disponibilidad</label><br /><br />
                            &nbsp; &nbsp; <input type="checkbox" name="checkdisponible" id="checkdisponible" checked="checked"  />
                            Establecer la plantilla como disponible<br /><br />   
                         </fieldset>
						
						

						
						<fieldset style="width:48%; float:left; margin-right: 3%;"> 
                            
                            <label>Disciplina</label>
							<select name="cbocdisciplina" id="cbocdisciplina" style="width:92%;">
								<option value="NO">NO PERTENECE</option>
								<option value="ACT">Actuaría</option>
                                <option value="ARQ">Arquitectura</option>
								<option value="CS">Ciencias de la Salud</option>
                                <option value="COM">Comunicación</option>
                                <option value="DER">Derecho</option>
                                <option value="DG">Diseño Gráfico</option>
                                <option value="ECO">Economía.</option>
                                <option value="FIL">Filosofía</option>
                                <option value="IDM">Idiomas</option>
                                <option value="ING">Ingeniería.</option>
                                <option value="MER">Mercadotecnia.</option>
                                <option value="NI">Negocios Internacionales</option>
                                <option value="PED">Pedagogía</option>
                                <option value="PSC">Psicología</option>
                                <option value="RI">Relaciones Internacionales</option>
                                <option value="TUR">Turismo</option>
							</select>
						</fieldset>
						<fieldset style="width:48%; float:left;"> <!-- to make two field float next to one another, adjust values accordingly -->
							<label>Tags</label><div class="clear"></div>
                            <input type="hidden" name="tags" id="tags" />
                            <div id="tags" class="ui-helper-clearfix">
							<input type="text" id="totag" style="width:92%;">
                            </div>
						</fieldset><div class="clear"></div>
						
						<div class="submit_link">
					
					<input type="submit" value="Agregar" id="btnsavearticulo" class="alt_btn">
					<input type="reset" value="Reset">
					
				</div>
                
                </form>
