<p>Hello Admin,</p>
<p>We have a query from an user with the following information:</p>
<p>
<table style="width: 100%;">
    <tr><td style="width:170px;"><b>Subject</b></td> <td>:</td><td><?php echo h($subject); ?></td></tr>
    <tr><td><b>Name</b></td> <td>:</td><td><?php echo $name; ?></td></tr>
    <tr><td><b>Email / Phone Number</b></td> <td>:</td><td><?php echo $email; ?></td></tr>
    <?php if(trim($message)!=''):?>
        <tr><td><b>Message</b></td> <td>:</td><td><?php echo h($message); ?></td></tr>
    <?php endif;?>
</table>
</p>