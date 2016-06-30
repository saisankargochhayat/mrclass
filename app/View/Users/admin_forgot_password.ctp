<div class="login-box">
    <div class="login-logo">
        <img src="<?php echo HTTP_ROOT?>images/logo.png" alt="mrclass_logo"/>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?php echo __('Please Enter Your Email Address') ?></p>
        <?php echo $this->Form->create('User', array('action' => 'forgot_password','admin'=>1,'autocomplete'=>'off')); ?>
        <div class="form-group has-feedback">
            <?php echo $this->Form->input('User.email', array('placeholder' => 'Email','div'=>false,'label'=>false,'class'=>'form-control'));?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <label id="UserEmail-error" class="error" for="UserEmail" style="display: none;">Please enter your email address.</label>
        </div>
        <div class="row">
            <div class="col-xs-6">
            </div><!-- /.col -->
            <div class="col-xs-6">
                <button type="button" class="btn btn-primary btn-block btn-flat" onclick="AdminForgotPasswordValid();">Send Reset Link</button>
            </div><!-- /.col -->
        </div>
        <?php echo $this->Form->end(); ?>
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->