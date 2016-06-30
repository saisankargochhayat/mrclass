<style>
    .action_links{margin:0 0 0 2px;}
</style>
<div class="booking_det">
    <div class="wrapper">
        <div class="content-left fl">
            <?php echo $this->element('user_inner_left_navbar'); ?>
        </div>
        <div class="fr upcom_book_cnt">
            <div class="bg-trns-white">
                <div class="up_mc_top1">
                    <h2>Booking Requests</h2>
                    <div class="cb"></div>
                </div>
                <table id="bookings_user" class="display listblocks-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:15%;"><?php echo __('Booked On'); ?></th>
                            <th style="width:20%;"><?php echo __('User'); ?></th>
                            <th style="width:20%;"><?php echo __('Class'); ?></th>
                            <th style="width:15%;"><?php echo __('Booking From'); ?></th>
                            <th style="width:15%;"><?php echo __('Booking To'); ?></th>
                            <th style="width:10%;"><?php echo __('#Seats'); ?></th>
                            <th style="width:5%;text-align: center;"><?php echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking) { ?>
                            <tr>
                                <td align="center"><?php echo $this->Format->dateFormat($booking['BusinessBooking']['created']); ?></td>
                                <td>
                                    <?php echo $this->Format->showUsername($booking['User']['name'],15); ?>
                                </td>
                                <td>
                                    <?php echo $this->Format->showUsername($booking['Business']['name'],15); ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo $this->Format->dateFormat($booking['BusinessBooking']['from_date']); ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo strtotime($booking['BusinessBooking']['to_date']) > 0 ? "" . $this->Format->dateFormat($booking['BusinessBooking']['to_date']) : "---"; ?>
                                </td>
                                <td style="text-align: center;"><?php echo $booking['BusinessBooking']['seats']; ?></td>
                                <td style="text-align: center;">
                                    <?php $BusinessBookingId = $booking['BusinessBooking']['id']; ?>
                                    <?php if (($booking[0]['stats']) == 'Upcoming'){ ?>
                                        <span class="action_links">
                                            <?php if (intval($booking['BusinessBooking']['approved']) == 1): ?>
                                                <a class="anchor" href="<?php echo $this->Html->url(array('action' => 'grant_bookings', $BusinessBookingId)); ?>">
                                                    <i class="fa fa-ban" title="Decline  Request"></i>
                                                </a>
                                            <?php else: ?>
                                                <a class="anchor" href="<?php echo $this->Html->url(array('action' => 'grant_bookings', $BusinessBookingId)); ?>">
                                                    <i class="fa fa-check-square-o"  title="Approve Request"></i>
                                                </a>
                                            <?php endif; ?>
                                        </span>
                                    <?php }else{ ?>
                                        <span class="action_links">
                                            <i class="fa fa-close" title="Expired"></i>
                                        </span>
                                    <?php } ?>
                                    <span class="action_links">
                                        <a class="anchor ajax" data-href="<?php echo $this->Html->url(array('action' => 'booking_detail', $BusinessBookingId)); ?>">
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
        var table = $('#bookings_user').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [], //[0, 'desc']
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [6]},
            ]
        });
        table.on('draw', function() {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
    });
</script>