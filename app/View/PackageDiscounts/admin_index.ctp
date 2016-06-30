<div class="packageDiscounts index">
	<h2><?php echo __('Package Offers'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('package_id'); ?></th>
			<th><?php echo $this->Paginator->sort('period_duration'); ?></th>
			<th><?php echo $this->Paginator->sort('period_type'); ?></th>
			<th><?php echo $this->Paginator->sort('discount'); ?></th>
			<th><?php echo $this->Paginator->sort('discount_type'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($packageDiscounts as $packageDiscount): ?>
	<tr>
		<td><?php echo h($packageDiscount['PackageDiscount']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($packageDiscount['Package']['name'], array('controller' => 'packages', 'action' => 'view', $packageDiscount['Package']['id'])); ?>
		</td>
		<td><?php echo h($packageDiscount['PackageDiscount']['period_duration']); ?>&nbsp;</td>
		<td><?php echo h($packageDiscount['PackageDiscount']['period_type']); ?>&nbsp;</td>
		<td><?php echo h($packageDiscount['PackageDiscount']['discount']); ?>&nbsp;</td>
		<td><?php echo h($packageDiscount['PackageDiscount']['discount_type']); ?>&nbsp;</td>
		<td><?php echo h($packageDiscount['PackageDiscount']['created']); ?>&nbsp;</td>
		<td><?php echo h($packageDiscount['PackageDiscount']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $packageDiscount['PackageDiscount']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $packageDiscount['PackageDiscount']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $packageDiscount['PackageDiscount']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $packageDiscount['PackageDiscount']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Package Discount'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Packages'), array('controller' => 'packages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Package'), array('controller' => 'packages', 'action' => 'add')); ?> </li>
	</ul>
</div>
