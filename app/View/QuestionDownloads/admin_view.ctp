<div class="questionDownloads view">
<h2><?php echo __('Question Download'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($questionDownload['QuestionDownload']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Question'); ?></dt>
		<dd>
			<?php echo $this->Html->link($questionDownload['Question']['title'], array('controller' => 'questions', 'action' => 'view', $questionDownload['Question']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($questionDownload['User']['name'], array('controller' => 'users', 'action' => 'view', $questionDownload['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($questionDownload['QuestionDownload']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($questionDownload['QuestionDownload']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Question Download'), array('action' => 'edit', $questionDownload['QuestionDownload']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Question Download'), array('action' => 'delete', $questionDownload['QuestionDownload']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $questionDownload['QuestionDownload']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Question Downloads'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question Download'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
