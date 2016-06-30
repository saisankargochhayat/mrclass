<p>Dear <?php echo $name; ?>,</p>
<?php if ($status == 'enabled') { ?>
    <p>Thank you for creating a event – <b>"<?php echo h($eventname); ?>"</b> with us.</p>
    <p>Your event has been approved and active.</p>
<?php } else { ?>
    <p>We regret to inform you that your event <b>"<?php echo h($eventname); ?>"</b> has been disapproved due to some misinformation.</p>
    <p>Sorry for the inconvenience caused, please contact admin for details.</p>
<?php } ?>
<p>Thanks for your time.</p>