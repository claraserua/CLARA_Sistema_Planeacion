 <script src="skins/default/js/planesoperativo/addplanesoperativo.js"></script>


<div id="alerta" class="alert alert-block " style="display:none;">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<h4 id="headAlerta" class="alert-heading">!CORRECTO!</h4>
							<p><div id="bodyAlerta">El plan estrategico se ha guardado correctamente.</div></p>
</div>


				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h1 class="left">#PLANESTRATEGICO# / Crear Plan Operativo</h1><br>
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
								  <input type="text" value="" style="width:500px;" name="titulo" id="titulo" class="input-xlarge focused">
								</div>
							  </div>
							
							
							<div class="control-group">
								<label for="focusedInput" class="control-label">Descripci&oacute;n :</label>
								<div class="controls">
				<textarea id="descripcion" name="descripcion" class="cleditor" rows="3" style="width: 500px; height: 140x;"></textarea>
								</div>
							  </div>
							 
							 <legend>2.   Disponibilidad</legend>
							 
							 
							  <div class="control-group">
								<label for="focusedInput" class="control-label"></i>Disponible:</label>
								<div class="controls">
								  
                                  Si&nbsp;<input type="radio" checked="checked" value="1" name="disponible" class="input-xlarge focused">
                                  	  No&nbsp;<input type="radio" value="0" name="disponible" class="input-xlarge focused">
                                  
								</div>
							 </div>
                             
                             
                             	 <legend>3.   Duraci&oacute;n</legend>
							 
							 
							 <div class="control-group">
							<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Fecha Inicio:</label>
								<div class="controls">  
                                <input type="text" value="" readonly="readonly" style="width:130px;" name="finicio" id="finicio" class="input-xlarge focused">
								</div>
							 </div>
                             
                             
                             <div class="control-group">
							<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Fecha Termino:</label>
								<div class="controls">  
                                <input type="text" value="" readonly="readonly" style="width:130px;" name="ftermino" id="ftermino" class="input-xlarge focused">
								</div>
							 </div>
							 
                             
                             
                             
                              <legend>4.   Periodos de Seguimiento</legend>
                             
                              <div class="box-objectivos" id="BOX-L0-C0">
      
       <div class="well">
       <table width="100%">
        <tbody><tr>
        <td width="30">&nbsp;	</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Titulo del Periodo:</td>
        <td>&nbsp;&nbsp;Fecha de Inicio:</td>
        <td>&nbsp;&nbsp;Fecha de Termino:</td>
        </tr>
         
        <tr id="P1">
        <td>&nbsp; </td>
        <td width="505">  
        <div class="input-prepend">
		<span class="add-on" id="LABEL-P1">1.</span>
        <input type="text" style="width:450px;" id="P1-S1">
		</div> 
        </td>                          
        <td width="135"><input type="text"  style="width:130px;" class="finicio" id="P1-I1"></td>
        <td><input type="text"  style="width:130px;" class="ftermino" id="P1-T1"></td>
        </tr>
                    
        <tr>	
        <td colspan="2">
        <div style="margin-left:30px;" class="left">           
        <button style="float:left; margin-right:10px;" onclick="EliminarPeriodo();" id="BEP" disabled="disabled" class="btn btn-small"><i class="icon-remove"></i> Eliminar Periodo</button>
                    
		
         <button onclick="AgregarPeriodo();" id="BAP" class="btn btn-small"><i class="icon-plus"></i>Agregar Periodo</button>				
		</div>            
        </td>
        </tr>
        </tbody></table>
        </div>
                  
				  
	    
		
		 <legend>5.   Nodo principal de jerarqu&iacute;a institucional</legend>
							  <p>Seleccione el nivel principal al que pertenece el plan operativo dentro de la jerarquia institucional.</p>
                              <div class="control-group">
                              <div class="controls">
                              #NODOSPRINCIPAL#
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
                  