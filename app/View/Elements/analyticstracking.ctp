<?php 
if (strstr($_SERVER['HTTP_HOST'], 'stag.mrclass.in') || strstr($_SERVER['HTTP_HOST'], 'localhost') || strstr($_SERVER['HTTP_HOST'], '192.168')) {
    /* no action */
} else {
    ?>
    <?php
    $analytic_pages = array('home', 'sign_up', 'login', 'static_page', 'press', 'feedback', 'careers',
        'contact_us', 'search', 'faq', 'looking_for_tutor', 'forgot_password');
    $action = $this->params['action'];
    $controller = $this->params['controller'];
    if (empty($this->params['prefix']) && (in_array($action, $analytic_pages) || ($action == 'view' && $controller == 'businesses'))) {
        ?>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
          ga('create', 'UA-71180505-1', 'auto');
          ga('send', 'pageview');
        </script>
    <?php } ?>
<?php } ?>