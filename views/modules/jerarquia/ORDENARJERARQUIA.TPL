<script type="text/javascript">

function GuardarNivel(){
	
	
	$('#jerarquias option').prop('selected', 'selected');
	
	 $.blockUI({ css: { backgroundColor: 'transparent', color: '#336B86', border:"null" },
	            overlayCSS: {backgroundColor: '#FFF'},
                 message: '<img src="skins/default/images/spinner-md.gif" /><br><h3> Espere un momento..</h3>'
                 });
				 
				 setTimeout("document.forms.item(0).submit()",600);

}



$(document).ready(function(){
    $('input[type="button"]').click(function(){
		
        var $op = $('#jerarquias option:selected'),
            $this = $(this);
        if($op.length){
            ($this.val() == 'Arriba') ? 
                $op.first().prev().before($op) : 
                $op.last().next().after($op);
        }
    });
});

</script>


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
						<h1 class="left"> Ordenar Niveles
</h1><br>
<p>Los niveles sirven para administrar el nivel de acceso a las partes del sistema. 
						</p>
						
						
					</div>
					<!-- End Box Head -->	
                    
                    
                    <!-- Pagging -->
						
                        <div class="pagging">
                        
                        <div class="right">
                        <a href="#URLCANCELAR#" class="btn btn-large">Cancelar</a>
						<button class="btn-warning btn-large" onclick="GuardarNivel();">Guardar</button>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
						
                    
                    
					<!-- Table -->
					<div class="box-content">
						<form class="form-horizontal" method="post" action="#URLFORMACTION#" name="frmaddniveles" id="frmaddniveles">
						  <fieldset>
							<legend>1.   Nivel: #NOMBRENIVEL#</legend>
                            
                            <input type="hidden" name="padre" value="#PADRE#" />
							<input type="hidden" value="#IDNIVEL#" name="idnivel" />		
							
					
							  <div class="control-group">
                              <div class="controls">
                              
							  <select multiple id="jerarquias" name="jerarquias[]" style="width: 600px; height: 200px;"> 
                              #NIVELES#
                              </select>
							  <br/>
							  
							  <input type="button" class="btn" value="Arriba">
                              <input type="button" class="btn" value="Abajo">

							  
                              </div>
                              </div>
							  
							  
							  
							  
						  </fieldset>
						</form>   

					</div>
					<!-- Table -->
					
					
					 <!-- Pagging -->
						
                        <div class="pagging" style="border-top:1px solid #BBBBBB;">
              		
                        <div class="right">
                        <a href="#URLCANCELAR#" class="btn btn-large">Cancelar</a>
						<button class="btn-warning btn-large" onclick="GuardarNivel();">Guardar</button>
                        </div>
                        
						</div>
              
						<!-- End Pagging -->
					
					
				</div>
				<!-- End Box -->
                  