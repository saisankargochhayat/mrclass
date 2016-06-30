<p>Dear <?php echo $name; ?>,</p>
<p>Welcome to <a href="<?php echo HTTP_ROOT; ?>" target="_blank"><?php echo Configure::read('COMPANY.NAME'); ?></a></p>
<p>Congrats! Your <?php echo Configure::read('COMPANY.NAME'); ?> account has been provisioned successfully.</p>
<p>Click below to access your account and get started.</p>
<p><div style="text-align:center;">
    <a style="display:inline-block;padding:10px 20px;color:#333;background:#FFB248;font-size:16px;border-radius:5px;margin-top:20px;text-decoration:none;" 
       href="<?php echo HTTP_ROOT; ?>" target='_blank'>
       Access your Account
    </a></div>
</p>
