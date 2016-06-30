<div class="businessRatings form">
<?php echo $this->Form->create('BusinessRating'); ?>
	<fieldset>
		<legend><?php echo __('Add Business Rating'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('business_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Business Ratings'), array('action' => 'index')); ?></li>
	</ul>
</div>
