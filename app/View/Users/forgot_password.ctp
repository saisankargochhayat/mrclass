<style type="text/css">
    .reg_frm_sec .input{margin-bottom: 14px;}
    .reg_frm_sec input, .reg_frm_sec select{margin-bottom: 0px;}
</style>
<div class="sup_bg fpw_frm loginpg">
    <div class="reg_mc">
        <?php echo $this->Form->create('User', array('action' => 'forgot_password', 'autocomplete' => 'off')); ?>
        <div class="reg_top_sec">
            <div class="reg_ttl">Enter your email address.</div>
        </div>
        <div class="reg_frm_sec">
            <div class="lft_bx_reg email_reg">
                <?php
                echo $this->Form->input('User.email', array('placeholder' => 'Enter Your Email Address'));
                ?>
            </div>
            <div class="submit_login"><?php echo $this->Form->end(array('label'=>'Submit', 'class' => 'cmn_btn_n pad_big')); ?></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#UserForgotPasswordForm").validate({
            rules:{
                "data[User][email]":{
                    required:true,
                    email:true
                }
            },
            messages:{
                "data[User][email]":{
                    required:"Please enter your email address",
                    email:"Please enter valid email address"
                }
            }
        });
		
        $("#UserEmail").focus(function() {
            $(".email_reg").addClass("make-o");
        });

        $("#UserEmail").focusout(function() {
            $(".email_reg").removeClass("make-o");
        });

    });
</script>