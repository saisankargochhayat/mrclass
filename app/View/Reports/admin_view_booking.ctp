<style>
    .form-group{float: left; width:100%;}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Booking Details</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link) ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('action' => 'bookings')) ?>">Bookings</a></li>
        <li class="active">Details</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Booking Details</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <label class="col-sm-2 control-label">Business Name</label>
                <div class="col-sm-10">
                    <?php echo h($booking['Business']['name']); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Selected Date(s)</label>
                <div class="col-sm-10">
                    <?php echo $this->Format->dateFormat($booking['BusinessBooking']['from_date']); ?>
                    <?php echo strtotime($booking['BusinessBooking']['to_date']) > 0 ? "&nbsp;to&nbsp;" . $this->Format->dateFormat($booking['BusinessBooking']['to_date']) : ""; ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label"># Participants</label>
                <div class="col-sm-10"><?php echo $booking['BusinessBooking']['seats']; ?></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Booking Date</label>
                <div class="col-sm-10"><?php echo $this->Format->dateFormat($booking['BusinessBooking']['created']); ?></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Booking Details</label>
                <div class="col-sm-10" style="">
                    <?php if (is_array($booking['BusinessBookingDetail']) && count(($booking['BusinessBookingDetail'])) > 0) { ?>
                        <table>
                            <?php foreach ($booking['BusinessBookingDetail'] as $data) { ?>
                                <tr>
                                    <td><?php echo h($data['name']) ?></td>
                                    <td style="padding-left:10px">-</td>
                                    <td style="padding-left:10px"><?php echo h($data['age']) . " " . ($data['age'] > 1 ? "yrs" : "yr") ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    <?php } else { ?>
                        ---
                    <?php } ?>
                </div>
                <div class="cb"></div>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
           
        </div><!-- /.box-footer-->
    </div><!-- /.box -->

</section><!-- /.content -->
