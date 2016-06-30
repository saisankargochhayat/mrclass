<?php
echo $this->Html->script(array('ckeditor/ckeditor'), array('inline' => false));
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Careers'); ?><small></small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> <?php echo __('Home'); ?></a></li>
        <li><?php echo $this->Html->link(__('Careers'), array('action' => 'index')); ?></li>
        <li class="active"><?php echo __('Add Career'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#CareerAdd" data-toggle="tab">New Career</a></li>
                    <!--<li><a href="#userAdd" data-toggle="tab">Settings</a></li>-->
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="CareerAdd">
                        <?php echo $this->Form->create('Career', array('action'=>'add','admin'=>1,'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
                        <div class="form-group">
                            <label for="CareerTitle" class="col-sm-1 control-label"><?php echo __('Title'); ?></label>
                            <div class="col-sm-11">
                                <?php echo $this->Form->input('title', array('label' => false, 'div' => false, 'placeholder' => __('Title'), 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <?php /*?><div class="form-group">
                            <label for="StaticPageCode" class="col-sm-2 control-label"><?php echo __('Page Code'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('code', array('label' => false, 'div' => false, 'placeholder' => __('Page Code'), 'class' => 'form-control')); ?>
                            </div>
                        </div><?php */?>
                        <?php /*?><div class="form-group">
                            <label for="StaticPageUrl" class="col-sm-2 control-label"><?php echo __('Page URL'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('url', array('label' => false, 'div' => false, 'placeholder' => __('Page URL'), 'class' => 'form-control')); ?>
                            </div>
                        </div><?php */?>

                        <div class="form-group">
                            <label for="CareerContent" class="col-sm-1 control-label"><?php echo __('Description'); ?></label>
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
                            <!--<div class="col-sm-offset-2 col-sm-10">
                                <a class="btn btn-danger" href="<?php //echo $this->Html->url(array('controller' => 'users', 'action' => 'index', 'admin' => 1));    ?>"><?php echo __('Cancel'); ?></a>
                            </div>-->
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
        CKEDITOR.replace('CareerContent');
    });
</script>


