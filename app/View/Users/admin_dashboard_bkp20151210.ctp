<?php echo $this->Html->css(array('datepicker3'), array('inline' => false)); ?>
<?php echo $this->Html->script(array('jquery.slimscroll.min', 'fastclick.min'), array('inline' => false)); ?>
<?php echo $this->Html->script(array('dashboard'), array('block' => 'dashboardjs')); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        New Updates Since Last Login
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner"><h3><?php echo $allbusinesses; ?></h3><p>New Businesses</p></div>
                <div class="icon"><i class="ion ion-briefcase"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'index', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner"><h3><?php echo $allusers; ?></h3><p>User Registrations</p></div>
                <div class="icon"><i class="ion ion-person-add"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner"><h3><?php echo $allcontact; ?></h3><p>Contact Requests</p></div>
                <div class="icon"><i class="ion ion-android-contacts"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'contact_request', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner"><h3><?php echo $allcall; ?></h3><p>Call Requests</p></div>
                <div class="icon"><i class="ion ion-android-call"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'call_request', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
    
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-bookingtab">
                <div class="inner"><h3><?php echo $allbookings; ?></h3><p>New Bookings</p></div>
                <div class="icon"><i class="fa fa-ticket"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'bookings', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-feedbacks">
                <div class="inner"><h3><?php echo $allfeeds; ?></h3><p>Feedbacks</p></div>
                <div class="icon"><i class="ion ion-android-textsms"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'feedbacks', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-revratings">
                <div class="inner"><h3><?php echo $allreviews; ?></h3><p>Reviews & Ratings</p></div>
                <div class="icon"><i class="fa fa-star"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'business_ratings', 'action' => 'all', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
    
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner"><h3><?php echo $pending_businesses; ?></h3><p>Businesses Pending Approval</p></div>
                <div class="icon"><i class="ion ion-briefcase"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'index', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-revratings">
                <div class="inner"><h3><?php echo $pending_reviews; ?></h3><p>Pending Reviews & Ratings</p></div>
                <div class="icon"><i class="fa fa-star"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'business_ratings', 'action' => 'all', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner"><h3><?php echo $pending_users; ?></h3><p>Pending Users Activation</p></div>
                <div class="icon"><i class="ion ion-person-add"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable hide">
            <!-- quick email widget -->
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-envelope"></i>
                    <h3 class="box-title">Quick Email</h3>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button class="btn btn-info btn-sm" data-widget="remove" rel="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div><!-- /. tools -->
                </div>
                <div class="box-body">
                    <form action="#" method="post">
                        <div class="form-group">
                            <input type="email" class="form-control" name="emailto" placeholder="Email to:">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="subject" placeholder="Subject">
                        </div>
                        <div>
                            <textarea class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                    </form>
                </div>
                <div class="box-footer clearfix">
                    <button class="pull-right btn btn-default" id="sendEmail">Send <i class="fa fa-arrow-circle-right"></i></button>
                </div>
            </div>
        </section><!-- /.Left col -->
    </div><!-- /.row (main row) -->
</section><!-- /.content --><?php echo $this->Html->script(array('jquery.dataTables.min', 'dataTables.bootstrap.min'), array('block' => 'bootstrap_datatable')); ?>
