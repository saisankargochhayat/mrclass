<div class="login-box">
    <div class="login-logo">
        <img src="<?php echo HTTP_ROOT?>images/logo.png" alt="mrclass_logo"/>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?php echo __('RESET YOUR PASSWORD') ?></p>
        <?php echo $this->Form->create('User', array('autocomplete'=>'off')); ?>
        <div class="form-group has-feedback">
            <?php echo $this->Form->input('User.password', array('type'=>'password','placeholder' => 'New Password','value'=>'','div'=>false,'label'=>false,'class'=>'form-control'));?>
            <span class="fa fa-key form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?php echo $this->Form->input('User.password_confirm', array('type'=>'password','placeholder' => 'Repeat New Password','div'=>false,'label'=>false,'class'=>'form-control'));?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-6">

            </div><!-- /.col -->
            <div class="col-xs-6">
                <button type="button" class="btn btn-primary btn-block btn-flat" onclick="AdminResetPasswordValid();">Update Password</button>
            </div><!-- /.col -->
        </div>
        <?php echo $this->Form->end(); ?>

    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->