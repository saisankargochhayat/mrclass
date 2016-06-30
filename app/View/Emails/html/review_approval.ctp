<?php if (isset($for) && $for == 'user') { ?>
    <p>Dear <?php echo $name; ?>,</p>
<?php } else { ?>
    <p>Dear Admin,</p>
<?php } ?>
<?php if (isset($for) && $for == 'user') { ?>
    <p>Your Review for <b><?php echo $businessName; ?></b> has been approved.</p>
<?php } else { ?>
    <p>Review for <b><?php echo $businessName; ?></b> has been approved by business owner.</p>
<?php } ?>
<p>Here are the details about this review:</p>
<p><table style="width:100%;">
    <tr>
        <td>Business name</td><td>:</td>
        <td><?php echo $businessName; ?></td>
    </tr>
    <?php if (isset($for) && $for == 'admin') { ?>
        <tr>
            <td>Reviewed by</td><td>:</td>
            <td><?php echo $name; ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td>Reviewed on</td><td>:</td>
        <td><?php echo date('M d, Y', strtotime($created)); ?></td>
    </tr>
</table>
</p>