<div class="advertisementPages view">
<h2><?php echo __('Advertisement Page'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($advertisementPage['AdvertisementPage']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($advertisementPage['AdvertisementPage']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($advertisementPage['AdvertisementPage']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($advertisementPage['AdvertisementPage']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($advertisementPage['AdvertisementPage']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Advertisement Page'), array('action' => 'edit', $advertisementPage['AdvertisementPage']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Advertisement Page'), array('action' => 'delete', $advertisementPage['AdvertisementPage']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $advertisementPage['AdvertisementPage']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Advertisement Pages'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Advertisement Page'), array('action' => 'add')); ?> </li>
	</ul>
</div>
