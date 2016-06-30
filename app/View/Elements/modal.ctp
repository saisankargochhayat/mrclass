<div class="example-modal">
    <div class="modal" id="categoryAddModal">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- For Editing Subcategories -->

<div class="example-modal">
    <div class="modal" id="categoryEditModal">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<!-- For Adding Subcategories -->

<!-- For Adding and editing City -->
<div class="example-modal">
    <div class="modal" id="cityAddModal">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- For Adding  and editing City End -->

<!-- For Adding and editing City -->
<div class="example-modal">
    <div class="modal" id="localityAddModal">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- For Adding  and editing City End -->

<!-- For Adding and Editing facilities -->
<div class="example-modal">
    <div class="modal" id="facilityModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo $this->Form->create('Facility', array('action' => 'add_facility', 'admin' => 1)); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo __('Add Facility'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="facility_Name"><?php echo __('Enter Facility Name'); ?></label>
                        <?php echo $this->Form->input('name', array('class' => 'form-control', 'id' => 'facility_Name', 'div' => false, 'label' => false)); ?>
                    </div>
                    <div class="form-group">
                        <label for="select"><?php echo __('Choose Facility Icon'); ?></label>
                        <select class="form-control select2" id="select" style="width: 100%;" name="data[Facility][image]">
                            <option value=''></option>
                        </select>
                        <div class="error" id="selectErr"></div>
                        <label id="select-error" class="error" for="select" style="display:none;"><font color="red" size="2px">Please select facility icon.</font></label>
                    </div>
                    <div class="form-group">
                        <label for="facility_Color"><?php echo __('Enter Color Code'); ?></label>
                        <div class="input-group my-colorpicker2">
                            <?php echo $this->Form->input('color', array('class' => 'form-control', 'id' => 'facility_Color', 'div' => false, 'label' => false)); ?>
                            <div class="input-group-addon"><i></i></div>
                        </div><!-- /.input group -->
                    </div>
                    
                    <input type="hidden" name="user_icon_class_val" id='user_icon_class_val' value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancel'); ?></button>
                    <button type="button" class="btn btn-primary" onclick="validate_facility();"><?php echo __('Save'); ?></button>
                </div>
                <?php echo $this->Form->end(); ?>

            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- For Adding Facilty End -->

<!-- Editing facilities -->
<div class="example-modal">
    <div class="modal" id="facilityEditModal">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- Editing City End -->


