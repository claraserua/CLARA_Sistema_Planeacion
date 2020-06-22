<script src="skins/admin/js/links.js" type="text/javascript"></script>

<form enctype="multipart/form-data" method="post" id="frmarticulos" action="#ACTIONFORM#" target="iframe-post-form">
  <input type="hidden" name="idarticulo" id="idarticulo" value="#IDARTICULO#" />                    
                     <fieldset>
							<label>Titulo:</label>
							<input type="text" name="txttitulo" id="txttitulo" #VALUETITULO#>
                          
						</fieldset>
                        
                         <fieldset>
							<label>URL:</label>
							<input type="text" name="txturl" id="txturl" #VALUEURL#><br /><br />
                            &nbsp; &nbsp; &nbsp; &nbsp;<input type="checkbox" name="check_blank" id="check_blank" #BLANK#  />
                            Abrir enlace en una nueva ventana
						</fieldset>
						
						<fieldset>
							<label>Imagen</label>
                              <input type="hidden" value="off" id="inputeditimage" name="inputeditimage"  />
							<input type='file' id="imagearticulo" name="imagearticulo" onchange="readURL(this);" #STYLEIMPUT# />
                            <img id="thumbailarticulo" src="#" style="display:none" />
						<input type="button" id="btncancelimage" class="btncancel" style="display:none" value="Eliminar" />
						</fieldset>
						
					<fieldset>
					         <label>Descripcion</label>
							<textarea id="txtdescripcion" name="txtdescripcion" rows="12"><!--#VALUEDESCRIPCION#--></textarea>
							<script type="text/javascript">
				               CKEDITOR.replace( 'txtdescripcion',
					{
						skin : 'office2003'
					});
			                 </script>
						</fieldset>
						
						<fieldset>
							<label>Disponibilidad</label><br /><br />
                            &nbsp; &nbsp; <input type="checkbox" name="checkdisponible" id="checkdisponible" #DISPONIBLE#   />
                            Establecer el enlace como disponible<br /><br />
                          
                           <div style="width:100%"><label> Mostrar desde:</label><input type="text" id="from" name="from" #VALUEFDESDE#   style="width:100px; margin-left:-70px;"><div><br /><br />
                           <div style="width:100%"> <label> Mostrar hasta:</label><input type="text" id="to" name="to" #VALUEFHASTA# style="width:100px; margin-left:-70px;"></div>	
                            </fieldset>
						
						

						
						<fieldset style="width:48%; float:left; margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
							<label>Categoria</label>
							<select name="cbocategoria" id="cbocategoria" style="width:92%;">
								 #CATEGORIAS#
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
					
					<input type="submit" value="Guardar" id="btnsavearticulo" class="alt_btn">
					<input type="reset" value="Cancelar" onclick="history.back(-1);">
					
				</div>
                
                </form>
