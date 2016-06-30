<ul>
    <li class="<?php if($parms['controller'] == 'businesses' && $parms['action'] == 'index'){ echo 'active';}?> header-option">
        <a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'index')); ?>"><span class="all-sprite icon-dashboard"></span> Business Dashboard</a>
    </li>
    <li <?php if($parms['controller'] == 'businesses' && $parms['action'] == 'add'){ echo 'class="active"';}?>>
        <a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'add')); ?>"><span class="all-sprite icon-add"></span> Add New Business</a>
    </li>
    <?php /*?><li>
        <a href=""><span class="all-sprite icon-minus"></span> Remove A business</a>
    </li><?php */?>
    <?php /*?><li>
        <a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'manage'));?>"><span class="all-sprite icon-mng"></span> Manage Records</a>
    </li><?php */?>
    <li <?php if($parms['controller'] == 'reports' && $parms['action'] == 'bookings'){ echo 'class="active"';}?>>
        <a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'bookings'));?>"><span class="all-sprite icon-book"></span> Booking Requests</a>
    </li>
    <?php /*?><li>
        <a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'queries'));?>"><span class="all-sprite icon-query"></span> Queries</a>
    </li><?php */?>
    <li <?php if($parms['controller'] == 'business_ratings' && $parms['action'] == 'reviews'){ echo 'class="active"';}?>>
        <a href="<?php echo $this->Html->url(array('controller' => 'business_ratings', 'action' => 'reviews'));?>"><span class="all-sprite icon-review"></span> Reviews</a>
    </li>
    <?php /*?><li>
        <a href=""><span class="all-sprite icon-support"></span> support helpline</a>
    </li>
    <li>
        <a href=""><span class="all-sprite icon-bill"></span> bill records</a>
    </li><?php */?>
        <li <?php if($parms['controller'] == 'reports' && $parms['action'] == 'call_requests'){ echo 'class="active"';}?>>
            <a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'call_requests'));?>"><span class="all-sprite icon-feedback"></span> Request a Call</a>
        </li>
	<li <?php if($parms['controller'] == 'subscriptions' && $parms['action'] == 'index'){ echo 'class="active"';}?>>
		<a href="<?php echo $this->Html->url(array('controller' => 'subscriptions', 'action' => 'index',$user['id']));?>"><span class="all-sprite icon-subscription"></span> Subscriptions</a>
	</li>
</ul>