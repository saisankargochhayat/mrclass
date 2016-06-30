<?php if (isset($for) && $for == 'user') { ?>
    <p>Dear <?php echo $name; ?>,</p>
<?php } else { ?>
    <p>Dear Admin,</p>
<?php } ?>
<?php if (isset($for) && $for == 'user') { ?>
    <p>Your Booking request for <b><?php echo $businessName; ?></b> has been <?php echo $status; ?>.</p>
<?php } else { ?>
    <p>Booking request for <b><?php echo $businessName; ?></b> has been <?php echo $status; ?> by business owner.</p>
<?php } ?>
<p>Here are the details about this booking:</p>
<p>
<table style="width:100%">
    <tr>
        <td><b>Business name</b></td><td>:</td>
        <td><?php echo h($businessName); ?></td>
    </tr>
    <?php if (isset($for) && $for == 'admin') { ?>
        <tr>
            <td><b>Booked by</b></td><td>:</td>
            <td><?php echo h($name); ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td><b>Booking dates</b></td><td>:</td>
        <td><?php echo date('M d, Y', strtotime($start)); ?>
            <?php echo strtotime($end) > 0 ? " to " . date('M d, Y', strtotime($end)) : ""; ?>
        </td>
    </tr>
    <tr>
        <td><b>Number of seats</b></td><td>:</td>
        <td><?php echo h($seats); ?></td>
    </tr>
</table>
</p>
<?php if (isset($for) && $for == 'user') { ?>
    <p>Thanks for your time.</p>
<?php } ?>