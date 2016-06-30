<p>Hello <?php echo h($name); ?>,</p>
<?php if (isset($extra) && $extra == 'inquiry') { ?>
    <p>Thanks for your time & for writing to us. We will take your inquiry in consideration. You will be contacted soon.</p>
    <p>Keep writing to us.</p>
<?php } else { ?>
    <p>Thanks for your time & for writing to us. We will take your feedback in consideration.</p>
    <p>Keep writing to us.</p>
    <?php
}?>