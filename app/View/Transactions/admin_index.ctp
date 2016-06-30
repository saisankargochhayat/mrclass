<?php
echo $this->Html->css(array('bootstrap-editable'), array('inline' => false));
echo $this->Html->script(array('bootstrap-editable.min'), array('inline' => false));
?>
<style type="text/css">
    .box{min-height: 450px;}
    .editable-click, a.editable-click, a.editable-click:hover{text-decoration: none;border-bottom: dashed 1px #0088cc;}
</style>
<section id="ajax_div">
    <section class="content-header">
        <h1><?php echo __('Transactions'); ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'subscriptions', 'action' => 'index', 'admin' => 1)); ?>"> Subscriptions</a></li>
            <li>Transactions</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo (empty($transaction_data)) ? 'No transcations found' : 'All transactions of ' . $user_data['User']['name']; ?></h3>
                        <div class="box-tools pull-right">
                            <?php /* <a href="<?php echo $this->Html->url(array('controller' => 'transactions', 'action' => 'add', 'admin' => 1, $user_data['User']['id'], $subscription_id)); ?>" class="btn btn-flat btn-primary btn-sm pull-left"><i class="ion ion-person-add"></i>  <?php echo 'Add Transaction'; ?></a> */?>
                            <a href="javascript://" onclick="alert('Comming soon!')" class="btn btn-flat btn-primary btn-sm pull-left"><i class="ion ion-person-add"></i>  <?php echo 'Add Transaction'; ?></a>
                    	</div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="admin_transactions"class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo __('Package'); ?></th>
                                    <th><?php echo __('Mode'); ?></th>
                                    <th><?php echo __('Sub-total'); ?></th>
                                    <th><?php echo __('Discount'); ?></th>
                                    <th><?php echo __('Total'); ?></th>
                                    <th><?php echo __('Created'); ?></th>
                                    <th><?php echo __('Status'); ?></th>
                                    <th style="text-align: center;"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php foreach ($transaction_data as $data) { ?>
                            <tr>
                                <td><?php echo $data['Subscription']['name']; ?></td>
                                <td><?php echo $data['Transaction']['mode']; ?></td>
                                <td><?php echo $data['Transaction']['sub_total']; ?></td>
                                <td><?php echo $data['Transaction']['discount']; ?></td>
                                <td><?php echo $data['Transaction']['final_price']; ?></td>
                                <td>
                                            <?php /*<a href="<?php echo $this->Html->url(array("controller" => "transactions", "action" => "invoice", "admin" => 1, $data['Transaction']['id'])); ?>" target="_blank" rel="tooltip" title="Click to view invoice"><?php echo $data['Transaction']['reference_number']; ?></a>*/?>
                                            <?php echo $this->Format->dateFormat($data['Transaction']['created']); ?>
                                    <?php /* if ($data['Subscription']['status'] == '1') { ?>
                                    <?php } else { ?>
                                        <a href="javascript:void(0)" style="color:black;cursor:default;">---</a>
                                    <?php } */ ?>
                                </td>
                                <td>
                                    <?php if ($data['Subscription']['status'] == '1' || $data['Subscription']['status'] == '0') { ?>
                                        <a href="#" class="editable editable-click status_link" data-type="select" data-pk="<?php echo $data['Transaction']['id']; ?>" rel="tooltip" data-name="status" data-value="<?php echo $data['Transaction']['status']; ?>" title="Select status"><?php echo $data['Transaction']['status']; ?></a>
                                    <?php } else { ?>
                                        <?php echo $data['Transaction']['status']; ?>
                                    <?php } ?>
                                </td>
                                <td style="text-align: center;">
                                    <span class="action_links">
                                                <a href="<?php echo $this->Html->url(array("controller" => "transactions", "action" => "invoice", "admin" => 1, $data['Transaction']['id'])); ?>" target="_blank" rel="tooltip" title="View Invoice" class="admin_invoice_transaction"><span class="fa  fa-file-text-o"></span></a>
                                            </span>
                                            <span class="action_links" style="margin-left: 6px;">
                                        <a href="<?php echo $this->Html->url(array("controller" => "transactions", "action" => "view", "admin" => 1, $data['Transaction']['id'], $user_data['User']['id'], $subscription_id)); ?>" rel="tooltip" data-original-title="View transaction details"><i class="fa fa-eye"></i></a>
                                    </span>
                                    <span class="action_links" style="margin-left: 6px;">
                                        <a href="<?php echo $this->Html->url(array("controller" => "transactions", "action" => "delete", "admin" => 1, $data['Transaction']['id'], $user_data['User']['id'], $subscription_id)); ?>" rel="tooltip" title="Delete transcation" data-id="<?php echo $data['Transaction']['id']; ?>" id="<?php echo $data['Transaction']['id']; ?>" onclick="if(confirm(&quot;Are you sure you want to delete the transaction?&quot;)){return true;}return false;" class="admin_del_transaction"><span class="fa fa-trash-o"></span></a>
                                    </span>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</section><!-- /.ajax_div -->
<script type="text/javascript">
jQuery(document).ready(function($) {
    table = $('#admin_transactions').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
	        "aaSorting": [], //[0, 'desc']
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [6]},
            ]
    });
    table.on('draw', function () {
        var body = $(table.table().body());
        body.unhighlight();
        body.highlight(table.search());
    });
      //toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'popup';
    $('.status_link').each(function(index, el) {
        var _this = $(this);
        $('.editable-click').editable({
            title: 'Change status',
            placement: 'top',
            source: [
				{value: 'Initiated', text: 'Initiated'},
				{value: 'Scheduled', text: 'Scheduled'},
				{value: 'Processing', text: 'Processing'},
				{value: 'Authorized', text: 'Authorized'},
				{value: 'On Hold', text: 'On Hold'},
				{value: 'Declined', text: 'Declined'},
				{value: 'Cancelled', text: 'Cancelled'},
				{value: 'Completed', text: 'Completed'},
            ],
            url: "<?php echo $this->Html->url(array('controller' => 'transactions', 'action' => 'change_status', 'admin' => 1)); ?>",
            ajaxOptions: {
                dataType: 'json'
            },
            success: function(response, newValue) {
                if (!response) {
                    return "Unknown error!";
                }
                if (response.success === false) {
                    return response.responseText;
                }
            },
            error: function(response, newValue) {
                if (response.status === 500) {
                    return 'Service unavailable. Please try later.';
                } else {
                    return response.responseText;
                }
            }
        });
    });
});
</script>