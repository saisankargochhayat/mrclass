<style type="text/css">
    .cmn_static_mc.mc_faq_bg .static_pg_cnt h4{margin-bottom:0px;}
    .cmn_static_mc.mc_faq_bg .static_pg_cnt h4 i{margin-top:10px;}
    .static_pg_cnt .panel-body{padding-top:0px;}
    .cmn_static_mc.mc_faq_bg .static_pg_cnt p, .cmn_static_mc.mc_faq_bg .static_pg_cnt p:last-child {margin: 0 0 5px 0;}
</style>
<script src="<?php echo HTTP_ROOT; ?>js/accordian.js"></script>
<div class="cmn_static_mc mc_faq_bg">
    <div class="wrapper">
        <h1>FAQs</h1>
        <div class="static_pg_cnt">
            <div>
                <?php if (is_array($faqlist) && count($faqlist) > 0) { ?>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <h4 class="panel-title anchor" data-toggle="collapse" data-parent="#accordion"
                              href="#collapsefirst" aria-expanded="false" aria-controls="collapsefirst">
                              <a class="accordion-toggle">What is MrClass and how it works ?</a>
                              <i class="indicator ion ion-plus  pull-right"></i>
                          </h4>
                      </div>
                      <div id="collapsefirst" class="panel-collapse collapse">
                          <div class="panel-body">
                            <div class="home_user_bus" style="margin-bottom:0px;">
                                <div class="wrapper">
                                    <h2 style="margin:5px 0px 0px 0px;">How It Works</h2>
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
                            </div>
                          </div>
                      </div>
                  </div>
                    <?php foreach ($faqlist as $key => $val) { ?>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title anchor" data-toggle="collapse" data-parent="#accordion"
                                    href="#collapse<?php echo h($key); ?>" aria-expanded="false" aria-controls="collapse<?php echo $key;?>">
                                    <a class="accordion-toggle"><?php echo h($val['Faq']['title']) ?></a>
                                    <i class="indicator ion ion-plus  pull-right"></i>
                                </h4>
                            </div>
                            <div id="collapse<?php echo h($key); ?>" class="panel-collapse collapse">
                                <div class="panel-body"><?php echo trim($val['Faq']['content']) ?></div>
                                <?php if($val['Faq']['id'] == '2'){ ?>
                                    <?php echo $this->element('subscription_plan_table'); ?>
                                	<div class="clear">&nbsp;</div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                <?php } else { ?>
                    <h2>Coming soon...</h2>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    /*$('.panel-heading').click(function(){
        $(this).closest('.panel-default').find('.collapse').is(":visible")?
        $(this).find('.indicator').removeClass('ion-minus').addClass('ion-plus'):
        $(this).find('.indicator').removeClass('ion-plus').addClass('ion-minus');
    });*/
    function toggleChevron(e) {
        $(e.target).closest('.panel').find('.indicator').toggleClass('ion-minus ion-plus');
        //$(e.target).prev('.panel-heading').find("i.indicator").toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
    }
    $('#accordion').on('hidden.bs.collapse', toggleChevron);
    $('#accordion').on('shown.bs.collapse', toggleChevron);
</script>
