<div class="advertisementPages form">
<?php echo $this->Form->create('AdvertisementPage'); ?>
	<fieldset>
		<legend><?php echo __('Edit Advertisement Page'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('AdvertisementPage.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('AdvertisementPage.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Advertisement Pages'), array('action' => 'index')); ?></li>
	</ul>
</div>
