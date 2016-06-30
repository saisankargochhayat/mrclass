<style>
    .home_user_bus .us_bs_mc .us_bs_iner{padding:10px;min-height: 215px;}
    .home_user_bus .us_bs_img { margin: 0 0 10px;}
    @media only screen and (max-width:1030px){
        .home_user_bus .us_bs_mc .us_bs_iner p {font-size: 13px;line-height:18px;}
    }
    @media only screen and (max-width:700px){
        .home_user_bus .us_bs_mc .us_bs_iner p {font-size: 12px;line-height:13px;}
    }
    @media only screen and (max-width:600px){
        .cmn_static_mc .wrapper{padding: 30px 15px 40px;}
    }
</style>
<p><strong><u><a href="http://www.mrclass.in" target="_blank">mrclass.in</a></u></strong> is an online listing platform providing exhaustive information about tuitions, coaching, hobbies and extra-curricular activities in your neighborhood; connecting tutors, teachers, lecturers, coaching institutions or extra-curricular activity centers&nbsp;with parents or students looking for information about any service of their choice.</p>
<p>In today&rsquo;s fast paced world where time is a luxury, we plan to ease peoples&rsquo; lives in our own small way.</p>
<div class="home_user_bus">
    <div class="wrapper" style="width:100%;">
        <h2>How It Works</h2>
        <div class="cb20"></div>
        <div class="us_bs_mc">
            <h4>USERS</h4>
            <div class="us_bs_iner rtbdr btbdr fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/user1.png" /></div>
                <p>Looking for an Activity or Academic Class in your neighborhood? <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'sign_up')) ?>">Register</a> with us. It's FREE...</p>
            </div>
            <div class="us_bs_iner btbdr fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/user2.png" /></div>
                <p>Choose your City, Category, Locality & Search.</p>
            </div>
            <div class="us_bs_iner rtbdr fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/user3.png" /></div>
                <p>Explore the list of Classes tailored as per your requirement. Book Online or by Phone.</p>
            </div>
            <div class="us_bs_iner fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/user4.png" /></div>
                <p>Pay Online, by Cheque or at the place of joining. It's that EASY...</p>
            </div>
            <div class="cb20"></div>
        </div>
        <div class="us_bs_mc">
            <h4>SERVICE PROVIDERS</h4>
            <div class="us_bs_iner rtbdr btbdr fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/busi1.png" /></div>
                <p>Looking to expand your Business potential? <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'sign_up')) ?>">Register</a> with us.</p>
            </div>
            <div class="us_bs_iner btbdr fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/busi4.png" /></div>
                <p>Let people discover you by Locality & Category.</p>
            </div>
            <div class="us_bs_iner rtbdr fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/busi3.png" /></div>
                <p>Engage with the audience.</p>
            </div>
            <div class="us_bs_iner fl">
                <div class="us_bs_img"><img src="<?php echo HTTP_ROOT; ?>images/busi2.png" /></div>
                <p>Get additional reach/business leads.</p>
            </div>
            <div class="cb"></div>
        </div>
        <div class="cb20"></div>
    
        <div class="cb20"></div>
        <div class="us_bs_mc"><h4>Service Providers' Packages</h4></div>
        <?php echo $this->element('subscription_plan_table'); ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.pro-chart').jScrollPane();
    });
</script>