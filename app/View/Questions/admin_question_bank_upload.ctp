<style type="text/css">
    .sortable li{list-style: none;display: list-item;}
    .ui-state-highlight { height: 40px; line-height: 1.2em;border: 2px dotted #FFFF00;background: #FFFF99;}
</style>
<?php
echo $this->Html->script(array('AjaxFileUpload/load-image.all.min','AjaxFileUpload/canvas-to-blob.min','AjaxFileUpload/jquery.iframe-transport','AjaxFileUpload/cors/jquery.xdr-transport','AjaxFileUpload/jquery.fileupload','AjaxFileUpload/jquery.fileupload-process','AjaxFileUpload/jquery.fileupload-image','AjaxFileUpload/jquery.fileupload-validate'), array('inline' => false));
?>
<section class="content-header">
    <h1>Upload files for question bank</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'index',$QuestionCategory['QuestionCategory']['id'], 'admin' => 1)); ?>"><?php echo $QuestionCategory['QuestionCategory']['name'];?></a></li>
        <li class="active"><?php echo __('Question Bank Upload'); ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row"><!-- right column -->
        <div class="col-md-12">
            <div class="box box-info"><!-- /.box-header -->
                <div class="box-body question-bank">
                <?php echo $this->Form->create('Question',array('action' => 'question_bank_upload_files','type' => 'file')); ?>
                        <div class="form-group" id="dropzone"> 
                            <label>Select files from your computer</label>
                            <div class="cb"></div>
                            <div class="btn btn-default btn-file pull-left">
                                <i class="fa fa-paperclip"></i> Select Files to attach
                                <input type="file" name="data[Question][attachemnts]" multiple>
                            </div>
                            <div class="pull-left" id="spinner_div" style="width:295px;padding:5px 0;margin-left:10px;display:none;"><i class="fa fa-spinner fa-spin" style="font-size:20px;"></i> Please Wait While Files Are being Uploaded ...</div>
                            <div class="clearfix"></div>
                            <p class="help-block">Files of size upto 2MB are allowed. </p>
                        </div>

                      <!-- Progress Bar -->
                      <div class="progress" style="display:none;">
                        <div class="progress-bar progress-bar-green progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                      <!-- Upload Finished -->
                      <div class="js-upload-finished" id="files_div" style="display:none;">
                        <h3>Processed files</h3>
                        <ul class="list-group sortable" id="sortable-1">
                        </ul>
                      </div>
                      
                         <!-- Drop Zone -->
                      <h4>Or drag and drop files below</h4>
                      <div class="upload-drop-zone" id="drop_zone">
                        Just drag and drop files here
                      </div>



                </div><!-- /.box-body -->
                <input type="hidden" name="data[Question][question_category_id]" id='ad_q_cat_id' value="<?php echo $QuestionCategory['QuestionCategory']['id'];?>">
                <div class="box-footer">
                    <button type="button" onclick="return check_valid_upload();" class="btn btn-success" >Save</button>
                    <a href='<?php echo $this->Html->url(array("controller" => "questions","action" => "index",$QuestionCategory['QuestionCategory']['id'],'admin'=>true));?>' class="btn btn-default">Cancel</a>
                </div>
                <?php echo $this->Form->end(); ?>
                  <div class="overlay" style="display:none;">
                    <i class="fa fa-refresh fa-spin"></i>
                  </div>
            </div><!-- /.box -->
        </div><!--/.col (right) -->
    </div><!-- /.row -->
</section>
<script type="text/html" id='file_complete_blocks'>
<li><input type="hidden" class="files_hidden" name="data[Question][files][]" id="<%= resp_obj.tmp_name %>" value="<%= resp_obj.tmp_name %>@<%= resp_obj.file_name %>"/>
    <a href="#" data-tmp-name="<%= resp_obj.tmp_name %>" data-file-name="<%= resp_obj.file_name %>" class="list-group-item list-group-item-success file_delete" title="Delete file">
        <span class="badge alert-success pull-right"><i class="fa fa-close"></i></span> <%= resp_obj.file_name %>
    </a>
</li>
</script>
<script type="text/html" id='hidden_fields'>
   <input type="hidden" class="files_hidden" name="data[Question][files][]" id="<%= resp_obj.tmp_name %>" value="<%= resp_obj.tmp_name %>@<%= resp_obj.file_name %>"/>
