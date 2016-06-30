<?php echo $this->Form->create('City'); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><?php echo __('Edit City'); ?></h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <label for="City_Name"><?php echo __('State'); ?></label>
        <?php echo $this->Form->input('state', array('options' => $states, 'selected' => $city['City']['state'],'class' => 'form-control select2', 'id' => 'City_State', 'div' => false, 'label' => false)); ?>
    </div>
    <div class="form-group">
        <label for="City_Name"><?php echo __('City Name'); ?></label>
        <input class="form-control" name="data[City][name]" value="<?php echo $city['City']['name']; ?>">
    </div>
    <div class="form-group">
        <label for="City_editStatus"><?php echo __('Status'); ?></label>
        <?php echo $this->Form->input('status', array('options' => array(1 => 'Active', 0 => 'Inactive'), 'selected' => $city['City']['status'], 'class' => 'form-control', 'style' => 'width:100%;', 'label' => false, 'div' => false)); ?>
    </div>
    <div class="form-group">
        <label for="City_Business_Status"><?php echo __('Is Business location?'); ?></label>
        <?php echo $this->Form->input('business_status', array('options' => array(1 => 'Yes', 0 => 'No'),'selected' => $city['City']['business_status'],  'empty' => __('Choose Status'), 'class' => 'form-control', 'id' => 'City_Business_Status', 'style' => 'width:100%;', 'label' => false, 'div' => false)); ?>
    </div>
    <input class="form-control" name="data[City][id]" type="hidden" value="<?php echo $city['City']['id']; ?>" id="cmp_id">
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancel'); ?></button>
    <button type="button" class="btn btn-primary" onclick="adm_edit_city_valid();"><?php echo __('Save'); ?></button>
</div>
<?php echo $this->Form->end(); ?>
<script>
    $(".select2").select2();
</script>