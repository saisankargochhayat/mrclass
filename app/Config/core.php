MrClass.in
1. Credentials
a) Live server credentials:
1. http://www.mrclass.in/
DB Name: mrclass
2. Admin url: http://www.mrclass.in/mcsuper/
u: admin
p: <Password already with MRC>

Blog
3. Blog url: http://www.mrclass.in/blog/ - It is a wordpress application
DB Name: mrclass_blog
4. http://www.mrclass.in/blog/mcblogadmin/
u: mcblog
p: v$XK$4JGkqvk^HLOazxbeh5$

b) Database credentials:
url: http://www.mrclass.in/phpmyadmin/
1. Root user:
u: root
p: mrclass123
2. application user:
u: mrclassuser
p: 8JhJDuqkjItp6sXN

c) Staging server details:
1. http://stag.mrclass.in/ (currently it is not working as IP might not have mapped with domain)
DB Name: staging_mrclass
2. Admin url: http://stag.mrclass.in/mcsuper/
u: admin
p: admin
Blog
3. Blog url: http://stag.mrclass.in/blog/
DB Name: staging_mrclass_blog
4. http://stag.mrclass.in/blog/mcblogadmin
u: admin
p: <check>

2. Environment details of CakePHP Application -  MrClass.in
a) Server version: Apache/2.2.15
b) OS: Centos x86_64
c) PHP: 5.3.3
d) MySql: 5.5.48
e) CakePHP: 2.7
f) Blog is developed in WordPress
g) wkhtmltopdf 0.10.0 rc2
h) ImageMagick 6.7.2-7

3. Hosting details:
a) Machine type: n1-standard-1 (1 vCPU, 3.75 GB memory)
b) https://cloud.google.com
user: andolasoft@mrclass.in
pass: googlehosting123
c) Domain Hosting: GoDaddy server

4. API details
Facebook: These credentials required to update in \app\Config\bootstrap.php,
The app currently present in our FB account! Please change to your FB account so that we can remove from ours.
a)

1. define('FACEBOOK_APP_ID', 'xxxxxx');
2. define('FACEBOOK_APP_SECRET', 'xxxx);
3. define('FACEBOOK_REDIRECT_URI', 'xxxxxx');
b) Google: These credentials required to update in \app\Config\bootstrap.php
The app currently present in our GOOGLE account! Please change to your GOOGLE account so that we can remove from ours.

1. define('GOOGLE_CLIENT_ID', 'xxxxxx');
2. define('GOOGLE_CLIENT_SECRET', 'xxxxxx');
3. define('GOOGLE_OAUTH_REDIRECT_URI', 'xxxxxx');

c) Sendgrid email: https://app.sendgrid.com/ - This is 3rd party vendor
u: mrclass.india
p: test1234

5. Page wise controller and views

