<?php echo $this->Html->css(array('datepicker3'), array('inline' => false)); ?>
<?php echo $this->Html->script(array('jquery.slimscroll.min', 'fastclick.min'), array('inline' => false)); ?>
<?php echo $this->Html->script(array('dashboard'), array('block' => 'dashboardjs')); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        New Updates Since Last Login
        <small>Control panel</small>
        <a class="btn btn-app" id="widgets_refresh" data-placement="right" rel="tooltip" title="Refresh" onclick="count_refresh();">
            <i class="fa fa-refresh"></i>
        </a>
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
            <div class="small-box bg-yellow">
                <div class="inner"><h3 id="pend_users">0</h3><p>Users</p></div>
                <div class="icon"><i class="ion ion-person-add"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner"><h3 id="pend_business">0</h3><p>Businesses</p></div>
                <div class="icon"><i class="ion ion-briefcase"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'index', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-blue">
                <div class="inner"><h3 id="pend_askus">0</h3><p>Ask Us Anything</p></div>
                <div class="icon"><i class="fa fa-question"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'ask_us_anything', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner"><h3 id="pend_contactus">0</h3><p>Contact Us Requests</p></div>
                <div class="icon"><i class="ion ion-android-contacts"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'contact_request', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-gnut">
                <div class="inner"><h3 id="pend_writeus">0</h3><p>Write to Us</p></div>
                <div class="icon"><i class="fa fa-pencil-square"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'write_to_us', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-bookingtab">
                <div class="inner"><h3 id="pend_bookings">0</h3><p>Business Bookings</p></div>
                <div class="icon"><i class="fa fa-ticket"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'bookings', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-groupbookingtab">
                <div class="inner"><h3 id="pend_groupbookings">0</h3><p>Group Bookings</p></div>
                <div class="icon"><i class="ion ion-android-people"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'group_booking_requests', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-revratings">
                <div class="inner"><h3 id="pend_reviews">0</h3><p>Review & Ratings</p></div>
                <div class="icon"><i class="fa fa-star"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'business_ratings', 'action' => 'all', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-crimson">
                <div class="inner"><h3 id="pend_tutors">0</h3><p>Looking for a Tutor</p></div>
                <div class="icon"><i class="fa fa-search"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'inquiries', 'action' => 'index', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-feedbacks">
                <div class="inner"><h3 id="pend_feedbacks">0</h3><p>Feedback</p></div>
                <div class="icon"><i class="ion ion-android-textsms"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'feedbacks', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner"><h3 id="pend_calls">0</h3><p>Request a Call</p></div>
                <div class="icon"><i class="ion ion-android-call"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'call_request', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-contact-info">
                <div class="inner"><h3 id="pend_contact_info_requets">0</h3><p>Contact Requests</p></div>
                <div class="icon"><i class="fa fa-phone-square"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'inquiries', 'action' => 'contact_requests_info', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-subs">
                <div class="inner"><h3 id="pend_subscriptions">0</h3><p>Subscriptions</p></div>
                <div class="icon"><i class="fa fa-inr"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'subscriptions', 'action' => 'index', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-favs">
                <div class="inner"><h3 id="pend_bus_favorites">0</h3><p>Favorites</p></div>
                <div class="icon"><i class="fa fa-heart"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'business_favorite', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-feedbacks">
                <div class="inner"><h3 id="pend_event_activation">0</h3><p>Events</p></div>
                <div class="icon"><i class="ion ion-speakerphone"></i></div>
                <a href="<?php echo $this->Html->url(array('controller' => 'events', 'action' => 'index', 'admin' => 1)); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <!-- /.row -->
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
</section><!-- /.content -->
<?php #echo $this->Html->script(array('jquery.dataTables.min', 'dataTables.bootstrap.min'), array('block' => 'bootstrap_datatable')); ?>
<script type="text/javascript">
    var _animated_css = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
    $(document).ready(function () {
        count_refresh();
        setInterval("count_refresh()", 60000);
    });

    function count_refresh() {
        $('#widgets_refresh').addClass('fa-spin');
        $.ajax({
            type: "POST",
            url: HTTP_ROOT + "users/dashboard_counts",
            data: {},
            dataType: 'json',
            success: function (counts) {
                $('#widgets_refresh').removeClass('fa-spin');
                if (counts) {
                    for (var pending_counts in counts) {
                        set_count(pending_counts, counts[pending_counts]);
                    }
                }
            }
        });
    }
    function set_count(id, val) {
        $('#' + id).addClass('animated fadeOut').one(_animated_css, function () {
            $('#' + id).removeClass('animated fadeOut').text(val).addClass('animated fadeIn').one(_animated_css, function () {
                 $('#' + id).removeClass('animated fadeIn')
            });
        });
    }
</script>