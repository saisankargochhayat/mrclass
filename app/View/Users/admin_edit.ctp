<?php echo $this->Html->script(array('admin_custom_script'), array('block' => 'demojs'));?>
<section class="content-header">
    <h1>
        <?php echo __('Update User Details: ').$this->data['User']['name']; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'index','admin'=>1));?>">Users</a></li>
        <li class="active">Edit User</li>
    </ol>
</section>
<?php //pr($this->data);exit;?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#userAdd" data-toggle="tab"><?php echo __('Edit User'); ?></a></li>
<!--                    <li><a href="#userAdd" data-toggle="tab">Timeline</a></li>-->
                    <!--<li><a href="#userAdd" data-toggle="tab">Settings</a></li>-->
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="userAdd">
                        <?php echo $this->Form->create('User', array('action' => 'edit', 'admin' => 1, 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
                        <?php echo $this->Form->input('id');?>
                        <div class="form-group">
                            <label for="UserName" class="col-sm-2 control-label"><?php echo __('Name'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('name',array('label'=>false,'div'=>false,'placeholder'=>'Name','class'=>'form-control alphaOnly'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserUsername" class="col-sm-2 control-label"><?php echo __('Username'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('username',array('label'=>false,'div'=>false,'placeholder'=>'Username','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserEmail" class="col-sm-2 control-label"><?php echo __('Email'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('email',array('label'=>false,'div'=>false,'placeholder'=>'Email','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserPhone" class="col-sm-2 control-label"><?php echo __('Phone'); ?></label>
                            <div class="col-sm-10">
                                <div class="phoneblock fl">
                                    <div class="phlbl fl">+91</div>
                                    <?php echo $this->Form->input('phone', array('label' => false, 'div' => false, 'placeholder' => 'Phone', 'class' => 'form-control numbersOnly', 'maxlength' => 10, 'error' => false)); ?>
                                </div>
                                <div class="error" id="UserPhoneErr"><?php  echo $this->Form->error('phone', null, array('class' => 'error-message'));?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserCity" class="col-sm-2 control-label"><?php echo __('City'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('city',array('options'=>$cities,'label'=>false,'div'=>false,'data-placeholder'=>'Select City','class'=>'form-control select2'));?>
                            </div>
                        </div>
                        <?php /*?><div class="form-group">
                            <label for="UserPincode" class="col-sm-2 control-label"><?php echo __('Pincode'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('pincode',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'pincode','class'=>'form-control numbersOnly','maxlength'=>6));?>
                            </div>
                        </div><?php */?>
                        <div class="form-group">
                            <label for="UserPassword" class="col-sm-2 control-label"><?php echo __('New Password'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('password', array('label' => false, 'div' => false, 'placeholder' => 'Password','class' => 'form-control usrpassword', 'value' => '**********', 'required' => false)); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserPasswordConfirm" class="col-sm-2 control-label"><?php echo __('Confirm Password'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('password_confirm', array('type' => 'password', 'label' => false, 'div' => false, 'placeholder' => 'Confirm Password', 'value' => '**********', 'class' => 'form-control usrpassword', 'required' => false)); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-success" onclick="admin_user_edit_valid();"><?php echo __('Submit'); ?></button>
                            </div>
                       <?php echo $this->Form->end(); ?>
                    </div>
                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script>
    $(document).ready(function(){
        admin_user_edit_valid('mode');
        $(".usrpassword").focus(function(){$(this).val()=='**********'?$(this).val(''):""}).blur(function(){$(this).val()==''?$(this).val('**********'):""});
        $(".select2").select2();
    });
</script>