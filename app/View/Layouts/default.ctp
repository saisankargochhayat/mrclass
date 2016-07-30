<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
# manifest="<?php echo HTTP_ROOT; ? >appmrclass.appcache"
$cakeDescription = __d('cake_dev', 'Mr. Class');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <?php if($parms['controller'] == "users" && $parms['action'] == "login"){?>
        <meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-client_id" content="816686345567-8nm7ct6rhtmqcl33efotlqevu0h3jlek.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
    <?php } ?>
    <?php if($parms['controller'] == "users" && ($parms['action'] == "sign_up")){?>
       <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
       <script src="https://apis.google.com/js/api:client.js"></script>
    <?php } ?>
        <meta name="viewport" content="width=device-width, height=device-height,  initial-scale=1.0, user-scalable=0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php echo $this->Html->charset(); ?>
        <title><?php echo Configure::read('COMPANY.META_TITLE'); ?><?php echo ($this->fetch('title') != '' ? " | " : "").$this->fetch('title'); ?></title>

        <?php
        echo $this->Html->meta('icon');
        if(Configure::read('COMPANY.META_DESCRIPTION')!=''){
            echo $this->Html->meta('description', '', array('content' => Configure::read('COMPANY.META_DESCRIPTION')));
        }
        if(Configure::read('COMPANY.META_KEYWORDS')!=''){
            echo $this->Html->meta('keywords', '', array('content' => Configure::read('COMPANY.META_KEYWORDS')));
        }
        echo $this->Html->css(array('font-awesome.min', 'ionicons.min'));
        echo $this->Html->css(array('select2.min','colorbox'));
        #$action_tree = array('bookings', 'reviews', 'call_requests', 'my_bookings', 'my_reviews', 'dashboard', 'recently_viewed_classes');
        if (empty($this->params['prefix']) && in_array($parms['action'], $action_tree)) {
            echo $this->Html->css(array('jquery.dataTables', 'dataTables.fontAwesome'));
        }
        echo $this->Html->css(array('style', 'jquery-ui.min', 'dev'));
        if(($parms['controller'] == 'content') && ($parms['action'] == 'static_page' || $parms['action'] == 'search')){
            echo $this->Html->css(array('jquery.jscrollpane'));
        }
        echo $this->fetch('meta');
        echo $this->fetch('css');
        /*
         * JS FILES
         */
        #echo $this->Html->script(array('jQuery-2.1.4.min', 'jquery-ui.min.js'));
        echo $this->Html->script(array('jquery-1.9.1.min', 'jquery-ui.min.js','jquery.validate.min','script_common','validation_script','mc_common_script_v1'));
        if(empty($this->params['prefix']) && in_array($this->params['action'], $action_tree)){
            echo $this->Html->script(array('jquery.dataTables.min','jquery.highlight.js'));
        }
        echo $this->Html->script(array('select2.full.min'));
        echo $this->Html->script(array('colorbox/jquery.colorbox-min'), array('inline' => false));
        ?>
        <?php if(($parms['controller'] == 'content') && ($parms['action'] == 'static_page' || $parms['action'] == 'search')){
            echo $this->Html->script(array('jquery.jscrollpane.min','jquery.mousewheel'));
        }?>
        <?php if($this->params['controller'] == 'content' && $this->params['action'] == 'home'){?>
            <?php echo $this->Html->css(array('banner.slider'));?>
            <?php echo $this->fetch('bannerResources');?>
        <?php }?>
        <script type="text/javascript">
            var HTTP_ROOT = '<?php echo HTTP_ROOT; ?>';
            var SESSION_USER = '<?php echo $user["id"]; ?>';
            var CONTROLLER = '<?php echo $parms["controller"]; ?>';
            var ACTION = '<?php echo $parms["action"]; ?>';
            $device = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
        </script>

        <style>
          @media all and (-ms-high-contrast:none) {
                      a, img {border:none;  outline:none}
                      .ultimate h2{font-weight:300;}
           }
        </style>
        <!--[if lte IE 9]>
             <style>
                     a, img {border:none;  outline:none}
                     .ultimate h2{font-weight:300;}
                     .banner_form .src-button{background:#4096ee;}
                     .banner_form .src-button:hover{background:#3285da;}
             </style>
             <![endif]-->
        <meta name="format-detection" content="telephone=no">
        <?php echo $this->element('analyticstracking'); ?>
    </head>
    <body class="<?php echo $this->Session->read('Auth.User.id') > 0? "after-login" : "before-login"?> <?php echo $this->params['action'] == 'home' ? "home-page" : "inner-pages" ;?>">
        <?php if($this->params['controller'] == 'content' && $this->params['action'] == 'home'){?>
            <?php echo $this->element('banner'); ?>
        <?php }?>

        <div id="container" style="position:relative;">
            <div class="overlay_div" style="display:none;">
                    <img src="<?php echo HTTP_ROOT; ?>images/ajax-loader.gif" class="loader" alt="loader">
            </div>
            <div id="header" class="<?php echo $this->Session->read('Auth.User.id') > 0 && $this->params['action'] != 'home'? "sticky_header" : ""?>">
                <?php echo $this->element('header'); ?>
            </div>
            <div id="content">
                <?php echo $this->Flash->render(); ?>
                <?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer">
                <?php echo $this->element('footer'); ?>
            </div>
        </div>
        <?php
        echo $this->fetch('script');
//        echo $this->element('sql_dump');
        ?>
        <script type="text/javascript">
            $(document).ready(function(){
                <?php if($parms['action'] == 'login' && isset($_SERVER['HTTP_REFERER']) &&  strpos($_SERVER['HTTP_REFERER'],'signup')){?>
                        //alert(123)
                <?php }else{ ?>
                    if($('.alert-dismissible').is(':visible')){
                        setTimeout(function(){
                            $('.alert-dismissible').fadeOut(function(){$('.js-alert-box-error,.js-alert-box-success').hide();});
                            //$('.alert-dismissible').fadeOut(function(){$('.alert-dismissible').remove()});
                        },5000);
                    }
                <?php } ?>
                $(".alert-dismissible,.close-alert").click(function(){
                    //, .alert-dismissible
                    $('.alert-dismissible').fadeOut(function(){$('.js-alert-box-error,.js-alert-box-success').hide();/*$('.alert-dismissible').remove()*/});
                });
            });
        </script>
        <?php
        $act_arr = array('home', 'sign_up', 'login');
        if(in_array($this->params['action'], $act_arr)){ ?>
            <div id="map"></div>
            <input type="hidden" id="localityLatitude"/>
            <input type="hidden" id="localityLongitude"/>
            <input type="hidden" id="localityCity"/>
            <input type="hidden" id="localityCityId"/>
            <input type="hidden" id="localityArea"/>
            <input type="hidden" id="localityShort"/>
            <input type="hidden" id="localitydefCity"/>
            <input type="hidden" id="localitydeflng"/>
            <input type="hidden" id="localitydeflat"/>
        <?php if($this->Session->read('user_location.lon') == ''){ ?>
            <script type="text/javascript">

                // Note: This example requires that you consent to location sharing when
                // prompted by your browser. If you see the error "The Geolocation service
                // failed.", it means you probably did not give permission for the browser to
                // locate you.
                var addr = "";
                function initMap() {
                    var map = new google.maps.Map(document.getElementById('map'), {
                        center: {lat: 20.296059, lng: 85.824540},
                        zoom: 8
                    });
                    var infoWindow = new google.maps.InfoWindow({map: map});

                    // Try HTML5 geolocation.
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var pos = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            };
                            var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                            var geocoder = new google.maps.Geocoder();
                            geocoder.geocode({'location': latlng}, function(results, status) {
                                if (status == google.maps.GeocoderStatus.OK) {
                                    if (results[1]) {
                                        map.setZoom(11);
                                        //jQuery("#where_search_2102").val(results[0].formatted_address);
                                        var addr2 = results[1].formatted_address;
                                        //alert(addr2);
                                        $("#localityLatitude, #latitude").val(results[1].geometry.location.lat());
                                        $("#localityLongitude, #longitude").val(results[1].geometry.location.lng());

                                        if(typeof results != 'undefined' && typeof results[1] != 'undefined'){
                                            $.each(results[1].address_components,function(key,val){
                                                if(val.types[0] == 'locality') {
                                                    //console.log(val.long_name)
                                                    //$('#InquiryCity').val(val.long_name);
                                                    $('#localityCity').val(val.long_name);
                                                    if($('#HomeCity').length > 0){
                                                        $('#HomeCity').find('option').each(function(){
                                                            //console.log($(this).html())
                                                            //console.log('levenshtein: '+levenshtein($(this).html(),val.long_name)+" : " +$(this).html());
                                                            //if($(this).html() == val.long_name){
                                                            if(levenshtein($(this).html(),val.long_name) < 2){
                                                                //console.log($(this).val())
                                                                set_city($(this).val());
                                                                $('#localityCityId').val($(this).val());
                                                            }
                                                        });
                                                    }
                                                    if($('#UserCity').length > 0){
                                                        $('#UserCity').find('option').each(function(){
                                                            //console.log('levenshtein: '+levenshtein($(this).html(),val.long_name)+" : " +$(this).html());
                                                            //if($(this).html() == val.long_name){
                                                            if(levenshtein($(this).html(),val.long_name) < 2){
                                                                set_city($(this).val());
                                                                $('#UserCity').select2("val",$(this).val());
                                                            }
                                                        });
                                                    }
                                                    save_data();
                                                }
                                            });
                                        }
                                        infoWindow.setContent(results[1].formatted_address);
                                    }
                                }
                            });
                            infoWindow.setPosition(pos);

                            map.setCenter(pos);
                        }, function() {
                            handleLocationError(true, infoWindow, map.getCenter());
                        });
                    } else {
                        // Browser doesn't support Geolocation
                        handleLocationError(false, infoWindow, map.getCenter());
                    }
                }

                function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                    infoWindow.setPosition(pos);
                    infoWindow.setContent(browserHasGeolocation ?
                            'Error: The Geolocation service failed.' :
                            'Error: Your browser doesn\'t support geolocation.');
                }

                function save_data(){
                        var params = {lat:$("#localityLatitude").val(),lon:$("#localityLongitude").val(),'city':$('#localityCity').val(),'cityid':$('#localityCityId').val()};
                        $.post(HTTP_ROOT+'content/update_location',params,function(response){console.log(response)});
                }
            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_KEY; ?>&callback=initMap&libraries=places&#038;sensor=true"></script>
            <?php
            }elseif($this->Session->read('user_location.city')!=''){
                $city = $this->Session->read('user_location.city');
                ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    if($('#HomeCity').length>0 || $('#UserCity').length>0){
                        $('#HomeCity,#UserCity').find('option').each(function(){
                            //console.log('levenshtein: '+levenshtein($(this).html(),'<?php echo $city;?>'));
                            //if($(this).html() == '<?php echo $city;?>'){
                            //console.log($(this).val()+' >> '+$(this).html())
                            if(parseInt(levenshtein($(this).html(),'<?php echo $city;?>')) < 2){
                                set_city($(this).val());
                                $('#localityCityId').val($(this).val());
                            }
                        });
                    }
                });
            </script>
            <?php } ?>
        <?php } ?>
        <script type="text/javascript">
            function set_city(cityid){
                $('#UserCity').length>0?$('#UserCity').select2('val',cityid):"";
                $('#HomeCity').val(cityid);
                $('#HomeCity').size()>0?update_locality(cityid):"";
            }
        </script>
        <?php if($parms['controller'] == "users" && ($parms['action'] == "login" || $parms['action'] == "sign_up")){?>
            <?php echo $this->element('login_script_block'); ?>
        <?php } ?>
            <?php echo $this->fetch('lazyLoad');?>
    </body>
</html>
