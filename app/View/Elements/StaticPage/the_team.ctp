<script type="text/javascript">
    $(document).ready(function() {
        $('#profile_2').css("display", "none");
        $('#profile_3').css("display", "none");
        $('.pro-img2').removeClass("active");
        $('.pro-img3').removeClass("active");
		$('.pro-img1').addClass("active");
    });

    function showProfile1() {
        $('#profile_1').css("display", "block");
        $('#profile_2').css("display", "none");
        $('#profile_3').css("display", "none");
        $('.pro-img2').removeClass("active");
        $('.pro-img3').removeClass("active");
        $('.pro-img1').addClass("active");
    }

    function showProfile2() {
        $('#profile_1').css("display", "none");
        $('#profile_2').css("display", "block");
        $('#profile_3').css("display", "none");
        $('.pro-img2').addClass("active");
        $('.pro-img3').removeClass("active");
        $('.pro-img1').removeClass("active");
    }

    function showProfile3() {
        $('#profile_1').css("display", "none");
        $('#profile_2').css("display", "none");
        $('#profile_3').css("display", "block");
        $('.pro-img2').removeClass("active");
        $('.pro-img3').addClass("active");
        $('.pro-img1').removeClass("active");
    }

</script>
<style>
	.in-text{font-size:22px !important;margin-bottom:0px !important;}

    .full-wd{
        /*left: 50%;*/
        /*margin-left:-227px;*/
        position: relative;
        width: 100%;
        text-align: center;
    }
    .team-members {
        cursor: pointer;
        margin:0 15px;
        position: relative;
        text-align: center;
        display: inline-block;
    }
    .team-members .arrow-up {position: absolute;top: auto;bottom: -21px;left: 35%; display: none;}
    .team-members.active .arrow-up{display: block;}

    .team-members img {
        background: #ccc none repeat scroll 0 0;
        border: 1px solid #ccc;
        border-radius: 140px;
        height: 115px;
        width: 115px;
    }

    .pro-img1.active img, .pro-img2.active img, .pro-img3.active img, .team-members img:hover {
        border: 1px solid #E9510E;
        box-shadow: 0 0 10px #E9510E;
    }

    .who_we_r h4 {
        color: #666;
        font-size: 13px;
        margin: 5px 0;
        text-align: center;
        white-space: nowrap;
    }

    .white {
        border-bottom: 20px solid #E9510E;
        display: block;
        z-index: 9;
    }
    .arrow-up {
        border-left: 20px solid transparent;
        border-right: 20px solid transparent;
        top: -22px;
        height: 0;
        left: 50%;
        position: absolute;
        width: 0;
        /*margin-left:-177px;*/
    }

    .profile {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        background: #fff none repeat scroll 0 0;
        border-color: #E9510E;
        border-image: none;
        border-style: solid;
        border-width: 2px 1px 1px;
        box-shadow: 0 0 5px #ccc;
        display: block;
        padding: 15px;
        position:relative;
    }
    .cmn_static_mc .wrapper h1{text-align: center;}
    
    /*.ar-m-125{margin-left:125px;}
    .a-m-32{margin-left:-32px;}*/
    #profile_1 .arrow-up{left:25%;}
    #profile_3 .arrow-up{left:75%;}
	
	@media only screen and (max-width:1030px){
		/*.full-wd{width: 69%;}*/
	}
	
	@media only screen and (max-width:850px){
		/*.full-wd{width: 77%;}*/
	}
	
	@media only screen and (max-width:700px){
		/*.full-wd{width: 88%;}*/
	}
	
	@media only screen and (max-width:630px){
		/*.full-wd{left:0;margin:0 auto !important;}*/
		.team-members{margin: 0 5px;}
		.cmn_static_mc .static_pg_cnt{font-size: 11px !important; line-height: 14px;}
		.cmn_static_mc .static_pg_cnt p{ font-size: 13px; line-height: 20px; text-align:left !important}
		.in-text{font-size:18px !important}
                /*.arrow-up{margin-left: -148px;}*/
                /*.a-m-32{margin-left: -23px !important;}
                .ar-m-125{margin-left:102px !important;}*/
	}
	
	@media only screen and (max-width:500px){
		/*.full-wd{width:96%}*/
	}
	
	@media only screen and (max-width:414px){
		.cmn_static_mc .wrapper{padding: 30px 3px 40px;}
		.team-members img{width:85px;height:85px;}
		.full-wd{width:100%;left:0;margin-left:0}
		
	}
</style>

