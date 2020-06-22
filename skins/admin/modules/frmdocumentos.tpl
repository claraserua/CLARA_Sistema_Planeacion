<script src="skins/admin/js/fileManagerDocumentos.js" type="text/javascript"></script>

<form enctype="multipart/form-data" method="post" id="frmdocumentos" action="index.php?execute=fileManager&handle=fileManager&action=add&method=saveDocumento" target="iframe-post-form">                    
                     <fieldset>
							<label>Titulo:<span>*</span></label>
							<input type="text" name="txttitulodoc" id="txttitulodoc">
						</fieldset>
                        
                        <fieldset>
					         <label>Descripcion del documento</label>
							<textarea id="txtdescripciondoc" name="txtdescripciondoc" rows="5"></textarea>
							
						</fieldset>
						
						<fieldset style="width:48%; float:left; margin-right: 3%;">
							<label style="width:70px;">Imagen</label>
							<input type='file' id="imagedoc" name="imagedoc"  onchange="readURLDoc(this);" />
                            <img id="thumbaildoc" src="#" style="display:none" />
						<input type="button" id="btncanceldoc" class="btncancel" style="display:none" value="Eliminar" />
                        <br />
                        
						</fieldset>
                                              
                        
                        <fieldset style="width:48%; float:left;"> <!-- to make two field float next to one another, adjust values accordingly -->
							<label>Clasificación</label>
                            <select name="cboclasificaciondoc" id="cboclasificaciondoc" style="width:92%;">
								<option value="PDF">PDF</option>
                                <option value="WRD">Word</option>
                                <option value="PWP">Power Point</option>
                                  <option value="EBO">eBOOKS</option>
							</select>
						</fieldset>
						
                        
                       <fieldset  style="width:48%; float:left; margin-right: 3%;">
                       <label style="width:70px;">Documento:<span>*</span></label>
				<input type='file' id="adjuntodoc" name="adjuntodoc"  />
                       </fieldset> 
                        
                        
					<fieldset  style="width:48%; float:left;">
                    <label>Autor:<span>*</span></label>
					<input type="text" name="txtautorvideo" id="txtautorvideo">        
					</fieldset>
						
						<fieldset>
							<label>Disponibilidad</label><br /><br />
                            &nbsp; &nbsp; <input type="checkbox" name="checkdisponible" id="checkdisponible" checked="checked"  />
                            Establecer el video como disponible<br /><br />   
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
