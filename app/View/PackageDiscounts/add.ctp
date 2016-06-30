<div class="packageDiscounts form">
<?php echo $this->Form->create('PackageDiscount'); ?>
	<fieldset>
		<legend><?php echo __('Add Package Discount'); ?></legend>
	<?php
		echo $this->Form->input('package_id');
		echo $this->Form->input('period_duration');
		echo $this->Form->input('period_type');
		echo $this->Form->input('discount');
		echo $this->Form->input('discount_type');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Package Offers'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Packages'), array('controller' => 'packages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Package'), array('controller' => 'packages', 'action' => 'add')); ?> </li>
	</ul>
</div>
