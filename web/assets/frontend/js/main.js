$(document).ready(
	function(){
		
		$('#users_usernic').on('change',function(){ checkField(this,'Usernic'); });
	    $('#users_useremail_first,#users_useremail').on('change',function(){ checkField(this,'Useremail'); });
	    
	    $('#users_usernic').keyup(function(){ checkField(this,'Usernic'); });
	    $('#users_useremail_first,#users_useremail').keyup(function(){ checkField(this,'Useremail'); });
	    
	    $('.signUpCountryCode select').change(function(){ choose($(this)); });
	    
	    $('.dropdown-toggle').click(function(){
	        if($(this).next('ul').css('display')=='none'){
	            $(this).next('ul').show();
	        }else{
	            $(this).next('ul').hide();
	        }
	        return false;
	    });
	    
	    $('#images .portrait img').click(function(){
	        clickImage(this);        
	    });
	    selectImage($('#images .image-main img'));
	    
	    $('#setMain,#remove').click(function(){
	        actionImage(this);
	        return false;
	    });
		
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

function actionImage(el){
    var id = $('#images .image-main img').attr('src').match(/\d/g).join("");
    var route = $('#userImages').val();
    var action = $(el).attr('id');
    //alert(id);
    $.ajax({
        url: route,
        type: 'Post',
        data: 'action=' + action + '&id=' + id,
        error: function(error){
            //alert(JSON.stringify(error));
        },
        success: function(data){
            $('#images').html($(data).find('#images'));
            selectImage($('#images .image-main img')); 
            $('#images .portrait img').click(function(){clickImage(this);});
        }
    });
}

function clickImage(elem){
    var src = $(elem).attr('src');
    //$(this).parent().parent().find('.image-main img.background').remove();
    var el = $(elem).parent().parent().find('.image-main img');
    el.parent().css({position:'relative'});
    //el.after('<img style="position:absolute;" class="background" width="286" height="370" src="' + el.attr('src') + '">');
    el.css({opasity:'0'}).attr('src',src).animate({opacity:'1'},5000);//.next('img').remove();
    selectImage($(elem));
}

function selectImage(sel){
    $('#setMain').show();
    //alert(sel.attr('imgmain')+','+sel.attr('src'));
    if(sel.attr('imgmain') === '1' || sel.attr('approved') !== '1'){
        $('#setMain').hide();
    }
}

function checkField(el,field){
    var email_pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
    var value = $(el).val();        
    if((value.length > 3 && field == 'Usernic')||(email_pattern.test(value) && field == 'Useremail')){            
        var route = $('#checkRoute').val();
        var data = 'field=' + field + '&value=' + value;
//        if(parseInt($(el).attr('userid'))>0){
//            data = data + '&user_id=' + $(el).attr('userid');
//        }
        $.ajax({
            url: route,
            type: 'Post',
            data: data,
            error: function(error){
                //alert(JSON.stringify(error));
            },
            success: function(data){
                    $('.' + field).remove();
                    $(el).after(data);
            },
        });	
    }
}

function afterSubmit(button){
    if(($('#users_useremail_first').size() > 0 && $('#users_useremail_first').val().length == 0) || ($('#users_useremail_second').size() > 0 && $('#users_useremail_second').val().length == 0) || 
            ($('#users_userpass_first').size() > 0 && $('#users_userpass_first').val().length == 0) || ($('#users_userpass_second').size() > 0 && $('#users_userpass_second').val().length == 0) || 
            $('#users_usernic').val().length == 0 || $('#users_zipcode').val().length == 0 || 
            $('#users_countrycode').val() == '--' || $('#users_countryoforigincode').val() == '--'){
        button.click();
        return false;
    }
    
    if($('.Usernic.error').size() > 0 || $('.Useremail.error').size() > 0){
        if($('.Usernic.error').size() > 0) 
            $('#users_usernic').focus();
        if($('.Useremail.error').size() > 0){
            if($('#users_useremail_first').size() > 0)
                $('#users_useremail_first').focus();
            else
                $('#users_useremail').focus();
        }
        return false;
    }
    
    if($('#agree').size() > 0 && !$('#agree').is(':checked')){
        alert('Please, check confirm');
        return false;
    }        
    
    button.click();
}

function choose(el){
    var field = el.attr('id');
    var value = el.val();
    var countrycode = false;
    var id = '';
    if(field == 'users_regioncode'){
        countrycode = $('#users_countrycode').val();
        $('#users_cityname,#users_usercityname').parent().addClass('hidden').remove();
        //$('#users_cityname,#users_usercityname').remove();
    }else{
        $('#users_cityname,#users_usercityname,#users_regioncode').parent().addClass('hidden').remove();
        //$('#users_cityname,#users_usercityname,#users_regioncode').remove();
    }
    var route = $('#chooseRoute').val();
    if(value != '--'){
    	$.ajax({
            url: route,
            type: 'Post',
            data: 'value=' + value + '&countrycode=' + countrycode,
            error: function(error){
                //alert(JSON.stringify(error));
            },
            success: function(data){            
                if($(data).find('select').size() > 0)
                    id = $(data).find('select').attr('id');
                else
                    id = $(data).find('input').attr('id');            
                $('#'+id).parent('.field_text').remove();
                el.parent().after(data);
                $('#'+id).selectBox();
                if(id == 'users_regioncode')
                    $('#'+id).change(function(){ choose($(this)); });
            },
        });    	
    }
    
}

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