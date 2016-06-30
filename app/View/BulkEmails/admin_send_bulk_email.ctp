<?php
echo $this->Html->css(array('bootstrap-tagsinput'), array('block' => 'bootstrap_datatable_css'));
echo $this->Html->script(array('bootstrap-tagsinput.min','ckeditor/ckeditor'), array('inline' => false));
echo $this->Html->script(array('AjaxFileUpload/load-image.all.min','AjaxFileUpload/canvas-to-blob.min','AjaxFileUpload/jquery.iframe-transport','AjaxFileUpload/cors/jquery.xdr-transport','AjaxFileUpload/jquery.fileupload','AjaxFileUpload/jquery.fileupload-process','AjaxFileUpload/jquery.fileupload-image','AjaxFileUpload/jquery.fileupload-validate'), array('inline' => false));
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
    <div class="row"><!-- right column -->
        <div class="col-md-12">
            <div class="box box-info"><!-- /.box-header -->
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
                            <?php echo $this->Form->input('subject', array('type'=>'text','label' => false, 'div' => false, 'class' => 'form-control','placeholder'=>'Subject')); ?>
                        	<div class="error" id="subject_error"></div>
                        </div>

                        <!-- textarea -->
                        <div class="form-group">
                            <label>Description*</label>
                            <?php echo $this->Form->textarea('description',array('rows' => '3', 'cols' => '5','id'=>'email_description','class'=>'form-control','label' => false, 'div' => false,'escape'=>false));?>
                        	<div class="error" id="bulkmail_desc_error"></div>
                        </div>

                        <div class="form-group" id="dropzone"> 
                            <label>Attachments</label>
                            <div class="cb"></div>
                            <div class="btn btn-default btn-file pull-left">
                                <i class="fa fa-paperclip"></i> Select Files to attach
                                <input type="file" name="data[BulkEmail][attachments]" multiple>
                            </div>
                            <div class="pull-left" id="spinner_div" style="width:295px;padding:5px 0;margin-left:10px;display:none;"><i class="fa fa-spinner fa-spin" style="font-size:20px;"></i> Please Wait While Files Are being Uploaded ...</div>
                            <div class="clearfix"></div>
                            <p class="help-block">Max. 5 files of size upto 2MB are allowed. </p>
                        </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="button" onclick="return validate_bulk_mail();" class="btn btn-success" >Send</button>
                    <a href='<?php echo $this->Html->url(array("controller" => "bulk_emails","action" => "manage_email",'admin'=>true));?>' class="btn btn-default">Cancel</a>
                </div>
                </form>
                  <div class="overlay" style="display:none;">
                    <i class="fa fa-refresh fa-spin"></i>
                  </div>
            </div><!-- /.box -->
        </div><!--/.col (right) -->
    </div><!-- /.row -->
