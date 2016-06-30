<style>
    .pop-up-box .rating-stars{float: left; margin-right: 5px;}
    .pop-up-box .review-box{border:0px none;}
    .pop-up-box .review-box tr{margin:4px 0px;}
    .pop-up-box .review-box td{padding:3px 5px;}
    .pop-up-box .review-box td.lb{font-weight: bold;}
</style>
<div class="pop-up-box" style="width:496px;min-height: 250px; height: 100%;padding:20px;">
    <div class="up_mc_top book_now"><h2>Edit Review Detail</h2></div>
    <div class="cb20"></div>
    <div class="pop-up-form">
        <?php echo $this->Form->create('BusinessRating'); ?>
        <?php echo $this->Form->input('id'); ?>
        <table class="review-box" border="0" style="width:100%;">
            <tr>
                <td class="lb">Rating</td>
                <td>
                    <?php $rating = floatval($this->data['BusinessRating']['rating']);?>
                    <div class="rateit12" id="rateit9" style="width: 100px;" data-rateit-ispreset="true"></div>
                    <?php echo $this->Form->input('rating', array('type' => 'hidden', "id" => "backingfld", "value" => $rating)); ?>
                    <span id="backingfld_span" style="color:#EA632C"><?php echo $rating;?> Star<?php echo $rating>1?"s":"";?></span>
                </td>
            </tr>
            <tr>
                <td class="lb" valign="top">Comment</td>
                <td>
                    <?php echo $this->Form->input('comment', array('type' => 'textarea', 'div' => false, 'label' => false, 'style'=>'width:100%;','class'=>'noresize'));?>
                </td>
            </tr>
          
            <tr><td class="lb">&nbsp;</td><td><button class="cmn_btn_n pad_big" type="submit">Submit</button></td></tr>
        </table>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<script type="text/javascript">
    $('#rateit9').rateit({step:0.5,backingfld:'#backingfld',starwidth:'20',})
                .on('beforerated', function (e, value) {$('#backingfld_span').html(value+' Star'+(parseInt(value)>1?"s":""));});
        $('#rateit9').rateit('value','<?php echo floatval($this->data['BusinessRating']['rating']);?>')
</script>