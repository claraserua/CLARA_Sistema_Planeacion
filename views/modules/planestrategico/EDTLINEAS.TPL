 <script src="skins/default/js/planestrategico/editplanestrategico.js"></script>
 
 
  <link href="skins/default/css/jquery.iphone.toggle.css" rel="stylesheet">
 
 
 <script src="skins/default/js/jquery.iphone.toggle.js"></script>
 
 
 <style type="text/css">
 
 .iPhoneCheckContainer{
 	width: 97px !important;
 }
 
 .iPhoneCheckLabelOff{
 	width: 97px !important;
 }
 
 .iPhoneCheckLabelOff span{
 	margin-right: 0px !important;
 }
 

 
 .iPhoneCheckLabelOn{
 	width: 54px !important;
 }
 
 .iPhoneCheckHandle{
 	width: 41px !important;
 }
 
 </style>
 
 


<div id="alerta" class="alert alert-block " style="display:none;">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<h4 id="headAlerta" class="alert-heading">!CORRECTO!</h4>
							<p><span id="bodyAlerta"> Indica un campo obligatorio.</span></p>
</div>


				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h1 class="left">Editar: #TITULO#</h1><br>
						<p> <i class="icon-asterisk"></i> Indica un campo obligatorio.
						</p>
						
					</div>
					<!-- End Box Head -->	
             
                    
                    <!-- Pagging -->
						
                     
                      
                        <div class="pagging">
                         <div class="left">
                         
                         <ul class="Menu" style="margin-top:15px;">
                       <li><a href="#MENUURL#">Propiedades</a></li>
                       <li id="active"> L&iacute;neas y Objetivos</li>
                     
                       </ul>
                         
						 </div>
                        <div class="right">
                        <a href="?execute=principal&method=default&Menu=F1&SubMenu=SF11#&p=1&s=25&sort=1&q=" class="btn btn-large">Salir</a>
						<input type="button" onclick="Salvar()" class="btn-warning btn-large" value="Guardar">
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
						
                    
					
					
                    
					<!-- Table -->
					<div class="box-content">
						<div class="form-horizontal">
                          <fieldset>
						  
                          <div class="box" id="linea0" style="display: none" >
                            <legend id="legenda0">1.   Línea Estrategica 
                            
                            
                             </legend>
									
                             <div class="well"> 
							<div class="control-group">
                            
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Título:</label>
								<div class="controls">
								 
				<textarea id="titulo0" class="input-xlarge focused" name="titulo" style="width:700px;" ></textarea>
								  
								</div>
							  </div>
                              </div>
							
							 
							 <legend>Objetivos estratégicos:</legend>
							 
							  <div class="well" style="padding: 10px;">                
							
							
							
							<!--=====================INICIO===================-->
							
							<div id="L0-controlobjetivo1" class="objetivoe">
								<div class="controls" style="margin-bottom:30px; margin-left: 140px;">							
								    <div class="form-group" style="">
										<label><b><font size="2">Objetivo:</font></b></label>							
									   <div class="input-prepend">
										  <span id="textobjetivo00" class="add-on">1</span>					
										 <textarea style="width:770px;" name="L0-objetivo" id="L0-objetivo1"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;
										 
									   </div>									   
									</div>          
                                      									
								</div>
								
								
								
								
								
  	 
	    <div style="margin-bottom:40px;">
         <span colspan="2" >
	   
        <div class="box-icon">
          <a href="javascript:void(0)" onclick="ToogleOE(0,0);" class="btn btn-minimize btn-round" id="TOGOE-L0-objetivo1"><i class="icon-chevron-down"></i> Indicador de objetivo</a>						
        </div>		   
		  <div class="box-objectivos" id="BOXOBJETIVOE-L0-objetivo1" style="display: none;">	
	  
				  <div class="wellstrong" style="padding: 10px; margin-right: -10px;"><h2>Indicadores Objetivos: </h2>
					   <div class="well" style="padding: 10px;" id="WL0-objetivo1-indicador1">
										 <div id="L0-controlobjetivo1-controlindicador1" class="control-group">
												 <div class="controls">									   
														<div class="form-group" style="margin-left: -165px; float: left; margin-right: 10px;">
														   <label><b><font size="2">Indicador:</font></b></label>										   
														   <div class="input-prepend">
															 <span id="textindicador000" class="add-on">1</span>
															 <textarea style="width:524px; height:66px;" name="L0-objetivo" id="L0-objetivo1-indicador1"></textarea>
														   </div>										
													    </div>
																			
													   <div class="" style="float: left;">							
														    <div class="form-group" style="">
																<label><b><font size="2">Meta al 2024:</font></b></label>																																		
																<textarea style="width:402px; height:66px;" name="L0-meta" id="L0-objetivo1-meta1"></textarea>																							   
														    </div>                                									
													   </div>									   
													   
													   
												</div>
										 </div>
										 
						</div><!--fin well ind -->
						
						<div class="controls">                              
           <button style="float:left; margin-right:10px;" onclick="EliminarIndice(this.id);" id="EIL0-O1"  class="btn btn-small" disabled="disabled" ><i class="icon-remove"></i> Eliminar Indice</button>                                
                             <a class="btn btn-small" onclick="agregarIndice(0,0);" id="AIL0-O1" href="javascript:void(0)"><i class="icon-plus"></i> Agregar Indice</a>
                          </div>
						
						
						
				   </div><!--fin wellstrong ind -->
			 
			 </div><!--BOXOBJETIVOE hide visible-->
	     </span>
	 </div><!--<div><span>&nbsp;</span></div>-->
	 
	 </div><!--Ln-controlobjetivon objetivo -->
							
							
							
							<!--=============================FIN=========================-->
                            
                           
                            
                            
                            <div class="controls">
                            
                               
           <button class="btn btn-small" disabled="disabled" id="OL0"  onclick="EliminarObjetivo(this.id);" style="float:left; margin-right:10px;"><i class="icon-remove"></i> Eliminar Objetivo</button>
                                        
                                        
                             <a href="javascript:void(0)" id="L0" onclick="agregarObjetivo(this.id);" class="btn btn-small"><i class="icon-plus"></i> Agregar Objetivo</a>
                            </div> <!-- fin de well de objetivo estrategico-->
                            </div> <!-- fin de none/block de la linea  -->
                             
                             
                             
                             
                             
                             </div>
                            <!--END BOX--> 	
							  
							  
							  #CONTENIDO#
							  
                               
                              
                              
						  </fieldset>
    
						</div>   

                      
                     
					</div>
					<!-- Table -->
					
					
					 <!-- Pagging -->
						
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
              		
                        <div class="right">
                        <a href="?execute=principal&method=default&Menu=F1&SubMenu=SF11#&p=1&s=25&sort=1&q=" class="btn btn-large">Salir</a>
						<input type="button" onclick="Salvar()" class="btn-warning btn-large" value="Guardar"/>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
					
					
				</div>
				<!-- End Box -->           
                  