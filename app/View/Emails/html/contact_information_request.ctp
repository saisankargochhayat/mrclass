<?php if ($for == "business_owner") { ?>
<p>Hello <?php echo $contact_person_name;?>,</p>
<?php }else{ ?>
<p>Hello Admin,</p>
<?php } ?>
<?php if ($for == "business_owner") { ?>
<p>We have received a contact information request from a user with information given below:</p>
<p>
<table style="width:100%;">
    <?php if (!empty($user_name)) { ?>
    <tr><td style="width:150px;"><b>Name</b></td><td>:</td><td><?php echo h($user_name); ?>
    </td></tr>
    <?php } ?>
    <?php if (!empty($user_email)) { ?>
        <tr><td><b>Phone / Email</b></td><td>:</td><td><?php echo h($user_email); ?></td></tr>
    <?php } ?>
    <?php if (!empty($user_phone)) { ?>
        <tr><td><b>Phone</b></td><td>:</td><td><?php echo h($user_phone); ?></td></tr>
    <?php } ?>
</table>
</p>
<?php }else{ ?>
<p>We have received a contact information request for Business:<?php echo $businessName;?> from a user with information given below:</p>
<p>
<table style="width:100%;">
    <?php if (!empty($user_name)) { ?>
    <tr><td style="width:150px;"><b>Name</b></td><td>:</td><td><?php echo h($user_name); ?>
    </td></tr>
    <?php } ?>
    <?php if (!empty($user_email)) { ?>
        <tr><td><b>Phone / Email</b></td><td>:</td><td><?php echo h($user_email); ?></td></tr>
    <?php } ?>
    <?php if (!empty($user_phone)) { ?>
        <tr><td><b>Phone</b></td><td>:</td><td><?php echo h($user_phone); ?></td></tr>
    <?php } ?>
</table>
</p>
<?php } ?>