<style>
    #colorbox div.pop-up-form{width: 100%;}
    .frm-data{width:100%;}
    .act-icons{font-size: 18px;}
    .participant_items{margin-top:5px; display: inline-block;}
    .pop-up-box .form-control{ display: inline-block; }
    .pop-up-box label{padding:5px 32px 0 0; width: 100%;}
</style>
<div class="pop-up-box" style="width:496px;min-height: 250px; height: 100%;padding:20px;">
    <div class="up_mc_top book_now"><h2>Event Inquiry</h2></div>
    <div class="cb20"></div>
    <div class="pop-up-form fl">
        <?php if (intval($event['Event']['status']) != 1) { ?>
            <h3 class="error">Event is not active.</h3>
        <?php } elseif ($this->Session->read('Auth.User.id') > 0) { ?>
            <?php echo $this->Form->create('EventInquiry', array('autocomplete' => 'off', 'type' => 'get', 'id' => 'EventInquiryForm', 'onsubmit' => 'return false;')); ?>
            <div class="form-group">
                <label for="" class="fl">Name:</label>
                <div class="frm-data fl">
                    <?php echo $this->Form->input('name', array('placeholder' => 'Enter your name', 'class' => 'form-control', 'div' => false, 'label' => false, 'value' => $user['name'])); ?>
                    <div class="cb"></div>
                    <span class="error" id="EventInquiryNameErr"></span>
                </div>
                <div class="cb"></div>
            </div>
            <div class="form-group">
                <label for="" class="fl">Phone:</label>
                <div class="frm-data fl">
                    <?php echo $this->Form->input('phone', array('placeholder' => 'Enter your phone number', 'class' => 'form-control', 'div' => false, 'label' => false, 'value' => $user['phone'])); ?>
                    <div class="cb"></div>
                    <span class="error" id="EventInquiryPhoneErr"></span>
                </div>
                <div class="cb"></div>
            </div>
            <div class="form-group">
                <label for="" class="fl">Email:</label>
                <div class="frm-data fl">
                    <?php echo $this->Form->input('email', array('placeholder' => 'Enter your email address', 'class' => 'form-control', 'div' => false, 'label' => false, 'value' => $user['email'])); ?>
                    <div class="cb"></div>
                    <span class="error" id="EventInquiryEmailErr"></span>
                </div>
                <div class="cb"></div>
            </div>

            <div class="cb">&nbsp;</div>
            <div class="row">
                <div class="frm-data fr">
                    <a class="anchor btn-cmn" id="event_inquiry_submit" style="display: inline-block;">Submit</a>
                </div>
            </div>
            <div class="cb20"></div>
            <?php echo $this->Form->end(); ?>
        <?php } else { ?>
            <div class="form-group">Please <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'login')) ?>?from=<?php echo $this->Format->event_detail_url($event['Event'], false); ?>">Sign In</a> to book </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">

    var flag = true;
    $("#event_inquiry_submit").click(function () {
        if (!flag)
            return false;
        //console.log($('#BookNowBookNowForm').serialize())
        //$('#BookNowBookNowForm').submit();
        var err = false;
        $('#EventInquiryNameErr').html("");
        if ($('#EventInquiryName').val().trim() == '') {
            $('#EventInquiryNameErr').html("Please enter your name.");
            err = true;
        }
        $('#EventInquiryPhoneErr').html("");
        if ($('#EventInquiryPhone').val() == '') {
            $('#EventInquiryPhoneErr').html("Please enter your phone number");
            err = true;
        }
        $('#EventInquiryEmailErr').html("");
        if ($('#EventInquiryEmail').val() == '') {
            $('#EventInquiryEmailErr').html("Please enter your email address");
            err = true;
        }

        if (err === true) {
            $.colorbox.resize();
            return false;
        }
        $("#booknow_submit").html('Loading...');
        flag = false;
        $.ajax({
            url: HTTP_ROOT + "content/ajax_save_event_inquiry/<?php echo $EventId . "/" . $stat; ?>",
            data: $('#EventInquiryForm').serialize(),
            method: 'post',
            //dataType: 'json',
            success: function (response) {
                $.colorbox.close();
                var msg = response == 'success' ? "Event Inquiry sent successfully" : "Error: Event Inquiry not sent";
                var stats = response == 'success' ? "success" : "error";
                alert(msg, stats);
            }
        });
    });




    $("#BookNowSeats,.BookNowAge").keypress(function (event) {
        var charCode = event.which || event.keyCode;
        if ((charCode < 48 || charCode > 57) && charCode != 8) {
            return false;
        }
    });

</script>