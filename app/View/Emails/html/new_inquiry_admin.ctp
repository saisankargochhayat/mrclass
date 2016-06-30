<p>Hello Admin,</p>
<p>We have a new inquiry for tutor from a user. The details are as follows:</p>
<p>
<table style="width:100%;">
    <tr><td style="width:125px;"><b>Name</b></td><td>:</td><td><?php echo h($name); ?></td></tr>
    <?php if(trim($extra['email'])!=''):?>
        <tr><td><b>Email</b></td><td>:</td><td><?php echo h($extra['email']); ?></td></tr>
    <?php endif;?>
    <?php if(trim($extra['phone'])!=''):?>
        <tr><td><b>Phone Number</b></td><td>:</td><td><?php echo h($extra['phone']); ?></td></tr>
    <?php endif;?>
    <?php if(trim($message)!=''):?>
        <tr><td><b>Message</b></td><td>:</td><td><?php echo h($message); ?></td></tr>
    <?php endif;?>
    <tr><td><b>Category</b></td><td>:</td><td><?php echo h($extra['category']); ?></td></tr>
    <?php /* <tr><td>Sub Category</td><td>:</td><td><?php #echo h($extra['sub_category']); ?></td></tr> */?>
    <tr><td><b>City</b></td><td>:</td><td><?php echo h($extra['city']); ?></td></tr>
    <tr><td><b>Area</b></td><td>:</td><td><?php echo h($extra['area']); ?></td></tr>
    <tr><td><b>Min Age</b></td><td>:</td><td><?php echo h($extra['min_age']); ?> yr(s)</td></tr>
    <?php if(trim($extra['max_age'])!=''):?>
        <tr><td><b>Max Age</b></td><td>:</td><td><?php echo h($extra['max_age']); ?> yr(s)</td></tr>
    <?php endif;?>
    <tr><td><b>Tutor Type</b></td><td>:</td><td><?php echo h(ucfirst($extra['type'])); ?></td></tr>
    <tr><td><b>Preferred Location</b></td><td>:</td><td><?php echo h(ucfirst($extra['location'])); ?></td></tr>
</table>
</p>
