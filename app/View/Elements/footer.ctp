<div class="js-alert-box-success none">
    <?php echo $this->element("/Flash/success", array('key'=>'','message'=>''));?>
</div>
<div class="js-alert-box-error none">
    <?php echo $this->element("/Flash/error", array('key'=>'','message'=>''));?>
</div>
<div class="footer">
 <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/<?php echo TAWKTO_KEY;?>/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
    <div class="wrapper">
        <ul>
            <li <?php if($parms['controller'] == 'content' && $parms['action'] == 'static_page' && $parms['extra'] == 'terms_and_conditions'){ echo 'class="active"';}?>>
                <a href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'static_page', 'terms_and_conditions')) ?>">Terms & Conditions</a></li>
            <li <?php if($parms['controller'] == 'content' && $parms['action'] == 'static_page' && $parms['extra'] == 'privacy_policy'){ echo 'class="active"';}?>>
                <a href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'static_page', 'privacy_policy')) ?>">Privacy Policy</a></li>
            <li <?php if($parms['controller'] == 'content' && $parms['action'] == 'static_page' && $parms['extra'] == 'the_team'){ echo 'class="active"';}?>>
                <a href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'static_page', 'the_team')) ?>">Our Team</a>
            </li>
            <?php /*?><li <?php if($parms['controller'] == 'content' && $parms['action'] == 'static_page' && $parms['extra'] == 'the_platform'){ echo 'class="active"';}?>>
                <a href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'static_page', 'the_platform')) ?>">The Platform</a>
            </li><?php */?>
            <li <?php if($parms['controller'] == 'content' && $parms['action'] == 'static_page' && $parms['extra'] == 'about_us'){ echo 'class="active"';}?>>
                <a href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'static_page', 'about_us')) ?>">About Us</a>
            </li>
            <li <?php if($parms['controller'] == 'content' && $parms['action'] == 'careers'){ echo 'class="active"';}?>>
                <a href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'careers')) ?>">Career</a></li>
            <li <?php if($parms['controller'] == 'content' && $parms['action'] == 'press'){ echo 'class="active"';}?>>
                <a href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'press')) ?>">Press</a></li>
           <li <?php if($parms['controller'] == 'content' && $parms['action'] == 'feedback'){ echo 'class="active"';}?>>
                <a href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'feedback')) ?>">Feedback</a></li>
            <li <?php if($parms['controller'] == 'content' && $parms['action'] == 'contact_us'){ echo 'class="active"';}?>>
                <a href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'contact_us')) ?>">Contact Us</a></li>
            <li <?php if($parms['controller'] == 'content' && $parms['action'] == 'looking_for_tutor'){ echo 'class="active"';}?>>
                <a href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'looking_for_tutor')) ?>">Looking for a Tutor</a></li>
        </ul>
        <?php /*<div class="copy_right booking_anchr cmn_btn_grp">
            <a data-href="<?php echo $this->Html->url('/businesses/group_booking/')?>" onclick="event.preventDefault();" class="anchor ajax cmn_btn_n chng_sub">Group Booking</a>
        </div> */ ?>
        <div class="copy_right">&copy; <?php echo date('Y');?> <?php echo Configure::read('COMPANY.NAME'); ?>. All rights reserved.</div>
        <div class="dev-by">Developed & Maintained by <a href="http://www.andolasoft.com/" target="_blank">Andolasoft</a></div>
    </div>
