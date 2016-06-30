<section class="content-header">
        <h1><?php echo 'Manage '.substr($path, 4).'s'; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="#"><?php echo substr($path, 4).'s'; ?></a></li>
        </ol>
    </section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo substr($path, 4).'s'; ?></h3>
                    <div class="box-tools pull-right" style="position:initial;width:220px">
                        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'add', 'admin' => 1, $path)); ?>" class="btn btn-block btn-primary btn-sm pull-left" style="display:inline-block;width:100px;"><i class="ion ion-person-add"></i>  <?php echo str_replace('_', ' ', $path); ?></a>
                        <?php /*<a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'users_export_modal', 'admin' => 1)); ?>" data-toggle="modal" data-target="#myUserExportModal" class="btn btn-flat btn-primary btn-sm pull-right" style="display:inline-block;width:100px;margin-top:0;padding:5px 0"><i class="fa fa-file-excel-o"></i>  <?php echo "Export"; ?></a>*/?>
                        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'user_reports_sheets', 'admin' => 1)); ?>" class="btn btn-flat btn-primary btn-sm pull-right" target="_blank" style="display:inline-block;width:100px;margin-top:0;padding:5px 0"><i class="fa fa-file-excel-o"></i>  <?php echo "Export"; ?></a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="usersList" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('Username / Email'); ?></th>
                                <th><?php echo __('Phone'); ?></th>
                                <th><?php echo __('City'); ?></th>
                                <th><?php echo __('Created'); ?></th>
                                <th><?php echo __('Last login'); ?></th>
                                <th><?php echo __('Status'); ?></th>
                                <th style="text-align:center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <?php 
                        foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $this->Format->shortLength($user['User']['name'], 10,$user['User']['name']); ?></td>
                            <td><?php echo $this->Format->shortLength($user['User']['email'], 30,$user['User']['email']); ?></td>
                            <td><?php echo $this->Format->formatPhoneNumber($user['User']['phone']); ?></td>
                            <td><?php echo h(is_numeric($user['User']['city'])?$user['City']['name']:$user['User']['city']); ?>&nbsp;</td>
                           
                            <td><?php echo $this->Format->dateFormat($user['User']['created']); ?></td>
                            <td>
                                <span rel="tooltip" data-placement="top" title="<?php echo $this->Format->lastLoginTimeText($this->Format->dateFormat($user['User']['last_login'], 'F j, Y \a\t g:i A')); ?>">
                                    <?php echo (strtotime($user['User']['last_login']) == 0) ? '--' : $this->Format->dateFormat($user['User']['last_login']); ?>
                                </span>
                            </td>
                            <td><?php echo ($user['User']['status'])?"Active":"Inactive"; ?></td>
                            <td style="text-align:center;">
                                <span class="action_links">
                                    <?php if($user['User']['status']): ?>
                                                <?php echo $this->Html->link('<i class="fa fa-user-times"></i> ', array('action' => 'admin_grant_user',$user['User']['id']),array('escape' => false,'class' => 'tip-top red-ico','rel'=>'tooltip','data-original-title'=>'Disable User')); ?>
                                    <?php else: ?>
                                                <?php echo $this->Html->link('<i class="fa fa-user-plus"></i> ', array('action' => 'admin_grant_user',$user['User']['id']),array('escape' => false,'class' => 'tip-top green-ico','rel'=>'tooltip','data-original-title'=>'Enable User')); ?>
                                    <?php endif;?>
                                </span>
                                <span class="action_links">
                                        <?php echo $this->Html->link('<i class="fa fa-pencil"></i> ', array('action' => 'edit','admin'=>1,$user['User']['id']),array('escape' => false,'class' => 'tip-top','rel'=>'tooltip','data-original-title'=>'Edit')); ?>
                                </span>
                                <span class="action_links">
                                        <?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'fa fa-trash-o fa-fw')) . "",array('action' => 'delete',$user['User']['id']),array( 'escape' => false,'rel'=>'tooltip','data-original-title'=>'Delete','confirm' => __('Are you sure you want to delete # %s?', $user['User']['name'])));?>
                                </span>
                                <span class="action_links">
                                        <?php echo $this->Html->link('<i class="fa fa-eye"></i> ', array('action' => 'view', $user['User']['id']),array('escape' => false,'rel'=>'tooltip','data-original-title'=>'View User')); ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tfoot>
                            <tr>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('Email'); ?></th>
                                <th><?php echo __('Phone'); ?></th>
                                <th><?php echo __('City'); ?></th>
                                <th><?php echo __('Created'); ?></th>
                                <th><?php echo __('Last login'); ?></th>
                                <th><?php echo __('Status'); ?></th>
                                <th style="text-align:center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<?php echo $this->element('modal'); ?>
<script>
    $(document).ready(function () {
        page_no = getCookie(CONTROLLER+ACTION+'page_no');
        page_limit = getCookie(CONTROLLER+ACTION+'page_limit');
        page_sort = getCookie(CONTROLLER+ACTION+'page_sort');
        //removeCookie(CONTROLLER+ACTION+'page_no');
        
        table = $('#usersList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "pageLength": !isNaN(parseInt(page_limit))?(parseInt(page_limit)):10,
            "aaSorting": page_sort ? [page_sort.split(',')]:[],//[4, 'desc']
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [6]},
            ]
        });
        table.on('draw', function () {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());  
        });
        $('.table tr:eq(0) th').click(function (e) {
            !isNaN(parseInt(page_no)) ? table.page(parseInt(page_no)).draw(false) : "";
        });
        !isNaN(parseInt(page_no))?table.page(parseInt(page_no)).draw(false):"";
    });
</script>