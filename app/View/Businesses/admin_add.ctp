<?php

echo $this->Html->css(array('select2.min', 'bootstrap-tagsinput', 'bootstrap-datepicker.min'), array('block' => 'bootstrap_datatable_css'));
echo $this->Html->script(array('select2.full.min', 'bootstrap-tagsinput.min', 'bootstrap-datepicker.min'), array('inline' => false));
echo $this->Html->script(array('business_add'), array('inline' => false));
?>
<section class="content-header">
    <h1><?php echo __('Add Business'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'index', 'admin' => 1)); ?>">Businesses</a></li>
        <li class="active"><?php echo __('Add Business'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#businessAdd" data-toggle="tab"><?php echo __('Add Business'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="businessAdd">
                        <?php echo $this->Form->create('Business', array('action' => 'add', 'admin' => 1, 'class' => 'form-horizontal', 'autocomplete' => 'off', 'type' => 'file')); ?>
                        <div class="form-group">
                            <label for="BusinessName" class="col-sm-2 control-label"><?php echo __('Name'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('name', array('label' => false, 'div' => false, 'placeholder' => __('Name'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"><?php echo __('User'); ?> *</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('user_id', array('options' => $users, 'label' => false, 'div' => false, 'empty' => __('Select User'), 'class' => 'form-control select2')); ?>
                                <div class="error" id="BusinessUserIdErr"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessType" class="col-sm-2 control-label"><?php echo __('Business Type'); ?>*</label>
                            <div class="col-sm-10">
                                <div class="radio fl">
                                    <label><input name="data[Business][type]" id="BusinessType1" value="group" checked="" type="radio"/>&nbsp;Group</label>
                                </div>
                                <div class="radio fl" style="margin-left:20px;">
                                    <label><input name="data[Business][type]" id="BusinessType2" value="private" type="radio"/>&nbsp;Private</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessCategoryId" class="col-sm-2 control-label"><?php echo __('Category'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('category_id', array('options' => $pcategories, 'multiple' => 'multiple', 'empty' => __('Select Category'), 'label' => false, 'div' => false, 'class' => 'form-control')); ?>
                            </div>
                            <div class="col-sm-10 fr" id="BusinessCategoryIdErr"></div>
                        </div>
                        <?php /* ?><div class="form-group">
                          <label for="BusinessSubcategoryId" class="col-sm-2 control-label"><?php echo __('Sub Category'); ?>
                          <i class="fa fa-info-circle" rel="tooltip" title="You can select multiple sub categories"></i></label>
                          <div class="col-sm-10">
                          <?php
                          echo $this->Form->input('subcategory_id_tmp', array('type' => "hidden", "id" => "BusinessSubcategoryId_tmp", "value" => @implode(',',$this->data['subcategory_id'])));
                          echo $this->Form->input('subcategory_id', array( 'label' => false, 'div' => false, 'class' => 'form-control select2', 'multiple' => true, "data-placeholder" => __("Select Sub Category")));
                          ?>
                          </div>
                          <div class="col-sm-10 fr" id="BusinessSubcategoryIdErr"></div>
                          </div><?php */ ?>
                        <div class="form-group">
                            <label for="BusinessKeyword" class="col-sm-2 control-label"><?php echo __('Keywords'); ?>
                                <i class="fa fa-info-circle" rel="tooltip" title="You can enter multiple keywords. Press Enter to insert new keyword"></i></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('keyword', array('label' => false, 'div' => false, 'class' => 'form-control', "placeholder" => __("Keyword"))); ?>
                            </div>
                            <div class="col-sm-10 fr" id="BusinessKeywordErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessMinAgeGroup" class="col-sm-2 control-label"><?php echo __('Age Group'); ?>*</label>
                            <div class="col-sm-5">
                                <?php echo $this->Form->input('min_age_group', array('options' => range(0, 99), 'label' => false, 'div' => false, 'empty' => __(' Min age'), 'class' => 'form-control select2')); ?>
                                <span id="BusinessMinAgeGroupErr"></span>
                            </div>
                            <div class="col-sm-5">
                                <?php echo $this->Form->input('max_age_group', array('options' => range(0, 99), 'label' => false, 'div' => false, 'empty' => __('Max age'), 'class' => 'form-control select2')); ?>
                                <span id="BusinessMaxAgeGroupErr"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo __('Student:Teacher Ratio'); ?></label>
                            <div class="col-sm-4">
                                <?php echo $this->Form->input('student_ratio', array('type' => 'text', 'class' => 'form-control numbersOnly', 'placeholder' => 'Student', 'div' => false, 'label' => false)); ?>
                                <span id="student_ratio_error"></span>
                            </div>
                            <div class="col-sm-1" style="text-align:center;font-weight: bold;font-size: 20px;"> : </div>
                            <div class="col-sm-5">
                                <?php echo $this->Form->input('teacher_ratio', array('type' => 'text', 'class' => 'form-control numbersOnly', 'placeholder' => 'Teacher', 'div' => false, 'label' => false)); ?>
                                <span id="teacher_ratio_error"></span>
                            </div>
                        </div>
                        <hr/>
                        <div class="private_business" style="display:none;">
                            <div class="form-group">
                                <label for="BusinessDob" class="col-sm-2 control-label"><?php echo __('Date Of Birth'); ?></label>
                                <div class="col-sm-10">
                                	<?php echo $this->Form->input('dob', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Date Of Birth'), 'class' => 'form-control datepicker')); ?>
                                </div>
                            </div>
                            <?php /* ?><div class="form-group">
                              <label for="BusinessDob" class="col-sm-2 control-label"><?php echo __('Date of Establishment'); ?></label>
                              <div class="col-sm-10">
                              <?php echo $this->Form->input('established', array('type'=>'text','label' => false, 'div' => false, 'placeholder' => __('Date of Establishment'), 'class' => 'form-control datepicker')); ?>
                              </div>
                              </div><?php */ ?>
                            <div class="form-group">
                                <label for="BusinessEducation" class="col-sm-2 control-label"><?php echo __('Education'); ?>*</label>
                                <div class="col-sm-10">
                                    <?php echo $this->Form->input('education', array('label' => false, 'div' => false, 'placeholder' => __('Education'), 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            <?php /* ?><div class="form-group">
                              <label for="BusinessTagline" class="col-sm-2 control-label"><?php echo __('Tag Line'); ?>*</label>
                              <div class="col-sm-10">
                              <?php echo $this->Form->input('tagline', array('label' => false, 'div' => false, 'placeholder' => __('Tag Line'), 'class' => 'form-control')); ?>
                              </div>
                              </div><?php */ ?>
                            <div class="form-group">
                                <label for="BusinessExperience" class="col-sm-2 control-label"><?php echo __('Experience'); ?>*</label>
                                <div class="col-sm-10">
                                    <?php echo $this->Form->input('experience', array('type' => 'textarea', 'label' => false, 'div' => false, 'placeholder' => __('Experience'), 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="BusinessName" class="col-sm-2 control-label"><?php echo __('Languages'); ?>*</label>
                                <div class="col-sm-10">
                                    <?php echo $this->Form->input('languages', array('options' => $languages, 'label' => false, 'div' => false, 'data-placeholder' => __('Select Languages'), 'class' => 'form-control select2', 'multiple' => 'multiple')); ?>
                                    <div class="error" id="BusinessLanguagesErr"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="BusinessPreferredLocation" class="col-sm-2 control-label"><?php echo __('Preffered Location'); ?>*</label>
                                <div class="col-sm-10">
                                    <div class="radio fl">
                                        <label><input name="data[Business][preferred_location]" id="BusinessPreferredLocation1" value="own" checked="" type="radio"/>&nbsp;Own</label>
                                    </div>
                                    <div class="radio fl" style="margin-left:20px;">
                                        <label><input name="data[Business][preferred_location]" id="BusinessPreferredLocation2" value="customer" type="radio"/>&nbsp;Customer</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="BusinessFreeDemoClass" class="col-sm-2 control-label"><?php echo __('Free Demo Class'); ?>*</label>
                                <div class="col-sm-10">
                                    <div class="radio fl">
                                        <label><input name="data[Business][free_demo_class]" id="BusinessFreeDemoClass1" value="yes" checked type="radio"/>&nbsp;Yes</label>
                                    </div>
                                    <div class="radio fl" style="margin-left:20px;">
                                        <label><input name="data[Business][free_demo_class]" id="BusinessFreeDemoClass2" value="no" type="radio"/>&nbsp;No</label>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                        </div>
                        <div class="form-group">
                            <label for="BusinessGender" class="col-sm-2 control-label"><?php echo __('Targeted Gender'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('gender', array('options' => array('both' => 'Both (Male & Female)', 'male' => 'Male', 'female' => 'Female'), 'empty' => __('Select Gender'), 'label' => false, 'div' => false, 'class' => 'form-control select2')); ?>
                                <span id="BusinessGenderErr"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessPrice" class="col-sm-2 control-label"><?php echo __('Price'); ?>*</label>
                            <div class="col-sm-4">
                                <?php echo $this->Form->input('price', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Price'), 'class' => 'form-control')); ?>
                                <div class="error" id="BusinessPriceErr"></div>
                            </div>
                            <div class="col-sm-1" style="text-align:center;"> to </div>
                            <div class="col-sm-5">
                                <?php echo $this->Form->input('max_price', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Price'), 'class' => 'form-control')); ?>
                                <div class="error" id="BusinessMaxPriceErr"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessFacilities" class="col-sm-2 control-label"><?php echo __('Facilities'); ?>
                                <i class="fa fa-info-circle" rel="tooltip" title="You can select multiple facilities"></i></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('facilities', array('options' => $facilities, 'multiple' => true, 'label' => false, 'div' => false, 'data-placeholder' => __('Select Facilities'), 'class' => 'form-control select2')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessAboutUs" class="col-sm-2 control-label"><?php echo __('About Us'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('about_us', array('type' => 'textarea', 'label' => false, 'div' => false, 'placeholder' => __('About Us'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessLogo" class="col-sm-2 control-label"><?php echo __('Logo'); ?> </label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('logo', array('type' => 'file', 'label' => false)); ?>
                            </div>
                        </div>
                        <div class="checkbox">
                            <label class="col-sm-10 col-sm-offset-2" for="discount_allowed"><input type="checkbox" name="data[Business][discount_allowed]" id="discount_allowed" value="yes"/> Give discount on bookings?</label>
                            <div class="clear">&nbsp;</div>
                        </div>
                        <div class="form-group discount_allowed_blk" style="display:none;">
                            <label for="BusinessLogo" class="col-sm-2 control-label"><?php echo __('Discount Details'); ?> </label>
                            <div class="col-sm-5">
                                <?php echo $this->Form->input('discount_amount', array('type' => 'number', 'label' => false, 'div' => false, 'placeholder' => __('Discount Amount'), 'class' => 'form-control')); ?>
                            </div>
                            <div class="col-sm-5">
                                <?php $discount_arr = array('flat' => 'Flat', 'percentage' => 'Percentage'); ?>
                                <?php echo $this->Form->input('discount_type', array('options' => $discount_arr, 'empty' => __('Discount Type'), 'label' => false, 'div' => false, 'class' => 'form-control select2')); ?>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label for="BusinessCityId" class="col-sm-2 control-label"><?php echo __('City'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('city_id', array('options' => $cities, 'empty' => __('Select City'), 'label' => false, 'div' => false, 'class' => 'form-control select2')); ?>
                            </div>
                            <div class="col-sm-10 fr" id="BusinessCityIdErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessLocalityId" class="col-sm-2 control-label"><?php echo __('Locality'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('locality_id', array('empty' => __('Select Locality'), 'label' => false, 'div' => false, 'class' => 'form-control select2')); ?>
                            </div>
                            <div class="col-sm-10 fr" id="BusinessLocalityIdErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessAddress" class="col-sm-2 control-label"><?php echo __('Address'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('address', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Address'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessLandmark" class="col-sm-2 control-label"><?php echo __('Landmark'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('landmark', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Landmark'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessPincode" class="col-sm-2 control-label"><?php echo __('Pincode'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('pincode', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Pincode'), 'class' => 'form-control numbersOnly', 'maxlength' => 6)); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"><?php echo __('Map'); ?></label>
                            <?php
                            echo $this->Form->input('latitude', array('id' => 'latitude', 'type' => "hidden",));
                            echo $this->Form->input('longitude', array('id' => 'longitude', 'type' => "hidden",));
                            ?>
                            <div class="col-sm-10"><div  id="map" style="height:350px;"></div></div>
                        </div>

                        <hr/>

                        <div class="form-group">
                            <label for="BusinessContactPerson" class="col-sm-2 control-label"><?php echo __('Contact Person'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('contact_person', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Contact Person'), 'class' => 'form-control alphaOnly')); ?>
                            </div>
                        </div>
                        <div class="form-group" id="BusinessPhoneBlock">
                            <label for="BusinessPhone" class="col-sm-2 control-label"><?php echo __('Phone'); ?>*
                                <i class="fa fa-info-circle" rel="tooltip" title="You can select multiple phone numbers"></i></label>
                            <div class="col-sm-10">
                                <input name="data[Business][phone]" placeholder="Phone(s)" class="form-control numbers" maxlength="255" type="text" id="BusinessPhone"/>
                                <div class="cb"></div>
                                <div class="error" id="BusinessPhoneErr"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessEmail" class="col-sm-2 control-label"><?php echo __('Email'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('email', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Email'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessWebsite" class="col-sm-2 control-label"><?php echo __('Website'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('website', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Website'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessFacebook" class="col-sm-2 control-label"><?php echo __('Facebook'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('facebook', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Facebook'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessTwitter" class="col-sm-2 control-label"><?php echo __('Twitter'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('twitter', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Twitter'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessGplus" class="col-sm-2 control-label"><?php echo __('Google+'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('gplus', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Google+'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessYoutube" class="col-sm-2 control-label"><?php echo __('Youtube'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('youtube', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Youtube'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <?php echo $this->Form->input('dir_path', array('type' => 'hidden', 'value' => BUSINESS_LOGO_DIR)); ?>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-success" onclick="valid_admin_add();"><?php echo __('Submit'); ?></button>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
    $(document).ready(function () {
        $(".select2").select2();
        $("#BusinessCategoryId").select2({placeholder: "Select categories", allowClear: true});
        $("#BusinessPhone").tagsinput({maxTags: 15, maxChars: 20, confirmKeys: [13, 44], trimValue: true});
        $("#BusinessKeyword").tagsinput({confirmKeys: [13, 44], trimValue: true});
<?php if (!empty($this->data['Business']['keyword'])) { ?>
        var keywordArr = "<?php echo $this->data['Business']['keyword']; ?>".split(',');
        if (keywordArr.length > 0) {
            $.each(keywordArr, function (e, v) {
                $('#BusinessKeyword').tagsinput('add', trim(v));
            })
        }
<?php } ?>
        $('#BusinessPhone').on('beforeItemAdd', function (event) {
            $('#BusinessPhoneErr').hide();
            var isnum = /^(?=.*[0-9])[-+()0-9]+$/.test(event.item);
            if (!isnum) {
                $('#BusinessPhoneErr').html("Only Numeric and + , - ,() characters allowed").show();
                //alert("Only Numeric Inputs allowed","error");
                event.cancel = true;
            }
            if (/^[0-9]{1,8}$/.test(+event.item) && event.item.length < 8) {
                $('#BusinessPhoneErr').html("Phone numbers must be greater than 8 characters.").show();
                //alert("Phone numbers must be greater than 8 characters long.","error");
                event.cancel = true;
            }
        });
        if ($('#BusinessPhoneBlock').find('.bootstrap-tagsinput').is(':visible')) {
            $('#BusinessPhoneBlock').find('.bootstrap-tagsinput').attr('rel', 'tooltip').tooltip({title: '<i class="fa fa-info-circle" style="color:#fff"></i>  Enter Comma (,) separated phone numbers. Only numbers and following characters are allowed.<br/>+ , - , ()', placement: 'top', trigger: 'hover', animation: true, html: true});
        }

    });
</script>
<script>
    var map;
    var markers = [];
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            scrollwheel: false,
            center: {lat: 20.2960587, lng: 85.82453980000003}
        });
        var geocoder = new google.maps.Geocoder();
        setTimeout(function () {
            //,#BusinessLocalityId
            //#BusinessPincode,
            $("#BusinessCityId,#BusinessAddress,#BusinessLandmark").change(function () {
                Business.geo_search(geocoder, map);
            });
        }, 1000);
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
                    set_latlng(evt.latLng.lat().toFixed(7), evt.latLng.lng().toFixed(7));
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
                //$("#mapSearchInput").val(results[0].formatted_address);
                //$("#mapErrorMsg").hide(100);
            } else {
                console.log('Cannot determine address at this location.' + status);
                //$("#mapErrorMsg").html('Cannot determine address at this location.'+status).show(100);
            }
        }
        );
    }
    function set_latlng(lat, lng) {
        $('#latitude').val(lat);
        $('#longitude').val(lng);
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_KEY; ?>&libraries=places&callback=initMap" async defer></script>
