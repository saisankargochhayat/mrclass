<?php

/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */
/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */
/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */
CakePlugin::load('Upload');

/**
 * To prefer app translation over plugin translation, you can set
 *
 * Configure::write('I18n.preferApp', true);
 */
/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter. By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 * 		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 * 		'MyCacheFilter' => array('prefix' => 'my_cache_'), //  will use MyCacheFilter class from the Routing/Filter package in your app with settings array.
 * 		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 * 		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 * 		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
    'AssetDispatcher',
    'CacheDispatcher'
));

#Recaptcha settings
define('SITE_KEY', '6LcSWAwTAAAAABEr82OPPPBY6eRoP5nZvEs-s47-');
define('GOOGLE_SECRET_KEY', '6LcSWAwTAAAAAA2DOm4D-luTsuVsc6E9RBf0sW89');

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
    'engine' => 'File',
    'types' => array('notice', 'info', 'debug'),
    'file' => 'debug',
));
CakeLog::config('error', array(
    'engine' => 'File',
    'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
    'file' => 'error',
));

Configure::write('COMPANY', array(
    'NAME' => 'MrClass.in',
    'FOOTER' => "Regards,<br/><a href='" . HTTP_ROOT . "' target='_blank'>Mr Class</a><br/>Phone: 0674 - 694 1111",
    'FROM_EMAIL' => "info@mrclass.in",
    'ADMIN_EMAIL' => "id.email555@gmail.com",
    'SUPPORT_EMAIL' => "info@mrclass.in",
    'TOLLFREE' => "(0674) 694 1111",
    'ADDRESS' => "368/1906, Mahavir Nagar, Patia Square, Bhubaneswar, Odisha - 751024",
    'CONTACT_US_ADDRESS' => "368/1906,<br/> Mahavir Nagar,<br/>Patia Square,<br/>Bhubaneswar,<br/>Odisha - 751024",
    'CONTACT_US_EMAIL' => "info@mrclass.in",
    'CONTACT_US_MOBILE' => "+91-7205001807",
    'CONTACT_US_PHONE' => "0674-694 1111",
    'CONTACT_LATITUDE' => "20.3432723",
    'CONTACT_LONGITUDE' => "85.8220758",
    'FACEBOOK' => "https://www.facebook.com/mrclass.in",
    'TWITTER' => "https://twitter.com/mrclassin",
    'LINKEDIN' => "https://www.linkedin.com/company/mrclass",
    'GPLUS' => "https://plus.google.com/b/101730668007213646858/101730668007213646858/",
    'YOUTUBE' => "",
    'META_TITLE' => 'Mr Class',
    'META_KEYWORDS' => 'class, tutorial, classroom, class works, online classroom, education, classroom training, classroom activity, classroom activities, school activity, computer class, beauty care, beautycare, beauty care classes, Beauty Parlour training, Nail Art, Tattoo Art, Tattoo, Computer, Beauty care activity, find activities, search activity nearby, Art, Craft, art and craft activities, computer training, beauty care training, cooking classes, cookery classes, driving classes, driving training, car driving, education classes, competitive exams, CAT, AIPMT, JEE, IIT JEE, AIEEE, AIIMS, Medical, Engineering, MBA, IAS, Banking, Clerical, IBPS, Science, Commerce, English, Spoken English class, fashion class, fashion classes, fashion training, fashion, health and fitness, health class, fitness class, fitness classes, gym, yoga class, yoga, music and dance class, music and dance classes, Music, Dance, Summer Camp, find home tutor, search classes, photography classes, photography training, summer camps, camp training, sports training, sports classes, training, find classes nearby, find training centres, adventure sports, adventure camps, playschools and activities, playschools, activity and training, kids activity, adult training, Prep school, Play School, tutor, search tutor, tuitions, home tuition, private tuition, Bhubaneswar, Cuttack, Odisha',
    'META_DESCRIPTION' => 'The ultimate place to discover activities & academics of your choice in the neighborhood',
));

##################File Upload Directory Paths #########################