<div class="white-trp-bg our-team">

    <div class="cb20"></div>
    <div class="full-wd">
        <div class="fl1 team-members pro-img1" onclick="showProfile1();">
            <img class="attachment-thumbnail wp-post-image" width="137" height="134" alt="Sujeet Kumar" src="<?php echo HTTP_ROOT; ?>images/form/sujeet.jpg" />
            <h4>Sujeet Kumar</h4>
            <div class="arrow-up white"></div>
        </div>

        <div class="fl1 team-members pro-img2" onclick="showProfile2();">
            <img class="attachment-thumbnail wp-post-image" width="137" height="134" alt="Ankeet A Panda" src="<?php echo HTTP_ROOT; ?>images/form/ankeet.jpg" />
            <h4>Ankeet A Panda</h4>
            <div class="arrow-up white"></div>
        </div>

        <div class="fl1 team-members pro-img3" onclick="showProfile3();">
            <img class="attachment-thumbnail wp-post-image" width="137" height="134" alt="Bhabagrahi Das" src="<?php echo HTTP_ROOT; ?>images/form/bdas.jpg" />
            <h4>Bhabagrahi Das</h4>
            <div class="arrow-up white"></div>
        </div>
        <div class="cb20"></div>
    </div>

    <div id="profile_1" class="profile">
        
        <p class="in-text"><strong>Sujeet Kumar</strong></p>
        <p><em>Chief Mentor</em></p>
        <p style="text-align: justify;">Sujeet Kumar is a lawyer (of the Orissa High Court), entrepreneur, investor and an avid start-up enthusiast. He founded a boutique consulting firm, LexMantra (<a href="http://www.lexmantra.net" target="_blank">www.lexmantra.net</a>); a full-service business and legal consulting firm, providing a range of legal &amp; business advisory solutions for businesses of all sizes, particularly for start-ups. Sujeet also has a sustained interest in public affairs regularly interacting with the regulators, and has been involved in policy formulation in the state of Odisha. He was a Member, Drafting Committee of the State Youth Policy and is the past chair of CII-Young Indians Odisha chapter.</p>
        <p style="text-align: justify;">Sujeet currently advises &amp; mentors a number of start-up entrepreneurs, small and growing businesses, social business enterprises, non-profit organizations, impact investors and donor organizations- both Indian and foreign - on a range of business strategy, legal, regulatory and corporate governance issues in India. He is recognized for his expertise in start-up laws, technology matters, inbound &amp; outbound investments, and arbitration.</p>
        <p style="text-align: justify;">Sujeet is also the Founder &amp; Chairman of Kalinga Kusum (<a href="http://www.kalingakusum.org" target="_blank">www.kalingakusum.org</a>), a social enterprise that addresses challenges tied to education, entrepreneurship and legal empowerment in rural communities in India. Though he has stepped out of an active role at Kalinga Kusum, he continues to provide the organisation with leadership and direction. He is an ardent advocate of building bridges between law, development and the social sector. Sujeet loves the outdoors, and exploring different places and learning about their culture and history.</p>
        <p class="con_social">
            <a href="https://www.facebook.com/mrsujeetkumar" class="fb" target="_blank"></a>
            <a href="https://in.linkedin.com/pub/sujeet-kumar/1/2b6/365" class="lin" target="_blank"></a>
        </p>
        <p>&nbsp;</p>
    </div>
    <div class="cb"></div>
    <div id="profile_2" class="profile">
        
		
        <p class="in-text"><strong>Ankeet Ansooman Panda</strong></p>

        <p><em>Head (Product &amp; Strategy)</em></p>

        <p style="text-align: justify;">With interests in Strategy, Product &amp; Business Development, Social Media, Operations and Finance, Ankeet really brings a lot to the table apart from his fresh-n-bold ideas &amp; approach. With a habit of giving equal importance to the smallest of things, Ankeet heads our Product &amp; Strategy team and has a knack of getting the work done at any cost.</p>

        <p style="text-align: justify;">Ankeet also advises a number of start-up entrepreneurs on a range of business strategies. After office hours&hellip; travelling, swimming, gaming &amp; aviculture occupy most of his time. He has an MBA degree from Faculty of Management, Sri Sri University and a B.Tech degree from Institute of Technical Education &amp; Research (ITER), Bhubaneswar. &nbsp;</p>
        <p class="con_social">
            <a href="https://www.facebook.com/ankeetpanda" class="fb" target="_blank"></a>
            <a href="https://in.linkedin.com/pub/ankeet-panda/59/53b/a80" class="lin" target="_blank"></a>
            <a href="https://twitter.com/ankeetpanda" class="tweet" target="_blank"></a>
        </p>
        <p>&nbsp;</p>
    </div>
    <div class="cb"></div>
    <div id="profile_3" class="profile">
        <p class="in-text"><strong>Bhabagrahi Das</strong></p>
        <p><em>Head (Marketing)</em></p>
        <p style="text-align: justify;">Bhabagrahi heads the Marketing team at mrclass.in. He is an alumnus of the Faculty of Management Studies, Sri Sri University, Odisha and loves travelling, meeting new people.&nbsp;Customer satisfaction is always his first priority. Outside of work he is very casual and spends his free time with friends or at the movies.</p>
        <p>They say &ldquo;All good things come in small packages&rdquo;. He is one perfect example of this.</p>
        <p class="con_social">
            <a href="https://www.facebook.com/bhabagrahi.das.7" class="fb" target="_blank"></a>
            <a href="https://in.linkedin.com/pub/bhabagrahi-das/64/967/268" class="lin" target="_blank"></a>
            <a href="https://twitter.com/Bhabagrahi89" class="tweet" target="_blank"></a>
        </p>
        <p>&nbsp;</p>
    </div>
</div>