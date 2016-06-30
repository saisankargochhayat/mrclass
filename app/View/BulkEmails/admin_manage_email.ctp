<style type="text/css">
    .box{        min-height: 450px;    }
</style>
<section id="ajax_div">
    <section class="content-header">
        <h1><?php echo __('Sent Emails'); ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'bulk_emails', 'action' => 'manage_email', 'admin' => 1)); ?>">Sent Emails</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo __('All Sent Emails'); ?></h3>
                        <div class="box-tools pull-right" style="position:initial;width:220px">
                        <a href="<?php echo $this->Html->url(array('controller' => 'bulk_emails', 'action' => 'send_bulk_email', 'admin' => 1)); ?>" class="btn btn-flat btn-primary btn-sm pull-right"><i class="fa fa-envelope"></i>  <?php echo "Send New Email"; ?></a>
                    </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="admin_sent_emails"class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo __('Sent On'); ?></th>
                                    <th><?php echo __('No Of Recipients'); ?></th>
                                    <th><?php echo __('No Of Attachments'); ?></th>
                                    <th style="text-align: center;"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php foreach ($all_mails as $data) { ?>
                            <?php //$mark_mode = (intval($data['ContactNumberRequest']['is_complete'])==1)?"restore":"markcomplete"; ?>
                            <tr>
                                <td><?php echo $this->Format->dateTimeFormat($data['BulkEmail']['created']); ?></td>
                                <td><?php echo count($data['BulkEmailReceiver']);?></td>
                                <td><?php echo count($data['BulkEmailAttachment']);?></td>
                                <td style="text-align: center;">
                                <?php /*?><span class="action_links">
                                        <a data-id="<?php echo $data['BulkEmail']['id']; ?>" data-state="<?php echo $mark_mode;?>" data-mode="manage_email" id="mark_complete_conreq_<?php echo $data['BulkEmail']['id']; ?>" 
                                            rel="tooltip" data-original-title="<?php echo $mark_mode=='restore'?"Restore":"Mark Complete";?>"
                                            class="mark_complete_conreq anchor">
                                             <?php if(intval($data['BulkEmail']['is_complete'])==1){ ?>
                                                 <span class="ion ion-refresh"></span>
                                             <?php }else{ ?>
                                                 <span class="ion ion-checkmark"></span>
                                             <?php } ?>
                                         </a>
                                    </span><?php */?>
                                    <span class="action_links" style="margin-left: 10px;">
                                        <a href="<?php echo $this->Html->url(array("controller" => "bulk_emails","action" => "admin_email_attachment_delete","admin" => 1,$data['BulkEmail']['id']));?>" rel="tooltip" title="Delete" data-id="<?php echo $data['BulkEmail']['id']; ?>" id="<?php echo $data['BulkEmail']['id']; ?>" onclick="if (confirm(&quot;Are you sure you want to delete the email?&quot;)) { return true; } return false;" class="admin_del_manage_email">
                                            <span class="fa fa-trash-o"></span>
                                        </a>
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
    table = $('#admin_sent_emails').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [3]},
                ]
            });
    table.on('draw', function () {
        var body = $(table.table().body());
        body.unhighlight();
        body.highlight(table.search());
    });
});
</script>