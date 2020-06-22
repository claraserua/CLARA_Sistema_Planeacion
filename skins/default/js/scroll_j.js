// JavaScript Document
$(window).load(function() {
	$customScrollBox=$("#customScrollBox");
	$customScrollBox_container=$("#customScrollBox .container");
	$customScrollBox_content=$("#customScrollBox .content");
	$dragger_container=$("#dragger_container");
	$dragger=$("#dragger");
	
	CustomScroller();
	
	function CustomScroller(){
		outerMargin=42;
		innerMargin=62;
		$customScrollBox.height($(window).height()-216);
		$dragger_container.height($(window).height()-216);
		visibleHeight=$(window).height()-216;
		if($customScrollBox_container.height()>visibleHeight){ //custom scroll depends on content height
			$dragger_container,$dragger.css("display","block");
			totalContent=$customScrollBox_content.height();
			draggerContainerHeight=$(window).height()-216;
			animSpeed=400; //animation speed
			easeType="easeOutCirc"; //easing type
			bottomSpace=1.05; //bottom scrolling space
			targY=0;
			draggerHeight=$dragger.height();
			$dragger.draggable({ 
				axis: "y", 
				containment: "parent", 
				drag: function(event, ui) {
					Scroll();
				}, 
				stop: function(event, ui) {
					DraggerOut();
				}
			});

			//scrollbar click
			$dragger_container.click(function(e) {
				var mouseCoord=(e.pageY - $(this).offset().top);
				var targetPos=mouseCoord+$dragger.height();
				if(targetPos<draggerContainerHeight){
					$dragger.css("top",mouseCoord);
					Scroll();
				} else {
					$dragger.css("top",draggerContainerHeight-$dragger.height());
					Scroll();
				}
			});

			//mousewheel
			$(function($) {
				$customScrollBox.bind("mousewheel", function(event, delta) {
					vel = Math.abs(delta*10);
					$dragger.css("top", $dragger.position().top-(delta*vel));
					Scroll();
					if($dragger.position().top<0){
						$dragger.css("top", 0);
						$customScrollBox_container.stop();
						Scroll();
					}
					if($dragger.position().top>draggerContainerHeight-$dragger.height()){
						$dragger.css("top", draggerContainerHeight-$dragger.height());
						$customScrollBox_container.stop();
						Scroll();
					}
					return false;
				});
			});

			function Scroll(){
				var scrollAmount=(totalContent-(visibleHeight/bottomSpace))/(draggerContainerHeight-draggerHeight);
				var draggerY=$dragger.position().top;
				targY=-draggerY*scrollAmount;
				var thePos=$customScrollBox_container.position().top-targY;
				$customScrollBox_container.stop().animate({top: "-="+thePos}, animSpeed, easeType); //with easing
				//$customScrollBox_container.css("top",$customScrollBox_container.position().top-thePos+"px"); //no easing
			}

			//dragger hover
			$dragger.mouseup(function(){
				DraggerOut();
			}).mousedown(function(){
				DraggerOver();
			});

			function DraggerOver(){
				$dragger.css("background", "url(skins/default/img/custom_scrollbar_bg_over.png)");
			}

			function DraggerOut(){
				$dragger.css("background", "url(skins/default/img/custom_scrollbar_bg.png)");
			}
		} else { //hide custom scrollbar if content is short
			$dragger,$dragger_container.css("display","none");
		}
	}

	//resize browser window functions
	$(window).resize(function() {
		$dragger.css("top",0); //reset content scroll
		$customScrollBox_container.css("top",0);
		$customScrollBox.unbind("mousewheel");
		CustomScroller();
	});
});