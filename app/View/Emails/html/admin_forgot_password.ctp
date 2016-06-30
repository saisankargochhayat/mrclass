<p> Dear <?php echo $name; ?>, </p>
<p>We have received your request for reset password.</p>
<p>To reset, please click the button below.</p>
<?php $url = $urlValue;?>
<p><div style="text-align:center">
    <a style="display:inline-block;padding:10px 20px;color:#333;background:#FFB248;font-size:16px;border-radius:5px;margin-top:20px;text-decoration:none;" 
       href="<?php echo $url ?>" target='_blank'>
        Reset Password
    </a></div>
</p>
<p>Or open below URL in your browser:</p>
<p><a href="<?php echo $url ?>" target="_blank"><?php echo $url ?></a></p>