<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vista Previa</title>

<link href="libs/video/acornmediaplayer/website/css/amp-demos.css" rel="stylesheet" type="text/css" />
<link href="skins/default/css/comentarios.css" rel="stylesheet">
 <script type="text/javascript" src="libs/video/jwplayer/jwplayer.js"></script>
     <script type="text/javascript">jwplayer.key="m1N2ZLyGQAQcvWlCU9X3snknGTMGMQ57UzehqA==";</script>

<script type="text/javascript">

function descargar(url){
	
	    var href = "index.php?execute=planesoperativo/evidencia&method=descargar&file="+url;
		//var caracteristicas = "height=100,width=200,scrollTo,resizable=0,scrollbars=0,location=0";
      	//descarga=window.open(href, 'Descarga', caracteristicas);
      	window.location.href = href;
		return false;
}

</script>

</head>


<body>

  
   <section>
        <div style="float: left;">  
		<h3>#TITULO#</h3>
		</div>
		<div style="float: right; margin-top: 20px;">
		<!--<input  type="button" class="btn btn-warning" onclick="#LINKDESCARGA#" value="Descargar"/>-->
		#BTNDESCARGAR#
		</div>
		<figure>
			
			
			#PREVIEW#
			
			<figcaption id="full-descript">
			<h3>AUTOR:</h3>
				<p>#AUTOR#</p>
			     <h3>DESCRIPCION:</h3>
				<p>#DESCRIPCION#</p>
			</figcaption>
		</figure>
		
		
	</section>
  
  
          <h3>COMENTARIOS</h3>
  
          
		  <div id="twitter-container" >
			
			    <span class="counter" id="counter"></span>
			    <textarea name="inputField" id="inputField-evidencia"  tabindex="1" rows="2" cols="40"></textarea>
			   
			    <input class="inact" style="padding: 10px; float: right;" name="submit" type="button" onClick="guardarComentarioEvidencia();" value="comentar"  id="btncomentario" />
			   			
	            <div class="clear"></div>
		    
		  </div>
		  
		  
		  <div id="contentcomentarios">

            <div id="flashmessage">
            <div id="flash"></div>
	  		</div>
   		  
		    <div class="comentarios" id="comentarios">
                        #COMENTARIOS#
		    </div>
  
  </div>

</body>

     <script type="text/javascript" src="libs/video/acornmediaplayer/jquery/jquery.min.js"></script>
	 <script type="text/javascript" src="skins/default/js/comentarios/jquery.oembed.js"></script>
     <script type="text/javascript" src="skins/default/js/comentarios/jquery.watermarkinput.js"></script>
	
	
	
	<!-- Call the plugin --> 
	<script>
		jQuery(function() {
			
				$('#inputField-evidencia').bind("blur focus keydown keypress keyup", function(){
					
					recount();
					});
	        $("#btncomentario").attr("disabled","disabled");
		    $("#inputField-evidencia").Watermark("Agrega tu comentario ...");
			 
		
			
		
			
			
			
			
		});
		
		function recount(){
		  var current = $('#inputField-evidencia').val().length;
		  if(current<0 || current==0)
	      {
		  $('#btncomentario').attr('disabled','disabled').addClass('inact');
	      }else{
		 $('#btncomentario').removeAttr('disabled').removeClass('inact');
	      }
		}
		
		
		
		function guardarComentarioEvidencia(){
    

	var idevidencia = gup('id');
    var comentario = $("#inputField-evidencia").val();
			
	$("#counter").html('<img src="skins/default/img/spinner-mini.gif" />');
	
		$.ajax({
			type: "POST",
			url: "index.php?execute=planestrategico/evidencia&method=insertarComentario",  
			data: { comentario: comentario, idevidencia: idevidencia},  
			cache: false,
			success: function(html)
			{
				
				
			   html = html.replace(/(?:http:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/g, '<iframe width="420" height="345" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>');
				
				
			
				
				$("#comentarios").prepend($(html).fadeIn('slow'));
				$("#inputField-evidencia").val('');	
				$("#inputField-evidencia").focus();
				$("#counter").html('');
				
  			}
 		});
	return false;

	
}
		
		
		function gup(name){
	
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp ( regexS );
	var tmpURL = window.location.href;
	var results = regex.exec( tmpURL );
	if( results == null )
		return"";
	else
		return results[1];
}
		 
	</script>




</html>

