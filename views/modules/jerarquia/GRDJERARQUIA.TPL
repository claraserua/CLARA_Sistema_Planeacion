<script src="skins/default/js/jerarquia/jerarquias.js"></script>

<!-- Alerta -->
<div id="alerta" class="alert alert-block " style="display:none;">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<h4 id="headAlerta" class="alert-heading">!CORRECTO!</h4>
							<p><div id="bodyAlerta">El plan estrategico se ha guardado correctamente.</div></p>
</div>

<!--End Alerta -->

<!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h2 class="left">#NIVEL#</h2><br>
					
						<p>Haga clic en los niveles para crear y administrar los nodos secundarios.. 
						<a href="#URL#"><button type="submit" class="btn btn-small btn-warning"><i class="icon-list icon-white"></i>&nbsp;Crear Nivel</button></a>
						</p>
					</div>
					<!-- End Box Head -->	
                    
                    
                    <!-- Pagging -->
                      <div class="pagging" id="pagginghead">         
                      
                        
                     
                        
       <div id="search_page_size-panel">
        <div id="page_size_25-panel" onclick="showLimitPage(25,this);" class="page_size_25 page_size_25-selected"></div>
		<div id="page_size_50-panel" onclick="showLimitPage(50,this);" class="page_size_50"></div>
        <div id="page_size_100-panel" onclick="showLimitPage(100,this);" class="page_size_100"></div>
        <div id="page_size_200-panel" onclick="showLimitPage(200,this);" class="page_size_200"></div>
	 </div>
                        
               <div class="bar_seperator"></div>
                        
               <div id="results_text">
               0 resultados
               </div>
                        
               
               <div class="search_pagination">
                
                <div class="page_button left button_disable"></div> 
                <div class="page_overview_display">
                <input type="text" class="page_number-box"  value="1">&nbsp;de&nbsp;1
                </div>
               <div class="page_button right button_disable"></div>
	            </div>    
                        
                        </div>
					<!-- End Pagging -->	
					<!-- Table -->
					<div class="table" style="min-height: 300px;">
						<table width="100%"  border="0" cellspacing="0" cellpadding="0">
							<thead>
							<tr>
							<th width="40px;">Logo</th>
							 <th width="30px;">ID</th>
							    <th>Nombre</th>
								 <th>Descripci&oacute;n</th>
								<th width="220" class="ac">Control</th>
							</tr>
							</thead>
							 <tbody id="results-panel">
							
							</tbody>
						</table>
						</div>
					<!-- Table -->
						
						  <!-- Pagging -->
                        <div class="pagging" id="barfilterfooter">
                    
                       <div class="search_pagination">
                       <div class="page_button left button_disable">
                       </div> <div class="page_overview_display">
                       <input type="text" class="page_number-box"  value="1">
          &nbsp;de&nbsp;1</div><div class="page_button right button_disable"></div> 
	                  </div>                       
                        
                        
                        </div>
						<!-- End Pagging -->
						
				</div>
				<!-- End Box -->