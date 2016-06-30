<?php echo $this->Form->create('Category',array('type'=>'file'));?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><?php echo __('Edit Category'); ?></h4>
</div>
<div class="modal-body">
    <?php echo $this->Form->input('id'); ?>
    <?php echo $this->Form->input('parent_id', array('type' => 'hidden', 'value' => '0', 'id' => 'Category_ParentId', 'label' => false, 'div' => false)); ?>
    <?php /* ?>
    <div class="form-group">
        <?php echo $this->Form->input('parent_id', array('options' => $pcategories, 'selected' => $this->data['Category']['parent_id'],'empty' => __('Parent Category') ,'class' => 'form-control', 'style' => 'width:100%;', 'div' => false)); ?>
    </div><?php */ ?>
    <div class="form-group">
        <?php echo $this->Form->input('name', array('class' => 'form-control', 'div' => false)); ?>
    </div>
    <div class="form-group">
        <?php echo $this->Form->input('status', array('options' => array(1 => 'Active', 0 => 'Inactive'), 'selected' => $this->data['Category']['status'], 'class' => 'form-control', 'style' => 'width:100%;', 'div' => false)); ?>
    </div>
    <div class="form-group">
        <label for="categoryDescription"><?php echo __('Enter Description'); ?></label>
        <textarea placeholder="Enter Description..." rows="3" class="form-control" id="categoryDescription" name="data[Category][description]"><?php echo h($this->data['Category']['description'])?></textarea>
    </div>
    <div class="form-group">
        <label for="CategoryCategoryImage">Upload image</label>
        <div class="cb"></div>
        <img src="<?php echo $this->Format->category_image($this->data,100,100) ?>" alt="alt" />
        <div class="cb">&nbsp;</div>
        <?php echo $this->Form->input('category_image',array('type' => 'file','label'=>false));?>
        <p class="help-block">Upload an image that suits the description.</p>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancel'); ?></button>
    <button type="submit" class="btn btn-primary" onclick="adm_valid_category();"><?php echo __('Save'); ?></button>
</div>
<?php echo $this->Form->end(); ?>
