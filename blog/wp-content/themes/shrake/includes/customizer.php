<?php
/**
 * Customizer
 *
 * @package Shrake
 * @since 1.0.0
 */

/**
 * Add postMessage support for site title in the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function shrake_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';

	// Register default theme settings section for other options to hook into.
	$wp_customize->add_section( 'theme_options', array(
		'title'    => esc_html__( 'Theme Options', 'shrake' ),
		'priority' => 120,
	) );
}
add_action( 'customize_register', 'shrake_customize_register' );

/**
 * Enqueue assets to load in the Customizer preview.
 *
 * @since 1.0.0
 */
function shrake_customize_enqueue_assets() {
	wp_enqueue_script(
		'shrake-customize-preview',
		get_template_directory_uri() . '/assets/js/customize-preview.js',
		array( 'customize-preview' ),
		'20141221',
		true
	);
}
add_action( 'customize_preview_init', 'shrake_customize_enqueue_assets' );
