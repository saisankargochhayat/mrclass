<div class="subscriptions view">
<h2><?php echo __('Subscription'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($subscription['User']['name'], array('controller' => 'users', 'action' => 'view', $subscription['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Package Id'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['package_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Priority Search'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['priority_search']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Personal Subdomain'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['personal_subdomain']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Social Media Widget'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['social_media_widget']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Map Integration'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['map_integration']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Photo Limit'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['photo_limit']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Video Limit'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['video_limit']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subscription'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['subscription']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Listing Period'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['listing_period']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment Method'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['payment_method']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Enquiries'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['enquiries']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address Detail'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['address_detail']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Call Request'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['call_request']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Review'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['review']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Faq'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['faq']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($subscription['Subscription']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Subscription'), array('action' => 'edit', $subscription['Subscription']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Subscription'), array('action' => 'delete', $subscription['Subscription']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $subscription['Subscription']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Subscriptions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subscription'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
