$(document).ready(
	function(){
		
		$('#searchPagination span').click(function(){
			var page = $(this).find('input[type="hidden"]').val();			
			$('#requestedPage').val(page);			
			$('#advancedSearchForm').submit();
		});
		
		$('#show_sf').click(function(){
			$('#advancedSearchForm').show('slow');
			$('.selectBox-label').css({'width':'159px'});
		});
		
	}
);

function displayUsers(actionAttr){
	$('#requestedPage').val(1);
	$('#advancedSearchForm').attr({'action':actionAttr}).submit();
}


function quickSearch(){
	var userGender = $('.gen_picker.current').find('input').val();
	$('#qs_user_gender').val(userGender);
	//alert($('#qs_user_gender').val());
	$('#qs_form').submit();	
}

function viewUserProfile(userId, offSetTop){	
	var route = $('#viewUserProfileRoute').val();
	//$('#profile_' + userId).html("").css({"height":"480px"}).siblings('.dimmer').dimmer('show');
	$('#warp-floatblock, #darken').remove();
	
	$('<div id="darken"><div class="loader">Loading</div></div>').insertBefore('#page-warp');
	
	
	$.ajax({
		url: route,
		type: 'Get',
		data: 'userId=' + userId,
		error: function(error){
			$('.error').html(JSON.stringify(error));
		},
		success: function(data){
			//$('#profile_' + userId).html(data).css({"height":"0px"}).siblings('.dimmer').dimmer('hide');
			//initInterfaceItems();
			//alert(data);
			$(data).insertBefore('#darken');
			var marginTop = offSetTop - 400;	
			var marginLeft = ( $(window).width() / 2 ) - ( $('.floatblock').width() / 2 );
			
			$('#darken .loader').remove();
			$('#warp-floatblock').show();
			
			
			
			$('#warp-floatblock').css({'margin-top': marginTop + 'px', 'margin-left' : marginLeft + 'px'}); 
			
			$('.floatblock .close,  #darken').click(function(){
				$('#warp-floatblock, #darken').remove();
			});
			 
		},
	});	
}