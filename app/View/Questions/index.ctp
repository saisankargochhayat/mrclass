<style type="text/css">
    .cmn_static_mc.mc_faq_bg .static_pg_cnt h4{margin-bottom:0px;padding:12px 0px 12px 5px;}
    .static_pg_cnt .panel-body{padding-top:0px;}
    .cmn_static_mc.mc_faq_bg .static_pg_cnt p, .cmn_static_mc.mc_faq_bg .static_pg_cnt p:last-child {margin: 0 0 5px 0;}
	.view-download{float:right}
    .accodion-downld-icon,.panel.panel-default .view-icon{display:inline-block;font-size:22px;}
	.panel.panel-default .view-icon{margin-right:10px}
    .file-ext i{font-size:26px;margin-right:10px;vertical-align:middle;}
    .quesion-bank-back.back_btn a:hover {
    background: #f7f7f7;
    border: 1px solid #bbb;
}
.quesion-bank-back.back_btn a {
    background: #f3f3f3;
    border: 1px solid #dadada;
    color: #666666;
    font-size: 15px;
    text-decoration: none;
    text-decoration: none;
    line-height: inherit;
    padding: 2px 15px;
}
h1.question-bank-head{display:inline-block;}
#accordion a.question-anchor-block{text-decoration:none;display:block;width:49.4%;float:left;}
#accordion a.question-anchor-block:hover .view-icon,#accordion a.xyz:hover .accodion-downld-icon{color:#e9510e;}
#accordion .panel.panel-default .panel-heading{background:#f5f5f5}
#accordion .panel.panel-default .panel-heading:hover{background:#fff}
#accordion a.question-anchor-block:nth-child(2n+1){margin:0 10px 0 0}
#accordion a.question-anchor-block:nth-child(2n+2){margin:0}
.panel.panel-default .view-icon{display: inline-block;float:right;}

</style>
<div class="cmn_static_mc mc_faq_bg">
    <div class="wrapper">
        <h1 class="question-bank-head">Question Bank : <?php echo $category_name;?></h1>
        <div class="back_btn quesion-bank-back fr">
            <a class="anchor" onclick="window.history.back();"> <span style="font-size:20px;font-weight:bold">&larr;</span> Go Back</a>
        </div>
        <div class="static_pg_cnt">		
            <div>
                <?php if (is_array($questions) && count($questions) > 0) { ?>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <?php foreach ($questions as $key => $val) { ?>
	                    <?php if(!empty($user)){?>
	                    <a href="<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'question_bank_download','cid'=>$val['QuestionCategory']['id'],'id'=>$val['Question']['id'],'cat'=> $this->Format->sanitizeFilename($val['QuestionCategory']['name']),'file'=> $val['Question']['filename']));?>" class="question-anchor-block" target="_blank">
                        <div class="panel panel-default">
                            <div class="panel-heading">
	                            <h4 class="anchor accodh4-head">
	                                <span class="file-ext"><i class="<?php echo $this->Format->get_font_ext_class($val['Question']['extension']); ?>"></i></span>
	                                    <span class="file-name-txt ellipsis-view"><?php echo $this->Text->truncate($val['Question']['title'],50,array('ellipsis' => '...','exact' => true,'html'=>false)); ?></span>
	                                        <span class="view-icon accodion-downld-icon"><i class="fa fa-eye"></i></span>
	                                </h4>
                            </div>
                        </div>
                        </a>
	                        <?php } else {?>
	                        <a href="javascript:void(0);" onclick="show_alert();" title="View this question bank" class="question-anchor-block">
	                        <div class="panel panel-default">
	                            <div class="panel-heading">
		                            <h4 class="anchor accodh4-head">
		                                <span class="file-ext"><i class="<?php echo $this->Format->get_font_ext_class($val['Question']['extension']); ?>"></i></span>
		                                    <span class="file-name-txt ellipsis-view"><?php echo $this->Text->truncate($val['Question']['title'],50,array('ellipsis' => '...','exact' => true,'html'=>false)); ?></span>
			                                        <span class="view-icon accodion-downld-icon"><i class="fa fa-eye"></i></span>
		                                </h4>
	                            </div>
                        	</div>
                        </a>
	                    <?php }?>
                    <?php } ?>
					<div class="cb"></div>
                    </div>
                <?php } else { ?>
                    <h2>Coming soon...</h2>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php $login_url = '<a href="'.HTTP_ROOT.'login?from=question-papers/'.$category_id.'/'.$category_name.'" style="color:black;">Sign In</a> to view this question paper.'; ?>
<script type="text/javascript">
var login = '<?php echo $login_url;?>';
function show_alert(){
	alert(login,'error');
}
</script>