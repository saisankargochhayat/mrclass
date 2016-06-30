<!DOCTYPE html>
<html>
    <head>
       <?php echo $this->Html->charset(); ?>
        <title>Admin | <?php echo $this->fetch('title'); ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php echo $this->fetch('meta'); ?>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css(array('bootstrap.min', 'font-awesome.min', 'ionicons.min'));
        echo $this->Html->css(array('AdminLTE.min','admin_custom_css'));
        echo $this->fetch('css');
        echo $this->Html->script(array('jquery-1.9.1.min','jquery.validate.min','mc_common_script_v1'));
        echo $this->Html->script(array('bootstrap.min')); 
        echo $this->Html->script(array('icheck.min','admin_custom_script'));
        ?>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <?php echo $this->fetch('content'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                if ($('#flash').is(':visible')) {
                    var $el = $('#flash');
                    setTimeout(function () {
                        $el.addClass('animated fadeOutUp');
                    }, 3000);
                }
            });
        </script>
        <?php echo $this->Flash->render(); ?>
    </body>
</html>
