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