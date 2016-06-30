<style type="text/css">
    .inactiveLink{cursor: not-allowed;}
    .inactiveLink:hover{border: 2px solid #FFE2A6;box-shadow: 0px 1px 2px #666;background: #FFE2A6;color: #fff;}
</style>
<?php
if (isset($subscription['Subscription']['video_limit']) && !empty($subscription['Subscription']['video_limit'])) {
    $video_limit = intval($subscription['Subscription']['video_limit']);
} else if (isset($subscription['Subscription']['photo_limit']) && empty($subscription['Subscription']['video_limit'])) {
    $video_limit = 0;
} else {
    $video_limit = 10;
}
$existing_video_count = count($galleries);
$block_video_count = ($existing_video_count > 0) ? $existing_video_count : 1;
?>
<div class="content-full add-utube-video-link">
    <div class="content-left fl">
        <?php echo $this->element('user_inner_left_navbar'); ?>
    </div>
    <div class="content-right fl">
	<div class="heading"><span class="edit-business"></span> Add Youtube Video Links</div>
        <div class="cb"></div>
        <?php echo $this->element('front_edit_business_tabs', array('BusinessId' => $business_id)); ?>
        <div class="cb"></div>
        <div class="bg-trns-white pdtop_gly">
                <?php echo $this->Form->create('BusinessGallery'); ?>
                <div class="field_wrapper pad40">
                    <?php if (count($galleries) > 0) { ?>
                        <?php
                        $cntr = 0;
                        foreach ($galleries as $key => $value) {
                            ?>
                            <div class="form-group" style="">
                                <div style="" class="width80per fl url_input_class">
                                    <input id="" name="data[BusinessGallery][<?php echo $key; ?>][media]"  type="text" class="url_input form-control" value="<?php echo @$value['BusinessGallery']['media']; ?>" placeholder="Video URL"/>
                                    <input id="" name="data[BusinessGallery][<?php echo $key; ?>][business_id]" type="hidden" value="<?php echo @$value['BusinessGallery']['business_id']; ?>"/>
                                    <input id="" name="data[BusinessGallery][<?php echo $key; ?>][type]" type="hidden" value="video"/>
                                    <input id="" name="data[BusinessGallery][<?php echo $key; ?>][id]" type="hidden" value="<?php echo @$value['BusinessGallery']['id']; ?>"/>
                                </div>
                                <div class='remove_more_url_glyph'>
                                    <a href="javascript:void(0)" title="Remove" class="remove_url_row" data-urlId="<?php echo @$value['BusinessGallery']['id']; ?>"><i class="fa fa-minus-circle"></i></a>
                                </div>
                            </div>
                            <?php $cntr++; ?>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="form-group" style="">
                            <div style="" class="width80per fl url_input_class">
                                <input id="" name="data[BusinessGallery][0][media]"  type="text" class="form-control url_input" value="" placeholder="Video URL"/>
                                <input id="" name="data[BusinessGallery][0][business_id]"  type="hidden" class="form-control"  value="<?php echo $business_id; ?>"/>
                                <input id="" name="data[BusinessGallery][0][type]" type="hidden" class="form-control" value="video"/>
                                <input id="" name="data[BusinessGallery][0][id]" type="hidden" class="form-control" value=""/>
                            </div>
                            <div class='remove_more_url_glyph'>
                                <a href="javascript:void(0)" title="Remove" class="remove_url_row" data-urlId="<?php echo @$value['BusinessGallery']['id']; ?>"><i class="fa fa-minus-circle"></i></a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="cb"></div>
                <div class="form-group" >
                    <div class='add_more_url_glyph' style="padding-left:80%;">
                            <a href="javascript:void(0)" title="Add more" class="add_button"><i class="fa fa-plus-circle"></i></a>
                        </div>
                </div>
                <div class="cb"></div>
                <div><button class="cmn_btn_n pad_big" type="submit">Submit</button></div>
                <div class="cb20"></div>
                <p style="font-size:13px; "><b>NOTE:</b> <?php echo  Configure::read('COMPANY.NAME');?> reserves the right to screen each & every file you upload. Improper/shaky/darkened/indecent pictures or videos of any kind will be filtered out without any notice. Repeated mistakes may result in cancellation of your listing without any refund.</p>
            <div class="cb"></div>
       </div>
       <div class="cb20"></div>
       <?php echo $this->Form->end(); ?>
    </div>
    <div class="cb20"></div>
</div>
<script>
    var video_limit = parseInt("<?php echo $video_limit;?>");
    var existing_video = parseInt("<?php echo count($galleries); ?>");
    var block_video_count = parseInt("<?php echo $block_video_count;?>");
    var counter = (video_limit) ? ((existing_video) ? (existing_video + 1) - 1  : 1) : 1;
$(document).ready(function() {
    var addButton = $('.add_button');
    var wrapper = $('.field_wrapper');
    if(!(video_limit)){
            update_elements();
    }
    var fieldHTML_blk = $(wrapper).find('.form-group').eq(0).clone();
    $(addButton).on('click', function() {
        if (counter < video_limit) {
            fieldHTML = fieldHTML_blk.clone();
            counter++;
            block_video_count++;
            $(fieldHTML).find(".remove_url_row").attr('data-urlid','');
            var sel = $(fieldHTML).find('.url_input_class');
            $(sel).find("input[type='text']").val('');
            $(sel).find("input[type='hidden'][name$='[id]']").val('');
            $(sel).find('input').each(function() {
                var type = $(this).attr('type');
                var oldname = $(this).attr('name');
                if (typeof oldname !== 'undefined') {
                    var newname = oldname.replace(/\d+/, block_video_count);
                    $(this).attr('name', newname);
                }
            });
            $(wrapper).append(fieldHTML);
            
        } else {
            (video_limit) ? alert('Sorry! you have reached your limit. you can not add more videos.','error') : alert('Sorry! you can not add more than '+maxField+' videos.','error');
        }
    });
    $(wrapper).on('click', '.remove_url_row', function(event) {
        var attr = $(this).attr('data-urlId');
        var obj = $(this);
        if (typeof attr !== 'undefined' && attr !== '') {
            confirm("Are You Sure want to delete the youtube video Url?", function() {
                $('.overlay_div').show();
                $.ajax({
                    type: "POST",
                    data: {
                        id: attr
                    },
                    url: "<?php echo $this->Html->url(array('controller' => 'business_galleries', 'action' => 'delete')); ?>",
                    success: function(response) {
                        $('.overlay_div').hide();
                        if (response == "Success") {
                            obj.closest('.form-group').remove();
                        }
                    }
                });
            });
        } else {
            $(this).closest('.form-group').remove();
        }
        counter--;
    });
    $('#BusinessGalleryAddVideoLinkForm').validate({
        submitHandler: function(form) {
            General.hideAlert('now');
            var error_arr = youtube_parser();
            var error_string_alert = "Empty (or) Invalid Url Format at ";
            if (error_arr.length > 0) {
                General.hideAlert();
                for (var i = 0; i < error_arr.length; i++) {
                    error_string_alert += error_arr[i] + ", ";
                }
                error_string_alert = error_string_alert.replace(/,\s*$/, "");
                alert(error_string_alert,'error');
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
    $(".url_input").removeClass('err');
    $(".url_input").each(function() {
        var input_url = $(this).val();
        var valid = ytVidId(input_url);
        if (typeof valid === "boolean" && valid === false) {
            $(this).addClass('err');
            error_url_arr.push("row " + row_cntr);
        }
        row_cntr++;
    });
    $('.err').eq(0).focus();
    return error_url_arr;
}

function ytVidId(url) {
    var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
    return (url.match(p)) ? RegExp.$1 : false;
}
function update_elements(){
	$('.url_input_class').find('input[type="text"]:first').attr({'disabled':true,'title':'Sorry, you can not add videos. Please upgrade your subscription package.'});
        $("body").off("click", ".add_button");
        $('.pdtop_gly').find('.cmn_btn_n').addClass('inactiveLink').attr('type','button');
}
</script>