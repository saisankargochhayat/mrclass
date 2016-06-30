<div class="width_100">
		<div class="form-group">
                <label>Upload Multiple Gallery Images</label>
                <div class="cb" style="padding:5px;"></div>
                <div class="upload-div-sub">
                    <span class="fl"><img src="<?php echo HTTP_ROOT; ?>images/form/attach_btn.png"></span>
                    <span class="up-text fl p_pic_name" style="font-style:normal;">Attach File</span>
                    <input type="file" name="data[BusinessGallery][media][]" class="attach-img-sub" multiple="multiple" id="BusinessGalleryMedia" required="required">
                    <div class="cb"></div>

                </div>
            </div>
        <div class="uploading none">Uploading...</div>
            <div class="gallery">
                <ul id="images_preview" class="reorder_ul reorder-photos-list">
                    <?php if (is_array($gallery) && count($gallery) > 0) { ?>
                        <?php foreach ($gallery as $val) { ?>
                            <li id="image_li_<?php echo mt_rand(); ?>" class="ui-sortable-handle relative">
                                <a class="image_delete anchor" data-id="<?php echo $val['BusinessGallery']['id']; ?>"></a>
                                <a class="image_link anchor">
                                    <img class="colorbox lazy" rel="gal" data-href="<?php echo $this->Format->gallery_image($val, $business_id,500,500); ?>" src="<?php echo $this->Format->gallery_image($val, $business_id,200,200); ?>" data-original="<?php echo $this->Format->gallery_image($val, $business_id,200,200); ?>" alt="">
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="cb"></div>
        <p>The better your photos are, the better your profile will look.</p>
        <p style="font-size:13px; "><b>NOTE:</b> <?php echo $this->Format->image_add_block_text($subscription,$server_file_size,intval($image_count));?> <?php echo  Configure::read('COMPANY.NAME');?> reserves the right to screen each & every file you upload. Improper/shaky/darkened/indecent pictures or videos of any kind will be filtered out without any notice. Repeated mistakes may result in cancellation of your listing without any refund.</p>
