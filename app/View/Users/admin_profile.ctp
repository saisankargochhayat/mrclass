<?php
echo $this->Html->script(array('demo', 'admin_custom_script'), array('block' => 'demojs'));
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Admin Profile</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Admin profile</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" 
                         src="<?php echo $this->Format->user_photo($this->Session->read('Auth.User'),100,122,1); ?>" alt="User profile picture">
                    <h3 class="profile-username text-center"><?php echo ucfirst($details['User']['name']); ?></h3>
                    <p class="text-muted text-center hide"><?php echo $this->Format->userType($details['User']['type']); ?></p>
                 
                </div><!-- /.box-body -->
            </div><!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">About</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <!--<strong><i class="fa fa-book margin-r-5"></i>  Education</strong>
                  <p class="text-muted">
                    B.S. in Computer Science from the University of Tennessee at Knoxville
                  </p>
                  <hr>-->

                    <?php /* <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                    <p class="text-muted"><?php echo $details['City']['name'] . ', ' . $details['User']['pincode']; ?></p>
                    <hr> */ ?>

                    <strong><i class="ion ion-log-in margin-r-5" style="font-weight:bold;"></i> Last login</strong>
                    <?php if (strtotime($details['User']['last_login']) > 0) { ?>
                        <p class="text-muted"><?php echo $this->Time->format($this->Time->convert(strtotime($details['User']['last_login']), 'Asia/Kolkata'), '%B %e, %Y %H:%M %p'); ?></p>
                    <?php } ?>
                   
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#pro_det" data-toggle="tab"><?php echo __('Profile Details'); ?></a></li>
                    <li><a href="#ch_pass" data-toggle="tab"><?php echo __('Change Password'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="pro_det">
                        <?php echo $this->Form->create('User', array('action' => 'save_profile', 'admin' => 1, 'class' => 'form-horizontal', 'autocomplete' => 'off', 'type' => 'file')); ?>
                        <div class="form-group">
                            <label for="UserName" class="col-sm-4 control-label"><?php echo __('Name'); ?></label>
                            <div class="col-sm-8">
                                <?php echo $this->Form->input('name', array('label' => false, 'div' => false, 'placeholder' => 'Name', 'value' => $details['User']['name'], 'class' => 'form-control', 'required' => false)); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserEmail" class="col-sm-4 control-label"><?php echo __('Email'); ?></label>
                            <div class="col-sm-8">
                                <?php echo $this->Form->input('email', array('label' => false, 'div' => false, 'placeholder' => 'Email', 'value' => $details['User']['email'], 'class' => 'form-control', 'required' => false)); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserUsername" class="col-sm-4 control-label"><?php echo __('Username'); ?></label>
                            <div class="col-sm-8">
                                <?php echo $this->Form->input('username', array('label' => false, 'div' => false, 'placeholder' => 'Email', 'value' => $details['User']['username'], 'class' => 'form-control', 'required' => false)); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserPhone" class="col-sm-4 control-label"><?php echo __('Phone Number'); ?></label>
                            <div class="col-sm-8">
                                <div class="phoneblock fl">
                                    <div class="phlbl fl">+91</div>
                                    <?php echo $this->Form->input('phone', array('label' => false, 'div' => false, 'placeholder' => 'Phone', 'value' => $details['User']['phone'], 'class' => 'form-control', 'required' => false,'maxlength' => 10, 'error' => false)); ?>
                                </div>
                                <div class="error" id="UserPhoneErr"><?php  echo $this->Form->error('phone', null, array('class' => 'error-message'));?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserCity" class="col-sm-4 control-label"><?php echo __('City'); ?></label>
                            <div class="col-sm-8">
                                <?php echo $this->Form->input('city', array('options' => $cities, 'label' => false, 'div' => false, 'data-placeholder' => 'Select City', 'value' => $details['User']['city'], 'class' => 'form-control select2', 'required' => false)); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserPhoto" class="col-sm-4 control-label"><?php echo __('Profile Picture'); ?></label>
                            <div class="col-sm-8">
                                <?php #echo $this->Form->input('pincode', array('label' => false, 'div' => false, 'placeholder' => 'Pincode', 'type' => 'text', 'value' => $details['User']['pincode'], 'class' => 'form-control', 'required' => false)); ?>
                                <?php echo $this->Form->input('photo', array("type" => "file", "class" => "attach-img-sub", 'div' => false, 'label' => false)); ?>
                            </div>
                        </div>
                        <?php echo $this->Form->input('id', array('value' => $details['User']['id'])); ?>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="button" class="btn btn-success" onclick="validate_admin_profile();">Submit</button>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div><!-- /.tab-pane -->
                    <div class="tab-pane" id="ch_pass">
                        <?php echo $this->Form->create('User', array('action' => 'change_password', 'admin' => 1, 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
                        <div class="form-group">
                            <label for="UserCurrentPassword" class="col-sm-4 control-label"><?php echo __('Current Password'); ?></label>
                            <div class="col-sm-8">
                                <?php echo $this->Form->input('current_password', array('label' => false, 'div' => false, 'placeholder' => 'Password', 'class' => 'form-control', 'type' => 'password', 'required' => false)); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserPassword1" class="col-sm-4 control-label"><?php echo __('New Password'); ?></label>
                            <div class="col-sm-8">
                                <?php echo $this->Form->input('password1', array('label' => false, 'div' => false, 'placeholder' => 'Password', 'class' => 'form-control', 'type' => 'password', 'required' => false)); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserPassword2" class="col-sm-4 control-label"><?php echo __('Retype New Password'); ?></label>
                            <div class="col-sm-8">
                                <?php echo $this->Form->input('password2', array('label' => false, 'div' => false, 'placeholder' => 'Password', 'class' => 'form-control', 'type' => 'password', 'required' => false)); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="button" class="btn btn-success" onclick="validate_password();">Submit</button>
                            </div>
                        </div>
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script>
    $(document).ready(function() {
        validate_admin_profile('mode');
        if ($('#flash').is(':visible')) {
            var $el = $('#flash');
            setTimeout(function() {
                $el.addClass('animated fadeOutUp');
            }, 3000);
        }
        $('.select2').select2();
    });
</script>