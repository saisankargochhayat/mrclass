<div class="box">
<div class="box-header with-border">
	<i class="ion ion-images"></i>
	<h3 class="box-title"><?php echo __('Upload multiple gallery images.'); ?></h3>
</div><!-- /.box-header -->
<div class="box-body">
<?php
#echo $this->Form->input('business_id', array('options' => $business_list, 'empty' => 'Select Bunsiess'));
echo $this->Form->input('business_id', array('value' => $business_id, 'type' => 'hidden'));
echo $this->Form->input('media', array('type' => 'file', 'multiple', 'name' => 'data[BusinessGallery][media][]', 'label' => false, 'id' => 'BusinessGalleryMedia'));
//echo $this->Form->input('sequence');
?>	<p class="help-block"><?php echo $this->Format->image_add_block_text($subscription,$server_file_size,intval(count($gallery)));?></p>
	<div class="uploading none">Uploading...</div>
	<div class="gallery">
            <ul id="images_preview" class="mailbox-attachments">
            <?php if (is_array($gallery) && count($gallery) > 0) { ?>
                    <?php foreach ($gallery as $val) { ?>
                            <li id="image_li_<?php echo mt_rand(); ?>" class="ui-sortable-handle relative">
                                <span class="mailbox-attachment-icon has-img"><a class="image_link anchor"><img src="<?php echo $this->Format->gallery_image($val, $business_id,191,191,0); ?>" alt="Attachment"></a></span>
                                <div class="mailbox-attachment-info">
                                        <a href="javascript:void(0)" class="mailbox-attachment-name"><i class="fa fa-file-image-o"></i> <?php echo $this->Format->shortLength($val['BusinessGallery']['media'],17,null,'bottom'); ?></a>
                                        <span class="mailbox-attachment-size">
                                                <?php echo $this->Format->FileSizeConvert($val, $business_id); ?>
                                                <a href="javascript:void(0)" data-id="<?php echo $val['BusinessGallery']['id']; ?>" rel="tooltip" title="Click to delete" class="btn btn-default btn-xs pull-right image_delete"><i class="fa  fa-trash"></i></a>
                                        </span>
                                </div>
                            </li>
                    <?php } ?>
            <?php } ?>
            </ul>
	</div>
</div>
<div class="overlay" style="display:none;">
   <i class="fa fa-refresh fa-spin"></i>
 </div>
</div>