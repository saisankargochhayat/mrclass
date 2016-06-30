<?php echo $this->Form->create('Facility',array('action'=>'edit_facility','admin'=>1)); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><?php echo __('Edit Facility'); ?></h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <label for="City_Name"><?php echo __('Enter Facility Name'); ?></label>
        <?php echo $this->Form->input('name', array('class' => 'form-control', 'id' => 'edit_facility_Name', 'div' => false, 'label' => false)); ?>
    </div>
    <div class="form-group">
        <label for="City_Status"><?php echo __('Choose Facility Icon'); ?></label>
        <select class="form-control select2" id="select1" style="width: 100%;" name="data[Facility][image]">
                      <option value=''></option>
                      <option>&lt;i class='fa fa-check'>&lt;/i></option>
                      <option>&lt;i class='fa fa-battery-full'>&lt;/i></option>
                      <option>&lt;i class='fa fa-comment-o'>&lt;/i></option>
                      <option>&lt;i class='fa fa-graduation-cap'>&lt;/i></option>
                      <option>&lt;i class='fa fa-expeditedssl'>&lt;/i></option>
                      <option>&lt;i class='fa fa-get-pocket'>&lt;/i></option>
                      <option>&lt;i class='ion ion-arrow-down-c'>&lt;/i></option>
        </select>
<label id="select-error" class="error" for="select" style="display:none;"><font color="red" size="2px">Please select facility icon.</font></label>
    </div>
<input type="hidden" name="user_icon_class_val1" id='user_icon_class_val1' value="">
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancel'); ?></button>
    <button type="button" class="btn btn-primary" onclick="validate_facility();"><?php echo __('Save'); ?></button>
</div>
<?php echo $this->Form->end(); ?>
