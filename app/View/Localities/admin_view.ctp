<div class="localities view">
<h2><?php echo __('Locality'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($locality['Locality']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City Id'); ?></dt>
		<dd>
			<?php echo h($cities[$locality['Locality']['city_id']]); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($locality['Locality']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($locality['Locality']['status'] == '1' ? "Active" : "Inactive"); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Locality'), array('action' => 'edit', $locality['Locality']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Locality'), array('action' => 'delete', $locality['Locality']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $locality['Locality']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Localities'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Locality'), array('action' => 'add')); ?> </li>
	</ul>
</div>
