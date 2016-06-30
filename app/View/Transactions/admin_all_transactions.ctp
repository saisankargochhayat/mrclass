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
                        <h3 class="box-title"><?php echo __('All Transactions'); ?></h3>
					</div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="all_transactions"class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo __('User'); ?></th>
                                    <th><?php echo __('Package'); ?></th>
                                    <th><?php echo __('Mode'); ?></th>
									<th><?php echo __('Sub-total'); ?></th>
                                    <th><?php echo __('Discount'); ?></th>
                                    <th><?php echo __('Total'); ?></th>
                                    <th><?php echo __('Ref.No.'); ?></th>
                                    <th><?php echo __('Status'); ?></th>
                                    <th style="text-align: center;"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php foreach ($transaction_data as $data) { ?>
                            <tr>
                            <td><?php echo $data['User']['name']; ?></td>
                            <td><?php echo $data['Subscription']['name']; ?></td>
                            <td><?php echo $data['Transaction']['mode']; ?></td>
							 <td><?php echo $data['Transaction']['sub_total']; ?></td>
                            <td><?php echo $data['Transaction']['discount']; ?></td>
                            <td><?php echo $data['Transaction']['final_price']; ?></td>
                            <td><a href="<?php echo $this->Html->url(array("controller" => "transactions","action" => "invoice","admin" => 1,$data['Transaction']['id']));?>" rel="tooltip" title="Click to view invoice"><?php echo $data['Transaction']['reference_number']; ?></a></td>
                            <td>
                                <a href="#" class="editable editable-click status_link" data-type="select" data-pk="<?php echo $data['Transaction']['id']; ?>" rel="tooltip" data-name="status" data-value="<?php echo $data['Transaction']['status']; ?>" title="Select status">
                                <?php echo $data['Transaction']['status']; ?>
                                </a>
                            </td>
                            <td style="text-align: center;">
								<span class="action_links">
                                        <a href="<?php echo $this->Html->url(array("controller" => "transactions","action" => "view","admin" => 1,$data['Transaction']['id']));?>" rel="tooltip" data-original-title="View transaction details"><i class="fa fa-eye"></i></a>
                                    </span>
                                    <span class="action_links" style="margin-left: 6px;">
                                        <a href="<?php echo $this->Html->url(array("controller" => "transactions","action" => "delete","admin" => 1,$data['Transaction']['id']));?>" rel="tooltip" title="Delete transcation" data-id="<?php echo $data['Transaction']['id']; ?>" id="<?php echo $data['Transaction']['id']; ?>" onclick="if (confirm(&quot;Are you sure you want to delete the transaction ?&quot;)) { return true; } return false;" class="admin_del_transaction"><span class="fa fa-trash-o"></span></a>
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
    table = $('#all_transactions').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
				"aaSorting": [], //[0, 'desc']
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [8]},
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
            url: "<?php echo $this->Html->url(array('controller' => 'transactions', 'action' => 'change_status','admin'=>1)); ?>",
            ajaxOptions: {
                dataType: 'json'
            },
            success: function(response, newValue) {
                if(!response) {
                    return "Unknown error!";
                }          
                if(response.success === false) {
                     return response.responseText;
                }
            },
            error: function(response, newValue) {
                if(response.status === 500) {
                    return 'Service unavailable. Please try later.';
                } else {
                    return response.responseText;
                }
            }
        });
    });
});
</script>