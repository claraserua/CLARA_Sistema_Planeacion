 <script src="skins/default/js/reportes/avancespe.js"></script>


<div id="alerta" class="alert alert-block " style="display:none;">
							<button type="button" class="close" data-dismiss="alert">Î</button>
							<h4 id="headAlerta" class="alert-heading">!CORRECTO!</h4>
							<p><div id="bodyAlerta">El plan estrategico se ha guardado correctamente.</div></p>
</div>

				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h1 class="left">Reporte de Avances del Plan Estrátegico </h1><br>
						<p>Se crea un reporte del avances del Plan Estrátegico.
						</p>
						
					</div>
					<!-- End Box Head -->	
                     
                    <!-- Pagging -->
			
                        <div class="pagging">
                         <div class="left">
						 <i class="icon-asterisk"></i> Indica un campo obligatorio.</div>
                        <div class="right">
                        <a href="?execute=reportespe&method=default&Menu=F1&SubMenu=SF13#&p=1&s=25&sort=1&q=" class="btn btn-large">Cancelar</a>
                        
                           <a  id="descargarE" href="?execute=planestrategico/reportes/descargar_avances&method=default&Menu=F2&SubMenu=SF23#&p=1&s=25&sort=1&q=" style="display:none;" on class="btn btn-large">Descargar Excel</a>
                        
						<input type="button" onclick="generarReporte();" id="btnenviaform1"  class="btn-warning btn-large" value="Generar">
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="box-content">
						<div class="form-horizontal">
						  <form enctype="multipart/form-data" name="frmaddusuarios" method="post" id="frmaddusuarios" action="?execute=usuarios/addusuarios&Menu=F3&SubMenu=SF8&method=GuardarUsuario" target="iframe-post-form">  
                          <fieldset>
							
		
							 
							  <legend>1.  Jerarquía Institucional</legend>
							  <p>Seleccione los niveles de los cuales desea generar el reporte.</p><br>
                              <div class="control-group">
                              <div class="controls">
                              #NODOS#
                              
                             
                              
                              
                              </div>
                              </div>
							 
						
						     
							  
							  
							  
						  </fieldset>
                          </form>
						</div>   

					</div>
					<!-- Table -->
					  <div id="danos" style="float: right;  position:absolute; top:360px; right: 130px;">
                               <label>Seleccione el Año:</label>
                              <select name="anos" id="anos" >
                               <option value="all">Todos</option>
							     <option value="2018">2018</option>
							    <option value="2017">2017</option>
                                <option value="2016">2016</option>
                               <option value="2015">2015</option>
                               <option value="2014">2014</option>
                               <option value="2013">2013</option>
                               <option value="2012">2012</option>
                               <option value="2011">2011</option>
                               <option value="2010">2010</option>
                               <option value="2009">2009</option>
                               <option value="2008">2008</option>
                               <option value="2007">2007</option>
                               <option value="2006">2006</option>
                               <option value="2005">2005</option>
                               <option value="2004">2004</option>                                
                               
                              </select> 
                              </div>
					
					 <!-- Pagging -->
						
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
              		
                        <div class="right">
                        <a href="?execute=reportespe&method=default&Menu=F1&SubMenu=SF13#&p=1&s=25&sort=1&q=" class="btn btn-large">Cancelar</a>
						<input type="button" id="btnenviaform2" onclick="generarReporte();" class="btn-warning btn-large" value="Generar"/>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
					
					
				</div>
				<!-- End Box -->           
                  