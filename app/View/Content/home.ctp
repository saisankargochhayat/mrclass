<link href="<?php echo HTTP_ROOT; ?>css/effect.css" rel="stylesheet" />
<?php echo $this->Html->script('modernizr.custom.86080', array('block' => 'bannerResources'));?>
<?php echo $this->Html->script('jquery.lazyload.min', array('block' => 'lazyLoad'));?>
<style type="text/css">
</style>
<div class="home_banner">
    <div class="scroll_btm_bnr"><a class="scroll_btm" href="javascript:void(0);">&nbsp;</a></div>
    <?php /*<div class="bnr_effect"><img src="<?php echo HTTP_ROOT; ?>images/girl.png" class="bounceInDown animated-one" alt="" /></div> */ ?>
    <div class="wrapper">
        <div class="ultimate">
            <h2>Discover the best classes, courses, tutors and hobbies in Bhubaneswar and Cuttack.</h2>
            <div class="blink-discount home-discount-tag">
                <img src="<?php echo HTTP_ROOT; ?>img/discount-logo.png"/>
            </div>
        </div>
    </div>
    <div class="banner_form">
        <?php echo $this->Form->create('Home', array('url' => array('controller' => 'content', 'action' => 'search'), 'autocomplete' => 'off','type'=>'get')); ?>
            <?php
            echo $this->Form->input('city', array('options' => $cities, 'empty' => 'Select your City', 'div' => false, 'label' => false,'value' => @$location['cityid']));
            echo $this->Form->input('locality', array('options' => array(), 'empty' => 'Select your Locality', 'div' => false, 'label' => false));
            echo $this->Form->input('category', array('options' => $category_list, 'empty' => 'Select your Category', 'div' => false, 'label' => false));
            ?>
            <a id="search-btn" class="src-button anchor">Search<img src="<?php echo HTTP_ROOT; ?>images/arrow.png" alt="Arrow" width="12" height="18"/></a>
        </form>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<?php if (is_array($middleads) && count($middleads) > 0) { ?>
    <div class="home_user_bus">
        <div class="wrapper home-page-ad-md-blk">
          <div class='marquee' id='middleadsmarquee'>
            <?php foreach ($middleads as $key => $addata) { ?>
                <div class="home-page-ad-md">
                    <a class="" href="<?php echo $addata['Advertisement']['url'] != "" ? $addata['Advertisement']['url'] : "javascript://"; ?>" target="_blank">
                        <img src="<?php echo $this->Format->ad_image($addata['Advertisement'], 350, 200, 0); ?>" alt="" style=""/>
                    </a>

                </div>
            <?php } ?>
          </div>
            <div class="cb"></div>
        </div>
    </div>
<?php } ?>
<?php /*<div class="home_user_bus">
    <div class="wrapper">
        <h2>How It Works</h2>
        <div class="us_bs_mc">
            <h4>Users</h4>
            <div class="us_bs_iner rtbdr btbdr fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/user1.png" alt="User1" width="66" height="50" /></div>
                <p>Looking for an Activity or Academic Class in your neighborhood? <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'sign_up')) ?>">Register</a> with us. It's FREE...</p>
            </div>
            <div class="us_bs_iner btbdr fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/user2.png" alt="User2" width="66" height="50" /></div>
                <p>Choose your City, Category, Locality & Search.</p>
            </div>
            <div class="us_bs_iner rtbdr fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/user3.png" alt="User3" width="66" height="50" /></div>
                <p>Explore the list of Classes tailored as per your requirement. Book Online or by Phone.</p>
            </div>
            <div class="us_bs_iner fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/user4.png" alt="User4" width="66" height="50" /></div>
                <p>Pay Online, by Cheque or at the place of joining. It's that EASY...</p>
            </div>
            <div class="cb20"></div>
        </div>
        <div class="us_bs_mc">
            <h4>Service Providers</h4>
            <div class="us_bs_iner rtbdr btbdr fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/busi1.png" alt="Business1" width="66" height="50" /></div>
                <p>Looking to expand your Business potential? <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'sign_up')) ?>">Register</a> with us.</p>
            </div>
            <div class="us_bs_iner btbdr fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/busi4.png" alt="Business4" width="66" height="50" /></div>
                <p>Let people discover you by Locality & Category.</p>
            </div>
            <div class="us_bs_iner rtbdr fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/busi3.png" alt="Business3" width="66" height="50" /></div>
                <p>Engage with the audience.</p>
            </div>
            <div class="us_bs_iner fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/busi2.png" alt="Business2" width="66" height="50" /></div>
                <p>Get additional reach/business leads.</p>
            </div>
            <div class="cb"></div>
        </div>
        <div class="cb"></div>
    </div>
</div>*/ ?>
<div class="home_catg">
    <div class="wrapper">
        <h2>Categories</h2>
        <div class="cat_hm_cnt">
            <?php foreach ($categories as $key => $val) { ?>
                <?php if ($key > 0 && $key % 5 == 0) { ?>
                    <div class="cb"></div>
                    </div>
                    <div class="cat_hm_cnt">
                <?php } ?>
                <div class="fl cat_section  <?php echo count($categories)%5 != 0 ? " blok".$key." ": " "; if ($key > 0 && $key % 5 == 4) echo "last"; ?>">
                    <a href="<?php echo HTTP_ROOT.'search/#cid='.h($val['Category']['id']) ?>">
                        <img data-original="<?php echo $this->Format->category_image($val) ?>" class="lazy" alt="<?php echo h($val['Category']['name']) ?>" width="228" height="228" />
                    </a>
                    <h4><?php echo h($val['Category']['name']); ?> </h4>
                    <div class="btn_book"><a href="#">Find Classes</a></div>
                </div>
            <?php } ?>
            <div class="cb"></div>
        </div>
        <div class="cmn_static_mc press_page home_page home_catg">
            <div class="wrapper">
                <h2>Media Mentions</h2>
                <div class="static_pg_cnt">
                    <?php if (is_array($press) && count($press) > 0): ?>
                      <div class='marquee' id='pressmarquee'>
                        <?php foreach ($press as $key => $data): ?>
                            <div class="cont_listing home-page-ad-md">
                                <a title="<?php echo h($data['Press']['name']); ?>" href="<?php echo $this->Format->validate_url($data['Press']['link']); ?>" target="_blank">
                                    <div class="prs_lcnt">
                                        <img src="<?php echo $this->Format->show_press_image($data['Press'], 120, 120, 0); ?>" alt=""/>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <h2>Coming soon...</h2>
                    <?php endif; ?>
                    <div class="cb"></div>
                </div>
            </div>
        </div>
        <div class="cat_frm">
            <div class="fl txt_lst">Looking for something else?</div>
            <div class="fl">
                <?php echo $this->Form->create(false,array('controller'=>'content','action' => 'write_to_admin'));?>
                <?php echo $this->Form->input('message',array('placeholder'=>'Write to us...','div'=>false,'label'=>false));?>
                <input type="button"  value="Submit" onclick="submitQuery();" id="send_admin"/>
                <?php echo $this->Form->end();?>
            </div>
            <div class="fl" id="success_text" style="margin-top:12px;font-size:20px;color:#00A550;">
            </div>
            <div class="cb"></div>
        </div>
        <?php if (is_array($ads) && count($ads) > 0) { ?>
            <?php foreach ($ads as $key => $addata) { ?>
                <div class="home-page-ad adblocks ">
                    <a class="" href="<?php echo $addata['Advertisement']['url'] != "" ? $addata['Advertisement']['url'] : "javascript://"; ?>" target="_blank">
                        <img src="<?php echo $this->Format->ad_image($addata['Advertisement'], 960, 260, 0); ?>" alt="" style=""/>
                    </a>
                    <div class="cb"></div>
                </div>
                <div class="cb"></div>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<script type="text/javascript" src="js/crawler.js">
/* Text and/or Image Crawler Script v1.53 (c)2009-2011 John Davenport Scheuer
   as first seen in http://www.dynamicdrive.com/forums/
   username: jscheuer1 - This Notice Must Remain for Legal Use
*/
</script>
<script type="text/javascript">
    $(document).ready(function () {
      marqueeInit({
        uniqueid: 'middleadsmarquee',
        style: {
        },
        inc: 5, //speed - pixel increment for each iteration of this marquee's movement
        mouse: 'pause', //mouseover behavior ('pause' 'cursor driven' or false)
        persist: true
      });
      marqueeInit({
        uniqueid: 'pressmarquee',
        style: {
        },
        inc: 5, //speed - pixel increment for each iteration of this marquee's movement
        mouse: 'pause', //mouseover behavior ('pause' 'cursor driven' or false)
        moveatleast : 2,
        persist: true
      });
        $("img.lazy").lazyload({effect : "fadeIn"});
        $('#HomeCity').change(function () {
            if ($(this).val() > 0) {
                update_locality($(this).val());
            } else {
                $("#HomeLocality").find('option:gt(0)').remove();
            }
        });
        $("#search-btn").click(function () {
            $url = $('#HomeHomeForm').attr('action')+"#";
            $url += ($('#HomeCity').val()>0)? "city="+$('#HomeCity').val()+"|" : "";
            $url += ($('#HomeLocality').val()>0)? "lc="+$('#HomeLocality').val()+"|" : "";
            $url += ($('#HomeCategory').val()>0)? "cid="+$('#HomeCategory').val()+"|" : "";
            window.location.href = $url;
        });
        $(".scroll_btm").click(function () {
            var p = $(".home_user_bus .wrapper");
            var headtotal = $("#header").height();
            var position = p.position();
            $("html, body").animate({scrollTop: (parseInt(position.top) - (headtotal))}, 1000);
        });
        $(".srart_discovering").click(function () {
            var position = $(".home_catg").position().top;
            var headtotal = $("#header").height();
            console.log(parseInt(position) - (headtotal))
            $("html, body").animate({scrollTop: (parseInt(position) - (headtotal))}, 1000);
        });
        if(typeof window.location.hash != 'undefined'){
            if(window.location.hash == '#discover'){
                window.location.hash='';
                setTimeout(function(){$(".srart_discovering").trigger('click');},500);
            }
        }
    });
    function update_locality(cityid) {
        var params = {ctid: cityid};
        update_category_business(cityid, '');
        $.ajax({
            url: HTTP_ROOT + "content/localities",
            data: params,
            method: 'post',
            success: function (response) {
                $("#HomeLocality").find('option:gt(0)').remove();
                $("#HomeLocality").append(response);
            }
        });
    }
    function update_category_business(ctid, lcid){
        var params = {
            ctid: ctid || '',
            lcid: lcid || ''
        };
        $.ajax({
            url: HTTP_ROOT + "content/update_category_business",
            data: params,
            method: 'post',
            success: function (response) {
                $("#HomeCategory").find('option:gt(0)').remove();
                $("#HomeCategory").append(response);
            }
        });
    }
    function submitQuery() {
        <?php if(!empty($user)) { ?>
                General.hideAlert();
                alert('Please sign in!',"error");
                return false;
        <?php } ?>
        if ($('#message').val() == '') {
            $('#message').css('borderColor', 'red').focus();
            return false;
        }else{
            $('#send_admin').val('Sending..');
            $.ajax({
                type: 'POST',
                url: HTTP_ROOT + "content/write_to_admin",
                data: $('#write_to_adminForm').serialize() + "&lat="+$('#localityLatitude').val()+"&long="+$('#localityLongitude').val(),
                 success: function (response) {
                    if(response == 'success'){
                        $('#send_admin').val('Sent');
                        $('#success_text').html('<i class="fa fa-check-circle" style="font-size:25px;"></i> Thanks for writing to us.').show();
                        setTimeout(function(){
                            $('#send_admin').val('Submit');
                            $('#success_text').hide('slow');
                            $('#message').val('');
                        },4000);
                    }
                }
            });
        }
    }
</script>
<script>
    $(document).ready(function () {
        //console.log($(window).width());
        var extra_height = 40;
        if ($(window).width() > 1100) {
            extra_height = 0;
            var height = $(window).height();
            var head = $(".header").height();
            var total_height = height - (head + 27);
            $(".home-page").css("background-size", "100% "+height+"px" );
            $(".home_banner").css("height", total_height);
        }else if ($(window).width() < 1100 && $(window).width() > 1000) {
            extra_height = 140;
        }else if ($(window).width() < 1000 && $(window).width() > 730) {
            extra_height = 60;
        }else if ($(window).width() < 730 && $(window).width() > 360) {
            extra_height = 100;
        }
        var banner_height = (($('.home_banner').height())+parseFloat($('.header').height())+parseFloat($('.header').css('padding-top').replace('px',''))+parseFloat($('.header').css('padding-bottom').replace('px',''))+parseFloat($('.home_banner').css('padding-bottom').replace('px',''))+parseFloat(extra_height));
        $(".cb-slideshow").css('height', banner_height+"px");
        $("#HomeLocality").change(function(){
            update_category_business($('#HomeCity').val(), $(this).val());
        });
        <?php if(!empty($location['cityid']) && $location['cityid'] >0){echo "update_locality(".$location['cityid'].")";}?>
    });
    $(window).resize(function () {
        if ($(window).width() > 1100) {
            var height = $(window).height();
            var head = $(".header").height();
            var total_height = height - (head + 27);
			$(".home-page").css("background-size", "100% "+height+"px" );
            $(".home_banner").css("height", total_height);
        }
    });
</script>
