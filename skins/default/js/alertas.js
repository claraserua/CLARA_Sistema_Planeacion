$(function() {
   /* $('.content-area').jScrollPane();*/
});


function __validasesion(msg){

    	var num = msg.length;
    	if(num>150){
             return false;
    	}else{
    		return true;
    	}
    }


    function _openlogin(){

    	  window.open("index.php", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=300,width=440,height=600");
    }

    


function goAlerta(ID){
	
	//alert(ID);
	
	$.ajax({ 
	 
    type: "POST",  
    url: "index.php?execute=notificaciones&method=goAlerta",  
	data: { ID:ID},  
    success: function(msg){  
	
	  //alert(msg);
	 
	 var randomnumber=Math.floor(Math.random()*11);
	 
	 if(msg.trim()!=""){
	 	
		 url = msg.replace("#","&parametro="+ randomnumber +"#"); 
		
		
		setTimeout("window.location.href='" + url + "'", 0) 
	 }else{
	 	alert("La notificación ya vencio");
	 }
	 
               
			   } 
   
           });
	
	
	
}