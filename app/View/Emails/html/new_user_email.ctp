<?php $url = $urlValue; ?>
<p>Dear <?php echo $name; ?>,</p>
<p>Thank you for using <b><?php echo Configure::read('COMPANY.NAME'); ?></b></p>
<p>Your account has been created with <a href="<?php echo HTTP_ROOT; ?>" target="_blank"><?php echo Configure::read('COMPANY.NAME'); ?></a>.
    <?php if (isset($from) && $from == 'admin') {
        echo "";
    } else {
        echo "To activate your account click on the below given URL Or open URL in your browser";
    } ?>.</p>
<?php if (!isset($from) || $from != 'admin') { ?>
    <p><a href="<?php echo $url ?>" target="_blank"><?php echo $url ?></a></p>
<?php } ?>
<p>Your login credentials are as below:</p>
<p>
<table style="width: 100%;">
    <tr>
        <td><b>Username</b></td> <td>:</td><td><?php echo $userName; ?></td>
    </tr>
    <tr>
        <td><b>Password</b></td> <td>:</td><td><?php echo $password; ?></td>
    </tr>
</table>
</p>
