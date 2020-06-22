 $(document).ready( function(){	
      
	   $(".various").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
										

$('#search_go-button').click(function(){

    q = $('#searchbar').val();
	url = "?Search=recursos#&p=1&s=25&sort=1&q="+q;
	$(location).attr('href',url); 
});


	});

 