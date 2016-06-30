<style type="text/css">
    .content-left {min-height:auto;}
    .attach-img-sub{width: 100%;}
    .phoneblock{background: #fff; border: 1px solid #ccc; width: 100%; position: relative;}
    .phoneblock .phlbl{display: block;padding: 8px 0 0 12px; font-size: 18px; color: #555; font:16px Arial}
    .phoneblock input.form-control{border: 0px none #ccc; width:80%; padding-left: 6px;}
</style>
<div class="content-full edit-your-business">
    <div class="content-left fl">
        <?php echo $this->element('business_left_tab');?>
    </div>
    <div class="content-right fl">
        <div class="heading">
            <span class="edit-business"></span> Edit your profile
            <div class="fr"><?php echo $this->Html->link('Change Password ', array('action' => 'change_password_user'), array('class' => 'cmn_btn_n')); ?></div>
            <div class="cb"></div>
        </div>
        <div class="bg-trns-white">
            <div class="sub-heading">Profile Details</div>
            <?php echo $this->Form->create('User',array('type'=>'file')); ?>
            <?php echo $this->Form->input('id');?>
            <div class="con-w-40 fl">
                <div class="form-group">
                    <label>Name </label>
                    <?php echo $this->Form->input('name',array('class'=>'form-control alphaOnly','placeholder'=>'Name','div'=>false,'label'=>false));?>
                </div>
                <?php /*?><div class="form-group">
                    <label>Username </label>
                    <?php echo $this->Form->input('username',array('class'=>'form-control','placeholder'=>'Username','div'=>false,'label'=>false));?>
                </div><?php */?>
                <div class="form-group">
                    <label>Email </label>
                    <?php echo $this->Form->input('email',array('class'=>'form-control','placeholder'=>'Email','div'=>false,'label'=>false));?>
                </div>
                <div class="form-group fl" style="width:100%;">
                    <label>Phone </label>
                    <div class="phoneblock fl">
                        <div class="phlbl fl">+91</div>
                        <?php echo $this->Form->input('phone',array('class'=>'form-control numbersOnly fl','placeholder'=>'Phone','div'=>false,'label'=>false,'maxlength'=>10));?>
                    </div>
                    <div class="error" id="UserPhoneErr"></div>
                </div>
                <div class="form-group">
                    <label>City </label>
                    <?php echo $this->Form->input('city',array('options' => $cities, 'class'=>'form-control select2','data-placeholder'=>'Select City','div'=>false,'label'=>false));?>
                </div>
                <?php /*?><div class="form-group">
                    <label>Pincode </label>
                    <?php echo $this->Form->input('pincode',array('type'=>'text','class'=>'form-control numbersOnly','placeholder'=>'Pincode','div'=>false,'label'=>false));?>
                </div><?php */?>
            </div>
            <div class="con-w-40 fr">
                <div class="form-group">
                    <label>Profile Picture </label>
                    <div class="pro_pix1" style="mrgin-top:16px;">
                        <img src="<?php echo $this->Format->user_photo($this->data['User'],200,200);?>" style="height:200px; width:200px;" id="pro_image"/>
                    </div>
                </div>
                <div class="form-group">
                    <label>Change Profile Picture</label>
                    <div class="upload-div-sub">
                        <span class="fl"><img src="<?php echo HTTP_ROOT; ?>images/form/attach_btn.png"></span>
                        <span class="up-text fl p_pic_name" style="font-style:normal;">Attach File</span>
                        <?php echo $this->Form->input('photo', array("type" => "file", "class" => "attach-img-sub", 'div' => false, 'label' => false)); ?>
                        <div class="cb"></div>
                    </div>
                </div>
            </div>
            <div class="cb20"></div>
            <div class="con-w-40 fl">
                <button class="cmn_btn_n pad_big" type="button" onclick="valid_edit_user_form('');">Submit</button>
            </div>
            <div class="cb20"></div>
        </div>
	<?php echo $this->Form->end(); ?>
    </div>
    <div class="cb20"></div>
</div>
<script type="text/javascript">
 $(document).ready(function(){
     valid_edit_user_form('mode');
     $('#pro_image').click(function(){
         $('#UserPhoto').trigger('click');
     });
     $('#UserPhoto').on('change',function(){
         $('.p_pic_name').addClass('ellipsis-view').css('width', '70%').text($(this).val().replace(/^.*\\/, ""));
     });
});
</script>
<script>
    $(".select2").select2();
</script>