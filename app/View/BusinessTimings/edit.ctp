<div class="businessTimings form">
<?php echo $this->Form->create('BusinessTiming'); ?>
	<fieldset>
		<legend><?php echo __('Edit Business Timing'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('business_id');
		echo $this->Form->input('day');
		echo $this->Form->input('start_time');
		echo $this->Form->input('close_time');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('BusinessTiming.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('BusinessTiming.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Business Timings'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Businesses'), array('controller' => 'businesses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business'), array('controller' => 'businesses', 'action' => 'add')); ?> </li>
	</ul>
</div>
