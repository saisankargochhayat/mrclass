<div class="login-box">
    <div class="login-logo">
        <img src="<?php echo HTTP_ROOT ?>images/logo.png" alt="mrclass_logo"/>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?php echo __('Welcome Admin!') ?></p>
        <?php echo $this->Form->create('User', array('action' => 'login', 'admin' => 1, 'autocomplete' => 'off')); ?>
        <div class="form-group has-feedback">
            <?php echo $this->Form->input('User.username', array('placeholder' => 'Username', 'div' => false, 'label' => false, 'class' => 'form-control')); ?>
            <span class="fa fa-key form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?php echo $this->Form->input('User.password', array('type' => 'password', 'placeholder' => 'Password', 'div' => false, 'label' => false, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8 ">
                <?php echo $this->Html->link('Forgot password?', array('action' => 'admin_forgot_password', 'admin' => 1),array('style'=>'margin-top:8px; display: block;')); ?>
                <div class="checkbox icheck hide">
                    <label>
                        <input type="hidden" name="data[User][remember_me]" value="0" />
                        <input type="checkbox" name="data[User][remember_me]" value="1" /> Remember Me
                    </label>
                </div>
            </div><!-- /.col -->
            <div class="col-xs-4 fr">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
        </div>
        <?php echo $this->Form->end(); ?>
        
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
<script>
    $(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>