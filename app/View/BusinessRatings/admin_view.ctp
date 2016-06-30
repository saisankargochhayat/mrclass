<div class="businessRatings view">
<h2><?php echo __('Business Rating'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($businessRating['BusinessRating']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
			<?php echo h($businessRating['BusinessRating']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Business Id'); ?></dt>
		<dd>
			<?php echo h($businessRating['BusinessRating']['business_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($businessRating['BusinessRating']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Business Rating'), array('action' => 'edit', $businessRating['BusinessRating']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Business Rating'), array('action' => 'delete', $businessRating['BusinessRating']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $businessRating['BusinessRating']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Business Ratings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business Rating'), array('action' => 'add')); ?> </li>
	</ul>
</div>
