<ul>
    <li class="<?php if($parms['controller'] == 'users' && $parms['action'] == 'dashboard'){ echo 'active';}?> header-option">
        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'dashboard'));?>"><span class="all-sprite icon-dashboard"></span> User Dashboard</a>
    </li>
    <li <?php if($parms['controller'] == 'reports' && $parms['action'] == 'my_bookings'){ echo 'class="active"';}?>>
        <a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'my_bookings'));?>"><span class="all-sprite icon-book"></span> Booking History</a>
    </li>
    <li <?php if($parms['controller'] == 'business_ratings' && $parms['action'] == 'my_reviews'){ echo 'class="active"';}?>>
        <a href="<?php echo $this->Html->url(array('controller' => 'business_ratings', 'action' => 'my_reviews'));?>"><span class="all-sprite icon-review"></span> Your Reviews</a>
    </li>
    <?php /*?><li <?php if($parms['controller'] == 'users' && $parms['action'] == 'queries'){ echo 'class="active"';}?>>
        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'queries'));?>"><span class="all-sprite icon-query"></span> Your Queries</a>
    </li><?php */?>
    <li <?php if($parms['controller'] == 'content' && $parms['action'] == 'refer_friend'){ echo 'class="active"';}?>>
        <a href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'refer_friend')); ?>"><span class="all-sprite icon-refer"></span> Refer A Friend</a>
    </li>
    <li <?php if($parms['controller'] == 'events' && $parms['action'] == 'index'){ echo 'class="active"';}?>>
        <a class="cust_links_side" href="<?php echo $this->Html->url(array('controller' => 'events', 'action' => 'index')); ?>"><i class="fa fa-trophy no-sprite-icon"></i> Events</a>
    </li>
    <li <?php if($parms['controller'] == 'businesses' && $parms['action'] == 'favorites'){ echo 'class="active"';}?>>
        <a class="cust_links_side" href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'favorites')); ?>"><i class="fa fa-heart no-sprite-icon"></i> Favorites</a>
    </li>
    <?php /*?><li <?php if($parms['controller'] == 'users' && $parms['action'] == 'recently_viewed_classes'){ echo 'class="active"';}?>>
            <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'recently_viewed_classes')); ?>"><span class="all-sprite icon-refer"></span>Recently Viewed Classes</a>
    </li><?php */?>
    <?php /*?><li <?php if($parms['controller'] == 'content' && $parms['action'] == 'faq'){ echo 'class="active"';}?>>
        <a href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'faq')); ?>"><span class="all-sprite icon-faq"></span> FAQS</a>
    </li><?php */?>
</ul>
<?php if(is_array($view_data) && count($view_data)>0){?>
<div class="recently_viewed_classes_left">
    <h3><?php echo __('Recently Viewed Classes'); ?></h3>
    <div class="recent-views">
        <table id="" class="" cellspacing="0" style="width:290px;">
            <tbody>
                <?php foreach ($view_data as $views) { ?>
                    <tr>
                        <td style="" class="" rel="tooltip" title="<?php echo h($views['Business']['name']); ?>">
                            
                            <span class="fl" style="position:relative;font-size:25px;top:-2px;left:5px;">&bull; </span><?php echo $this->Html->link(trim($views['Business']['name']), $this->Format->business_detail_url($views['Business']), array('target' => '_blank', 'class' => 'ellipsis-view fl', 'title' => h($views['Business']['name']),'style'=>'max-width:290px;padding:5px 0 5px 10px; display:block;')); ?>
                        </td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>