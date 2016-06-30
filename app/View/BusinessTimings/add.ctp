<?php
echo $this->Html->css(array('timepicker/jquery-ui-timepicker-addon.min'));
echo $this->Html->script(array('timepicker/jquery-ui-timepicker-addon.min', 'timepicker/i18n/jquery-ui-timepicker-addon-i18n.min', 'timepicker/jquery-ui-sliderAccess'), array('inline' => true));
?>
<style>
    .hasDatepicker , .ui_tpicker_time {text-transform: uppercase; text-align: center;}
    input.error{border: 1px solid red;}
</style>
<div class="content-full business-timing-details">
    <div class="content-left fl">
        <?php echo $this->element('user_inner_left_navbar'); ?>
    </div>
    <div class="content-right fl">
        <div class="heading"><span class="edit-business"></span> Update Business Timings</div>
        <?php echo $this->element('front_edit_business_tabs', array('BusinessId' => $BusinessId)); ?>
        <div class="cb"></div>
        <div class="bg-trns-white">
            <?php echo $this->Form->create('BusinessTiming', array('class' => 'form-horizontal', 'autocomplete' => 'off', 'id' => 'BusinessTimingAddForm')); ?>
            <table class="table table-bordered" style="width: 100%;">
                <tbody>
                    <tr style=" height: 40px;">
                        <th style="width:20%; text-align: left; padding: 5px;">Days</th>
                        <th style="width:30%; text-align: left; padding: 5px;">Opening Time</th>
                        <th style="width:30%; text-align: left; padding: 5px;">Closing Time</th>
                        <th style="width:14%; text-align: left; padding: 5px;">Mark As Holiday</th>
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
                            <?php if ($v == 'Monday') { ?>
                                <span style="margin-left:28px;">
                                    <input type="checkbox" name="common_time" id="common_time_<?php echo $v; ?>" value="" data-common="<?php echo $v; ?>" rel="tooltip" title="Check to set all same as monday for all days."/>
                                    <i class="ion ion-information-circled" rel="tooltip" title="Check to set time same as monday for all days."></i>
                                </span>
                            <?php } ?>
                        </td>
                        <td class="bootstrap-timepicker timepicker">
                            <div class="input-group" style="width:90%;margin-bottom: 5px;">

                                <input id="timepicker_start_<?php echo $v; ?>" 
                                       readonly="readonly"
                                        name="data[BusinessTiming][<?php echo $v; ?>][start_time_temp]"
                                        rel="<?php echo @$this->Format->format_24hr_to_12hr($businesses[$k]['BusinessTiming']['start_time']); ?>" 
                                        value="<?php echo @$this->Format->format_24hr_to_12hr($businesses[$k]['BusinessTiming']['start_time']); ?>"
                                        type="text" class="form-control open-time" />
                                <input id="startpicker_temp_<?php echo $v; ?>" name="data[BusinessTiming][<?php echo $v; ?>][start_time]" type="hidden" value=""/>
                            </div>
                        </td>
                        <td class="bootstrap-timepicker timepicker">
                            <div class="input-group" style="width:90%;margin-bottom: 5px;">

                                <input id="timepicker_close_<?php echo $v; ?>"
                                       readonly="readonly"
                                       name="data[BusinessTiming][<?php echo $v; ?>][close_time_temp]" 
                                       rel="<?php echo @$this->Format->format_24hr_to_12hr($businesses[$k]['BusinessTiming']['close_time']); ?>" 
                                       value="<?php echo @$this->Format->format_24hr_to_12hr($businesses[$k]['BusinessTiming']['close_time']); ?>"
                                       type="text" class="form-control close-time" />
                                <input id="closepicker_temp_<?php echo $v; ?>" name="data[BusinessTiming][<?php echo $v; ?>][close_time]" type="hidden" value="" />
                            </div>
                        </td>
                        <td style="text-align:center;">
                            <input type="hidden" name="data[BusinessTiming][<?php echo $v; ?>][holiday]" value="0" />
                            <input type="checkbox" class="markasholiday" name="data[BusinessTiming][<?php echo $v; ?>][holiday]" value="1" <?php echo (intval(@$businesses[$k]['BusinessTiming']['holiday']) == 1 ? 'checked' : ''); ?>/>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td><button class="cmn_btn_n pad_big" type="submit" >Save</button></td>
                    </tr>
                </tfoot>
            </table>
		<div class="cb20"></div>
        </div>
		
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="cb20"></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".markasholiday").each(function(){
            $(this).is(':checked')?$(this).closest('.business_hours').find('input[type=text]').attr('disabled','disabled'):"";
        });
        $(".markasholiday").change(function(){
            $(this).is(':checked')?$(this).closest('.business_hours').find('input[type=text]').attr('disabled','disabled'):$(this).closest('.business_hours').find('input[type=text]').attr('disabled',false);
        });
        $("input[id^='timepicker_start_']").attr({'title': 'Change opening time here'});
        $("input[id^='timepicker_close_']").attr({'title': 'Change close time here'});
        jQuery("input[id^='timepicker_start_']").timepicker({timeFormat: 'h:mm tt'});
        jQuery("input[id^='timepicker_close_']").timepicker({timeFormat: 'h:mm tt'});
        
        var newTime = new Date();
        jQuery("input[id^='timepicker_start_'], input[id^='timepicker_close_'").each(function(){
            var hr = (format12to24($(this).val()));
            var hrArr = hr.split(':');
            if (newTime) { // Not null
                newTime.setHours(hrArr[0]);
                newTime.setMinutes(hrArr[1]);
            }
            $(this).timepicker('setTime', newTime);
        });
        $('#BusinessTimingAddForm').validate({
            submitHandler: function(form) {
                var error_arr = validate_businesshours();
                //console.log(error_arr);
                if (error_arr.length > 0) {
                    General.hideAlert('now');
                    General.hideAlert();
                    $('input.error').eq(0).focus();
                    alert("Starting time and closing time can not be empty or equal and closing time must be greater than starting time.",'error');
                    return false;
                } else {
                    return true;
                }
            }
        });
        $('#common_time_Monday').change(function() {
            if ($(this).is(":checked")) {
                var common_start = $('#timepicker_start_' + $(this).data('common')).val();
                var common_close = $('#timepicker_close_' + $(this).data('common')).val();
                //$('.open-time').each(function() {
                    $("input[id^='timepicker_start_']").val(common_start);
                    $("input[id^='startpicker_temp_']").val($.trim(format12to24(common_start)));
                //});
                //$('.close-time').each(function() {
                    $("input[id^='timepicker_close_']").val(common_close);
                    $("input[id^='closepicker_temp_']").val($.trim(format12to24(common_close)));
                //});
            }else{
                $('.open-time').each(function() {
                    var common_start = $(this).attr('rel');
                    $(this).val(common_start);
                    $(this).closest('closest').find("input[id^='startpicker_temp_']").val($.trim(format12to24(common_start)));
                });
                $('.close-time').each(function() {
                    var common_close = $(this).attr('rel');
                    $(this).val(common_close);
                    $(this).closest('closest').find("input[id^='closepicker_temp_']").val($.trim(format12to24(common_close)));
                });
            }
        });
    });
    function validate_businesshours() {
        var is_valid;
        var day;
        var error_day_arr = [];
        
        $("input[id^='timepicker_start_'],input[id^='timepicker_close_']").removeClass('error');
        $(".business_hours").each(function() {
            day = $(this).data('day');
            var start_time = $.trim(format12to24($('#timepicker_start_' + day).val()));
            $('#startpicker_temp_' + day).val(start_time);
            var close_time = $.trim(format12to24($('#timepicker_close_' + day).val()));
            $('#closepicker_temp_' + day).val(close_time);
            //console.log(start_time+' >> '+close_time);
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
                    $('#timepicker_start_' + day).addClass('error');
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
        //console.log(error_day_arr)
        return error_day_arr;
    }
    function pgready(){
        jQuery("input[id^='timepicker_start_']").each(function(){$(this).attr('value') == '' ? $(this).val(''):'';});
        jQuery("input[id^='timepicker_close_']").each(function(){$(this).attr('value') == '' ? $(this).val(''):'';});
    }
    //window.onload=pgready;
</script>