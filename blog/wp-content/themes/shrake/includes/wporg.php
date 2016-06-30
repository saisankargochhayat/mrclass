<?php
/**
 * Functionality specific to self-hosted installations of WordPress, including
 * any plugin support.
 *
 * @package Shrake
 * @since 1.0.0
 */

/**
 * Shrake only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require( get_template_directory() . '/includes/back-compat.php' );
}

/**
 * Enqueue scripts and styles for front-end.
 *
 * @since 1.1.2
 */
function shrake_wporg_enqueue_assets() {
	wp_enqueue_script( 'shrake-fitvids', get_template_directory_uri() . '/assets/js/vendor/jquery.fitvids.js', array( 'jquery' ), '1.1', true );
}
add_action( 'wp_enqueue_scripts', 'shrake_wporg_enqueue_assets' );

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
/**
 * Display the document title tag.
 *
 * Provides backward compatibility for the the new title tag method introduced
 * in WordPress 4.1.
 *
 * @since 1.1.0
 */
function shrake_title_tag() {
	?>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php
}
add_action( 'wp_head', 'shrake_title_tag', 1 );
endif;


/*
 * Plugin support.
 * -----------------------------------------------------------------------------
 */

/**
 * Load Jetpack theme support.
 */
if ( class_exists( 'Jetpack' ) ) {
	include_once( get_template_directory() . '/includes/plugins/jetpack.php' );
}
