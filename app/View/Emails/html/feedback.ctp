<p>Hello Admin,</p>
<p>We have received a feedback/request from a user with information given below:</p>
<p>
<table style="width:100%;">
    <?php if (!empty($name)) { ?>
    <tr><td style="width:150px;"><b>Name</b></td><td>:</td><td><?php echo h($name); ?></td></tr>
    <?php } ?>
    <?php if (!empty($number_email)) { ?>
        <tr><td><b>Phone / Email</b></td><td>:</td><td><?php echo h($number_email); ?></td></tr>
    <?php } ?>
    <?php if (!empty($number)) { ?>
        <tr><td><b>Phone</b></td><td>:</td><td><?php echo h($number); ?></td></tr>
    <?php } ?>
    <?php if (!empty($email)) { ?>
        <tr><td><b>Email</b></td><td>:</td><td><?php echo h($email); ?></td>
        </tr>
    <?php } ?>
    <?php if (!empty($message)) { ?>
        <tr><td><b>Message</b></td><td>:</td><td><?php echo nl2br($message); ?></td>
        </tr>
    <?php } ?>
    <?php if (!empty($feedback_type)) { ?>
        <tr><td><b>Feedback type</b></td><td>:</td><td><?php echo h($feedback_type); ?></td></tr>
    <?php } ?>
    <?php /* if (!empty($message)) { ?>
      <tr><td>Suggestion</td><td><?php echo h($message); ?></td></tr>
      <?php } */ ?>
</table>
</p>