1) Edit profile: '/edit-profile', 'controller' = 'users', 'view' = 'edit'
2) Favorites: '/favorites', 'controller' = 'businesses', 'view' = 'favorites'
3) Sign-up: '/signup', 'controller' = 'users', 'view' = 'sign_up'
4) Dashboard: '/dashboard', 'controller' = 'users', 'view' = 'dashboard'
5) Login: '/login', 'controller' = 'users', 'view' = 'login'
6) Logout: '/logout', 'controller' = 'users', 'view' = 'logout'
7) Activate: '/activate', 'controller' = 'users', 'view' = 'activate_account'
8) Forgot password: '/forgot-password', 'controller' = 'users', 'view' = 'forgot_password'
9) Reset password: '/reset-password/*', 'controller' = 'content', 'view' = 'reset_password', 'title' => 'Reset Password'
10) Change Password: '/change-password', 'controller' = 'users', 'view' = 'change_password_user'
11) Recently viewed classes: '/recently-viewed-classes', 'controller' = 'users', 'view' = 'recently_viewed_classes'
12) Categories: '/categories/*', 'controller' = 'content', 'view' = 'categories'
13) Category details: '/c-:id-:slug', 'controller' = 'content', 'view' = 'categories'
14) Press: '/press', 'controller' = 'content', 'view' = 'press'
15) Feedback: '/feedback', 'controller' = 'content', 'view' = 'feedback'
16) Contact Us: '/contact-us', 'controller' = 'content', 'view' = 'contact_us'
17) Looking for a tutor: '/looking-for-a-tutor', 'controller' = 'content', 'view' = 'looking_for_tutor'
18) Refer a friend: '/refer-a-friend', 'controller' = 'content', 'view' = 'refer_friend'
19) Search: '/search', 'controller' = 'content', 'view' = 'search'
20) FAQs: '/faq', 'controller' = 'content', 'view' = 'faq'
21) Career: '/career', 'controller' = 'content', 'view' = 'careers'
22) About us: '/about-us', 'controller' = 'content', 'view' = 'static_page', 'about_us'
23) Terms and Conditions: '/terms-and-conditions', 'controller' = 'content', 'view' = 'static_page', 'terms_and_conditions'
24) Privacy policy: '/privacy-policy', 'controller' = 'content', 'view' = 'static_page', 'privacy_policy'
25) Our team: '/our-team', 'controller' = 'content', 'view' = 'static_page', 'the_team'
26) The platform: '/the-platform', 'controller' = 'content', 'view' = 'static_page', 'the_platform'
27) Business dashboard: '/business-dashboard', 'controller' = 'businesses', 'view' = 'index'
28) Create business: '/create-business/*', 'controller' = 'businesses', 'view' = 'add'
29) Edit business: '/edit-business-:id-:slug', 'controller' = 'businesses', 'view' = 'edit'
30) Business gallery images: '/business-pics-:id-:slug', 'controller' = 'business_galleries', 'view' = 'add'
31) Business videos: '/business-videos-:id-:slug', 'controller' = 'business_galleries', 'view' = 'add_video_link'
32) Business timings: '/business-timing-:id-:slug', 'controller' = 'business_timings', 'view' = 'add'
33) Business FAQs: '/business-faq-:id-:slug', 'controller' = 'BusinessFaqs', 'view' = 'index'
34) Business courses: '/business-courses-:id-:slug', 'controller' = 'Businesses', 'view' = 'courses'
35) Business details: '/b-:id-:slug', 'controller' = 'businesses', 'view' = 'view'
36) Call requests: '/call-requests', 'controller' = 'reports', 'view' = 'call_requests'
37) My Bookings: '/my-bookings', 'controller' = 'reports', 'view' = 'my_bookings'
38) Booking requests: '/booking-requests', 'controller' = 'reports', 'view' = 'bookings'
39) My reviews: '/my-reviews', 'controller' = 'business_ratings', 'view' = 'my_reviews'
40) Business reviews: '/business-reviews', 'controller' = 'business_ratings', 'view' = 'reviews'
41) Google login: '/google_login', 'controller' = 'users', 'view' = 'google_login'
42) Choose subscription: '/choose-subscription', 'controller' = 'subscriptions', 'view' = 'choose_subscription'
43) Question banks: '/question-banks', 'controller' = 'QuestionCategories', 'view' = 'index'
44) Question bank detail: '/question-papers/:id/:slag', 'controller' = "questions", 'view' = "index"
45) Question bank download url: '/question-bank-download/:cid/:id/:cat/:file', 'controller' = "questions", 'view' = "question_bank_download"
46) Create event: '/create-event', 'controller' = 'events', 'view' = 'add'
47) Edit event: '/edit-event-:id', 'controller' = 'events', 'view' = 'edit'
48) Event list: '/events-list', 'controller' = 'content', 'view' = 'event_list'
49) Event details: '/e-:id-:slug', 'controller' = 'content', 'view' = 'event_view'
<?php

/**
 * This is core configuration file.
 *
 * Use it to configure core behavior of Cake.
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
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * CakePHP Debug Level:
 *
 * Production Mode:
 * 	0: No error messages, errors, or warnings shown. Flash messages redirect.
 *
 * Development Mode:
 * 	1: Errors and warnings shown, model caches refreshed, flash messages halted.
 * 	2: As in 1, but also with full debug messages and SQL output.
 *
 * In production mode, flash messages redirect after a time interval.
 * In development mode, you need to click the flash message to continue.
 */
Configure::write('debug', 2);


/**
 * Configure the Error handler used to handle errors for your application. By default
 * ErrorHandler::handleError() is used. It will display errors using Debugger, when debug > 0
 * and log errors with CakeLog when debug = 0.
 *
 * Options:
 *
 * - `handler` - callback - The callback to handle errors. You can set this to any callable type,
 *   including anonymous functions.
 *   Make sure you add App::uses('MyHandler', 'Error'); when using a custom handler class
 * - `level` - integer - The level of errors you are interested in capturing.
 * - `trace` - boolean - Include stack traces for errors in log files.
 *
 * @see ErrorHandler for more information on error handling and configuration.
 */
