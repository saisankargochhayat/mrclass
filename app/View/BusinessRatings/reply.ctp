<style>
    .pop-up-box .rating-stars{float: left; margin-right: 5px;}
    .pop-up-box .review-box{border:0px none;}
    .pop-up-box .review-box tr{margin:4px 0px;}
    .pop-up-box .review-box td{padding:3px 5px;}
    .pop-up-box .review-box td.lb{font-weight: bold;}
</style>
<div class="pop-up-box" style="width:496px;min-height: 250px; height: 100%;padding:20px;">
    <div class="up_mc_top book_now"><h2>Reply to Review</h2></div>
    <div class="cb20"></div>
    <div class="pop-up-form">
        <?php echo $this->Form->create('BusinessRatingReply'); ?>
        <?php echo $this->Form->input('id'); ?>
        <table class="review-box" border="0" style="width:100%;">
            
            <tr>
                <td class="lb" valign="top">Rating</td>
                <td>
                    <?php $rating = isset($review['BusinessRating']['rating']) ? $review['BusinessRating']['rating'] : 0; ?>
                    <?php echo $this->element('view_rating', array('rating' => $rating,'show_count'=>'No')) ?>
                </td>
            </tr>
            <tr>
                <td class="lb" valign="top">Comment</td>
                <td>
                 <?php echo h($review['BusinessRating']['comment'])?>   
                </td>
            </tr>
            <tr>
                <td class="lb" valign="top">Reply</td>
                <td>
                    <?php echo $this->Form->input('comment', array('type' => 'textarea', 'div' => false, 'label' => false, 'style'=>'width:100%;','class'=>'noresize','placeholder'=>'Write your reply here...'));?>
                </td>
            </tr>
          
            <tr><td class="lb">&nbsp;</td><td><button class="cmn_btn_n pad_big" type="submit">Submit</button></td></tr>
        </table>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
