<style type="text/css">
    .content-left {min-height:auto;}
</style>
<div class="content-full edit-your-business">
    <div class="content-left fl">
        <?php echo $this->element('business_left_tab');?>
    </div>
    <div class="content-right fl">
        <div class="heading">
            <span class="edit-business"></span> Change Your Password 
            <div class="fr"><?php echo $this->Html->link('Edit Profile', array('action' => 'edit'), array('class' => 'cmn_btn_n')); ?></div>
			<div class="cb"></div>
        </div>
		<div class="bg-trns-white">
        <div class="sub-heading">Enter Details</div>
        <?php echo $this->Form->create('User',array('action'=>'change_password_user')); ?>
        <div class="con-w-40 fl">
            <div class="form-group">
                <label>Current Password </label>
                <?php echo $this->Form->input('current_password',array('type'=>'password','class'=>'form-control','placeholder'=>'Current Password','div'=>false,'label'=>false));?>
            </div>
            <div class="form-group">
                <label>New Password </label>
                <?php echo $this->Form->input('password1',array('type'=>'password','class'=>'form-control','placeholder'=>'New Password','div'=>false,'label'=>false));?>
            </div>
            <div class="form-group">
                <label>Repeat Password </label>
                <?php echo $this->Form->input('password2',array('type'=>'password','class'=>'form-control','placeholder'=>'Repeat Password','div'=>false,'label'=>false));?>
            </div>
        </div>
        <div class="cb20"></div>
        <div class="con-w-40 fl">
            <button class="cmn_btn_n pad_big" type="button" onclick="valid_change_user_password_form();">Submit</button>
        </div>
         <div class="cb20"></div>
		</div>
	<?php echo $this->Form->end(); ?>
    </div>
    <div class="cb20"></div>
</div>