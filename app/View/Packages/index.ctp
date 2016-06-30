<div class="packages index">
	<h2><?php echo __('Packages'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('price'); ?></th>
			<th><?php echo $this->Paginator->sort('priority_search'); ?></th>
			<th><?php echo $this->Paginator->sort('personal_subdomain'); ?></th>
			<th><?php echo $this->Paginator->sort('social_media_widget'); ?></th>
			<th><?php echo $this->Paginator->sort('map_integration'); ?></th>
			<th><?php echo $this->Paginator->sort('photo_limit'); ?></th>
			<th><?php echo $this->Paginator->sort('video_limit'); ?></th>
			<th><?php echo $this->Paginator->sort('subscription'); ?></th>
			<th><?php echo $this->Paginator->sort('listing_period'); ?></th>
			<th><?php echo $this->Paginator->sort('payment_method'); ?></th>
			<th><?php echo $this->Paginator->sort('enquiries'); ?></th>
			<th><?php echo $this->Paginator->sort('address_detail'); ?></th>
			<th><?php echo $this->Paginator->sort('call_request'); ?></th>
			<th><?php echo $this->Paginator->sort('review'); ?></th>
			<th><?php echo $this->Paginator->sort('faq'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($packages as $package): ?>
	<tr>
		<td><?php echo h($package['Package']['id']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['name']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['price']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['priority_search']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['personal_subdomain']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['social_media_widget']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['map_integration']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['photo_limit']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['video_limit']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['subscription']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['listing_period']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['payment_method']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['enquiries']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['address_detail']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['call_request']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['review']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['faq']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['status']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['created']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $package['Package']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $package['Package']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $package['Package']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $package['Package']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Package'), array('action' => 'add')); ?></li>
	</ul>
</div>
