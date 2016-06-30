/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function user_valid_admin_add(mode) {
    //jQuery.validator.defaults.ignore = ":hidden";
    var mode = mode || '';
    var validate = $('#BusinessAddForm').validate({
        ignore: [],
        rules: {
            'data[Business][name]': {required: true,},
            'data[Business][category_id][]': {required: true,},
            'data[Business][subcategory_id]': {required: false,},
            'data[Business][min_age_group]': {required: true,},
            'data[Business][max_age_group]': {required: true,greaterThan: "select[name='data[Business][min_age_group]']"},
            'data[Business][student_ratio]': {required: function(element){return $('#BusinessTeacherRatio').val()!='';}},
            'data[Business][teacher_ratio]': {required: function(element){return $('#BusinessStudentRatio').val()!='';}},
            'data[Business][city_id]': {required: true,},
            'data[Business][locality_id]': {required: true,},
            'data[Business][address]': {required: true},
            'data[Business][landmark]': {required: false},
            'data[Business][pincode]': {required: true,indZip: true},
            'data[Business][contact_person]': {required: true},
            'data[Business][phone]': {required: true,},////moblieNmuber: true
            'data[Business][email]': {required: true,strictEmail:true,},//email: true
            'data[Business][website]': {required: false,url:true},
            'data[Business][facebook]': {required: false,url:true},
            'data[Business][twitter]': {required: false,url:true},
            'data[Business][gplus]': {required: false,url:true},
            'data[Business][youtube]': {required: false,url:true},
            'data[Business][gender]': {required: true},
            'data[Business][price]': {required: true,number: true},
            'data[Business][max_price]': {required: false,number: true,greaterThan: "input[name='data[Business][price]']"},
            'data[Business][seo_url]':{required: false,remote: {async: false,type: 'post',url: HTTP_ROOT + "businesses/seo_url_unique",data: {seo_url: $('#BusinessSeoUrl').val()},dataType: 'json'}},
            'data[Business][facilities]': {required: false},
            'data[Business][about_us]': {required: true},
            'data[Business][logo]': {required: false},
            'BusinessType': {required: true},
            'data[Business][dob]': {required: false},
            'PreferredLocation': {required: true},
            'FreeDemoClass': {required: true},
            'data[Business][languages][]': {required: true},
            //'data[Business][tagline]': {required: true},
            'data[Business][education]': {required: true},
            'data[Business][experience]': {required: true},
            //'data[Business][established]': {required: false},
            accept_terms: { required: true }
        },
        messages: {
            'data[Business][name]': {required: "Enter business name."},
            'data[Business][category_id][]': {required: "Please select categories."},
            'data[Business][subcategory_id]': {required: "Please select sub-category."},
            'data[Business][min_age_group]': {required: "Enter min age."},
            'data[Business][max_age_group]': {required: "Enter max age."},
            'data[Business][student_ratio]':{required: "Enter student ratio."},
            'data[Business][teacher_ratio]':{required:"Enter teacher ratio."},
            'data[Business][city_id]': {required: "Please select a city."},
            'data[Business][locality_id]': {required: "Please select a locality."},
            'data[Business][address]': {required: "Please enter address."},
            'data[Business][landmark]': {required: "Please enter a landmark."},
            'data[Business][pincode]': {required: "Please enter pincode."},
            'data[Business][contact_person]': {required: "Please enter name of contact person."},
            'data[Business][phone]': {required: "Please enter your phone number."},
            'data[Business][email]': {required: "Please enter an email.",},//email: "Enter a valid email address."
            'data[Business][gender]': {required: "Please select a gender."},
            'data[Business][price]': {required: "Enter a price.",number: "Please enter a valid price."},
            'data[Business][max_price]':{required: "Enter max price.",number: "Please enter a valid price.",greaterThan:"Please enter max price more than min price"},
            'data[Business][seo_url]':{remote: "This name is already exists. Please try another one."},
            'data[Business][facilities]': {required: "Please enter facilities."},
            'data[Business][about_us]': {required: "Please write something about your business."},
            'data[Business][logo]': {required: "Upload a logo that describes your business.",},
            'BusinessType': {required: "Please select business type."},
            'data[Business][dob]': {required: "Please enter your date of birth."},
            'PreferredLocation': {required: "Please select preferred location."},
            'FreeDemoClass': {required: "Please elsect if have free demo class."},
            'data[Business][languages][]': {required: "Please select languages spoken."},
            'data[Business][tagline]': {required: "Please enter business tag line."},
            'data[Business][education]': {required: "Please enter your education details."},
            'data[Business][experience]': {required: "Please enter your experience details."},
            'data[Business][established]': {required: "Please select established date"},
            accept_terms: {required: "Please agree to our terms & conditions."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "BusinessLogo") {
                error.appendTo($("#BusinessLogoErr"));
            } else if (element.attr("id") == "BusinessMinAgeGroup") {
                error.appendTo($("#min_age_grp_error"));
            } else if (element.attr("id") == "BusinessCategoryId") {
                error.appendTo($("#BusinessCategoryErr"));
            } else if (element.attr("id") == "BusinessMaxAgeGroup") {
                error.appendTo($("#max_age_grp_error"));
            } else if (element.attr("id") == "BusinessLocalityId") {
                error.appendTo($("#BusinessLocalitysErr"));
            } else if (element.attr("id") == "BusinessStudentRatio") {
                error.appendTo($("#student_ratio_error"));
            } else if (element.attr("id") == "BusinessTeacherRatio") {
                error.appendTo($("#teacher_ratio_error"));
            } else if (element.attr("id") == "accept_terms") {
                error.appendTo($("#accept_termsErr"));
            } else if (element.attr("id") == "BusinessLanguages") {
                error.appendTo($("#BusinessLanguagesErr"));
            } else if (element.attr("name") == "PreferredLocation") {
                error.appendTo($("#PreferredLocationErr"));
            } else if (element.attr("name") == "FreeDemoClass") {
                error.appendTo($("#FreeDemoClassErr"));
            } else if (element.attr("name") == "BusinessType") {
                error.appendTo($("#BusinessTypeErr"));
            } else if (element.attr("id") == "phoneTags") {
                error.appendTo($("#BusinessPhoneErr"));
            } else if (element.attr("id") == "BusinessSeoUrl") {
                error.appendTo($("#BusinessSeoUrl").closest('.form-group'));
            } else {
                error.insertAfter(element);
            }
            
        }
    });
    if(mode == ''){
        if (validate.form()) {
            //$('#BusinessAddForm').submit();
            $('.user_valid_admin_add').html('Loading...');
            document.BusinessAddForm.submit();
        }else{
            $('input.error,textarea.error').eq(0).focus();
            setTimeout(function(){
                var inputPosid = $('input.error,textarea.error');
                if (!inputPosid.length) {
                    return;
                }
                var top = inputPosid.position().top-80;
                window.scrollTo(200,top);
            },200);
        }
    }
}

