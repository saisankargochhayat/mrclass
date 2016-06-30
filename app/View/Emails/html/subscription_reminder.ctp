<p>Hello <?php echo h($name)?>,</p>
<p>Your subscription package <?php echo h($packageName)?> is about to expire in <?php echo h($daysBefore)?> days on <?php echo h($this->Format->dateFormat($subscriptionEnd))?>. </p>
<p>Please upgrade your subscription package to keep connected with MrClass.</p>
<p> Thanks for your time.</p>