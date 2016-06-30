<style type="text/css">
    .box{        min-height: 450px;    }
</style>
<section id="ajax_div">
    <section class="content-header">
        <h1><?php echo __('Contact Information Requests Details'); ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'inquiries', 'action' => 'contact_requests_info', 'admin' => 1)); ?>">Contact Information Requests</a></li>
            <li><a href="javascript:void(0)">Details</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo __('Contact Information Requests Details'); ?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="admin_contact_number_req"class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo __('Business Name'); ?></th>
                                    <th><?php echo __('Address'); ?></th>
                                    <th><?php echo __('User'); ?></th>
                                    <th><?php echo __('Email'); ?></th>
                                    <?php /*?><th><?php echo __('Phone'); ?></th><?php */?>
                                    <?php /*?><th><?php echo __('City'); ?></th>?php */?>
                                    <th><?php echo __('Created'); ?></th>
                                    <th style="text-align: center;"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php foreach ($requester_data as $data) { ?>
                            <?php $mark_mode = (intval($data['ContactNumberRequest']['is_complete'])==1)?"restore":"markcomplete"; ?>
                            <tr class="<?php echo $mark_mode;?>">
                                <td><?php echo $this->Format->shortLength($data['Business']['name'], 30,$data['Business']['name']); ?></td>
                                <td><?php echo $this->Format->shortLength($this->Format->addressComplete($data['City']['name'],$data['Locality']['name'],$data['Business']['address'], $data['Business']['landmark'],$data['Business']['pincode']),30,$this->Format->addressComplete($data['City']['name'],$data['Locality']['name'],$data['Business']['address'], $data['Business']['landmark'],$data['Business']['pincode'])); ?></td>
                                <td><?php echo $data['User']['name']; ?></td>
                                <td><?php echo $data['User']['email']; ?></td>
                                <?php /*?><td><?php echo $this->Format->formatPhoneNumber($data['User']['phone']); ?></td><?php */?>
                                <?php /*?><td><?php echo $data['City']['name']; ?></td>?php */?>
                                <td><?php echo $this->Format->dateTimeFormat($data['ContactNumberRequest']['created']); ?></td>
                                <td style="text-align: center;">
                                <span class="action_links">
                                        <a data-id="<?php echo $data['ContactNumberRequest']['id']; ?>" data-state="<?php echo $mark_mode;?>" data-mode="contact_information_request" id="mark_complete_conreq_<?php echo $data['ContactNumberRequest']['id']; ?>" 
                                            rel="tooltip" data-original-title="<?php echo $mark_mode=='restore'?"Restore":"Mark Complete";?>"
                                            class="mark_complete_conreq anchor">
                                             <?php if(intval($data['ContactNumberRequest']['is_complete'])==1){ ?>
                                                 <span class="ion ion-refresh"></span>
                                             <?php }else{ ?>
                                                 <span class="ion ion-checkmark"></span>
                                             <?php } ?>
                                         </a>
                                    </span>
                                    <span class="action_links" style="margin-left: 10px;">
                                        <a href="<?php echo $this->Html->url(array("controller" => "inquiries","action" => "contact_request_delete","admin" => 1,$data['ContactNumberRequest']['id'],$data['ContactNumberRequest']['user_id'],$data['ContactNumberRequest']['business_id']));?>" rel="tooltip" title="Delete" data-id="<?php echo $data['ContactNumberRequest']['id']; ?>" id="<?php echo $data['ContactNumberRequest']['id']; ?>" onclick="if (confirm(&quot;Are you sure you want to delete the contact information request ?&quot;)) { return true; } return false;" class="admin_del_contact_number_req">
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
    table = $('#admin_contact_number_req').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [5]},
                ]
            });
    table.on('draw', function () {
        var body = $(table.table().body());
        body.unhighlight();
        body.highlight(table.search());
    });
});
    var page_name = "contact_information_request";
    var act_url = "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'mark_complete')); ?>";
</script>