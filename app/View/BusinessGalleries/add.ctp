<?php echo $this->Html->script(array('jquery.form'), array('inline' => false));?>
<?php echo $this->Html->script(array('jquery.lazyload.min'), array('block' => 'lazyLoad'));?>
<?php 
$server_file_limit = $server_file_size;
if(isset($subscription['Subscription']['photo_limit']) && !empty($subscription['Subscription']['photo_limit']) && ($subscription['Subscription']['photo_limit'] != "Unlimited")){
	$limit = intval($subscription['Subscription']['photo_limit']);
}else if(isset($subscription['Subscription']['photo_limit']) && !empty($subscription['Subscription']['photo_limit']) && ($subscription['Subscription']['photo_limit'] == "Unlimited")){
	$limit = 300;
}else{
	$limit = 300;
}
$existing_count = intval($image_count);
 ?>
<div class="content-full add-business-gallery">
    <div class="content-left fl">
        <?php echo $this->element('user_inner_left_navbar');?>
    </div>
    <div class="content-right fl">
        <div class="heading"><span class="edit-business"></span> Upload Gallery Images</div>
        <?php echo $this->element('front_edit_business_tabs',array('BusinessId'=>$business_id));?>
	<div class="cb"></div>
	<?php echo $this->Form->create('BusinessGallery', array('enctype' => 'multipart/form-data'));?>
	<?php echo $this->Form->input('business_id', array('value' => $business_id, 'type' => 'hidden'));?>
	<div class="bg-trns-white pdtop_gly">
		<?php echo $this->element('image_add_block');?>
        <div class="cb20"></div>
	</div>
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="cb20"></div>
</div>
<script type="text/javascript">
    var server_file_limit = parseInt("<?php echo $server_file_limit;?>");
    var file_limit = parseInt("<?php echo $limit;?>") || 0;
	var existing_images = parseInt("<?php echo $existing_count;?>");
	var max_file_size = 2097152;
	var _animated_css = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
	$(document).ready(function() {
            update_file_button(file_limit,existing_images);
            $("img.lazy").lazyload({effect : "fadeIn"}).removeClass('lazy');
            $('.colorbox').colorbox({rel: 'gal'});
	    $('#BusinessGalleryMedia').on('change', function() {
	        var files = document.getElementById('BusinessGalleryMedia').files;
	        for(file_prop in files){
                if(typeof files[file_prop] == "object"){
                    if(parseInt(files[file_prop]['size']) > max_file_size){
                        $('#BusinessGalleryMedia').val('');
                        alert("Please upload files of size below 2 MB.", "error");
                        return false;
                    }
                }
            }
	        if (file_limit) {
	            if (existing_images) {
	                if (parseInt(files.length) > parseInt((file_limit - existing_images))) {
	                    if(parseInt(file_limit - existing_images)){
							alert("Sorry. You can upload " + parseInt(file_limit - existing_images) + " more images only.", "error");
                        }else{
                           alert("Sorry. Your maximum photo upload limit reached. Please upgrade your subscription package.", "error"); 
                        }
	                    return false;
	                }
	            }
	            if (parseInt(files.length) > file_limit) {
	                alert("Sorry. You can not upload more than " + file_limit + " images.", "error");
	                return false;
	            }
	        }
			if (parseInt(files.length) > server_file_limit) {
	            alert("Please upload "+server_file_limit+" images at a time.","error");
                $('#BusinessGalleryMedia').val('');
                return false;
	        }
	        existing_images = existing_images + parseInt(files.length);
	        $('#BusinessGalleryAddForm').ajaxForm({
	            target: '#images_preview',
	            append: true,
	            beforeSubmit: function(e) {
	                $('.uploading').show();
	            },
	            success: function(data, status, xhr) {
	            	var new_imgs_li = $("#images_preview").find(".effects");
	                $('.uploading').hide();
	                $(new_imgs_li).addClass('animated zoomIn').one(_animated_css, function () {
                 		$(new_imgs_li).removeClass('animated zoomIn effects');
            		});
	                $('#BusinessGalleryMedia').val('');
	                $("#images_preview").find(".colorbox").colorbox({rel: 'gal'});
	                update_file_button(file_limit,existing_images);
	            },
	            error: function(e) {}
	        }).submit();
	    });
	    $(document).on('click', '.image_delete', function() {
	        var pid = $(this).attr('data-id');
	        var obj = $(this);
	        confirm('Are you sure to delete the image?', function() {
	            var params = {
	                id: pid
	            }
                    $('.overlay_div').show();
	            $.ajax({
	                url: "<?php echo $this->Html->url(array('controller' => 'business_galleries', 'action' => 'delete')); ?>",
	                data: params,
	                method: 'post',
	                success: function(response) {
	                    if (response == 'Success') {
                            $('.overlay_div').hide();
	                        obj.closest('li').addClass('animated zoomOut').one(_animated_css, function () {
                 				obj.closest('li').remove();
            				});
	                        existing_images--;
	                        update_file_button(file_limit,existing_images);
	                    }
	                }
	            });
	        });
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