</div>
<?php if(empty($error)){ ?>
    <div class="ask_us_rt" style="z-index:99999; display: none;">
        <h2 id="toggleclick">Ask Us Anything...</h2>
        <div class="cnt_ask_sec" style="height:240px;">
            <?php /*?><div class="start_cnt">
                <div class="logo_team"><img src="<?php echo HTTP_ROOT; ?>images/chat-logo.png" alt="" /><span>Team</span></div>
                Lorem ipsum dolor sit amet consec tetur adipisicing elit
            </div><?php */?>
            <div class="start_cnt footer_askus" style="padding:10px;">
                <input type="text" placeholder="Name" class="texting" id="askus_username"/>
                <div class="cb" style="height:10px"></div>
                <input type="text" placeholder="Email/Phone" class="texting" id="askus_phone"/>
                <div class="cb" style="height:10px"></div>
                <textarea type="text" placeholder="Message" class="texting" id="askus_message" style="resize:none;height: 80px;"></textarea>
                <div class="cb" style="height:10px"></div>

                <div id="captcha_div" class="math_captcha_box">
                    <?php echo $this->Captcha->render(array('type' => 'math', 'height' => '35px', 'width' => '35px',"model" => 'ask', 'attr'=>array('class'=>'texting math_captcha_text'))); ?>
                </div>
                <?php /*?><div class="cat_frm">
                    <input id="send_admin" type="button" value="Submit" style="left:0;">
                </div><?php */?>
            </div>
        </div>
        <div class="ask_inp_bx">
            <div class="cat_frm" style="margin: 0 auto;">
                <input id="askus_send_admin" type="button" value="Submit" style="left:0; padding: 8px 10px;"/>
            </div>
            <input type="text" placeholder="Start a conversation..." style="visibility:hidden; display:none;"/>
        </div>
    </div>
<?php } ?>
<a id="backToTop" class="scroll_top anchor"></a>
<script type="text/javascript">
        jQuery(document).ready(function(){
            if($('#toggleclick').length>0){
                $header = parseFloat($('#toggleclick').height())+parseFloat($('#toggleclick').css('padding-top').replace('px',''))+parseFloat($('#toggleclick').css('padding-bottom').replace('px',''))
                $top = parseFloat($('.ask_us_rt').height())-$header;
                $(".ask_us_rt").css("bottom",'-'+$top+'px');
                $("#toggleclick").click(function(){ 
                    $header = parseFloat($('#toggleclick').height())+parseFloat($('#toggleclick').css('padding-top').replace('px',''))+parseFloat($('#toggleclick').css('padding-bottom').replace('px',''))
                    $top = parseFloat($('.ask_us_rt').height())-$header;
                    $(".ask_us_rt").css("bottom") === '0px' ? $(".ask_us_rt").css("bottom",'-'+$top+'px'):$(".ask_us_rt").css("bottom",'0px');
                    //$(".ask_us_rt").css("bottom") === '0px' ? $(".ask_us_rt").css("bottom",'-324px'):$(".ask_us_rt").css("bottom",'0px');
                });	
            }
            $("#open_popup").click(function(){
                    $(".popup_profile").slideToggle(500);
            });

            $(window).scroll(function(){
                    if ($(this).scrollTop() > 50) {
                            $('.scroll_top').fadeIn('slow');
                    } else {
                            $('.scroll_top').fadeOut('slow');
                    }
            });
            $('.scroll_top').click(function(){
                    $("html, body").animate({ scrollTop: 0 }, 1000);
                    return false;
            });
            if((!$device)){
                $(window).resize(function(){resizeBoxHeight();}).scroll(function(){resizeBoxHeight();});
                resizeBoxHeight('load');
            }
	});
        
        
        function resizeBoxHeight(mode){
            var mode = mode || '';
            //$footer = parseFloat($('.footer').height())+parseFloat($('.footer').css('padding-top').replace('px',''))+parseFloat($('.footer').css('padding-bottom').replace('px',''))
            $footer = isScrolledIntoView($('.footer')) ? parseFloat($('.footer').css('height')) : 0;
            $top = parseFloat($('#header').css('height'));
            //alert(typeof $(document).touch() == 'undefined')
            //console.log($(window).height()+' &** '+($footer+' ??  '+$top))//,
            $height = ($(window).height()-($footer+$top))+'px';
            if(mode=='load'){
                $('.add-utube-video-link').css('min-height',$height);
            }
            $('.content-left').css('min-height',$height);
            $('.booking_det,.cmn_static_mc,.log_sup, .contact-us-bg,.fpw_frm').css('min-height',$height);
        }
        function isScrolledIntoView(elem)
        {
            var $elem = $(elem);
            var $window = $(window);

            var docViewTop = $window.scrollTop();
            var docViewBottom = docViewTop + $window.height();

            var elemTop = $elem.offset().top;
            var elemBottom = elemTop + $elem.height();
            //console.log(elemBottom-docViewBottom)
            return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
        }
        
        <?php if (!isset($params['admin']) && $this->Session->read('Auth.User.id') > 0 && $this->params['action'] != 'home') {?>
        <?php } elseif ($this->params['action'] == 'search') {?>
            $("#header").addClass("sticky_header",100);
        <?php }else{ ?>
            $(window).scroll(function() {    
                var scroll = $(window).scrollTop();
                if (scroll >= 1) {
                        $("#header").addClass("sticky_header",300);
                }
                else{
                        $("#header").removeClass("sticky_header",1000);
                }
            });
        <?php } ?>
</script>


