<style>
    .form-group label {width:20%;}
    .form-group .frm-data{width:80%;}
    .act-icons{font-size: 18px;}
    .participant_items{margin-top:5px; display: inline-block;}
    label{padding:5px 5px 0 0;}
</style>
<div class="pop-up-box" style="width:450px;min-height: 250px; height: 100%; padding:20px;">
    <div class="up_mc_top request_call"><h2>Request a Callback</h2></div>
    <div class="cb20"></div>
    <div class="pop-up-form fl" style="width:100%;">
        <?php #if($this->Session->read('Auth.User.id')>0){?>
        <?php if(intval($business['Business']['status']) != 1){?>
            <h3 class="error">Business is not active.</h3>
        <?php }else{ ?>
            <?php echo $this->Form->create('CallRequest', array('autocomplete' => 'off', 'type' => 'post', 'id'=>'CallRequestForm')); ?>
            
            <div class="form-group">
                <label for="CallRequestName">Name:</label>
                <div class="frm-data fr">
                    <?php echo $this->Form->input('name', array('placeholder' => 'Name', 'class' => 'form-control', 'div' => false, 'label' => false));?>
                    <div class="cb"></div>
                    <span class="error" id="CallRequestNameErr"></span>
                </div>
                <div class="cb"></div>
            </div>
            <div class="form-group">
                <label for="CallRequestPhone">Phone:</label>
                <div class="frm-data fr">
                    <?php echo $this->Form->input('phone', array('placeholder' => 'Phone Number', 'class' => 'form-control numbersOnly', 'div' => false, 'label' => false, 'maxlength' => 10));?>
                    <div class="cb"></div>
                    <span class="error" id="CallRequestPhoneErr"></span>
                </div>
                <div class="cb"></div>
            </div>
            <div class="form-group">
                <label for="CallRequestEmail">Email:</label>
                <div class="frm-data fr">
                    <?php echo $this->Form->input('email', array('placeholder' => 'Email Address', 'class' => 'form-control', 'div' => false, 'label' => false));?>
                    <div class="cb"></div>
                    <span class="error" id="CallRequestEmailErr"></span>
                </div>
                <div class="cb"></div>
            </div>
            
            <div class="cb"></div>
            <div class="form-group">
                <div class="frm-data fr">
                    <input class="anchor btn-cmn" id="call_submit" style="display: inline-block;" value="Submit" type="submit"/>
                </div>
            </div>
            <div class="cb20"></div>
            <?php echo $this->Form->end(); ?>
        <?php } ?>
        <?php /*}else{ ?>
            <div class="form-group">Please Login to book </div>
        <?php }*/ ?>
    </div>
</div>
<script>
    function validateCallRequest(){
        $.colorbox.resize();
        $("#CallRequestForm").validate({
            rules:{
                'data[CallRequest][name]':{required:true},
                'data[CallRequest][phone]':{required: function(){return $('#CallRequestEmail').val()=='';},moblieNmuber:true},
                'data[CallRequest][email]':{required: function(){return $('#CallRequestPhone').val()=='';},strictEmail:true}
            },
            messages:{
                'data[CallRequest][name]':{required:'Please enter your name'},
                'data[CallRequest][phone]':{required:'Please enter your phone number'},
                'data[CallRequest][email]':{required:'Please enter your email address',email: "Please enter valid email address"}
            },
            errorPlacement:function(error,element){
                error.insertAfter(element);
                $.colorbox.resize();
            },
            submitHandler:function(form){
                //document.form.submit();
                $('#call_submit').val('Loading...');
                $.ajax({
                    url: HTTP_ROOT + "businesses/request_call/<?php echo $BusinessId;?>",
                    data: $('#CallRequestForm').serialize(),
                    method: 'post',
                    //dataType: 'json',
                    success: function(response) {
                        $.colorbox.close();
                        var msg = response == 'success' ? "Call request sent successfully" : "Error: Call request not sent"; 
                        var stats = response == 'success' ? "success" : "error"; 
                        alert(msg, stats);
                        if(stats != 'success'){
                            $('#call_submit').val('Submit');
                        }
                    }
                });
                return false;
            }
        });
    }
    $("#CallRequestForm input").change(function(){
        $.colorbox.resize();
    });
    validateCallRequest();
</script>