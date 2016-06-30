<style>
    .frm-data{width:288px;}
    .act-icons{font-size: 18px;}
    .participant_items{margin-top:5px; display: inline-block;}
    .pop-up-box .form-control{ display: inline-block; width: auto;}
    .pop-up-box label{padding:5px 0px 3px 0; width: 140px; font-weight: bold;}
    .pop-up-box .frm-data    {padding:5px 0px 3px 0; }
    .pop-up-box .form-group{margin-bottom: 5px;}
</style>
<div class="pop-up-box" style="width:496px;min-height: 250px; height: 100%;padding:20px;">
    <div class="up_mc_top book_now"><h2>Booking Detail
            <?php if($booking[0]['stats'] == 'Expired'){echo "<em style='font-size:14px;'>Expired</em>";}?>
        </h2></div>
    <div class="cb20"></div>
    <div class="pop-up-form fl">
        <div class="form-group">
            <label class="fl">Business Name:</label>
            <div class="frm-data fl">
                <?php echo h($booking['Business']['name']); ?>
            </div>
            <div class="cb"></div>
        </div>
        <div class="form-group">
            <label class="fl">Selected Date(s):</label>
            <div class="frm-data fl">
                <?php echo $this->Format->dateFormat($booking['BusinessBooking']['from_date']); ?>
                <?php echo strtotime($booking['BusinessBooking']['to_date']) > 0 ? " to ".$this->Format->dateFormat($booking['BusinessBooking']['to_date']) : ""; ?>
            </div>
            <div class="cb"></div>
        </div>
        <div class="form-group">
            <label class="fl"># Participants:</label>
            <div class="frm-data fl"><?php echo $booking['BusinessBooking']['seats'];?></div>
            <div class="cb"></div>
        </div>
        <div class="form-group">
            <label class="fl">Booking Date:</label>
            <div class="frm-data fl"><?php echo $this->Format->dateFormat($booking['BusinessBooking']['created']); ?></div>
            <div class="cb"></div>
        </div>
        <div class="form-group">
            <label class="fl">Booking Details:</label>
            <div class="frm-data fl" style="">
                <?php if(is_array($booking['BusinessBookingDetail']) && count(($booking['BusinessBookingDetail']))>0){ ?>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Age</th>
                        </tr>
                        <?php foreach($booking['BusinessBookingDetail'] as $data){ ?>
                            <tr>
                                <td><?php echo h($data['name']) ?></td>
                                <td style="padding-left:25px"> <?php echo h($data['age'])." ".($data['age']>1?"yrs":"yr") ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php }else{ ?>
                ---
                <?php } ?>
            </div>
            <div class="cb"></div>
        </div>
        <div class="form-group">
            <label class="fl">Status:</label>
            <div class="frm-data fl">
                
                <?php echo ($booking[0]['stats'] == 'Expired')? "<em>Expired</em>" :((intval($booking['BusinessBooking']['approved']) == 1)?"Approved":"Pending"); ?>
            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>