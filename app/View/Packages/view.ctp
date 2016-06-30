<div class="packages view">
<h2><?php echo __('Package'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($package['Package']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($package['Package']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($package['Package']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Priority Search'); ?></dt>
		<dd>
			<?php echo h($package['Package']['priority_search']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Personal Subdomain'); ?></dt>
		<dd>
			<?php echo h($package['Package']['personal_subdomain']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Social Media Widget'); ?></dt>
		<dd>
			<?php echo h($package['Package']['social_media_widget']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Map Integration'); ?></dt>
		<dd>
			<?php echo h($package['Package']['map_integration']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Photo Limit'); ?></dt>
		<dd>
			<?php echo h($package['Package']['photo_limit']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Video Limit'); ?></dt>
		<dd>
			<?php echo h($package['Package']['video_limit']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subscription'); ?></dt>
		<dd>
			<?php echo h($package['Package']['subscription']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Listing Period'); ?></dt>
		<dd>
			<?php echo h($package['Package']['listing_period']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment Method'); ?></dt>
		<dd>
			<?php echo h($package['Package']['payment_method']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Enquiries'); ?></dt>
		<dd>
			<?php echo h($package['Package']['enquiries']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address Detail'); ?></dt>
		<dd>
			<?php echo h($package['Package']['address_detail']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Call Request'); ?></dt>
		<dd>
			<?php echo h($package['Package']['call_request']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Review'); ?></dt>
		<dd>
			<?php echo h($package['Package']['review']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Faq'); ?></dt>
		<dd>
			<?php echo h($package['Package']['faq']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($package['Package']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($package['Package']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($package['Package']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Package'), array('action' => 'edit', $package['Package']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Package'), array('action' => 'delete', $package['Package']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $package['Package']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Packages'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Package'), array('action' => 'add')); ?> </li>
	</ul>
</div>
