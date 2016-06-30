<?php
$existing_count = count($courses);
$block_count = ($existing_count > 0) ? $existing_count : 1;
?>
<div class="content-full add-utube-video-link">
    <div class="content-left fl">
        <?php echo $this->element('user_inner_left_navbar'); ?>
    </div>
    <div class="content-right fl">
        <div class="heading"><span class="edit-business"></span> Manage Business Courses</div>
        <div class="cb"></div>
        <?php echo $this->element('front_edit_business_tabs', array('BusinessId' => $business_id)); ?>
        <div class="cb"></div>
        <div class="bg-trns-white pdtop_gly">
            <?php echo $this->Form->create('Business'); ?>
            <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $this->params['pass'][0])); ?>
            <div class="field_wrapper pad40" id="parent_block">
                <?php if (is_array($courses) && count($courses) > 0) { ?>
                    <?php foreach ($courses as $key => $course) { ?>
                        <div class="form-group course_block" id="course_block_<?php echo $key; ?>">
                            <?php echo $this->Form->input('id' . $key, array('type' => 'hidden', 'name' => 'Business[course][' . $key . '][id]', 'value' => $course['BusinessCourse']['id'], 'class' => 'form-control', 'placeholder' => 'Course Name', 'div' => false, 'label' => false)); ?>
                            <label class="col-sm-2 control-label"><?php echo __('Course'); ?> <span class="blockcounter"><?php echo $key + 1; ?></span></label>
                            <div class="col-sm-4">
                                <?php echo $this->Form->input('name' . $key . '', array('type' => 'text', 'name' => 'Business[course][' . $key . '][name]', 'value' => $course['BusinessCourse']['name'], 'class' => 'form-control coursename', 'placeholder' => 'Course Name', 'div' => false, 'label' => false)); ?>
                                <span id="course_name_error_<?php echo $key; ?>" class="course_name_error"></span>
                            </div>
                            <div class="col-sm-4">
                                <?php echo $this->Form->input('price' . $key . '', array('type' => 'text', 'name' => 'Business[course][' . $key . '][price]', 'value' => $course['BusinessCourse']['price'], 'class' => 'form-control numbersOnly pricevalue', 'placeholder' => 'Price', 'div' => false, 'label' => false)); ?>
                                <span id="course_price_error_<?php echo $key; ?>" class="course_price_error"></span>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-social-icon btn-google remove_button trans-block" data-id="<?php echo $course['BusinessCourse']['id'];?>" type="button" rel="tooltip" title="" data-original-title="Remove"><i class="ion-minus-circled"></i></button>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="form-group course_block" id="course_block_0">
                        <?php echo $this->Form->input('id0', array('type' => 'hidden', 'name' => 'Business[course][0][id]', 'class' => 'form-control', 'placeholder' => 'Course Name', 'div' => false, 'label' => false)); ?>
                        <label class="col-sm-2 control-label"><?php echo __('Course'); ?> <span class="blockcounter">1</span></label>
                        <div class="col-sm-4">
                            <?php echo $this->Form->input('name0', array('type' => 'text', 'name' => 'Business[course][0][name]', 'class' => 'form-control coursename', 'placeholder' => 'Course Name', 'div' => false, 'label' => false)); ?>
                            <span id="course_name_error_0" class="course_name_error"></span>
                        </div>
                        <div class="col-sm-4">
                            <?php echo $this->Form->input('price0', array('type' => 'text', 'name' => 'Business[course][0][price]', 'class' => 'form-control numbersOnly pricevalue', 'placeholder' => 'Price', 'div' => false, 'label' => false)); ?>
                            <span id="course_price_error_0" class="course_price_error"></span>
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-social-icon btn-google remove_button trans-block" data-id="" type="button" rel="tooltip" title="" data-original-title="Remove"><i class="ion-minus-circled"></i></button>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="cb"></div>
            <div class="form-group">
                <div class="col-sm-2">&nbsp;</div>
                <div class="col-sm-4">
                    <button class="cmn_btn_n pad_big btn-block" type="submit">Save</button>
                </div>
                <div class="col-sm-4">&nbsp;</div>
                <div class="col-sm-2">
                    <button class="btn btn-success btn-social-icon add_button trans-block" rel="tooltip" title="" type="button" data-original-title="Add More"><i class="ion-plus-circled"></i></button>
                </div>
            </div>

            <div class="cb"></div>
        </div>
        <div class="cb20"></div>
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="cb20"></div>
</div>
<script>
    $(document).ready(function() {
        var wrapper = $('#parent_block')
        var block_count = 0;
        var clone_blk = wrapper.find('.form-group').eq(0).clone();
        $('.add_button').on('click', function() {
            fieldHTML = clone_blk.clone();
            block_count++;
            $(fieldHTML).find(".remove_button").attr('data-id', '');
            $(fieldHTML).find(".blockcounter").html(block_count + 1);
            //var sel = $(fieldHTML).find('.url_input_class');
            //$(sel).find("input[type='text']").val('');
            //$(sel).find("input[type='hidden'][name$='[id]']").val('');
            $(fieldHTML).find('input').each(function() {
                $(this).val('');
                var oldname = $(this).attr('name');
                if (typeof oldname !== 'undefined') {
                    var newname = oldname.replace(/\d+/, block_count);
                    $(this).attr('name', newname);
                }
                var oldid = $(this).attr('id');
                if (typeof oldid !== 'undefined') {
                    var newid = oldid.replace(/\d+/, block_count);
                    $(this).attr('id', newid);
                }
            });

            wrapper.append(fieldHTML);

            /*if (counter < video_limit) {
             counter++;
             } else {
             (video_limit) ? alert('Sorry! you have reached your limit. you can not add more videos.','error') : alert('Sorry! you can not add more than '+maxField+' videos.','error');
             }*/
        });
        $(wrapper).on('click', '.remove_button', function(event) {
            var attr = $(this).attr('data-id');
            var obj = $(this);
            if (typeof attr !== 'undefined' && attr !== '') {
                confirm("Are You Sure want to delete the course?", function() {
                    $('.overlay_div').show();
                    $.ajax({
                        type: "POST",
                        data: {
                            id: attr,
                            mode: 'delete'
                        },
                        dataType:'json',
                        url: "<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'courses')); ?>",
                        success: function(response) {
                            $('.overlay_div').hide();
                            if (response.success) {
                                obj.closest('.form-group').remove();
                            }
                        }
                    });
                });
            } else {
                $(this).closest('.form-group').remove();
            }
            //counter--;
        });
        $('#BusinessCoursesForm').submit(function(){
            return validateform();
        });
        function validateform(){
            var valid = true;
            $('.coursename').each(function(){
                if($(this).val() == ''){
                    $(this).focus();
                    alert('Please enter course name.')
                    valid = false;
                }
            });
            return valid;
        }
    });
</script>