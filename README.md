# MrClass 
Online Education Institute Aggregator 
This is a completely implemented web platform to manage local educational institutes and create a structured presentation.

## Tech Stack - 
>Server version: Apache/2.2.15
>OS: Ubuntu 16.04
>PHP: 5.3.3 
>MySql: 5.5.48
>CakePHP: 2.7

## Page wise controller and views
Edit profile: '/edit-profile', 'controller' = 'users', 'view' = 'edit'
Favorites: '/favorites', 'controller' = 'businesses', 'view' = 'favorites'
Sign-up: '/signup', 'controller' = 'users', 'view' = 'sign_up'
Dashboard: '/dashboard', 'controller' = 'users', 'view' = 'dashboard'
Login: '/login', 'controller' = 'users', 'view' = 'login'
Logout: '/logout', 'controller' = 'users', 'view' = 'logout'
Activate: '/activate', 'controller' = 'users', 'view' = 'activate_account'
Forgot password: '/forgot-password', 'controller' = 'users', 'view' = 'forgot_password'
Reset password: '/reset-password/*', 'controller' = 'content', 'view' = 'reset_password', 'title' => 'Reset Password'
Change Password: '/change-password', 'controller' = 'users', 'view' = 'change_password_user'
Recently viewed classes: '/recently-viewed-classes', 'controller' = 'users', 'view' = 'recently_viewed_classes'
Categories: '/categories/*', 'controller' = 'content', 'view' = 'categories'
Category details: '/c-:id-:slug', 'controller' = 'content', 'view' = 'categories'
Press: '/press', 'controller' = 'content', 'view' = 'press'
Feedback: '/feedback', 'controller' = 'content', 'view' = 'feedback'
Contact Us: '/contact-us', 'controller' = 'content', 'view' = 'contact_us'
Looking for a tutor: '/looking-for-a-tutor', 'controller' = 'content', 'view' = 'looking_for_tutor'
Refer a friend: '/refer-a-friend', 'controller' = 'content', 'view' = 'refer_friend'
Search: '/search', 'controller' = 'content', 'view' = 'search'
FAQs: '/faq', 'controller' = 'content', 'view' = 'faq'
Career: '/career', 'controller' = 'content', 'view' = 'careers'
About us: '/about-us', 'controller' = 'content', 'view' = 'static_page', 'about_us'
Terms and Conditions: '/terms-and-conditions', 'controller' = 'content', 'view' = 'static_page', 'terms_and_conditions'
Privacy policy: '/privacy-policy', 'controller' = 'content', 'view' = 'static_page', 'privacy_policy'
Our team: '/our-team', 'controller' = 'content', 'view' = 'static_page', 'the_team'
The platform: '/the-platform', 'controller' = 'content', 'view' = 'static_page', 'the_platform'
Business dashboard: '/business-dashboard', 'controller' = 'businesses', 'view' = 'index'
Create business: '/create-business/*', 'controller' = 'businesses', 'view' = 'add'
Edit business: '/edit-business-:id-:slug', 'controller' = 'businesses', 'view' = 'edit'
Business gallery images: '/business-pics-:id-:slug', 'controller' = 'business_galleries', 'view' = 'add'
Business videos: '/business-videos-:id-:slug', 'controller' = 'business_galleries', 'view' = 'add_video_link'
Business timings: '/business-timing-:id-:slug', 'controller' = 'business_timings', 'view' = 'add'
Business FAQs: '/business-faq-:id-:slug', 'controller' = 'BusinessFaqs', 'view' = 'index'
Business courses: '/business-courses-:id-:slug', 'controller' = 'Businesses', 'view' = 'courses'
Business details: '/b-:id-:slug', 'controller' = 'businesses', 'view' = 'view'
Call requests: '/call-requests', 'controller' = 'reports', 'view' = 'call_requests'
My Bookings: '/my-bookings', 'controller' = 'reports', 'view' = 'my_bookings'
Booking requests: '/booking-requests', 'controller' = 'reports', 'view' = 'bookings'
My reviews: '/my-reviews', 'controller' = 'business_ratings', 'view' = 'my_reviews'
Business reviews: '/business-reviews', 'controller' = 'business_ratings', 'view' = 'reviews'
Google login: '/google_login', 'controller' = 'users', 'view' = 'google_login'
Choose subscription: '/choose-subscription', 'controller' = 'subscriptions', 'view' = 'choose_subscription'
Question banks: '/question-banks', 'controller' = 'QuestionCategories', 'view' = 'index'
Question bank detail: '/question-papers/:id/:slag', 'controller' = "questions", 'view' = "index"
Question bank download url: '/question-bank-download/:cid/:id/:cat/:file', 'controller' = "questions", 'view' = "question_bank_download"
Create event: '/create-event', 'controller' = 'events', 'view' = 'add'
Edit event: '/edit-event-:id', 'controller' = 'events', 'view' = 'edit'
Event list: '/events-list', 'controller' = 'content', 'view' = 'event_list'
Event details: '/e-:id-:slug', 'controller' = 'content', 'view' = 'event_view'

