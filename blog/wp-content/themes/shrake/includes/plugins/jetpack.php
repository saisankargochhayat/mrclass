<?php
/**
 * Functions and definitions for the Jetpack plugin.
 *
 * @package Shrake
 * @since 1.0.0
 */

/**
 * Set up Jetpack theme support.
 *
 * Adds support for Infinite Scroll.
 *
 * @since 1.0.0
 */
function shrake_jetpack_setup() {
	// Add support for Infinite Scroll
	add_theme_support( 'infinite-scroll', apply_filters( 'shrake_infinite_scroll_args', array(
		'container' => 'primary',
		'footer'    => 'footer',
		'render'    => 'shrake_jetpack_infinite_scroll_render',
	) ) );
}
add_action( 'after_setup_theme', 'shrake_jetpack_setup' );

/**
 * Filter the JavaScript options for Infinite Scroll.
 *
 * @since 1.0.0
 */
function shrake_jetpack_infinite_scroll_js_settings( $settings ) {
    $settings['text'] = sprintf( '%s <span>+</span>', esc_html__( 'Load More Articles', 'shrake' ) );

    return $settings;
}
add_filter( 'infinite_scroll_js_settings', 'shrake_jetpack_infinite_scroll_js_settings' );


/*
 * Template Tags, Custom Functions, and Callbacks
 * -----------------------------------------------------------------------------
 */

if ( ! function_exists( 'shrake_jetpack_infinite_scroll_render' ) ) :
/**
 * Callback for the Infinite Scroll module in Jetpack to render additional posts.
 *
 * @since 1.0.0
 */
function shrake_jetpack_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'templates/parts/content', get_post_format() );
	}
}
endif;
