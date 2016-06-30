<style type="text/css">
    .reg_frm_sec .input{margin-bottom: 14px;}
    .reg_frm_sec input, .reg_frm_sec select{margin-bottom: 0px;}
    .select2-container{width:100% !important; max-width:388px; padding-left:53px;}
    .select2-container--default .select2-selection--single{padding: 8px 0 34px}
</style>
<script type="text/javascript">
      var googleUser = {};
      var startApp = function() {
        gapi.load('auth2', function(){
          // Retrieve the singleton for the GoogleAuth library and set up the client.
          auth2 = gapi.auth2.init({
            client_id: '<?php echo GOOGLE_CLIENT_ID;?>',
            cookiepolicy: 'single_host_origin',
            // Request scopes in addition to 'profile' and 'email'
            //scope: 'additional_scope'
          });
          attachSignin(document.getElementById('customBtn'));
        });
      };

      function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
          console.log('User signed out.');
        });
      }

      function attachSignin(element) {
        auth2.attachClickHandler(element, {},
            function(googleUser) {
                var profile_obj = {};
                // Useful data for your client-side scripts:
                var profile = googleUser.getBasicProfile();
                var id_token = googleUser.getAuthResponse().id_token;
                profile_obj['social_id'] = profile.getId();
                profile_obj['UserName'] = profile.getName();
                profile_obj['UserEmail'] = profile.getEmail();
                //profile_obj['picture'] = profile.getImageUrl();

                var url = "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'google_login_new')); ?>";
                $('.overlay_div').show();
                  $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {data: profile_obj},
                  })
                  .done(function(response) {
                    $('.overlay_div').hide();
                    if(response.exist && response.login){
                      alert('Sign up Successful. Please wait..');
                      window.location = "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'dashboard')); ?>";
                    }else{
                        $.each(profile_obj, function (index, value) {
                            (value) ? $('#'+index).val(value) : "";
                        });
                        $('#social_id').attr('name', 'data[User][google_id]');
                        alert("Success. Please provide rest of the details to complete the signup process.");
                        General.hideAlert();
                    }
                  });
            }, function(error) {
              alert(JSON.stringify(error, undefined, 2),'error');
            });
      }
