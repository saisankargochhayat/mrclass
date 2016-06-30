<style type="text/css">
    .star_on{display: inline-block; float:left;}
</style>
<p>Dear <?php echo h($business['Business']['contact_person']); ?>,</p>
<?php if(!empty($mode) && $mode == 'update'): ?>
    <p>A review is updated for your business: <b><?php echo h($business['Business']['name']); ?></b>.</p>
<?php else: ?>
    <p>A new review is received for your business: <b><?php echo h($business['Business']['name']); ?></b>.</p>
<?php endif; ?>
<p>Review Details:</p>
<p>
<table style="width: 100%;">
    <tr>
        <td style="width:120px;"><b>Name</b></td> <td>:</td><td><?php echo h($reviewed_by); ?></td>
    </tr>
    <tr>
        <td><b>Reviewed on</b></td> <td>:</td><td><?php echo date('M d, Y'); ?></td>
    </tr>
    <tr>
        <td><b>Comment</b></td> <td>:</td><td><?php echo h($review['comment']); ?></td>
    </tr>
    <tr>
        <td><b>Rating</b></td><td>:</td>
        <td>
            <?php
            $rating = $review['rating'];?>
            <?php echo $this->element('view_rating', array('rating' => $rating,'show_count'=>'No')) ?>
            <span>(<?php echo round($rating,1); ?>)</span>
        </td>
    </tr>
</table>
</p>
<p>You required to approve the review to available.</p>