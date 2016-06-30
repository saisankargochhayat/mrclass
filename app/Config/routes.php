<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/mcsuper', array('controller' => 'users', 'action' => 'dashboard', 'admin' => 1));
Router::connect("/mcsuper/:controller", array('action' => 'index', 'prefix' => 'admin', 'admin' => true));
Router::connect("/mcsuper/:controller/:action/*", array('prefix' => 'admin', 'admin' => true));
#Router::connect('/admin', array('controller' => 'users', 'action' => 'dashboard', 'admin' => 1));
#Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
Router::connect('/', array('controller' => 'content', 'action' => 'home'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

Router::connect('/edit-profile', array('controller' => 'users', 'action' => 'edit'));
Router::connect('/favorites', array('controller' => 'businesses', 'action' => 'favorites'));
Router::connect('/signup', array('controller' => 'users', 'action' => 'sign_up'));
Router::connect('/dashboard', array('controller' => 'users', 'action' => 'dashboard'));
Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
Router::connect('/activate', array('controller' => 'users', 'action' => 'activate_account'));
Router::connect('/forgot-password', array('controller' => 'users', 'action' => 'forgot_password'));
Router::connect('/reset-password/*', array('controller' => 'content', 'action' => 'reset_password', 'title' => 'Reset Password'));
Router::connect('/change-password', array('controller' => 'users', 'action' => 'change_password_user'));
Router::connect('/recently-viewed-classes', array('controller' => 'users', 'action' => 'recently_viewed_classes'));

Router::connect('/categories/*', array('controller' => 'content', 'action' => 'categories', 'title' => 'Categories'));
Router::connect('/c-:id-:slug', array('controller' => 'content', 'action' => 'categories', 'pass' => array('id', 'slug'), 'id' => "[0-9]+", 'title' => 'Search Result'));
Router::connect('/blog', array('controller' => 'content', 'action' => 'blog'));
Router::connect('/admin/admins', array('controller' => 'users', 'action' => 'index', 'admin' => 1, 'type' => 'admin'));
Router::connect('/press', array('controller' => 'content', 'action' => 'press'));
Router::connect('/feedback', array('controller' => 'content', 'action' => 'feedback'));
Router::connect('/contact-us', array('controller' => 'content', 'action' => 'contact_us'));
Router::connect('/looking-for-a-tutor', array('controller' => 'content', 'action' => 'looking_for_tutor'));
Router::connect('/refer-a-friend', array('controller' => 'content', 'action' => 'refer_friend'));
Router::connect('/search', array('controller' => 'content', 'action' => 'search'));
Router::connect('/faq', array('controller' => 'content', 'action' => 'faq'));
Router::connect('/career', array('controller' => 'content', 'action' => 'careers'));

/* static pages */
Router::connect('/about-us', array('controller' => 'content', 'action' => 'static_page', 'about_us'));
Router::connect('/terms-and-conditions', array('controller' => 'content', 'action' => 'static_page', 'terms_and_conditions'));
Router::connect('/privacy-policy', array('controller' => 'content', 'action' => 'static_page', 'privacy_policy'));
Router::connect('/our-team', array('controller' => 'content', 'action' => 'static_page', 'the_team'));
Router::connect('/the-platform', array('controller' => 'content', 'action' => 'static_page', 'the_platform'));

/* Business pages */
Router::connect('/business-dashboard', array('controller' => 'businesses', 'action' => 'index'));
Router::connect('/create-business/*', array('controller' => 'businesses', 'action' => 'add'));
Router::connect('/edit-business-:id-:slug', array('controller' => 'businesses', 'action' => 'edit', 'title' => 'Edit Business'), array('pass' => array('id', 'slug'), 'id' => "[0-9]+", 'slug' => "[a-zA-Z\-]+"));
Router::connect('/edit-business-:id', array('controller' => 'businesses', 'action' => 'edit', 'title' => 'Edit Business'), array('pass' => array('id'), 'id' => "[0-9]+"));
Router::connect('/business-pics-:id-:slug', array('controller' => 'business_galleries', 'action' => 'add', 'type' => 'pics', 'title' => 'Edit Business Pics'), array('pass' => array('id'), 'id' => "[0-9]+"));
Router::connect('/business-videos-:id-:slug', array('controller' => 'business_galleries', 'action' => 'add_video_link', 'type' => 'vids', 'title' => 'Edit Business Videos'), array('pass' => array('id'), 'id' => "[0-9]+"));
Router::connect('/business-timing-:id-:slug', array('controller' => 'business_timings', 'action' => 'add', 'type' => 'timings', 'title' => 'Edit Business Timing'), array('pass' => array('id'), 'id' => "[0-9]+"));
Router::connect('/business-faq-:id-:slug', array('controller' => 'BusinessFaqs', 'action' => 'index', 'type' => 'faqs', 'title' => 'Edit Business Faqs'), array('pass' => array('id'), 'id' => "[0-9]+"));
Router::connect('/business-courses-:id-:slug', array('controller' => 'Businesses', 'action' => 'courses', 'type' => 'courses', 'title' => 'Edit Business Courses'), array('pass' => array('id'), 'id' => "[0-9]+"));
Router::connect('/b-:id-:slug', array('controller' => 'businesses', 'action' => 'view', 'title' => 'Class Details'), array('pass' => array('id', 'slug'), 'id' => "[0-9]+"));
Router::connect('/call-requests', array('controller' => 'reports', 'action' => 'call_requests'));
Router::connect('/my-bookings', array('controller' => 'reports', 'action' => 'my_bookings'));
Router::connect('/booking-requests', array('controller' => 'reports', 'action' => 'bookings'));
Router::connect('/my-reviews', array('controller' => 'business_ratings', 'action' => 'my_reviews'));
Router::connect('/business-reviews', array('controller' => 'business_ratings', 'action' => 'reviews'));

Router::connect('/google_login', array('controller' => 'users', 'action' => 'google_login'));
Router::connect('/choose-subscription', array('controller' => 'subscriptions', 'action' => 'choose_subscription'));
Router::connect('/question-banks', array('controller' => 'QuestionCategories', 'action' => 'index'));
Router::connect('/question-papers/:id/:slag', array("controller" => "questions", "action" => "index"), array('pass' => array('id'), 'id' => "[0-9]+"));
Router::connect('/question-bank-download/:cid/:id/:cat/:file', array("controller" => "questions", "action" => "question_bank_download"), array('pass' => array('id', 'cid', 'slug'), 'id' => "[0-9]+", 'cid' => "[0-9]+"));

/* events */
Router::connect('/create-event', array('controller' => 'events', 'action' => 'add'));
Router::connect('/edit-event-:id', array('controller' => 'events', 'action' => 'edit'), array('pass' => array('id'), 'id' => "[0-9]+"));
Router::connect('/events-list', array('controller' => 'content', 'action' => 'event_list'));
Router::connect('/e-:id-:slug', array('controller' => 'content', 'action' => 'event_view', 'title' => 'Event Details'), array('pass' => array('id', 'slug'), 'id' => "[0-9]+"));
/* custom urls for business */
$requestURI = explode('/', $_SERVER['REQUEST_URI']);
$scriptName = explode('/', $_SERVER['SCRIPT_NAME']);
for ($i = 0; $i < sizeof($scriptName); $i++) {
    if (isset($requestURI[$i]) && isset($scriptName[$i]) && $requestURI[$i] == $scriptName[$i]) {
        unset($requestURI[$i]);
    }
}

$param = array_values($requestURI);
$pagelink = $param[0];
App::uses('Business', 'Model');
$BusinessModel = new Business();
$matchedBusiness = $BusinessModel->find('first', array('conditions' => array('Business.seo_url ' => "$pagelink"), 'fields' => array('id', 'name'), 'recursive' => false, 'contain' => false));
if (is_array($matchedBusiness) && !empty($matchedBusiness)) {
    $id = $matchedBusiness['Business']['id'];
    $name = $BusinessModel->seo_url($matchedBusiness['Business']['name'], '-', 25);
    Router::connect("/{$pagelink}", array('controller' => 'businesses', 'action' => 'view', 'title' => 'Class Details', 'id' => $id, 'slug' => $name), array('pass' => array('id', 'slug'), 'id' => "[0-9]+"));
}
/* end of seo url */
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
