<p>Dear <?php echo $name; ?>, </p>
<p>Thank you for showing interest in <?php echo Configure::read('COMPANY.NAME');?>. Your booking request has been received for <strong><?php echo $business['Business']['name']; ?></strong></p>
<p>Booking Details:</p>
<p>
<table style="max-width:100%; min-width: 50%;">
    <tr>
        <td><b>Reference Code </b></td><td>:</td>
        <td><?php echo $bookings['BusinessBooking']['reference_code']; ?></td>
    </tr>
    <tr>
        <td><b>Date </b></td><td>:</td>
        <td><?php echo $this->Format->dateFormat($bookings['BusinessBooking']['from_date']); ?>
            <?php
            if ($bookings['BusinessBooking']['to_date'] != '') {
                echo " to " . $this->Format->dateFormat($bookings['BusinessBooking']['to_date']);
            }
            ?>
        </td>
    </tr>
    <tr>
        <td><b>No. of Participants</b></td><td>:</td>
        <td><?php echo $bookings['BusinessBooking']['seats']; ?> </td>
    </tr>
</table>

</p>

<p><b>Details:</b></p>
<?php if (!empty($details)) { ?>   
    <p>
    <table style="max-width:100%; min-width: 50%;">
        <tr><th style="text-align: left;">Name</th><th></th><th style="text-align: left;">Age</th></tr>
                <?php foreach ($details as $val) { ?>   
            <tr><td><?php echo $val['name']; ?></td><td>:</td><td><?php echo $val['age']; ?></td></tr>
        <?php } ?>
    </table>
    </p>
<?php } ?>
<?php if (!empty($to) && $to == 'owner') { ?>
    <p>The following business booking request is waiting for your approval.</p>
    <p>Confirmation mail will be sent to user once the booking is approved. </p>
<?php } elseif (!empty($to) && $to == 'booker') { ?>
    <p>Confirmation mail will be sent to you once the booking is approved by the Business Owner. </p>
<?php } ?>
