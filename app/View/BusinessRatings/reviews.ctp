<?php
echo $this->Html->css(array('rateit'));
echo $this->Html->script(array('rateit/jquery.rateit.min'), array('inline' => false));
?>
<style type="text/css">
    .rate-stars img{}
</style>
<div class="booking_det">
    <div class="wrapper">
        <div class="content-left fl">
            <?php echo $this->element('user_inner_left_navbar'); ?>
        </div>
        <div class="fr upcom_book_cnt">
            <div class="bg-trns-white">
                <div class="up_mc_top1">
                    <h2>Reviews</h2>
                    <div class="cb"></div>
                </div>
                <table id="reviews_business" class="display listblocks-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:14%;"><?php echo __('User'); ?></th>
                            <th style="width:18%;"><?php echo __('Class'); ?></th>
                            <th style="width:14%;min-width:70px;"><?php echo __('Date'); ?></th>
                            <th style="width:6%;"><?php echo __('Rating'); ?></th>
                            <th style="width:23%;"><?php echo __('Comment'); ?></th>
                            <th style="width:23%;"><?php echo __('My Reply'); ?></th>
                            <th style="width:2%; text-align: center;"><?php echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ratings as $businessRating) { ?>
                        <?php $BusinessRatingId = $businessRating['BusinessRating']['id']; ?>
                            <tr>
                                <td style="max-width:90px;" class="ellipsis-view">
                                    <span  rel="tooltip" title="<?php echo h($businessRating['User']['name']); ?>">
                                        <?php echo $this->Format->showUsername($businessRating['User']['name']); ?>
                                    </span>
                                </td>
                                <td style="max-width:100px;" class="ellipsis-view">
                                    <span  rel="tooltip" title="<?php echo h($businessRating['Business']['name']); ?>">
                                        <?php echo h($businessRating['Business']['name']); ?>
                                    </span>
                                </td>
                                <td><?php echo $this->Format->dateFormat($businessRating['BusinessRating']['created']); ?></td>
                                <td align="center" class="rate-stars" style="text-align:center;">
                                    <?php $rating = isset($businessRating['BusinessRating']['rating']) ? $businessRating['BusinessRating']['rating'] : 0; ?>
                                    <?php echo floatval($rating); ?>
                                    <?php #echo $this->element('view_rating', array('rating' => $rating,'show_count'=>'No')) ?>
                                </td>
                                <td style="max-width:160px;" class="ellipsis-view">
                                    <span rel="tooltip" title="<?php echo h($businessRating['BusinessRating']['comment']); ?>">
                                        <?php echo h($businessRating['BusinessRating']['comment']); ?>
                                    </span>
                                </td>
                                <td style="max-width:160px;" class="ellipsis-view">
                                    <?php if(!empty($businessRating['BusinessRatingReply'][0]['comment'])): ?>
                                    <span rel="tooltip" title="<?php echo h($businessRating['BusinessRatingReply'][0]['comment']); ?>">
                                        <?php echo h($businessRating['BusinessRatingReply'][0]['comment']); ?>
                                    </span>
                                    <?php else:?>
                                    ---
                                    <?php endif;?>
                                </td>
                                <td style="text-align: center;">
                                    <span>
                                        <?php if (intval($businessRating['BusinessRating']['status']) == 1): ?>
                                            <a class="anchor " title="Disable Review" href="<?php echo $this->Html->url(array('action' => 'grant_reviews', $BusinessRatingId, 'disable')); ?>">
                                                <i class="fa fa-ban"></i>
                                            </a>
                                        <?php else: ?>
                                            <a class="anchor " title="Approve Review" href="<?php echo $this->Html->url(array('action' => 'grant_reviews', $BusinessRatingId, 'approve')); ?>">
                                                <i class="fa fa-check-square-o"></i>
                                            </a>
                                        <?php endif; ?>
                                    </span>
                                    <span class="action_links" style="margin-left: 5px;">
                                        <a class="anchor ajax" data-href="<?php echo $this->Html->url(array('action' => 'reply', $BusinessRatingId)); ?>">
                                            <i class="fa fa-pencil" title="Reply"></i>
                                        </a>
                                    </span>
                                    <?php /*?><span class="action_links" style="margin-left: 5px;">
                                        <a class="anchor ajax"
                                           data-href="<?php echo $this->Html->url(array('action' => 'reviews_info', $BusinessRatingId)); ?>">
                                            <i class="fa fa-eye" title="View"></i>
                                        </a>
                                    </span><?php */?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="cb"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#reviews_business').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [], //[0, 'desc']
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [4]},
            ]
        });
        table.on('draw', function() {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
    });
</script>