Configure::write('Error', array(
    'handler' => 'ErrorHandler::handleError',
    'level' => E_ALL & ~E_DEPRECATED,
    'trace' => true
));

/**
 * Configure the Exception handler used for uncaught exceptions. By default,
 * ErrorHandler::handleException() is used. It will display a HTML page for the exception, and
 * while debug > 0, framework errors like Missing Controller will be displayed. When debug = 0,
 * framework errors will be coerced into generic HTTP errors.
 *
 * Options:
 *
 * - `handler` - callback - The callback to handle exceptions. You can set this to any callback type,
 *   including anonymous functions.
 *   Make sure you add App::uses('MyHandler', 'Error'); when using a custom handler class
 * - `renderer` - string - The class responsible for rendering uncaught exceptions. If you choose a custom class you
 *   should place the file for that class in app/Lib/Error. This class needs to implement a render method.
 * - `log` - boolean - Should Exceptions be logged?
 * - `skipLog` - array - list of exceptions to skip for logging. Exceptions that
 *   extend one of the listed exceptions will also be skipped for logging.
 *   Example: `'skipLog' => array('NotFoundException', 'UnauthorizedException')`
 *
 * @see ErrorHandler for more information on exception handling and configuration.
 */
Configure::write('Exception', array(
    'handler' => 'ErrorHandler::handleException',
    'renderer' => 'ExceptionRenderer',
    'log' => true
));

/**
 * Application wide charset encoding
 */
Configure::write('App.encoding', 'UTF-8');

/**
 * To configure CakePHP *not* to use mod_rewrite and to
 * use CakePHP pretty URLs, remove these .htaccess
 * files:
 *
 * /.htaccess
 * /app/.htaccess
 * /app/webroot/.htaccess
 *
 * And uncomment the App.baseUrl below. But keep in mind
 * that plugin assets such as images, CSS and JavaScript files
 * will not work without URL rewriting!
 * To work around this issue you should either symlink or copy
 * the plugin assets into you app's webroot directory. This is
 * recommended even when you are using mod_rewrite. Handling static
 * assets through the Dispatcher is incredibly inefficient and
 * included primarily as a development convenience - and
 * thus not recommended for production applications.
 */
//Configure::write('App.baseUrl', env('SCRIPT_NAME'));

/**
 * To configure CakePHP to use a particular domain URL
 * for any URL generation inside the application, set the following
 * configuration variable to the http(s) address to your domain. This
 * will override the automatic detection of full base URL and can be
 * useful when generating links from the CLI (e.g. sending emails)
 */
//Configure::write('App.fullBaseUrl', 'http://example.com');

/**
 * Web path to the public images directory under webroot.
 * If not set defaults to 'img/'
 */
//Configure::write('App.imageBaseUrl', 'img/');

/**
 * Web path to the CSS files directory under webroot.
 * If not set defaults to 'css/'
 */
//Configure::write('App.cssBaseUrl', 'css/');

/**
 * Web path to the js files directory under webroot.
 * If not set defaults to 'js/'
 */
//Configure::write('App.jsBaseUrl', 'js/');

/**
 * Uncomment the define below to use CakePHP prefix routes.
 *
 * The value of the define determines the names of the routes
 * and their associated controller actions:
 *
 * Set to an array of prefixes you want to use in your application. Use for
 * admin or other prefixed routes.
 *
 * 	Routing.prefixes = array('admin', 'manager');
 *
 * Enables:
 * 	`admin_index()` and `/admin/controller/index`
 * 	`manager_index()` and `/manager/controller/index`
 *
 */
Configure::write('Routing.prefixes', array('admin', 'business'));

/**
 * Turn off all caching application-wide.
 *
 */
//Configure::write('Cache.disable', true);

/**
 * Enable cache checking.
 *
 * If set to true, for view caching you must still use the controller
 * public $cacheAction inside your controllers to define caching settings.
 * You can either set it controller-wide by setting public $cacheAction = true,
 * or in each action using $this->cacheAction = true.
 *
 */
//Configure::write('Cache.check', true);

/**
 * Enable cache view prefixes.
 *
 * If set it will be prepended to the cache name for view file caching. This is
 * helpful if you deploy the same application via multiple subdomains and languages,
 * for instance. Each version can then have its own view cache namespace.
 * Note: The final cache file name will then be `prefix_cachefilename`.
 */
