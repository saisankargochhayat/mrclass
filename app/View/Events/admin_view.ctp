<div class="events view">
<h2><?php echo __('Event'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($event['Event']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($event['User']['name'], array('controller' => 'users', 'action' => 'view', $event['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($event['Event']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($event['Event']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fee'); ?></dt>
		<dd>
			<?php echo h($event['Event']['fee']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Equipment Provided'); ?></dt>
		<dd>
			<?php echo h($event['Event']['is_equipment_provided']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo $this->Html->link($event['City']['name'], array('controller' => 'cities', 'action' => 'view', $event['City']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Locality'); ?></dt>
		<dd>
			<?php echo $this->Html->link($event['Locality']['name'], array('controller' => 'localities', 'action' => 'view', $event['Locality']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($event['Event']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Landmark'); ?></dt>
		<dd>
			<?php echo h($event['Event']['landmark']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pincode'); ?></dt>
		<dd>
			<?php echo h($event['Event']['pincode']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contact Person'); ?></dt>
		<dd>
			<?php echo h($event['Event']['contact_person']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($event['Event']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($event['Event']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Latitude'); ?></dt>
		<dd>
			<?php echo h($event['Event']['latitude']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Longitude'); ?></dt>
		<dd>
			<?php echo h($event['Event']['longitude']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($event['Event']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($event['Event']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($event['Event']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Event'), array('action' => 'edit', $event['Event']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Event'), array('action' => 'delete', $event['Event']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $event['Event']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cities'), array('controller' => 'cities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New City'), array('controller' => 'cities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Localities'), array('controller' => 'localities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Locality'), array('controller' => 'localities', 'action' => 'add')); ?> </li>
	</ul>
</div>
