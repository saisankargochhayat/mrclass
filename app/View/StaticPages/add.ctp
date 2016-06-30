<div class="staticPages form">
<?php echo $this->Form->create('StaticPage'); ?>
	<fieldset>
		<legend><?php echo __('Add Static Page'); ?></legend>
	<?php
		echo $this->Form->input('code');
		echo $this->Form->input('url');
		echo $this->Form->input('title');
		echo $this->Form->input('status');
		echo $this->Form->input('content');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Static Pages'), array('action' => 'index')); ?></li>
	</ul>
</div>
