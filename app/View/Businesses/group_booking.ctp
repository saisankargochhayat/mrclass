<div class="pop-up-box group_booking">
    <div class="up_mc_top book_now">
        <h2>Group Booking</h2></div>
    <div class="cb20"></div>
    <div class="pop-up-form fl">
            <?php echo $this->Form->create('GroupBookingRequest', array('autocomplete' => 'off','url' => '/businesses/group_booking_save/')); ?>
                <div class="form-group">
                    <div class="fl half-form-control">
                        <label for="GroupBookingRequestName">Contact person name:</label>
                        <span>
                            <?php echo $this->Form->input('name', array('placeholder' => 'Enter Name', 'class' => 'form-control', 'div' => false, 'label' => false, 'style' => "width:285px;"));?>
                            <span class="err-msg" id="GroupBookingRequestNameErr"></span>
                        </span>
                    </div>
                    <div style="visibility:hidden" class="fl to-diff">to</div>
                    <div class="fl half-form-control">
                        <label for="GroupBookingRequestPhone">Phone Number:</label>
                        <span>
                            <?php echo $this->Form->input('phone', array('placeholder' => 'Enter Phone Number', 'class' => 'form-control numbersOnly', 'div' => false, 'label' => false, 'style' => "width:285px;",'maxlength'=>15));?>
                            <span class="err-msg" id="GroupBookingRequestPhoneErr"></span>
                        </span>
                    </div>
                    <div class="cb"></div>

                </div>
                <div class="form-group">
                    <div class="fl half-form-control">
                        <label for="GroupBookingRequestEmail">Email:</label>
                        <span>
                            <?php echo $this->Form->input('email', array('placeholder' => 'Enter Email', 'class' => 'form-control', 'div' => false, 'label' => false, 'style' => "width:285px;"));?>

                        </span>
                    </div>
                    <div style="visibility:hidden" class="fl to-diff">to</div>
                    <div class="fl half-form-control">
                        <label for="GroupBookingRequestGroupSize">Group size:</label>
                        <span>
                           <?php echo $this->Form->input('group_size', array( 'options' => array("2 to 5"=>"2 to 5","6 to 10"=>"6 to 10","11 to 15"=>"11 to 15","16 or more"=>"16 or more"),'class' => 'form-control', 'empty' => 'Select group size' ,'div' => false, 'label' => false, 'style' => "width:285px;"));?>
                            <span class="err-msg" id="GroupBookingRequestGroupSizeErr"></span>

                        </span>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-group">
                    <label for="GroupBookingRequestLookingFor" class="fl">Looking For:</label>
                    <div class="frm-data fl">
                        <?php echo $this->Form->input('looking_for', array('type' => 'textarea','placeholder' => 'What are you looking for', 'class' => 'form-control height-plus', 'div' => false, 'label' => false, 'style' => "width:606px;"));?>
                            <div class="cb"></div>
                            <span class="err-msg" id="GroupBookingRequestLookingForErr"></span>
                            <br/>
                            <span class="note">*e.g. Dance Teacher/Aerobics Teacher</span>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-group">
                    <div class="fl half-form-control">
                        <label for="GroupBookingRequestAddress">Address:</label>
                        <span>
                            <?php echo $this->Form->input('address', array('placeholder' => 'Enter Address', 'class' => 'form-control', 'div' => false, 'label' => false, 'style' => "width:285px;"));?>
                            <span class="err-msg" id="GroupBookingRequestAddressErr"></span>
                        </span>
                    </div>
                    <div style="visibility:hidden" class="fl to-diff">to</div>
                    <div class="fl half-form-control">
                        <label for="GBBusinessCityId">Select city:</label>
                        <span>
                           <?php echo $this->Form->input('city_id', array( 'options' => $ucities,'class' => 'form-control', 'empty' => 'Select city', 'id' => 'GBBusinessCityId' ,'div' => false, 'label' => false, 'style' => "width:285px;"));?>
                            <span class="err-msg" id="GBBusinessCityIdErr"></span>
                        </span>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-group">
                    <div class="fl half-form-control">
                        <label for="GBBusinessLocalityId">Locality:</label>
                        <span>
                           <?php echo $this->Form->input('locality_id', array('options' => array(), 'class' => 'form-control', 'empty' => 'Select locality', 'id' => 'GBBusinessLocalityId', 'div' => false, 'label' => false, 'style' => "width:285px;"));?>
                            <span class="err-msg" id="GBBusinessLocalityIdErr"></span>
                        </span>
                    </div>
                    <div style="visibility:hidden" class="fl to-diff">to</div>
                    <div class="fl half-form-control">
                        <label for="GroupBookingRequestPincode">Pincode:</label>
                        <span>
                           <?php echo $this->Form->input('pincode', array('placeholder' => 'Enter Pincode', 'class' => 'form-control numbersOnly', 'div' => false, 'label' => false, 'maxlength' => '6', 'style' => "width:285px;"));?>
                            <span class="err-msg" id="GroupBookingRequestPincodeErr"></span>
                        </span>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-group">
                <label for="askReferSecurityCode">Answer simple math:</label>
                    <div id="captcha_div" class="math_captcha_box">
                        <?php echo $this->Captcha->render(array('type' => 'math', 'height' => '35px', 'width' => '210px',"model" => 'ask', 'attr'=>array('class'=>'form-control texting math_captcha_text'))); ?>
                    </div>
                    <div class="cb"></div>
                    <span class="err-msg" id="askReferSecurityCodeErr"></span>
                </div>
                <div class="cb">&nbsp;</div>
                <div class="row">
                    <div class="frm-data fr">
                        <button type="button" class="anchor btn-cmn" id="group_booknow_submit" onclick="valid_gbooking_save();" style="display: inline-block;">Submit</a>
                    </div>
                </div>
                <div class="cb20"></div>
                <?php echo $this->Form->end(); ?>

    </div>
