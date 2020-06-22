<!DOCTYPE html>
<html style="" class=" js rgba multiplebgs backgroundsize borderradius boxshadow textshadow opacity cssanimations cssgradients csstransitions fontface"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Red de Universidades Anáhuac</title>
<!--<link rel="stylesheet" href="skins/default/css/style.default.css" type="text/css">
<link rel="stylesheet" href="skins/default/css/style.orange.css" type="text/css">
-->
<link rel="stylesheet" href="skins/default/css/login.css" type="text/css">

<link href='https://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>

<!--<script type="text/javascript" src="skins/default/js/jquery-1.9.1.min.js"></script>-->
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  
  <script
  src="https://code.jquery.com/jquery-migrate-3.0.1.min.js"
  integrity="sha256-F0O1TmEa4I8N24nY0bya59eP6svWcshqX1uzwaWC4F4="
  crossorigin="anonymous"></script>

<!--
<script type="text/javascript" src="skins/default/js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="skins/default/js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="skins/default/js/modernizr.min.js"></script>
<script type="text/javascript" src="skins/default/js/bootstrap.min.js"></script>
<script type="text/javascript" src="skins/default/js/jquery.cookie.js"></script>
<script type="text/javascript" src="skins/default/js/custom.js"></script>
-->

<script type="text/javascript" src="skins/default/js/jquery.easing.min.js"></script>
<script type="text/javascript" src="skins/default/js/supersized.3.2.7.js"></script>
<script type="text/javascript" src="skins/default/js/supersized.shutter.js"></script>


<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#login').submit(function(){
            var u = jQuery('#username').val();
            var p = jQuery('#password').val();
            if(u == '' && p == '') {
                jQuery('.login-alert').fadeIn();
                return false;
            }
        });
    });
</script>


<script type="text/javascript" charset="utf-8">
			
				
			
					// full screen slider	
$(document).ready( function(){
	
    $.supersized({
	
		// Functionality
		slide_interval          :   10000,		// Length between transitions
		transition              :   1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
		transition_speed		:	1000,		// Speed of transition
												   
		// Components							
		slide_links				:	'false',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
		slides 					:  	[			// Slideshow Images

	{image : 'skins/default/bg/bg2.jpg', thumb : 'images/gallery/thumb/thumb1.jpg', url : ''},
	{image : 'skins/default/bg/bg3.jpg', thumb : 'images/gallery/thumb/thumb1.jpg', url : ''},
	{image : 'skins/default/bg/bg4.jpg', thumb : 'images/gallery/thumb/thumb1.jpg', url : ''},
	{image : 'skins/default/bg/bg5.jpg', thumb : 'images/gallery/thumb/thumb1.jpg', url : ''},
	{image : 'skins/default/bg/bg6.jpg', thumb : 'images/gallery/thumb/thumb1.jpg', url : ''},
	{image : 'skins/default/bg/bg1.jpg', thumb : 'images/gallery/thumb/thumb1.jpg', url : ''},
		
						]
	});
	
});
		</script>
		
		
	

</head>

<body class="loginpage">

<div id="wrapper">
	
		<div id="container">
							
		<div id="homepage">
		#LOGIN#
		
	    </div>
	    <!--end homepage-->
				    
		
		</div><!--end container-->

		
		 <div class="logo animate0 bounceIn" style="position: absolute; margin-left: 750px; top: 250px;">
		 
		 <img src="skins/default/images/login/logo.png" alt="">
		 	
		 </div>
		
		
		
		
		<!--Time Bar-->
		<div id="progress-back" class="load-item">
			<div id="progress-bar"></div>
		</div>
		
	
	</div><!--end wrapper-->


</body>

</html>
