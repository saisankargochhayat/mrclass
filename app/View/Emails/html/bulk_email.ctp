<p> Dear <?php echo $name; ?>, </p><br/>
<div><?php echo $desc; ?></div>
<?php if (isset($downlod_urls) && !empty($downlod_urls)) {?>
<div>To download the attachments, click on the below url addresses.
    <?php foreach ($downlod_urls as $key => $value) {?>
    <p><a href="<?php echo $value; ?>" target="_blank"><?php echo $file_names[$key];?></a></p>
    <?php }?>
</div>
<?php }?>
