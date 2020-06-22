 <script src="skins/default/js/planesoperativo/asignarusuario.js"></script>


<div id="alerta" class="alert alert-block " style="display:none;">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<h4 id="headAlerta" class="alert-heading">!CORRECTO!</h4>
							<p><div id="bodyAlerta">El plan estrategico se ha guardado correctamente.</div></p>
</div>

				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h1 class="left">Asignar Usuario al Plan Operativo</h1><br>
						<p>Los usuarios que dispongan de una cuenta existente en el sistema se podrán asignar al plan. Haga clic en Examinar para buscar usuarios.
						</p>
						
					</div>
					<!-- End Box Head -->	
                     
                    <!-- Pagging -->
			
                        <div class="pagging">
                         <div class="left">
						 <i class="icon-asterisk"></i> Indica un campo obligatorio.</div>
                        <div class="right">
					
                        <a href="#URLCANCELAR#" class="btn btn-large">Cancelar</a>
						<input type="button" id="btnenviaform1"  class="btn-warning btn-large" value="Enviar">
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="box-content">
						<div class="form-horizontal">
						
						
						  <form enctype="multipart/form-data" name="frmaddusuarios" method="post" id="frmaddusuarios" action="?execute=planesoperativo/asignarusuario&Menu=F3&SubMenu=SF8&method=GuardarUsuario" target="iframe-post-form">  
                          <fieldset>
							<legend>1.   Asignar usuarios</legend>
								
					Introduzca uno o varios nombres de usuario. Si introduce varios nombres de usuario, sepárelos mediante comas. Haga clic en Examinar para efectuar una búsqueda.
							
							<div class="control-group">
				<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Usuarios:</label>
								<div class="controls">
								
								<input  type="hidden" name="idplan" value="#IDPLAN#"/>
								<input  type="hidden" name="jerarquia" value="#JERARQUIA#"/>
								  <input type="text" value="" name="usuarios" id="usuarios" class="input-xlarge focused">
		<input type="button" id="btnenviaform1"  class="btn-warning btn-small" onclick="AsignarUsuarios()" value="Examinar">
								</div>
							  </div>
							
							
							<div class="control-group">
				<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Rol</label>
								<div class="controls">
						
						<select name="roles" id="roles">
		                        #ROLES#
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
                        <a href="#URLCANCELAR#" class="btn btn-large">Cancelar</a>
						<input type="button" id="btnenviaform2" class="btn-warning btn-large" value="Enviar"/>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
					
					
				</div>
				<!-- End Box -->     
				
				
				
				
				
				
<!--MODAL PLANES ESTRATEGICOS-->
<div class="modal hide fade" id="myModalplanese" style="width:700px; ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<span id="titlemodalplane">Elige los usuarios para asignar:</span>
			</div>
			<div class="modal-body">
				
                <!-- BUSQUEDA DE PLANES ESTRATEGICOS-->
                
              
                    
                    
                    <!-- Pagging -->
                        <div class="pagging" id="paggingheadModal">         
                        <div class="left">  
            <input type="text" name="searchbar" id="search_go-button-pe"    />
							<button class="btn btn-small"  id="search_go-button-pe"><i class="icon-search"></i> Buscar</button>
                        </div>
                        
                        <div class="bar_seperator"></div>
                        
       <div id="search_page_size-panel">
        <div id="page_size_25-panel2" onClick="showLimitPage2(25,this);" class="page_size_25 page_size_25-selected"></div>
		<div id="page_size_50-panel2" onClick="showLimitPage2(50,this);" class="page_size_50"></div>
        <div id="page_size_100-panel2" onClick="showLimitPage2(100,this);" class="page_size_100"></div>
        <div id="page_size_200-panel2" onClick="showLimitPage2(200,this);" class="page_size_200"></div>
	 </div>
                        
             
             
             
             
  
               <div class="search_pagination">
               <!-- <button class="btn btn-small" style="float:left; margin-right:10px;"><i class="icon-list-alt"></i> Mostrar Todos</button>-->
                <div class="page_button left button_disable"></div> 
                <div class="page_overview_display">
                <input type="text" class="page_number-box"  value="1">&nbsp;de&nbsp;1
                </div>
               <div class="page_button right button_disable"></div>
	            </div>    
                        
                        
                        </div>
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="tableModal" style="min-height: 250px; height: 250px; overflow-y: auto;">
						<table width="100%"  border="0" cellspacing="0" cellpadding="0">
							<thead>
							<tr>
							
							   <th width="5%">&nbsp;</th>
							   <th width="20%">Foto</th>
								<th width="30%" align="left">Nombre</th>
								<th width="30%" align="left">Apellidos</th>
                                <th width="15%">Centro</th>
                                
							</tr>
							</thead>
							 <tbody id="results-panel-Modal">
							
							
							</tbody>
							
						</table>
						</div>
					<!-- Table -->
						
						  <!-- Pagging -->
						
                        <div class="pagging" id="barfilterfooterModal">
                       
                     
                       <div class="search_pagination">
                       
                     
                       
                       <div class="page_button left button_disable">
                       </div> <div class="page_overview_display">
          <input type="text" class="page_number-box"  value="1">
          &nbsp;de&nbsp;1</div><div class="page_button right button_disable"></div> 
	                  </div>                       
                        
                          <div class="left"> 
                        <div id="results_textModal">
               0 resultados
               </div>
               </div>
                        
                        </div>
						<!-- End Pagging -->
						
					
					
				
                <!-- END BUSQUEDA DE PLANES ESTRATEGICOS-->
                
                
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
				<a href="#" id="aceptarmodalpe"  class="btn btn-warning">Aceptar</a>
			</div>
		</div>

<!--END MODAL PLANES ESTRATEGICOS-->
				
				
				
				      
                  