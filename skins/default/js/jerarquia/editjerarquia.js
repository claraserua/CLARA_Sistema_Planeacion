

$(function(){

// ----- FUNCION IMAGE PREVIEW USUARIOS--//
	  $('#btncancelimage').click(function(){
	  $('#thumbailarticulo').hide();
	  $('#imagearticulo').show();
	  $(this).hide();
      });
      // ----- END FUNCION IMAGE PREVIEW USUARIOS--//
	  
	
});//End function jquery


function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                $('#thumbailarticulo')
                        .attr('src', e.target.result)
                        .width(100)
                        .height(100)
						.show();
                };
				
				
				$('#editimagen').val('TRUE');
				$('#btncancelimage').show();
				$('#imagearticulo').hide();
				
               reader.readAsDataURL(input.files[0]);
            }
        }