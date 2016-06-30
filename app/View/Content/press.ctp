<div class="cmn_static_mc mc_faq_bg press_page">
    <div class="wrapper">       
        <h1>Press</h1>
        <div class="static_pg_cnt ">
            <?php if (is_array($press) && count($press) > 0): ?>
                <?php foreach ($press as $key => $data): ?>                   
                    <div class="cont_listing fl">
                        <a title="<?php echo h($data['Press']['name']); ?>" href="<?php echo $this->Format->validate_url($data['Press']['link']); ?>" target="_blank">
                            <div class="prs_rcnt">									
                                <div class="relative">
                                    <h2 class="ellipsis-view" style="max-width: 100%;"><?php echo h($data['Press']['name']); ?></h2>
                                    <h4><?php echo h($data['Press']['source']); ?> <?php echo strtotime($data['Press']['published_date'])>0 ? " on " : "" ;?> <?php echo $this->Format->dateFormat($data['Press']['published_date']); ?></h4>
                                </div>
                                <?php /* <div class="list_view_lft_cnt">
                                  <?php echo h($data['Press']['description']); ?>
                                  </div> */ ?>
                            </div>
                            <div class="prs_lcnt">
                                <img src="<?php echo $this->Format->show_press_image($data['Press'], 300, 300, 0); ?>" alt=""/>
                            </div>
                        </a>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <h2>Coming soon...</h2>
            <?php endif; ?>
            <div class="cb"></div>
        </div>
    </div>
</div>