 <script src="skins/default/js/planesoperativo/addobjetivos.js"></script>
 <script type="text/javascript" src="skins/default/js/comentarios/jquery.watermarkinput.js"></script>

<div id="alerta" class="alert alert-block " style="display:none;">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<h4 id="headAlerta" class="alert-heading">!CORRECTO!</h4>
							<p><div id="bodyAlerta">El plan estrategico se ha guardado correctamente.</div></p>
</div>

#ALERTAACTIVO#



				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h1 class="left">#TITULOPLAN#</h1>
						<span class="right">#ESTADO#</span>
						<br>
						<p>Agregue las lineas estratégicas y objetivos estratégicos correspondientes al plan. 
						</p>
						
					</div>
					<!-- End Box Head -->	
             
                    
                    <!-- Pagging -->
						
                     
                      
                        <div class="pagging">
                         <div class="left" id="menucontent">
                        
                       <ul class="subMenu" style="margin-top:15px;" id="myTablab">
                       <li class=""><a href="#lineasyobjetivos">Líneas y Resultados</a></li>
                       <!--#FRESUMENEJECUTIVO#-->
                       </ul>
                         
                         </div>
                        <div class="right">
                        <a href="?execute=operativo&method=Salir&Menu=F2&SubMenu=SF21#SALIDA##&p=1&s=25&sort=1&q=" class="btn btn-large"><i class="icon-thumbs-down"></i> Salir</a>
						
						
						<!--#BTNGUARDAR#-->
						
						<!--#BTNENVIARREVISION#--> 
                        
                        
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
						
                    
                    
					<!-- CONTENT LINEA -->
                    <div id="TabContent" class="tab-content">
					 
                     <div class="tab-pane" id="lineasyobjetivos">
                     <div class="box-content">
              
                     <!--====================OBJETIVO=====================--> 
  <div id="L0-C0" class="wellstrong" style="display:none;">
                         
   <table width="100%">
       <tbody>
	   
	   <tr>
	   <td colspan="2"><b><font size="2">Objetivo Estratégico: </font></b>
       <select style="width:100%;" id="L0-OE0"> <option>L1 Objetivo estrategico 1</option> <option>L1 Objetivo estrategico 2</option> <option>L1 Objetivo estrategico 3</option> <option>L1 Objetivo estrategico 4</option> <option>L1 Objetivo estrategico 5</option></select></td>	
	   </tr>
	   
	   <tr>
       <td><b><font size="2">Resultado:</font></b></td>
       <td><b><font size="2"> Responsable:</font></b></td>
       </tr>
                    
       <tr>
       <td  width="70%">   
		<div class="input-prepend"> 
		   <span class="add-on" id="LABEL-L0-O0">1.1</span>
          <!-- <input type="text"  style="width:90%;" id="L0-O0">-->
		    <textarea name="resultado" style="width:90%;" id="L0-O0"></textarea>
		   
		</div>
       </td>
       <td  width="30%"><select id="L0-OR0" style="width:100%;">#RESPONSABLES# </select> </td>
       </tr>
       </tbody></table>
                    
      <div class="box-icon">
<a href="javascript:void(0)" onclick="Toogle(this.id);"  id="TOG-L0-C0" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>						
</div>
	  
	  
      <div class="box-objectivos" id="BOX-L0-C0">
      
       <div class="well">
       <table width="100%">
        <tbody><tr>
        <td width="2%">&nbsp;	</td>
        <td width="70%"><b><font size="2">Medios</font></b></td>
        <td width="28%"><b><font size="2">Responsable</font></b></td>
        </tr>
         
        <tr id="L0-O0-M0-C0">
        <td>&nbsp; </td>
        <td>  
        <div class="input-prepend">
		<span class="add-on" id="LABEL-L0-O0-M0">1.1.1</span>
       <!-- <input type="text" style="width:470px;" id="L0-O0-M0">-->
		<textarea name="medio" style="width:86%;" id="L0-O0-M0"></textarea>
		</div> 
        </td>                          
        <td><select id="L0-O0-M0-R0"> #RESPONSABLES# </select></td>
        </tr>
                    
        <tr>	
        <td colspan="2">
        <div style="margin-left:30px;" class="left">           
        <button style="float:left; margin-right:10px;" onclick="EliminarMedio(this.id);" id="BEM-L0-O0" disabled="disabled" class="btn btn-small"><i class="icon-remove"></i> Eliminar medio</button>
                    
		
         <button onclick="AgregarMedio(this.id);" id="BAM-L0-O0" class="btn btn-small"><i class="icon-plus"></i>Agregar Medio</button>				
		</div>            
        </td>
        </tr>
        </tbody></table>
        </div>
                      
                      
                      
         <div class="well">
         <table width="100%">
         <tbody><tr>
         <td width="30">&nbsp;	</td>
         <td><b><font size="2">Evidencias</font></b></td>            
         </tr>           
          
          <tr id="L0-O0-E0-C0">
          <td>&nbsp; </td>       
          <td>  
          <div class="input-prepend">
		  <span class="add-on" id="LABEL-L0-O0-E0">1.1.1</span>
          <input type="text" style="width:470px;"  id="L0-O0-E0">
		  </div> 
          </td>
          </tr>
                    
          <tr>
          <td colspan="2">
          <div style="margin-left:30px;" class="left">         
          <button style="float:left; margin-right:10px;" onclick="EliminarEvidencia(this.id);" id="BEE-L0-O0" disabled="disabled" class="btn btn-small"><i class="icon-remove"></i> Eliminar Evidencia</button>
	      <button onclick="AgregarEvidencia(this.id);" id="BAE-L0-O0"  class="btn btn-small"><i class="icon-plus"></i>Agregar Evidencia</button>			
		  </div>
          </td>
          </tr>     
          </tbody></table>
          </div> 
                     </div>
          
          
          </div>
<!--====================END OBJETIVO=====================-->
                     
                     
						#CONTENIDO#
					    </div>
					<!-- END CONTENT LINEA -->
                    </div>
                    
                    <div class="tab-pane" id="resumen">
                     <div class="box-content">
                     
                     
                     <p style="padding:10px; background:#F5F5F5; border: 1px solid rgba(0, 0, 0, 0.05);">En este apartado, se exponen las Áreas de oportunidad y Fortalezas de la universidad al inicio del año. El equipo directivo de la Oficina de la Red de Universidades Anáhuac retroalimentará el plan en general.</p>
                     
                      <!--#VALUEDESCRIPCION#-->
                     
                     </div>
                    </div>
                    
                    </div>
					
                    
					
					 <!-- Pagging -->
						
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
              		
                        <div class="right">
                        <a href="?execute=operativo&method=Salir&Menu=F2&SubMenu=SF21#SALIDA##&p=1&s=25&sort=1&q=" class="btn btn-large"><i class="icon-thumbs-down"></i> Cancelar</a>
						<!--#BTNGUARDAR#-->
						
						<!--#BTNENVIARREVISION#--> 
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
					
					
				</div>
				<!-- End Box -->           
                  