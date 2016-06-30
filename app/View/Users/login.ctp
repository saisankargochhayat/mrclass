<style type="text/css">
    .reg_frm_sec .input{margin-bottom: 14px;}
    .reg_frm_sec input, .reg_frm_sec select{margin-bottom: 0px;}
</style>
<div class="sup_bg log_sup loginpg">
    <div class="reg_mc">
        <?php echo $this->Form->create('User', array('autocomplete' => 'off')); ?>

        <div class="reg_top_sec">
            <div class="reg_ttl"><?php echo __('Sign In'); ?></div>
            <!--<h5><?php echo __('Already registered?'); ?></h5>-->
        </div>
        <div class="reg_frm_sec" style="position:relative;">
            <div class="fl lft_bx_reg">
                <h6><?php echo __('If you have an account with us, please sign in.'); ?></h6>
                <div class="name_reg phonebox">
                    <div class="input tel required fr" aria-required="true" style="background:#fff;">
                        <label for="UserPhone">Phone</label>
                        <span class="phlbl">+91</span>
                        <?php echo $this->Form->input('User.username', array('class' => 'login-inputs useisdinstart', 'placeholder' => 'Enter your Mobile or Email', 'tabindex' => '1', 'error' => false)); ?>
                    </div>
                    <div class="error" id="UserUsernameErr">
                        <?php  echo $this->Form->error('User.username', null, array('class' => 'error-message'));?>
                    </div>
                    <div class="cb"></div>
                </div>
<!--                <div class="name_reg">
                    <?php #echo $this->Form->input('User.username', array('placeholder' => 'Enter your Mobile or Email', 'class' => 'login-inputs', 'tabindex' => '1')); ?>
                </div>-->
                <div class="pwd_reg">
                    <?php echo $this->Form->input('User.password', array('placeholder' => 'Password', 'class' => 'login-inputs', 'tabindex' => '2')); ?>
                </div>
                <div class="submit_login">
                    <div class="submit">
                        <input class="cmn_btn_n pad_big" type="button" value="Submit" onclick="UserSignInValid();" tabindex="3"/>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
                <div class="cb20"></div>
                <hr/>
                <div class="cb20"></div>
                <div class="social-login">
                    <a class="new-facebook-sign-in" href="javascript:login();"><img src="img/facebook-new.png"/><span class="social-txt">Sign In</span></a>
                    <div class="g-signin2 new-google-sign-in" data-width="185" data-height="36" data-onsuccess="onSignIn" data-theme="dark"></div>
                 </div>
                <div class="cb20"></div>
                <div class="log_fpw"><?php echo $this->Html->link('Forgot Password?', array('controller' => 'users', 'action' => 'forgot_password'), array('class' => 'button')); ?></div>
            </div>
            <div class="fr rt_bx_reg information-rgt-dv-new">

                <h3 style="margin-bottom:26px;"><?php echo __('New Here?'); ?></h3>
                <h4><?php echo __('Registration is FREE and Easy!'); ?></h4>

                <div class="sup_link">Haven't registered yet? <?php echo $this->Html->link('Create an Account', array('controller' => 'users', 'action' => 'sign_up'), array('style' => '')); ?></div>
                <div class="extra-info">
                    <ul>
                        <li>
                            Manage Your Bookings
                            <p>(also your reviews, queries etc.)</p>
                        </li>
                        <li>
                            Make Better Decisions
                            <p>(choose from various options)</p>
                        </li>
                        <li class="dot_line">
                            Help Others
                            <p>(Refer to a friend)</p>
                        </li>
                        <li>
                            Add Your Businesses
                            <p>(if any; create your business profile)</p>
                        </li>

                    </ul>

                </div>
            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#UserLoginForm').find('input.login-inputs').keydown(function(event) {
            if (event.which == 13 || event.keyCode == 13) {
                UserSignInValid();
            }
        });

        $("#UserUsername").focus(function() {$(".name_reg").addClass("make-o");});
        $('#UserUsername').focus();
        $("#UserUsername").focusout(function() {$(".name_reg").removeClass("make-o");});
        $("#UserPassword").focus(function() {$(".pwd_reg").addClass("make-o");});
        $("#UserPassword").focusout(function() {$(".pwd_reg").removeClass("make-o");});
        
        UserSignInValid('mode');
    });
    function UserSignInValid(mode) {
        var mode = mode || '';
        var validate = $('#UserLoginForm').validate({
            rules: {
                'data[User][username]': {required: true,moblieAndEmail: true},
                'data[User][password]': {required: true,}
            },
            messages: {
                'data[User][username]': {required: "Please enter your mobile or email.",moblieAndEmail:function(){
                        return isNaN($("#UserUsername").val())?"Please enter valid email address.":"Please enter valid mobile number.";
                }
                },
                'data[User][password]': {required: "Please enter your password."}
            },
            errorPlacement: function (error, element) {
                if (element.attr("id") == "UserUsername") {
                    error.appendTo($("#UserUsernameErr"));
                } else {
                    error.insertAfter(element);
                }
            }
            
        });
        if(mode == ''){
            if (validate.form()) {
                $('#UserLoginForm').submit();
            }
        }
    }
</script>