<?php if($status){
	$text = ", and it is active";
}else{
	$text = ", and your subscription will be active upon admin's approval of your business";
}?>
<p> Dear <?php echo $name; ?>, </p><br/>
<p>You have subscribed to "<?php echo $Subscription['name'];?>" package<?php echo $text;?>.</p><br/>

	<p>Subscription Details:</p>
	<p>
	<table style="max-width:100%; min-width: 50%;">
		<tr>
			<td><b>Subscription Name </b></td><td>:</td>
			<td><?php echo $Subscription['name']; ?></td>
		</tr>
		<tr>
			<td><b>Subscription Period </b></td><td>:</td>
			<td><?php echo $days . " days (".$month." Months)"; ?>
			</td>
		</tr>
		<tr>
			<td><b>No. of Businesses Limit</b></td><td>:</td>
			<td><?php echo $Subscription['subscription']; ?> </td>
		</tr>
	</table>
	</p><br/>
	<p>Subscription Details:</p>
	<p>
	<table style="max-width:100%; min-width: 50%;">
	    <tr>
	        <td><b>Sub-total price</b></td><td>:</td>
	        <td><?php echo $Transaction['sub_total']; ?></td>
	    </tr>
	    <tr>
	        <td><b>Discount </b></td><td>:</td>
	        <td><?php echo $Transaction['discount']; ?></td>
	    </tr>
		<tr>
			<td><b>Total price</b></td><td>:</td>
			<td><?php echo $Transaction['final_price'];?></td>
		</tr>
	</table>
	</p><br/>

	<p>Thanks for your time. You will be contacted soon.</p>
