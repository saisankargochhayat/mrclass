<div class="booking_det">
    <div class="wrapper">
        <div class="content-left fl">
            <?php echo $this->element('business_left_tab') ?>
        </div>
        <div class="fr upcom_book_cnt">
            <div class="bg-trns-white">
                <div class="up_mc_top1">
                    <h2>My Bookings</h2>
                    <div class="cb"></div>
                </div>
                
                <table id="my_booking_user" class="display listblocks-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:15%;"><?php echo __('Booked On'); ?></th>
                            <th style="width:25%;"><?php echo __('Class'); ?></th>
                            <th style="width:15%;"><?php echo __('Booking From'); ?></th>
                            <th style="width:15%;"><?php echo __('Booking To'); ?></th>
                            <th style="width:15%;"><?php echo __('#Seats'); ?></th>
                            <th style="width:15%;"><?php echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking) { ?>
                            <tr>
                                <td align="center"><?php echo $this->Format->dateFormat($booking['BusinessBooking']['created']); ?></td>
                                <td>
                                    <?php echo $this->Format->shortLength($booking['Business']['name'],20,$booking['Business']['name']); ?>
                                </td>
                                <td align="center"><?php echo $this->Format->dateFormat($booking['BusinessBooking']['from_date']); ?></td>
                                <td align="center">
                                    <?php echo strtotime($booking['BusinessBooking']['to_date']) > 0 ? "" . $this->Format->dateFormat($booking['BusinessBooking']['to_date']) : "---"; ?>
                                </td>
                                <td align="center"><?php echo $booking['BusinessBooking']['seats']; ?></td>
                                <td align="center">
                                    <?php if (($booking[0]['stats']) == 'Upcoming'){ ?>
                                        <span>
                                            <?php if (intval($booking['BusinessBooking']['approved']) == 1): ?>
                                                <i class="fa fa-check-square-o" title="Approved"></i>
                                            <?php else: ?>
                                                <i class="fa fa-exclamation-triangle" title="Pending"></i>
                                            <?php endif; ?>
                                        </span>
                                    <?php }else{ ?>
                                        <span class="action_links">
                                            <i class="fa fa-close" title="Expired"></i>
                                        </span>
                                    <?php } ?>
                                    <span class="action_links" style="margin-left: 10px;">
                                        <a class="anchor ajax" data-href="<?php echo $this->Html->url(array('action' => 'booking_detail', $booking['BusinessBooking']['id'])); ?>">
                                            <i class="fa fa-eye" title="View"></i>
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