<style type="text/css">
    .star_on{display: inline-block; float:left;}
</style>
<p>Dear <?php echo h($username); ?>,</p>
<p>Owner has replied to your review for business: <b><?php echo h($business['Business']['name']); ?></b>.</p>

<p>Reply Details:</p>
<p>
<table style="width: 100%;">
    <tr>
        <td style="width:120px;"><b>Name</b></td> <td>:</td><td><?php echo h($reviewed_by); ?></td>
    </tr>
    <tr>
        <td><b>Reviewed on</b></td> <td>:</td><td><?php echo date('M d, Y'); ?></td>
    </tr>
    <tr>
        <td><b>Comment</b></td> <td>:</td><td><?php echo h($comment); ?></td>
    </tr>
</table>
</p>
