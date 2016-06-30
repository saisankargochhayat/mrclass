<p>Dear <?php echo $name; ?>,</p>
<?php if ($business_status == 'enabled') { ?>
    <p>Thank you for creating a Business – <b>"<?php echo h($businessName); ?>"</b> with us.</p>
    <p>Your business has been approved and active.</p>
<?php } else { ?>
    <p>We regret to inform you that your business <b>"<?php echo h($businessName); ?>"</b> has been disapproved due to some misinformation.</p>
    <p>Sorry for the inconvenience caused, please contact admin for details.</p>
<?php } ?>
<p>Thanks for your time.</p>