//Configure::write('Cache.viewPrefix', 'prefix');

/**
 * Session configuration.
 *
 * Contains an array of settings to use for session configuration. The defaults key is
 * used to define a default preset to use for sessions, any settings declared here will override
 * the settings of the default config.
 *
 * ## Options
 *
 * - `Session.cookie` - The name of the cookie to use. Defaults to 'CAKEPHP'
 * - `Session.timeout` - The number of minutes you want sessions to live for. This timeout is handled by CakePHP
 * - `Session.cookieTimeout` - The number of minutes you want session cookies to live for.
 * - `Session.checkAgent` - Do you want the user agent to be checked when starting sessions? You might want to set the
 *    value to false, when dealing with older versions of IE, Chrome Frame or certain web-browsing devices and AJAX
 * - `Session.defaults` - The default configuration set to use as a basis for your session.
 *    There are four builtins: php, cake, cache, database.
 * - `Session.handler` - Can be used to enable a custom session handler. Expects an array of callables,
 *    that can be used with `session_save_handler`. Using this option will automatically add `session.save_handler`
 *    to the ini array.
 * - `Session.autoRegenerate` - Enabling this setting, turns on automatic renewal of sessions, and
 *    sessionids that change frequently. See CakeSession::$requestCountdown.
 * - `Session.ini` - An associative array of additional ini values to set.
 *
 * The built in defaults are:
 *
 * - 'php' - Uses settings defined in your php.ini.
 * - 'cake' - Saves session files in CakePHP's /tmp directory.
 * - 'database' - Uses CakePHP's database sessions.
 * - 'cache' - Use the Cache class to save sessions.
 *
 * To define a custom session handler, save it at /app/Model/Datasource/Session/<name>.php.
 * Make sure the class implements `CakeSessionHandlerInterface` and set Session.handler to <name>
 *
 * To use database sessions, run the app/Config/Schema/sessions.php schema using
 * the cake shell command: cake schema create Sessions
 *
 */
Configure::write('Session', array(
    'defaults' => 'php'
));

/**
 * A random string used in security hashing methods.
 */
Configure::write('Security.salt', 'DYhG93b0qyJfIxfs112guVoUubWwvniR2G0FgaC9mi');
// Configure::write('Security.salt', '');


/**
 * A random numeric string (digits only) used to encrypt/decrypt strings.
 */
Configure::write('Security.cipherSeed', '7116859309657453542496749683645');


/**
 * Apply timestamps with the last modified time to static assets (js, css, images).
 * Will append a query string parameter containing the time the file was modified. This is
 * useful for invalidating browser caches.
 *
 * Set to `true` to apply timestamps when debug > 0. Set to 'force' to always enable
 * timestamping regardless of debug value.
 */
//Configure::write('Asset.timestamp', true);

/**
 * Compress CSS output by removing comments, whitespace, repeating tags, etc.
 * This requires a/var/cache directory to be writable by the web server for caching.
 * and /vendors/csspp/csspp.php
 *
 * To use, prefix the CSS link URL with '/ccss/' instead of '/css/' or use HtmlHelper::css().
 */
//Configure::write('Asset.filter.css', 'css.php');

/**
 * Plug in your own custom JavaScript compressor by dropping a script in your webroot to handle the
 * output, and setting the config below to the name of the script.
 *
 * To use, prefix your JavaScript link URLs with '/cjs/' instead of '/js/' or use JsHelper::link().
 */
//Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');

/**
 * The class name and database used in CakePHP's
 * access control lists.
 */
Configure::write('Acl.classname', 'DbAcl');
Configure::write('Acl.database', 'default');

/**
 * Uncomment this line and correct your server timezone to fix
 * any date & time related errors.
 */
date_default_timezone_set('Asia/Kolkata');

/**
 * `Config.timezone` is available in which you can set users' timezone string.
 * If a method of CakeTime class is called with $timezone parameter as null and `Config.timezone` is set,
 * then the value of `Config.timezone` will be used. This feature allows you to set users' timezone just
 * once instead of passing it each time in function calls.
 */
//Configure::write('Config.timezone', 'Europe/Paris');