</script>
<div class="sup_bg">
    <div class="reg_mc">
        <?php echo $this->Form->create('User', array('action' => 'sign_up', 'autocomplete' => 'off')); ?>
        <div class="reg_top_sec">
            <div class="reg_ttl"><?php echo __('Register Yourself'); ?></div>
        </div>
        <div class="reg_frm_sec">
            <div class="fl lft_bx_reg name_reg">
                <?php echo $this->Form->input('name', array('placeholder' => 'Name','class'=>'alphaOnly',)); ?>
            </div>
            <div class="fr rt_bx_reg ph_reg phonebox">
                <div class="input tel required fr" aria-required="true">
                    <label for="UserPhone">Phone</label>
                    <span class="phlbl">+91</span>
                    <?php echo $this->Form->input('phone', array('class' => 'numbersOnly useisdinstart', 'placeholder' => 'Phone Number', 'maxlength' => 10, 'div'=>false,'label'=>false, 'error' => false)); ?>
                </div>
                <div class="error" id="UserPhoneErr">
                    <?php  echo $this->Form->error('phone', null, array('class' => 'error-message'));?>
                </div>
                <div class="note" id="UserPhoneNote"><?php echo Configure::read('NOTE.MOBILE');?></div>
            </div>
            <div class="cb"></div>
            <div class="fl lft_bx_reg email_reg">
                <?php echo $this->Form->input('email', array('placeholder' => 'Email Address')); ?>
            </div>
            <div class="fr rt_bx_reg city_reg"><?php echo $this->Form->input('city', array('options' => $ucities, 'data-placeholder' => 'City', 'class'=>'select2')); ?></div>
            <div class="cb"></div>
            <div class="fl lft_bx_reg pwd_reg"><?php echo $this->Form->input('password', array('placeholder' => 'Password', 'value'=>'')); ?></div>
            <div class="fr rt_bx_reg pwd_reg"><?php echo $this->Form->input('password_confirm', array('placeholder' => 'Re-type password', 'value'=>'', 'type' => 'password', 'label' => array('class' => 'retype', 'text' => 'Confirm Password'))); ?></div>
            <div class="cb"></div>
        </div>  
        <div class="cb"></div>
        <div id="captcha_div">
            <?php echo $this->Captcha->render(array('type' => 'image', 'height' => '44px', 'width' => '320px','attr'=>array('name'=>'data[User][security_code]'))); ?>
        </div>
        <div class="cb"></div>
        <div class="error" id="UserReferSecurityCodeErr"><?php  echo $this->Form->error('security_code', null, array('class' => 'error-message', 'span' => false));?></div>
        <label id="UserSecurityCode-error1" class="error" for="UserSecurityCode" style="display:none;">Please enter the characters shown in the image.</label>

        <div class="submit_reg_cnt">
            <div class="fl">
                <input type="checkbox" id="accept_terms" name="accept_terms"/>
                <span>Accept 
                    <a target="_blank" href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'static_page', 'terms_and_conditions')) ?>">Terms & conditions</a> and 
                    <a target="_blank" href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'static_page', 'privacy_policy')) ?>">Privacy Policy</a>
                </span>
                <div class="cb"></div>
                <div class="error" id="terms_Cond_err" style="margin-top:3px;"></div>
            </div>
            <div class="fr"><div class="submit"><input type="button" class="cmn_btn_n pad_big" value="Submit" onclick="UserSignUpValid();"/></div></div>
            <div class="cb"></div>
        </div>
         <?php
        echo $this->Form->input('latitude', array('id' => 'latitude', 'type' => "hidden", 'value' => $this->Session->read('user_location.lat')));
        echo $this->Form->input('longitude', array('id' => 'longitude', 'type' => "hidden", 'value' => $this->Session->read('user_location.lon')));
        ?>
        <input type="hidden" name="data[User][platform_type]" id="social_id" value="">
        <?php echo $this->Form->end(); ?>
        <?php 
        #pr($this->Session->read('user_location'));
        echo $this->Form->input('usercity', array('id' => 'usercity', 'type' => "hidden", 'value' => $this->Session->read('user_location.city')));
        ?>
         <div class="cb20"></div>
        <hr/>
        <div class="cb20"></div>
        <div class="social-login sign_up">
            <a class="new-facebook-sign-in" href="javascript:login();"><img src="img/facebook-new.png"/><span class="social-txt">Sign Up</span></a>
            <!--<div class="g-signin2 new-google-sign-in" data-width="185" data-height="36" data-onsuccess="onSignIn" data-theme="dark"></div>-->
            <div id="customBtn" class="customGPlusSignIn">
              <span class="icon"></span>
              <span class="buttonText">Sign Up</span>
            </div>
            <div class="clearfix"></div>
          <script>startApp();</script>
         </div>
        <div class="cb20"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var profile_obj = {};
        if(!empty(getCookie("login_cookie"))){
            var cookie_obj = $.parseJSON(getCookie("login_cookie"));
            profile_obj['social_id'] = trim(cookie_obj['form/social_id']);
            profile_obj['UserName'] = trim(cookie_obj['form/name']);
            profile_obj['UserEmail'] = trim(cookie_obj['form/email']);
            $.each(profile_obj, function (index, value) {
                (value) ? $('#'+index).val(value) : "";
            });
            $('#social_id').attr('name', (cookie_obj['form/referer_platform'] == "google") ? 'data[User][google_id]' : 'data[User][facebook_id]');
            alert("Please provide rest of the details to complete the signup process.");
            General.hideAlert();
            removeCookie("login_cookie");
        }

        $(".select2").select2();
        $("#UserName").focus(function() {$(".name_reg").addClass("make-o");});
        $('#UserName').focus();
        $("#UserName").focusout(function() {$(".name_reg").removeClass("make-o");});
        $("#UserEmail").focus(function() {$(".email_reg").addClass("make-o");});
        $("#UserEmail").focusout(function() {$(".email_reg").removeClass("make-o");});
        $("#UserPassword").focus(function() {$(".lft_bx_reg.pwd_reg").addClass("make-o");});
        $("#UserPassword").focusout(function() {$(".lft_bx_reg.pwd_reg").removeClass("make-o");});
        $("#UserPasswordConfirm").focus(function() {$(".rt_bx_reg.pwd_reg").addClass("make-o");});
        $("#UserPasswordConfirm").focusout(function() {$(".rt_bx_reg.pwd_reg").removeClass("make-o");});
        $("#UserPhone").focus(function() {$(".ph_reg").addClass("make-o");});
        $("#UserPhone").focusout(function() {$(".ph_reg").removeClass("make-o");});
        $("#UserCity").focus(function() {$(".city_reg").addClass("make-o");});
        $("#UserCity").focusout(function() {$(".city_reg").removeClass("make-o");});
        $.validator.addMethod("noSpecialChars",
            function (value, element) {
                return /^[A-Za-z\d=#$%@_ -]+$/.test(value);
            }, "Sorry, no special characters allowed.");
       
            
        UserSignUpValid('mode');
    });
    function UserSignUpValid(mode) {
        var mode = mode || '';
        var validate = $('#UserSignUpForm').validate({
            rules: {
                'data[User][name]': {required: true, noSpecialChars: true},
                'data[User][phone]': {required: true, moblieNmuber: true,remote: {async: false,type: 'post',url: HTTP_ROOT + "users/phone_unique_edit",data: {},dataType: 'json'}},
                'data[User][email]': {required: true, strictEmail:true,remote: {async: false,type: 'post',url: HTTP_ROOT + "users/email_unique_edit",data: {},dataType: 'json'}},
                'data[User][city]': {required: true},
                'data[User][password]': {required: true,minlength: 6},
                'data[User][password_confirm]': {required: true, minlength: 6, equalTo: "#UserPassword"},
                'data[User][security_code]': {required: true},
                accept_terms: {required: true}
            },
            messages: {
                'data[User][name]': {required: "Please enter your name."},
                'data[User][phone]': {required: "Please enter your phone number.",remote:"This phone number is already exists. Please try another one."},
                'data[User][email]': {required: "Please enter your email address.",remote:"This email address is already exists. Please try another one."},//email: "Enter a valid email address."
                'data[User][city]': {required: "Please enter your city.",},
                'data[User][password]': {required: "Please enter your password.", minlength: "Password must be of six characters long."},
                'data[User][password_confirm]': {required: "Please re-enter password.", minlength: "Password must be of six characters long.", equalTo: "Password & confirm password do not match." },
                'data[User][security_code]': {required: "Please enter characters shown in the image."},
                accept_terms:{required:"Please agree to our terms & conditions."}
            },
            errorPlacement: function (error, element) {
                if (element.attr("id") == "accept_terms") {
                    error.appendTo($("#terms_Cond_err"));
                }else if (element.attr("id") == "UserPhone") {
                    error.appendTo($("#UserPhoneErr"));
                }else if (element.attr("id") == "UserReferSecurityCode") {
                    $("#UserReferSecurityCodeErr").html('');
                    error.appendTo($("#UserReferSecurityCodeErr"));
                } else {
                    error.insertAfter(element);
                }
            }
            
        });
        if (mode == '') {
            if (validate.form()) {
                if ($('input[name="accept_terms"]:checked').length > 0) {
                    $('#UserSignUpForm').submit();
                } else {
                    alert("You must agreed to the terms & conditions","error");
                    return false;
                }
            }else{
                $('input.error,textarea.error').eq(0).focus();
            }
        }
    }
    
   
</script>
