<?php
echo $this->Html->css(array('bootstrap-tagsinput'), array('block' => 'bootstrap_datatable_css'));
echo $this->Html->script(array('bootstrap-tagsinput.min','ckeditor/ckeditor'), array('inline' => false));
echo $this->Html->script(array('jquery.ui.widget','jquery.iframe-transport','jquery.fileupload'), array('inline' => false));
?>
<section class="content-header">
    <h1>Send Email To Users</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller' => 'bulk_emails', 'action' => 'manage_email', 'admin' => 1)); ?>">Sent Emails</a></li>
        <li class="active"><?php echo __('Send New Email'); ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-body">
                <?php echo $this->Form->create('BulkEmail',array('action' => 'send_bulk_email','type' => 'file')); ?>
                        <!-- text input -->
                        <div class="form-group">
                            <label>City</label>
                            <?php echo $this->Form->input('users_city', array('options' =>  $city_list,'label' => false,'empty'=>'Select City', 'div' => false, 'class' => 'form-control','id'=>'active_city')); ?>
                            <div class="error" id="user_city_error"></div>
                        </div>
                        <div class="form-group">
                            <label>Users*</label>
                            <?php echo $this->Form->input('users_email', array('options' =>  $user_list, 'multiple'=>true,'label' => false, 'div' => false, 'class' => 'form-control select2')); ?>
                        	<div class="error" id="bulkmail_error"></div>
                        </div>
                        <div class="checkbox">
	                      <a href="javascript:void(0)" rel="tooltip" data-action="all" class="select_action" data-original-title="Select All" style="color:#0F4D92">Select All</a>
	                      <span class="separator" style="font-weight:bold;padding:5px;">|</span>
                              <a href="javascript:void(0)" rel="tooltip" data-action="none" class="select_action" data-original-title="Select None" style="color:#0F4D92">Deselect All</a>
                    	</div>
                        <div class="form-group">
                            <label>Subject*</label>
                            <?php echo $this->Form->input('subject', array('label' => false, 'div' => false, 'class' => 'form-control','placeholder'=>'Subject')); ?>
                        	<div class="error" id="subject_error"></div>
                        </div>

                        <div class="form-group" id="drop">
                            <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> Attachment
                            <input type="file" name="data[BulkEmail][attachments]" multiple>
                            </div>
                            <p class="help-block">Max. 2MB</p>
                        </div>
                        
                        <!-- textarea -->
                        <div class="form-group">
                            <label>Description*</label>
                            <?php echo $this->Form->textarea('description',array('rows' => '3', 'cols' => '5','id'=>'email_description','class'=>'form-control','label' => false, 'div' => false,'escape'=>false));?>
                        	<div class="error" id="bulkmail_desc_error"></div>
                        </div>
                </div>
                <div class="box-footer">
                    <a href='<?php echo $this->Html->url(array("controller" => "users","action" => "index",'admin'=>true));?>' class="btn btn-default">Cancel</a>
                    <button type="button" class="btn btn-info pull-right" onclick="validate_bulk_mail();">Send</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
var select;
    $(document).ready(function () {
    var controller_url = '<?php echo $this->Html->url(array("controller" => "users","action" => "get_active_cities","admin" => 1));?>';
        select = $(".select2").select2({placeholder: "Select an email",allowClear: true});
        $(".select_action").click(function(){
		    if($(this).attr('data-action') == "all"){
		        $(".select2 > option").prop("selected","selected");
		        $(".select2").trigger("change");
		    }else{
				if($(".select2").val()){
					$(".select2 > option").removeAttr("selected");
					$(".select2").trigger("change");
				}
                if($('#active_city').val()){
                    $('#active_city').val('').trigger("change");
                }
		     }
		});
        CKEDITOR.replace('email_description');
        $('#active_city').on('change', function(){
            if($(this).val()){
                $.ajax({
                    url: controller_url,
                    type: 'POST',
                    dataType: "json",
                    data: {city_id: $(this).val()},
                    success: function (response) {
                        if(!$.isEmptyObject(response)){
                            if($(".select2").val()){
                                select.val(null).trigger("change");
                            }
                            select.val(response).trigger("change");
                        }else{
                            alert('No Users found !')
                        }
                    }
                });
            }else{
                select.val(null).trigger("change");
            }
        });
        

    $('#drop label').click(function(){
        // Simulate a click on the file input button
        // to show the file browser dialog
        $(this).parent().find('input').click();
    });

    // Initialize the jQuery File Upload plugin
    $('#BulkEmailSendBulkEmailForm').fileupload({

        // This element will accept file drag/drop uploading
        dropZone: $('#drop'),
        // singleFileUploads:false,
        // limitMultiFileUploadSize:2097152,
        // sequentialUploads:true,
        // limitMultiFileUploads:5,

        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
        add: function (e, data) {

            // var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+
            //     ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

            // Append the file name and file size
            // tpl.find('p').text(data.files[0].name)
            //              .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

            // Add the HTML to the UL element
            // data.context = tpl.appendTo(ul);

            // Initialize the knob plugin
            // tpl.find('input').knob();

            // Listen for clicks on the cancel icon
            // tpl.find('span').click(function(){

            //     if(tpl.hasClass('working')){
            //         jqXHR.abort();
            //     }

            //     tpl.fadeOut(function(){
            //         tpl.remove();
            //     });

            // });

            // Automatically upload the file once it is added to the queue
            var jqXHR = data.submit();
        },

        progress: function(e, data){

            // Calculate the completion percentage of the upload
            // var progress = parseInt(data.loaded / data.total * 100, 10);

            // Update the hidden input field and trigger a change
            // so that the jQuery knob plugin knows to update the dial
            // data.context.find('input').val(progress).change();

            // if(progress == 100){
            //     data.context.removeClass('working');
            // }
        },

        fail:function(e, data){
           alert(data.errorThrown);
           alert(data.textStatus);
           alert(data.jqXHR);
        }

    });


    // Prevent the default action when a file is dropped on the window
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

    // Helper function that formats the file sizes
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }

    });
</script>