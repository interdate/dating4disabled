$(document).ready(
	function(){
		
		$('.tabMenu .menu .item').tab();
		$('.ui.checkbox').checkbox('disable');
		
		$('#selectAll').click(function(){
			$(this).checkbox('toggle');
			
			if($(this).find('input[type="checkbox"]').is(":checked")){
				$('.ui.checkbox').checkbox('disable');			
			}
			else{
				$('.ui.checkbox').checkbox('enable');
			}
		});
		
		
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
			duration: 50 /*miliseconds*/,			
		});  
		
		
		
		$('#getSideBar').click(function(){
			
			$('.sidebar')			
			  .sidebar({
			    overlay: true
			  })
			  .sidebar('toggle')			  
			;
			
			if($('.sidebar').hasClass('active')){
				$('#getSideBar').addClass('move');				
			}
			else{
				$('#getSideBar').removeClass('move');
			}
			
		});		
		
		$('#usersMenuActions .item').click(function(){
			var action = $(this).attr('id');
			alert(action);
		});
		
		
	}
);

