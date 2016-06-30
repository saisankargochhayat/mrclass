<?php
echo $this->Html->script(array('ckeditor/ckeditor'), array('inline' => false));
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Faqs'); ?><small></small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> <?php echo __('Home'); ?></a></li>
        <li><?php echo $this->Html->link(__('Business Faqs'), array("controller" => "BusinessFaqs", "action" => "index", "admin" => 1,$BusinessId,"bfaqs")); ?></li>
        <li class="active"><?php echo __('Add Business Faq'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#faqEdit" data-toggle="tab">Edit Faq</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="BusinessfaqEdit">
                        <?php echo $this->Form->create('BusinessFaq', array('class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
                        <?php echo $this->Form->input('id');?>
                        <div class="form-group">
                            <label for="BusinessFaqTitle" class="col-sm-1 control-label"><?php echo __('Title'); ?></label>
                            <div class="col-sm-11">
                                <?php echo $this->Form->input('title', array('label' => false, 'div' => false, 'placeholder' => __('Title'), 'class' => 'form-control')); ?>
								<div class="error" id="title_error"></div>
							</div>
                        </div>
                        <div class="form-group">
                            <label for="BusinessFaqContent" class="col-sm-1 control-label"><?php echo __('Description'); ?></label>
                            <div class="col-sm-11">
                                <?php echo $this->Form->input('content', array('label' => false, 'div' => false, 'placeholder' => __('Description'), 'class' => 'form-control')); ?>
								<div class="error" id="content_error"></div>
							</div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-11">
                                <button type="button" class="btn btn-success" onclick="validate_edit_business_faqs();"><?php echo __('Submit'); ?></button>
                                &nbsp;or&nbsp;
                                <?php echo $this->Html->link(__('Cancel'), array('action' => 'index','admin'=>1,$BusinessId,"bfaqs")); ?>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col-->
    </div><!-- ./row -->
</section><!-- /.content -->
<!-- CK Editor -->
<script>
    $(function() {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('BusinessFaqContent');
    });
</script>
