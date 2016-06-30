<style type="text/css">
@media only screen and (max-width:650px){
	.sticky_header, #header{height:auto}
	.bg-tr-wht{padding-top:60px;}
	.contact-us-bg{background-size:cover}
	#map {overflow: hidden !important;width: 555px !important;}
}

@media only screen and (max-width:600px){
	#map {overflow: hidden !important;width: 500px !important;}
}

@media only screen and (max-width:560px){
	#map {overflow: hidden !important;width: 440px !important;}
}

@media only screen and (max-width:400px){
	#map {overflow: hidden !important;width: 275px !important;}
}

.contact-us-bg .form-group .lft_bg_con:before{left:1px;}
.contact-us-bg .form-control.useisdinstart{height:34px; border:0px none;}
.phonebox .phlbl{color:#555; top:6px;}
</style>
<div class="contact-us-bg">
    <div class="wrapper">
        <div class="bg-tr-wht">
            <div class="wd-50-c fl">
                <div class="contact-title">
                    <span class="contact-us-ico"></span> Contact Us
                </div>
                <div class="cb20"></div>
                <?php echo $this->Form->create('Feedback', array('url' => array('controller' => 'content', 'action' => 'contact_us'))); ?>
                <div class="form-group">
                    <div class="lft_bg_con name_con">
                        <?php echo $this->Form->input('name', array('class' => 'form-control alphaOnly', 'placeholder' => 'Enter Name', 'div' => false, 'label' => false,'value'=>@$user['name'])); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="lft_bg_con name_mail  phonebox contactusfrmemailphone" data-p="ph_reg" data-e="name_mail">
                        <div class="input tel  fl" aria-required="true" style="width:100%;">
                            <span class="phlbl">+91</span>
                            <?php echo $this->Form->input('email', array('class' => 'form-control useisdinstart hasBothEmailPhone', 'placeholder' => 'Enter Email / Phone Number', 'div' => false, 'label' => false, 'type' => 'text')); ?>
                        </div>
                    </div>
                    <div class="cb"></div>
                    <div class="error" id="FeedbackEmailErr"></div>
                </div>
                <div class="form-group">
                    <div class="lft_bg_con name_subj">
                        <?php echo $this->Form->input('subject', array('class' => 'form-control', 'placeholder' => 'Enter Subject', 'div' => false, 'label' => false)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('comment', array('type' => 'textarea', 'class' => 'form-control height-plus', 'placeholder' => 'Write Your Message Here', 'div' => false, 'label' => false)); ?>
                </div>
                <div class="cb"></div>
                <div class="wd-full fl">
                    <button class="cmn_btn_n pad_big" type="button" onclick="validate_contact_us();">SUBMIT</button>
                </div>
                <?php echo $this->Form->end(); ?>
                <div class="cb20"></div>
            </div>
            <div class="wd-50-c m-left-c fl">
                <div class="form-group">
                    <div class="contact-title fl">
                        <span class="con-address"></span> Address
                        <div class="address-text"><?php echo Configure::read('COMPANY.CONTACT_US_ADDRESS');?></div>
                    </div>
                    <div class="contact-title fr">
                        <span class="reach-at"></span> Reach Us at
                        <div class="address-text reach_at">
                            <span><img src="<?php echo HTTP_ROOT; ?>images/phone-list.png" alt="Mobile" title="Mobile" /></span>&nbsp; <?php echo Configure::read('COMPANY.CONTACT_US_PHONE');?><br/>
                            <span><img src="<?php echo HTTP_ROOT; ?>images/phone-list.png" alt="Mobile" title="Mobile" /></span>&nbsp; <?php echo Configure::read('COMPANY.CONTACT_US_MOBILE');?><br/>
                            <span><img src="<?php echo HTTP_ROOT; ?>images/mail-list.png" alt="e-Mail" title="e-Mail" /></span>&nbsp; <?php echo Configure::read('COMPANY.CONTACT_US_EMAIL');?><br/>
                        </div>
                    </div>
                    <div class="cb"></div>
                </div>
                <?php /*<div class="form-group map-address" id="map" style="height: 208px; width: 401px;"></div> */ ?>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d935.2390425911782!2d85.82152682918448!3d20.343429256602818!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a1909119c20e335%3A0xfb2184ec62a909b0!2sMrClass!5e0!3m2!1sen!2sin!4v1450074122423" width="100%" height="208" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <div class="cb"></div>
        </div>
    </div>
    <div class="cb20"></div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        validate_contact_us('mode');
        $("#FeedbackName").focus(function(){$(".name_con").addClass("make-o");}).focusout(function(){$(".name_con").removeClass("make-o");});
        $("#FeedbackEmail").focus(function(){$(".name_mail,.ph_reg").addClass("make-o");}).focusout(function(){$(".name_mail,.ph_reg").removeClass("make-o");});
        $("#FeedbackSubject").focus(function(){$(".name_subj").addClass("make-o");}).focusout(function() {$(".name_subj").removeClass("make-o");});
    });
	
</script>
<?php /*
<script type="text/javascript">
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: {lat: <?php echo Configure::read('COMPANY.CONTACT_LATITUDE');?>, lng: <?php echo Configure::read('COMPANY.CONTACT_LONGITUDE');?>}
        });
        var geocoder = new google.maps.Geocoder();
        //geocodeAddress(geocoder, map,'<?php echo Configure::read('COMPANY.ADDRESS');?>');
        var marker = new google.maps.Marker({
            map:map,
            position: {lat: <?php echo Configure::read('COMPANY.CONTACT_LATITUDE');?>, lng: <?php echo Configure::read('COMPANY.CONTACT_LONGITUDE');?>}
         });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_KEY; ?>&libraries=places&callback=initMap" async defer></script>
*/ ?>