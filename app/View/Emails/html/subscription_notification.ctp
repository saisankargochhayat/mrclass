<?php if($for == "User"){?>
<p> Dear <?php echo $name; ?>, </p><br/>
<?php }else{?>
<p> Dear admin, </p><br/>
<?php }?>
<?php if($for == "User"){?>
	<?php if($status == "active"){?>
		<p>You subscription has been <?php echo $type; ?> to "<?php echo $Subscription['name']; ?>" package, and it is active.</p><br/>
	<?php }else{?>
		<p>You subscription has been <?php echo $type; ?> to "<?php echo $Subscription['name']; ?>" package, and your subscription will be active upon admin's approval of your business.</p><br/>
	<?php }?>
<?php }else{?>
	<p><?php echo $name; ?> was <?php echo $type; ?> his subscription from "<?php echo $packageName; ?>" to "<?php echo $Subscription['name']; ?>".</p><br/>
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
<p>Transaction Details:</p>
<p>
<table style="max-width:100%; min-width: 50%;">
    <tr>
        <td><b>Sub-total amount</b></td><td>:</td>
        <td><?php echo $Transaction['sub_total']; ?></td>
    </tr>
	<?php if(intval($Transaction['final_price']) > 0){?>
		<tr>
			<td><b>Discount amount</b></td><td>:</td>
			<td><?php echo $Transaction['discount'];?></td>
		</tr>
		<tr>
			<td><b>Total amount</b></td><td>:</td>
			<td><?php echo $Transaction['final_price'];?></td>
		</tr>
		<?php }else{?>
		<tr>
			<td><b>Carry forward amount</b></td><td>:</td>
			<td><?php echo $Transaction['discount'];?></td>
		</tr>
		<tr>
			<td><b>Refundable amount</b></td><td>:</td>
			<td><?php echo (abs($Transaction['final_price']));?></td>
		</tr>
	<?php }?>
</table>
</p><br/>
<p>Thanks for your time.</p>