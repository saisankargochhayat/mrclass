<div class="businessGalleries index">
	<h2><?php echo __('Business Galleries'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('business_id'); ?></th>
			<th><?php echo $this->Paginator->sort('media'); ?></th>
			<th><?php echo $this->Paginator->sort('sequence'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($businessGalleries as $businessGallery): ?>
	<tr>
		<td><?php echo h($businessGallery['BusinessGallery']['id']); ?>&nbsp;</td>
		<td><?php echo h($businessGallery['BusinessGallery']['business_id']); ?>&nbsp;</td>
		<td><?php echo h($businessGallery['BusinessGallery']['media']); ?>&nbsp;</td>
		<td><?php echo h($businessGallery['BusinessGallery']['sequence']); ?>&nbsp;</td>
		<td><?php echo h($businessGallery['BusinessGallery']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $businessGallery['BusinessGallery']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $businessGallery['BusinessGallery']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $businessGallery['BusinessGallery']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $businessGallery['BusinessGallery']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Business Gallery'), array('action' => 'add')); ?></li>
	</ul>
</div>
