$(document).ready(
	function(){
		
		//$('.tabMenu .menu .item').tab();
		//$('.profileWraper .menu .item').tab();
		
		
		
		//$('.ui.checkbox').checkbox('disable');		
		
		$('.ui.checkbox').checkbox({
			disable: true,
			onEnable: function(){
				$(this).parents('tr').addClass("selectedRow");
			},
			onDisable: function(){
				$(this).parents('tr').removeClass("selectedRow");
			}
		});
				
		$('#selectAll').click(function(){
			//$(this).checkbox('toggle');
			
			if($(this).find('input[type="checkbox"]').is(":checked")){
				$('.userRow').find('.ui.checkbox').checkbox('enable');
			}
			else{
				$('.userRow').find('.ui.checkbox').checkbox('disable');
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
		
		
		
		
		
		$('#statWraper .location, #statWraper .props .icon').popup({
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
			var usersIds = [];
			var action = $(this).attr('id');
			
			$('.users .userRow :checked').each(function(){
				//console.log($(this).val());
				usersIds.push($(this).val());
			});			
			executeAction(action, usersIds);
		});
		
		$('.users tbody .trash.icon').click(function(){
			
			if( confirm('Are you sure ?') ){			
				var usersIds = [];
				var userId = $(this).parent('td').siblings('.userId').text();
				usersIds.push(userId);
				executeAction('delete', usersIds);
			}
		});
		
		$('.users tbody .edit.icon').click(function(){
		
			/*
			$('.modal')
	        	.modal('setting', 'transition', 'vertical flip')
	        	.modal('show')
	        ;
	        */
			
			$(this).parents('tr').addClass("editedUser");			
			$(this).parents('tr').next().removeClass('hidden');
			
			var userId = $(this).parent('td').siblings('.userId').text();
			getUserProfile(userId);
		
		});
		
		$('.users tbody .photos.icon').click(function(){
			
			$('.modal')
	        	.modal('setting', 'transition', 'vertical flip')
	        	.modal('show')
	        ;
			
		});
		
		$('.userImagesWraper .preview .image').click(function(){
			$('.shape').shape('flip up');
		});
		
		
		$('.usersSearch').click(function(){
			$(this).parents('form').submit();
		});
		
		
		
		initInterfaceItems();
		
		
		
		$('.ui.accordion')
		  .accordion()
		;
	}
);

function executeAction(action, usersIds){	
	
	if(usersIds.length == 0){
		alert('Please select users');
		return;
	}	
	
	var currentRoute = $('#currentRoute').val();
	var filter = $('#filter').val();			
	var page = $('#page').val();			
	$('#usersIds').val(usersIds);
	$('#usersIdsForm').attr('action', currentRoute + '/' + filter  + '?page=' + page + '&action=' + action).submit();
}


function getUserProfile(userId){
	
	var route = $('#profileRoute').val();
	$('#profile_' + userId).html("").css({"height":"480px"}).siblings('.dimmer').dimmer('show');
		
	$.ajax({
		url: route + '/' + userId,
		type: 'Get',		
		error: function(error){
			$('#profile_' + userId).html(JSON.stringify(error)).css({"height":"0px"}).siblings('.dimmer').dimmer('hide');
		},
		success: function(data){
			$('#profile_' + userId).html(data).css({"height":"0px"}).siblings('.dimmer').dimmer('hide');
			initInterfaceItems();
		},
	});
	
}



function saveUserProfile(form){	
	var userId = form.find('.userId').val();	
	$('#profile_' + userId).siblings('.dimmer').dimmer('show');
	
	var route = $('#profileRoute').val();
	var data = form.serialize();	
	
	$.ajax({
		url: route + '/' + userId,
		type: 'Post',
		data: data,
		error: function(data){
			$('body').html(JSON.stringify(data));
		},
		success: function(data){
			$('#profile_' + userId).html(data).siblings('.dimmer').dimmer('hide');
			initInterfaceItems();
		},
	});

}

function initInterfaceItems(){
	$('.userProfileTabs .item').click(function(){
		
		$(this).parent().find('.item').removeClass('active');
		$(this).addClass('active');
							
		var tab = $(this).attr('data-tab');
		var segment = $(this).parent().siblings('.segment');
		segment.find('.ui.form').removeClass('active').addClass('hidden');
		segment.find('div[data-tab="'+ tab +'"]').removeClass('hidden').addClass('active');		
	});
	
	
	$('.profile .ui.dropdown').dropdown({
		'on':'click',
		'delay': {
			show: 100,
			hide: 100
		},
		'duration' : 150
	});
	
	$('.profile .ui.checkbox').checkbox({
		disable: true,
	});
	
	
	$('.close').click(function(){
		$(this).parents('tr').addClass('hidden');
		$(this).parents('tr').prev().removeClass('editedUser');
	});
	
	$('.saveUserProfile').click(function(){				
		var form = $(this).parents('form');				
		saveUserProfile(form);
	});
}

