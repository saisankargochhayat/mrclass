<style type="text/css">
    #map {height: 300px;}
</style>
<?php echo $this->Html->script(array('moment.min', 'event_js'), array('inline' => false)); ?>
<div class="content-full register-your-business">
    <div class="content-left fl">
        <?php echo $this->element('business_left_tab'); ?>
    </div>
    <div class="content-right fl">
        <div class="heading"><span class="edit-business"></span> Add your Event</div>
        <?php echo $this->Form->create('Event', array('method' => 'post', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off', 'type' => 'file')); ?>
        <div class="bg-trns-white">
            <div class="sub-heading">Event Details</div>
            <div class="con-w-40 fl">
                <div class="form-group">
                    <label for="EventName">Event Name*</label>
                    <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Write the name of the event', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label for="is_equipment_provided">Equipment*</label>
                    <div class="cb"></div>
                    <div style="height:34px; padding: 5px 0;">
                        <div class="radio fl">
                            <label><input name="data[Event][is_equipment_provided]" id="is_equipment_provided1" value="0" checked="checked" type="radio"/>&nbsp;Self</label>
                        </div>
                        <div class="radio fl" style="margin-left:20px;">
                            <label><input name="data[Event][is_equipment_provided]" id="is_equipment_provided2" value="1" type="radio"/>&nbsp;Provided</label>
                        </div>
                    </div>
                    <div class="error" id="is_equipment_providedErr"></div>
                </div>
                <div class="form-group">
                    <label for="fee_type">Participation Fee*</label>
                    <div class="cb"></div>
                    <div style="height:34px; padding: 5px 0;">
                        <div class="radio fl">
                            <label><input name="data[Event][fee_type]" id="fee_free" value="free" checked="checked" class="radio_fee" type="radio"/>&nbsp;Free</label>
                        </div>
                        <div class="radio fl" style="margin-left:20px;">
                            <label><input class="radio_fee" name="data[Event][fee_type]" id="fee_price" value="paid" type="radio"/>&nbsp;Paid</label>
                        </div>
                    </div>
                    <div class="error" id="fee_typeErr"></div>
                </div>
                <div class="form-group" style="display:none;" id="custom_price">
                    <label for="EventFee">Fee*</label>
                    <?php echo $this->Form->input('fee', array('type' => 'text', 'class' => 'form-control numbersOnly', 'placeholder' => 'Participation Fee', 'div' => false, 'label' => false)); ?>
                </div>
            </div>
            <div class="con-w-40 fl left-offset">
                <div class="form-group">
                    <label for="EventBanner">Upload Banner</label>
                    <div class="upload-div-sub">
                        <span class="fl"><img src="<?php echo HTTP_ROOT; ?>images/form/attach_btn.png"></span>
                        <span class="up-text fl">Attach File</span>
                        <?php echo $this->Form->input('banner', array("type" => "file", "class" => "attach-img-sub", 'div' => false, 'label' => false, 'error' => false)); ?>
                        <div class="cb"></div>
                    </div>
                    <div class="cb"></div>
                    <div class="error" id="EventBannerErr"><?php echo $this->Form->error('logo', null, array('class' => 'error-message')); ?></div>
                </div>
                <div class="form-group">
                    <label for="schedule_type">Schedule*</label>
                    <div class="cb"></div>
                    <div style="height:34px; padding: 5px 0;">
                        <div class="radio fl">
                            <label><input name="data[Event][schedule_type]" id="run_daily" value="Immediate" checked="checked" class="range_radio" type="radio"/>&nbsp;Event Date</label>
                        </div>
                        <div class="radio fl" style="margin-left:20px;">
                            <label><input name="data[Event][schedule_type]" id="run_specific" value="Specific" class="range_radio" type="radio"/>&nbsp;Schedule Dates</label>
                        </div>
                    </div>
                    <div id="end_date_div">
                        <?php echo $this->Form->input('custom_end_date', array('class' => 'form-control', 'placeholder' => 'Event End Date', 'div' => false, 'label' => false)); ?>
                    </div>
                    <div style="display:none;" id="range_div">
                        <div class="cb"></div>
                        <div class=" fl half-form-control">
                            <?php echo $this->Form->input('event_range_start', array('type' => 'text', 'class' => 'form-control priceOnly', 'placeholder' => 'Start Date', 'div' => false, 'label' => false)); ?>
                            <div class="cb"></div><span class="fl" id="min_price_error"></span>    
                        </div>
                        <div class="fl to-diff">to</div>
                        <div class=" fl half-form-control">
                            <?php echo $this->Form->input('event_range_end', array('type' => 'text', 'class' => 'form-control priceOnly', 'placeholder' => 'End Date', 'div' => false, 'label' => false)); ?>
                            <div class="cb"></div><span class="fl" id="max_price_error"></span>
                        </div>
                        <div class="cb"></div>
                    </div>
                    <input type="hidden" name="data[Event][start_date]" id="event_start" value="<?php echo date('Y-m-d'); ?>"/>
                    <input type="hidden" name="data[Event][end_date]" id="event_end" value=""/>
                    <div class="error" id="schedule_typeErr"></div>
                </div>
                <div class="form-group">
                    <label for="EventAboutUs">Description*</label>
                    <?php echo $this->Form->input('description', array('type' => 'textarea', 'class' => 'form-control height-plus', 'placeholder' => 'Write something about your event...', 'div' => false, 'label' => false)); ?>
                </div>
            </div>
            <div class="cb hr-space"></div>
        </div>
        <div class="bg-trns-white">
            <div class="sub-heading">Venue</div>
            <div class="con-w-40 fl">
                <div class="form-group">
                    <label for="EventCityId">City</label>
                    <?php echo $this->Form->input('city_id', array('options' => $ucities, 'class' => 'form-control select2', 'data-placeholder' => 'City', 'id' => 'EventCityId', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label>Locality</label>
                    <?php echo $this->Form->input('locality_id_tmp', array('type' => "hidden", "id" => "EventLocalityId_tmp", "value" => @$this->data['Event']['locality_id'])); ?>
                    <?php echo $this->Form->input('locality_id', array('options' => array(), 'class' => 'form-control select2', 'data-placeholder' => 'Locality', 'id' => 'EventLocalityId', 'div' => false, 'label' => false)); ?>
                    <div class="error" id="EventLocalitysErr"></div>
                </div>
                <div class="form-group">
                    <label for="EventAddress">Address*</label>
                    <?php echo $this->Form->input('address', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Address', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <div class="fl half-form-control">
                        <label for="EventLandmark">Landmark</label>
                        <span><?php echo $this->Form->input('landmark', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Landmark', 'div' => false, 'label' => false)); ?></span>
                    </div>
                    <div class="fl to-diff" style="visibility:hidden">to</div>
                    <div class="fl half-form-control">
                        <label for="EventPincode">Pincode*</label>
                        <span><?php echo $this->Form->input('pincode', array('type' => 'text', 'class' => 'form-control numbersOnly', 'placeholder' => 'Pincode', 'div' => false, 'label' => false, 'maxlength' => 6)); ?></span>
                    </div>
                    <div class="cb"></div>
                </div>
            </div>
            <div class="con-w-40 fl left-offset">
                <?php
                echo $this->Form->input('latitude', array('id' => 'latitude', 'type' => "hidden"));
                echo $this->Form->input('longitude', array('id' => 'longitude', 'type' => "hidden"));
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
                    <label for="EventContactPerson">Contact Person*</label>
                    <?php echo $this->Form->input('contact_person', array('type' => 'text', 'class' => 'form-control alphaOnly', 'placeholder' => 'Contact Person', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label for="EventEmail">Email*</label>
                    <?php echo $this->Form->input('email', array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Email', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="form-group">
                    <label>Phone*
                        <i class="fa fa-info-circle" rel="tooltip" title="You can select multiple phone numbers"></i></label>
                    <div class="cb"></div>
                    <?php echo $this->Form->input('phone', array('type' => 'text', 'class' => 'form-control', 'placeholder' => '', 'div' => false, 'label' => false, 'id' => 'phoneTags')); ?>
                    <div class="cb"></div>
                    <div class="error" id="EventPhoneErr"></div>
                </div>
            </div>
            <div class="con-w-40 fl left-offset soc_rt_cnt">
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
                    <button class="cmn_btn_n pad_big user_valid_admin_add" type="submit">Submit</button>
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
        map = new google.maps.Map(document.getElementById('map'), {zoom: 15, scrollwheel: false, center: {lat: 20.2960587, lng: 85.82453980000003}});
        var geocoder = new google.maps.Geocoder();
        setTimeout(function () {
            $("#EventCityId,#EventAddress,#EventLandmark").change(function () {
                geo_search(geocoder, map);
            });
        }, 1000);
        $('#map').css('background-image', 'none');
    }

    function geocodeAddress(geocoder, resultsMap, address) {
        geocoder.geocode({'address': address}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                setMapOnAll(null);
                resultsMap.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({map: resultsMap, draggable: true, position: results[0].geometry.location});
                google.maps.event.addListener(marker, 'dragend', function (evt) {
                set_latlng(evt.latLng.lat().toFixed(7), evt.latLng.lng().toFixed(7));
                        geocodePosition(marker.getPosition());
                });
                markers.push(marker);
                set_address(results[0].formatted_address);
                $('#latitude').val(results[0].geometry.location.lat());
                $('#longitude').val(results[0].geometry.location.lng());
            } else {
                console.log('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

    function set_latlng(lat, lng) {
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
                    Event.set_address(results[0].formatted_address);
                } else {
                    console.log('Cannot determine address at this location.' + status);
                }
            }
        );
    }
    jQuery(document).ready(function ($) {
        $(".radio_fee").on('change', function () {
            if (trim($(this).val()) == "free") {
                $("#custom_price").slideUp();
            } else {
                $("#custom_price").slideDown();
            }
        });
        $(".range_radio").on('change', function () {
            if (trim($(this).val()) == "Immediate") {
            $("#range_div").slideUp();
                    $("#end_date_div").slideDown();
                    $("#event_start").val(moment().format('YYYY-MM-DD'));
                    $("#EventEventRangeStart").val('');
                    $("#EventEventRangeEnd").val('');
                    $("#event_end").val('');
            } else {
            $("#end_date_div").slideUp();
                    $("#EventCustomEndDate").val('');
                    $("#event_start").val('');
                    $("#event_end").val('');
                    $("#range_div").slideDown();
            }
            });
            $("#EventCustomEndDate").datepicker({minDate: 0, dateFormat: "dd/mm/yy", onSelect: function (dateText, inst) {var date = $(this).datepicker('getDate');$("#EventEventRangeEnd").datepicker("option", "minDate", inst.lastVal);$("#event_end").val(moment(date).format('YYYY-MM-DD'));}});
            $("#EventEventRangeStart").datepicker({minDate: 0, dateFormat: "dd/mm/yy", onSelect: function (dateText, inst) {var date = $(this).datepicker('getDate');$("#EventEventRangeEnd").datepicker("option", "minDate", inst.lastVal);$("#event_start").val(moment(date).format('YYYY-MM-DD'));}});
            $("#EventEventRangeEnd").datepicker({minDate: 0, dateFormat: "dd/mm/yy", onSelect: function (dateText, inst) {var date = $(this).datepicker('getDate');$("#EventEventRangeStart").datepicker("option", "maxDate", inst.lastVal);$("#event_end").val(moment(date).format('YYYY-MM-DD'));}});
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_KEY; ?>&libraries=places&callback=initMap" async defer></script>