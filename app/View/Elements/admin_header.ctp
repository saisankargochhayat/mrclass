<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo $this->Html->url($adminpanel_dashboard_link)?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"> <?php echo $this->Html->image('mrclass_35x35.png', array('alt' => 'logo_small_mrc'));?></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><?php echo $this->Html->image('mrclass_130x31.png', array('alt' => 'logo_reg_mrc'));?></span>
    </a>
    <!-- Hea9der Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo $this->Format->user_photo($this->Session->read('Auth.User'),25,25,1); ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo  ucfirst($user['name']);?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo $this->Format->user_photo($this->Session->read('Auth.User'),90,90,1); ?>" class="img-circle" alt="User Image">
                            <p><?php echo ucfirst($user['name']);?></p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'profile', 'admin' => 1));?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <?php echo $this->Html->link('Sign Out',array('controller'=>'users','action'=>'admin_logout'),array('class'=>'btn btn-default btn-flat'));?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>