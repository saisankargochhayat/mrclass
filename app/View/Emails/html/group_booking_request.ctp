<p>Hello Admin, </p>
<p>We have received a group booking request from a user with information given below:</p>
<p>Group Booking Request Details:</p>
<p>
<table style="max-width:100%; min-width: 50%;">
    <tr>
        <td><b>Name </b></td><td>:</td>
        <td><?php echo $bookingData['GroupBookingRequest']['name']; ?></td>
    </tr>
    <?php if(!empty($bookingData['GroupBookingRequest']['email'])){?>
    <tr>
        <td><b>Email</b></td><td>:</td>
        <td><?php echo $bookingData['GroupBookingRequest']['email']; ?> </td>
    </tr>
    <?php }?>
    <tr>
        <td><b>Phone</b></td><td>:</td>
        <td><?php echo $bookingData['GroupBookingRequest']['phone']; ?> </td>
    </tr>
    <tr>
        <td><b>Email</b></td><td>:</td>
        <td><?php echo $bookingData['GroupBookingRequest']['email']; ?> </td>
    </tr>
    <tr>
        <td><b>Group Size</b></td><td>:</td>
        <td><?php echo $bookingData['GroupBookingRequest']['group_size']; ?> </td>
    </tr>
    <tr>
        <td><b>Looking For</b></td><td>:</td>
        <td><?php echo $bookingData['GroupBookingRequest']['looking_for']; ?> </td>
    </tr>
    <tr>
        <td><b>Address</b></td><td>:</td>
        <td><?php echo $bookingData['GroupBookingRequest']['address'].", ".$cityLocality['Locality']['name'].", ".$cityLocality['City']['name'].", ".$bookingData['GroupBookingRequest']['pincode']; ?> </td>
    </tr>
    <tr>
        <td><b>Requested Date </b></td><td>:</td>
        <td><?php echo $this->Format->dateFormat($bookingData['GroupBookingRequest']['created']); ?></td>
    </tr>
</table>
</p>

