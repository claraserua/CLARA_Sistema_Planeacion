<link rel="stylesheet" type="text/css" href="skins/admin/css/smoothness-1.8.13/jquery-ui-1.8.13.custom.css">
<link rel="stylesheet" type="text/css" href="skins/admin/css/ui.dropdownchecklist.standalone.css">

<script type="text/javascript" src="skins/admin/js/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="skins/admin/js/ui.dropdownchecklist-1.4-min.js"></script>

<script type="text/javascript" src="skins/admin/js/galeria.js"></script>

<script type="text/javascript">
        $(document).ready(function() {
			$("#s2").dropdownchecklist( {icon: {}, emptyText: "Acotar Resultados...",forceMultiple: true, onComplete: function(selector) {
        var values = "";
        for( i=0; i < selector.options.length; i++ ) {
            if (selector.options[i].selected && (selector.options[i].value != "")) {
                if ( values != "" ) values += ";";
                values += selector.options[i].value;
            }
        }
	  	//alert( values );
		
		submitURL(values);
		
    } } );
		
			 });
			 
	
	function submitURL(values){
		
		if(values!=""){filter = "&filter="+values; }else{ filter ="";}
		
	  window.location.href="index.php?execute="+gup("execute")+"&handle="+gup("handle")+"&action="+gup("action")+"&method=null&p="+gup("p")+"&s="+gup("s")+"&sort="+gup("sort")+"&q="+gup("q")+filter+"";
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

<!-- MODULE -->
<article class="module width_full">
		<header>#TITLEMODULO#</header>
		<div class="module_content">
				
                #CONTENIDOMODULO#
                
		<div class="clear"></div>
		</div>
		<!--FOOTERMODULE-->
</article><!-- end MODULE -->