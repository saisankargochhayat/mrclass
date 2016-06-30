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

                        <?php echo $this->Form->create('Facility', array('action' => 'add_facility', 'admin' => 1)); ?>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><?php echo __('Add Facility'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="City_Name"><?php echo __('Enter Facility Name'); ?></label>
                                <?php echo $this->Form->input('name', array('class' => 'form-control', 'id' => 'facility_Name', 'div' => false, 'label' => false)); ?>
                            </div>
                            <div class="form-group">
                                <label for="City_Status"><?php echo __('Choose Facility Icon'); ?></label>
                                <select class="form-control select2" id="select" style="width: 100%;" name="data[Facility][image]">
                                    <option value=''></option>
                                </select>
                                <label id="select-error" class="error" for="select" style="display:none;"><font color="red" size="2px">Please select facility icon.</font></label>
                            </div>
                            <input type="hidden" name="user_icon_class_val" id='user_icon_class_val' value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancel'); ?></button>
                            <button type="button" class="btn btn-primary" onclick="validate_facility();"><?php echo __('Save'); ?></button>
                        </div>
                        <?php echo $this->Form->end(); ?>

                    </div><!-- /.tab-pane -->

                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col-->
    </div><!-- ./row -->
</section><!-- /.content -->