<style>
    .action_links{margin:0 0 0 5px;}
</style>
<?php 
$button_text = (!empty($subscriptions_data)) ? "Change Subscription" : "Subscribe";
if(empty($subscriptions_data)){
    $is_button_visible = true;
}else if(!empty($subscriptions_data) && $subscriptions_data[0]['Subscription']['status'] == '0'){
    $is_button_visible = true;
}else if(!empty($subscriptions_data) && $subscriptions_data[0]['Subscription']['status'] == '1'){
    $is_button_visible = true;
}else{
    $is_button_visible = false; 
}
?>
<div class="booking_det">
    <div class="wrapper">
        <div class="content-left fl">
            <?php echo $this->element('user_inner_left_navbar'); ?>
        </div>
        <div class="fr upcom_book_cnt">
            <div class="bg-trns-white">
                <div class="up_mc_top1">
                    <h2 class="fl">Your Subscriptions</h2>
                    <?php if($is_button_visible){?>
                    <div class="fr"><a href="<?php echo $this->Html->url(array('action' => 'choose_subscription')); ?>" class="cmn_btn_n chng_sub"><?php echo $button_text;?></a></div>
                    <div class="cb"></div>
                    <?php }?>
                </div>
                <table id="subscriptions_user" class="display listblocks-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:15%;"><?php echo __('Name'); ?></th>
                            <th style="width:20%;"><?php echo __('Subscription Start'); ?></th>
                            <th style="width:20%;"><?php echo __('Subscription End'); ?></th>
                            <th style="width:15%;"><?php echo __('Status'); ?></th>
                            <th style="width:5%;text-align: center;"><?php echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subscriptions_data as $subscription) { ?>
                            <tr>
                                <td><?php echo $subscription['Subscription']['name'];?></td>
                                <td style="text-align:center;">
                                    <?php echo (!empty($subscription['Subscription']['subscription_start'])) ? $this->Format->dateFormat($subscription['Subscription']['subscription_start']) : "NA"; ?>
                                </td>
                                <td style="text-align:center;">
                                    <?php echo (!empty($subscription['Subscription']['subscription_end'])) ? $this->Format->dateFormat($subscription['Subscription']['subscription_end']) : "NA"; ?>
                                </td>
								<?php if($subscription['Subscription']['status'] == '0'){
										$status = '<span style="font-weight:bold;color:#f39c12;">Pending approval</span>';
                                }else if($subscription['Subscription']['status'] == '2'){
                                        $status = '<span style="font-weight:bold;color:#dd4b39;">Cancelled</span>';
								}else if($this->Format->is_subscription_expired($subscription['Subscription']['subscription_start'],$subscription['Subscription']['listing_period'])){
										$status = '<span style="font-weight:bold;color:#f39c12;">Expired</span>';
								}else{
										$status = '<span style="font-weight:bold;color:#00a65a;">Active<span>';
								}?>
								<td><?php echo $status;?></td>
                                <td style="text-align: center;">
                                    <?php $subscriptionID = $subscription['Subscription']['id']; ?>
                                    <span class="action_links">
                                        <a class="anchor" title="View Subscription Details" href="<?php echo $this->Html->url(array('action' => 'view', $subscriptionID)); ?>">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </span>
									<span class="action_links">
                                        <a class="anchor" title="View Transactions" href="<?php echo $this->Html->url(array('controller'=>'transactions','action' => 'index', $subscriptionID)); ?>">
                                           <i class="fa fa-money"></i>
                                        </a>
                                    </span>
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
        var table = $('#subscriptions_user').DataTable({
            "paging": true,
            "lengthChange": true,
			"language": {
				"emptyTable":"No subscriptions found"
			},
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [], 
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