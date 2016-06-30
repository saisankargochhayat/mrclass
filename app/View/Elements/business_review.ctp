<div class="review-full-content">
    <div class="review-img fl">
        <img src="<?php echo $this->Format->user_photo($review['User'], 39, 42, 1); ?>" alt="" style="border-radius:50%;" title="<?php echo $review['User']['name'];?>"/>
    </div>
    <div class="review-desc fl">
        <div class="arrow-left-html"></div>
        <?php $rating = isset($review['BusinessRating']['rating']) ? $review['BusinessRating']['rating'] : 0; ?>
        <div class="fl rating_star" title="<?php echo floatval($rating); ?>">
            <?php echo $this->element('view_rating', array('rating' => $rating,'show_count'=>'No')) ?>
        </div>
        <div class="fr">
            <div class="fl" style="margin-right:10px;">By <b><?php echo $review['User']['name'];?></b> on </div>
            <div class="fr calender-review"><?php echo $this->Format->dateFormat($review['BusinessRating']['created']) ?></div>
        </div>
        <div class="cb"></div>
        <p class="description-text"><?php echo nl2br(h($review['BusinessRating']['comment'])); ?></p>
        <?php if(isset($review['BusinessRating']['status']) && $review['BusinessRating']['status'] == '0'){ ?>
            <span class="fr fa fa-warning" style="color:#EA510E;" title=""></span>
            <div class="cb"></div>
            <em class="fr" style="font-size:12px;">Approval Pending</em>
        <?php } ?>
    </div>
        <?php if(isset($review['BusinessRatingReply'][0]['comment']) && $review['BusinessRatingReply'][0]['comment'] !=''){ ?>
            <div class="review-reply">
                <img class="fl" src="<?php echo $this->Format->user_photo(array('id'=>$review['BusinessRatingReply'][0]['user_id'],'photo'=>$review['BusinessRatingReply'][0]['user_photo']), 39, 42, 1); ?>" alt="" style="border-radius:50%;" title="<?php echo $review['BusinessRatingReply'][0]['user_name'];?>"/>
                <div class="review-desc">
                    <div class="arrow-left-html"></div>
                    <div class="fl" style="">Replied By <b><?php echo $review['BusinessRatingReply'][0]['user_name'];?></b> </div>
                    <div class="fr">
                        <div class="fr calender-review"><?php echo $this->Format->dateFormat($review['BusinessRatingReply'][0]['created']) ?></div>
                    </div>
                    <div class="cb"></div>
                    <p class="description-text"><?php echo nl2br(h($review['BusinessRatingReply'][0]['comment'])); ?></p>
                </div>
            </div>
        <?php } ?>
    <div class="cb"></div>
</div>