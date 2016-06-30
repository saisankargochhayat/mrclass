<div class="businesses view">
<h2><?php echo __('Business'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($business['Business']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($business['Business']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category Id'); ?></dt>
		<dd>
			<?php echo h($business['Business']['category_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subcategory Id'); ?></dt>
		<dd>
			<?php echo h($business['Business']['subcategory_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Min Age Group'); ?></dt>
		<dd>
			<?php echo h($business['Business']['min_age_group']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Max Age Group'); ?></dt>
		<dd>
			<?php echo h($business['Business']['max_age_group']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Facilities'); ?></dt>
		<dd>
			<?php echo h($business['Business']['facilities']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('About Us'); ?></dt>
		<dd>
			<?php echo h($business['Business']['about_us']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Logo'); ?></dt>
		<dd>
			<?php echo h($business['Business']['logo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City Id'); ?></dt>
		<dd>
			<?php echo h($business['Business']['city_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Locality Id'); ?></dt>
		<dd>
			<?php echo h($business['Business']['locality_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($business['Business']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Landmark'); ?></dt>
		<dd>
			<?php echo h($business['Business']['landmark']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pincode'); ?></dt>
		<dd>
			<?php echo h($business['Business']['pincode']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contact Person'); ?></dt>
		<dd>
			<?php echo h($business['Business']['contact_person']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($business['Business']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($business['Business']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Website'); ?></dt>
		<dd>
			<?php echo h($business['Business']['website']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Facebook'); ?></dt>
		<dd>
			<?php echo h($business['Business']['facebook']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Twitter'); ?></dt>
		<dd>
			<?php echo h($business['Business']['twitter']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gender'); ?></dt>
		<dd>
			<?php echo h($business['Business']['gender']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($business['Business']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($business['Business']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($business['Business']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Business'), array('action' => 'edit', $business['Business']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Business'), array('action' => 'delete', $business['Business']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $business['Business']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Businesses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Business Galleries'), array('controller' => 'business_galleries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business Gallery'), array('controller' => 'business_galleries', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Business Ratings'), array('controller' => 'business_ratings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Business Rating'), array('controller' => 'business_ratings', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Business Galleries'); ?></h3>
	<?php if (!empty($business['BusinessGallery'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Business Id'); ?></th>
		<th><?php echo __('Media'); ?></th>
		<th><?php echo __('Sequence'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($business['BusinessGallery'] as $businessGallery): ?>
		<tr>
			<td><?php echo $businessGallery['id']; ?></td>
			<td><?php echo $businessGallery['business_id']; ?></td>
			<td><?php echo $businessGallery['media']; ?></td>
			<td><?php echo $businessGallery['sequence']; ?></td>
			<td><?php echo $businessGallery['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'business_galleries', 'action' => 'view', $businessGallery['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'business_galleries', 'action' => 'edit', $businessGallery['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'business_galleries', 'action' => 'delete', $businessGallery['id']), array('confirm' => __('Are you sure you want to delete # %s?', $businessGallery['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Business Gallery'), array('controller' => 'business_galleries', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Business Ratings'); ?></h3>
	<?php if (!empty($business['BusinessRating'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Business Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($business['BusinessRating'] as $businessRating): ?>
		<tr>
			<td><?php echo $businessRating['id']; ?></td>
			<td><?php echo $businessRating['user_id']; ?></td>
			<td><?php echo $businessRating['business_id']; ?></td>
			<td><?php echo $businessRating['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'business_ratings', 'action' => 'view', $businessRating['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'business_ratings', 'action' => 'edit', $businessRating['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'business_ratings', 'action' => 'delete', $businessRating['id']), array('confirm' => __('Are you sure you want to delete # %s?', $businessRating['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Business Rating'), array('controller' => 'business_ratings', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
