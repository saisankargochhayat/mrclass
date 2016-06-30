<?php

echo $this->Html->css(array('bootstrap-timepicker.min'), array('block' => 'timepickercss'));
echo $this->Html->script(array('bootstrap-timepicker.min'), array('block' => 'timepicker'));
?>
<section class="content-header">
    <h1><?php echo __('Edit Business'); ?>: <?php echo h($business);?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'index', 'admin' => 1)); ?>">Businesses</a></li>
        <li class="active"><?php echo __('Edit Business'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <?php echo $this->element('admin_business_edit_tabs'); ?>
                <div class="tab-content">
                    <div class="active tab-pane" id="timings">
                        <div class="box-body ">
                            <?php echo $this->Form->create('BusinessTiming', array('class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width:15%;">Days</th>
                                        <th style="width:35%;">Opening Time</th>
                                        <th style="width:35%;">Closing Time</th>
                                        <th style="width:15%;">Mark as Holiday</th>
                                    </tr>
                                    <?php
                                    $businessdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                                    foreach ($businessdays as $k => $v) {
                                        ?>
                                <input type="hidden" name="data[BusinessTiming][<?php echo $v; ?>][business_id]" class="form-control" value="<?php echo $this->params['pass'][0]; ?>"/>
                                <input type="hidden" name="data[BusinessTiming][<?php echo $v; ?>][id]" class="form-control" value="<?php echo @$businesses[$k]['BusinessTiming']['id']; ?>"/>
                                <tr class="business_hours" data-Day="<?php echo $v; ?>">
                                    <td>
                                        <label class="control-label"><?php echo __($v); ?></label>
                                        <input type="hidden" name="data[BusinessTiming][<?php echo $v; ?>][day]" class="form-control" value="<?php echo $k; ?>">
                                        <?php if($v == 'Monday'){?>
                                        <span style="margin-left:28px;">
                                            <input type="checkbox" name="common_time" id="common_time_<?php echo $v; ?>" value="" data-common="<?php echo $v; ?>" rel="tooltip" data-original-title="Check to set time same as monday for all days."/>
                                            <i class="ion ion-information-circled" rel="tooltip" data-original-title="Check to set time same as monday for all days."></i>
                                        </span>
                                        <?php }?>
                                    </td>
                                    <td class="bootstrap-timepicker timepicker">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input id="timepicker_start_<?php echo $v; ?>" name="data[BusinessTiming][<?php echo $v; ?>][start_time_temp]" data-openDay="<?php echo $v; ?>" type="text" class="form-control open-time" rel="tooltip" value="<?php echo @$this->Format->format_24hr_to_12hr($businesses[$k]['BusinessTiming']['start_time']); ?>">
                                            <input id="startpicker_temp_<?php echo $v; ?>" name="data[BusinessTiming][<?php echo $v; ?>][start_time]" type="hidden" class="form-control" value="">
                                        </div>
                                    </td>
                                    <td class="bootstrap-timepicker timepicker">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input id="timepicker_close_<?php echo $v; ?>" type="text" name="data[BusinessTiming][<?php echo $v; ?>][close_time_temp]" data-closeDay="<?php echo $v; ?>" class="form-control close-time" rel="tooltip" value="<?php echo @$this->Format->format_24hr_to_12hr($businesses[$k]['BusinessTiming']['close_time']); ?>"/>
                                            <input id="closepicker_temp_<?php echo $v; ?>" type="hidden" name="data[BusinessTiming][<?php echo $v; ?>][close_time]" class="form-control" value="" />
                                        </div>
                                    </td>
                                    <td style="text-align:center;">
                                        <input type="hidden" name="data[BusinessTiming][<?php echo $v; ?>][holiday]" value="0" />
                                        <input type="checkbox" class="markasholiday" name="data[BusinessTiming][<?php echo $v; ?>][holiday]" value="1" <?php echo (intval(@$businesses[$k]['BusinessTiming']['holiday']) == 1 ? 'checked' : '');?>/>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-0"></div>
                                <div class="col-md-4">
                                    <button class="btn btn-success btn-block" type="submit" >Save</button>
                                </div>
                                <div class="col-md-8"></div>
                            </div>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div><!-- /.tab-pane -->    
                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
    $(document).ready(function () {
        $(".markasholiday").each(function(){
            $(this).is(':checked')?$(this).closest('.business_hours').find('input[type=text]').attr('disabled','disabled'):"";
        });
        $(".markasholiday").change(function(){
            $(this).is(':checked')?$(this).closest('.business_hours').find('input[type=text]').attr('disabled','disabled'):$(this).closest('.business_hours').find('input[type=text]').attr('disabled',false);
        });
        $("input[id^='timepicker_start_']").each(function() {
           $(this).attr({'data-original-title': 'Change opening time for '+$(this).attr("data-openday")
            }); 
        });
        $("input[id^='timepicker_close_']").each(function() {
            $(this).attr({'data-original-title': 'Change close time for '+$(this).attr("data-closeday")
            });
        });
        var start_time = $("input[id^='timepicker_start_']").timepicker({
            showInputs: false,
            defaultTime: '00:00:00',
            minuteStep: 5
        });
        var start_time = $("input[id^='timepicker_close_']").timepicker({
            showInputs: false,
            defaultTime: '00:00:00',
            minuteStep: 5
        });
        $("input[id^='timepicker_start_']").timepicker().on('changeTime.timepicker', function (e) {
            $("input[id^='startpicker_temp_" + $(this).data('openday') + "']").val(trim(mrClass_Global.format12to24(e.time.value)));
        });
        $("input[id^='timepicker_close_']").timepicker().on('changeTime.timepicker', function (e) {
            $("input[id^='closepicker_temp_" + $(this).data('closeday') + "']").val(trim(mrClass_Global.format12to24(e.time.value)));
        });
        $(".open-time").each(function () {
            //$("input[name='data[BusinessTiming][" + $(this).data('openday') + "][start_time]']").val(trim(mrClass_Global.format12to24($(this).val())));
        });
        $(".close-time").each(function () {
            $("input[name='data[BusinessTiming][" + $(this).data('closeday') + "][close_time]']").val(trim(mrClass_Global.format12to24($(this).val())));
        });
        $('#common_time_Monday').change(function () {
            if ($(this).is(":checked")) {
                var common_start = $('#timepicker_start_' + $(this).data('common')).val();
                var common_close = $('#timepicker_close_' + $(this).data('common')).val();
                $('.open-time').each(function () {
                    $(this).val(common_start);
                    $("input[id^='startpicker_temp_']").val(trim(mrClass_Global.format12to24(common_start)));
                });
                $('.close-time').each(function () {
                    $(this).val(common_close);
                    $("input[id^='closepicker_temp_']").val(trim(mrClass_Global.format12to24(common_close)));
                });
            }
        });
        $('#BusinessTimingAdminAddForm').validate({
            submitHandler: function (form) {
                var error_arr = validate_businesshours();
                //console.log(error_arr);
                if (error_arr.length > 0) {
                    $('input.error').eq(0).focus();
                    alert("Starting time and closing time can not be empty or equal and closing time must be greater than starting time.");
                    return false;
                } else {
                    //document.form.submit();
                    return true;
                }
            }
        });
    });
    function validate_businesshours() {
        var is_valid;
        var error_day_arr = [];
        $("input[id^='timepicker_start_'],input[id^='timepicker_close_']").removeClass('error');
        $(".business_hours").each(function () {
            day = $(this).data('day');
            var start_time = trim(mrClass_Global.format12to24($('#timepicker_start_' + day).val()));
            var close_time = trim(mrClass_Global.format12to24($('#timepicker_close_' + day).val()));
            var start_time_arr = start_time.split(":");
            var close_time_arr = close_time.split(":");
            var startTimeObject = new Date();
            startTimeObject.setHours(start_time_arr[0], start_time_arr[1], start_time_arr[2]);
            var endTimeObject = new Date(startTimeObject);
            endTimeObject.setHours(close_time_arr[0], close_time_arr[1], close_time_arr[2]);
            var valid = true;
            
            if(!$('#timepicker_start_' + day).is(':disabled')){
                if (startTimeObject > endTimeObject) {
                    valid = false;
                } else if (start_time == '' ||  close_time == '') {
                    valid = false;
                    start_time == ''?$('#timepicker_start_' + day).addClass('error'):'';
                } else if (startTimeObject.getTime() == endTimeObject.getTime()) {
                    valid = false;
                }
                 if(!valid){
                    $('#timepicker_close_' + day).addClass('error');
                    error_day_arr.push(day);
                }
            }
        });
        return error_day_arr;
    }
</script>