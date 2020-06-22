 <script src="skins/default/js/planestrategico/adjuntos.js"></script>
 


<div id="alerta" class="alert alert-block " style="display:none;">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<h4 id="headAlerta" class="alert-heading">!CORRECTO!</h4>
							<p><div id="bodyAlerta">El plan estratégico se ha guardado correctamente.</div></p>
</div>


				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h1 class="left">#TITULO#</h1><br>
						
						
					</div>
					<!-- End Box Head -->	
             
                    
                    <!-- Pagging -->
						
                     
                      
                        <div class="pagging">
                         <div class="left" id="menucontent">
                       
                       <ul class="subMenu" style="margin-top:15px;">
                       <li ><a href="#MENUURL#">Líneas y Objetivos</a></li>
                       <li class="active"> <a href="#">Documentos Adjuntos</a></li>
                     
                       </ul>
                       
						 </div>
                        <div class="right">
                        <a href="?execute=principal&method=default&Menu=F1&SubMenu=SF11#&p=1&s=25&sort=1&q=" class="btn btn-large"><i class="icon-chevron-left"></i>  Regresar</a>
					
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="box-content-2">
                   
                       
                       <!-- Content RIGHT -->
			<div id="contentright">
				
               <!--End Alerta -->


<!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						
						<div class="right">                            
                            
							
							<!--#URLUPLOAD#-->
							
							
							
						</div>
						
                        <div class="left" >
                        <input type="text" name="searchbar" id="searchbar" style="margin-top:8px"   />
							<button class="btn btn-small" id="search_go-button-pe"><i class="icon-search"></i> Buscar</button>
						
						</div>
						
					</div>
					<!-- End Box Head -->	
                    
                    
                    <!-- Pagging -->
                        <div class="pagging" id="pagginghead">         
                        <div class="left">  
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
						
                    
                    
					<!-- results-panel -->
					<div id="results-panel">
					
	
	
	
	
	
	
	
	
	              </div>				
					<!-- results-panel -->
					
					
					
					
						
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
               
				

			</div>
			<!-- End Conten RIGHTt -->
			
             <div id="sidebar">
        <!-- Box -->
				<div class="box">
					
					<!-- Box Head -->
					<div class="box-head">
						<h2><i class="icon-search"></i>&nbsp;Acotar Búsqueda</h2>
					</div>
					<!-- End Box Head-->
					
                    
                    <!-- Box Content-->
					<div>
						
                        
                <div id="category-filter">
					<ul>
                    
    
     <li>
    <li>
    <input type="checkbox" class="any" id="all" value="all" onclick="filtrarTodo(this.id);" name="all" checked="checked">
    Todo
    </li>                
     <li>
     <input id="AUD" class="any" type="checkbox" onclick="filtrar(this.id);" value="AUD" name="tipos[]">
Audio
     </li>
	 <li>
     <input id="VID" class="any" type="checkbox" onclick="filtrar(this.id);" value="VID" name="tipos[]">
Videos
     </li>
     
     <li>
     <input id="IMG" class="any" type="checkbox" onclick="filtrar(this.id);" value="IMG" name="tipos[]">
Imágenes
     </li>
     
	<li>
    <input type="checkbox" class="any" id="DOCS" value="DOCS" onclick="archivos(this.id);" name="DOCS" >
    Documentos / Archivos
    
	<ul>
	<li><input type="checkbox" class="any" id="PPT" value="PPT" onclick="filtrar(this.id);" name="tipos[]">
    Presentaciones</li>
	<li><input type="checkbox" class="any" id="DOC" value="DOC" onclick="filtrar(this.id);" name="tipos[]">
    Word</li>
	<li><input type="checkbox" class="any" id="XLS" value="XLS" onclick="filtrar(this.id);" name="tipos[]" >
    Excel</li>
    <li><input type="checkbox" class="any" id="PDF" value="PDF" onclick="filtrar(this.id);" name="tipos[]" >
    Pdf</li>
    <li><input type="checkbox" class="any" id="ZIP" value="ZIP" onclick="filtrar(this.id);" name="tipos[]" >
    Zip</li>
	</ul>
	</li>
	
</ul>



		</div>				
						
					</div>
                    <!-- End Box Content-->
                    
				</div>
				<!-- End Box -->
        </div>
                       
                       
                       
                       
                       
						

					</div>
					<!-- Table -->
					
					
					 <!-- Pagging -->
						
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
              		
                        <div class="right">
                      <a href="?execute=principal&method=default&Menu=F1&SubMenu=SF11#&p=1&s=25&sort=1&q=" class="btn btn-large"><i class="icon-chevron-left"></i>  Regresar</a>
						
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
					
					
				</div>
				<!-- End Box -->           
                  