</script>
<script type="text/javascript">
var file_counts = 0;
var counter = 0;
var number_of_files = 0;
var draggable_opts = {connectToSortable: "#sortable-1",helper: "clone",opacity: 0.75,revert: 'invalid',stop: function(event, ui) {$.noop();}};
$(document).ready(function() {
    sessionStorage.setItem('number_of_files', number_of_files);
    var progress_div = $('#QuestionQuestionBankUploadFilesForm').find('.progress');
    $('#dropzone label').click(function() {
        $(this).parent().find('input').click();
    });
     $("#sortable-1").sortable({placeholder: "ui-state-highlight"});
     $("#sortable-1").disableSelection();
    $('#QuestionQuestionBankUploadFilesForm').fileupload({
        add: function(e, data) {
            var jqXHR;
            var uploadErrors = [];
            var re = /(?:\.([^.]+))?$/;
            var ext = re.exec(data.originalFiles[0]['name'])[1];
            var acceptFileTypes = ['pdf'];
            if (data.originalFiles[0]['type'].length && $.inArray(ext.toLowerCase(), acceptFileTypes) == -1) {
                uploadErrors.push('Invalid file format. Only pdf files are allowed.');
            }else if(empty(data.originalFiles[0]['type'].length)){
                uploadErrors.push('Invalid file format. Only pdf files are allowed.');
            }else if(data.originalFiles[0]['size'] > 31457280){
                uploadErrors.push('Filesize is too big. Please upload files of 2 MB.');
            }else{

            }
            if (uploadErrors.length > 0) {
                alert(uploadErrors.join("\n"));
                return false;
            // }else if(file_counts > 4){
            //     alert("You can attach up to 5 files Only.");
            //     return false;
            } else {
                jqXHR = data.submit();
            }
            $.each(data.files, function (index, file) {
                number_of_files = number_of_files + 1;
                sessionStorage.setItem('number_of_files', number_of_files);
            });
        },
        // This element will accept file drag/dropzone uploading
        dropZone: $('#drop_zone'),
        maxNumberOfFiles: 5,
        send:function (e, data) {
            //console.log(data.files.length);
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            progress_div.show();
            progress_div.children().first().attr('aria-valuenow', progress).css('width',progress + '%').text(progress + '%');
        },
        done: function(e, data) {
            var new_el;
            var resp_obj = JSON.parse(data.jqXHR.responseText);
            var tpl2 = _.template($('#file_complete_blocks').html());
            new_el = tpl2({resp_obj: resp_obj});
            $("#files_div").show().find('.list-group').append(new_el);
            $("#sortable-1").sortable( "refresh" );
            $('#spinner_div').hide();
            progress_div.children().first().attr('aria-valuenow', '0').css('width','0%').text('0%');
            progress_div.hide();
        },
        fail: function(e, data) {
            alert(data.errorThrown);
            alert(data.textStatus);
            alert(data.jqXHR);
        }

    }).bind('fileuploadsubmit', function(e, data) {
        data.formData = {
            question_category_id: $('#ad_q_cat_id').val(),
        };
    });
});
$(document).bind('dragover', function (e) {
    var dropZone = $('#drop_zone'),
        timeout = window.dropZoneTimeout;
    if (!timeout) {
        dropZone.addClass('in');
    } else {
        clearTimeout(timeout);
    }
    if (e.target === dropZone[0]) {
        dropZone.addClass('hover');
    } else {
        dropZone.removeClass('hover');
    }
    window.dropZoneTimeout = setTimeout(function () {
        window.dropZoneTimeout = null;
        dropZone.removeClass('in hover');
    }, 100);
});
// Prevent the default action when a file is dropped on the window
$(document).on('drop dragover', function(e) {
    e.preventDefault();
});

$(document).on('click', '.file_delete', function() {
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
            url: "<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'delete_attachment', 'admin' => 1)); ?>",
            success: function(response) {
                if (response) {
                     $('.overlay').hide();
                    if (response.status == "success") {
                        //file_counts = file_counts - 1;
                        sessionStorage.setItem('number_of_files', parseInt(sessionStorage.getItem('number_of_files')) - 1);
                        obj.closest('form').find('input[type="hidden"][id="' + file_tmp_name + '"]').remove();
                        if(obj.closest('ul').find('a').size() > 1){
                            obj.closest('a').closest('li').remove();
                        }else{
                            obj.closest('a').closest('li').remove();
                            $('#files_div').hide();
                        }
                        $("#sortable-1").sortable( "refresh" );
                        alert(response.reponseTest.charAt(0).toUpperCase() + response.reponseTest.slice(1)+".");
                    }
                }
            }
        });
    } else {
        $.noop();
    }
});
function check_valid_upload(){
    if($('.files_hidden').size() > 0){
        sessionStorage.removeItem("number_of_files");
        $('#QuestionQuestionBankUploadFilesForm').submit();
    }else{
        alert("Please upload some files to save !")
    }
}
</script>