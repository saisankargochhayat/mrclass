<style type="text/css">
    .reg_mc{padding-bottom:25px;}
    .w50{width:49%;}
    .reg_frm_sec select{padding-left:10px; }
    .feed_back.sup_bg .cmn_btn_n{margin-top: 0px;}
    .rdio_btn{height:35px; padding-top:0px;}
    .rdio_btn label{margin-bottom: 0px; margin-right:20px;}
    
    h6.captcha-info{    font-size: 16px; color: #5f5f5f; margin: 5px 0px 0px 0px; padding: 0px; font-weight: normal;}
    .reg_frm_sec input, .reg_frm_sec select{margin-bottom: 0px;}
    .reg_frm_sec .input{margin-bottom: 14px;}
</style>
<div class="sup_bg feed_back">
    <div class="reg_mc">
        <div class="reg_top_sec">
            <div class="reg_ttl">Looking for a Tutor?</div>
        </div>
        <?php echo $this->Form->create('Inquiry', array('autocomplete' => 'off')); ?>
        <div class="reg_frm_sec">
            <div class="fl lft_bx_reg name_reg">
                <?php echo $this->Form->input('name', array('placeholder' => 'Name', 'class' => 'alphaOnly', 'value' => @$user['name'])); ?>
            </div>
            <div class="fr lft_bx_reg search_reg">
                <?php echo $this->Form->input('city', array('type' => 'text', 'placeholder' => 'City')); ?>
            </div>
            <div class="cb"></div>
            <div class="fl rt_bx_reg ph_reg phonebox">
                <div class="input tel required fr" aria-required="true">
                        <label for="FeedbackPhone">Phone</label>
                        <span class="phlbl">+91</span>
                        <?php echo $this->Form->input('phone', array('class' => 'numbersOnly useisdinstart', 'placeholder' => 'Phone Number', 'maxlength' => 10, 'div'=>false,'label'=>false)); ?>
                </div>
                <div class="error" id="InquiryPhoneErr"></div>
                <div class="note" id="InquiryPhoneNote"><?php echo Configure::read('NOTE.MOBILE');?></div>
            </div>
            <div class="fr rt_bx_reg search_reg">
                <?php echo $this->Form->input('area', array('type' => 'text', 'placeholder' => 'Area')); ?>
            </div>
            <div class="cb"></div>
            <div class="fl rt_bx_reg email_reg">
                <?php echo $this->Form->input('email', array('placeholder' => 'Email Address')); ?>
            </div>
            <div class="fr rt_bx_reg search_reg">
                <div class="reg_frm_sec fr" style="margin-bottom:14px;width: 100%;">
                    <div class="w50 fl">
                        <?php echo $this->Form->input('min_age', array('options' => range(0,99), 'empty' => 'Min Age', 'div' => false, 'label' => false)); ?>
                    </div>
                    <div class="w50 fr">
                        <?php echo $this->Form->input('max_age', array('options' => range(0,99), 'empty' => 'Max Age', 'div' => false, 'label' => false)); ?>
                    </div>
                </div>
            </div>
            <div class="cb"></div>
        </div>  
        <div class="cb"></div>
        <div class="fback_captcha_txt">
             <div class="fl lft_bx_reg">
                 <div class="reg_frm_sec">
                    <?php echo $this->Form->input('category_id', array('options' => $category_list, 'empty' => 'Select Category', 'div' => false, 'label' => false)); ?>
                </div>
<!--                <div class="reg_frm_sec">
                    <input type="hidden" id="sub_category_id_tmp" value="<?php echo @$this->data['Inquiry']['sub_category_id'];?>"/>
                    <select name="data[Inquiry][sub_category_id]" id="sub_category_id">
                        <option value="">Select Sub-Category</option>
                    </select>
                </div>-->

                <h4>Preferred location of training/service?</h4>
                <div class="rdio_btn">
                    <?php
                    $options = array('own' => '&nbsp;Tutor\'s location', 'customer' => '&nbsp;Your Location');
                    echo $this->Form->radio('location', $options, array('legend' => false, 'value' => 'own'));
                    ?>
                </div>
                
                <div class="cb"></div>
                <h4>What are you looking for?</h4>
                <div class="rdio_btn">
                    <?php
                    $options = array('private' => '&nbsp;Private Tutor', 'group' => '&nbsp;Group Tutor');
                    echo $this->Form->radio('type', $options, array('legend' => false, 'value' => 'private'));
                    ?>
                </div>
                
                <div class="cb20"></div>
                
            </div>
            <div class="fr rt_bx_reg">
                <?php echo $this->Form->input('comment', array('type' => 'textarea', 'div' => false, 'label' => false, 'placeholder' => " Any other information",'style'=>'width:100%;')); ?>
                <div id="captcha_div">
                    <?php echo $this->Captcha->render(array('type' => 'image', 'height' => '36px', 'width' => '140px')); ?>
                    <div class="cb"></div>
                </div>

                <div id="captchaErr"></div>
                <div class="cb"></div>
                <h6 class="captcha-info">Please enter the verification code as it is shown</h6>
                <div class="cb20"></div>
                <div class="">
                    <input type="checkbox" id="accept_terms" name="accept_terms"/>
                    <span>Accept 
                        <a target="_blank" href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'static_page', 'terms_and_conditions')) ?>">Terms & conditions</a> and 
                        <a target="_blank" href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'static_page', 'privacy_policy')) ?>">Privacy Policy</a>
                    </span>
                    <div class="cb"></div>
                    <div id="accept_termsErr"></div>
                </div>
            </div>
           
            <div class="cb"></div>
        </div>
        <div class="cb"></div>
        <button type="button" class="cmn_btn_n pad_big fr" onclick="validate_inquiry();">Submit</button>
        <div class="cb"></div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        validate_inquiry('mode');
        //$("#InquiryCategoryId").change(function(){General.get_subcategories($(this).val(),'sub_category_id');});
        //if($("#InquiryCategoryId").val()>0){General.get_subcategories($("#InquiryCategoryId").val(),'sub_category_id',$("#sub_category_id_tmp").val());}
        $("#InquiryName").focus(function(){$(".name_reg").addClass("make-o");}).focusout(function(){$(".name_reg").removeClass("make-o");});
        $("#InquiryEmail").focus(function(){$(".email_reg").addClass("make-o");}).focusout(function(){$(".email_reg").removeClass("make-o");});
        $("#InquiryPhone").focus(function(){$(".ph_reg").addClass("make-o");}).focusout(function(){$(".ph_reg").removeClass("make-o");});
        $("#InquiryCity, #InquiryArea").focus(function(){$(this).closest(".search_reg").addClass("make-o");}).focusout(function(){$(this).closest(".search_reg").removeClass("make-o");});
    });
</script>