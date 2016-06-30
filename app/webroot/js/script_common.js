
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    
    $(".ajax").colorbox({scrolling: false,overlayClose: false
        //escKey: false,//width:'100%',//height:'100%', 
    });
    $(document).on('click', function (event) {
        $(event.target).closest('.prof_m_span').size() > 0 ? "" : $(".popup_profile").fadeOut();
    });
    if($('.useisdinstart').val()!='' && !isNaN($('.useisdinstart').val())){
        $('.useisdinstart').closest('.phonebox').find('.phlbl').show();
        $('.useisdinstart').css({'width':'79%','padding-left':'15px'});
    }
    $(document)
        .on('focus', '.useisdinstart', function (event) {
            if((trim($(this).val()) == '' && !$(this).hasClass('login-inputs') && !$(this).hasClass('hasBothEmailPhone')) || (trim($(this).val()) != '' && !isNaN($(this).val()) && ($(this).hasClass('login-inputs') || $(this).hasClass('hasBothEmailPhone')))){
                $(this).closest('.phonebox').find('.phlbl').show();
                $(this).css({'width':'79%','padding-left':'15px'});
                //$(this).closest('.phonebox').find('.error').html('');
            }
        })
        .on('blur', '.useisdinstart', function (event) {
            if(trim($(this).val()) == '' && !$(this).hasClass('login-inputs') && !$(this).hasClass('hasBothEmailPhone')){
                $(this).closest('.phonebox').find('.phlbl').hide();
                $(this).css({'width':'100%','padding-left':'60px'});
            }
            trim($(this).val()) != ''?$(this).closest('.phonebox').find('.error').html(''):"";
        }).on('keydown keyup', '.useisdinstart', function (event) {
            if($(this).hasClass('login-inputs') || $(this).hasClass('hasBothEmailPhone')){
                if(trim($(this).val()) != '' && !isNaN($(this).val())){
                    $(this).closest('.phonebox').find('.phlbl').show();
                    $(this).css({'width':'79%','padding-left':'15px'}).attr({'maxlength':10});
                    $(this).closest('.contactusfrmemailphone').length>0?$('.contactusfrmemailphone').removeClass('name_mail').addClass('ph_reg'):"";
                }else{
                    $(this).closest('.phonebox').find('.phlbl').hide();
                    $(this).css({'width':'100%','padding-left':'60px'}).attr({'maxlength':100});
                    $(this).closest('.contactusfrmemailphone').length>0?$('.contactusfrmemailphone').removeClass('ph_reg').addClass('name_mail'):"";
                }
                $(this).closest('.phonebox').find('.error').html('');
            }
        });
    $('.pricevalue').on('keyup', function (event) {
        var price = $(this).val();
        var validprice = /^\d{0,10}(\.\d{0,2})?$/.test(price);
        $(this).val(validprice?price:price.slice(0,-1));
    });
    $(document).on('keydown', '.numbersOnly', function (event) {
        var key = window.event ? event.keyCode : event.which;
        var key_arr = [8, 46, 37,38, 39,40, 9, 91, 92, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 116,16,187,46,17,82,65,35,36,110,190];
        if(jQuery.inArray(key, key_arr) > -1){return true;}else if(key < 48 || key > 57){return false;}else{return true;}
    });
    $(document).on('keydown', '.priceOnly', function (event) {
        var key = window.event ? event.keyCode : event.which;
        var key_arr = [8, 46, 37, 39, 9, 91, 92, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 190, 116,46,17,82];
        if (jQuery.inArray(key, key_arr) > -1) {return true;} else if (key < 48 || key > 57) {return false;} else {return true;}
    });
    $(document).on('keydown', '.alphaOnly', function (e) {
        if (e.altKey) {
            e.preventDefault();
        } else {
            var key = e.keyCode;
            if (!((key == 8) || (key == 32) || (key == 9) || (key == 46) || (key == 116) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                e.preventDefault();
            }
        }
    });
    /*custom validation start*/
    $.validator.addMethod("moblieAndEmail",function (value, element) {
        return /^([1-9][0-9]{9})$/.test(value)||
               /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
    }, "Please enter valid mobile or email.");
    $.validator.addMethod("noSpecialChars",function (value, element) {return /^[A-Za-z\d=#$%@_ -]+$/.test(value);}, "Sorry, no special characters allowed.");
    $.validator.addMethod("moblieNmuber",function (value, element) {if(value==''){return true;}return /^([0|\+[0-9]{1,5})?([1-9][0-9]{9})$/.test(value);}, "Please enter valid phone number.");
    //$.validator.addMethod("moblieNmuber",function (value, element) {return /^([0|\+[0-9]{1,5})?([0-9][0-9]{9})$/.test(value);}, "Please enter a valid phone number.");
    $.validator.addMethod("strictEmail", function (value, element) {if(value==''){return true;}return /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);}, "Please enter valid email address.")
    $.validator.addMethod("indZip",function (value, element) {return /(^\d{6}$)/.test(value);}, "Please enter valid pincode.");
    $.validator.addMethod("greaterThan", function (value, element, param) {
        if(value=='' || parseFloat(value)===0){return true;} var $min = $(param);
        if (this.settings.onfocusout) {$min.off(".validate-greaterThan").on("blur.validate-greaterThan", function () {$(element).valid();});}
        return parseInt(value) > parseInt($min.val());
    }, "Max age must be greater than min age");
    /*custom validation end*/
    
    /*ASK US*/
    $('#askus_send_admin').click(function(){General.validate_askus_form();});
    $('#askus_username, #askus_phone, #askus_message, #askReferSecurityCode').keyup(function(){$(this).val().trim() != '' ? $(this).removeClass('error') : '';});
});

window.alert = function (message, caption) {
    var caption = caption || 'Message';
    if(caption == 'error'){
        $('.js-alert-box-error').find('.alert-message').html(message);
        $('.js-alert-box-error').find('.alert-dismissible').show();
        $('.js-alert-box-error').show();
    }else{
        $('.js-alert-box-success').find('.alert-message').html(message);
        $('.js-alert-box-success').find('.alert-dismissible').show();
        $('.js-alert-box-success').show();
    }

    /*$('<div />').text(message).dialog({modal: true,title: caption,buttons: {'Ok': function () {$(this).dialog('close');}},close: function () {$(this).dialog('destroy').remove();}});*/
}
window.confirm = function (message, callback, cancelCallBack, caption) {
    caption = caption || 'Confirmation';
    $('<div />').attr({
        title: caption,
        'class': 'dialog'
    }).html(message).dialog({
        //position: ['center', 100],
        //dialogClass: 'fixed',
        buttons: {
            "OK": function () {
                $(this).dialog('close');
                callback()
                return true;
            },
            "Cancel": function () {
                $(this).dialog('close');
                if (typeof cancelCallBack === 'function') {
                    cancelCallBack();
                }
                return false;
            }
        },
        close: function () {
            $(this).remove();
        },
        draggable: false,
        modal: true,
        resizable: false,
        //width: 'auto'
    });
};

Hash = {
    lastHash: window.location.hash,
    newHash: '',
    init: function () {
        $(window).bind('hashchange', function () {
            var newHash = location.hash;
            // Do something
            var diff = Hash.compareHash(newHash, Hash.lastHash);
            alert("Difference between old and new hash:\n" + diff[0] + "\n\n" + diff[1]);

            //At the end of the func:
            Hash.lastHash = newHash;
        });
    },
    compareHash: function (current, previous) {
        for (var i = 0, len = Math.min(current.length, previous.length); i < len; i++) {
            if (current.charAt(0) != previous.charAt(0))
                break;
        }
        current = current.substr(i);
        previous = previous.substr(i);
        for (var i = 0, len = Math.min(current.length, previous.length); i < len; i++) {
            if (current.substr(-1) !== previous.substr(-1))
                break;
        }
        //Array: Current = New hash, previous = old hash
        return [current, previous];
    }
};
/*
 * page scroll loadmore functionality
 * @returns {undefined}
 *  
 */
function scrolltoloadrecord($obj) {
    if ($obj.size() > 0 && $obj.css('display') != 'none') {
        //console.log($(window).scrollTop()+" >> "+ $(window).height()+" == "+($(window).scrollTop() + $(window).height())+" ++ "+($(window).scrollTop() + $(window).height() + 1000)+' > '+ $obj.position().top);
        if ($(window).scrollTop() + $(window).height() + 1000 > $obj.position().top) {
            $obj.trigger("click");
        }
    }
}

var format12to24 = function (unformattedTime) {
    var time = unformattedTime || '';
    if(time == ''){
        return '';
    }
    time = time.toUpperCase();
    var hours = Number(time.match(/^(\d+)/)[1]);
    var minutes = Number(time.match(/:(\d+)/)[1]);
    var AMPM = time.match(/\s(.*)$/)[1];
    if (AMPM == "PM" && hours < 12)
        hours = hours + 12;
    if (AMPM == "AM" && hours == 12)
        hours = hours - 12;
    var sHours = hours.toString();
    var sMinutes = minutes.toString();

    if (hours < 10)
        sHours = "0" + sHours;
    if (minutes < 10)
        sMinutes = "0" + sMinutes;
    //console.log(hours+' >> '+sHours)
    return sHours + ":" + sMinutes + ":00";
};
General = {
    myTm: '',
    flag: true,
    hideAlert : function(mode){
        var mode = mode || '';
        if(mode == 'now'){
            $('.alert-dismissible,.js-alert-box-error,.js-alert-box-success').hide();
            return false;
        }
        clearTimeout(this.myTm);
        this.myTm = setTimeout(function(){
            $('.alert-dismissible').fadeOut(function(){
                $('.js-alert-box-error,.js-alert-box-success').hide();
            });
        },5000);
    },
    get_subcategories : function(catid,subcatele,subcatid) {
        var catid = catid || '';
        if(catid == ''){
            $("#"+subcatele).find('option:gt(0)').remove();
            return false;
        }
        var subcatid = subcatid || '';
        var params = {catid: catid};
        $.ajax({
            url: HTTP_ROOT + "content/subcats",
            data: params,
            method: 'post',
            success: function(response) {
                $("#"+subcatele).find('option:gt(0)').remove();
                $("#"+subcatele).append(response);
                $("#"+subcatele).val(subcatid);
            }
        });
    },
    validate_askus_form: function(){
        $('#askus_username, #askus_phone, #askus_message, #askReferSecurityCode').removeClass('error');
        this.hideAlert('now');
        General.hideAlert();
        var name = $('#askus_username');
        var phone = $('#askus_phone');
        var msg = $('#askus_message');
        var captcha = $('#askReferSecurityCode');
        var flag = true;
        
        if(name.val().trim() == ''){
            flag = false;
            name.addClass('error');
        }
        
        if(phone.val().trim() == ''){
            flag = false;
            phone.addClass('error');
        }else{
            flag = !!(this.isPhone(phone.val()) | this.isEmail(phone.val()));
            !flag ? phone.addClass('error') : '';
        }
        if(msg.val().trim() == ''){
            flag = false;
            msg.addClass('error');
        }
        if(captcha.val().trim() == ''){
            flag = false;
            captcha.addClass('error');
        }
        if(!flag){
            alert("Please enter details properly.","error")
            return false;
        }
        if(this.flag){
            this.flag = false;
            var params = {
                name:name.val().trim(),
                contact:phone.val().trim(),
                message:msg.val().trim(),
                captcha:captcha.val().trim(),
            };
            $('#askus_send_admin').val('Loading...');
            $.ajax({
                url: HTTP_ROOT + "content/ask_us",
                data: params,
                method: 'post',
                dataType:'json',
                success: function(response) {
                    General.flag = true;
                    General.hideAlert();
                    alert(response.message,(response.success ? "" : "error"));
                    $('#askus_send_admin').val('Submit');
                    if(response.success){
                        $('#toggleclick').trigger('click');
                        $('#askus_username, #askus_phone, #askus_message, #askReferSecurityCode').removeClass('error').val('');
                    }
                }
            });
        }
    },
    email: function( value ) {
        return /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(value);
    },
    isPhone: function(value){
        return /^([0|\+[0-9]{1,5})?([0-9][0-9]{9})$/.test(value);
    },
    isEmail: function(value){
        return /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
    }
};
/*
 * Used for refreshing captcha image
 * @returns {undefined}
 *  
 */
function captcha_refresh() {
    var source = $('#captcha_img').attr('src').indexOf('&tmp') > -1 ? $('#captcha_img').attr('src').substring(0, $('#captcha_img').attr('src').indexOf('&tmp')) : $('#captcha_img').attr('src');
    $('#captcha_img').attr('src', source + '&tmp' + Math.random());
}

function levenshtein(s1, s2, cost_ins, cost_rep, cost_del) {
  //        example 1: levenshtein('Kevin van Zonneveld', 'Kevin van Sommeveld');
  //        returns 1: 3
  //        example 2: levenshtein("carrrot", "carrots");
  //        returns 2: 2
  //        example 3: levenshtein("carrrot", "carrots", 2, 3, 4);
  //        returns 3: 6

  var LEVENSHTEIN_MAX_LENGTH = 255; // PHP limits the function to max 255 character-long strings
  cost_ins=cost_ins==null?1:+cost_ins;cost_rep=cost_rep==null?1:+cost_rep;cost_del=cost_del==null?1:+cost_del;
  if(s1==s2){return 0;}var l1=s1.length;var l2=s2.length;if(l1===0){return l2*cost_ins;}if(l2===0){return l1*cost_del;}
  // Enable the 3 lines below to set the same limits on string length as PHP does
  /*if (l1 > LEVENSHTEIN_MAX_LENGTH || l2 > LEVENSHTEIN_MAX_LENGTH) {return -1;}*/
  // BEGIN STATIC
  // Earlier IE may not support access by string index
  var split=false;try{split=!('0')[0];}catch(e){split=true;}
  // END STATIC
  if(split){s1=s1.split('');s2=s2.split('');}var p1= new Array(l2+1);var p2= new Array(l2+1);var i1,i2,c0,c1,c2,tmp;
  for(i2=0;i2<=l2;i2++){p1[i2]=i2*cost_ins;}
  for(i1=0;i1<l1;i1++){p2[0]=p1[0]+cost_del;for(i2=0;i2<l2;i2++){c0=p1[i2]+((s1[i1]==s2[i2])?0:cost_rep);c1=p1[i2+1]+cost_del;if(c1<c0){c0=c1;}c2=p2[i2]+cost_ins;if(c2<c0){c0 = c2;}p2[i2+1]=c0;}tmp=p1;p1=p2;p2=tmp;}
  c0=p1[l2];
  return c0;
}