</div>
<script type="text/javascript">
    var action_url = "<?php echo $this->Html->url(array('controller'=>'businesses','action'=>'group_booking_save'));?>";
    var submit_stat = false;
    $(document).ready(function () {
        $('#GBBusinessCityId').on('change', function () {
            getLocality($(this).val());
        });
    });

    function getLocality(val) {
        if (!empty(val)) {
            $.ajax({
                type: "POST",
                url: HTTP_ROOT + "content/localities",
                data: {
                    ctid: val
                },
                success: function (data) {
                    $("#GBBusinessLocalityId").find('option:gt(0)').remove();
                    $("#GBBusinessLocalityId").append(data);
                }
            });
        } else {
            if ($("#GBBusinessLocalityId").find('option').size() > 1) {
                $("#GBBusinessLocalityId").find('option:gt(0)').remove();
            }
        }
    }

    function valid_gbooking_save() {
        var validate = $('#GroupBookingRequestGroupBookingForm').validate({
            rules: {
                'data[GroupBookingRequest][name]': {
                    required: true,
                    noSpecialChars: true
                },
                'data[GroupBookingRequest][phone]': {
                    required: true,
                    moblieNmuber: true
                },
                'data[GroupBookingRequest][group_size]': {
                    required: true,
                },
                'data[GroupBookingRequest][looking_for]': {
                    required: true,
                },
                'data[GroupBookingRequest][address]': {
                    required: true,
                },
                'data[GroupBookingRequest][city_id]': {
                    required: true,
                },
                'data[GroupBookingRequest][locality_id]': {
                    required: true,
                },
                'data[GroupBookingRequest][pincode]': {
                    required: true,
                    indZip: true
                },
                'data[ask][refer_security_code]': {
                    required: true,
                    remote: {
                        async: false,
                        type: 'post',
                        url: HTTP_ROOT + "businesses/verify_group_booking_captcha",
                        data: {id: $('#askReferSecurityCode').val()},
                        dataType: 'json'
                    }
                }
            },
            messages: {
                'data[GroupBookingRequest][name]': {
                    required: "Please enter contact person name.",
                    noSpecialChars: "Special characters are not allowed."
                },
                'data[GroupBookingRequest][phone]': {
                    required: "Please enter contact number.",
                    moblieNmuber: "Please enter a valid mobile number"
                },
                'data[GroupBookingRequest][group_size]': {
                    required: "Please select group size.",
                },
                'data[GroupBookingRequest][looking_for]': {
                    required: "Please enter what are you looking for.",
                },
                'data[GroupBookingRequest][address]': {
                    required: "Please enter address.",
                },
                'data[GroupBookingRequest][city_id]': {
                    required: "Please select city.",
                },
                'data[GroupBookingRequest][locality_id]': {
                    required: "Please select locality.",
                },
                'data[GroupBookingRequest][pincode]': {
                    required: "Please enter pincode.",
                    indZip: "Please enter a valid pin code"
                },
                'data[ask][refer_security_code]': {
                    required: "Please answer the above question.",
                    remote: "Wrong ansewer. Please try again."
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("id") == "GroupBookingRequestName") {
                    error.appendTo($("#GroupBookingRequestNameErr"));
                } else if (element.attr("id") == "GroupBookingRequestPhone") {
                    error.appendTo($("#GroupBookingRequestPhoneErr"));
                } else if (element.attr("id") == "GroupBookingGroupSize") {
                    error.appendTo($("#GroupBookingRequestGroupSizeErr"));
                } else if (element.attr("id") == "GroupBookingRequestLookingFor") {
                    error.appendTo($("#GroupBookingRequestLookingForErr"));
                } else if (element.attr("id") == "GroupBookingRequestAddress") {
                    error.appendTo($("#GroupBookingRequestAddressErr"));
                } else if (element.attr("id") == "GBBusinessCityId") {
                    error.appendTo($("#GBBusinessCityIdErr"));
                } else if (element.attr("id") == "GBBusinessLocalityId") {
                    error.appendTo($("#GBBusinessLocalityIdErr"));
                } else if (element.attr("id") == "GroupBookingRequestPincode") {
                    error.appendTo($("#GroupBookingRequestPincodeErr"));
                } else if (element.attr("id") == "askReferSecurityCode") {
                    error.appendTo($("#askReferSecurityCodeErr"));
                } else {
                    error.insertAfter(element);
                }
            }

        });
        if (validate.form()) {
            if(submit_stat){
                return false;
            }
            submit_stat = true;
            $('#group_booknow_submit').text('PLEASE WAIT..');
            $('#group_booknow_submit').addClass('animated bounceOut').one(_animated_css, function(event) {
                $(this).removeClass('animated bounceOut').addClass('animated bounceIn').one(_animated_css, function(event) {
                   $('#group_booknow_submit').removeClass('animated bounceIn');
                });
            });
            var frm = $('#GroupBookingRequestGroupBookingForm');
            var data = frm.serializeArray();
            $.ajax({
                type: "POST",
                url: action_url,
                data: data,
                dataType: "json",
                success: function (response) {
                    submit_stat = false;
                    $.colorbox.close();
                    if(response.status){
                        alert('Booking request sent successfully. We will get in touch with you as soon as possible.')
                    }else{
                        alert('Something went wrong. Please try after some time.','error');
                    }
                }
            });
        } else {
            $.colorbox.resize();
            $('input.error').eq(0).focus();
        }
    }
</script>