<!-- For Adding and Editing facilities -->
<div class="example-modal">
    <div class="modal" id="edit_facility">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo $this->Form->create('Facility', array('action' => 'edit_facility_form', 'admin' => 1)); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo __('Edit Facility'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""><?php echo __('Facility Name'); ?></label>
                        <?php echo $this->Form->input('name', array('class' => 'form-control', 'id' => 'edit_facility_name', 'div' => false, 'label' => false)); ?>
                    </div>
                    <div class="form-group">
                        <label for=""><?php echo __('Choose Facility Icon'); ?></label>
                        <select class="form-control select2" id="edit_facility_select" style="width: 100%;" name="data[Facility][image]">
                            <option value=''></option>
                        </select>
                        <div class="error" id="edit_facility_selectErr"></div>
                    </div>
                    <!-- Color Picker -->
                    <div class="form-group">
                        <label for="edit_facility_color"><?php echo __('Enter Color Code'); ?></label>
                        <div class="input-group my-colorpicker2">
                            <?php echo $this->Form->input('color', array('class' => 'form-control', 'id' => 'edit_facility_color', 'div' => false, 'label' => false)); ?>
                            <div class="input-group-addon"><i></i></div>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                    <input type="hidden" name="edit_user_icon_class_val" id='edit_user_icon_class_val' value="">
                    <input type="hidden" name="facility_id" id='facility_id' value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" ><?php echo __('Cancel'); ?></button>
                    <button type="button" class="btn btn-primary" onclick="validate_edit_facility();"><?php echo __('Save'); ?></button>
                </div>
                <?php echo $this->Form->end(); ?>

            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- For Adding Facilty End -->

<!-- Editing review comment -->
<div class="example-modal pop-up-box">
    <div class="modal" id="edit_rating_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo $this->Form->create('BusinessRating', array('action' => 'admin_save_rating_content', 'admin' => 1)); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo __('Edit Review'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="fl"><?php echo __('Edit Rating'); ?></label>
                        <div class="fl" style="margin-left: 10px;margin-top: 3px;">
                            <div class="rateit12" id="rateit9" style="width: 100px;"  data-rateit-ispreset="true"></div>
                            <?php echo $this->Form->input('rating', array('type' => 'hidden', "id" => "backingfld")); ?>
                            <span id="backingfld_span" style="color:#EA632C; margin-left:5px;"></span>
                        </div>
                        <div class="cb"></div>
                    </div>
                    <div class="cb"></div>
                
                    <div class="form-group">
                        <label for=""><?php echo __('Edit Comment'); ?></label>
                        <?php echo $this->Form->input('comment', array('type' => 'textarea', 'class' => 'form-control', 'id' => 'edit_rating_content', 'div' => false, 'label' => false)); ?>
                        <?php echo $this->Form->input('id', array('type' => 'hidden', "id" => "rating_hid_id", "value" => "")); ?>
                        <?php echo $this->Form->input('business_id', array('type' => 'hidden', "id" => "rating_bid_id", "value" => "")); ?>
                        <?php echo $this->Form->input('param_text', array('type' => 'hidden', "id" => "rating_param_text", "value" => "")); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" ><?php echo __('Cancel'); ?></button>
                    <button type="button" class="btn btn-primary" onclick="return rating_content_valid();"><?php echo __('Save'); ?></button>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- For Adding Facilty End -->

<!-- For Exporting Business records -->
<div class="example-modal">
    <div class="modal" id="myExportModal">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- For Exporting Business records End -->

<!-- For Exporting Users records -->
<div class="example-modal">
    <div class="modal" id="myUserExportModal">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- For Exporting Business records End -->

<!-- For Adding and Editing facilities -->
<div class="example-modal">
    <div class="modal" id="ad_page_modal_box">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo $this->Form->create('AdvertisementPage', array('action' => 'add', 'admin' => 1, 'onsubmit'=> 'validate_ad_page()')); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="ad_page_form_header"><?php echo __('Add Advertisement Page'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ad_page_Name"><?php echo __('Enter Facility Name'); ?>*</label>
                        <?php echo $this->Form->input('name', array('class' => 'form-control', 'id' => 'ad_page_Name', 'div' => false, 'label' => false)); ?>
                    </div>
                    <div class="form-group">
                        <label for="ad_page_description"><?php echo __('Enter Description'); ?></label>
                        <?php echo $this->Form->input('description', array('type'=>'textarea','class' => 'form-control', 'rows' => 2, 'id' => 'ad_page_description', 'div' => false, 'label' => false)); ?>
                    </div>
                    <input type="hidden" name="data[AdvertisementPage][id]" id='ad_page_id' value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancel'); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo __('Save'); ?></button>
                </div>
                <?php echo $this->Form->end(); ?>

            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- For Adding Facilty End -->
<?php if($parms['controller'] == "questionCategories" && $parms['action'] == "admin_index"){?>
<!-- For Adding and Editing Question categories -->
<div class="example-modal">
    <div class="modal" id="add_cat_ques_modal_box">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo $this->Form->create('QuestionCategory', array('action' => 'add', 'admin' => 1)); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="ad_ques_cat_form_header"><?php echo __('Add Question Category'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ad_q_cat_Name"><?php echo __('Enter Category Name'); ?>*</label>
                        <?php echo $this->Form->input('name', array('class' => 'form-control', 'id' => 'ad_q_cat_Name', 'div' => false, 'label' => false)); ?>
                        <div id="ad_q_cat_Name_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="ad_q_cat_description"><?php echo __('Enter Description'); ?></label>
                        <?php echo $this->Form->input('description', array('type'=>'textarea','class' => 'form-control', 'id' => 'ad_q_cat_description', 'div' => false, 'label' => false)); ?>
                        <div id="ad_q_cat_description_error"></div>
                    </div>
                    <input type="hidden" name="data[QuestionCategory][id]" id='ad_q_cat_id' value="">
                <?php echo $this->Form->end(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="add_q_cat_button" onclick="validate_ad_q_cat();"><?php echo __('Save'); ?></button>
                </div>

            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- For Adding/Editing Question categories End -->
<?php }?>

<?php if($parms['controller'] == "questions" && $parms['action'] == "admin_index"){?>
<!-- For Editing Question -->
<div class="example-modal">
    <div class="modal" id="add_ques_modal_box">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo $this->Form->create('Question', array('action' => 'add', 'admin' => 1)); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="ad_ques_form_header"><?php echo __('Update Question Bank Details'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ad_q_cat_Name"><?php echo __('Enter Title'); ?>*</label>
                        <?php echo $this->Form->input('title', array('class' => 'form-control', 'id' => 'ad_q_Name', 'div' => false, 'label' => false)); ?>
                        <div id="ad_q_Name_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="ad_q_cat_description"><?php echo __('Enter Description'); ?></label>
                        <?php echo $this->Form->input('description', array('type'=>'textarea','class' => 'form-control', 'id' => 'ad_q_description', 'div' => false, 'label' => false)); ?>
                        <div id="ad_q_description_error"></div>
                    </div>
                    <input type="hidden" name="data[Question][id]" id='ad_q_id' value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="add_q_button" onclick="validate_ad_q();"><?php echo __('Update'); ?></button>
                </div>
                <?php echo $this->Form->end(); ?>

            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- For Editing QuestionEnd -->
<?php }?>