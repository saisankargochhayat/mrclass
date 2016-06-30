<?php
echo $this->Html->css(array('rateit'));
echo $this->Html->script(array('rateit/jquery.rateit.min'), array('inline' => false));
?>
<style type="text/css">
    div.tooltip-inner {max-width: 450px;}
</style>
<section class="content-header">
    <h1><?php echo __('Edit Business'); ?>: <?php echo h($business);?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'index', 'admin' => 1)); ?>">Businesses</a></li>
        <li class="active"><?php echo __('Edit Business'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <?php echo $this->element('admin_business_edit_tabs'); ?>
                <div class="tab-content">
                    <div class="active tab-pane" id="timings">
                        <div class="box">
                            <div class="box-header with-border">
                                <i class="fa fa-star"></i>
                                <h3 class="box-title"><?php echo __('View review & ratings'); ?></h3>
                            </div><!-- /.box-header -->
                            <div class="box-body ">
                                <table id="ratings" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:15%;"><?php echo __('User'); ?></th>
                                            <th style="width:12%;"><?php echo __('Date'); ?></th>
                                            <th style="width:12%;"><?php echo __('Rating'); ?></th>
                                            <th style="width:30%;"><?php echo __('Comment'); ?></th>
                                            <th style="width:22%;"><?php echo __('Reply by Owner'); ?></th>
                                            <th style="width:10%;"><?php echo __('Actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($businessRatings as $businessRating) {?>
                                        <tr>
                                            <td class="ellipsis-view" style="max-width:100px;">
                                                <span rel="tooltip" title="<?php echo h($businessRating['User']['name']); ?>">
                                                    <?php echo h($businessRating['User']['name']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo $this->Format->dateFormat($businessRating['User']['created']); ?></td>
                                            <?php /*?><td>
                                            <?php echo $this->Format->shortLength($businessRating['Business']['name'],15,$businessRating['Business']['name']); ?>
                                            </td><?php */?>
                                            <td>
                                                <?php echo $this->element('view_rating', array('rating' => $businessRating['BusinessRating']['rating'],'show_count'=>'No')) ?>
                                                <?php //echo round($businessRating['BusinessRating']['rating'],1); ?>
                                            </td>
                                            <td class="ellipsis-view" style="max-width:100px;">
                                                <?php echo $this->Format->shortLength($businessRating['BusinessRating']['comment'],50,$businessRating['BusinessRating']['comment']); ?>
                                            </td>
                                            <td class="ellipsis-view" style="max-width:100px;">
                                                <?php if(!empty($businessRating['BusinessRatingReply'][0]['comment'])): ?>
                                                    <?php echo $this->Format->shortLength($businessRating['BusinessRatingReply'][0]['comment'],50,$businessRating['BusinessRatingReply'][0]['comment']); ?>
                                                <?php else:?>
                                                ---
                                                <?php endif;?>
                                            </td>
                                            <td>
                                                <span class="action_links">
                                                <?php if(intval($businessRating['BusinessRating']['status']) == 1): ?>
                                                    <?php echo $this->Html->link('<i class="fa fa-ban"></i> ', array('action' => 'admin_grant_rating',$businessRating['BusinessRating']['id'],$business_id,"bratings"),array('escape' => false,'rel'=>'tooltip','data-original-title'=>'Disable Rating')); ?>
                                                <?php else: ?>
                                                    <?php echo $this->Html->link('<i class="fa fa-check-square-o"></i> ', array('action' => 'admin_grant_rating',$businessRating['BusinessRating']['id'],$business_id,"bratings"),array('escape' => false,'rel'=>'tooltip','data-original-title'=>'Enable Rating')); ?>
                                                <?php endif;?>
                                                </span>
                                                <span class="action_links">
                                                    <a data-original-title="Edit" rel="tooltip" id="edit_ratingc_<?php echo $businessRating['BusinessRating']['id']?>" href="javascript:void(0)" data-id="<?php echo $businessRating['BusinessRating']['id']?>" data-bid="<?php echo $business_id;?>" data-params="bratings"><i class="fa fa-pencil"></i> </a>
                                                </span>
                                                <span class="action_links">
                                                    <?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'fa fa-trash-o')) . "",array('action' => 'delete', 'admin' => 1,$businessRating['BusinessRating']['id'],$business_id,"bratings"),array( 'escape' => false,'rel' => 'tooltip','rel'=>'tooltip','data-original-title'=>'Delete','confirm' => __('Are you sure you want to delete the review?', $businessRating['BusinessRating']['id'])));?>
                                                </span>
                                            </td>
                                        </tr>
                                <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.tab-pane -->    
                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<?php echo $this->element('modal'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#ratings').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [[1, 'desc']],
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [5]},
            ]
        });
        table.on('draw', function () {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
        $('a[id^=edit_ratingc_]').on('click', function () {
            var id = $(this).data('id');
            var param = $(this).data('params');
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller' => 'business_ratings', 'action' => 'edit', 'admin' => 1)); ?>",
                type: 'POST',
                dataType: 'json',
                data: {id: id},
                success: function (res) {
                    if (res) {
                        $('#edit_rating_content').val(res.BusinessRating.comment);
                        $('#rating_bid_id').val(res.Business.id);
                        $('#rating_param_text').val(param);
                        $('#rating_hid_id').val(res.BusinessRating.id);
                        $('#edit_rating_modal').modal();
                        $('#rateit9').rateit({step:0.5,backingfld:'#backingfld',starwidth:'20',})
                                .on('beforerated', function (e, value) {$('#backingfld_span').html(value+' Star'+(parseFloat(value)>1?"s":""));});
                        $('#rateit9').rateit('value',res.BusinessRating.rating);
                        $('#backingfld_span').html(parseFloat(res.BusinessRating.rating)+' Star'+(parseFloat(res.BusinessRating.rating)>1?"s":""));
                    }
                }
            });
        });
    });
</script>
