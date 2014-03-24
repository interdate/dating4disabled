$(document).ready(
	function(){
		
		$('.tabMenu .menu .item').tab();
		
		$('#getSideBar').click(function(){
			//alert(444565464564);
			$('.sidebar')			
			  .sidebar({
			    overlay: true
			  })
			  .sidebar('toggle')			  
			;
			
			if($('.sidebar').hasClass('active')){
				$('#getSideBar').addClass("move");
				//$('#getSideBar').css({"margin-left":"250px"});
			}
			else{
				$('#getSideBar').removeClass("move");
			}
			//$('.sidebar').sidebar('is closed', )
			
			
			
			
		});
		
		
		
	}
);

