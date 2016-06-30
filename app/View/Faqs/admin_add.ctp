<?php
echo $this->Html->script(array('ckeditor/ckeditor'), array('inline' => false));
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Faqs'); ?><small></small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> <?php echo __('Home'); ?></a></li>
        <li><?php echo $this->Html->link(__('Faqs'), array('action' => 'index')); ?></li>
        <li class="active"><?php echo __('Add Faq'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#FaqAdd" data-toggle="tab">New Faq</a></li>
                    <!--<li><a href="#userAdd" data-toggle="tab">Settings</a></li>-->
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="FaqAdd">
                        <?php echo $this->Form->create('Faq', array('class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
                        <div class="form-group">
                            <label for="FaqTitle" class="col-sm-1 control-label"><?php echo __('Title'); ?></label>
                            <div class="col-sm-11">
                                <?php echo $this->Form->input('title', array('label' => false, 'div' => false, 'placeholder' => __('Title'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="FaqContent" class="col-sm-1 control-label"><?php echo __('Description'); ?></label>
                            <div class="col-sm-11">
                                <?php echo $this->Form->input('content', array('label' => false, 'div' => false, 'placeholder' => __('Description'), 'class' => 'form-control')); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-11">
                                <button type="submit" class="btn btn-success" ><?php echo __('Submit'); ?></button>
                                &nbsp;or&nbsp;
                                <?php echo $this->Html->link(__('Cancel'), array('action' => 'index','admin'=>1)); ?>
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
        CKEDITOR.replace('FaqContent');
    });
</script>