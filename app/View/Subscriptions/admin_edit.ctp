<div class="subscriptions form">
<?php echo $this->Form->create('Subscription'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Subscription'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('package_id');
		echo $this->Form->input('name');
		echo $this->Form->input('price');
		echo $this->Form->input('priority_search');
		echo $this->Form->input('personal_subdomain');
		echo $this->Form->input('social_media_widget');
		echo $this->Form->input('map_integration');
		echo $this->Form->input('photo_limit');
		echo $this->Form->input('video_limit');
		echo $this->Form->input('subscription');
		echo $this->Form->input('listing_period');
		echo $this->Form->input('payment_method');
		echo $this->Form->input('enquiries');
		echo $this->Form->input('address_detail');
		echo $this->Form->input('call_request');
		echo $this->Form->input('review');
		echo $this->Form->input('faq');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Subscription.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Subscription.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Subscriptions'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
