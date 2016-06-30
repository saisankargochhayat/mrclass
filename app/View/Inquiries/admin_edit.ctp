<div class="inquiries form">
<?php echo $this->Form->create('Inquiry'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Inquiry'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('phone');
		echo $this->Form->input('email');
		echo $this->Form->input('type');
		echo $this->Form->input('location');
		echo $this->Form->input('min_age');
		echo $this->Form->input('max_age');
		echo $this->Form->input('category_id');
		echo $this->Form->input('sub_category_id');
		echo $this->Form->input('comment');
		echo $this->Form->input('ip');
		echo $this->Form->input('city');
		echo $this->Form->input('area');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Inquiry.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Inquiry.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Inquiries'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
