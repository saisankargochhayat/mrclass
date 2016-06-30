<?php echo $this->Form->create('Locality', array('name'=>"LocalityAdminAddForm")); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><?php echo __('Add Locality'); ?></h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <?php echo $this->Form->input('city_id', array('options' => $cities, 'empty' => __('-- Choose City --'), 'class' => 'form-control select2', 'div' => false, 'onchange' => 'setVal(this)')); ?>
    </div>
    <div class="form-group">
        <?php echo $this->Form->input('name', array('class' => 'form-control', 'div' => false)); ?>
        <div class="cb"></div>
        <div class="error" id="LocalityNameErr"></div>
    </div>
    <div class="form-group">
        <?php echo $this->Form->input('status', array('options' => array(1 => 'Active', 0 => 'Inactive'), 'empty' => __('-- Choose Status --'), 'class' => 'form-control', 'style' => 'width:100%;', 'div' => false)); ?>
    </div>
    <input class="form-control" name="selectedcityID" type="hidden" value="" id="selectedcityID">
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancel'); ?></button>
    <button type="button" class="btn btn-primary" onclick="adm_add_local_valid();"><?php echo __('Save'); ?></button>
</div>
<?php echo $this->Form->end(); ?>
<script>
    //adm_add_local_valid('load');
    $('.select2').select2();
</script>