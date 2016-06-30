<?php
if(isset($subscription['Subscription']['video_limit']) && !empty($subscription['Subscription']['video_limit'])){
    $video_limit = intval($subscription['Subscription']['video_limit']);
}else if(isset($subscription['Subscription']['photo_limit']) && empty($subscription['Subscription']['video_limit'])){
    $video_limit = 0;
}else{
    $video_limit = 10;
}
$existing_video_count = count($galleries);
$admin_block_video_count = ($existing_video_count > 0) ? $existing_video_count : 1;
?>
<section class="content-header">
    <h1><?php echo __('Edit Business'); ?>: <?php echo h($business['Business']['name']);?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'index', 'admin' => 1)); ?>">Businesses</a></li>
        <li class="active"><?php echo __('Edit Business'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <?php echo $this->element('admin_business_edit_tabs'); ?>
                <div class="tab-content">
                    <div class="active tab-pane" id="timings">
                        <?php echo $this->Form->create('BusinessGallery', array('class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
                        <div class="box">
                            <div class="box-header with-border">
                                <i class="fa  fa-youtube"></i>
                                <h3 class="box-title"><?php echo __('Add Youtube Video Links'); ?></h3>
                            </div><!-- /.box-header -->
                            <div class="box-body ">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width:80%;">Youtube Links</th>
                                            <th style="width:20%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="field_wrapper">
								<?php if (count($galleries) > 0) { ?>
                                <?php $cntr = 0;
                                foreach ($galleries as $key => $value){ ?>
                                        <tr>
                                            <td>
                                                <input id="" name="data[BusinessGallery][<?php echo $key;?>][media]"  type="text" class="form-control url_input" value="<?php echo @$value['BusinessGallery']['media'];?>">
                                                <input id="" name="data[BusinessGallery][<?php echo $key;?>][business_id]"  type="hidden" class="form-control"  value="<?php echo @$value['BusinessGallery']['business_id'];?>">
                                                <input id="" name="data[BusinessGallery][<?php echo $key;?>][type]" type="hidden" class="form-control" value="video">
                                                <input id="" name="data[BusinessGallery][<?php echo $key;?>][id]" type="hidden" class="form-control" value="<?php echo @$value['BusinessGallery']['id'];?>">
                                            </td>
                                            <td style="text-align:center;">
                                                <button class="btn btn-social-icon btn-google remove_button" data-urlId="<?php echo @$value['BusinessGallery']['id'];?>" type="button"  rel="tooltip" title="Remove"><i class="ion-minus-circled"></i></button>
                                            </td>
                                        </tr>
                                    <?php $cntr++;?>
                                <?php } ?>
                               <?php } else { ?>
                                        <tr>
                                            <td>
                                                <input id="" name="data[BusinessGallery][0][media]"  type="text" class="form-control url_input" value="">
                                                <input id="" name="data[BusinessGallery][0][business_id]"  type="hidden" class="form-control"  value="<?php echo $business_id;?>">
                                                <input id="" name="data[BusinessGallery][0][type]" type="hidden" class="form-control" value="video">
                                                <input id="" name="data[BusinessGallery][0][id]" type="hidden" class="form-control" value="">
                                            </td>
                                            <td style="text-align:center;">
                                                <button class="btn btn-social-icon btn-google remove_button" data-urlId="" type="button" rel="tooltip" title="Remove"><i class="ion-minus-circled"></i></button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <div class=" fr" style="margin-right:81px; margin-top: 10px;">
                                    <button class="btn btn-success btn-social-icon add_button" rel="tooltip" title="Add More" type="button" ><i class="ion-plus-circled"></i></button>
                                </div>
                            </div><!-- /.Box Body -->
                            <div class="overlay" style="display:none;">
                               <i class="fa fa-refresh fa-spin"></i>
                             </div>
                             <div class="box-footer" id="message_text">
                                 <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <button class="btn btn-success btn-block" type="submit" >Save</button>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>
                        </div><!-- /.Box -->
                        <?php echo $this->Form->end(); ?>
                    </div><!-- /.tab-pane -->    
                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script>
    var video_limit = parseInt("<?php echo $video_limit;?>");
    var existing_video = parseInt("<?php echo count($galleries); ?>");
    var counter = (video_limit) ? ((existing_video) ? (existing_video + 1) - 1 : 1) : 1;
    var admin_add_video_count = parseInt("<?php echo $admin_block_video_count;?>");
    $(document).ready(function () {
        var addButton = $('.add_button');
        var wrapper = $('.field_wrapper');
        
        if(!(video_limit)){
			update_elements();
            }
        var fieldHTML_blk = $(wrapper).find('tr:first').clone();
        $(addButton).on('click', function () {
            fieldHTML = fieldHTML_blk.clone();
            if (counter < video_limit) {
                counter++;
                admin_add_video_count++;
                $(fieldHTML).find('.remove_button').attr('data-urlid','');
                $(fieldHTML).find('input:text').val('');
                $(fieldHTML).find("input[type='hidden'][name$='[id]']").val('');
                $(fieldHTML).find('td:nth-child(1)').find('input').each(function () {
                    var type = this.type;
                    var oldname = $(this).attr('name');
                    if (typeof oldname != 'undefined') {
                        var newname = oldname.replace(/\d+/, admin_add_video_count);
                        $(this).attr('name', newname);
                    }
                });
                $(wrapper).append(fieldHTML);
            }else{
                (video_limit) ? alert('Sorry ! you can add only '+video_limit+' videos.') : alert('Sorry! you can not add more than '+maxField+' videos.');
            }
            //if (counter == video_limit) {}
        });
        $(wrapper).on('click', '.remove_button', function (e) {
            //e.preventDefault();
            var attr = $(this).attr('data-urlId');
            if (typeof attr !== 'undefined' && attr !== '') {
                if (confirm("Are You Sure want to delete the youtube video Url?")) {
                    $('.overlay').show();
                    $.ajax({
                        type: "POST",
                        data: {id: attr},
                        url: "<?php echo $this->Html->url(array('controller' => 'business_galleries', 'action' => 'delete', 'admin' => 1)); ?>",
                        success: function (response) {
                            if (response) {
                                $('.overlay').hide();
                                //console.log(response);
                            }
                            $(this).closest('tr').remove();
                            counter--;
                        }
                    });
                }
            }else{
                $(this).closest('tr').remove();
                counter--;
            }
        });
        $('#BusinessGalleryAdminAddVideoLinkForm').validate({
            submitHandler: function (form) {
                var error_arr = youtube_parser();
                var error_string_alert = "Empty (or) Invalid Url Format at ";
                if (error_arr.length > 0) {
                    for (var i = 0; i < error_arr.length; i++) {
                        error_string_alert += error_arr[i] + ", ";
                    }
                    error_string_alert = error_string_alert.replace(/,\s*$/, "");
                    alert(error_string_alert);
                    return false;
                } else {
                    return true;
                }
            }
        });
    });

    function youtube_parser() {
        var error_url_arr = [];
        var row_cntr = 1;
        $(".url_input").each(function () {
            var input_url = trim($(this).val());
            var valid = ytVidId(input_url);
            if (typeof valid === "boolean" && valid === false) {
                error_url_arr.push("row " + row_cntr);
            }
            row_cntr++;
        });
        return error_url_arr;
    }
    function ytVidId(url) {
        var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
        return (url.match(p)) ? RegExp.$1 : false;
    }
	function update_elements(){
		var url_field = $('.field_wrapper').find('input[type="text"]:first');
		url_field.attr('disabled',true);
		url_field.attr('title','Sorry, you can not add videos. User needs to upgrade the subscription package.');
		 $("body").off("click", ".add_button");
		 var submit = $('.row').find('.btn-success');
         $('#message_text').html('<span class="label label-danger">Sorry, you can not add videos. User needs to upgrade the subscription package.</span>');
		 $(submit).addClass('inactiveLinkadmin');
		 $(submit).attr('type','button');
	}
</script>