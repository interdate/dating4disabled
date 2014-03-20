$(document).ready(
	function(){
		
		$('.menu .item').tab();
		
		$('#getSideBar').click(function(){
			//alert(444565464564);
			$('.sidebar')			
			  .sidebar({
			    overlay: true
			  })
			  .sidebar('toggle')
			;
		});
		
		
		
	}
);

