<style type="text/css">
    .box{min-height: 450px;}
</style>
<section>
    <section class="content-header">
        <h1><?php echo __('User Subscriptions'); ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Subscriptions</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo __('All Subscriptions'); ?></h3>
                        <div class="box-tools pull-right" style="position:initial;">
                            <a href="<?php echo $this->Html->url(array('controller' => 'subscriptions', 'action' => 'add', 'admin' => 1)); ?>" class="btn btn-flat btn-primary btn-sm pull-left"><?php echo str_replace('_', ' ', 'Add_Subscription'); ?></a>
                            <a href="<?php echo $this->Html->url(array('controller' => 'subscriptions', 'action' => 'export_modal', 'admin' => 1)); ?>" data-toggle="modal" data-target="#myExportModal" class="btn btn-flat btn-primary btn-sm pull-right ico-export-btn"><i class="fa fa-file-excel-o"></i>  <?php echo "Export"; ?></a>
                            <a href="<?php echo $this->Html->url(array('controller' => 'transactions', 'action' => 'all_transactions', 'admin' => 1)); ?>" class="btn btn-flat btn-primary btn-sm pull-right">&nbsp;&nbsp;<?php echo 'See all transactions'; ?>&nbsp;&nbsp;</a>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="admin_subscriptions"class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo 'User'; ?></th>
                                    <th><?php echo 'Package' ?></th>
                                    <th><?php echo 'Listing Period'; ?></th>
                                    <th><?php echo 'Subscription Start'; ?></th>
                                    <th><?php echo 'Subscription End'; ?></th>
                                    <th><?php echo 'Status'; ?></th>
                                    <th><?php echo 'Created'; ?></th>
                                    <th style="text-align: center;"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($subscriptions as $data) { ?>
                                    <tr>
                                        <td><?php echo $this->Format->shortLength($data['User']['name'], 7, $data['User']['name']); ?></td>
                                        <td><?php echo $data['Subscription']['name']; ?></td>
                                        <td><?php echo $data['Subscription']['listing_period'] . " days"; ?></td>
                                        <td><?php echo (!empty($data['Subscription']['subscription_start'])) ? $this->Format->dateFormat($data['Subscription']['subscription_start']) : "NA"; ?></td>
                                        <td><?php echo (!empty($data['Subscription']['subscription_end'])) ? $this->Format->dateFormat($data['Subscription']['subscription_end']) : "NA"; ?></td>
                                        <td style="text-align: center;"><?php echo $this->Format->checkSubscription($data['Subscription']); ?></td>
                                        <td><?php echo $this->Format->dateFormat($data['Subscription']['created']); ?></td>
                                        <td style="text-align: center;">
                                            <?php if ($data['Subscription']['status'] == '3' || $this->Format->is_subscription_expired($data['Subscription']['subscription_start'], $data['Subscription']['listing_period'])) { ?>
													<span class="action_links" style="margin-left: 6px;">
                                                    <a href="<?php echo $this->Html->url(array("controller" => "subscriptions", "action" => "renew_subscription", "admin" => 1, $data['User']['id'], $data['Subscription']['id'])); ?>" rel="tooltip" title="Re-new Subscription" id="<?php echo $data['User']['id']; ?>" class=""><i class="fa  fa-repeat"></i></a>
                                                </span>
                                            <?php } ?>
                                            <span class="action_links" style="margin-left: 6px;">
                                                <a href="<?php echo $this->Html->url(array("controller" => "transactions", "action" => "index", "admin" => 1, $data['User']['id'], $data['Subscription']['id'])); ?>" rel="tooltip" title="View transcations" id="<?php echo $data['User']['id']; ?>" class="admin_view_transaction"><i class="fa fa-money"></i></a>
                                            </span>
                                            <?php if ($data['Subscription']['status'] != '2') { ?>
                                                <span class="action_links" style="margin-left: 6px;">
                                                    <a href="<?php echo $this->Html->url(array("controller" => "subscriptions", "action" => "cancel_subscription", "admin" => 1, $data['User']['id'], $data['Subscription']['id'])); ?>" rel="tooltip" title="Cancel subscription" class="admin_cancel_transaction"><i class="fa fa-ban"></i></a>
                                                </span>
                                            <?php } ?>
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
<?php echo $this->element('modal'); ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        table = $('#admin_subscriptions').DataTable({"paging": true, "lengthChange": true, "searching": true, "ordering": true, "info": true, "aaSorting": [], "aoColumnDefs": [{'bSortable': false, 'aTargets': [7]}, ]});
        table.on('draw', function () {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
    });
</script>