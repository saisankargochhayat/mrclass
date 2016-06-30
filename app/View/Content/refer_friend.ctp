<style type="text/css">
    .creload{ float: left; height: 45px; padding: 10px 20px; position: relative; font-size:25px; top: 1px; text-align:center; color:black; }
    #captcha_img{ float: left;}
</style>
<div class="booking_det">
    <div class="wrapper">
        <div class="content-left fl">
            <?php echo $this->element('business_left_tab') ?>
        </div>
        <div class="fr upcom_book_cnt">
            <div class="bg-trns-white">
                <div class="up_mc_top1">
                    <h2><span class="edit-business"></span> Refer A Friend</h2>
                    <div class="cb"></div>
                </div>

                <?php echo $this->Form->create(false, array('action' => 'refer_friend')); ?>
                <div class="con-w-40 fl">
                    <div class="form-group">
                        <div class="name_con">
                            <?php echo $this->Form->input('name', array('class' => 'form-control alphaOnly', 'placeholder' => 'Your Name', 'value' => $user['name'], 'div' => false, 'label' => false, 'tabindex' => 1)); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="name_mail">
                            <?php echo $this->Form->input('email', array('type' => 'textarea', 'class' => 'form-control height-plus', 'placeholder' => 'Type friends email addresses here, separated by comma.', 'div' => false, 'label' => false, 'tabindex' => 2)); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="captcha_div">
                            <?php echo $this->Captcha->render(array('type' => 'image', 'height' => '44px', 'width' => '300px', 'attr' => array('class' => 'form-control', 'tabindex' => 3))); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="cb20"></div>
                        <button class="cmn_btn_n pad_big" type="button" onclick="refer_form_valid();" tabindex="4">Submit</button>
                    </div>
                </div>
                <div class="con-w-40 fr">
                    <h3>Help your friends. Let them Go for the Best.</h3>
                    <h4><?php echo __('Registration is FREE and Easy!'); ?></h4>
                    <ul>
                        <li>Feel free to refer us and make it easy in exploring.</li>
                    </ul>
                </div>
                <div class="cb"></div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
        <div class="cb"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        //$('#name').focus();
        $('.creload').attr('title', 'Refresh Image').html('<i class="fa fa-refresh"></i>');
    });
</script>