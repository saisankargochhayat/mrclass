<div class="businessTimings view">
<h2><?php echo __('Business Timing'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($businessTiming['BusinessTiming']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Business'); ?></dt>
		<dd>
			<?php echo $this->Html->link($businessTiming['Business']['name'], array('controller' => 'businesses', 'action' => 'view', $businessTiming['Business']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Day'); ?></dt>
		<dd>
			<?php echo h($businessTiming['BusinessTiming']['day']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Time'); ?></dt>
		<dd>
			<?php echo h($businessTiming['BusinessTiming']['start_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Close Time'); ?></dt>
		<dd>
			<?php echo h($businessTiming['BusinessTiming']['close_time']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Business Timing'), array('action' => 'edit', $businessTiming['BusinessTiming']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Business Timing'), array('action' => 'delete', $businessTiming['BusinessTiming']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $businessTiming['BusinessTiming']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Business Timings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business Timing'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Businesses'), array('controller' => 'businesses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business'), array('controller' => 'businesses', 'action' => 'add')); ?> </li>
	</ul>
</div>
