<link rel="stylesheet" type="text/css" href="skins/default/css/slider_o.css" />
<script language="javascript" type="text/javascript" src="skins/default/js/script.js"></script>

<script type="text/javascript">

 $(document).ready( function(){	

		var buttons = { previous:$('#lofslidecontent45 .lof-previous') ,

		next:$('#lofslidecontent45 .lof-next') };

					
		$obj = $('#lofslidecontent45').lofJSidernews( { interval : 7000,

												direction		: 'opacitys',	

											 	easing			: 'easeInOutExpo',

												duration		: 1200,

												auto		 	: true,

												maxItemDisplay  : 3,

												navPosition     : 'horizontal', // horizontal

												navigatorHeight : 32,

												navigatorWidth  : 80,

												mainWidth:980,

												mainHeight:400,

												buttons			: buttons} );	

																		

	});

</script>

<div class="Slideshow" id="Slideshow"> 

  

  <!------------------------------------- THE CONTENT ------------------------------------------------->

  <div id="lofslidecontent45" class="lof-slidecontent" style="width:980px; height:400px;">

    <div class="preload">

      <div></div>

    </div>

    <!-- MAIN CONTENT -->

    <div class="lof-main-outer" style="width:980px; height:400px;">

      <ul class="lof-main-wapper">
        #NOTICIAS#
      </ul>

    </div>

    <!-- END MAIN CONTENT --> 

    <!-- NAVIGATOR -->

    <div class="lof-navigator-wapper">

      <div onClick="return false" href="" class="lof-next">Next</div>

      <div class="lof-navigator-outer">

        <ul class="lof-navigator">
        #THUMBNOTICIAS# 
        </ul>

      </div>

      <div onClick="return false" href="" class="lof-previous">Previous</div>

    </div>

    <!----------------- ---------------------> 

  </div>

  
  <!------------------------------------- END OF THE CONTENT -------------------------------------------------> 

  

</div>

<!--END SLIDE-->