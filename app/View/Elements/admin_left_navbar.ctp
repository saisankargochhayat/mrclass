<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
              <div class="pull-left image">
                  <img src="<?php echo $this->Format->user_photo($this->Session->read('Auth.User'),45,45,1); ?>" class="img-circle" alt="User Image">
              </div>
              <div class="pull-left info">
                  <p><?php echo ucfirst($user['name']); ?></p>
                  <a href="#" class="hide"><i class="fa fa-circle text-success"></i> Online</a>
              </div>
          </div>
          <ul class="sidebar-menu">
              <?php
              $dashboard_action_tree = array('admin_dashboard');
              $dashboard_controller_tree = array('users');
              ?>
            <li class="header">MAIN NAVIGATION</li>
            <li <?php if($parms['controller'] == 'users' && in_array($parms['action'],$dashboard_action_tree)){ echo 'class="active treeview"';}?>>
              <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'dashboard', 'admin' => 1));?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> 
              </a>
            </li>
            <?php
            $usr_mg_action_tree = array('admin_index', 'admin_add', 'admin_edit', 'admin_view','admin_manage_email','admin_send_bulk_email');
            $usr_mg_controller_tree = array('users','bulk_emails');
            ?>
            <li class="<?php if(in_array($parms['controller'],$usr_mg_controller_tree) && in_array($parms['action'],$usr_mg_action_tree)){ echo 'active ';}?>treeview">
              <a href="#">
                <i class="ion ion-person-stalker"></i>
                <span>User Management</span>
                <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <?php /*?><li <?php if($parms['controller'] == 'users' && in_array($parms['action'],$usr_mg_action_tree) && $this->params['type'] == 'admin'){ echo 'class="active"';}?>><a href="<?php echo HTTP_ROOT;?>admin/admins"><i class="ion ion-person"></i> <?php echo __('Admins'); ?></a></li><?php */?>
                <li <?php if(($parms['controller'] == 'users' && in_array($parms['action'],$usr_mg_action_tree) && !isset($this->params['type'])) && ($parms['action'] == 'admin_index' || $parms['action'] == 'admin_edit' || $parms['action'] == 'admin_add' || $parms['action'] == 'admin_view')){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index', 'admin' => 1));?>"><i class="ion ion-ios-people"></i> <?php echo __('Users'); ?></a></li>
                <li <?php if($parms['controller'] == 'bulk_emails' && !isset($this->params['type']) && ($parms['action'] == 'admin_manage_email' || $parms['action'] == 'admin_send_bulk_email')){ echo 'class="active"';}?>>
                <a href="<?php echo $this->Html->url(array('controller' => 'bulk_emails', 'action' => 'manage_email', 'admin' => 1));?>"><i class="fa fa-envelope"></i> <?php echo __('Manage Emails'); ?></a>
                </li>
              </ul>
            </li>
            <?php
            $masters_action_tree = array('admin_index', 'admin_facility_manage', 'admin_edit', 'admin_add', 'admin_add_video_link','admin_view','admin_business_favorite');
            $masters_controller_tree = array('businesses', 'facilities', 'categories', 'business_galleries', 'business_ratings', 'business_timings','BusinessFaqs','packages','package_discounts');
            ?>
            <li class="<?php if(in_array($parms['controller'],$masters_controller_tree) && in_array($parms['action'],$masters_action_tree)){ echo 'active ';}?>treeview">
              <a href="#">
                <i class="fa fa-briefcase"></i>
                <span>Masters</span>
                <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if(in_array($parms['controller'],array('businesses','business_galleries','business_ratings','business_timings','BusinessFaqs')) && in_array($parms['action'],$masters_action_tree) && $parms['action'] == 'admin_index'){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'index', 'admin' => 1));?>"><i class="ion ion-briefcase"></i> Business</a></li>
                <li <?php if($parms['controller'] == 'categories' && in_array($parms['action'],$masters_action_tree)){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'categories', 'action' => 'index', 'admin' => 1));?>"><i class="ion ion-ios-copy-outline"></i> Categories</a></li>
                <li <?php if($parms['controller'] == 'facilities' && in_array($parms['action'],$masters_action_tree)){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'facilities', 'action' => 'facility_manage', 'admin' => 1));?>"><i class="ion ion-ribbon-a"></i> Facility Manager</a></li>
                <li class="<?php if (in_array($parms['controller'], $masters_controller_tree) && in_array($parms['action'], $masters_action_tree) && ($parms['controller'] == 'packages' || $parms['controller'] == 'package_discounts')) { echo 'active';} ?> treeview">
                    <a href="<?php echo $this->Html->url(array('controller' => 'packages', 'action' => 'index', 'admin' => 1)); ?>"><i class="ion ion-cash"></i><span>Packages</span></a>
                </li>
                <li <?php if($parms['controller'] == 'businesses' && in_array($parms['action'],$masters_action_tree) && $parms['action'] == 'admin_business_favorite'){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'business_favorite', 'admin' => 1));?>"><i class="ion ion-ios-heart"></i> Favorites</a></li>
            </ul>
            </li>
            <?php 
                $location_action_tree = array('admin_index');
                $location_contrloller_tree = array('cities','localities');
            ?>
            <li class="<?php if(in_array($parms['controller'],$location_contrloller_tree) && in_array($parms['action'],$location_action_tree)){ echo 'active ';}?>treeview">
              <a href="#">
                <i class="ion ion-ios-location"></i>
                <span>Locations</span>
                <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($parms['controller'] == 'cities' && in_array($parms['action'],$location_action_tree)){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'cities', 'action' => 'index', 'admin' => 1));?>"><i class="fa fa-circle-o"></i> Cities</a></li>
                <li <?php if($parms['controller'] == 'localities' && in_array($parms['action'],$location_action_tree)){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'localities', 'action' => 'index', 'admin' => 1));?>"><i class="fa fa-circle-o"></i> Localities</a></li>
              </ul>
            </li>
            <?php
            $static_action_tree = array('admin_index', 'admin_edit', 'admin_add','admin_view');
            $static_controller_tree = array('static_pages', 'careers', 'faqs','presses');
            ?>
            <li class="<?php if(in_array($parms['controller'],$static_controller_tree) && in_array($parms['action'],$static_action_tree)){ echo 'active ';}?>treeview">
              <a href="#">
                <i class="ion ion-gear-b"></i>
                <span>CMS</span>
                <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($parms['controller'] == 'static_pages' && in_array($parms['action'],$static_action_tree)){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'static_pages', 'action' => 'index', 'admin' => 1));?>"><i class="ion ion-document"></i> Static Pages</a></li>
                <li <?php if($parms['controller'] == 'careers' && in_array($parms['action'],$static_action_tree)){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'careers', 'action' => 'index', 'admin' => 1));?>"><i class="ion ion-flag"></i> Careers</a></li>
                <li <?php if($parms['controller'] == 'faqs' && in_array($parms['action'],$static_action_tree)){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'faqs', 'action' => 'index', 'admin' => 1));?>"><i class="ion ion-information-circled"></i> Faqs</a></li>
                <li <?php if($parms['controller'] == 'presses' && in_array($parms['action'],$static_action_tree)){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'presses', 'action' => 'index', 'admin' => 1));?>"><i class="ion ion-information-circled"></i> Presses</a></li>
              </ul>
            </li>
            <?php
            $request_action_tree = array('admin_contact_request', 'admin_call_request', 'admin_bookings', 'admin_feedbacks', 'admin_view_booking', 'admin_index','admin_view','admin_contact_number_requests','admin_contact_requests_info','admin_group_booking_requests');
            $request_controller_tree = array('reports', 'inquiries');
            ?>
            <li class="<?php if(in_array($parms['controller'],$request_controller_tree) && in_array($parms['action'],$request_action_tree)){ echo 'active';}?> treeview">
              <a href="#">
                <i class="ion ion-chatbubble-working"></i>
                <span>Requests</span>
                <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if($parms['action'] == 'admin_contact_request'){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'contact_request', 'admin' => 1));?>"><i class="ion ion-android-contacts"></i> Contact Us Requests</a></li>
                <li <?php if($parms['action'] == 'admin_call_request'){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'call_request', 'admin' => 1));?>"><i class="ion ion-android-call"></i> Request a Call</a></li>
                <li <?php if($parms['action'] == 'admin_bookings' || $parms['action'] == 'admin_view_booking'){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'bookings', 'admin' => 1));?>"><i class="fa fa-ticket"></i> Business Bookings</a></li>
                <li <?php if($parms['action'] == 'admin_group_booking_requests'){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'group_booking_requests', 'admin' => 1));?>"><i class="ion ion-android-people"></i> Group Bookings</a></li>
                <li <?php if($parms['action'] == 'admin_feedbacks'){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'feedbacks', 'admin' => 1));?>"><i class="ion ion-android-textsms"></i> Feedbacks</a></li>
                <li <?php if($parms['controller'] == 'inquiries' && $parms['action'] == 'admin_index'){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'inquiries', 'action' => 'index', 'admin' => 1));?>"><i class="fa fa-search"></i> Looking for a Tutor</a></li>
                <li <?php if($parms['controller'] == 'inquiries' && ($parms['action'] == 'admin_contact_requests_info' || $parms['action'] == 'admin_contact_number_requests')){ echo 'class="active"';}?>><a href="<?php echo $this->Html->url(array('controller' => 'inquiries', 'action' => 'contact_requests_info', 'admin' => 1));?>"><i class="fa fa-phone-square"></i> Contact Information Requests</a></li>
              </ul>
            </li>
            <?php
            $rating_action_tree = array('admin_all');
            $rating_contrloller_tree = array('business_ratings');
            ?>
            <li class="<?php if (in_array($parms['controller'], $rating_contrloller_tree) && in_array($parms['action'], $rating_action_tree)) { echo 'active';} ?> treeview">
                <a href="<?php echo $this->Html->url(array('controller' => 'business_ratings', 'action' => 'all', 'admin' => 1)); ?>">
                    <i class="fa fa-star"></i> <span>Reviews & Ratings</span> 
                </a>
            </li>
            <?php
            $request_action_tree = array('admin_users','admin_write_to_us','admin_ask_us_anything');
            $request_controller_tree = array('reports');
            ?>
            <li class="<?php if (in_array($parms['controller'], $request_controller_tree) && in_array($parms['action'], $request_action_tree)) {echo 'active';} ?> treeview">
                <a href="#">
                    <i class="ion ion-chatbubble-working"></i>
                    <span>Reports</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <?php /*<li <?php if ($parms['action'] == 'admin_users') {echo 'class="active"';} ?>><a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'users', 'admin' => 1)); ?>"><i class="ion ion-male"></i> Users Report</a></li>*/?>
                    <li <?php if ($parms['action'] == 'admin_write_to_us') {echo 'class="active"';} ?>><a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'write_to_us', 'admin' => 1)); ?>"><i class="ion ion-social-buffer"></i> Write to Us</a></li>
                    <li <?php if ($parms['action'] == 'admin_ask_us_anything') {echo 'class="active"';} ?>><a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'ask_us_anything', 'admin' => 1)); ?>"><i class="fa fa-circle-o"></i> Ask Us Anything</a></li>
                </ul>
            </li>
            <?php
            $subscription_action_tree = array('admin_index','admin_view','admin_add','admin_edit');
            $subscription_contrloller_tree = array('subscriptions');
            ?>
            <li class="<?php if (in_array($parms['controller'], $subscription_contrloller_tree) && in_array($parms['action'], $subscription_action_tree)) { echo 'active';} ?> treeview">
                <a href="<?php echo $this->Html->url(array('controller' => 'subscriptions', 'action' => 'index', 'admin' => 1)); ?>">
                    <i class="fa fa-inr"></i> <span>Subscriptions</span> 
                </a>
            </li>
            <?php
            $ad_action_tree = array('admin_index','admin_add','admin_edit','admin_tracking');
            $ad_controller_tree = array('advertisements','advertisement_pages');
            ?>
            <li class="<?php if (in_array($parms['controller'], $ad_controller_tree) && in_array($parms['action'], $ad_action_tree)) {echo 'active';} ?> treeview">
                <a href="#">
                    <i class="ion ion-speakerphone"></i>
                    <span>Ad Management</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php if (in_array($parms['action'], $ad_action_tree) && $parms['controller'] == 'advertisements') {echo 'class="active"';} ?>><a href="<?php echo $this->Html->url(array('controller' => 'advertisements', 'action' => 'index', 'admin' => 1)); ?>"><i class="ion ion-speakerphone"></i> Ads</a></li>
                    <?php /*<li <?php if ($parms['action'] == 'admin_index' && $parms['controller'] == 'advertisement_pages') {echo 'class="active"';} ?>><a href="<?php echo $this->Html->url(array('controller' => 'advertisement_pages', 'action' => 'index', 'admin' => 1)); ?>"><i class="ion ion-earth"></i> Ad Pages</a></li>*/ ?>
                    <li <?php if ($parms['action'] == "admin_tracking" && $parms['controller'] == 'advertisements') {echo 'class="active"';} ?>><a href="<?php echo $this->Html->url(array('controller' => 'advertisements', 'action' => 'tracking', 'admin' => 1)); ?>"><i class="fa fa-bar-chart"></i> Tracks</a></li>
                </ul>
            </li>
            <?php
            $qe_action_tree = array('admin_index');
            $qe_controller_tree = array('questionCategories','questions','QuestionDownloads');
            ?>
            <li class="<?php if (in_array($parms['controller'], $qe_controller_tree) && in_array($parms['action'], $qe_action_tree)) {echo 'active';} ?> treeview">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Question Bank</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php if (in_array($parms['action'], $qe_action_tree) && $parms['controller'] == 'questionCategories') {echo 'class="active"';} ?>><a href="<?php echo $this->Html->url(array('controller' => 'questionCategories', 'action' => 'index', 'admin' => 1)); ?>"><i class="ion ion-speakerphone"></i> Question Category</a></li>
                    <li <?php if ($parms['action'] == 'admin_index' && $parms['controller'] == 'questions') {echo 'class="active"';} ?>><a href="<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'index','all', 'admin' => 1)); ?>"><i class="fa fa-question"></i> Question Bank</a></li>
                    <li <?php if ($parms['action'] == 'admin_index' && $parms['controller'] == 'QuestionDownloads') {echo 'class="active"';} ?>><a href="<?php echo $this->Html->url(array('controller' => 'QuestionDownloads', 'action' => 'index','all', 'admin' => 1)); ?>"><i class="fa fa-download"></i> Download Histrory</a></li>
                </ul>
            </li>
            <?php
            $event_action_tree = array('admin_index','admin_add','admin_edit','admin_event_inquiry');
            $event_controller_tree = array('events');
            ?>
            <li class="<?php if (in_array($parms['controller'], $event_controller_tree) && in_array($parms['action'], $event_action_tree)) {echo 'active';} ?> treeview">
                <a href="#">
                    <i class="ion ion-speakerphone"></i>
                    <span>Events</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php if (in_array($parms['action'], $event_action_tree) && $parms['controller'] == 'events') {echo 'class="active"';} ?>><a href="<?php echo $this->Html->url(array('controller' => 'events', 'action' => 'index', 'admin' => 1)); ?>"><i class="fa fa-trophy"></i> Events</a></li>
                    <li <?php if (in_array($parms['action'], $event_action_tree) && $parms['controller'] == 'events') {echo 'class="active"';} ?>><a href="<?php echo $this->Html->url(array('controller' => 'events', 'action' => 'event_inquiry', 'admin' => 1)); ?>"><i class="fa fa-trophy"></i> Event Inquiry</a></li>
                </ul>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
</aside>