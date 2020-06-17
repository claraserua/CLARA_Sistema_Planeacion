<?php

class html {
	function html() {
		
	}
	
	
	 function addTabs($option="link",$tabs,$title="Articulos"){	
		

    switch($option){
 	case "link":
 		
	 $html= '<h3 class="tabs_involved">'.$title.'</h3>
	        <ul class="tabs">';
		foreach($tabs as $key => $value){	
		$html .= '<li><a href="#'.$key.'">'.$value.'</a></li>';
		}
		
      $html .='</ul>';
		
		break;
 	
	case "content":
	   $html = '<div class="tab_container">';
	
	foreach($tabs as $key => $value){	
	        $html .= '<div id="'.$key.'" class="tab_content">';
			$html .= $value;
			$html .= '</div>';
	}
	   $html .= '</div>';
	
 		break;
	
 	default:
 		break;
     }
		
      return $html;
		
	}
	
	
	

	
	
	
}


?>