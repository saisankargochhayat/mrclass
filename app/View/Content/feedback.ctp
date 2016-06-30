<style type="text/css">
    .reg_frm_sec .input{margin-bottom: 14px;}
    .reg_frm_sec input, .reg_frm_sec select{margin-bottom: 0px;}
</style>
<div class="sup_bg feed_back">
    <div class="reg_mc">
        <div class="reg_top_sec">
            <div class="reg_ttl">Feedback</div>
        </div>
        <?php echo $this->Form->create('Feedback', array('url' => array('controller' => 'content', 'action' => 'feedback'))); ?>
        <div class="reg_frm_sec">
            <div class="fl lft_bx_reg name_reg">
                <?php echo $this->Form->input('name', array('placeholder' => 'Name', 'class' => 'alphaOnly','value'=>@$user['name'])); ?>
            </div>
            <div class="fr lft_bx_reg email_reg"><?php echo $this->Form->input('email', array('placeholder' => 'Email Address')); ?></div>
            <div class="cb"></div>
            <div class="fl rt_bx_reg ph_reg phonebox">
                <div class="input tel required fr" aria-required="true">
                    <label for="FeedbackPhone">Phone</label>
                        <span class="phlbl">+91</span>
                        <?php echo $this->Form->input('phone', array('class' => 'numbersOnly useisdinstart', 'placeholder' => 'Phone Number', 'maxlength' => 10, 'div'=>false,'label'=>false)); ?>
                </div>
                <div class="error" id="FeedbackPhoneErr"></div>
                <div class="note" id="FeedbackPhoneNote"><?php echo Configure::read('NOTE.MOBILE');?></div>
            </div>
            <div class="fr rt_bx_reg search_reg"><?php echo $this->Form->input('find_us', array('type' => 'text', 'placeholder' => 'How did you find us?')); ?></div>
            <div class="cb"></div>
        </div>  
        <div class="fback_captcha_txt">
            <div class="fl lft_bx_reg">
                <h4>Feel free to share your suggestion!</h4>
                <?php echo $this->Form->input('comment', array('type' => 'textarea', 'div' => false, 'label' => false, 'placeholder' => "Write your suggestion")); ?>
            </div>
            <div class="fr rt_bx_reg">
                <h4>How would you rate us?</h4>
                <div class="rdio_btn">
                    <?php
                    $options = array('Excellent' => '&nbsp;Excellent', 'Very Good' => '&nbsp;Very Good', 'Good' => '&nbsp;Good', 'Average' => '&nbsp;Average');
                    $attributes = array('legend' => false);
                    echo $this->Form->radio('feedback_type', $options, $attributes);
                    ?>
                </div>
                <div id="rating_error"></div>
                <div id="captcha_div">
                    <?php echo $this->Captcha->render(array('type' => 'image', 'height' => '36px', 'width' => '140px')); ?>
                </div>
                <div class="cb"></div>
                <h6>Please enter the verification code as it is shown</h6>
            </div>
            <div class="cb"></div>
        </div>
        <div class="cb"></div>
        <button type="button" class="cmn_btn_n pad_big" onclick="validate_feedback_user();">Submit</button>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        validate_feedback_user('mode');
        $("#FeedbackName").focus(function(){$(".name_reg").addClass("make-o");}).focusout(function(){$(".name_reg").removeClass("make-o");});
        $("#FeedbackEmail").focus(function(){$(".email_reg").addClass("make-o");}).focusout(function(){$(".email_reg").removeClass("make-o");});
        $("#FeedbackPhone").focus(function(){$(".ph_reg").addClass("make-o");}).focusout(function(){$(".ph_reg").removeClass("make-o");});
        $("#FeedbackFindUs").focus(function(){$(".search_reg").addClass("make-o");}).focusout(function(){$(".search_reg").removeClass("make-o");});
   });
</script>