 <script src="skins/default/js/planestrategico/addplanestrategico.js"></script>


<div id="alerta" class="alert alert-block " style="display:none;">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<h4 id="headAlerta" class="alert-heading">!CORRECTO!</h4>
							<p><div id="bodyAlerta">El plan estrategico se ha guardado correctamente.</div></p>
</div>


				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h1 class="left">#TITULOPLAN#</h1><br>
						<p>Agregue las lineas estrat&eacute;gicas y objetivos estrat&eacute;gicos correspondientes al plan. 
						</p>
						
					</div>
					<!-- End Box Head -->	
             
                    
                    <!-- Pagging -->
						
                     
                      
                        <div class="pagging">
                         <div class="left">
						 <i class="icon-asterisk"></i> Indica un campo obligatorio.</div>
                        <div class="right">
                        <a href="?execute=principal&Menu=F1&SubMenu=SF4#&p=1&s=25&sort=1&q=" class="btn btn-large">Cancelar</a>
						<input type="button" onclick="Salvar();" class="btn-warning btn-large" value="Guardar">
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="box-content">
						<div class="form-horizontal">
                          <fieldset>
                            <div class="box" id="linea0" >
                            
                             <div class="box-head" >
						<h2 class="left"> <span id="legenda0">Línea estratégica 1</span></h2>
						
					</div>
                            
                            
                        
									
                             <div class="well"> 
							<div class="control-group">
                            
								<label for="focusedInput" class="control-label"><i class="icon-asterisk"></i>Titulo:</label>
								<div class="controls">
	
			
			
			<textarea  style="width:700px;" name="titulo" id="titulo0" class="input-xlarge focused"></textarea>
								</div>
							  </div>
                              </div>
							
							 
							 <legend><small style="color:#000000;">Objetivos estrat&eacute;gicos:</small></legend>
							 
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
																<label><b><font size="2">Meta:</font></b></label>																																		
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
                            </div>
                            </div>
                             
                             
                             
                             
                             
                             </div>
                            <!--END BOX--> 	
							  
                               <div class="right">
                               
 
  <button class="btn btn-large" disabled="disabled" id="btndeleteline" onclick="EliminarLinea();" style="float:left; margin-right:10px;"><i class="icon-remove"></i> Eliminar Linea</button>
                               
<a href="javascript:void(0)" onclick="agregarLinea();" class="btn btn-large"><i class="icon-plus"></i> Agregar Linea</a>
                          
                          </div>
                              
                              
						  </fieldset>
    
						</div>   

					</div>
					<!-- Table -->
					
					
					 <!-- Pagging -->
						
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
              		
                        <div class="right">
                        <a href="?execute=principal&Menu=F1&SubMenu=SF4#&p=1&s=25&sort=1&q=" class="btn btn-large">Cancelar</a>
						<input type="button" onclick="Salvar();" class="btn-warning btn-large" value="Guardar"/>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
					
					
				</div>
				<!-- End Box -->           
                  