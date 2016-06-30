<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Manage Presses
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#"><?php echo __('Presses'); ?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('Presses'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo $this->Html->url(array('controller' => 'presses', 'action' => 'add', 'admin' => 1)); ?>" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus"></i>  <?php echo __('Add Press'); ?></a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="pressTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo __('Title'); ?></th>
                                <th><?php echo __('Source'); ?></th>
                                <th><?php echo __('Link'); ?></th>
                                <th><?php echo __('Published'); ?></th>
                                <th><?php echo __('Status'); ?></th>
                                <th class="actions" style="text-align:center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($presses as $press): ?>
                                <tr>
                                    <td><?php echo h($press['Press']['name']); ?>&nbsp;</td>
                                    <td><?php echo h($press['Press']['source']); ?>&nbsp;</td>
                                    <td style="text-align:center;"><a href="<?php echo $this->Format->validate_url($press['Press']['link']); ?>" target="_blank">View</a>&nbsp;</td>
                                    <td><?php echo date("M d, Y", strtotime($press['Press']['published_date'])); ?>&nbsp;</td>
                                    <td style="text-align:center;"><?php echo h($press['Press']['status']==1?"Active":"Inactive"); ?>&nbsp;</td>
                                    <td class="actions" style="text-align:center;">
                                        <?php if (intval($press['Press']['status']) == 1): ?>
                                            <?php echo $this->Html->link('<i class="fa fa-ban fa-fw"></i> ', array('action' => 'admin_change_status', $press['Press']['id'], 0), array('escape' => false, 'rel' => 'tooltip', 'data-original-title' => 'Disable')); ?>
                                        <?php else: ?>
                                            <?php echo $this->Html->link('<i class="fa fa-check-square-o"></i> ', array('action' => 'admin_change_status', $press['Press']['id'], 1), array('escape' => false, 'rel' => 'tooltip', 'data-original-title' => 'Enable')); ?>
                                        <?php endif; ?>
                                        
                                        <?php #echo $this->Html->link(__('View'), array('action' => 'view', $press['Press']['id'])); ?>
                                        <?php echo $this->Html->link('', array('action' => 'edit', $press['Press']['id']),array('class'=>'fa fa-pencil')); ?>
                                        <?php echo $this->Form->postLink('', array('action' => 'delete', $press['Press']['id']), array('confirm' => __('Are you sure you want to delete this record?', $press['Press']['id']),'class'=>'fa fa-trash-o fa-fw')); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<?php #echo $this->element('modal'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#pressTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [[0, 'asc']],
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [5]},
            ]
        });
        table.on('draw', function() {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
    });
</script>
