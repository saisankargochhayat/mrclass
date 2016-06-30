<div class="questionCategories view">
<h2><?php echo __('Question Category'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($questionCategory['QuestionCategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($questionCategory['QuestionCategory']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($questionCategory['QuestionCategory']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($questionCategory['QuestionCategory']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($questionCategory['QuestionCategory']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($questionCategory['QuestionCategory']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Question Category'), array('action' => 'edit', $questionCategory['QuestionCategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Question Category'), array('action' => 'delete', $questionCategory['QuestionCategory']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $questionCategory['QuestionCategory']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Question Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Questions'); ?></h3>
	<?php if (!empty($questionCategory['Question'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Question Category Id'); ?></th>
		<th><?php echo __('Filename'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($questionCategory['Question'] as $question): ?>
		<tr>
			<td><?php echo $question['id']; ?></td>
			<td><?php echo $question['question_category_id']; ?></td>
			<td><?php echo $question['filename']; ?></td>
			<td><?php echo $question['description']; ?></td>
			<td><?php echo $question['status']; ?></td>
			<td><?php echo $question['created']; ?></td>
			<td><?php echo $question['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'questions', 'action' => 'view', $question['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'questions', 'action' => 'edit', $question['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'questions', 'action' => 'delete', $question['id']), array('confirm' => __('Are you sure you want to delete # %s?', $question['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
