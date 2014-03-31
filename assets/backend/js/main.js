$(document).ready(
	function(){
		
		$('.tabMenu .menu .item').tab();
		$('.ui.checkbox').checkbox();
		
		
		$('.ui.dropdown').dropdown({
			'on':'hover',
			'delay': {
				show: 100,
				hide: 100
			},
			'duration' : 150
		});
		
		
		$('#statWraper .location').popup({
			delay: 1, /*miliseconds*/
			duration: 150 /*miliseconds*/,			
		});  
		
		
		
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

