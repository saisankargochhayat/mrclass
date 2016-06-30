<?php
/**
 * Shrake functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package Shrake
 * @since 1.0.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 800; // pixels
}

/**
 * Adjust the content width.
 *
 * @since 1.0.0
 */
function shrake_content_width() {
	global $content_width;

	if ( shrake_is_full_width() ) {
		$content_width = 1280;
	}
}
add_action( 'template_redirect', 'shrake_content_width' );

/**
 * Load helper functions and libraries.
 */
require( get_template_directory() . '/includes/customizer.php' );
require( get_template_directory() . '/includes/hooks.php' );
require( get_template_directory() . '/includes/template-helpers.php' );
require( get_template_directory() . '/includes/template-tags.php' );
include( get_template_directory() . '/includes/vendor/cedaro-theme/autoload.php' );
shrake_theme()->load();

/**
 * Set up theme defaults and registers support for various WordPress features.
 *
 * @since 1.0.0
 */
function shrake_setup() {
	// Add support for translating strings in this theme.
	// @link http://codex.wordpress.org/Function_Reference/load_theme_textdomain
	load_theme_textdomain( 'shrake', get_template_directory() . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array(
		is_rtl() ? 'assets/css/editor-style-rtl.css' : 'assets/css/editor-style.css',
		shrake_fonts_url(),
		shrake_fonts_icon_url(),
	) );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Add support for the title tag.
	// @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	add_theme_support( 'title-tag' );

	// Add support for a logo.
	add_theme_support( 'site-logo', array(
		'size' => 'medium',
	) );

	// Add support for post thumbnails.
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'shrake-featured', 1280, 600, array( 'center', 'top' ) );
	set_post_thumbnail_size( 320, 9999 );

	// Add support for Custom Background functionality.
	add_theme_support( 'custom-background', apply_filters( 'shrake_custom_background_args', array(
		'default-color' => 'ffffff',
	) ) );

	// Add support for HTML5 markup.
	add_theme_support( 'html5', array(
		'caption', 'comment-form', 'comment-list', 'gallery', 'search-form',
	) );

	// Add support for Post Formats.
	add_theme_support( 'post-formats', array(
		'aside', 'link', 'quote',
	) );

	// Add support for page excerpts.
	add_post_type_support( 'page', 'excerpt' );

	// Register default nav menus.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'shrake' ),
		'social'  => esc_html__( 'Social Menu', 'shrake' ),
	) );

	// Register support for archive settings.
	shrake_theme()->archive_content->add_support()->set_full_text_formats( array( 'aside', 'audio', 'link', 'quote', 'status' ) ) ;
}
add_action( 'after_setup_theme', 'shrake_setup' );

/**
 * Set up theme defaults and registers support for various WordPress features.
 *
 * @since 2.0.0
 */
function shrake_setup_page_types() {
	// Add support for page types and get the theme object.
	$page_types = shrake_theme()->page_types->add_support();

	// Register the grid page template.
	$page_types->register(
		'grid',
		array(
			'archive_template' => 'templates/archive-grid.php',
			'single_template'  => 'templates/single-grid.php',
		)
	);

	// Register the list page template.
	$page_types->register(
		'list',
		array(
			'archive_template' => 'templates/archive-list.php',
			'single_template'  => 'templates/single-list.php',
		)
	);
}
add_action( 'after_setup_theme', 'shrake_setup_page_types' );

/**
 * Register widget areas.
 *
 * @since 2.0.0
 */
function shrake_register_widget_areas() {
	register_sidebar( array(
		'id'            => 'footer-widgets',
		'name'          => esc_html__( 'Footer Area', 'shrake' ),
		'description'   => esc_html__( 'Add widgets here to appear at the bottom of every page.', 'shrake' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s block-grid-item">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'shrake_register_widget_areas' );

/**
 * Enqueue scripts and styles for front-end.
 *
 * @since 1.0.0
 */
function shrake_enqueue_assets() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'shrake-fonts', shrake_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', shrake_fonts_icon_url(), array(), '3.3.1' );

	// Load main stylesheet.
	wp_enqueue_style( 'shrake-style', get_stylesheet_uri() );

	// Load RTL stylesheet.
	wp_style_add_data( 'shrake-style', 'rtl', 'replace' );

	// Load theme scripts.
	wp_enqueue_script( 'shrake-header', get_template_directory_uri() . '/assets/js/header.js', array( 'jquery', 'underscore' ), '20141221', true );
	wp_enqueue_script( 'shrake', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery', 'shrake-header' ), '20150224', true );

	// Load script to support comment threading when it's enabled.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'shrake_enqueue_assets' );

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since 1.1.2
 */
function shrake_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'shrake_javascript_detection', 0 );

/**
 * Return the Google font stylesheet URL, if available.
 *
 * The default Google font usage is localized. For languages that use characters
 * not supported by the font, the font can be disabled.
 *
 * @since 1.0.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function shrake_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin';

	/*
	 * translators: If there are characters in your language that are not
	 * supported by these fonts, translate this to 'off'.
	 * Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Arimo: on or off', 'shrake' ) ) {
		$fonts[] = 'Arimo:400,700,400italic,700italic';
	}

	/*
	 * translators: To add a character subset specific to your language,
	 * translate this to 'latin-ext', 'cyrillic', 'greek', or 'vietnamese'.
	 * Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (latin-ext)', 'shrake' );

	if ( 'latin-ext' == $subset ) {
		$subsets .= ',latin-ext';
	}

	if ( $fonts ) {
		$query_args = array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		);

		$fonts_url = esc_url_raw( add_query_arg( $query_args, 'https://fonts.googleapis.com/css' ) );
	}

	return $fonts_url;
}

/**
 * Return the Genericons icon font stylesheet URL
 *
 * @since 1.0.0
 *
 * @return string Font stylesheet.
 */
function shrake_fonts_icon_url() {
	return get_template_directory_uri() . '/assets/css/genericons.css';
}

/**
 * Wrapper for accessing the Cedaro_Theme instance.
 *
 * @since 1.0.0
 *
 * @return Cedaro_Theme
 */
function shrake_theme() {
	static $instance;

	if ( null == $instance ) {
		Cedaro_Theme_Autoloader::register();
		$instance = new Cedaro_Theme( array( 'prefix' => 'shrake' ) );
	}

	return $instance;
}
