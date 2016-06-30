$(document).ready(function () {
    $(document).on('change', '.dataTables_length select', function () {
        setCookie(CONTROLLER + ACTION + 'page_limit', $(this).val());
        if (typeof table != 'undefined') {
            setCookie(CONTROLLER + ACTION + 'page_no', parseInt(table.page()));
        }
    });
    $(document).on('click', '.pagination a', function () {
        page_no = parseInt($(this).text()) - 1;
        //page_no = parseInt($(this).attr('data-dt-idx')) - 1;
        //setCookie(CONTROLLER + ACTION + 'page_no', parseInt($(this).attr('data-dt-idx')) - 1);
        setCookie(CONTROLLER + ACTION + 'page_no', page_no);
    });
    $(document).on('click', '.table tr:eq(0) th', function () {
        setCookie(CONTROLLER + ACTION + 'page_sort', table.table(0).order());
    });

    $(document).on('click', '.mark_complete_conreq', function () {
        var id = $(this).attr('data-id');
        var state = $(this).attr('data-state');
        var mode = $(this).attr('data-mode');
        var dis_page_name = page_name=='contact_information_request'?'request':page_name;
        if (confirm('Are you sure to ' + (state == 'restore' ? "restore" : "mark complete") + ' the ' + dis_page_name + '?')) {
            //alert(id+' >> '+state+' >> '+mode);
            var params = {id: id, state: state, mode: mode};
            $.ajax({url: act_url, data: params, method: 'post', dataType: 'json',
                success: function (response) {
                    if (response.success == '1') {
                        $('#mark_complete_conreq_' + id).attr('data-state', (state != 'restore' ? "restore" : "markcomplete"));
                        $('#mark_complete_conreq_' + id).attr('data-original-title', (state != 'restore' ? "Restore" : "Mark Complete"));
                        $('#mark_complete_conreq_' + id).find('.ion').removeClass('ion-checkmark ion-refresh');
                        $('#mark_complete_conreq_' + id).find('.ion').addClass(state == 'restore' ? "ion-checkmark" : "ion-refresh");
                        $('#mark_complete_conreq_' + id).closest('tr').removeClass('restore markcomplete')
                        $('#mark_complete_conreq_' + id).closest('tr').addClass(state == 'restore' ? "markcomplete" : "restore");
                    }else{
                        alert(response.message);
                    }
                }
            });
        }
    });


    $('.pricevalue').on('keyup', function (event) {
        var price = $(this).val();
        var validprice = /^\d{0,10}(\.\d{0,2})?$/.test(price);
        $(this).val(validprice?price:price.slice(0,-1));
    });    
    $('.numbersOnly').on('keydown', function (event) {
        var key = window.event ? event.keyCode : event.which;
        var key_arr = [8, 46, 37, 39, 9, 91, 92, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105,110,190];
        if(jQuery.inArray(key, key_arr) > -1){return true;}else if(key < 48 || key > 57){return false;}else{return true;}
    });
    $('.alphaOnly').on('keydown', function (event) {
        if (event.altKey) {
            event.preventDefault();
        } else {
            var key = window.event ? event.keyCode : event.which;
            if (!((key == 8) || (key == 32) || (key == 9) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                event.preventDefault();
            }
        }
    });
    $.validator.addMethod("customlocality", function (value, element) {
        check_locality_exist('extra');
        return true;
    }, "City exist.");
    $.validator.addMethod("noSpecialChars", function (value, element) {
        return /^[A-Za-z\d=#$%@_ -]+$/.test(value);
    }, "Sorry, no special characters allowed.");
    $.validator.addMethod("moblieNmuber", function (value, element) {
        return /^([0|\+[0-9]{1,5})?([0-9][0-9]{9})$/.test(value);
    }, "Please enter a valid phone number.");
    $.validator.addMethod("strictEmail", function (value, element) {
        return /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
    }, "Please enter valid email address.")
    $.validator.addMethod("indZip", function (value, element) {
        return /(^\d{6}$)/.test(value);
    }, "Please enter valid pincode.");
    $.validator.addMethod('positiveNumber', function (value) { 
        return Number(value) > 0;
    }, 'Enter a valid amount greater than zero.');
    $.validator.addMethod("greaterThan", function (value, element, param) {
        if (value == '' || parseFloat(value) === 0) {
            return true;
        }
        var $min = $(param);
        if (this.settings.onfocusout) {
            $min.off(".validate-greaterThan").on("blur.validate-greaterThan", function () {
                $(element).valid();
            });
        }
        return parseFloat(value) > parseFloat($min.val());
    }, "Max age must be greater than min age.");
    $.validator.addMethod("greaterequal", function (value, element, param) {
        if (value == '' || parseFloat(value) === 0) {
            return true;
        }
        var $min = $(param);
        if (this.settings.onfocusout) {
            $min.off(".validate-greaterequal").on("blur.validate-greaterequal", function () {
                $(element).valid();
            });
        }
        return parseFloat(value) >= parseFloat($min.val());
    });
});
var mrClass_Global = {
    isobjEmpty: function (obj) {
        if (obj == null)
            return true;
        if (obj.length > 0)
            return false;
        if (obj.length === 0)
            return true;
        for (var key in obj) {
            if (hasOwnProperty.call(obj, key))
                return false;
        }
        return true;
    },
    format12to24: function (unformattedTime) {
        var time = unformattedTime;
        if (time == '') {
            return '';
        }
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
        return sHours + ":" + sMinutes + ":00";
    },
    format24to12: function (time) {
        time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
        if (time.length > 1) { // If time format correct
            time = time.slice(1);  // Remove full string match value
            time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
            time[0] = +time[0] % 12 || 12; // Adjust hours
        }
        return time.join(''); // return adjusted time or original string
    }
};
function getLocality(val) {
    $.ajax({
        type: "POST",
        url: HTTP_ROOT + "content/localities",
        data: {ctid: val},
        success: function (data) {
            $("#BusinessLocalityId").find('option:gt(0)').remove();
            $("#BusinessLocalityId").append(data);
        }
    });
}
function getsubCat(val) {
    $.ajax({
        type: "POST",
        url: HTTP_ROOT + "content/subcats",
        data: {catid: val},
        success: function (data) {
            $("#BusinessSubcategoryId").find('option:gt(0)').remove();
            $("#BusinessSubcategoryId").append(data);
        }
    });
}
function validate_password() {
    var validate = $('#UserChangePasswordForm').validate({
        rules: {
            'data[User][current_password]': {required: true},
            'data[User][password1]': {required: true, minlength: 5},
            'data[User][password2]': {required: true, equalTo: "#UserPassword1", minlength: 5}
        },
        messages: {
            'data[User][current_password]': {required: "Please enter old password."},
            'data[User][password1]': {required: "Please enter new password."},
            'data[User][password2]': {required: "Please Re-enter new password", equalTo: "Password & confirm password do not match."}
        }
    });
    if (validate.form()) {
        $('#UserChangePasswordForm').submit();
    }
}
function validate_facility() {
    var validate = $('#FacilityAddFacilityForm').validate({
        rules: {
            'data[Facility][name]': {required: true},
            'data[Facility][image]': {required: true}
        },
        messages: {
            'data[Facility][name]': {required: "Please enter facility name."},
            'data[Facility][image]': {required: "Please select facility icon."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "select") {
                error.appendTo($("#selectErr"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if (validate.form()) {
        $('#FacilityAddFacilityForm').submit();
    }
}
function validate_edit_facility() {
    var validate = $('#FacilityEditFacilityFormForm').validate({
        rules: {
            'data[Facility][name]': {required: true},
            'data[Facility][image]': {required: false}
        },
        messages: {
            'data[Facility][name]': {required: "Please enter facility name."},
            'data[Facility][image]': {required: "Please select facility icon."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "edit_facility_select") {
                error.appendTo($("#edit_facility_selectErr"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if (validate.form()) {
        $('#FacilityEditFacilityFormForm').submit();
    }
}

function admin_user_edit_valid(mode) {
    var mode = mode || '';
    var validate = $('#UserEditForm').validate({
        rules: {
            'data[User][name]': {required: true, noSpecialChars: true},
            //'data[User][username]': {required: true,remote: {async: false,type: 'post',url: HTTP_ROOT + "users/username_unique_edit",data: {id: $('#UserId').val()},dataType: 'json'}},
            'data[User][email]': {required: true, strictEmail: true,
                remote: {async: false, type: 'post', url: HTTP_ROOT + "users/email_unique_edit", data: {id: $('#UserId').val()}, dataType: 'json'}},
            'data[User][phone]': {required: true, moblieNmuber: true,
                remote: {async: false, type: 'post', url: HTTP_ROOT + "users/phone_unique_edit", data: {id: $('#UserId').val()}, dataType: 'json'}},
            'data[User][city]': {required: true},
            //'data[User][pincode]': {required: true,digits: true,indZip: true},
            'data[User][password]': {minlength: 6},
            'data[User][password_confirm]': {required: {depends: function (element) {
                        return (trim($('#UserPassword').val()) != '');
                    }}, minlength: 6, equalTo: "#UserPassword"}
        },
        messages: {
            'data[User][name]': {required: "Please enter user's name.", },
            'data[User][username]': {required: "Please enter username.",
                remote: "This username is already exists. Please try another one."},
            'data[User][email]': {required: "Please enter email.", email: "Please enter valid email address.",
                remote: "This email address is already exists. Please try another one."},
            'data[User][phone]': {required: "Please enter your phone number.",
                remote: "This phone number is already exists. Please try another one."},
            'data[User][city]': {required: "Please enter city."},
            'data[User][pincode]': {required: "Please enter pincode.", digits: "Please enter only numbers.", },
            'data[User][password]': {minlength: "Please enter at least 6 characters."},
            'data[User][password_confirm]': {required: "Please re-type the above password.", minlength: "Please enter at least 6 characters."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "UserPhone") {
                error.appendTo($("#UserPhoneErr"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if (mode == '') {
        if (validate.form()) {
            $('#UserEditForm').submit();
        }
    }
}

function validate_admin_profile(mode) {
    var mode = mode || '';
    var validate = $('#UserSaveProfileForm').validate({
        rules: {
            'data[User][name]': {required: true, noSpecialChars: true},
            'data[User][username]': {required: true,
                remote: {async: false, type: 'post', url: HTTP_ROOT + "users/username_unique_edit", data: {id: $('#UserId').val()}, dataType: 'json'}},
            'data[User][email]': {required: true, strictEmail: true,
                remote: {async: false, type: 'post', url: HTTP_ROOT + "users/email_unique_edit", data: {id: $('#UserId').val()}, dataType: 'json'}},
            'data[User][phone]': {required: true, moblieNmuber: true,
                remote: {async: false, type: 'post', url: HTTP_ROOT + "users/phone_unique_edit", data: {id: $('#UserId').val()}, dataType: 'json'}},
            'data[User][city]': {required: true},
            //'data[User][pincode]': {required: true,digits: true,indZip: true}
        },
        messages: {
            'data[User][name]': {required: "Please enter user's name."},
            'data[User][username]': {required: "Please enter username.",
                remote: "This username is already exists. Please try another one."},
            'data[User][email]': {required: "Please enter email.", email: "Please enter valid email address.",
                remote: "This email address is already exists. Please try another one."},
            'data[User][phone]': {required: "Please enter your phone number.",
                remote: "This phone number is already exists. Please try another one."},
            'data[User][city]': {required: "Please enter city."},
            'data[User][pincode]': {required: "Please enter pincode.", digits: "Please enter only numbers."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "UserPhone") {
                error.appendTo($("#UserPhoneErr"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if (mode == '') {
        if (validate.form()) {
            $('#UserSaveProfileForm').submit();
        }
    } else {
        $('input.error,textarea.error').eq(0).focus();
    }
}

function admin_add_user_valid(mode) {
    var mode = mode || '';
    var validate = $('#UserAddForm').validate({
        rules: {
            'data[User][name]': {required: true, noSpecialChars: true},
            'data[User][username]': {required: true,
                remote: {async: false, type: 'post', url: HTTP_ROOT + "users/username_unique_edit", data: {}, dataType: 'json'}},
            'data[User][email]': {required: true, strictEmail: true,
                remote: {async: false, type: 'post', url: HTTP_ROOT + "users/email_unique_edit", data: {}, dataType: 'json'}},
            'data[User][phone]': {required: true, moblieNmuber: true,
                remote: {async: false, type: 'post', url: HTTP_ROOT + "users/phone_unique_edit", data: {}, dataType: 'json'}},
            'data[User][password]': {required: true, minlength: 6},
            'data[User][password_confirm]': {required: true, minlength: 6, equalTo: '#UserPassword'},
            'data[User][city]': {required: true},
            //'data[User][pincode]': {required: true,digits: true,indZip: true}
        },
        messages: {
            'data[User][name]': {required: "Please enter user's name."},
            'data[User][username]': {required: "Please enter username.",
                remote: "This username is already exists. Please try another one."},
            'data[User][email]': {required: "Please enter email.", email: "Please enter valid email address.",
                remote: "This email address is already exists. Please try another one."},
            'data[User][phone]': {required: "Please enter your phone number.",
                remote: "This phone number is already exists. Please try another one."},
            'data[User][password]': {required: "Please enter password.", minlength: "Please enter at least 6 characters.", },
            'data[User][password_confirm]': {required: "Please enter the same password again.", minlength: "Please enter at least 6 characters.",
                remote: "Passwords do not match."},
            'data[User][city]': {required: "Please enter city."},
            'data[User][pincode]': {required: "Please enter pincode.", digits: "Please enter only numbers."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "UserPhone") {
                error.appendTo($("#UserPhoneErr"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if (mode == '') {
        if (validate.form()) {
            $('#UserAddForm').submit();
        } else {
            $('input.error,textarea.error').eq(0).focus();
        }
    }
}
function valid_adm_add_category(mode) {
    var mode = mode || '';
    var validate = $('#CategoryAdminAddForm').validate({
        rules: {
            'data[Category][name]': {required: true, },
            'data[Category][status]': {required: true, },
            'data[Category][description]': {required: true, },
            'data[Category][category_image]': {required: function () {
                    return !$("select[name='data[Category][parent_id]']").val() > 0;
                }, }
        },
        messages: {
            'data[Category][name]': {required: "Please enter category name."},
            'data[Category][status]': {required: "Please choose status.", },
            'data[Category][description]': {required: "Please enter category description.", },
            'data[Category][category_image]': {required: "Please choose an image to upload.", }
        }
    });
    if (mode == '') {
        if (validate.form()) {
            $('#CategoryAdminAddForm').submit();
        } else {
            $('input.error,textarea.error').eq(0).focus();
        }
    }
}
function adm_valid_category() {
    var validate = $('#CategoryAdminEditForm').validate({
        rules: {
            'data[Category][name]': {required: true, },
            'data[Category][status]': {required: true, },
            'data[Category][description]': {required: true, }
        },
        messages: {
            'data[Category][name]': {required: "Please enter category name."},
            'data[Category][status]': {required: "Please choose status.", },
            'data[Category][description]': {required: "Please enter category description.", }
        }
    });
    if (validate.form()) {
        $('#CategoryAdminEditForm').submit();
    }
}
function adm_city_add_valid() {
    var validate = $('#CityAdminAddForm').validate({
        rules: {
            'data[City][name]': {required: true,
                remote: {async: false, type: 'post', url: HTTP_ROOT + "cities/cityname_unique_edit", data: {}, dataType: 'json'}},
            'data[City][status]': {required: true, }
        },
        messages: {
            'data[City][name]': {required: "Please enter city name.",
                remote: "City already exists. Enter a new one."},
            'data[City][status]': {required: "Please choose status.", }
        }
    });
    if (validate.form()) {
        $('#CityAdminAddForm').submit();
    }
}
function adm_edit_city_valid() {
    var validate = $('#CityAdminEditForm').validate({
        rules: {
            'data[City][name]': {required: true,
                remote: {async: false, type: 'post', url: HTTP_ROOT + "cities/cityname_unique_edit", data: {id: $('#cmp_id').val()}, dataType: 'json'}},
            'data[City][status]': {required: true, }
        },
        messages: {
            'data[City][name]': {required: "Please enter city name.",
                remote: "City already exists. Enter a new one."},
            'data[City][status]': {required: "Please choose status.", }
        }
    });
    if (validate.form()) {
        $('#CityAdminEditForm').submit();
    }
}
function adm_add_local_valid(mode) {
    var mode = mode || '';
    var flag = true;
    var validate = $('#LocalityAdminAddForm').validate({
        rules: {
            'data[Locality][city_id]': {required: true, },
            'data[Locality][name]': {required: true, customlocality: true},
            'data[Locality][status]': {required: true, }
        },
        messages: {
            'data[Locality][city_id]': {required: "Please choose city."},
            'data[Locality][name]': {required: "Please enter locality name.",
                remote: "Locality exists. Enter a new one."},
            'data[Locality][status]': {required: "Please choose status.", }
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "LocalityName") {
                error.appendTo($("#LocalityNameErr"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            check_locality_exist('submithandler', form);
            return false;
        }
    });
    if (mode == '') {
        if (validate.form()) {
            $('#LocalityAdminAddForm').submit();
        }
    }
}
function adm_edit_local_valid() {
    var validate = $('#LocalityAdminEditForm').validate({
        rules: {
            'data[Locality][city_id]': {required: true, },
            'data[Locality][name]': {required: true, customlocality: true},
            'data[Locality][status]': {required: true, }
        },
        messages: {
            'data[Locality][city_id]': {required: "Please choose city."},
            'data[Locality][name]': {required: "Please enter locality name.", },
            'data[Locality][status]': {required: "Please choose status.", }
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "LocalityName") {
                error.appendTo($("#LocalityNameErr"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            check_locality_exist('submithandler', form);
            return false;
        }
    });
    if (validate.form()) {
        $('#LocalityAdminEditForm').submit();
    }
}
function valid_admin_add() {
    var validate = $('#BusinessAddForm').validate({
        rules: {
			//'data[Business][package_id]': {required: true, },
            'data[Business][user_id]': {required: true, },
            'data[Business][name]': {required: true, },
            'data[Business][category_id][]': {required: true, },
            'data[Business][subcategory_id]': {required: true, },
            'data[Business][min_age_group]': {required: true, },
            'data[Business][max_age_group]': {required: true, greaterThan: '#BusinessMinAgeGroup'},
            'data[Business][student_ratio]': {required: function (element) {
                    return $('#BusinessTeacherRatio').val() != '';
                }},
            'data[Business][teacher_ratio]': {required: function (element) {
                    return $('#BusinessStudentRatio').val() != '';
                }},
            'data[Business][dob]': {
                required: false
                        /*function(element){return !($('input[type="radio"][name="data[Business][type]"]:checked').val() == "group");}*/
            },
            'data[Business][education]': {
                required: function (element) {
                    return !($('input[type="radio"][name="data[Business][type]"]:checked').val() == "group");
                }
            },
            //'data[Business][tagline]':{required:function(element){return !($('input[type="radio"][name="data[Business][type]"]:checked').val() == "group");}},
            'data[Business][experience]': {
                required: function (element) {
                    return !($('input[type="radio"][name="data[Business][type]"]:checked').val() == "group");
                }
            },
            'data[Business][languages][]': {
                required: function (element) {
                    return !($('input[type="radio"][name="data[Business][type]"]:checked').val() == "group");
                }
            },
            'data[Business][city_id]': {required: true, },
            'data[Business][locality_id]': {required: true, },
            'data[Business][address]': {required: true, },
            'data[Business][landmark]': {required: false, },
            'data[Business][pincode]': {required: true, indZip: true},
            'data[Business][contact_person]': {required: true, },
            //'data[Business][phone]': {required: true,moblieNmuber: false},
            'data[Business][email]': {required: true, strictEmail: true, },
            'data[Business][website]': {required: false, url: true},
            'data[Business][facebook]': {required: false, url: true},
            'data[Business][twitter]': {required: false, url: true},
            'data[Business][gplus]': {required: false, url: true},
            'data[Business][youtube]': {required: false, url: true},
            'data[Business][gender]': {required: true, },
            'data[Business][price]': {required: true, number: true},
            'data[Business][max_price]': {required: false, number: true, greaterThan: "input[name='data[Business][price]']"},
            'data[Business][facilities]': {required: false, },
            'data[Business][about_us]': {required: false, },
            'data[Business][logo]': {required: false, }
        },
        messages: {
            //'data[Business][package_id]': {required: "Please select a subscription."},
            'data[Business][user_id]': {required: "Please select an user."},
            'data[Business][name]': {required: "Enter business name."},
            'data[Business][category_id][]': {required: "Please select categories."},
            'data[Business][subcategory_id][]': {required: "Please select sub-category."},
            'data[Business][min_age_group]': {required: "Please enter min-age."},
            'data[Business][max_age_group]': {required: "Please enter max-age."},
            'data[Business][student_ratio]': {required: "Enter student ratio."},
            'data[Business][teacher_ratio]': {required: "Enter teacher ratio."},
            'data[Business][dob]': {required: "Please enter date of birth."},
            'data[Business][education]': {required: "Please enter education."},
            'data[Business][tagline]': {required: "Please enter tagline."},
            'data[Business][experience]': {required: "Please enter experience."},
            'data[Business][languages][]': {required: "Please select languages."},
            'data[Business][city_id]': {required: "Please select a city."},
            'data[Business][locality_id]': {required: "Please select a locality."},
            'data[Business][address]': {required: "Please enter address."},
            'data[Business][landmark]': {required: "Please enter a landmark."},
            'data[Business][pincode]': {required: "Please enter pincode."},
            'data[Business][contact_person]': {required: "Please enter name of contact person."},
            // 'data[Business][phone]': {
            //     required: "Please enter your phone number."
            // },
            'data[Business][email]': {required: "Please enter an email."},
            'data[Business][gender]': {required: "Please select a gender."},
            'data[Business][price]': {required: "Enter a price.", number: "Please enter a valid number."},
            'data[Business][max_price]': {required: "Enter max price.", number: "Please enter a valid price.", greaterThan: "Please enter max price more than min price"},
            'data[Business][facilities]': {required: "Please enter facilities."},
            'data[Business][about_us]': {required: "Please write something about your business."},
            'data[Business][logo]': {required: "Upload a logo that describes your business.", }
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "BusinessCategoryId") {
                error.appendTo($("#BusinessCategoryIdErr"));
            } else if (element.attr("id") == "BusinessMinAgeGroup") {
                error.appendTo($("#BusinessMinAgeGroupErr"));
            } else if (element.attr("id") == "BusinessMaxAgeGroup") {
                error.appendTo($("#BusinessMaxAgeGroupErr"));
            } else if (element.attr("id") == "BusinessStudentRatio") {
                error.appendTo($('#student_ratio_error'));
            } else if (element.attr("id") == "BusinessTeacherRatio") {
                error.appendTo($('#teacher_ratio_error'));
            } else if (element.attr("id") == "BusinessGender") {
                error.appendTo($("#BusinessGenderErr"));
            } else if (element.attr("id") == "BusinessSubcategoryId") {
                error.appendTo($("#BusinessSubcategoryIdErr"));
            } else if (element.attr("id") == "BusinessCityId") {
                error.appendTo($("#BusinessCityIdErr"));
            } else if (element.attr("id") == "BusinessLocalityId") {
                error.appendTo($("#BusinessLocalityIdErr"));
            } else if (element.attr("id") == "BusinessLanguages") {
                error.appendTo($("#BusinessLanguagesErr"));
            } else if (element.attr("id") == "BusinessUserId") {
                error.appendTo($('#BusinessUserIdErr'));
			}else if(element.attr("id") == "BusinessPackageId"){
				error.appendTo($("#BusinessPackageIdErr"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if (validate.form()) {

        if (typeof $("#BusinessPhone").tagsinput('items') == 'object' && $("#BusinessPhone").tagsinput('items').length > 0) {
            $('#BusinessAddForm').submit();
        } else {
            alert("Enter phone number(s).")
            $('.form-group').find('.bootstrap-tagsinput').find('input[type="text"]').focus();
        }
    } else {
        $('input.error,textarea.error').eq(0).focus();
    }
}

function admin_edit_business_valid() {
    var validate = $('#BusinessEditForm').validate({
        ignore: ":hidden",
        rules: {
            'data[Business][user_id]': {required: true, },
            'data[Business][name]': {required: true, },
            'data[Business][category_id][]': {required: true, },
            'data[Business][subcategory_id]': {required: true, },
            'data[Business][min_age_group]': {required: true, },
            'data[Business][max_age_group]': {required: true, greaterThan: '#BusinessMinAgeGroup'},
            'data[Business][student_ratio]': {required: function (element) {
                    return $('#BusinessTeacherRatio').val() != '';
                }},
            'data[Business][teacher_ratio]': {required: function (element) {
                    return $('#BusinessStudentRatio').val() != '';
                }},
            'data[Business][dob]': {required: false/*function(element){ return !($('#contact').is(':visible'));}*/},
            'data[Business][education]': {required: function (element) {
                    return !($('#contact').is(':visible'));
                }},
            //'data[Business][tagline]':{required:function(element){return !($('#contact').is(':visible'));}},
            'data[Business][experience]': {required: function (element) {
                    return !($('#contact').is(':visible'));
                }},
            'data[Business][languages][]': {required: function (element) {
                    return !($('#contact').is(':visible'));
                }},
            'data[Business][city_id]': {required: true, },
            'data[Business][locality_id]': {required: true, },
            'data[Business][address]': {required: true, },
            'data[Business][landmark]': {required: false, },
            'data[Business][pincode]': {required: true, indZip: true},
            'data[Business][contact_person]': {required: true, },
            'data[Business][phone]': {required: true, moblieNmuber: false},
            'data[Business][email]': {required: true, strictEmail: true}, //,email: true
            'data[Business][website]': {required: false, url: true},
            'data[Business][facebook]': {required: false, url: true},
            'data[Business][twitter]': {required: false, url: true},
            'data[Business][gplus]': {required: false, url: true},
            'data[Business][youtube]': {required: false, url: true},
            'data[Business][gender]': {required: true, },
            'data[Business][price]': {required: true, number: true},
            'data[Business][max_price]': {required: false, number: true, greaterThan: "input[name='data[Business][price]']"},
            'data[Business][facilities]': {required: false, },
            'data[Business][about_us]': {required: false, },
            'data[Business][logo]': {required: false, }
        },
        messages: {
            'data[Business][user_id]': {required: "Please select an user."},
            'data[Business][name]': {required: "Enter business name."},
            'data[Business][category_id][]': {required: "Please select categories."},
            'data[Business][subcategory_id]': {required: "Please select sub-category."},
            'data[Business][min_age_group]': {required: "Please enter min-age."},
            'data[Business][max_age_group]': {required: "Please enter max-age."},
            'data[Business][student_ratio]': {required: "Enter student ratio."},
            'data[Business][teacher_ratio]': {required: "Enter teacher ratio."},
            'data[Business][dob]': {required: "Please enter date of birth."},
            'data[Business][education]': {required: "Please enter education."},
            'data[Business][tagline]': {required: "Please enter tagline."},
            'data[Business][experience]': {required: "Please enter experience."},
            'data[Business][languages][]': {required: "Please select languages."},
            'data[Business][city_id]': {required: "Please select a city."},
            'data[Business][locality_id]': {required: "Please select a locality."},
            'data[Business][address]': {required: "Please enter address."},
            'data[Business][landmark]': {required: "Please enter a landmark."},
            'data[Business][pincode]': {required: "Please enter pincode."},
            'data[Business][contact_person]': {required: "Please enter name of contact person."},
            'data[Business][phone]': {required: "Please enter your phone number."},
            'data[Business][email]': {required: "Please enter an email.", //email: "Enter a valid email address."
            },
            'data[Business][website]': {required: "Enter the website address."},
            'data[Business][facebook]': {required: "Enter the facebook page address."},
            'data[Business][twitter]': {required: "Enter the twitter page address."},
            'data[Business][gender]': {required: "Please select a gender."},
            'data[Business][price]': {required: "Enter a price.", number: "Please enter a valid number."},
            'data[Business][max_price]': {required: "Enter max price.", number: "Please enter a valid price.", greaterThan: "Please enter max price more than min price"},
            'data[Business][facilities]': {required: "Please enter facilities."},
            'data[Business][about_us]': {required: "Please write something about your business."},
            'data[Business][logo]': {required: "Upload a logo that describes your business.", }
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "edit_langs") {
                error.appendTo(element.parent('.col-sm-10'));
            } else if (element.attr("id") == "BusinessLanguages") {
                error.appendTo($("#BusinessLanguagesErr"));
            } else if (element.attr("id") == "BusinessUserId") {
                error.appendTo($('#BusinessUserIdErr'));
            } else if (element.attr("id") == "BusinessMinAgeGroup") {
                error.appendTo($('#BusinessMinAgeGroupErr'));
            } else if (element.attr("id") == "BusinessMaxAgeGroup") {
                error.appendTo($('#BusinessMaxAgeGroupErr'));
            } else if (element.attr("id") == "BusinessStudentRatio") {
                error.appendTo($('#student_ratio_error'));
            } else if (element.attr("id") == "BusinessTeacherRatio") {
                error.appendTo($('#teacher_ratio_error'));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if ($("#logo_old").length > 0 && $('#logo_old').val() != '') {
        $("input[name='data[Business][logo]']").rules("remove", "required");
    } else {
        //$("input[name='data[Business][logo]']").rules("add","required");
    }
    if (validate.form()) {
        if ($('#contact').is(':visible')) {
            if (typeof $("#BusinessPhone").tagsinput('items') == 'object' && $("#BusinessPhone").tagsinput('items').length > 0) {
                $('#BusinessEditForm').submit();
            } else {
                alert("Enter phone number(s).")
            }
        } else {
            $('#BusinessEditForm').submit();
        }
    } else {
        $('input.error,textarea.error').eq(0).focus();
    }
}
function AdminForgotPasswordValid() {
    var validate = $('#UserForgotPasswordForm').validate({
        rules: {
            'data[User][email]': {
                required: true,
                strictEmail: true
            }
        },
        messages: {
            'data[User][email]': {
                required: "Please enter your email address."
            }
        }
    });
    if (validate.form()) {
        $('#UserForgotPasswordForm').submit();
    }
}
function AdminResetPasswordValid() {
    var validate = $('#UserAdminResetForm').validate({
        rules: {
            'data[User][password]': {required: true},
            'data[User][password_confirm]': {required: true, equalto: "#UserPassword"}
        },
        messages: {
            'data[User][password]': {required: "Please enter your new password."},
            'data[User][password_confirm]': {required: "Repeat the password again.", equalto: "Password & confirm password must be equal."}
        }
    });
    if (validate.form()) {
        $('#UserAdminResetForm').submit();
    }
}

function rating_content_valid() {
    var validate = $('#BusinessRatingAdminSaveRatingContentForm').validate({
        rules: {
            'data[BusinessRating][comment]': {required: true}
        },
        messages: {
            'data[BusinessRating][comment]': {required: "Please enter some content."}
        }
    });
    if (validate.form()) {
        $('#BusinessRatingAdminSaveRatingContentForm').submit();
    }
}


function validate_bulk_mail() {
    var validate = $('#BulkEmailSendBulkEmailForm').validate({
        ignore: ".ignore, .select2-input",
        rules: {
            'data[BulkEmail][users_email][]': {required: true},
            'data[BulkEmail][subject]': {required: true},
            'data[BulkEmail][description]': {required: function () {
                    CKEDITOR.instances.email_description.updateElement();
                }
            }
        },
        messages: {
            'data[BulkEmail][users_email][]': {required: "Please select email(s)."},
            'data[BulkEmail][subject]': {required: "Please enter subject."},
            'data[BulkEmail][description]': {required: "Please enter some description."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "BulkEmailUsersEmail") {
                error.appendTo($("#bulkmail_error"));
            } else if (element.attr("id") == "BulkEmailSubject") {
                error.appendTo($("#subject_error"));
            } else if (element.attr("id") == "email_description") {
                error.appendTo("#bulkmail_desc_error");
            } else {
                error.insertAfter(element);
            }
        }
    });
    if (validate.form()) {
        $('#BulkEmailSendBulkEmailForm').submit();
    } else {
        return false;
    }
}
function validate_business_faqs(obj) {
    var validate = $('#BusinessFaqAdminAddForm').validate({
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
        $('#BusinessFaqAdminAddForm').submit();
    } else {
        return false;
    }
}
function validate_edit_business_faqs() {
    var validate = $('#BusinessFaqAdminEditForm').validate({
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
        $('#BusinessFaqAdminEditForm').submit();
    } else {
        return false;
    }
}
function validate_admin_package_add() {
    var validate = $('#PackageAddForm').validate({
        rules: {
            'data[Package][name]': {required: true},
            'data[Package][price]': {required: true},
            'data[Package][priority_search]': {required: true},
            'data[Package][personal_subdomain]': {required: true},
            'data[Package][social_media_widget]': {required: true},
            'data[Package][map_integration]': {required: true},
            'data[Package][photo_limit]': {required: true},
            'data[Package][video_limit]': {required: true},
            'data[Package][subscription]': {required: true},
            'data[Package][listing_period]': {required: true},
            'data[Package][payment_method]': {required: true},
            'data[Package][enquiries]': {required: true},
            'data[Package][address_detail]': {required: true},
            'data[Package][call_request]': {required: true},
            'data[Package][review]': {required: true},
            'data[Package][faq]': {required: true}
        },
        messages: {
            'data[Package][name]': {required: "Please enter package name."},
            'data[Package][price]': {required: "Please enter price."},
            'data[Package][priority_search]': {required: "Please select priority search rights."},
            'data[Package][personal_subdomain]': {required: "Please select personal sub-domain rights."},
            'data[Package][social_media_widget]': {required: "Please select social media widget rights."},
            'data[Package][map_integration]': {required: "Please select map integration rights."},
            'data[Package][photo_limit]': {required: "Please enter photo upload limits."},
            'data[Package][video_limit]': {required: "Please enter video limits."},
            'data[Package][subscription]': {required: "Please enter subscription limits."},
            'data[Package][listing_period]': {required: "Please enter listing period."},
            'data[Package][payment_method]': {required: "Please enter payment method."},
            'data[Package][enquiries]': {required: "Please enter enquiry limit."},
            'data[Package][address_detail]': {required: "Please select adress detail rights."},
            'data[Package][call_request]': {required:"Please select call request rights."},
            'data[Package][review]': {required: "Please enter reviews limit."},
            'data[Package][faq]': {required: "Please select faq limits."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "PackagePriorityY") {
                error.appendTo($("#priority_seacrh_error"));
            }else if(element.attr("id") == "PackagePersonalSubdomainY"){
                error.appendTo($("#personal_sub_error"));
            }else if(element.attr("id") == "PackageSocialMediaWidgetY"){
                error.appendTo($("#social_media_error"));
            }else if(element.attr("id") == "PackageMapIntegrationY"){
                error.appendTo($("#map_integration_error"));
            }else if(element.attr("id") == "PackageAddressDetailY"){
                error.appendTo($("#address_detail_error"));
            }else if(element.attr("id") == "PackageCallRequestY"){
                error.appendTo($("#call_request_error"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if (validate.form()) {
        $('#PackageAddForm').submit();
    } else {
        validate.focusInvalid();
        return false;
    }
}

function validate_admin_package_edit() {
    var validate = $('#PackageEditForm').validate({
        rules: {
            'data[Package][name]': {required: true},
            'data[Package][price]': {required: true},
            'data[Package][priority_search]': {required: true},
            'data[Package][personal_subdomain]': {required: true},
            'data[Package][social_media_widget]': {required: true},
            'data[Package][map_integration]': {required: true},
            'data[Package][photo_limit]': {required: true},
            'data[Package][video_limit]': {required: true},
            'data[Package][subscription]': {required: true},
            'data[Package][listing_period]': {required: true},
            'data[Package][payment_method]': {required: true},
            'data[Package][enquiries]': {required: true},
            'data[Package][address_detail]': {required: true},
            'data[Package][call_request]': {required: true},
            'data[Package][review]': {required: true},
            'data[Package][faq]': {required: true}
        },
        messages: {
            'data[Package][name]': {required: "Please enter package name."},
            'data[Package][price]': {required: "Please enter price."},
            'data[Package][priority_search]': {required: "Please select priority search rights."},
            'data[Package][personal_subdomain]': {required: "Please select personal sub-domain rights."},
            'data[Package][social_media_widget]': {required: "Please select social media widget rights."},
            'data[Package][map_integration]': {required: "Please select map integration rights."},
            'data[Package][photo_limit]': {required: "Please enter photo upload limits."},
            'data[Package][video_limit]': {required: "Please enter video limits."},
            'data[Package][subscription]': {required: "Please enter subscription limits."},
            'data[Package][listing_period]': {required: "Please enter listing period."},
            'data[Package][payment_method]': {required: "Please enter payment method."},
            'data[Package][enquiries]': {required: "Please enter enquiry limit."},
            'data[Package][address_detail]': {required: "Please select adress detail rights."},
            'data[Package][call_request]': {required:"Please select call request rights."},
            'data[Package][review]': {required: "Please enter reviews limit."},
            'data[Package][faq]': {required: "Please select faq limits."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "PackagePriorityY") {
                error.appendTo($("#priority_seacrh_error"));
            }else if(element.attr("id") == "PackagePersonalSubdomainY"){
                error.appendTo($("#personal_sub_error"));
            }else if(element.attr("id") == "PackageSocialMediaWidgetY"){
                error.appendTo($("#social_media_error"));
            }else if(element.attr("id") == "PackageMapIntegrationY"){
                error.appendTo($("#map_integration_error"));
            }else if(element.attr("id") == "PackageAddressDetailY"){
                error.appendTo($("#address_detail_error"));
            }else if(element.attr("id") == "PackageCallRequestY"){
                error.appendTo($("#call_request_error"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if (validate.form()) {
        $('#PackageEditForm').submit();
    } else {
        validate.focusInvalid();
        return false;
    }
}
function admin_add_transaction() {
    var validate = $('#TransactionAddForm').validate({
        rules: {
            'data[Transaction][user_id]': {required: true},
            'data[Transaction][package_id]': {required: true},
            'data[Transaction][mode]': {required: true},
            'data[Transaction][reference_number]': {required: true},
            'data[Transaction][issued_date]': {required: true},
            'data[Transaction][status]': {required: true}
        },
        messages: {
            'data[Transaction][user_id]': {required: "Please select an user."},
            'data[Transaction][package_id]': {required: "Please select the subscription package."},
            'data[Transaction][mode]': {required: "Please select transaction mode."},
            'data[Transaction][reference_number]': {required: "Please enter reference number."},
            'data[Transaction][issued_date]': {required: "Please enter date."},
            'data[Transaction][status]': {required: "Please select transaction status."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "TranscationUserId") {
                error.appendTo($("#TransactionUserIdErr"));
            }else if(element.attr("id") == "TransactionPackageId"){
                error.appendTo($("#TransactionPackageIdErr"));
            }else if(element.attr("id") == "TranscationMode"){
                error.appendTo($("#TransactionModeErr"));
            }else if(element.attr("id") == "TranscationStatus"){
                error.appendTo($("#TransactionStatusErr"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if (validate.form()) {
        $('#TransactionAddForm').submit();
    } else {
        validate.focusInvalid();
        return false;
    }
}
function admin_add_subscription() {
    var validate = $('#SubscriptionAddForm').validate({
        rules: {
            'data[Subscription][user_id]': {required: true},
            'data[Subscription][package_id]': {required: true},
            'data[Subscription][subscription_start]':{required: function(element){return $('#SubscriptionSubscriptionEnd').val()!='';}},
            'data[Subscription][subscription_end]':{required: function(element){return $('#SubscriptionSubscriptionStart').val()!='';}}

        },
        messages: {
            'data[Subscription][user_id]': {required: "Please select an user."},
            'data[Subscription][package_id]': {required: "Please select the subscription package."},
            'data[Subscription][subscription_start]':{required: "Enter subscription start date."},
            'data[Subscription][subscription_end]':{required:"Enter subscription end date."},
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "SubscriptionUserId") {
                error.appendTo($("#SubscriptionUserIdErr"));
            }else if(element.attr("id") == "SubscriptionPackageId"){
                error.appendTo($("#SubscriptionPackageIdErr"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if (validate.form()) {
        $('#SubscriptionAddForm').submit();
    } else {
        validate.focusInvalid();
        return false;
    }
}
function admin_add_advertisement(obj) {
    var obj = $(obj);
    var form = obj.closest('form');
    var form_id = $(form).attr('id');
    var validate = $('#'+form_id).validate({
        ignore: "",
        rules: {
            'data[Advertisement][name]': {required: true},
            'data[Advertisement][page_id]': {required: true},
            'data[Advertisement][image]':{required: true},
            'data[Advertisement][contact_name]':{required: true},
            'data[Advertisement][email]':{required: true, strictEmail: true},
            'data[Advertisement][cost_per_view]':{required: true},
            'data[Advertisement][budget_price]':{required: true,greaterequal: '#AdvertisementCostPerView'},
            'data[Advertisement][campaign_range]':{required: function(){
                   return $('#run_daily').is(':checked') ? false :true ;
            }}
        },
        messages: {
            'data[Advertisement][name]': {required: "Please select ad name."},
            'data[Advertisement][page_id]': {required: "Please select a page to display the ad."},
            'data[Advertisement][image]':{required: "Please upload a banner ad."},
            'data[Advertisement][contact_name]':{required: "Please enter contact person name."},
            'data[Advertisement][email]':{required: "Please select enter person email."},
            'data[Advertisement][cost_per_view]':{required: "Please enter cost per view."},
            'data[Advertisement][budget_price]':{required: "Please enter total budget price.",greaterequal:"Budget price must be greater than cost per view."},
            'data[Advertisement][campaign_range]':{required: "Please enter the date range."}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "AdvertisementName") {
                error.appendTo($("#AdvertisementName_error"));
            }else if(element.attr("id") == "AdvertisementPageId"){
                error.appendTo($("#AdvertisementPageId_error"));
            }else if(element.attr("id") == "banner_id"){
                error.appendTo($("#banner_file_input_error"));
            }else if(element.attr("id") == "AdvertisementContactName"){
                error.appendTo($("#AdvertisementContactName_error"));
            }else if(element.attr("id") == "AdvertisementEmail"){
                error.appendTo($("#AdvertisementEmail_error"));
            }else if(element.attr("id") == "AdvertisementCostPerView"){
                error.appendTo($("#AdvertisementCostPerView_error"));
            }else if(element.attr("id") == "AdvertisementBudgetPrice"){
                error.appendTo($("#AdvertisementBudgetPrice_error"));
            }else if(element.attr("id") == "AdvertisementCostPerView"){
                error.appendTo($("#AdvertisementDateRange_error"));
            }else {
                error.insertAfter(element);
            }
        }
    });
    if (validate.form()) {
        $('#'+form_id).submit();
    } else {
        validate.focusInvalid();
        return false;
    }
}
function check_locality_exist(el, form) {
    var form = form || '';
    if ($('#LocalityCityId').val() > 0) {
        $('#LocalityNameErr').html('');
        $.ajax({
            url: HTTP_ROOT + "localities/locality_unique_edit",
            async: false,
            type: 'post',
            dataType: 'json',
            data: {cityId: $('#LocalityCityId').val(), name: $("#LocalityName").val(), id: $("#LocalityId").val()},
            success: function (res) {
                if (res === false) {
                    $('#LocalityNameErr').css('color', 'red').html('Locality exists.Enter a new one.');
                } else if (form != '') {
                    document.LocalityAdminAddForm.submit();
                }
                return res;
            }
        });
    } else {
        return false;
    }
}
