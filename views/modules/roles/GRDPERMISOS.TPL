 <script src="skins/default/js/roles/rolespermisos.js"></script>
 
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
						<h2 class="left">Privilegios de: #ROL#</h2><br>
				
						<p>Haga clic en las casillas de verificaci&oacute;n para seleccionar privilegios y, a continuaci&oacute;n, haga clic en Permitir privilegios o en Restringir privilegios.
						</p>
					</div>
					<!-- End Box Head -->	
                    
                     <div class="pagging">
                     <div class="left">
                     <input type="text" name="searchbar" id="searchbar" style="margin-top:8px;"   />
							<button class="btn btn-small" id="search_go-button-rolespermisos"><i class="icon-search"></i> Buscar</button>
                     </div>
                     
                     <div class="right" >
                     <a href="?execute=rolesadmin&method=default&Menu=F3&SubMenu=SF32#&p=1&s=25&sort=1&q=" class="btn btn-large"><i class="icon-chevron-left"></i> Regresar</a>
                     </div>
                     </div>
                    
                    
                    <!-- Pagging -->
                        <div class="pagging" id="pagginghead">         
                       
                        
                        <div class="btn-group" style="float:left;">
								  <a href="javascript:void(0)" class="btn btn-warning"><span title=".icon  .icon-white  .icon-arrowthick-s " class="icon icon-white icon-arrowthick-s"></span> Privilegios</a>
								  <a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn-warning"><span class="caret"></span></a>
								  <ul class="dropdown-menu">
									<li><a href="javascript:void(0)" onclick="permitirPermisos();"><i class="icon-ok"></i> Permitir Permiso</a></li>
									<li class="divider"></li>
									<li><a href="javascript:void(0)" onclick="restringirPermisos();"><i class="icon-ban-circle"></i> Restringir Permiso</a></li>
								  </ul>
								</div>
                        
                         <div class="bar_seperator"></div>
                       
                         <div class="left" style="margin-left:10px;">
                          <div id="sort-panel">  
	                  <select onchange="Ordenar(this.value)" name="sort" id="sort-menu">
                      <option value="1" selected="selected">Ordenar por: Reciente adición</option>
		              <option value="2">Ordenar por: Nombre</option>
		              <option value="3">Ordenar por: Apellidos</option>
                      </select>
                     
	                    </div>  
                        </div>
                        
                        <div class="bar_seperator"></div>
                        
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
                <button class="btn btn-small" style="float:left; margin-right:10px;"><i class="icon-list-alt"></i> Mostrar Todos</button>
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
                    <form name="form">
                      
						<table width="100%"  border="0" cellspacing="0" cellpadding="0">
							<thead>
							<tr>
								
								<th align="right" style="text-align:right;"><input type="checkbox" id="checkboxall" onclick="seleccionarTodo();" /></th>
								<th align="center" style="text-align:center;">Permitidos</th>
								<th>Permisos</th>
								<th>Descripci&oacute;n</th>
							</tr>
							</thead>
                          
							 <tbody id="results-panel">
							
							
							</tbody>
							
						</table>
                    </form>
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
						
					
                     <div class="pagging">
                     <div class="right" style="margin-top:0px;">
                     <a href="?execute=rolesadmin&Menu=F3&SubMenu=SF9#&p=1&s=25&sort=1&q=" class="btn btn-large"><i class="icon-chevron-left"></i> Regresar</a>
                     </div>
                     </div>
                    
                    
					
				</div>
				<!-- End Box -->
                
 