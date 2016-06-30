<?php
echo $this->Html->css(array('bootstrap-datepicker.min'), array('block' => 'bootstrap_datatable_css'));
echo $this->Html->script(array('bootstrap-datepicker.min'), array('inline' => false));
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Presses'); ?><small></small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> <?php echo __('Home'); ?></a></li>
        <li><?php echo $this->Html->link(__('Presses'), array('action' => 'index')); ?></li>
        <li class="active"><?php echo __('Edit Press'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab"><?php echo __('Edit Press'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="PressEdit">
                        <?php echo $this->Form->create('Press', array('class' => 'form-horizontal', 'autocomplete' => 'off', 'type' => 'file')); ?>

                        <?php echo $this->Form->input('id'); ?>
                        <div class="form-group">
                            <label for="PressName" class="col-sm-2 control-label"><?php echo __('Title'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('name', array('label' => false, 'div' => false, 'placeholder' => __('Title'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PressSource" class="col-sm-2 control-label"><?php echo __('Source'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('source', array('label' => false, 'div' => false, 'placeholder' => __('Source Name'), 'class' => 'form-control')); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="PressLink" class="col-sm-2 control-label"><?php echo __('Link'); ?>*</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('link', array('label' => false, 'div' => false, 'placeholder' => __('Source Link'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PressPreview" class="col-sm-2 control-label"><?php echo __('Preview'); ?></label>
                            <div class="col-sm-10">
                                <?php
                                $found = '';
                                $file_path = PRESS_IMAGE_DIR . "preview" . DS . $this->data['Press']['id'] . DS . $this->data['Press']['preview'];
                                if (trim($this->data['Press']['preview']) != '' && file_exists($file_path)) {
                                    $found = 'Yes';
                                    ?>
                                    <input type="hidden" id="preview_old" value="<?php echo trim($this->data['Press']['preview']); ?>"/>
                                    <div class="preview_image">
                                        <img class="colorbox" src="<?php echo $this->Format->show_press_image($this->data['Press'], 122, 122, 0); ?>" 
                                             data-href="<?php echo $this->Format->show_press_image($this->data['Press'], 500, 500, 0); ?>"
                                             alt=""/>
                                        <a class="anchor" onclick="$('.preview_image').slideUp();
                                                    $('.preview_edit').slideDown();">Change Image</a>
                                        &nbsp;|&nbsp;
                                        <a class="anchor" onclick="delete_preview(<?php echo intval($this->data['Press']['id']); ?>)">Remove Preview</a>
                                    </div>
                                <?php } ?>
                                <div class="preview_edit <?php echo $found == 'Yes' ? "none" : ""; ?>">
                                    <?php echo $this->Form->input('preview', array('type' => 'file', 'label' => false, 'div' => false, 'placeholder' => 'Preview Image', 'class' => 'form-control')); ?>
                                    <?php if ($found == 'Yes') { ?>
                                        <div class="cb"></div>
                                        <a class="anchor cancelicn" style="margin-bottom:10px;" onclick="$('.preview_edit').slideUp();
                                                    $('.preview_image').slideDown();">Cancel</a>
                                       <?php } ?>
                                </div>

                               
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PressPublishedDate" class="col-sm-2 control-label"><?php echo __('Published Date'); ?></label>
                            <div class="col-sm-10 PressPublishedDate">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <?php
                                    echo $this->Form->input('published_date', array('label' => false, 'div' => false, 'type' => 'text',
                                        'placeholder' => __('Published Date'), 'class' => 'form-control'));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php /*<div class="form-group">
                            <label for="PressDescription" class="col-sm-2 control-label"><?php echo __('Description'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('description', array('label' => false, 'div' => false, 'placeholder' => __('Description'), 'class' => 'form-control')); ?>
                            </div>
                        </div> */?>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-success" ><?php echo __('Submit'); ?></button>
                                &nbsp;or&nbsp;
                                <?php echo $this->Html->link(__('Cancel'), array('action' => 'index', 'admin' => 1)); ?>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div><!-- /.tab-pane -->

                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col-->
    </div><!-- ./row -->
</section><!-- /.content -->
<script>
    $(document).ready(function () {
        $('#PressPublishedDate').datepicker({
            format: 'M dd, yyyy', dateFormat: 'M d, yy', maxDate: '0', autoclose: true, clearBtn: true, changeYear: true, changeMonth: true, yearRange: "-100:+0", startDate: "01/01/1901", endDate: new Date(), clearBtn: true
        });
        
        $("#PressLink")
                .focus(function(){$("#PressLink").val()==""?$("#PressLink").val('http://'):"";})
                .blur(function(){$("#PressLink").val()=="http://"?$("#PressLink").val(''):"";});
        $('#PressAdminAddForm').validate({
            rules: {
                'data[Press][name]': {required: true},
                'data[Press][source]': {required: true},
                'data[Press][link]': {required: true,url:true},
                //'data[Press][image]': {required: true}
            },
            messages: {
                'data[Press][name]': {required: "Please enter title."},
                'data[Press][source]': {required: "Please enter source name"},
                'data[Press][link]': {required: "Please enter source link",url:"Please enter valid url"},
                'data[Press][image]': {required: "Please select facility icon."}
            },
            errorPlacement: function (error, element) {
                if (element.attr("id") == "select") {
                    error.appendTo($("#selectErr"));
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });
    function delete_preview(id){
        if(confirm('Are you sure you want to delete preview image?')){
                $.post(HTTP_ROOT+"presses/delete_preview",{id:id},function(response){
                    if(response.success == 1){
                        $('.preview_image').slideUp().remove();
                        $('.cancelicn').remove();
                        $('.preview_edit').slideDown();
                    }
                    alert(response.message);
                },'json');
        }
    }
</script>
