 <script src="skins/default/js/planesoperativo/estado.js"></script>



				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h1 class="left">Editar estadO Plan Operativo</h1><br>
						<p>La informaci&oacute;n sobre planes operativos esta asociada a un plan estrat&eacute;gico.</p>
						
					</div>
					<!-- End Box Head -->	
             
                    
                    <!-- Pagging -->
						
                     
                      
                        <div class="pagging">
                         <div class="left">
						 <i class="icon-asterisk"></i> Indica un campo obligatorio.</div>
                        <div class="right">
                        <a href="?execute=operativo&method=default&Menu=F2&SubMenu=SF21#&p=1&s=25&sort=1&q=" class="btn btn-large">Cancelar</a>
						<input type="button" id="btnenviaform1" onclick="GuardarPlanOperativo();" class="btn-warning btn-large" value="Guardar">
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="box-content">
						<div class="form-horizontal">
						<!--  <form enctype="multipart/form-data" name="frmaddplaneso" method="post" id="frmaddplaneso" action="?execute=planesoperativo/addplano&Menu=F1&SubMenu=SF4&method=GuardarPlan" target="iframe-post-form">  -->
                          <fieldset>
							<legend>1.   Informaci&oacute;n general</legend>
									
								
							<input type="hidden" value="#IDPLAN#" id="idplan" name="idplan" />
	<input type="hidden" value="#IDPlanEstrategico#" id="IDPlanEstrategico" name="IDPlanEstrategico" />						
							
							<div class="control-group">
                            
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Titulo:</label>
								<div class="controls">
								  <input type="text" value="#TITULO#" disabled="disabled" style="width:500px;" name="titulo" id="titulo" class="input-xlarge focused">
								</div>
							  </div>
							
							
							 
							 <legend>2.   Estado</legend>
							 
							 
							  <div class="control-group">
								
								<div class="controls">
								  
                               <input type="radio" #PENDIENTE# value="G" name="estado" class="input-xlarge focused">
							   &nbsp;<span class="label label-warning">Pendiente</span> <span class="label label-info">Elaborando</span><br/><br/>
                               <input type="radio" #REVISIONORUA# value="E" name="estado" class="input-xlarge focused">
							   &nbsp;<span class="label label-warning">Pendiente</span> <span class="label label-revision">Revisando</span><br/><br/>
                               <input type="radio" #REVISIONUNI# value="R" name="estado" class="input-xlarge focused">
							   &nbsp;<span class="label label-warning">Pendiente</span> <span class="label label-revision">Revisando Centro</span><br/><br/>
							   
							   
							   
							   
							  #PERIODOESTADO#<br>
							   
							   
							   <input type="radio" #TERMINADO# value="T" name="estado" class="input-xlarge focused">
							   &nbsp;<span class="label label-important">Terminado</span><br/>
							   
								</div>
							 </div>
                             
                             
							 
 
						  </fieldset>
                          <!--</form>-->
						</div>   

					</div>
					<!-- Table -->
					
					
					 <!-- Pagging -->
						
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
              		
                        <div class="right">
                        <a href="?execute=operativo&method=default&Menu=F2&SubMenu=SF21#&p=1&s=25&sort=1&q=" class="btn btn-large">Cancelar</a>
						<input type="button" id="btnenviaform2" onclick="GuardarPlanOperativo();" class="btn-warning btn-large" value="Guardar"/>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
					
					
				</div>
				<!-- End Box -->           
                  