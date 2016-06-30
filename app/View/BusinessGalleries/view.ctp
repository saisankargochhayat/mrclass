<div class="businessGalleries view">
<h2><?php echo __('Business Gallery'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($businessGallery['BusinessGallery']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Business Id'); ?></dt>
		<dd>
			<?php echo h($businessGallery['BusinessGallery']['business_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Media'); ?></dt>
		<dd>
			<?php echo h($businessGallery['BusinessGallery']['media']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sequence'); ?></dt>
		<dd>
			<?php echo h($businessGallery['BusinessGallery']['sequence']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($businessGallery['BusinessGallery']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Business Gallery'), array('action' => 'edit', $businessGallery['BusinessGallery']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Business Gallery'), array('action' => 'delete', $businessGallery['BusinessGallery']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $businessGallery['BusinessGallery']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Business Galleries'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business Gallery'), array('action' => 'add')); ?> </li>
	</ul>
</div>
