<p>Dear <?php echo $name; ?>,</p>
<p>Call request received for <?php echo $business['Business']['name']; ?>.</p>
<p>Request Details:</p>
<p>
<table style="width: 100%;">
    <tr><td style="width:70px;"><b>Name</b></td> <td>:</td><td><?php echo h($call['name']); ?></td></tr>
    <?php if(trim($call['phone'])!=''): ?>
        <tr><td><b>Phone</b></td> <td>:</td><td><?php echo h($call['phone']); ?></td></tr>
    <?php endif; ?>
    <?php if(trim($call['email'])!=''): ?>
        <tr><td><b>Email</b></td> <td>:</td><td><?php echo h($call['email']); ?></td></tr>
    <?php endif; ?>
</table>

</p>

<?php if (isset($extra) && $extra == 'user') { ?>
    <p>Thanks for your time. You will be contacted soon.</p>
<?php }elseif (isset($extra) && $extra == 'owner') { ?>
    <p>The request is waiting for your response.</p>
<?php } ?>