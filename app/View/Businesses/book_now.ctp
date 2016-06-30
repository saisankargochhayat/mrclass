<style>
    .frm-data{width:100%;}
    .act-icons{font-size: 18px;}
    .participant_items{margin-top:5px; display: inline-block;}
    .pop-up-box .form-control{ display: inline-block; width: auto;}
    .pop-up-box label{padding:5px 32px 0 0; width: 100%;}
</style>
<div class="pop-up-box" style="width:496px;min-height: 250px; height: 100%;padding:20px;">
    <div class="up_mc_top book_now"><h2>Book Now</h2></div>
    <div class="cb20"></div>
    <div class="pop-up-form fl">
        <?php if(intval($business['Business']['status']) != 1){?>
            <h3 class="error">Business is not active.</h3>
        <?php }elseif($this->Session->read('Auth.User.id')>0){?>
            <?php echo $this->Form->create('BookNow', array('autocomplete' => 'off', 'type' => 'get', 'id'=>'BookNowBookNowForm', 'onsubmit' => 'return false;')); ?>
            <div class="form-group">
                <label for="" class="fl">Select Date:</label>
                <div class="frm-data fl">
                    <?php echo $this->Form->input('from_date', array('placeholder' => 'From Date', 'id' => 'BookNowFromDate', 'class' => 'form-control', 'readonly' => 'readonly', 'div' => false, 'label' => false, 'style' => "width:49%;"));?>
                    <?php echo $this->Form->input('to_date', array('placeholder' => 'To Date', 'id' => 'BookNowToDate', 'class' => 'form-control', 'readonly' => 'readonly', 'div' => false, 'label' => false, 'style' => "width:49%;"));?>
                    <div class="cb"></div>
                    <span class="error" id="BookNowDateErr"></span>
                </div>
                <div class="cb"></div>
            </div>
            <div class="form-group">
                <label for="BookNowSeats" class="fl">No. of Participants:</label>
                <div class="frm-data fl">
                    <?php echo $this->Form->input('seats', array('placeholder' => 'Participants', 'id' => 'BookNowSeats', 'class' => 'form-control', 'div' => false, 'label' => false, 'maxlength' => '2', 'value' => '1', 'style' => "width:98%;"));?>
                    <div class="cb"></div>
                    <span class="error" id="BookNowSeatsErr"></span>
                </div>
                <div class="cb"></div>
            </div>
            <div class="row">
                <label for="" class="fl">Participant Details:</label>
                <div id="participant_block" class="frm-data fl">
                    <span class="participant_items">
                        <?php echo $this->Form->input('name', array('placeholder' => 'Name', 'name' => 'data[BookNow][0][name]', 'class' => 'form-control BookNowName', 'div' => false, 'label' => false, 'style' => "width:78%;"));?>
                        <?php echo $this->Form->input('age', array('placeholder' => 'Age', 'name' => 'data[BookNow][0][age]', 'class' => 'form-control BookNowAge', 'div' => false, 'label' => false, 'style' => "width:20%;", 'maxlength' => "2"));?>
                        <span class="act-icons anchor book_now_add_items none"><i class="ion ion-plus-circled"></i></span>
                        <span class="act-icons anchor book_now_remove_items none"><i class="ion ion-minus-circled"></i></span>
                        <div class="cb"></div>
                        <span class="participant_items_err error" id="participant_items_err0"></span>
                    </span>
                </div>
                <div class="cb"></div>
            </div>
            <div class="cb">&nbsp;</div>
            <div class="row">
                <div class="frm-data fr">
                    <a class="anchor btn-cmn" id="booknow_submit" style="display: inline-block;">Submit</a>
                </div>
            </div>
            <div class="cb20"></div>
            <?php echo $this->Form->end(); ?>
        <?php }else{ ?>
            <div class="form-group">Please <a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'login'))?>?from=<?php echo $this->Format->business_detail_url($business['Business'],false); ?>">Sign In</a> to book </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
  
    var flag = true;
    $("#booknow_submit").click(function(){
        if(!flag) return false;
        //console.log($('#BookNowBookNowForm').serialize())
        //$('#BookNowBookNowForm').submit();
        var err = false;
        $('#BookNowDateErr').html("");
        if($('#BookNowFromDate').val().trim() == ''){
            $('#BookNowDateErr').html("Please select date.");
            err = true;
        }
        $('#BookNowSeatsErr').html("");
        if($('#BookNowSeats').val() == ''){
            $('#BookNowSeatsErr').html("Please select number of participants");
            err = true;
        }
        $('.participant_items').each(function(){
            if($(this).find('input.BookNowName').val()== '' && $(this).find('input.BookNowAge').val() == ''){
                $(this).find('.participant_items_err').html("Please enter name and age.");
                err = true;
            }else if($(this).find('input.BookNowName').val()== '' || $(this).find('input.BookNowAge').val() == ''){
                $(this).find('.participant_items_err').html("Please enter "+($(this).find('input.BookNowName').val()== '' ? "name" : "age"));
                err = true;
            }else{
                $(this).find('.participant_items_err').html("");
            }
        });
        if(err === true){
            $.colorbox.resize();
            return false;
        }
        $("#booknow_submit").html('Loading...');
        flag = false;
        $.ajax({
            url: HTTP_ROOT + "businesses/ajax_save_bookings/<?php echo $BusinessId;?>",
            data: $('#BookNowBookNowForm').serialize(),
            method: 'post',
            //dataType: 'json',
            success: function(response) {
                $.colorbox.close();
                var msg = response == 'success' ? "Booking request sent successfully" : "Error: Booking request not sent";
                var stats = response == 'success' ? "success" : "error"; 
                alert(msg, stats);
            }
        });
    });
    $( "#BookNowFromDate" ).datepicker({
        dateFormat: 'M d, yy',
        defaultDate: "0",
        numberOfMonths: 1,
        minDate: 0,
        onClose: function( selectedDate ) {
            if(selectedDate!=''){
                $('#BookNowDateErr').html("");
            }
            $( "#BookNowToDate" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    $( "#BookNowToDate" ).datepicker({
        dateFormat: 'M d, yy',
        defaultDate: "+1d",
        numberOfMonths: 1,
        minDate: 0,
        onClose: function( selectedDate ) {
            $( "#BookNowFromDate" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
    var clone = $('.participant_items').eq(0).clone();
    var cntr = 0;
    $("#participant_block").on('click',".book_now_add_items",function(){
        var nclone = clone.clone();
        cntr++;
        nclone.find('input,select,span').each(function(){
            var type = this.type || this.tagName.toLowerCase();

            var oldid = $(this).attr('id');
            if(typeof oldid !='undefined'){
                var newid = oldid.replace(/\d+/,cntr); 
                $(this).attr('id',newid);
            }
            var oldname = $(this).attr('name');
            if(typeof oldname !='undefined'){
                var newname = oldname.replace(/\d+/,cntr); 
                $(this).attr('name',newname);
            }
            if(type == 'text'){
                $(this).val('');
            }
        });
        nclone.on('keypress','.BookNowAge',function(){
            var charCode = event.which || event.keyCode;
            if ((charCode < 48 || charCode > 57) && charCode != 8){
                return false;
            }
        });
        $('#participant_block').append(nclone);
        $(".participant_items_err").html('');
        //$(".book_now_remove_items:gt(0)").show();
        //$('#BookNowSeats').val($('.participant_items').length);
        $.colorbox.resize();
    });
    $("#participant_block").on('click',".book_now_remove_items",function(){
        $(this).closest('.participant_items').remove();
        //$('#BookNowSeats').val($('.participant_items').length);
        $.colorbox.resize();
    });
 
    $('#BookNowSeats').on('change',function(){
        $(this).val(!isNaN($(this).val()) && $(this).val()>0 ? $(this).val() : 1);
        $('#BookNowSeatsErr').html("");
        var rm = false; var inc = 0; var incArr = [];
        var cntr = 0;
        /*if($('input.BookNowName').eq(0).val()== '' && $('input.BookNowAge').eq(0).val() == ''){
            inc++;
        }*/
        //$('.participant_items:gt(0)').each(function(){
        
        $('.participant_items').each(function(){
            if($(this).find('input.BookNowName').val()!= '' || $(this).find('input.BookNowAge').val() != ''){
                inc++;
            }else{
                //console.log($(this).index()+'>0 || '+inc)
                //if($(this).index()>0 || inc >0)
                    $(this).find('.book_now_remove_items').trigger('click');
            }
        });
        if($('.participant_items').length===0){
            var nclone = clone.clone();
            $('#participant_block').append(nclone);
            cntr=1;
        }
        cntr = parseInt($(this).val()-(inc>0?--inc:0));
        //console.log('cntr > '+cntr+' inc > '+inc)
        if(cntr>1){
            for(var i=1; i<cntr; i++){
                $('.book_now_add_items').eq(0).trigger('click');
            }
        }
        $(this).val($('.participant_items').length);
    })
    $("#BookNowSeats,.BookNowAge").keypress(function(event){
        var charCode = event.which || event.keyCode;
        if ((charCode < 48 || charCode > 57) && charCode != 8){
            return false;
        }
    });
    
</script>