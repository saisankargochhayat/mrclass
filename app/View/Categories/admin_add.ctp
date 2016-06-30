<?php echo $this->Form->create('Category',array('type' => 'file')); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><?php echo __('Add Category'); ?></h4>
</div>
<div class="modal-body">
    <?php echo $this->Form->input('parent_id', array('type' => 'hidden', 'value' => '0', 'id' => 'Category_ParentId', 'label' => false, 'div' => false)); ?>
    <?php /* ?><div class="form-group">
        <label for="Category_ParentId"><?php echo __('Parent Category'); ?></label>
        <?php echo $this->Form->input('parent_id', array('options' => $pcategories, 'empty' => __('Parent Category'), 'class' => 'form-control', 'id' => 'Category_ParentId', 'style' => 'width:100%;', 'label' => false, 'div' => false)); ?>
    </div><?php */ ?>
    <div class="form-group">
        <label for="Category_Name"><?php echo __('Name'); ?></label>
        <?php echo $this->Form->input('name', array('class' => 'form-control', 'id' => 'Category_Name', 'div' => false, 'label' => false,'placeholder'=>'Enter Name')); ?>
    </div>
    <div class="form-group">
        <label for="Category_Status"><?php echo __('Status'); ?></label>
        <?php echo $this->Form->input('status', array('options' => array(1 => 'Active', 0 => 'Inactive'), 'empty' => __('Status'), 'class' => 'form-control', 'id' => 'Category_Status', 'style' => 'width:100%;', 'label' => false, 'div' => false, 'value' => 1)); ?>
    </div>
    <div class="form-group">
        <label for="categoryDescription"><?php echo __('Enter Description'); ?></label>
        <textarea placeholder="Enter Description..." rows="3" class="form-control" id="categoryDescription" name="data[Category][description]"></textarea>
    </div>
    <div class="form-group">
        <label for="CategoryCategoryImage">Upload image</label>
        <?php echo $this->Form->input('category_image',array('type' => 'file','label'=>false));?>
        <p class="help-block">Upload an image that suits the description.</p>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancel'); ?></button>
    <button type="botton" class="btn btn-primary" onclick="valid_adm_add_category();"><?php echo __('Save'); ?></button>
</div>
<?php echo $this->Form->end(); ?>
<script>
    valid_adm_add_category('load');
</script>