if (!defined('CATEGORY_IMG_DIR')) {
    define('CATEGORY_IMG_DIR', WWW_ROOT . 'upload' . DS . 'category');
}
if (!defined('BUSINESS_LOGO_DIR')) {
    define('BUSINESS_LOGO_PATH', 'upload' . DS . 'business' . DS);
    define('BUSINESS_LOGO_DIR', WWW_ROOT . BUSINESS_LOGO_PATH);
    define('BUSINESS_LOGO_URL', HTTP_ROOT . 'upload/business/');
}
if (!defined('EVENT_BANNER_DIR')) {
    define('EVENT_BANNER_PATH', 'upload' . DS . 'event' . DS);
    define('EVENT_BANNER_DIR', WWW_ROOT . EVENT_BANNER_PATH);
    define('EVENT_BANNER_URL', HTTP_ROOT . 'upload/event/');
}
if (!defined('BUSINESS_GALLERY_DIR')) {
    define('BUSINESS_GALLERY_PATH', 'upload' . DS . 'gallery' . DS);
    define('BUSINESS_GALLERY_DIR', WWW_ROOT . BUSINESS_GALLERY_PATH);
    define('BUSINESS_GALLERY_URL', HTTP_ROOT . 'upload/gallery/');
}
if (!defined('GOOGLE_MAP_KEY')) {
    define('GOOGLE_MAP_KEY', 'AIzaSyAbn9m4b84YR8Ajys1TslOsFB6Cn6XG_VU');
}

if (!defined('USER_IMAGE_DIR')) {
    define('USER_IMAGE_PATH', 'upload' . DS . 'user' . DS);
    define('USER_IMAGE_DIR', WWW_ROOT . USER_IMAGE_PATH);
    define('USER_IMAGE_URL', HTTP_ROOT . 'upload/user/');
}
if (!defined('PRESS_IMAGE_DIR')) {
    define('PRESS_IMAGE_PATH', 'upload' . DS . 'press' . DS);
    define('PRESS_IMAGE_DIR', WWW_ROOT . PRESS_IMAGE_PATH);
    define('PRESS_IMAGE_URL', HTTP_ROOT . 'upload/press/');
}

if (!defined('EMAIL_ATTACHMENT_TMP_PATH')) {
    define('EMAIL_ATTACHMENT_TMP_PATH', WWW_ROOT . 'attachments' . DS . 'tmp');
    define('EMAIL_ATTACHMENT_PATH', WWW_ROOT . 'attachments');
}

if (!defined('BANNER_ATTACHMENT_TMP_PATH')) {
    define('BANNER_PATH', 'upload' . DS . 'ad_banners' . DS);
    define('BANNER_ATTACHMENT_TMP_PATH', WWW_ROOT . BANNER_PATH . 'tmp');
    define('BANNER_ATTACHMENT_PATH', WWW_ROOT . BANNER_PATH);
    define('BANNER_ATTACHMENT_URL', HTTP_ROOT . 'upload/ad_banners/');
}

if (!defined('QUESTION_BANK_DIR')) {
    define('QUESTION_BANK_PATH', 'upload' . DS . 'Question_Bank' . DS);
    define('QUESTION_BANK_DIR', WWW_ROOT . QUESTION_BANK_PATH);
    define('QUESTION_BANK_TMP_PATH', QUESTION_BANK_DIR . 'tmp' . DS);
}

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    define('PDF_LIB_PATH', "C:/wkhtmltopdf/bin/wkhtmltopdf.exe");
} else {
    define('PDF_LIB_PATH', '/usr/bin/wkhtmltopdf');
}
define('HTTP_INVOICE_PATH', WWW_ROOT . 'upload' . DS . 'user_invoice' . DS);

// Load phpthumb config
Configure::load('Config');

if (!defined('BUSINESS_SEARCH_PAGE_LIMIT')) {
    define('BUSINESS_SEARCH_PAGE_LIMIT', 8);
}

define('FACEBOOK_APP_ID', '1548496722107447');
define('FACEBOOK_APP_SECRET', '4dc2f731e7b4f3e1f7562907ad17759e');
define('FACEBOOK_REDIRECT_URI', 'http://localhost/myclass/users/fb_login');

define('GOOGLE_CLIENT_ID', '816686345567-8nm7ct6rhtmqcl33efotlqevu0h3jlek.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'd1-RvGPzDjFd6iLClEP6oKI1');
define('GOOGLE_OAUTH_REDIRECT_URI', 'http://localhost/myclass/google_login');

Configure::write('NOTE', array(
    "MOBILE" => "E.g. Mob: +91 7205001806, Land: +91 6746941111"
));
#+91 7205001806, Land: +91 6746941111
#+91 9437094370, Land: +91 6742556677
Configure::write('DEFAULT', array(
    'LATITUDE' => "20.2960587",
    'LONGITUDE' => "85.82453980000003",
));

define('TAWKTO_KEY', '56696c890c2fc456799e4c2b');
