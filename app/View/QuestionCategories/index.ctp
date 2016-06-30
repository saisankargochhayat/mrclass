<div class="cmn_static_mc mc_faq_bg press_page question-bank-page">
    <div class="wrapper">
        <h1>Question Bank</h1>
        <div class="static_pg_cnt ">
            <?php if (is_array($questionCategories) && count($questionCategories) > 0): ?>
                <?php foreach ($questionCategories as $key => $data): ?>
                	<?php $QuestionCategoryName = $this->Format->seo_url($data['QuestionCategory']['name']); ?>
                    <div class="cont_listing fl">
                        <a title="<?php echo h($data['QuestionCategory']['name']); ?>" href="<?php echo $this->Html->url(array("controller" => "questions", "action" => "index", "id" => $data['QuestionCategory']['id'], "slag" => $QuestionCategoryName)); ?>">
                            <div class="prs_rcnt">									
                                <div class="relative cstm-text-center">
                                    <h2 class="ellipsis-view" style="max-width: 100%;"><?php echo h($data['QuestionCategory']['name']); ?></h2>
                                    <h4>Number of Sets <?php echo count($data['Question']);?></h4>
                                </div>
                            </div>
                            <?php /*?><div class="prs_lcnt">
                                <?php echo $this->Html->image('logo.png', array('alt' => 'logo'));?>
                            </div><?php */?>
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