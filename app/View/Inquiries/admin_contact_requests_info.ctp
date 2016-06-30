<style type="text/css">
    .box{min-height: 450px;}
    .links{cursor: pointer;}
</style>
<section id="ajax_div">
    <section class="content-header">
        <h1><?php echo __('Contact Information Requests'); ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'inquiries', 'action' => 'contact_requests_info', 'admin' => 1)); ?>">Contact Information Requests</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo __('Contact Information Requests'); ?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="admin_contact_number_req"class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo __('Business Name'); ?></th>
                                    <th><?php echo __('Category'); ?></th>
                                    <th><?php echo __('Address'); ?></th>
                                    <th><?php echo __('No Of Requests'); ?></th>
                                    <?php /*?><th><?php echo __('Created'); ?></th><?php */?>
                                    <th style="text-align: center;"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php foreach ($requester_data as $data) { ?>
                            <?php $mark_mode = (intval($data[0]['is_complete']) === intval($data[0]['number_of_request'])) ? "restore" : "markcomplete"; ?>
                            <tr class="<?php echo $mark_mode;?> <?php echo intval($data[0]['is_complete']);?>">
                                <td><?php echo $this->Format->shortLength($data['Business']['name'], 30,$data['Business']['name']); ?></td>
                                <td><?php echo (!empty($data['Business']['categories'])) ? $this->Format->shortLength($data['Business']['categories'], 15,$data['Business']['categories']) : ""; ?></td>
                                <td><?php echo $this->Format->shortLength($this->Format->addressComplete($data['City']['name'],$data['Locality']['name'],$data['Business']['address'], $data['Business']['landmark'],$data['Business']['pincode']),48,$this->Format->addressComplete($data['City']['name'],$data['Locality']['name'],$data['Business']['address'], $data['Business']['landmark'],$data['Business']['pincode'])); ?></td>
                                <td><?php echo $data[0]['number_of_request']; ?></td>
                                <?php /*?><td><?php echo $this->Format->dateTimeFormat($data['ContactNumberRequest']['created']); ?></td><?php */?>
                                <td style="text-align: center;">
                                    <span class="action_links" style="margin-left: 5px;">
                                        <a href="<?php echo $this->Html->url(array("controller" => "inquiries","action" => "group_request_delete","admin" => 1,$data['ContactNumberRequest']['user_id'],$data['ContactNumberRequest']['business_id']));?>" rel="tooltip" title="Delete" data-id="<?php echo $data['ContactNumberRequest']['id']; ?>" id="<?php echo $data['ContactNumberRequest']['id']; ?>" onclick="if (confirm(&quot;Are you sure you want to delete the contact information request ?&quot;)) { return true; } return false;" class="admin_del_contact_number_req"><span class="fa fa-trash-o"></span></a>
                                    </span>
                                    <span class="action_links" style="margin-left: 5px;">
                                        <a href="<?php echo $this->Html->url(array("controller" => "inquiries","action" => "contact_number_requests","admin" => 1,$data['ContactNumberRequest']['user_id'],$data['ContactNumberRequest']['business_id']));?>" rel="tooltip" data-original-title="View all contact number requests for this business"><i class="fa fa-eye"></i></a>
                                    </span>
                                    <span class="action_links" style="margin-left: 5px;">
                                        <a data-id="<?php echo $data['ContactNumberRequest']['id']; ?>" data-bid="<?php echo $data['Business']['id']; ?>" data-state="<?php echo $mark_mode;?>" data-mode="contact_information_request" rel="tooltip" data-original-title="<?php echo $mark_mode=='restore'?"Restore All":"Mark Complete All";?>" class="links anchor">
                                             <?php if((intval($data[0]['is_complete']) === intval($data[0]['number_of_request']))){ ?>
                                                 <span class="ion ion-refresh"></span>
                                             <?php }else{ ?>
                                                 <span class="ion ion-checkmark"></span>
                                             <?php } ?>
                                         </a>
                                    </span>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="overlay" style="display:none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
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
                    {'bSortable': false, 'aTargets': [4]},
                ]
            });
    table.on('draw', function () {
        var body = $(table.table().body());
        body.unhighlight();
        body.highlight(table.search());
    });

    $(document).on('click', '.links', function () {
        var _this = $(this);
        var mode = _this.attr('data-state');
        var business_id = _this.attr('data-bid');
        var confirm_text = (trim(mode) == "restore") ? "restore all" : "mark complete all";
            $('.overlay').show();
            var params = {'business_id': business_id,'mode':mode};
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'mark_complete_all', 'admin' => 1)); ?>",
                data: params,
                method: 'post',
                dataType: 'json',
                success: function (response) {
                    $('.overlay').hide();
                    if (response.success) {
                        _this.attr('data-state', (trim(mode) == 'restore') ? "markcomplete" : "restore");
                        _this.attr('data-original-title', (trim(mode) == "restore") ? "Mark complete all" : "Restore all");
                        _this.find('span').attr('class', (trim(mode) == "restore") ? "ion ion-checkmark" : "ion ion-refresh");
                        _this.closest('tr').removeClass((trim(mode) == "restore") ? "restore" : "markcomplete").addClass((trim(mode) == "restore") ? "markcomplete" : "restore");
                        alert((trim(mode) == "restore") ? "All contact requests restored successfully" : "All contact requests marked complete successfully");
                    }
                }
            });
    });
});

</script>