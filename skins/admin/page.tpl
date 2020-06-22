<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8"/>
	<title>@prende Panel de Administración</title>
	
    <link rel="stylesheet" href="skins/admin/css/layout.css" type="text/css" media="screen" />
     <link rel="stylesheet" href="skins/admin/css/tags.css" type="text/css" media="screen" />
     
<link href="skins/default/css/minsearch.css" rel="stylesheet" type="text/css">   
  
	 <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="skins/admin/css/ie.css" type="text/css" media="screen" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	
   <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
	<script type="text/javascript" src="libs/ckeditor/ckeditor.js"></script>
	<script src="skins/admin/js/hideshow.js" type="text/javascript"></script>
	<script type="text/javascript" src="skins/admin/js/jquery.equalHeight.js"></script>
	<script src="skins/admin/js/jquery.blockUI.js" type="text/javascript"></script>
    
    <script src="skins/admin/js/jquery.iframe-post-form.js" type="text/javascript"></script>
    
    
    
     <!--FANCY BOX -->
    
    <!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="skins/admin/lib/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="skins/admin/lib/fancybox/source/jquery.fancybox.js?v=2.1.3"></script>
	<link rel="stylesheet" type="text/css" href="skins/admin/lib/fancybox/source/jquery.fancybox.css?v=2.1.2" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="skins/admin/lib/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="skins/admin/lib/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="skins/admin/lib/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="skins/admin/lib/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="skins/admin/lib/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.5"></script>

	 <!--END FANCY BOX -->
		

	
	
	<script type="text/javascript">
	
	
	$(document).ready(function() {

	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {
        
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});
    </script>
    <script type="text/javascript">
    $(function(){
       $('.column').equalHeight();
	     
 
    });
</script>

</head>


<body>
    <!-- header bar -->
	<header id="header">
		#HEADER#
	</header> 
    <!-- end of header bar -->
	
    <!-- secondary bar -->
    <section id="secondary_bar">    
        <div class="user">
			#USERINFO#
		</div>
		    
    <div class="breadcrumbs_container">
			#NAVEGACION#
         </div>
	</section>
    <!-- end of secondary bar -->
	
	
    
    <!--Menu -->
    <aside id="sidebar" class="column">
	
	
           #MENU#
	
       <footer>
		  #FOOTER#
	   </footer>
	
    </aside>
    <!-- end of Menu -->
	
	
    
     <!-- Content -->
    <section id="main" class="column" >
		<h4 id="alerta" class="alert_info" style="display:none">Alerta</h4>  
        #CONTENT#
		<div class="spacer"></div>
	</section>
     <!-- End Content -->


</body>

</html>