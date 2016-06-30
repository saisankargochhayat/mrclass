<p>Dear <?php echo $name; ?>, </p>
<p>A new Business – <b>"<?php echo $business['Business']['name']; ?>"</b> has been created by <b>"<?php echo $this->Session->read('Auth.User.name'); ?>"</b></p>
<p>Business creation Date: <?php echo date('M d, Y'); ?></p>
<p>The Business needs to approve before available. Please login to admin panel
    <a href="<?php echo $adminpanel_dashboard_link ?>" target="_blank"><?php echo Configure::read('COMPANY.NAME'); ?></a> to approve the Business.</p>
<p>Confirmation mail will be sent to business owner once the business is approved by you. </p>