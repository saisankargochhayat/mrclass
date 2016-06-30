<?php
echo $this->Html->css(array('bootstrap-datepicker.min', 'daterangepicker-bs3'), array('block' => 'bootstrap_datatable_css'));
echo $this->Html->script(array('bootstrap-datepicker.min', 'moment.min', 'daterangepicker', 'event_js'), array('inline' => false));
?>
<section class="content-header">
    <h1><?php echo __('Edit Event'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link) ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller' => 'events', 'action' => 'index', 'admin' => 1)); ?>">Events</a></li>
        <li class="active"><?php echo __('Edit Event'); ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#eventAdd" data-toggle="tab"><?php echo __('Edit Event'); ?></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="eventAdd">
                        <?php echo $this->Form->create('Event', array('action' => 'edit', 'admin' => 1, 'class' => 'form-horizontal', 'id' => 'event_manage', 'autocomplete' => 'off', 'type' => 'file')); ?>
                        <input type="hidden" name="data[Event][start_date]" id="event_start" value="<?php echo $this->request->data['Event']['start_date']; ?>"/>
                        <input type="hidden" name="data[Event][end_date]" id="event_end" value="<?php echo $this->request->data['Event']['end_date']; ?>"/>
                        <div class="form-group">
                            <label for="EventUserId" class="col-sm-2 control-label"><?php echo __('User'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('user_id', array('options' => $users, 'label' => false, 'div' => false, 'empty' => __('Select User'), 'class' => 'form-control select2')); ?>
                                <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
                                <div class="error" id="EventUserIdError"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="EventName" class="col-sm-2 control-label"><?php echo __('Name'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('name', array('label' => false, 'div' => false, 'placeholder' => __('Event Name'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="EventDescription" class="col-sm-2 control-label"><?php echo __('Description'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('description', array('type' => 'textarea', 'label' => false, 'div' => false, 'placeholder' => __('Description'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="EventType" class="col-sm-2 control-label"><?php echo __('Equipment'); ?></label>
                            <div class="col-sm-10">
                                <div class="radio fl">
                                    <label><input name="data[Event][is_equipment_provided]" id="is_equipment_provided1" value="0" type="radio" <?php echo ($this->request->data['Event']['is_equipment_provided'] == "0") ? "checked" : ""; ?>/>&nbsp;Self</label>
                                </div>
                                <div class="radio fl" style="margin-left:20px;">
                                    <label><input name="data[Event][is_equipment_provided]" id="is_equipment_provided2" value="1" type="radio" <?php echo ($this->request->data['Event']['is_equipment_provided'] == "1") ? "checked" : ""; ?>/>&nbsp;Provided</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="EventType" class="col-sm-2 control-label"><?php echo __('Participation Fee'); ?></label>
                            <div class="col-sm-10">
                                <div class="radio fl">
                                    <label for="fee_free"><input name="data[Event][fee_type]" id="fee_free" value="free" class="radio_fee" type="radio" <?php echo ($this->request->data['Event']['fee_type'] == 'free') ? "checked" : ""; ?>/>&nbsp;&nbsp;Free</label>
                                </div>
                                <div class="radio fl" style="margin-left:20px;">
                                    <label for="fee_price"><input name="data[Event][fee_type]" id="fee_price" value="paid" class="radio_fee" type="radio" <?php echo ($this->request->data['Event']['fee_type'] == 'paid') ? "checked" : ""; ?>/>&nbsp;&nbsp;Paid</label>
                                </div>
                            </div>
                        </div>

                        <?php
                        $style = ($this->request->data['Event']['fee_type'] == 'free') ? "display:none;" : "display:block;";
                        ?>
                        <div class="form-group" style="<?php echo $style; ?>" id="custom_price">
                            <label for="EventFee" class="col-sm-2 control-label"><?php echo __('Fee'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('fee', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Participation Fee'), 'class' => 'form-control numbersOnly')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="EventType" class="col-sm-2 control-label"><?php echo __('Schedule'); ?>*</label>
                            <div class="col-sm-10">
                                <div class="radio fl">
                                    <label for="run_daily"><input name="data[Event][schedule_type]" id="run_daily" value="Immediate" class="range_radio" type="radio" <?php echo ($this->request->data['Event']['schedule_type'] == 'Immediate') ? "checked" : ""; ?>/>&nbsp;&nbsp;Event Date</label>
                                </div>
                                <div class="radio fl" style="margin-left:20px;">
                                    <label for="run_specific"><input name="data[Event][schedule_type]" id="run_specific" value="Specific" class="range_radio" type="radio" <?php echo ($this->request->data['Event']['schedule_type'] == 'Specific') ? "checked" : ""; ?>/>&nbsp;&nbsp;Schedule Dates</label>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($this->request->data['Event']['schedule_type'] == 'Immediate') {
                            $date_style = "display:block;";
                            $range_div = "display:none;";
                        } else {
                            $date_style = "display:none;";
                            $range_div = "display:block;";
                        }
                        ?>
                        <div class="form-group" id="end_date_div" style="<?php echo $date_style; ?>">
                            <label for="EventCustomEndDate" class="col-sm-2 control-label"><?php echo __('Event Date'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('custom_end_date', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'Event Date', 'class' => 'form-control', 'value' => date("d/m/Y", strtotime($this->request->data['Event']['start_date'])))); ?>
                            </div>
                        </div>
                        <div class="form-group" id="range_div" style="<?php echo $range_div; ?>">
                            <label for="EventEventRange" class="col-sm-2 control-label"><?php echo __('Date Range'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('event_range', array('label' => false, 'div' => false, 'placeholder' => 'Date Range', 'class' => 'form-control', 'readonly' => 'true', 'value' => date("d/m/Y", strtotime($this->request->data['Event']['start_date'])) . " - " . date("d/m/Y", strtotime($this->request->data['Event']['end_date'])))); ?>
                            </div>
                        </div>

                        <hr/>
                        <div class="form-group">
                            <label for="EventCityId" class="col-sm-2 control-label"><?php echo __('City'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('city_id', array('options' => $cities, 'empty' => __('Select City'), 'label' => false, 'div' => false, 'class' => 'form-control')); ?>
                            </div>
                            <div class="col-sm-10 fr" id="EventCityIdErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="EventLocalityId" class="col-sm-2 control-label"><?php echo __('Locality'); ?>*</label>
                            <div class="col-sm-10">
                                <?php
                                echo $this->Form->input('locality_id', array('empty' => __('Select Locality'), 'label' => false, 'div' => false, 'class' => 'form-control'));
                                echo $this->Form->input('locality_id_tmp', array('type' => "hidden", "id" => "EventLocalityId_tmp", "value" => @$this->data['Event']['locality_id']));
                                ?>
                            </div>
                            <div class="col-sm-10 fr" id="EventLocalityIdErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="EventAddress" class="col-sm-2 control-label"><?php echo __('Address'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('address', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Address'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="EventLandmark" class="col-sm-2 control-label"><?php echo __('Landmark'); ?>
                            </label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('landmark', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Landmark'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="EventPincode" class="col-sm-2 control-label"><?php echo __('Pincode'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('pincode', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Pincode'), 'class' => 'form-control numbersOnly', 'maxlength' => 6)); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"><?php echo __('Map'); ?></label>
                            <?php
                            echo $this->Form->input('latitude', array('id' => 'latitude', 'type' => "hidden"));
                            echo $this->Form->input('longitude', array('id' => 'longitude', 'type' => "hidden"));
                            ?>
                            <div class="col-sm-10"><div id="map" style="height:350px;"></div></div>
                        </div>

                        <hr/>

                        <div class="form-group">
                            <label for="EventContactPerson" class="col-sm-2 control-label"><?php echo __('Contact Person'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('contact_person', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Contact Person'), 'class' => 'form-control alphaOnly')); ?>
                            </div>
                        </div>
                        <div class="form-group" id="EventPhoneBlock">
                            <label for="EventPhone" class="col-sm-2 control-label"><?php echo __('Phone'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('phone', array('type' => 'text', 'label' => false, 'div' => false, 'maxlength' => 25, 'placeholder' => __('Phone'), 'class' => 'form-control numbers')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="EventEmail" class="col-sm-2 control-label"><?php echo __('Email'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('email', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Email'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessLogo" class="col-sm-2 control-label"><?php echo __('Event Logo'); ?></label>
                            <div class="col-sm-10">
                                <?php
                                $found = '';
                                $file_path = EVENT_BANNER_DIR . "banner" . DS . $this->data['Event']['id'] . DS . $this->data['Event']['banner'];
                                if (trim($this->data['Event']['banner']) != '' && file_exists($file_path)) {
                                    $found = 'Yes';
                                    ?>
                                    <input type="hidden" id="banner_old" value="<?php echo trim($this->data['Event']['banner']); ?>" />
                                    <div class="banner_image">
                                        <img class="colorbox" src="<?php echo $this->Format->show_event_banner($this->data, 122, 122, 0); ?>" data-href="<?php echo $this->Format->show_event_banner($this->data, 500, 500, 0); ?>" alt="" />
                                        <a class="anchor" onclick="$('.banner_image').slideUp();
                                                $('.banner_edit').slideDown();">Change Banner</a> &nbsp;|&nbsp;
                                        <a class="anchor" onclick="delete_banner(<?php echo intval($this->data['Event']['id']); ?>)">Remove Banner</a>
                                    </div>
                                <?php } ?>
                                <div class="banner_edit <?php echo $found == 'Yes' ? " none " : " "; ?>">
                                    <?php echo $this->Form->input('banner', array('type' => 'file', 'label' => false, 'div' => false, 'placeholder' => 'Banner', 'class' => 'form-control')); ?>
                                    <?php if ($found == 'Yes') { ?>
                                        <div class="cb"></div>
                                        <a class="anchor cancelicn" style="margin-bottom:10px;" onclick="$('.banner_edit').slideUp();
                                                $('.banner_image').slideDown();">Cancel</a>
                                       <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $this->Form->input('dir_path', array('type' => 'hidden', 'value' => EVENT_BANNER_DIR)); ?>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" onclick="return validate_event();" class="btn btn-success"><?php echo __('Submit'); ?></button>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<script type="text/javascript">
    function delete_banner(id) {
        if (confirm('Are you sure you want to delete logo?')) {
            $.post(HTTP_ROOT + "events/delete_banner", {
                id: id
            }, function (response) {
                if (response.success == 1) {
                    $('.banner_image').slideUp().remove();
                    $('.cancelicn').remove();
                    $('.banner_edit').slideDown();
                }
                alert(response.message);
            }, 'json');
        }
    }
    var data_arr = [];
    var geocoder;
    function initMap() {
        var myloc = {
            lat: parseFloat($('#latitude').val()),
            lng: parseFloat($('#longitude').val())
        };
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            scrollwheel: false,
            center: myloc
        });
        geocoder = new google.maps.Geocoder();

        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: myloc
        });
        marker.addListener('click', function () {
            infoWindow.open(map, marker);
        });
        markers.push(marker);
        google.maps.event.addListener(marker, 'dragend', function (evt) {
            set_latlng(evt.latLng.lat().toFixed(7), evt.latLng.lng().toFixed(7));
            geocodePosition(marker.getPosition());
        });
        setTimeout(function () {
            $("#EventCityId,#EventAddress,#EventLandmark").change(function () {
                geo_search(geocoder, map);
            });
        }, 1000);
    }
    var event_start = "<?php echo $this->request->data['Event']['start_date']; ?>";
    var event_end = "<?php echo $this->request->data['Event']['end_date']; ?>";
    var event_fee = "<?php echo $this->request->data['Event']['fee']; ?>";
    var date_range_picker_opts;
    jQuery(document).ready(function ($) {
        date_range_picker_opts = {
            autoUpdateInput: false,
            startDate: moment(event_start).format('MM/DD/YYYY'),
            endDate: moment(event_end).format('MM/DD/YYYY'),
            minDate: moment().format('MM/DD/YYYY'),
            locale: {
                cancelLabel: 'Clear'
            }
        };
        $(".radio_fee").on('change', function () {
            if (_.trim($(this).val()) == "free") {
                $("#custom_price").slideUp();
            } else {
                $("#custom_price").slideDown();
                (parseInt(event_fee)) ? $('#EventFee').val(event_fee) : $('#EventFee').val('');
            }
        });
        $(".range_radio").on('change', function () {
            if (_.trim($(this).val()) == "Immediate") {
                $("#range_div").slideUp();
                $("#end_date_div").slideDown();
                $("#event_start").val(moment().format('YYYY-MM-DD'));
                $("#EventCustomEndDate").val('');
                $("#event_end").val('');
            } else {
                $("#end_date_div").slideUp();
                $("#range_div").slideDown();
                $("#event_start").val(event_start);
                $("#event_end").val(event_end);
                $("#EventCustomEndDate").val('');
            }
        });
        $('#EventEventRange').daterangepicker(date_range_picker_opts)
                .on('apply.daterangepicker', function (ev, picker) {$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY')).attr('readonly', true);$('#event_start').val(picker.startDate.format('YYYY-MM-DD'));$('#event_end').val(picker.endDate.format('YYYY-MM-DD'));})
                .on('cancel.daterangepicker', function (ev, picker) {$(this).val('').attr('readonly', false);$('#event_start').val('');$('#event_end').val('');});

        $('#EventCustomEndDate').datepicker({format: "dd/mm/yyyy",clearBtn: true,autoclose: true,todayHighlight: true,startDate: moment().toString()})
                .on('changeDate', function (e) {var date = moment(e.date);var formatted_date = date.format('YYYY-MM-DD');$("#event_end").val(formatted_date);})
                .on('clearDate', function (e) {$("#event_end").val('');});
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_KEY; ?>&libraries=places&callback=initMap" async defer></script>