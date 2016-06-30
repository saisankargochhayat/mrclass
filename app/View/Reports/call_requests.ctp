<div class="booking_det">
    <div class="wrapper">
        <div class="content-left fl">
            <?php echo $this->element('user_inner_left_navbar'); ?>
        </div>
        <div class="fr upcom_book_cnt">
            <div class="bg-trns-white">
            <div class="up_mc_top1">
                <h2>Request a Call</h2>
                <div class="cb"></div>
            </div>
            <table id="call_requests_user" class="display listblocks-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><?php echo __('Name'); ?></th>
                        <th><?php echo __('Phone'); ?></th>
                        <th><?php echo __('Email'); ?></th>
                        <th><?php echo __('Created'); ?></th>
                        <th style="text-align: center;"><?php echo __('Actions'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact) { ?>
                        <tr>
                            <td>
                                <?php echo $this->Format->shortLength($contact['Contact']['name'],20,$contact['Contact']['name']); ?>
                            </td>
                            <td>
                                <?php echo $this->Format->formatPhoneNumber($contact['Contact']['phone']); ?>
                            </td>
                            <td>
                                <?php echo $this->Format->shortLength($contact['Contact']['email'],20,$contact['Contact']['email']); ?>
                            </td>
                            <td align="center"><?php echo $this->Format->dateFormat($contact['Contact']['created']); ?></td>
                            <td style="text-align: center;">
                                <span class="action_links">
                                    <a class="anchor call_del" data-id="<?php echo $contact['Contact']['id']; ?>" 
                                       data-username="<?php echo $contact['Contact']['name']; ?>" 
                                       id="delete_call_<?php echo $contact['Contact']['id']; ?>" rel="tooltip" 
                                       data-original-title="Delete Request">
                                        <i class="fa fa-trash" title="Delete"></i>
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
    $(document).ready(function () {
        var table = $('#call_requests_user').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [[3, 'desc']],
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [3]},
            ]
        });
        table.on('draw', function () {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());  
        });
        $("#call_requests_user").on('click','.call_del', function () {
                var obj = $(this);
                var id = obj.data('id')
                confirm("Are You Sure want to delete the call request from " + obj.data('username') + " ?",function(){
                    window.location.href = "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'delete_call_request')); ?>/"+id;
                    return false;
                });
                
        });
    });
</script>