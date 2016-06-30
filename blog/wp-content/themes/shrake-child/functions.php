<?php
function theme_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css?ref='.time());
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css?ref='.time(), array( $parent_style ));
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function shrake_register_widget_areas2() {
	register_sidebar( array(
		'id'            => 'sidebar-widgets',
		'name'          => esc_html__( 'Sidebar Area', 'shrake' ),
		'description'   => esc_html__( 'Add widgets here to appear at the bottom of every page.', 'shrake' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s block-grid-item">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'shrake_register_widget_areas2' );
?>