function valid_edit_user_form(mode) {
    var mode = mode || '';
    var validate = $('#UserEditForm').validate({
        rules: {
            'data[User][name]': {required: true,noSpecialChars: true},
            /*'data[User][username]': {required: true,remote: {async: false,type: 'post',url: HTTP_ROOT + "users/username_unique_edit",data: {id: $('#UserId').val()},dataType: 'json'}},*/
            'data[User][email]': {required: true,strictEmail:true,
                remote: {async: false,type: 'post',url: HTTP_ROOT + "users/email_unique_edit",data: {id: $('#UserId').val()},dataType: 'json'}},
            'data[User][phone]': {required: true,moblieNmuber: true,
                remote: {async: false,type: 'post',url: HTTP_ROOT + "users/phone_unique_edit",data: {id:$('#UserId').val()},dataType: 'json'}},
            'data[User][city]': {required: true},
            'data[User][pincode]': {required: true,indZip: true}
        },
        messages: {
            'data[User][name]': {required: "Please enter your name."},
            'data[User][username]': {required: "Please enter username.", 
                remote: "This username is already exists. Please try another one."},
            'data[User][email]': {required: "Please enter email.",email: "Please enter valid email address.",
                remote: "This email address is already exists. Please try another one."
            },
            'data[User][phone]': {required: "Please enter your phone number.",
                remote: "This phone number is already exists. Please try another one."
            },
            'data[User][city]': {required: "Please enter your city."},
            'data[User][pincode]': {required: "Please enter your pincode."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "UserPhone") {
                error.appendTo($("#UserPhoneErr"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if(mode == ''){
        if (validate.form()) {
            $('#UserEditForm').submit();
        }else{
            $('input.error,textarea.error').eq(0).focus();
        }
    }
}
function refer_form_valid() {
    $.validator.addMethod('multimail', function (value, element) {
        if (this.optional(element))
            return true;

        var flag = true;
        var addresses = value.replace(/\s/g, '').split(',');
        for (i = 0; i < addresses.length; i++) {
            flag = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(addresses[i]);
        }
        return flag;
    }, 'Enter email addresses separated by a comma.');
    var validate = $('#refer_friendForm').validate({
        rules: {
            'data[name]': {required: true},
            'data[email]': {required: true,multimail: true},
            'data[User][refer_security_code]': {required: true}
        },
        messages: {
            'data[name]': {required: "Please enter your name."},
            'data[email]': {required: "Please enter your friend's email address."},
            'data[User][refer_security_code]': {required: "Please enter the characters shown in the below image."}
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('error');
        },
    });
    if (validate.form()) {
        $('#refer_friendForm').submit();
    }else{
        $('input.error,textarea.error').eq(0).focus();
    }
}

function validate_contact_us(mode){
    var mode = mode || '';
    var validate = $('#FeedbackContactUsForm').validate({
        rules: {
            'data[Feedback][name]': {required: true,},
            'data[Feedback][email]': {required: true,moblieAndEmail: true},
            'data[Feedback][subject]': {required: true,},
            'data[Feedback][comment]': {required: true,}
        },
        messages: {
            'data[Feedback][name]': {required: "Please enter your name."},
            'data[Feedback][email]': {required: "Please enter email.",email: "Please enter valid email address.",moblieAndEmail:function(){
                        return isNaN($("#FeedbackEmail").val())?"Please enter valid email address.":"Please enter valid mobile number.";
                }},
            'data[Feedback][subject]': {required: "Please enter subject."},
            'data[Feedback][comment]': {required: "Please enter your message."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "FeedbackEmail") {
                error.appendTo($("#FeedbackEmailErr"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if(mode == ''){
        if (validate.form()) {
            $('#FeedbackContactUsForm').submit();
        }else{
            $('input.error,textarea.error').eq(0).focus();
        }
    }
}

function validate_feedback_user(mode){
    var mode = mode || '';
    var validate = $('#FeedbackFeedbackForm').validate({
        rules: {
            'data[Feedback][name]': {required: true},
            'data[Feedback][email]': {required: function(){return $('#FeedbackPhone').val()=='';},strictEmail:true},//email:true
            'data[Feedback][phone]': {required: function(){return $('#FeedbackEmail').val()=='';},moblieNmuber:true},
            'data[Feedback][comment]': {required: true},
            'data[Feedback][feedback_type]':{required:true},
            'data[User][refer_security_code]':{required:true}
        },
        messages: {
            'data[Feedback][name]': {required: "Please enter your name."},
            'data[Feedback][email]': {required: "Please enter email."},//email: "Please enter valid email address."
            'data[Feedback][phone]': {required: "Please enter your phone number."},
            'data[Feedback][comment]': {required: "Please enter your message."},
            'data[Feedback][feedback_type]':{required:"Please rate us."},
            'data[User][refer_security_code]':{required:"Please enter captcha code."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "data[Feedback][feedback_type]") {
                error.appendTo($("#rating_error"));
            }else if (element.attr("id") == "FeedbackPhone") {
                error.appendTo($("#FeedbackPhoneErr"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if(mode == ''){
        if (validate.form()) {
            $('#FeedbackFeedbackForm').submit();
        }else{
            $('input.error,textarea.error').eq(0).focus();
        }
    }
}

function valid_change_user_password_form() {
    var validate = $('#UserChangePasswordUserForm').validate({
        rules: {
            'data[User][current_password]': {required: true},
            'data[User][password1]': {required: true,minlength: 6},
            'data[User][password2]': {required: true,equalTo: "#UserPassword1",minlength: 6}
        },
        messages: {
            'data[User][current_password]': {required: "Please enter your current password."},
            'data[User][password1]': {required: "Please enter new password.",minlength:"Password length must be six character long."},
            'data[User][password2]': {required: "Please Re-enter new password",minlength:"Password length must be six character long.",equalTo: "Password & confirm password do not match."}
        }
    });
    if (validate.form()) {
        $('#UserChangePasswordUserForm').submit();
    }
}
function validate_inquiry(mode){
    var mode = mode || '';
    var validate = $('#InquiryLookingForTutorForm').validate({
        rules: {
            'data[Inquiry][name]': {required: true},
            'data[Inquiry][email]': {required: function(){return $('#InquiryPhone').val()=='';}, strictEmail:true},
            'data[Inquiry][phone]': {required: function(){return $('#InquiryEmail').val()=='';}, moblieNmuber:true},
            'data[Inquiry][comment]': {required: false},
            'data[Inquiry][category_id]':{required:true},
            //'data[Inquiry][sub_category_id]':{required:false},
            'data[Inquiry][min_age]':{required:true},
            'data[Inquiry][max_age]':{required:false,greaterThan: "select[name='data[Inquiry][min_age]']"},
            'data[Inquiry][type]':{required:true},
            'data[Inquiry][location]':{required:true},
            'data[Inquiry][city]':{required:true},
            'data[Inquiry][area]':{required:true},
            'accept_terms':{required:true},
            'data[User][refer_security_code]':{required:true}
        },
        messages: {
            'data[Inquiry][name]': {required: "Please enter your name."},
            'data[Inquiry][email]': {required: "Please enter email."},
            'data[Inquiry][phone]': {required: "Please enter your phone number."},
            'data[Inquiry][comment]': {required: "Please give your comment."},
            'data[Inquiry][category_id]':{required:"Please select category."},
            'data[Inquiry][sub_category_id]':{required:"Please select sub category."},
            'data[Inquiry][min_age]':{required:"Please select min age."},
            'data[Inquiry][max_age]':{required:"Please select max age."},
            'data[Inquiry][type]':{required:"Please select type."},
            'data[Inquiry][location]':{required:"Please select location."},
            'data[Inquiry][city]':{required:"Please enter city."},
            'data[Inquiry][area]':{required:"Please enter area."},
            'accept_terms':{required:"Please agree to our terms & conditions."},
            'data[User][refer_security_code]':{required:"Please enter characters shown in the image."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "accept_terms") {
                error.appendTo($("#accept_termsErr"));
            }else if (element.attr("name") == "data[User][refer_security_code]") {
                error.appendTo($("#captchaErr"));
            }else if (element.attr("id") == "InquiryPhone") {
                error.appendTo($("#InquiryPhoneErr"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if(mode == ''){
        if (validate.form()) {
            $('#InquiryLookingForTutorForm').submit();
        }else{
            $('input.error,textarea.error').eq(0).focus();
        }
    }
}
function validate_user_edit_business_faqs() {
    var validate = $('#BusinessFaqEditForm').validate({
        ignore: ".ignore, .select2-input",
        rules: {
            'data[BusinessFaq][title]': {required: true},
            'data[BusinessFaq][content]': {required: function () {
                    CKEDITOR.instances.BusinessFaqContent.updateElement();
                }
            }
        },
        messages: {
            'data[BusinessFaq][title]': {required: "Please enter title."},
            'data[BusinessFaq][content]': {required: "Please enter some content."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "BusinessFaqTitle") {
                error.appendTo($("#title_error"));
            } else if (element.attr("id") == "BusinessFaqContent") {
                error.appendTo($("#content_error"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if (validate.form()) {
        $('#BusinessFaqEditForm').submit();
    } else {
        return false;
    }
}
function validate_user_add_business_faqs() {
    var validate = $('#BusinessFaqAddForm').validate({
        ignore: ".ignore, .select2-input",
        rules: {
            'data[BusinessFaq][title]': {required: true},
            'data[BusinessFaq][content]': {required: function () {
                    CKEDITOR.instances.BusinessFaqContent.updateElement();
                }
            }
        },
        messages: {
            'data[BusinessFaq][title]': {required: "Please enter title."},
            'data[BusinessFaq][content]': {required: "Please enter some content."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "BusinessFaqTitle") {
                error.appendTo($("#title_error"));
            } else if (element.attr("id") == "BusinessFaqContent") {
                error.appendTo($("#content_error"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if (validate.form()) {
        $('#BusinessFaqAddForm').submit();
    } else {
        return false;
    }
}