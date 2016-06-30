<div class="careers view">
<h2><?php echo __('Career'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($career['Career']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($career['Career']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content'); ?></dt>
		<dd>
			<?php echo h($career['Career']['content']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($career['Career']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Career'), array('action' => 'edit', $career['Career']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Career'), array('action' => 'delete', $career['Career']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $career['Career']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Careers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Career'), array('action' => 'add')); ?> </li>
	</ul>
</div>
