<div class="packageDiscounts view">
<h2><?php echo __('Package Discount'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($packageDiscount['PackageDiscount']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Package'); ?></dt>
		<dd>
			<?php echo $this->Html->link($packageDiscount['Package']['name'], array('controller' => 'packages', 'action' => 'view', $packageDiscount['Package']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Period Duration'); ?></dt>
		<dd>
			<?php echo h($packageDiscount['PackageDiscount']['period_duration']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Period Type'); ?></dt>
		<dd>
			<?php echo h($packageDiscount['PackageDiscount']['period_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discount'); ?></dt>
		<dd>
			<?php echo h($packageDiscount['PackageDiscount']['discount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discount Type'); ?></dt>
		<dd>
			<?php echo h($packageDiscount['PackageDiscount']['discount_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($packageDiscount['PackageDiscount']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($packageDiscount['PackageDiscount']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Package Discount'), array('action' => 'edit', $packageDiscount['PackageDiscount']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Package Discount'), array('action' => 'delete', $packageDiscount['PackageDiscount']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $packageDiscount['PackageDiscount']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Package Offers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Package Discount'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Packages'), array('controller' => 'packages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Package'), array('controller' => 'packages', 'action' => 'add')); ?> </li>
	</ul>
</div>
