$(document).ready(function(){
    $('#users_usernic').on('change',function(){ checkField(this,'Usernic'); });
    $('#users_useremail_first').on('change',function(){ checkField(this,'Useremail'); });
    
    $('#users_usernic').keyup(function(){ checkField(this,'Usernic'); });
    $('#users_useremail_first').keyup(function(){ checkField(this,'Useremail'); });
    
    $('.signUpCountryCode select').change(function(){ choose($(this)); });    
});

function checkField(el,field){
    var email_pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
    var value = $(el).val();        
    if((value.length > 3 && field == 'Usernic')||(email_pattern.test(value) && field == 'Useremail')){            
        var route = $('#checkRoute').val();
        $.ajax({
            url: route,
            type: 'Post',
            data: 'field=' + field + '&value=' + value,
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
    if($('#users_useremail_first').val().length == 0 || $('#users_useremail_second').val().length == 0 || 
            $('#users_userpass_first').val().length == 0 || $('#users_userpass_second').val().length == 0 || 
            $('#users_usernic').val().length == 0 || $('#users_zipcode').val().length == 0 || 
            $('#users_countrycode').val() == '--' || $('#users_countryoforigincode').val() == '--'){
        button.click();
        return false;
    }
    
    if($('.Usernic.error').size() > 0 || $('.Useremail.error').size() > 0){
        if($('.Usernic.error').size() > 0) 
            $('.Usernic.error').focus();
        if($('.Useremail.error').size() > 0) 
            $('.Useremail.error').focus();
        return false;
    }
    
    if(!$('#agree').is(':checked')){
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
    if(value != '--')
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