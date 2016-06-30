<div class="localities form">
<?php echo $this->Form->create('Locality'); ?>
	<fieldset>
		<legend><?php echo __('Edit Locality'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('city_id');
		echo $this->Form->input('name');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Locality.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Locality.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Localities'), array('action' => 'index')); ?></li>
	</ul>
</div>
