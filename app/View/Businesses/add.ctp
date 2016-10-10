<style type="text/css">
    #map {height: 300px;}
</style>
<?php echo $this->Html->script(array('business_add','tag-it.min'), array('inline' => false));
echo $this->Html->css(array('jquery.tagit'), array('inline' => false));?>
<div class="content-full register-your-business">
    <div class="content-left fl">
        <?php echo $this->element('user_inner_left_navbar');?>
    </div>
    <div class="content-right fl">
        <div class="heading"><span class="edit-business"></span> Register your Business</div>
	<?php echo $this->Form->create('Business', array('method' => 'post', 'name' => 'BusinessAddForm', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off'));?>
        <div class="bg-trns-white">
            <div class="sub-heading">Business Details</div>
            <div class="con-w-40 fl">
                <div class="form-group">
                    <label for="BusinessName">Business Name*</label>
                    <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Write the name of your business', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label for="BusinessType">Business Type*</label>
                    <div class="cb"></div>
                    <div style="height:34px; padding: 5px 0;">
                        <div class="radio fl">
                            <label><input name="BusinessType" id="BusinessType1" value="group" checked="checked" type="radio"/>&nbsp;Group</label>
                        </div>
                        <div class="radio fl" style="margin-left:20px;">
                            <label><input name="BusinessType" id="BusinessType2" value="private" type="radio"/>&nbsp;Private</label>
                        </div>
                    </div>
                    <div class="error" id="BusinessTypeErr"></div>
                </div>
                <div class="form-group">
                    <label>Choose Category <i class="fa fa-info-circle" rel="tooltip" title="You can select multiple categories"></i></label>
                    <?php echo $this->Form->input('category_id', array('class' => 'form-control select2', 'options' => $pcategories,'multiple' => 'multiple', 'data-placeholder' => 'Select Category', 'div' => false, 'label' => false, 'id' => 'BusinessCategoryId')); ?>
                    <div class="error" id="BusinessCategoryErr"></div>
                </div>
		        <?php echo $this->Form->input('package_id', array('type' => "hidden", "id" => "package_id_tmp", "value" => @$package_id)); ?>
                <?php echo $this->Form->input('discount_id', array('type' => "hidden", "id" => "discount_id_tmp", "value" => @$discount_id)); ?>
                <input type="hidden" name="referer" value="<?php echo @$referer;?>">
                <div class="form-group">
                    <label for="BusinessKeyword" ><?php echo __('Keywords'); ?>
                    <i class="fa fa-info-circle" rel="tooltip" title="You can enter multiple keywords. Press Enter to insert new keyword"></i></label>
                    <?php echo $this->Form->input('keyword', array( 'label' => false, 'div' => false, 'class' => 'form-control', "placeholder" => __("Keyword"))); ?>
                    <div class="error" id="BusinessKeywordErr"></div>
                </div>
                <div class="form-group">
                    <label>Targeted Gender</label>
                    <?php echo $this->Form->input('gender', array('options' => array('male' => 'Male', 'female' => 'Female', 'both' => 'Both (Male & Female)'), 'data-placeholder' => 'Select Gender', "class" => "form-control select2", "id" => "BusinessGender", 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label for="BusinessPrice">Price*</label>
                    <div class="cb"></div>
                    <div class=" fl half-form-control">
                        <?php echo $this->Form->input('price', array('type' => 'text', 'class' => 'form-control priceOnly', 'placeholder' => 'Min Price', 'div' => false, 'label' => false)); ?>
                        <div class="cb"></div><span class="fl" id="min_price_error"></span>
                    </div>
                    <div class="fl to-diff">to</div>
                    <div class=" fl half-form-control">
                        <?php echo $this->Form->input('max_price', array('type' => 'text', 'class' => 'form-control priceOnly', 'placeholder' => 'Max Price', 'div' => false, 'label' => false)); ?>
                        <div class="cb"></div><span class="fl" id="max_price_error"></span>
                    </div>
                    <div class="cb"></div>
                </div>
		<?php if(!empty($is_package_exist) && (intval($is_package_exist['Subscription']['personal_subdomain']))){?>
                <div class="form-group">
                    <label for="BusinessSubdomainKeyword">Business Url</label>
                    <div class="cb"></div>
                    <div class="fl to-diff" style="margin: 0 0.3%;">http://mrclass.in/</div>
                    <div class=" fl half-form-control">
                        <?php echo $this->Form->input('seo_url', array('type' => 'text', 'class' => 'form-control no_space', 'placeholder' => 'Your Business Name', 'div' => false, 'label' => false)); ?>
                        <div class="cb"></div><span class="fl" id="min_price_error"></span>
                    </div>
                    <div class="cb"></div>
                </div>
		<?php }?>
            </div>
            <div class="con-w-40 fl left-offset">
                <div class="form-group">
                    <label for="BusinessFacilities">Facilities
                    <i class="fa fa-info-circle" rel="tooltip" title="You can select multiple facilities"></i></label>
                    <?php echo $this->Form->input('facilities', array('options' => $facilities, 'data-placeholder' => 'Select Facilities', "class" => "form-control select2", "id" => "BusinessFacilities", 'multiple' => 'multiple', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label for="BusinessLogo">Upload Logo</label>
                    <div class="upload-div-sub">
                        <span class="fl"><img src="<?php echo HTTP_ROOT; ?>images/form/attach_btn.png"></span>
                        <span class="up-text fl">Attach File</span>
                        <?php echo $this->Form->input('logo', array("type" => "file", "class" => "attach-img-sub", 'div' => false, 'label' => false, 'error' => false)); ?>
                        <div class="cb"></div>
                    </div>
                    <div class="cb"></div>
                    <div class="error" id="BusinessLogoErr"><?php  echo $this->Form->error('logo', null, array('class' => 'error-message'));?></div>
                </div>
                <div class="form-group">
                    <label>Age Group*</label>
                    <div class="cb"></div>
                    <div class=" fl half-form-control">
                        <?php echo $this->Form->input('min_age_group', array('options' => range(0, 99), 'class' => 'form-control select2', 'data-placeholder' => 'Min Age', 'div' => false, 'label' => false)); ?>
                        <div class="cb"></div><span class="fl" id="min_age_grp_error"></span>
                    </div>
                    <div class="fl to-diff">to</div>
                    <div class=" fl half-form-control">
                        <?php echo $this->Form->input('max_age_group', array('options' => range(0, 99), 'class' => 'form-control select2', 'data-placeholder' => 'Max Age', 'div' => false, 'label' => false, 'value' => 1)); ?>
                        <div class="cb"></div><span class="fl" id="max_age_grp_error"></span>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-group">
                    <label>Student:Teacher Ratio</label>
                    <div class="cb"></div>
                    <div class=" fl half-form-control">
                        <?php echo $this->Form->input('student_ratio', array('type' => 'text', 'class' => 'form-control numbersOnly', 'placeholder' => 'Student', 'div' => false, 'label' => false)); ?>
                        <div class="cb"></div><span class="fl" id="student_ratio_error"></span>
                    </div>
                    <div class="fl to-diff">:</div>
                    <div class=" fl half-form-control">
                        <?php echo $this->Form->input('teacher_ratio', array('type' => 'text', 'class' => 'form-control numbersOnly', 'placeholder' => 'Teacher', 'div' => false, 'label' => false)); ?>
                        <div class="cb"></div><span class="fl" id="teacher_ratio_error"></span>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="form-group">
                    <label for="BusinessAboutUs">About Us*</label>
                    <?php echo $this->Form->input('about_us', array('type' => 'textarea', 'class' => 'form-control height-plus', 'placeholder' => 'Write something about your business...', 'div' => false, 'label' => false)); ?>
                </div>
            </div>
            <div class="cb hr-space"></div>
        </div>
        <div class="bg-trns-white none" id="privateBusinessBlock">
            <div class="sub-heading">Private Business Details</div>
            <div class="con-w-40 fl">
                <div class="form-group">
                    <label for="BusinessDob">Date of Birth</label>
                    <?php echo $this->Form->input('dob', array('class' => 'form-control ', 'placeholder' => 'Date of Birth', 'div' => false, 'label' => false,
                        'type' => 'text',
                        'dateFormat' => 'MDY', 'empty' => array('month' => 'Month', 'day'   => 'Day', 'year'  => 'Year'),
                        'minYear' => date('Y')-130, 'maxYear' => date('Y'), 'options' => array('1','2')
                        )); ?>
                </div>
                <div class="form-group">
                    <label for="PreferredLocation">Preferred Location for providing training/services*</label>
                    <div style="height:34px; padding: 5px 0;">
                        <div class="radio fl">
                            <label><input name="PreferredLocation" id="PreferredLocation1" value="own" checked="checked" type="radio"/>&nbsp;Your Location</label>
                        </div>
                        <div class="radio fl" style="margin-left:20px;">
                            <label><input name="PreferredLocation" id="PreferredLocation2" value="customer" type="radio"/>&nbsp;Customer Location</label>
                        </div>
                    </div>
                    <div class="error" id="PreferredLocationErr"></div>
                </div>
                <div class="form-group">
                    <label for="FreeDemoClass">Free Demo Class*</label>
                    <div style="height:34px; padding: 5px 0;">
                        <div class="radio fl">
                            <label><input name="FreeDemoClass" id="FreeDemoClass1" value="yes" checked="" type="radio"/>&nbsp;Yes</label>
                        </div>
                        <div class="radio fl" style="margin-left:20px;">
                            <label><input name="FreeDemoClass" id="FreeDemoClass2" value="no" type="radio"/>&nbsp;No</label>
                        </div>
                    </div>
                    <div class="error" id="FreeDemoClassErr"></div>
                </div>
                <div class="form-group">
                    <label for="BusinessLanguages">Languages Spoken*</label>
                    <?php echo $this->Form->input('languages', array('options' => $languages,'class' => 'form-control select2', 'multiple' => 'multiple', 'data-placeholder' => 'Languages', 'div' => false, 'label' => false)); ?>
                    <div class="error" id="BusinessLanguagesErr"></div>
                </div>
                <?php /*?><div class="form-group">
                    <label for="BusinessTagline">Tag Line*</label>
                    <?php echo $this->Form->input('tagline', array('class' => 'form-control', 'placeholder' => 'Write the name of your business', 'div' => false, 'label' => false)); ?>
                </div><?php */?>
            </div>
            <div class="con-w-40 fl left-offset">
                <?php /*?><div class="form-group">
                    <label for="BusinessEstablished">Date of Establishment</label>
                    <?php echo $this->Form->input('established', array('class' => 'form-control ', 'placeholder' => 'Date of Establish', 'div' => false, 'label' => false,
                        'type' => 'text',
                        'dateFormat' => 'MDY', 'empty' => array('month' => 'Month', 'day'   => 'Day', 'year'  => 'Year'),
                        'minYear' => date('Y')-130, 'maxYear' => date('Y'), 'options' => array('1','2')
                        )); ?>
                </div><?php */?>
                <div class="form-group">
                    <label for="BusinessEducation">Education/Qualification*</label>
                    <?php echo $this->Form->input('education', array('type' => 'textarea', 'class' => 'form-control height-plus', 'placeholder' => 'Write about your Education/Qualification...', 'div' => false, 'label' => false)); ?>
                </div>

                <div class="form-group">
                    <label for="BusinessExperience">Experience*</label>
                    <?php echo $this->Form->input('experience', array('type' => 'textarea', 'class' => 'form-control height-plus', 'placeholder' => 'Write about your Experience...', 'div' => false, 'label' => false)); ?>
                </div>
            </div>
            <div class="cb hr-space"></div>
        </div>
        <div class="bg-trns-white">
            <div class="sub-heading">Venue</div>
            <div class="con-w-40 fl">
                <div class="form-group">
                    <label for="BusinessCityId">City</label>
                    <?php echo $this->Form->input('city_id', array('options' => $ucities, 'class' => 'form-control select2', 'data-placeholder' => 'City', 'id' => 'BusinessCityId', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label>Locality</label>
                    <?php echo $this->Form->input('locality_id_tmp', array('type' => "hidden", "id" => "BusinessLocalityId_tmp", "value" => @$this->data['Business']['locality_id'])); ?>
                    <?php echo $this->Form->input('locality_id', array('options' => array(), 'class' => 'form-control select2', 'data-placeholder' => 'Locality', 'id' => 'BusinessLocalityId', 'div' => false, 'label' => false)); ?>
                    <div class="error" id="BusinessLocalitysErr"></div>
                </div>
                <div class="form-group">
                    <label for="BusinessAddress">Address*</label>
                    <?php echo $this->Form->input('address', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Address', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <div class="fl half-form-control">
                        <label for="BusinessLandmark">Landmark</label>
                        <span><?php echo $this->Form->input('landmark', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Landmark', 'div' => false, 'label' => false)); ?></span>
                    </div>
                    <div class="fl to-diff" style="visibility:hidden">to</div>
                    <div class="fl half-form-control">
                        <label for="BusinessPincode">Pincode*</label>
                        <span><?php echo $this->Form->input('pincode', array('type' => 'text', 'class' => 'form-control numbersOnly', 'placeholder' => 'Pincode', 'div' => false, 'label' => false,'maxlength'=>6)); ?></span>
                    </div>
                    <div class="cb"></div>
                </div>
            </div>
            <div class="con-w-40 fl left-offset">
                <?php
                echo $this->Form->input('latitude', array('id' => 'latitude', 'type' => "hidden",));
                echo $this->Form->input('longitude', array('id' => 'longitude', 'type' => "hidden",));
                ?>
                <div class="form-group">
                    <div id="map" style="height:300px;"></div>
                    <div class="note">Note: Drag the pointer to make location more accurate.</div>
                </div>
            </div>
            <div class="cb hr-space"></div>
        </div>
        <div class="bg-trns-white">
            <div class="sub-heading">Contact Details</div>
            <div class="con-w-40 fl">
                <div class="form-group">
                    <label for="BusinessContactPerson">Contact Person*</label>
                    <?php echo $this->Form->input('contact_person', array('type' => 'text', 'class' => 'form-control alphaOnly', 'placeholder' => 'Contact Person', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label for="BusinessEmail">Email*</label>
                    <?php echo $this->Form->input('email', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Email', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label>Phone*
                    <i class="fa fa-info-circle" rel="tooltip" title="You can select multiple phone numbers"></i></label>
                    <div class="cb"></div>
                    <?php echo $this->Form->input('phone', array('type' => 'text', 'class' => 'form-control', 'placeholder' => '', 'div' => false, 'label' => false, 'id' => 'phoneTags')); ?>
                    <div class="cb"></div>
                    <div class="error" id="BusinessPhoneErr"></div>
                </div>
                <div class="form-group">
                    <label for="BusinessWebsite">Website Link</label>
                    <?php echo $this->Form->input('website', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Website URL', 'div' => false, 'label' => false)); ?>
                </div>
            </div>
            <div class="con-w-40 fl left-offset soc_rt_cnt">
                <div class="form-group">
                    <label for="BusinessFacebook"><span class="fb" title="Facebook Link"></span></label>
                    <?php echo $this->Form->input('facebook', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Facebook URL', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label for="BusinessGplus"><span class="gp" title="Google+ Link"></span></label>
                    <?php echo $this->Form->input('gplus', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Google+ URL', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label for="BusinessTwitter"><span class="tl" title="Twitter Link"></span></label>
                    <?php echo $this->Form->input('twitter', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Twitter URL', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label for="BusinessYoutube"><span class="yl" title="YouTube Link"></span></label>
                    <?php echo $this->Form->input('youtube', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Youtube URL', 'div' => false, 'label' => false)); ?>
                </div>
            </div>
            <div class="cb"></div>
            <div class="submit_reg_cnt">
                <div class="fl">
                    <input type="checkbox" id="accept_terms" name="accept_terms"/>
                    <span>Accept
                        <a target="_blank" href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'static_page', 'terms_and_conditions')) ?>">Terms & conditions</a> and
                        <a target="_blank" href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'static_page', 'privacy_policy')) ?>">Privacy Policy</a>
                    </span>
                    <div class="cb"></div>
                    <div id="accept_termsErr"></div>
                </div>
                <div class="fr">
                    <button class="cmn_btn_n pad_big user_valid_admin_add" type="button" onclick="user_valid_admin_add('');">Submit</button>
                </div>
                <div class="cb"></div>
            </div>
            <div class="cb20"></div>
        </div>
        <div class="con-w-40 fl"></div>
        <div class="cb20"></div>
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="cb20"></div>
</div>
<script type="text/javascript">
    var map;
    var markers = [];
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            scrollwheel: false,
            center: {lat: 20.2960587, lng: 85.82453980000003}
        });
        var geocoder = new google.maps.Geocoder();
        setTimeout(function(){
            //#BusinessLocalityId
            //,#BusinessPincode,
            $("#BusinessCityId,#BusinessAddress,#BusinessLandmark").change(function () {
                Business.geo_search(geocoder, map);
            });
        },1000);
        $('#map').css('background-image','none');
    }

    function geocodeAddress(geocoder, resultsMap, address) {
        //var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                setMapOnAll(null);
                resultsMap.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: resultsMap,
                    draggable: true,
                    position: results[0].geometry.location
                });
                google.maps.event.addListener(marker, 'dragend', function (evt) {
                    set_latlng(evt.latLng.lat().toFixed(7),evt.latLng.lng().toFixed(7));
                    geocodePosition(marker.getPosition());
                });
                markers.push(marker);
                //console.log(results[0].formatted_address);
                //console.log(results);
                Business.set_address(results[0].formatted_address);
                //console.log(results[0].geometry.location)
                $('#latitude').val(results[0].geometry.location.lat());
                $('#longitude').val(results[0].geometry.location.lng());
            } else {
                console.log('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
    function set_latlng(lat,lng){
        $('#latitude').val(lat);
        $('#longitude').val(lng);
    }
    function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
        markers = [];
    }

    function geocodePosition(pos) {
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({latLng: pos},
        function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                //$('#latitude').val(results[0].geometry.location.lat());
                //$('#longitude').val(results[0].geometry.location.lng());
                //console.log(results[0].formatted_address);
                Business.set_address(results[0].formatted_address);
            } else {
                console.log('Cannot determine address at this location.' + status);
                //$("#mapErrorMsg").html('Cannot determine address at this location.'+status).show(100);
            }
        }
        );
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_KEY; ?>&libraries=places&callback=initMap" async defer></script>
<script type="text/javascript">
    $(document).ready(function () {
        user_valid_admin_add('mode');
        $("#BusinessKeyword").tagit({placeholderText: "Keywords",allowSpaces:true,trimValue: true});
        <?php if(!empty($this->data['Business']['keyword'])){?>
            var keywordArr = "<?php echo $this->data['Business']['keyword'];?>".split(',');
            if (keywordArr.length > 0) {
                $.each(keywordArr,function(e,v){
                    //$('#BusinessKeyword').tagsinput('add', trim(v));
                })
            }
        <?php }?>
        $('input[type=file]').on('change', function () {
            $(this).closest('div.upload-div-sub').find('.up-text').addClass('ellipsis-view').css('width', '70%').text($(this).val().replace(/^.*\\/, ""));
        });
        var key_arr_seo = [32,187,106,111,110];
        if($(".no_space").is(':visible')){
            $(".no_space").attr('maxlength','30');
            $(".no_space").bind({
                keydown: function(e) {
                    if (e.shiftKey === true ) {
                        if (e.which == 9) {
                            return true;
                        }
                        return false;
                    }
                    if (jQuery.inArray(e.which, key_arr_seo) > -1) {return false;}
                    return true;
                }
            });
        }
        $("#phoneTags").tagit({
            tagLimit: 6,
            placeholderText: "Phone(s)",
            beforeTagAdded: function (event, ui) {
                General.hideAlert('now');
                // console.log(ui.duringInitialization );
                var label = trim(ui.tagLabel);
                var isnum = /^(?=.*[0-9])[-+()0-9]+$/.test(label);
                if (!isnum) {
                    General.hideAlert();
                    alert("Only Numeric and + , - ,() characters allowed",'error');
                    return false;
                }
                if (/^[0-9]{1,8}$/.test(+label) && label.length < 8) {
                    General.hideAlert();
                    alert("Phone numbers must be greater than 8 characters.","error");
                    return false;
                }
            }
        });
    });
</script>
