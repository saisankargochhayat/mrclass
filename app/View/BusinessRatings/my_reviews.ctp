<?php
echo $this->Html->css(array('rateit'));
echo $this->Html->script(array('rateit/jquery.rateit.min'), array('inline' => false));
?>
<div class="booking_det">
    <div class="wrapper">
        <div class="content-left fl">
            <?php echo $this->element('business_left_tab') ?>
        </div>
        <div class="fr upcom_book_cnt">
            <div class="bg-trns-white">
                <div class="up_mc_top1">
                    <h2>My Reviews</h2>
                    <div class="cb"></div>
                </div>

                <table id="my_reviews_user" class="display listblocks-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:12%;"><?php echo __('Date'); ?></th>
                            <th style="width:18%;"><?php echo __('Class'); ?></th>
                            <th style="width:6%;"><?php echo __('Rating'); ?></th>
                            <th style="width:22%;"><?php echo __('Comment'); ?></th>
                            <th style="width:22%;"><?php echo __('Reply by Owner'); ?></th>
                            <th style="width:5%;text-align: center;"><?php echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ratings as $businessRating) { ?>
                        <?php $BusinessRatingId = $businessRating['BusinessRating']['id']; ?>
                            <tr>
                                <td align="center"><?php echo $this->Format->dateFormat($businessRating['BusinessRating']['created']); ?></td>
                                <td style="max-width:150px;" class="ellipsis-view" >
                                    <span rel="tooltip" title="<?php echo h($businessRating['Business']['name']); ?>">
                                        <?php echo h($businessRating['Business']['name']); ?>
                                    </span>
                                </td>
                                <td align="center" style="text-align:center;">
                                    <?php $rating = isset($businessRating['BusinessRating']['rating']) ? $businessRating['BusinessRating']['rating'] : 0; ?>
                                    <?php echo floatval($rating); ?>
                                    <?php #echo $this->element('view_rating', array('rating' => $rating,'show_count'=>'No')) ?>
                                    
                                </td>
                                <td style="max-width:150px;" class="ellipsis-view" >
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
                                <td align="center">
                                    <span><?php if (intval($businessRating['BusinessRating']['status']) == 1): ?><i class="fa fa-check-square-o" title="Approved"></i><?php else: ?><i class="fa fa-exclamation-triangle" title="Not Approved"></i><?php endif; ?></span>
                                    <span class="action_links" style="margin-left: 5px;">
                                        <?php /*if (intval($businessRating['BusinessRating']['status']) == 1): ?>
                                            <a style="opacity: 0.6;"><i class="fa fa-pencil" title="Disabled"></i></a>
                                        <?php else: ?>
                                        <?php endif; */?>
                                        <a class="anchor ajax" data-href="<?php echo $this->Html->url(array('action' => 'edit', $BusinessRatingId)); ?>"><i class="fa fa-pencil" title="Edit"></i></a>
                                    </span>
                                    <span class="action_links" style="margin-left: 5px;"><a class="anchor deletereview" data-id="<?php echo $BusinessRatingId; ?>"><i class="fa fa-trash" title="Delete"></i></a></span>
                                    <?php /*?><span class="action_links" style="margin-left: 5px;"><a class="anchor ajax" data-href="<?php echo $this->Html->url(array('action' => 'reviews_info', $BusinessRatingId)); ?>"><i class="fa fa-eye" title="View"></i></a></span><?php */?>
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
        var table = $('#my_reviews_user').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [],//[0, 'desc']
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [4]},
            ]
        });
        table.on('draw', function() {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
        $(document).on('click','.deletereview',function(){
            var obj = $(this);
            confirm("Are you sure to delete the review?",function(){
                //General.hideAlert();alert('Yes');
                var id = obj.attr('data-id');
                alert(id)
                var params = {id:id};
                    $.ajax({
                        url: "<?php echo $this->Html->url(array('controller' => 'business_ratings', 'action' => 'delete')); ?>/"+id,
                        data: params,
                        method: 'post',
                        dataType:"json",
                        success: function (response) {
                            General.hideAlert();
                            alert(response.message);
                            if (response.success === 1) {
                                window.location.reload();
                            }
                        }
                    });
            });
        });
    });
</script>