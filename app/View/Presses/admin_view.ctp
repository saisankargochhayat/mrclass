<div class="presses view">
<h2><?php echo __('Press'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($press['Press']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($press['Press']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($press['Press']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Source'); ?></dt>
		<dd>
			<?php echo h($press['Press']['source']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Link'); ?></dt>
		<dd>
			<?php echo h($press['Press']['link']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Preview'); ?></dt>
		<dd>
			<?php echo h($press['Press']['preview']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($press['Press']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($press['Press']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($press['Press']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Press'), array('action' => 'edit', $press['Press']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Press'), array('action' => 'delete', $press['Press']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $press['Press']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Presses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Press'), array('action' => 'add')); ?> </li>
	</ul>
</div>
