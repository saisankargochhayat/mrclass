<div class="businessFaqs view">
<h2><?php echo __('Business Faq'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($businessFaq['BusinessFaq']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Business'); ?></dt>
		<dd>
			<?php echo $this->Html->link($businessFaq['Business']['name'], array('controller' => 'businesses', 'action' => 'view', $businessFaq['Business']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($businessFaq['BusinessFaq']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content'); ?></dt>
		<dd>
			<?php echo h($businessFaq['BusinessFaq']['content']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($businessFaq['BusinessFaq']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($businessFaq['BusinessFaq']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($businessFaq['BusinessFaq']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sequence'); ?></dt>
		<dd>
			<?php echo h($businessFaq['BusinessFaq']['sequence']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Business Faq'), array('action' => 'edit', $businessFaq['BusinessFaq']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Business Faq'), array('action' => 'delete', $businessFaq['BusinessFaq']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $businessFaq['BusinessFaq']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Business Faqs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business Faq'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Businesses'), array('controller' => 'businesses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business'), array('controller' => 'businesses', 'action' => 'add')); ?> </li>
	</ul>
</div>
