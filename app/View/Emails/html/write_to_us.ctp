<p>Hello Admin,</p>
<p>&nbsp;</p>
<p>We have a query from the following location info:</p>
<p>&nbsp;</p>
<p>
<table style="width: 100%;">
    <tr>
        <td><b>Name</b></td> <td>:</td><td><?php echo $name; ?></td>
    </tr>
    <tr>
        <td><b>Message</b></td> <td>:</td><td><?php echo $message; ?></td>
    </tr>
    <?php if ($longitude != '') { ?>
        <tr>
            <td><b>Longitude</b></td> <td>:</td><td><?php echo $longitude != '' ? $longitude : '---'; ?></td>
        </tr>
    <?php } ?>
    <?php if ($latitude != '') { ?>
        <tr>
            <td><b>Latitude</b></td> <td>:</td><td><?php echo $latitude != '' ? $latitude : '---'; ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td><b>Ip Address</b></td> <td>:</td><td><?php echo $client_ip; ?></td>
    </tr>
</table>
</p>
