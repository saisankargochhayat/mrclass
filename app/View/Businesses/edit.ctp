<style type="text/css">
    #map {height: 300px;}
</style>
<?php 
$BusinessId = $this->data['Business']['id'];
$type = $this->data['Business']['type'];
?>
<?php echo $this->Html->script(array('business_add','tag-it.min'), array('inline' => false));
echo $this->Html->css(array('jquery.tagit'), array('inline' => false));
?>
<div class="content-full edit-your-business">
    <div class="content-left fl">
        <?php echo $this->element('user_inner_left_navbar');?>
    </div>
    <div class="content-right fl">
        <div class="heading"><span class="edit-business"></span> Update Business Details</div>
        <div class="cb"></div>
        <?php echo $this->element('front_edit_business_tabs',array('BusinessId'=>$BusinessId));?>
        <div class="cb"></div>
	<?php echo $this->Form->create('Business', array('method' => 'post', 'type' => 'file', 'autocomplete' => 'off', 'id' => 'BusinessAddForm', 'name' => 'BusinessAddForm'));?>

        <?php if($parms['slug'] == '' || $parms['slug'] == 'details'){?>
        <div class="sub-heading none">Business Details</div>

        <div class="bg-trns-white" style="margin-bottom:0px;">
            <div class="con-w-40 fl">
                <div class="form-group">
                    <label>Business Name*</label>
                        <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Write the name of your business', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label for="BusinessType">Business Type*</label>
                    <div class="cb"></div>

                    <div style="height:34px; padding: 5px 0;">
                        <div class="radio fl">
                            <label><input name="BusinessType" id="BusinessType1" value="group" <?php echo $type != 'private' ? 'checked="checked"' : ''?> type="radio"/>&nbsp;Group</label>
                        </div>
                        <div class="radio fl" style="margin-left:20px;">
                            <label><input name="BusinessType" id="BusinessType2" value="private" <?php echo $type == 'private' ? 'checked="checked"' : ''?> type="radio"/>&nbsp;Private</label>
                        </div>
                    </div>
                    <div class="error" id="BusinessTypeErr"></div>
                </div>
                <div class="form-group">
                    <label>Choose Category</label>
                        <?php echo $this->Form->input('category_id', array('class' => 'form-control select2', 'options' => $pcategories,'multiple' => 'multiple', 'data-placeholder' => 'Select Category', 'div' => false, 'label' => false, 'id' => 'BusinessCategoryId')); ?>
                </div>
                    <?php /* ?><div class="form-group">
                        <label>Choose Sub-Category
                        <i class="fa fa-info-circle" rel="tooltip" title="You can select multiple sub categories"></i></label>
                        <?php 
                        echo $this->Form->input('subcategory_id_tmp', array('type' => "hidden", "id" => "BusinessSubcategoryId_tmp", "value" => @implode(',',$this->data['Business']['subcategory_id'])));
                        echo $this->Form->input('subcategory_id', array('data-placeholder' => "Select Subcategory", "class" => "form-control select2", "id" => "BusinessSubcategoryId", 'div' => false, 'label' => false,'multiple'=>'multiple')); 
                        ?>
                    </div><?php */ ?>
                <div class="form-group">
                    <label for="BusinessKeyword" ><?php echo __('Keywords'); ?>
                        <i class="fa fa-info-circle" rel="tooltip" title="You can enter multiple keywords. Press Enter to insert new keyword"></i></label>
                        <?php echo $this->Form->input('keyword', array( 'label' => false, 'div' => false, 'class' => 'form-control', "placeholder" => __("Keyword"))); ?>
                    <div class="error" id="BusinessKeywordErr"></div>
                </div>
                <div class="form-group">
                    <label>Targeted Gender</label>
                        <?php echo $this->Form->input('gender', array('options' => array('male' => 'Male', 'female' => 'Female', 'both' => 'Both (Male & Female)'), 'data-placeholder' => 'Select Gender', "class" => "form-control select2", "id" => "BusinessSubcategoryId", 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label>Price*</label>
                    <div class="cb"></div>
                    <div class=" fl half-form-control">
                        <?php echo $this->Form->input('price', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Min Price', 'div' => false, 'label' => false)); ?>
                        <div class="cb"></div><span class="fl" id="min_price_error"></span>    
                    </div>
                    <div class="fl to-diff">to</div>
                    <div class=" fl half-form-control">
                        <?php 
                        $max_price = floatval($this->data['Business']['max_price'])>0?$this->data['Business']['max_price']:"";
                        echo $this->Form->input('max_price', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Max Price', 'div' => false, 'label' => false, 'value' => $max_price)); 
                        ?>
                        <div class="cb"></div><span class="fl" id="max_price_error"></span>
                    </div>
                    <div class="cb"></div>

                </div>
            </div>
            <div class="con-w-40 fl left-offset">
                <div class="form-group">
                    <label>Facilities
                        <i class="fa fa-info-circle" rel="tooltip" title="You can select multiple facilities"></i></label>
                        <?php echo $this->Form->input('facilities', array('options' => $facilities, 'data-placeholder' => 'Select Facilities', "class" => "form-control select2", "id" => "BusinessSubcategoryId", 'multiple' => 'multiple', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label>Upload Logo</label>
                    <div class="cb"></div>
                    <?php 
                    $found= '';
                    if(trim($this->data['Business']['logo'])!=''){ 
                        $found = 'Yes';
                            ?>
                        <input type="hidden" id="logo_old" value="<?php echo trim($this->data['Business']['logo']);?>"/>
                        <div class="logo_image">
                            <img class="colorbox" src="<?php echo $this->Format->show_business_logo($this->data, 122, 122,0); ?>" 
                                 data-href="<?php echo $this->Format->show_business_logo($this->data, '', '',0); ?>"
                                 alt=""/>
                            <a class="anchor" onclick="$('.logo_image').slideUp();$('.logo_edit').slideDown();">Change Logo</a>
                            &nbsp;|&nbsp;
                            <a class="anchor" onclick="delete_logo(<?php echo $this->data['Business']['id'];?>)">Remove Logo</a>
                        </div>
                    <?php } ?>

                    <div class="logo_edit <?php echo $found == 'Yes'? "none" : ""; ?>">
                        <div class="upload-div-sub">
                            <span class="fl"><img src="<?php echo HTTP_ROOT; ?>images/form/attach_btn.png"></span>
                            <span class="up-text fl">Attach File</span>
                                <?php echo $this->Form->input('logo', array("type" => "file", "class" => "attach-img-sub", 'div' => false, 'label' => false, 'error' => false, 'value' => '')); ?>
                            <div class="cb"></div>
                            <div class="error" id="BusinessLogoErr"><?php  echo $this->Form->error('logo', null, array('class' => 'error-message'));?></div>
                        </div>
                        <?php if(trim($this->data['Business']['logo'])!=''){  ?>
                            <div class="cb"></div>
                            <a class="anchor cancelicn" style="margin-bottom:10px;" onclick="$('.logo_edit').slideUp();$('.logo_image').slideDown();">Cancel</a>
                        <?php } ?>
                    </div>
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
                        <?php echo $this->Form->input('max_age_group', array('options' => range(0, 99), 'class' => 'form-control select2', 'data-placeholder' => 'Max Age', 'div' => false, 'label' => false)); ?>
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
                    <label>About Us*</label>
                        <?php echo $this->Form->input('about_us', array('type' => 'textarea', 'class' => 'form-control height-plus', 'placeholder' => 'Write something about your business...', 'div' => false, 'label' => false)); ?>
                </div>
            </div>
            <div class="cb hr-space"></div>
        </div>
        <div class="bg-trns-white <?php echo $type != 'private' ? 'none' : '';?>" id="privateBusinessBlock"  style="margin-bottom:0px;margin-top:0px;">
            <div class="sub-heading">Private Business Details</div>
            <div class="con-w-40 fl">
                <div class="form-group">
                    <label for="BusinessDob">Date of Birth</label>
                        <?php echo $this->Form->input('dob', array('class' => 'form-control ', 'placeholder' => 'Date of Birth', 'div' => false, 'label' => false,
                            'type' => 'text', 'value' => $this->Format->dateFormat($this->data['Business']['dob']),
                            'dateFormat' => 'MDY', 'empty' => array('month' => 'Month', 'day'   => 'Day', 'year'  => 'Year'),
                            'minYear' => date('Y')-130, 'maxYear' => date('Y'), 'options' => array('1','2')
                            )); ?>
                </div>
                <div class="form-group">
                    <label for="PreferredLocation">Preferred Location for providing training/services*</label>
                        <?php $preferred_location = $this->data['Business']['preferred_location']; #pr($this->data['Business']);?>
                    <div style="height:34px; padding: 5px 0;">
                        <div class="radio fl">
                            <label><input name="PreferredLocation" id="PreferredLocation1" value="own" <?php echo $preferred_location != 'customer' ? 'checked="checked"' : '';?> type="radio"/>&nbsp;Your Location</label>
                        </div>
                        <div class="radio fl" style="margin-left:20px;">
                            <label><input name="PreferredLocation" id="PreferredLocation2" value="customer" <?php echo $preferred_location == 'customer' ? 'checked="checked"' : '';?> type="radio"/>&nbsp;Customer Location</label>
                        </div>
                    </div>
                    <div class="error" id="PreferredLocationErr"></div>
                </div>
                <div class="form-group">
                    <label for="FreeDemoClass">Free Demo Class*</label>

                        <?php $free_demo_class = $this->data['Business']['free_demo_class'];?>
                    <div style="height:34px; padding: 5px 0;">
                        <div class="radio fl">
                            <label><input name="FreeDemoClass" id="FreeDemoClass1" value="yes" <?php echo $free_demo_class != 'no' ? 'checked="checked"' : '';?>  type="radio"/>&nbsp;Yes</label>
                        </div>
                        <div class="radio fl" style="margin-left:20px;">
                            <label><input name="FreeDemoClass" id="FreeDemoClass2" value="no" <?php echo $free_demo_class == 'no' ? 'checked="checked"' : '';?> type="radio"/>&nbsp;No</label>
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
                        <?php echo $this->Form->input('tagline', array('class' => 'form-control', 'placeholder' => 'Business Tag Line', 'div' => false, 'label' => false)); ?>
                    </div><?php */?>
            </div>
            <div class="con-w-40 fl left-offset">
                    <?php /*?><div class="form-group">
                        <label for="BusinessEstablished">Date of Establishment</label>
                        <?php echo $this->Form->input('established', array('class' => 'form-control ', 'placeholder' => 'Date of Establish', 'div' => false, 'label' => false,
                            'type' => 'text', 'value' => $this->Format->dateFormat($this->data['Business']['established']),
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
        <div class="bg-trns-white" style="margin-top:0px;">
            <button class="cmn_btn_n pad_big" type="button" onclick="user_valid_admin_add();">Submit</button>
        </div>
        <div class="cb20"></div>
        <?php } elseif ($parms['slug'] == 'venue') { ?>
        <div class="cb hr-space none"></div>
        <div class="sub-heading none">Venue</div>
        <div class="bg-trns-white">
            <div class="con-w-40 fl">
                <div class="form-group">
                    <label>City</label>
                        <?php echo $this->Form->input('city_id', array('options' => $ucities, 'class' => 'form-control select2', 'data-placeholder' => 'City', 'id' => 'BusinessCityId', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label>Locality</label>
                        <?php echo $this->Form->input('locality_id_tmp', array('type' => "hidden", "id" => "BusinessLocalityId_tmp", "value" => @$this->data['Business']['locality_id'])); ?>
                        <?php echo $this->Form->input('locality_id', array('options' => array(), 'class' => 'form-control select2', 'data-placeholder' => 'Locality', 'id' => 'BusinessLocalityId', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label>Address*</label>
                        <?php echo $this->Form->input('address', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Address', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <div class="fl half-form-control">
                        <label>Landmark</label>
                        <span><?php echo $this->Form->input('landmark', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Landmark', 'div' => false, 'label' => false)); ?></span>
                    </div>
                    <div class="fl to-diff" style="visibility:hidden">to</div>
                    <div class="fl half-form-control">
                        <label>Pincode*</label>
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
                    <div id="map"></div>
                    <div class="note">Note: Drag the pointer to make location more accurate.</div>
                </div>
            </div>
            <div class="cb"></div>
            <div>
                <button class="cmn_btn_n pad_big" type="button" onclick="user_valid_admin_add();">Submit</button>
            </div>
            <div class="cb20"></div>
        </div>

        <?php } elseif ($parms['slug'] == 'contact-info') { ?>
        <div class="cb hr-space none"></div>
        <div class="sub-heading none">Contact Details</div>
        <div class="bg-trns-white">	
            <div class="con-w-40 fl">
                <div class="form-group">
                    <label>Contact Person*</label>
                        <?php echo $this->Form->input('contact_person', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Contact Person', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label>Email*</label>
                        <?php echo $this->Form->input('email', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Email', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label>Phone*
                        <i class="fa fa-info-circle" rel="tooltip" title="You can select multiple phone numbers"></i></label>
                        <?php echo $this->Form->input('phone', array('type' => 'text', 'class' => 'form-control', 'div' => false, 'label' => false,'id'=>'myTags')); ?>
                    <div class="cb"></div>
                    <div class="error" id="BusinessPhoneErr"></div>
                </div>
                <div class="form-group">
                    <label>Website Link</label>
                    <?php echo $this->Form->input('website', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Website URL', 'div' => false, 'label' => false)); ?>
                </div>
            </div>
            <div class="con-w-40 fl left-offset soc_rt_cnt">
                <?php $disable = ($this->Format->is_allowed($is_package_exist, $user['type'], 'Social Media')) ? false : true; ?>
                <div class="form-group">
                    <span class="fb"></span>
                    <?php echo $this->Form->input('facebook', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Facebook URL', 'div' => false, 'label' => false, 'disabled' => $disable)); ?>
                </div>
                <div class="form-group">
                    <span class="gp"></span>
                    <?php echo $this->Form->input('gplus', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Google+ URL', 'div' => false, 'label' => false, 'disabled' => $disable)); ?>
                </div>
                <div class="form-group">
                    <span class="tl"></span>
                    <?php echo $this->Form->input('twitter', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Twitter URL', 'div' => false, 'label' => false, 'disabled' => $disable)); ?>
                </div>
                <div class="form-group">
                    <span class="yl"></span>
                    <?php echo $this->Form->input('youtube', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Youtube URL', 'div' => false, 'label' => false, 'disabled' => $disable)); ?>
                </div>
            </div>
            <div class="cb"></div>
            <div>
                <button class="cmn_btn_n pad_big user_valid_admin_add" type="button" onclick="user_valid_admin_add();">Submit</button>
            </div>
            <div class="cb20"></div>
        </div>
        <?php } ?>        
        <div class="cb20"></div>
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="cb20"></div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.colorbox').colorbox();
        user_valid_admin_add('mode');
        if($("input[name='data[Business][logo]']").length > 0){
            //$("input[name='data[Business][logo]']").rules("remove","required");
        }

        $('input[type=file]').on('change', function () {
            $(this).closest('div.upload-div-sub').find('.up-text').addClass('ellipsis-view').css('width', '70%').text($(this).val().replace(/^.*\\/, ""));
        });
    });
    function delete_logo(id){
        confirm('Are you sure you want to delete logo?',function(){
            $.post(HTTP_ROOT+"businesses/delete_logo",{id:id},function(response){
                General.hideAlert('now');
                General.hideAlert();
                if(response.success == 1){
                    $('.logo_image').slideUp().remove();
                    $('.cancelicn').remove();
                    $('.logo_edit').slideDown();
                    alert(response.message,'success');
                }else{
                    alert(response.message,'error');
                }
            },'json');
        });
    }
</script>

<?php if($parms['slug'] == '' || $parms['slug'] == 'details'){?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#BusinessKeyword").tagit({placeholderText: "Keywords",allowSpaces:true,trimValue: true});
        //if($("#logo_old").length > 0 && $('#logo_old').val() != ''){
        //$("input[name='data[Business][logo]']").rules("remove","required");
        //}else{
        //$("input[name='data[Business][logo]']").rules("add","required");
        //}
    });
</script>
<?php } ?>
<?php if($parms['slug'] == 'venue'){?>
<script type="text/javascript">
    var map;
    var markers = [];
    var infoWindow;
    var geocoder;
    function initMap() {
        var myloc = {lat: parseFloat($('#latitude').val()), lng: parseFloat($('#longitude').val())};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            scrollwheel: false,
            center: myloc
        });
        geocoder = new google.maps.Geocoder();
        infoWindow = new google.maps.InfoWindow();

        //Business.geo_search(geocoder, map);
        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: myloc
        });
        markers.push(marker);
        marker.addListener('click', function () {
            infoWindow.open(map, marker);
        });
        google.maps.event.addListener(marker, 'dragend', function (evt) {
            set_latlng(evt.latLng.lat().toFixed(7),evt.latLng.lng().toFixed(7));
            geocodePosition(marker.getPosition());
        });
        //geocodePosition(marker.getPosition());
        //$('#map').css('background-image','none');
        setTimeout(function(){
            //#BusinessLocalityId
            //#BusinessPincode
            $("#BusinessCityId,#BusinessAddress,#BusinessLandmark").change(function () {
                Business.geo_search(geocoder, map);
            });
        },1000);

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
                google.maps.event.addListener(marker, 'click', function () {
                    infoWindow.open(map, marker);
                });
                markers.push(marker);
                Business.set_address(results[0].formatted_address);
                infoWindow.setContent(results[0].formatted_address);

                //console.log(results[0].geometry.location.lat())
                $('#latitude').val(results[0].geometry.location.lat());
                $('#longitude').val(results[0].geometry.location.lng());

            } else {
                console.debug('Geocode was not successful for the following reason: ' + status);
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
                Business.set_address(results[0].formatted_address);
                infoWindow.setContent(results[0].formatted_address);
            } else {
                console.log('Cannot determine address at this location.' + status);
                //$("#mapErrorMsg").html('Cannot determine address at this location.'+status).show(100);
            }
        });
    }
    function set_latlng(lat,lng){
        $('#latitude').val(lat);
        $('#longitude').val(lng);
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_KEY; ?>&libraries=places&callback=initMap" async defer></script>
<?php } ?>
<?php if($parms['slug'] == 'contact-info'){?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#myTags").tagit({
            tagLimit: 6,
            placeholderText: "Phone(s)",
            removeConfirmation: true,
            beforeTagAdded: function (event, ui) {
                General.hideAlert('now');
                $('#BusinessPhoneErr').hide();
                var label = trim(ui.tagLabel);
                var isnum = /^(?=.*[0-9])[-+()0-9]+$/.test(label);
                if (!isnum) {
                    General.hideAlert();
                    $('#BusinessPhoneErr').html("Only Numeric and + , - ,() characters allowed").show();
                    //alert("Only Numeric and + , - ,() characters allowed","error");
                    return false;
                }
                if (/^[0-9]{1,8}$/.test(+label) && label.length < 8) {
                    General.hideAlert();
                    $('#BusinessPhoneErr').html("Phone numbers must be greater than 8 characters.").show();
                    //alert("Phone numbers must be greater than 8 characters.","error");
                    return false;
                }
            }
        });
    });
</script> 
<?php } ?>

