<style>
    .pop-up-box .rating-stars{float: left; margin-right: 5px;}
    .pop-up-box .review-box{border:0px none;}
    .pop-up-box .review-box tr{margin:4px 0px;}
    .pop-up-box .review-box td{padding:3px 5px;}
    .pop-up-box .review-box td.lb{font-weight: bold;}
</style>
<div class="pop-up-box" style="width:496px;min-height: 250px; height: 100%;padding:20px;">
    <div class="up_mc_top book_now"><h2>Review Detail</h2></div>
    <div class="cb20"></div>
    <div class="pop-up-form">
        <table class="review-box" border="0">
            <tr>
                <td class="lb">Business</td>
                <td><?php echo h($review['Business']['name']); ?></td>
            </tr>
            <tr>
                <td class="lb">Given By</td>
                <td><?php echo $this->Format->showUsername($review['User']['name']); ?></td>
            </tr>
            <tr>
                <td class="lb">Date</td>
                <td><?php echo $this->Format->dateFormat($review['BusinessRating']['created']); ?></td>
            </tr>
            <tr>
                <td class="lb">Rating</td>
                <td>
                    <?php $rating = isset($review['BusinessRating']['rating']) ? $review['BusinessRating']['rating'] : 0; ?>
                    <?php echo $this->element('view_rating', array('rating' => $rating,'show_count'=>'No')) ?>
                </td>
            </tr>
            <tr>
                <td class="lb">Comment</td>
                <td><?php echo nl2br(h($review['BusinessRating']['comment'])); ?></td>
            </tr>
        </table>
    </div>
</div>