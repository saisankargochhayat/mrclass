<div class="booking_det">
    <div class="wrapper">
        <div class="content-left fl">
            <?php echo $this->element('business_left_tab') ?>
        </div>
        <div class="fr upcom_book_cnt">
            <div class="bg-trns-white">
                <div class="up_mc_top">
                    <h2>Recently Viewed Classes</h2>
                    <div class="cb"></div>
                </div>
                <div class="cnt_bx_upcom">
                    <table id="my_booking_user" class="display listblocks-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width:90%;" align="left"><?php echo __('Class'); ?></th>
                                <th style="width:10%;text-align: center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($view_data as $views) { ?>
                                <tr>
                                    <td>
                                        <?php echo $this->Format->shortLength($views['Business']['name'],20,$views['Business']['name']); ?>
                                    </td>
                                    <td align="center">
                                        <?php echo $this->Html->link('', $this->Format->business_detail_url($views['Business']), array('target' => '_blank', 'class' => 'fa fa-eye', 'title' => 'View')); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="cb"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#my_booking_user').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [], //[0, 'desc']
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': []},
            ]
        });
        table.on('draw', function() {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
    });
</script>