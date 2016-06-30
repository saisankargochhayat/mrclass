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
        <li class="active"><?php echo __('Add Press'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab"><?php echo __('Add Press'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="PressAdd">
                        <?php echo $this->Form->create('Press', array('class' => 'form-horizontal', 'autocomplete' => 'off', 'type' => 'file')); ?>
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
                                <div class="input file">
                                    <?php echo $this->Form->input('preview', array('type' => 'file', 'label' => false, 'div' => false, 'placeholder' => __('Preview Image'), 'class' => '')); ?>
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
                        </div>*/?>
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
            format: 'M dd, yyyy',dateFormat: 'M d, yy',maxDate: '0',autoclose:true,clearBtn:true,changeYear:true,changeMonth:true,yearRange: "-100:+0",startDate: "01/01/1901",endDate: new Date(),clearBtn: true
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
</script>
