<div class="staticPages view">
<h2><?php echo __('Static Page'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($staticPage['StaticPage']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($staticPage['StaticPage']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($staticPage['StaticPage']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($staticPage['StaticPage']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($staticPage['StaticPage']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($staticPage['StaticPage']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content'); ?></dt>
		<dd>
			<?php echo h($staticPage['StaticPage']['content']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Static Page'), array('action' => 'edit', $staticPage['StaticPage']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Static Page'), array('action' => 'delete', $staticPage['StaticPage']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $staticPage['StaticPage']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Static Pages'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Static Page'), array('action' => 'add')); ?> </li>
	</ul>
</div>