</section>
<script type="text/javascript">
var select;
var file_counts = 0;
$(document).ready(function() {
    var controller_url = '<?php echo $this->Html->url(array("controller" => "users","action" => "get_active_cities","admin" => 1));?>';
    select = $(".select2").select2({
        placeholder: "Select an email",
        allowClear: true
    });
    $(".select_action").click(function() {
        if ($(this).attr('data-action') == "all") {
            $(".select2 > option").prop("selected", "selected");
            $(".select2").trigger("change");
        } else {
            if ($(".select2").val()) {
                $(".select2 > option").removeAttr("selected");
                $(".select2").trigger("change");
            }
            if ($('#active_city').val()) {
                $('#active_city').val('').trigger("change");
            }
        }
    });
    CKEDITOR.replace('email_description');
    $('#active_city').on('change', function() {
        if ($(this).val()) {
            $.ajax({
                url: controller_url,
                type: 'POST',
                dataType: "json",
                data: {
                    city_id: $(this).val()
                },
                success: function(response) {
                    if (!$.isEmptyObject(response)) {
                        if ($(".select2").val()) {
                            select.val(null).trigger("change");
                        }
                        select.val(response).trigger("change");
                    } else {
                        alert('No Users found !')
                    }
                }
            });
        } else {
            select.val(null).trigger("change");
        }
    });


    $('#dropzone label').click(function() {
        // Simulate a click on the file input button
        // to show the file browser dialog
        $(this).parent().find('input').click();
    });

    // Initialize the jQuery File Upload plugin
    $('#BulkEmailSendBulkEmailForm').fileupload({

        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
        add: function(e, data) {
            var jqXHR;
            var uploadErrors = [];
            var re = /(?:\.([^.]+))?$/;
            var ext = re.exec(data.originalFiles[0]['name'])[1];
            var acceptFileTypes = ['bmp','gif','png','jpg','jpeg','pdf','PDF','doc','docx','xls','xlxs','txt','rtf'];
            if (data.originalFiles[0]['type'].length && $.inArray(ext.toLowerCase(), acceptFileTypes) == -1) {
                uploadErrors.push('Invalid file format. Please upload  a valid file format.');
            }else if(empty(data.originalFiles[0]['type'].length)){
                uploadErrors.push('Invalid file format. Please upload  a valid file format.');
            }else if(data.originalFiles[0]['size'] > 2097152){
                uploadErrors.push('Filesize is too big. Please upload files of 2 MB.');
            }else{

            }
            if (uploadErrors.length > 0) {
                alert(uploadErrors.join("\n"));
                return false;
            }else if(file_counts > 4){
                alert("You can attach up to 5 files Only.");
                return false;
            } else {
                jqXHR = data.submit();
            }
            file_counts++;
        },
        // This element will accept file drag/dropzone uploading
        dropZone: $('#dropzone'),
        maxNumberOfFiles: 5,
        progress: function(e, data) {
            $('#spinner_div').show();
        },
        done: function(e, data) {
            var resp_obj = JSON.parse(data.jqXHR.responseText);
            var fieldHTML = '<input type="hidden" name="data[BulkEmail][files][]" id="' + resp_obj.tmp_name + '" value="' + resp_obj.tmp_name + '@' + resp_obj.file_name + '"/>';
            $(fieldHTML).appendTo($('#BulkEmailSendBulkEmailForm'));

            var uploaded_files = '<div class="checkbox"><label><input type="checkbox" class="uploaded_files" data-tmp-name="' + resp_obj.tmp_name + '" data-file-name="' + resp_obj.file_name + '"checked> ' + resp_obj.file_name + '</label></div>';
            $("#dropzone").after(uploaded_files);
            $('#spinner_div').hide();
        },
        fail: function(e, data) {
            alert(data.errorThrown);
            alert(data.textStatus);
            alert(data.jqXHR);
        }

    });
});
// Prevent the default action when a file is dropped on the window
$(document).on('drop dragover', function(e) {
    e.preventDefault();
});

$(document).on('click', '.uploaded_files', function() {
    var file_tmp_name = $(this).attr('data-tmp-name');
    var obj = $(this);
    if (confirm("Are You Sure want to remove the attachment " + $(this).attr('data-file-name') + " ?")) {
        $('.overlay').show();
        $.ajax({
            type: "POST",
            data: {
                tmp_name: file_tmp_name
            },
            dataType: 'json',
            url: "<?php echo $this->Html->url(array('controller' => 'bulk_emails', 'action' => 'delete_attachment', 'admin' => 1)); ?>",
            success: function(response) {
                if (response) {
                     $('.overlay').hide();
                    if (response.status == "success") {
                        file_counts = file_counts - 1;
                        obj.closest('form').find('input[type="hidden"][id="' + file_tmp_name + '"]').remove();
                        obj.closest('div').remove();
                        alert(response.reponseTest.charAt(0).toUpperCase() + response.reponseTest.slice(1)+".");
                    }
                }
            }
        });
    } else {
        $(this).prop("checked", true);
    }
});
</script>