<?php
echo $this->Html->script('jquery.form', array('inline' => false));
echo $this->Form->create('BusinessGallery', array('type' => 'file', 'id' => 'BusinessGalleryAddForm'));
?>
<?php 
$server_file_limit = $server_file_size;
if(isset($subscription['Subscription']['photo_limit']) && !empty($subscription['Subscription']['photo_limit']) && ($subscription['Subscription']['photo_limit'] != "Unlimited")){
    $limit = intval($subscription['Subscription']['photo_limit']);
}else if(isset($subscription['Subscription']['photo_limit']) && !empty($subscription['Subscription']['photo_limit']) && ($subscription['Subscription']['photo_limit'] == "Unlimited")){
    $limit = 300;
}else{
    $limit = 300;
}
//$limit = (isset($subscription['Subscription']['photo_limit']) && ($subscription['Subscription']['photo_limit'] != "Unlimited")) ? intval($subscription['Subscription']['photo_limit']) : 300;
$existing_count = intval(count($gallery));
?>
<style type="text/css">
    .none{display: none;}
    #images_preview {margin:20px 0px; float: left; width: 100%; padding: 0px;}
    #images_preview li {float:left; list-style: none; padding: 2px;}
    div.tooltip-inner {max-width: 650px;}
</style>
<section class="content-header">
    <h1><?php echo __('Edit Business'); ?>: <?php echo h($business_list[$business_id]); ?></h1>
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
                        <?php echo $this->element('admin_image_add_block');?>
                    </div>
                    <?php echo $this->Form->end();#__('Submit') ?>
                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
    var server_file_limit = parseInt("<?php echo $server_file_limit;?>");
    var file_limit = parseInt("<?php echo $limit;?>") || 0;
    var existing_images = parseInt("<?php echo $existing_count;?>");
    var max_file_size = 2097152;
    $(document).ready(function () {
        update_file_button(file_limit,existing_images);
        $('#BusinessGalleryMedia').on('change', function () {
            var files = document.getElementById('BusinessGalleryMedia').files;
            for(file_prop in files){
                if(typeof files[file_prop] == "object"){
                    if(parseInt(files[file_prop]['size']) > max_file_size){
                        $('#BusinessGalleryMedia').val('');
                        alert("Please upload files of size below 2 MB.");
                        return false;
                    }
                }
            }
	        if (file_limit) {
	            if (existing_images) {
	                if (parseInt(files.length) > parseInt((file_limit - existing_images))) {
	                    if(parseInt(file_limit - existing_images)){
                                alert("Sorry. Based on business owner's subscription package, you can upload " + parseInt(file_limit - existing_images) + " more images only.");
                            }else{
                               alert("Sorry. Business owner's maximum photo upload limit reached. Business owner needs to upgrade the subscription package."); 
                            }
                        $('#BusinessGalleryMedia').val('');
	                return false;
	                }
	            }
	            if (parseInt(files.length) > file_limit) {
	                alert("Sorry. Based on business owner's subscription package, you can not upload more than " + file_limit + " images.");
                        $('#BusinessGalleryMedia').val('');
                        return false;
	            }
	        }
			if (parseInt(files.length) > server_file_limit) {
	            alert("Please upload "+server_file_limit+" images at a time.");
                $('#BusinessGalleryMedia').val('');
                return false;
	        }
	        existing_images = existing_images + parseInt(files.length);
            $('#BusinessGalleryAddForm').ajaxForm({
                target: '#images_preview',
                append: true,
                beforeSubmit: function (e) {
                    $('.uploading').show();
                },
                success: function (data, status, xhr) {
                    $('.uploading').hide();
                    $('#BusinessGalleryMedia').val('');
                    update_file_button(file_limit,existing_images);
                },
                error: function (e) {
                }
            }).submit();
        });
        $(document).on('click', '.image_delete', function () {
            var pid = $(this).attr('data-id');
            var obj = $(this);
            $( "#dialog" ).dialog();
            if (confirm('Are you sure to delete the image?')) {
                $('.overlay').show();
                var params = {id: pid}
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller' => 'business_galleries', 'action' => 'delete', 'admin' => 1)); ?>",
                    data: params,
                    method: 'post',
                    success: function (response) {
                        $('.overlay').hide();
                        if (response == 'Success') {
                            obj.closest('li').remove();
                            existing_images--;
                            update_file_button(file_limit,existing_images);
                        }
                    }
                });
            }
        });
    });
function update_file_button(file_limit,existing_images){
    var file_button = $('#BusinessGalleryMedia');
    var attr = file_button.attr('disabled');
    if(existing_images < file_limit){
        if (typeof attr !== 'undefined') {
            //console.log(typeof attr);
            file_button.css('cursor', 'pointer');
            file_button.removeAttr('disabled');
            file_button.removeAttr('title');
        }
    }else{
        file_button.css('cursor', 'not-allowed');
        file_button.attr('disabled', true);
        file_button.attr('title', 'Maximum image upload limit reached');
    }
}
</script>
