<style>
    .submit_login input.cmn_btn_n{padding: 10px 15px; width: 100%;}
</style>
<div class="sup_bg fpw_frm loginpg">
    <div class="reg_mc">
        <?php if ($mode == 'success') { ?>
            <p><?php echo __('Password changed successfully.'); ?></p>
        <?php } elseif ($mode == 'empty') { ?>
            <p><?php echo __('Link has expired. Please try below form to reset password again.'); ?></p>
            <div class="log_fpw"><?php echo $this->Html->link('Forgot Password', array('controller' => 'users', 'action' => 'forgot_password'), array('class' => 'button')); ?></div>
        <?php } else { ?>
            <?php
            echo $this->Html->script('jquery.validate.min.js');
            echo $this->Form->create('User', array('autocomplete' => 'off', 'onsubmit' => "return false", "name" => "UserResetPasswordForm"));
            ?>

            <div class="reg_top_sec">
                <div class="reg_ttl">Hi <?php h($userdetails['User']['name']);?>,</div>
                <p><?php echo __('Please use below form to reset your password.'); ?></p>
            </div>
            <div class="reg_frm_sec">
                <div class="lft_bx_reg pwd_reg">
                    <?php
                    echo $this->Form->input('User.new_password', array('placeholder' => 'New password', 'type' => 'password'));
                    echo $this->Form->input('User.re_enter_password', array('placeholder' => 'Re-enter new password', 'type' => 'password'));
                    ?>
                </div>
                <div class="submit_login">
                    <?php echo $this->Form->input('Save',array('type'=>'submit','class'=>' cmn_btn_n','div'=>false,'label'=>false)); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        <?php } ?>
    </div>
</div>
<?php if ($mode == 'reset') { ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#UserResetPasswordForm").validate({
                rules: {
                    'data[User][new_password]': {
                        required: true,
                        minlength: 6
                    },
                    'data[User][re_enter_password]': {
                        required: true,
                        equalTo: 'input[name="data[User][new_password]"'
                    }
                },
                messages: {
                    'data[User][new_password]': {
                        required: "Please enter new password",
                        minlength: "Please enter new password of atleast 6 characters"
                    },
                    'data[User][re_enter_password]': {
                        required: "Please re-enter new password",
                        equalTo: "Please enter same as new password"
                    }
                }
            });
            $("#UserResetPasswordForm").find('input[type=submit]').click(function() {
                if ($("#UserResetPasswordForm").valid()) {
                    document.UserResetPasswordForm.submit();
                }
            });
        });
    </script>
<?php } ?>