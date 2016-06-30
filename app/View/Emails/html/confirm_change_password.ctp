<p>Dear <?php echo $name; ?>, </p>
<p>Your password is updated successfully. To continue please click on below button and login with your credentials to sign in.</p>
<p>
    <div style="text-align:center;">
        <a style="display:inline-block;padding:10px 20px;color:#333;background:#FFB248;font-size:16px;border-radius:5px;margin-top:20px;text-decoration:none;" 
           href="<?php echo $url ?>" target='_blank'>Sign In</a>
    </div>
</p>
<p>Or open the URL given below, in your browser:</p>
<a href="<?php echo $url ?>" target="_blank"><?php echo $url ?></a>