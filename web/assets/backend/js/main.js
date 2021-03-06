$(document).ready(
	function(){
		$('.tabMenu .menu .item').tab();
		//$('#searchForm .selDate option[selected="selected"]').val('_null');
		
		
		curYear = new Date("Y");		
		date1 = curYear - 90;
		date2 = curYear - 18;
		
		$( ".field .birthdayCalendar" ).datepicker({
			changeMonth: true,
		    changeYear: true,
		    yearRange: '-90:-18',
		    defaultDate:'-18y-m-d',
		});
		
		$( ".field .paymentCalendar, .field .regCalendar, .field .lastVisitCalendar" ).datepicker({
			changeMonth: true,
		    changeYear: true,
		    yearRange: '-10:+1',		    
		    defaultDate:'y-m-d',
		    dateFormat: 'yy-mm-dd',
		});
		
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
		
		$('.users .location, .users .props .icon').popup({
			delay: 1, /*miliseconds*/
			duration: 50 /*miliseconds*/,			
		});
		
		$('#getSideBar').click(function(){			
			
			$('.sidebar')			
				.sidebar({
					overlay: true
				})
				.sidebar('toggle');			
			
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
			var userId = $(this).parent('td').siblings('.userId').text();
			var username = $(this).parent('td').siblings('.username').text();
			getUserPhotos(userId, username);			
		});
		
		$('.userPhotos .preview .image').click(function(){
			$('.shape').shape('flip up');
		});
		
		
		$('.usersSearch').click(function(){
			$(this).parents('form').submit();
		});
		
		$('#searchPagination a').click(function(){
			var page = $(this).text().trim();			
			$('#requestedPage').val(page);			
			$('#searchSettingsForm').submit();
		});
		
		initInterfaceItems();
		
		$('.ui.accordion')
		  .accordion()
		;
		
		$('.forumUrl .ui.dropdown').dropdown({
			'on':'hover',
			'delay': {
				show: 100,
				hide: 100
			},
			'duration' : 150,
			onChange:function(value, text){
				window.location = value;
			}
		});
		
		$('.unapprovedPhoto')
		  .dimmer({
		    on: 'hover'
		  })
		;
		
		$('#selectAllImages').click(function(){
			var iconWrapper = $(this).find('i');			
			if(iconWrapper.hasClass('empty')){				
				$('.ui.checkbox').checkbox('enable');
				iconWrapper.removeClass('empty').addClass('checked');
				//$(this).html('<i class="inverted checked checkbox icon"></i> Unselect All');
			}
			else{
				$('.ui.checkbox').checkbox('disable');
				//$(this).html('<i class="inverted empty checkbox icon"></i> Select All');
				iconWrapper.removeClass('checked').addClass('empty');
			}
			
		});
		
		$('.unapprovedPhoto .approve').click(function(){
			//$(this).parents('.segmentWrapper').remove();
			var unapprovedPhotosIds = [];
			var segments = [];
			unapprovedPhotosIds.push($(this).siblings('.unapprovedPhotoId').val());
			segments.push($(this).parents('.segmentWrapper'));
			
			approvePhotos(unapprovedPhotosIds, segments);
		});
		
		$('.unapprovedPhoto .removeUser').click(function(){
			var usersIds = [];
			var segments = [];
			usersIds.push($(this).siblings('.userId').val());
			segments.push($(this).parents('.segmentWrapper'));			
			blockAndDeleteUsers(usersIds, segments);
		});
		
		$('#approveSelectedPhotos').click(function(){
			var unapprovedPhotosIds = [];
			var segments = [];
			$('#unapprovedPhotos').find('.checkbox :checked').each(function(){				
				unapprovedPhotosIds.push($(this).parent('.ui.checkbox').siblings('.unapprovedPhoto').find('.unapprovedPhotoId').val());
				segments.push($(this).parents('.segmentWrapper'));
			});
			approvePhotos(unapprovedPhotosIds, segments);
		});
		
		$('#blockAndDeleteSelectedUsers').click(function(){
			var usersIds = [];
			var segments = [];
			$('#unapprovedPhotos').find('.checkbox :checked').each(function(){				
				usersIds.push($(this).parent('.ui.checkbox').siblings('.unapprovedPhoto').find('.userId').val());
				segments.push($(this).parents('.segmentWrapper'));
			});			
			blockAndDeleteUsers(usersIds, segments);
		});
		
		/*
		$('#createReport').click(function(){			
			//createReport();
		});
		*/
		
		/*
		$('#createReport').popup({
			on: 'click',
			content: $('#reportCreationTemplate').html(),
		});
		*/
		
		
		
		
		$('#createReport').qtip({
			events: {
				show: createReport,				
			},
			content: {
				text: $("#reportCreationTemplate").html(),
				title: {
					text: 'Report Creation',
					button: true
				}
			},
			style: {
				classes: 'ui-tooltip-shadow ui-tooltip-rounded qtip-bootstrap',
				tip: {
		            corner: true,
		            height: 24
		        }
			},
			position: {
				my: 'top center', // Use the corner...
				at: 'bottom center', // ...and opposite corner
				width: 450,
				adjust: {
					y: 10
			    },	
			},
			show: {
				event: 'click'
			},
			hide: false,
	    });
		
		
		$('#editReportWraper .ui.checkbox').checkbox();
		
		$('.saveReport').click(function(){
			if($(this).parents('form').find('input[type="text"]').val().trim().length)
				$(this).parents('form').submit();
			else
				alert('Please fill Name field');
		});
		
		
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
	$('#requestedPage').val(page);			
	$('#action').val(action);
	$('#searchSettingsForm').submit();
	
	
	/*
	if(filter){
		alert(filter);
		//$('#usersIdsForm').attr('action', currentRoute + '/' + filter  + '?page=' + page + '&action=' + action).submit();
	}
	else{
		//$('#usersIdsForm').attr('action', currentRoute + '?page=' + page + '&action=' + action).submit();
	}
	*/
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
		'duration' : 150,
	});
	
	$('.profile .ui.dropdown.selectDate').dropdown({
		'onChange' : function(value, text){			
			var dateObj1 = $(this).parent('.field').siblings('.date1').find('input[type="text"]');
			var dateObj2 = $(this).parent('.field').siblings('.date2').find('input[type="text"]');
			setDatePeriods(dateObj1, dateObj2, value, '%Y-%m-%d');			
			//alert($(this).text());
		},
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

function getUserPhotos(userId, username){	
	var modalWrapper = $('.ui.modal');	
	modalWrapper.find('.container').html("");	
	modalWrapper.modal('setting', 'transition', 'vertical flip').modal('show');	
	modalWrapper.find('.dimmer').dimmer('show');	
	modalWrapper.find('.username').text(username);	
	var route = $('#photosRoute').val();
	
	$.ajax({
		url: route + '/' + userId,
		type: 'Get',		
		error: function(error){
			$('body').html(error.responseText);
		},
		success: function(data){			
			modalWrapper.find('.dimmer').dimmer('hide');
			modalWrapper.find('.container').html(data);
			initUserPhotosInterface();
			
		},
	});
	
}


function executePhotoAction(action, photoId){
	
	if(action == 'remove'){
		if(!confirm('Are you sure ?')){
			return false;
		}
	}	
	
	var modalWrapper = $('.ui.modal');
	modalWrapper.find('.dimmer').dimmer('show');
	var route = $('#photosRoute').val();
	
	$.ajax({
		url: '/admin/users/photo/' + action + '/' +  photoId,
		type: 'Post',		
		error: function(error){			
			$('body').html(error.responseText);
		},
		success: function(data){	
			modalWrapper.find('.dimmer').dimmer('hide');
			//if( action == 'remove'){
				modalWrapper.find('.container').html(data);
				initUserPhotosInterface();
			//}			
		},
	});
}


function initUserPhotosInterface(){
	var side = $('.shape .side');
	
	$('.userPhotos .preview .item').click(function(){				
		var index = $(this).parents('.preview').find('.item').index($(this));
		nextSide = side.eq(index);
		
		if( !nextSide.hasClass('active') ){				
			$('.shape')
				.shape('set next side', nextSide)
				.shape('flip up');
		}
		
	});
	
	$('.photoWrapper .button').click(function(){
		var photoId = $('.photoWrapper .side.active .photoId').val();
		var action = $(this).attr('action');
		executePhotoAction(action, photoId);
	});
}

function approvePhotos(unapprovedPhotosIds, segments){	
	if(unapprovedPhotosIds.length == 0){
		alert('Please select photos');
		return;
	}
	
	var route = $('#approvePhotosRoute').val();	
		
	$.ajax({
		url: route,
		type: 'Post',
		data: 'unapprovedPhotosIds=' + unapprovedPhotosIds,
		error: function(error){
			//$('#profile_' + userId).html(JSON.stringify(error)).css({"height":"0px"}).siblings('.dimmer').dimmer('hide');
			//alert(error.responseText);
			$('#unapprovedPhotos').html(error.responseText);
		},
		success: function(){			
			$(segments).each(function(){
				$(this).remove();
			});			
		},
	});
}


function blockAndDeleteUsers(usersIds, segments){
	if(usersIds.length == 0){
		alert('Please select users');
		return;
	}
	
	var route = $('#blockAndDeleteUsersRoute').val();
		
	$.ajax({
		url: route,
		type: 'Post',
		data: 'usersIds=' + usersIds,
		error: function(error){			
			$('#unapprovedPhotos').html(error.responseText);
		},
		success: function(data){			
			$(segments).each(function(){
				$(this).remove();
			});
		},
	});	
}


function createReport(){	
	$(this).find('.ui.checkbox').checkbox({
		disable: true,
	});
	
	var currentRouteName = $('#currentRouteName').val();
	if(currentRouteName == 'admin_users_search'){
		$('#requestedPage').val(1);
		var link = $('#searchSettingsForm').serialize();						
		$(this).find('input[name="link"]').val(link);
		$(this).find('input[name="stats"]').val(false);
	}
	else{
		var activeItem = $('#statSidebar a.active.item');
		var name = activeItem.text().trim();
		var link = activeItem.attr('href');
		//alert($('#statSidebar').html());
		$(this).find('input[name="name"]').val(name);
		$(this).find('input[name="link"]').val(link);		
		$(this).find('input[name="stats"]').val(true);
	}
	
	$(this).find('.create').click(function(){
		var form = $(this).parents('form');
		var route = form.attr('action');
		var data = form.serialize();
		
		$.ajax({
			url: route,
			type: 'Post',
			data: data,
			error: function(error){			
				//alert(error.responseText);
			},
			success: function(data){
				$('.qtip').qtip('hide');
				alert(data);
			},
		});		
	});	
}


//Old website functuion

function setDatePeriods(objRef_l, objRef_h, period, dtformat) {
    var d = new Date(),
        dStr_l = "",
        dStr_h = "",
        m;
    switch (period) {
    case "today":
        dStr_l = dStr_h = createdStr();
        break;
    case "week_t":
        d.setDate(d.getDate() - d.getDay());
        dStr_l = createdStr();
        d.setDate(d.getDate() + 6);
        dStr_h = createdStr();
        break;
    case "month_t":
        d.setDate(1);
        dStr_l = createdStr();
        setMonthLastDate();
        dStr_h = createdStr();
        break;
    case "quarter_t":
        m = d.getMonth();
        if (m <= 2) {
            d.setMonth(0)
        } else if (m <= 5) {
            d.setMonth(3)
        } else if (m <= 8) {
            d.setMonth(6)
        } else {
            d.setMonth(9)
        };
        d.setDate(1);
        dStr_l = createdStr();
        d.setMonth(d.getMonth() + 2);
        setMonthLastDate();
        dStr_h = createdStr();
        break;
    case "year_t":
        d.setMonth(0);
        d.setDate(1);
        dStr_l = createdStr();
        d.setMonth(11);
        d.setDate(31);
        dStr_h = createdStr();
        break;
    case "week_n":
        d.setDate(d.getDate() + 7 - d.getDay());
        dStr_l = createdStr();
        d.setDate(d.getDate() + 6);
        dStr_h = createdStr();
        break;
    case "month_n":
        d.setMonth(d.getMonth() + 1);
        d.setDate(1);
        dStr_l = createdStr();
        setMonthLastDate();
        dStr_h = createdStr();
        break;
    case "quarter_n":
        m = d.getMonth();
        if (m <= 2) {
            d.setMonth(3)
        } else if (m <= 5) {
            d.setMonth(6)
        } else if (m <= 8) {
            d.setMonth(9)
        } else {
            d.setMonth(12)
        };
        d.setDate(1);
        dStr_l = createdStr();
        d.setMonth(d.getMonth() + 2);
        setMonthLastDate();
        dStr_h = createdStr();
        break;
    case "year_n":
        d.setFullYear(d.getFullYear() + 1);
        d.setMonth(0);
        d.setDate(1);
        dStr_l = createdStr();
        d.setMonth(11);
        d.setDate(31);
        dStr_h = createdStr();
        break;
    case "week_p":
        d.setDate(d.getDate() - 7 - d.getDay());
        dStr_l = createdStr();
        d.setDate(d.getDate() + 6);
        dStr_h = createdStr();
        break;
    case "month_p":
        d.setMonth(d.getMonth() - 1);
        d.setDate(1);
        dStr_l = createdStr();
        setMonthLastDate();
        dStr_h = createdStr();
        break;
    case "quarter_p":
        m = d.getMonth();
        if (m <= 2) {
            d.setFullYear(d.getFullYear() - 1);
            d.setMonth(9)
        } else if (m <= 5) {
            d.setMonth(0)
        } else if (m <= 8) {
            d.setMonth(3)
        } else {
            d.setMonth(6)
        };
        d.setDate(1);
        dStr_l = createdStr();
        d.setMonth(d.getMonth() + 2);
        setMonthLastDate();
        dStr_h = createdStr();
        break;
    case "year_p":
        d.setFullYear(d.getFullYear() - 1);
        d.setMonth(0);
        d.setDate(1);
        dStr_l = createdStr();
        d.setMonth(11);
        d.setDate(31);
        dStr_h = createdStr();
        break;
    default:
        return;
        break;
    };
    
    /*
    objRef_l.value = dStr_l;
    objRef_h.value = dStr_h;
    */
    
    //modified
    objRef_l.val(dStr_l);
    objRef_h.val(dStr_h);

    function setMonthLastDate() {
        m = d.getMonth();
        if (m == 0 || m == 2 || m == 4 || m == 6 || m == 7 || m == 9 || m == 11) {
            d.setDate(31)
        } else if (m == 3 || m == 5 || m == 8 || m == 10) {
            d.setDate(30)
        } else if (d.getFullYear() % 4 == 0) {
            d.setDate(29)
        } else {
            d.setDate(28)
        }
    }

    function createdStr() {
		if ("undefined" != typeof (dtformat)) {
			if(console && console.log) {
				console.log('in')
			}
			return formatDate_ami( d, dtformat );
		}
        return ((d.getMonth() + 1) < 10 ? "0" + (d.getMonth() + 1) : (d.getMonth() + 1)) + "/" + (d.getDate() < 10 ? "0" + d.getDate() : d.getDate()) + "/" + d.getFullYear()
    }
    
    function formatDate_ami( dt, s ) {
    	if( !(dt instanceof Date) ) {
    		throw "Date object expected";
    	}
    	s = s.toString();
    	
    	console.log(s);
    	
    	s = s.replace(/%d/g, dt.getDate());
    	s = s.replace(/%m/g, dt.getMonth()+1);
    	s = s.replace(/%Y/g, dt.getFullYear());
    	s = s.replace(/%H/g, dt.getHours());
    	s = s.replace(/%i/g, dt.getMinutes());
    	s = s.replace(/%s/g, dt.getSeconds());
    	s = s.replace(/%f/g, dt.getMilliseconds());
    	return s;
    } 
}