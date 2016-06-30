<!DOCTYPE html>
<?php //  manifest="<?php echo HTTP_ROOT; ? >admin.appcache" ?>
<html lang="en">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>Mr Class Admin | <?php echo $this->fetch('title'); ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php echo $this->fetch('meta'); ?>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css(array('bootstrap.min', 'font-awesome.min', 'ionicons.min'));?>
        <?php echo $this->fetch('timepickercss');
        echo $this->Html->css(array('select2.min'));?>
        <?php #$action_tree = array('admin_index','admin_facility_manage','admin_all','admin_contact_request','admin_call_request','admin_bookings','admin_feedbacks');?>
        <?php 
        if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin' && in_array($parms['action'], $admin_action_tree)) {
            echo $this->Html->css(array('dataTables.bootstrap'));
        }
        ?>
        <?php echo $this->fetch('bootstrap_datatable_css');
        echo $this->Html->css(array('AdminLTE.min', '_all-skins.min'));
        #echo $this->Html->css(array('select2.min'));
        echo $this->Html->css(array('admin_custom_css'));
        echo $this->fetch('css');
        echo $this->Html->script(array('jquery-1.9.1.min', 'jquery-ui.min.js','jquery.validate.min','lodash.min.js','mc_common_script_v1'));
        ?>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <?php echo $this->Html->script(array('bootstrap.min')); ?>
        <?php echo $this->fetch('timepicker');?>
        <?php
        if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin' && in_array($parms['action'], $admin_page_array)) {
            echo $this->Html->script(array('jquery.dataTables.min', 'dataTables.bootstrap.min', 'jquery.highlight.js'));
        }
        ?>
        <?php echo $this->Html->script(array('select2.full.min')); ?>
        <?php echo $this->fetch('script');?>
        <script>
            var AdminLTEOptions = {
                enableBSToppltip: true,
                BSTooltipSelector: "[rel='tooltip']"
            };
        </script>
        <?php echo $this->Html->script(array('app.min','admin_custom_script'));
        echo $this->fetch('dashboardjs');
        echo $this->fetch('demojs');
        ?>
        <script type="text/javascript">
            var HTTP_ROOT = '<?php echo HTTP_ROOT; ?>';
            var CONTROLLER = '<?php echo $parms['controller']; ?>';
            var ACTION = '<?php echo $parms['action']; ?>';
            var SESSION_USER  = JSON.parse('<?php echo json_encode($this->Session->read("Auth.User")); ?>') || 'Session not found';
            var table,page_no,page_limit,page_sort,page_name,act_url;
        </script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <style type="text/css">
        .error-message{color: red !important;}
    </style>
    <?php /*onload='window.print();'*/ ?>
    <body class="hold-transition skin-blue sidebar-mini" <?php echo ($parms['controller'] == 'transactions' && $parms['action'] == 'admin_print_invoice') ? "" : "";?>>
        <div class="wrapper">
            <?php if ($parms['controller'] == "transactions" && $parms['action'] == 'admin_print_invoice') { ?>
                <?php echo $this->fetch('content'); ?>
            <?php } else { ?>
                <?php echo $this->element('admin_header'); ?>
                <?php echo $this->element('admin_left_navbar'); ?>
                <div class="content-wrapper">
                    <?php echo $this->fetch('content'); ?>
                </div>
                <?php echo $this->element('admin_footer'); ?>
            <?php } ?>
        </div>
        <?php echo $this->fetch('scriptBottom'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                if ($('#flash').is(':visible')) {
                    var $el = $('#flash');
                    setTimeout(function () {
                        $el.addClass('animated fadeOutUp');
                    }, 3000);
                }
            if($('.dataTables_filter').is(':visible')){
               $('.dataTables_filter').find('input[type="search"]').on('keydown', function (e) {
                    if (e.which === 32 && !this.value.length)
                        e.preventDefault();
                });
            }
            });
        </script>
        <?php echo $this->Flash->render(); ?>
    </body>
</html>
