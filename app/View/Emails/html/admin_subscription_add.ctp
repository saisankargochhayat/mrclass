<p> Dear <?php echo $name; ?>, </p><br/>
<?php if($status == "active"){?>
	<p>You have subscribed to "<?php echo $Subscription['name']; ?>" package, and it is active.</p><br/>
<?php }else{?>
	<p>You have subscribed to "<?php echo $Subscription['name']; ?>" package, and your subscription will be active upon admin's approval of your business.</p><br/>
<?php }?>
<p>Subscription Details:</p>
<p>
<table style="max-width:100%; min-width: 50%;">
    <tr>
        <td><b>Subscription Name </b></td><td>:</td>
        <td><?php echo $Subscription['name']; ?></td>
    </tr>
    <tr>
        <td><b>Subscription Period </b></td><td>:</td>
        <td><?php echo $days . " days (".$month." Months)"; ?></td>
    </tr>
	<?php if($status == "active"){?>
		<tr>
			<td><b>Subscription Start Date </b></td><td>:</td>
			<td><?php echo $this->Format->dateFormat($Subscription['subscription_start']);?></td>
		</tr>
		<tr>
			<td><b>Subscription End Date</b></td><td>:</td>
			<td><?php echo $this->Format->dateFormat($Subscription['subscription_end']);?></td>
		</tr>
	<?php }?>
    <tr>
        <td><b>No. of Businesses Limit</b></td><td>:</td>
        <td><?php echo $Subscription['subscription']; ?> </td>
    </tr>
</table>
</p><br/>
<p>Thanks for your time.</p>