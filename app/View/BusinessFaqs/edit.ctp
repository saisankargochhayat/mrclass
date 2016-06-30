<?php
echo $this->Html->script(array('ckeditor/ckeditor'), array('inline' => false));
?>
<div class="content-full business-timing-details">
    <div class="content-left fl">
        <?php echo $this->element('user_inner_left_navbar'); ?>
    </div>
    <div class="content-right fl">
        <div class="heading">
            <span class="edit-business"></span> Update Business Faqs
            <div class="fr"><?php echo $this->Html->link('Add new faq', array("controller" => "businessFaqs","action" => "add",$BusinessId), array('class' => 'cmn_btn_n')); ?></div>
            <div class="cb"></div>
        </div>
        <?php echo $this->element('front_edit_business_tabs', array('BusinessId' => $BusinessId)); ?>
        <div class="cb"></div>
		<?php echo $this->Form->create('BusinessFaq');?>
		<?php echo $this->Form->input('id');?>
        <div class="bg-trns-white">
			<div class="sub-heading">Edit Faq</div>
            <div class="con-w-40" style="width:100%;">
                <div class="form-group">
                    <label for="BusinessFaqTitle">Title*</label>
                    <?php echo $this->Form->input('title', array('class' => 'form-control', 'placeholder' => 'Title', 'div' => false, 'label' => false)); ?>
					<div class="error" id="title_error"></div>
				</div>
				<div class="form-group">
                    <label for="BusinessFaqContent">Content*</label>
                    <?php echo $this->Form->input('content', array('type' => 'textarea', 'class' => 'form-control height-plus', 'placeholder' => 'Write about your Education/Qualification...', 'div' => false, 'label' => false)); ?>
					<div class="error" id="content_error"></div>
				</div>
				<div class="cb20"></div>
				<div class="wd-full fl">
                    <button class="cmn_btn_n pad_big" type="button" onclick="validate_user_edit_business_faqs();">SUBMIT</button>
                </div>
				<?php echo $this->Form->end(); ?>
				<div class="cb20"></div>
            </div>
        </div>
    </div>
    <div class="cb20"></div>
</div>
<script>
    $(function() {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('BusinessFaqContent');
    });
</script>