/**
 * Cache Engine Configuration
 * Default settings provided below
 *
 * File storage engine.
 *
 * 	 Cache::config('default', array(
 * 		'engine' => 'File', //[required]
 * 		'duration' => 3600, //[optional]
 * 		'probability' => 100, //[optional]
 * 		'path' => CACHE, //[optional] use system tmp directory - remember to use absolute path
 * 		'prefix' => 'cake_', //[optional]  prefix every cache file with this string
 * 		'lock' => false, //[optional]  use file locking
 * 		'serialize' => true, //[optional]
 * 		'mask' => 0664, //[optional]
 * 	));
 *
 * APC (http://pecl.php.net/package/APC)
 *
 * 	 Cache::config('default', array(
 * 		'engine' => 'Apc', //[required]
 * 		'duration' => 3600, //[optional]
 * 		'probability' => 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 * 	));
 *
 * Xcache (http://xcache.lighttpd.net/)
 *
 * 	 Cache::config('default', array(
 * 		'engine' => 'Xcache', //[required]
 * 		'duration' => 3600, //[optional]
 * 		'probability' => 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional] prefix every cache file with this string
 * 		'user' => 'user', //user from xcache.admin.user settings
 * 		'password' => 'password', //plaintext password (xcache.admin.pass)
 * 	));
 *
 * Memcached (http://www.danga.com/memcached/)
 *
 * Uses the memcached extension. See http://php.net/memcached
 *
 * 	 Cache::config('default', array(
 * 		'engine' => 'Memcached', //[required]
 * 		'duration' => 3600, //[optional]
 * 		'probability' => 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 * 		'servers' => array(
 * 			'127.0.0.1:11211' // localhost, default port 11211
 * 		), //[optional]
 * 		'persistent' => 'my_connection', // [optional] The name of the persistent connection.
 * 		'compress' => false, // [optional] compress data in Memcached (slower, but uses less memory)
 * 	));
 *
 *  Wincache (http://php.net/wincache)
 *
 * 	 Cache::config('default', array(
 * 		'engine' => 'Wincache', //[required]
 * 		'duration' => 3600, //[optional]
 * 		'probability' => 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 * 	));
 */
/**
 * Configure the cache handlers that CakePHP will use for internal
 * metadata like class maps, and model schema.
 *
 * By default File is used, but for improved performance you should use APC.
 *
 * Note: 'default' and other application caches should be configured in app/Config/bootstrap.php.
 *       Please check the comments in bootstrap.php for more info on the cache engines available
 *       and their settings.
 */
$engine = 'File';

// In development mode, caches should expire quickly.
$duration = '+999 days';
if (Configure::read('debug') > 0) {
    $duration = '+10 seconds';
}

// Prefix each application on the same server with a different string, to avoid Memcache and APC conflicts.
$prefix = 'myapp_';

/**
 * Configure the cache used for general framework caching. Path information,
 * object listings, and translation cache files are stored with this configuration.
 */
Cache::config('_cake_core_', array(
    'engine' => $engine,
    'prefix' => $prefix . 'cake_core_',
    'path' => CACHE . 'persistent' . DS,
    'serialize' => ($engine === 'File'),
    'duration' => $duration
));

/**
 * Configure the cache for model and datasource caches. This cache configuration
 * is used to store schema descriptions, and table listings in connections.
 */
Cache::config('_cake_model_', array(
    'engine' => $engine,
    'prefix' => $prefix . 'cake_model_',
    'path' => CACHE . 'models' . DS,
    'serialize' => ($engine === 'File'),
    'duration' => $duration
));

if (!defined('SUB_FOLDER')) {
    if(strstr($_SERVER['HTTP_HOST'],'winterfell.tk')){
        define('SUB_FOLDER', '');
    }else{
        define('SUB_FOLDER', 'mrclass/');
    }
}

$ht = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? "https://" : "http://";
if (!defined('PROTOCOL')) {
    define('PROTOCOL', $ht);
}
if (!defined('DOMAIN')) {
    if ($_SERVER['SERVER_PORT'] != 80)
        define('DOMAIN', $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/");
    else
        define('DOMAIN', $_SERVER['SERVER_NAME'] . "/");
}
if (!defined('HTTP_SERVER')) {
    define('HTTP_SERVER', PROTOCOL . DOMAIN);
}
if (!defined('HTTP_ROOT')) {
    define('HTTP_ROOT', HTTP_SERVER . SUB_FOLDER);
}

if (!defined('DOMAIN_COOKIE')) {
    define('DOMAIN_COOKIE', $_SERVER['SERVER_NAME']);
}

Configure::write('EMAIL_DELIVERY_MODE', "default"); # default smtp or empty
