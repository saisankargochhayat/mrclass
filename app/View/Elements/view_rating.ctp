<?php $element = !empty($element) ?$element:"a";?>
<?php $show_count = !empty($show_count) ?$show_count:"Yes";?>
<?php $fraction = $rating > floor($rating)?"Yes":"No";?>
<?php for ($i = 0; $i < 5; $i++) { ?>
    <?php if($element =='span') { ?>
        <span class="star_on">
    <?php }else{ ?>
        <a class="star_on">
    <?php } ?>
        <?php $img =  $i < floor($rating) ? "fill-star.png" : ($i == ceil($rating)-1 && $fraction == 'Yes' ? "half-star.png" : "unfill-star.png") ?>
        <img  src="<?php echo HTTP_ROOT; ?>images/<?php echo $img; ?>" alt="" />
    <?php if($element =='span') { ?>
        </span>
    <?php }else{ ?>
        </a>
    <?php } ?>
<?php } ?>
<?php if($show_count =='Yes') { ?>
<span>(<?php echo $reviews_count;?>)</span>
<?php } ?>