<?php
echo $this->Html->script(array('moment.min', 'daterangepicker'), array('inline' => false));
echo $this->Html->css(array('daterangepicker-bs3'), array('block' => 'bootstrap_datatable_css'));
echo $this->Html->script(array('AjaxFileUpload/load-image.all.min', 'AjaxFileUpload/canvas-to-blob.min', 'AjaxFileUpload/jquery.iframe-transport', 'AjaxFileUpload/cors/jquery.xdr-transport', 'AjaxFileUpload/jquery.fileupload', 'AjaxFileUpload/jquery.fileupload-process', 'AjaxFileUpload/jquery.fileupload-image', 'AjaxFileUpload/jquery.fileupload-validate'), array('inline' => false));
?>
<style type="text/css">
    .tab-content .box-footer{border-top: none;padding: 0;}
    #range_div{display:none;}
    #package_lim,#dimension_lim{padding: 5px 30px 6px;font-size: 15px;}
    #limit_info_div{display: block;}
    #dimension_info_div{display: none;}
    .image_preview{display: block;}
</style>
<section class="content-header">
    <h1><?php echo __('Edit Advertisement'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="<?php echo $this->Html->url(array('controller' => 'advertisements', 'action' => 'index', 'admin' => 1)); ?>"><?php echo __('Advertisements'); ?></a></li>
        <li><?php echo __('Edit Advertisement'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#advertisementAdd" data-toggle="tab"><?php echo __('Edit Advertisement'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="advertisementAdd">
                        <?php echo $this->Form->create('Advertisement', array('action' => 'edit', 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Basic information about the advertisement</h3>
                            </div>
                            <div class="box-body" id="banner_desc">
                                <div class="form-group">
                                    <label for="AdvertisementName" class="col-sm-2 control-label"><?php echo __('Name'); ?>*</label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('name', array('label' => false, 'div' => false, 'placeholder' => 'Name', 'class' => 'form-control alphaOnly')); ?>
                                        <div class="error" id="AdvertisementName_error"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="AdvertisementDescription" class="col-sm-2 control-label"><?php echo __('Description'); ?></label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('description', array('type' => 'textarea', 'label' => false, 'div' => false, 'placeholder' => 'Description', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="AdvertisementUrl" class="col-sm-2 control-label"><?php echo __('URL'); ?></label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('url', array('label' => false, 'div' => false, 'placeholder' => 'Ad URL', 'class' => 'form-control')); ?>
                                        <div class="error" id="AdvertisementUrl_error"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="AdvertisementCityId" class="col-sm-2 control-label"><?php echo __('Target Audience'); ?></label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('city_id', array('options' => $cities, 'label' => false, 'div' => false, 'empty' => __('Select City'), 'class' => 'form-control select2')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="AdvertisementPageId" class="col-sm-2 control-label"><?php echo __('Target Page'); ?>*</label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('page_id', array('options' => $pages_list, 'label' => false, 'div' => false, 'empty' => __('Select Ad Page'), 'class' => 'form-control select2')); ?>
                                        <div class="error" id="AdvertisementPageId_error"></div>
                                    </div>
                                </div>
                                <div class="form-group" id="dimension_info_div">
                                    <label for="" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <span class="label label-primary" id="dimension_lim">Info:</span>
                                    </div>
                                </div>
                                <div class="form-group" id="dropzone" style="<?php
                                if (empty($this->request->data['Advertisement']['Image'])) {
                                    echo 'display:block;';
                                } else {
                                    echo 'display:none;';
                                }
                                ?>"> 
                                    <label class="col-sm-2 control-label">Ad Banner</label>
                                    <div class="col-sm-10">
                                        <div class="btn btn-default btn-file col-xs-3">
                                            <i class="fa fa-paperclip"></i> Change Ad Image
                                            <input type="file" name="data[Advertisement][attachments]" id="banner_file_input">
                                        </div>
                                        <div class="col-xs-1"></div>
                                        <div class="col-xs-6" id="spinner_div" style="padding:5px 0;display:none;"><i class="fa fa-spinner fa-spin" style="font-size:20px;"></i> Please wait while file is being Uploaded ...</div>
                                        <div class="clearfix"></div>
                                        <p class="help-block">Max. 1 file of size upto 2MB are allowed. </p>
                                        <div class="error" id="banner_file_input_error"></div>
                                    </div>
                                </div>
                                <div class="form-group margin-bottom image_preview" style="<?php
                                if (isset($this->request->data['Advertisement']['image']) && !empty($this->request->data['Advertisement']['image'])) {
                                    echo 'display:block;';
                                } else {
                                    echo 'display:none;';
                                }
                                ?>">
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-10">
                                        <span class="mailbox-attachment-icon has-img">
                                            <img class="img-responsive" src="<?php echo $this->Format->ad_image($this->request->data['Advertisement'],'','',0); ?>" alt="banner_img">
                                        </span>
                                        <div class="mailbox-attachment-info">
                                            <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> 
                                                <?php
                                                if (isset($this->request->data['Advertisement']['image']) && !empty($this->request->data['Advertisement']['image'])) {
                                                    echo $this->request->data['Advertisement']['image'];
                                                } else {
                                                    echo '';
                                                }
                                                ?></a>
                                            <span class="mailbox-attachment-size"><span id="image_size"></span>
                                                <a href="#" class="btn btn-default btn-xs pull-right image_delete" data-record-id="<?php echo @$this->request->data['Advertisement']['id']; ?>" data-id="<?php echo @$this->request->data['Advertisement']['image']; ?>"><i class="fa  fa-trash"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="overlay" style="display:none;">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                            <div class="box-footer"></div>
                        </div>
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Contact information of the advertiser</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="AdvertisementContactName" class="col-sm-2 control-label"><?php echo __('Contact Name'); ?>*</label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('contact_name', array('label' => false, 'div' => false, 'placeholder' => 'Name', 'class' => 'form-control alphaOnly')); ?>
                                        <div class="error" id="AdvertisementContactName_error"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="AdvertisementEmail" class="col-sm-2 control-label"><?php echo __('Email'); ?>*</label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('email', array('label' => false, 'div' => false, 'placeholder' => 'Email', 'class' => 'form-control')); ?>
                                        <div class="error" id="AdvertisementEmail_error"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="AdvertisementPhone" class="col-sm-2 control-label"><?php echo __('Phone'); ?></label>
                                    <div class="col-sm-10">
                                        <div class="phoneblock fl">
                                            <div class="phlbl fl">+91</div>
                                            <?php echo $this->Form->input('phone', array('label' => false, 'div' => false, 'placeholder' => 'Phone', 'class' => 'form-control numbersOnly', 'maxlength' => 10)); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="AdvertisementAddress" class="col-sm-2 control-label"><?php echo __('Address'); ?></label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('address', array('type' => 'textarea', 'label' => false, 'div' => false, 'placeholder' => 'Address', 'class' => 'form-control')); ?>
                                    </div>
                                </div>

                            </div>
                            <div class="box-footer"></div>
                        </div>
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">How much does the advertiser want to spend?</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="AdvertisementCostPerView" class="col-sm-2 control-label"><?php echo __('CPC'); ?>*</label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('cost_per_view', array('label' => false, 'div' => false, 'placeholder' => 'Cost Per View', 'class' => 'form-control numbersOnly budget_inputs')); ?>
                                        <div class="error" id="AdvertisementCostPerView_error"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label"><?php echo __('Budget'); ?>*</label>
                                    <div class="col-sm-10" style="padding-top:8px;">
                                        <div class="col-xs-2">
                                            <label for="budget_daily">
                                                <input name="data[Advertisement][budget_type]" id="budget_daily" value="Daily" type="radio" <?php
                                                if ($this->request->data['Advertisement']['budget_type'] == 'Daily') {
                                                    echo 'checked';
                                                }
                                                ?>/>&nbsp;&nbsp;Daily Budget
                                            </label>
                                        </div>
                                        <div class="col-xs-2">
                                            <label for="budget_total">
                                                <input name="data[Advertisement][budget_type]" id="budget_total" value="Total" type="radio" <?php
                                                if ($this->request->data['Advertisement']['budget_type'] == 'Total') {
                                                    echo 'checked';
                                                }
                                                ?>/>&nbsp;&nbsp;Total Budget
                                            </label> 
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="AdvertisementBudgetPrice" class="col-sm-2 control-label"><?php echo __('Price'); ?>*</label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('budget_price', array('label' => false, 'div' => false, 'placeholder' => 'Budget Price', 'class' => 'form-control numbersOnly budget_inputs')); ?>
                                        <div class="error" id="AdvertisementBudgetPrice_error"></div>
                                    </div>
                                </div>
                                <div class="form-group" id="limit_info_div">
                                    <label for="" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <span class="label label-primary" id="package_lim">No. Of Views : <?php echo $this->request->data['Advertisement']['cpc_left']; ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label"><?php echo __('Schedule'); ?>*</label>
                                    <div class="col-sm-10" style="padding-top:8px;">
                                        <div class="col-xs-5">
                                            <label for="run_daily">
                                                <input name="data[Advertisement][schedule_type]" id="run_daily" value="Immediate" class="range_radio" type="radio" <?php
                                                if ($this->request->data['Advertisement']['schedule_type'] == 'Immediate') {
                                                    echo 'checked';
                                                }
                                                ?>/>&nbsp;&nbsp;Run ad set continuously starting today
                                            </label>
                                        </div>
                                        <div class="col-xs-5">
                                            <label for="run_specific">
                                                <input name="data[Advertisement][schedule_type]" id="run_specific" value="Specific" class="range_radio" type="radio" <?php
                                                if ($this->request->data['Advertisement']['schedule_type'] == 'Specific') {
                                                    echo 'checked';
                                                }
                                                ?>/>&nbsp;&nbsp;Set a start and end date
                                            </label> 
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="form-group" id="range_div">
                                    <label for="AdvertisementCostPerView" class="col-sm-2 control-label"><?php echo __('Date Range'); ?>*</label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('campaign_range', array('label' => false, 'div' => false, 'placeholder' => 'Select Date Range', 'class' => 'form-control')); ?>
                                        <div class="error" id="AdvertisementDateRange_error"></div>
                                    </div>
                                </div>
                                <input type="hidden" name="data[Advertisement][campaign_start]" id="campaign_start" value="<?php echo $this->request->data['Advertisement']['campaign_start']; ?>">
                                <input type="hidden" name="data[Advertisement][campaign_end]" id="campaign_end" value="<?php echo $this->request->data['Advertisement']['campaign_end']; ?>">
                            </div>
                            <div class="box-footer"></div>
                        </div>
                        <input type="hidden" name="data[Advertisement][image]" id="banner_id" value="<?php
                        if (empty($this->request->data['Advertisement']['image'])) {
                            echo "";
                        } else {
                            echo $this->request->data['Advertisement']['image'];
                        }
                        ?>"/>
                        <input type="hidden" name="data[Advertisement][id]" id="id" value="<?php echo $this->request->data['Advertisement']['id']; ?>"/>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" onclick="return admin_add_advertisement(this);" class="btn btn-success"><?php echo __('Submit'); ?></button>
                            </div>
                            <?php /* ?><div class="col-sm-offset-2 col-sm-10">
                              <a class="btn btn-danger" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index', 'admin' => 1));?>"><?php echo __('Cancel'); ?></a>
                              </div><?php */ ?>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div><!-- /.tab-pane -->

                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script>
    var file_counts = 0;
    var page_image_dimensions = JSON.parse('<?php echo $pages_dimensions; ?>');
    var uploaded_image_width;
    var uploaded_image_height;
    var schedule_type = "<?php echo $this->request->data['Advertisement']['schedule_type']; ?>";
    var page_id = "<?php echo $this->request->data['Advertisement']['page_id']; ?>"
    var schedule_start = "<?php echo $this->request->data['Advertisement']['campaign_start']; ?>";
    var schedule_end = "<?php echo $this->request->data['Advertisement']['campaign_end']; ?>";
    var budget_type = "<?php echo $this->request->data['Advertisement']['budget_type']; ?>";
    var banner_url = '<?php echo $this->Html->url(array("controller" => "advertisements", "action" => "edit", "admin" => 1)); ?>';
    var folder_name = "<?php echo preg_replace('/\s+/', '_', $this->request->data['Advertisement']['name']); ?>";
    var send_id = ("<?php echo $this->request->data['Advertisement']['image']; ?>") ? true : false;
    jQuery(document).ready(function($) {
        var date_range_picker_opts = {
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        };
        $('#AdvertisementCampaignRange').daterangepicker(date_range_picker_opts);
        $('#AdvertisementCampaignRange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY')).attr('readonly', true);
            $('#campaign_start').val(picker.startDate.format('YYYY-MM-DD'));
            $('#campaign_end').val(picker.endDate.format('YYYY-MM-DD'));
        });
        $('#AdvertisementCampaignRange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('').attr('readonly', false);
            $('#campaign_start').val('');
            $('#campaign_end').val('');
        });
        if (schedule_type == "Specific") {
            $("#range_div").slideDown();
            //   $("#range_div").show();
            var date1 = new Date(schedule_start);
            var date2 = new Date(schedule_end);
            $('#AdvertisementCampaignRange').data('daterangepicker').setStartDate(date1);
            $('#AdvertisementCampaignRange').data('daterangepicker').setEndDate(date2);
            $('#AdvertisementCampaignRange').val(moment(schedule_start).format('DD/MM/YYYY') + ' - ' + moment(schedule_end).format('DD/MM/YYYY')).attr('readonly', true);
        } else {
            //$("#range_div").slideUp();
            $("#range_div").hide();
        }
        $(".range_radio").on('change', function() {
            if (_.trim($(this).val()) == "Immediate") {
                $("#range_div").slideUp();
                // $("#range_div").hide();
            } else {
                $("#range_div").slideDown();
                //   $("#range_div").show();
            }
        });
        var budget_inputs = $(".budget_inputs");
        budget_inputs.on('change', function() {
            var limit;
            var budget_price = !isNaN(parseInt($('#AdvertisementBudgetPrice').val())) ? parseInt($('#AdvertisementBudgetPrice').val()) : 0;
            var cpc = !isNaN(parseInt($('#AdvertisementCostPerView').val())) ? parseInt($('#AdvertisementCostPerView').val()) : 0;
            if (!empty(budget_price) && !empty(cpc) && (budget_price >= cpc)) {
                limit = _.floor(budget_price / cpc);
                $('#limit_info_div').show();
                $('#package_lim').html('No. Of Views : ' + limit);
            } else {
                $('#limit_info_div').hide();
            }
        });

        $('#AdvertisementPageId').on('change', function() {
            var page_dim_info;
            var page_id = this.value;
            if (page_id) {
                page_dim_info = page_image_dimensions[page_id];
                if (page_dim_info) {
                    var dim_info_spl = _.split(page_dim_info, '-');
                    var dim_info_res = explode('*', trim(dim_info_spl[1]));
                    uploaded_image_width = dim_info_res[0];
                    uploaded_image_height = dim_info_res[1];
                    var info_str = "Note: Please upload image of width " + dim_info_res[0] + "px and height " + dim_info_res[1] + "px";
                    $('#dimension_info_div').show();
                    $('#dimension_lim').html('').html(info_str);
                } else {
                    $('#dimension_info_div').hide();
                    $('#dimension_lim').html('');
                }
            } else {
                $('#dimension_info_div').hide();
                $('#dimension_lim').html('');
            }
        });
        $('#AdvertisementPageId').val(page_id).change();

        $('#dropzone label').click(function() {
            $(this).parent().find('input').click();
        });

        $('#AdvertisementEditForm').fileupload({
            url: banner_url,
            type: 'post',
            dataType: 'json',
            add: function(e, data) {
                var jqXHR;
                var uploadErrors = [];
                var re = /(?:\.([^.]+))?$/;
                var ext = re.exec(data.originalFiles[0]['name'])[1];
                var acceptFileTypes = ['bmp', 'gif', 'png', 'jpg', 'jpeg'];
                if (data.originalFiles[0]['type'].length && $.inArray(ext.toLowerCase(), acceptFileTypes) == -1) {
                    uploadErrors.push('Invalid file format. Please upload  a valid file format.');
                } else if (empty(data.originalFiles[0]['type'].length)) {
                    uploadErrors.push('Invalid file format. Please upload  a valid file format.');
                } else if (data.originalFiles[0]['size'] > 2097152) {
                    uploadErrors.push('Filesize is too big. Please upload files of 2 MB.');
                } else if (!(_.trim($("#AdvertisementPageId").val()))) {
                    uploadErrors.push('Please select page to upload a banner image.');
                } else {
                    _.noop();
                }
                if (uploadErrors.length > 0) {
                    alert(uploadErrors.join("\n"));
                    return false;
                } else if (file_counts > 0) {
                    alert("You can attach up to 5 files Only.");
                    return false;
                } else {
                    jqXHR = data.submit();
                }
            },
            dropZone: $('#dropzone'),
            maxNumberOfFiles: 1,
            progress: function(e, data) {
                $('#spinner_div').show();
            },
            done: function(e, data) {
                var resp_obj = JSON.parse(data.jqXHR.responseText);
                $('#spinner_div').hide();
                if (resp_obj.status == "success") {
                    $('#banner_id').val(resp_obj.tmp_name + '###@###' + resp_obj.file_name);
                    $('.image_preview').find('img').attr('src', resp_obj.file_url);
                    $('#image_size').html(resp_obj.file_size);
                    $('.mailbox-attachment-name').text(resp_obj.file_name);
                    $('.image_delete').attr('data-id', resp_obj.tmp_name);
                    $('.image_preview').show();
                    $('#dropzone').hide();
                    file_counts++;
                } else {
                    alert(resp_obj.textStatus);
                }
            },
            fail: function(e, data) {
                console.log(data);
                alert(data.errorThrown);
                alert(data.textStatus);
                alert(data.jqXHR);
            }

        }).bind('fileuploadsubmit', function(e, data) {
            data.formData = {
                width: uploaded_image_width,
                height: uploaded_image_height
            };
        });
        $(document).on('click', '.image_delete', function() {
            var pid = $(this).attr('data-id');
            var ad_id = (send_id) ? $(this).attr('data-record-id') : "";
            var folder = folder_name;
            var obj = $(this);
            if (confirm('Are you sure to delete the image?')) {
                $('.overlay').show();
                var params = {
                    banner_tmp: pid,
                    ad_id: ad_id,
                    foldername: folder
                }
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller' => 'advertisements', 'action' => 'delete_banner', 'admin' => 1)); ?>",
                    data: params,
                    method: 'post',
                    success: function(response) {
                        $('.overlay').hide();
                        if (response == 'success') {
                            obj.attr('data-id', '');
                            obj.closest('image').attr('src', '');
                            obj.closest('.image_preview').hide();
                            $('#image_size').html('');
                            $('#banner_id').val('');
                            $('#dropzone').show();
                            file_counts--;
                            alert("Banner deleted.");
                        } else {
                            alert("File not found.");
                        }
                    }
                });
            }
        });
    });
</script>