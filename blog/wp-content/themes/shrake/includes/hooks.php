<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package Shrake
 * @since 1.0.0
 */

/**
 * Register template parts to load throughout the theme.
 *
 * To remove any of these parts, use remove_action() in the
 * "shrake_register_template_parts" hook or later.
 *
 * @since 2.1.0
 */
function shrake_register_template_parts() {
	// Load the featured image for a static posts page.
	if ( ! is_front_page() && is_home() ) {
		add_action( 'shrake_content_top', 'shrake_posts_page_featured_image' );
	}

	// Load the submenu navigation
	add_action( 'shrake_content_top', 'shrake_submenu_navigation' );

	do_action( 'shrake_register_template_parts' );
}
add_action( 'template_redirect', 'shrake_register_template_parts', 9 );

/**
 * Add custom classes to the array of body classes.
 *
 * @since 1.0.0
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function shrake_body_classes( $classes ) {
	if ( is_singular( 'post' ) ) {
		$classes[] = 'layout-side-content';
	}

	if ( shrake_is_full_width() ) {
		$classes[] = 'layout-full';
	}

	if ( is_home() || is_archive() || is_search() || is_page_template( 'templates/archive-list.php' ) ) {
		$classes[] = 'layout-list';
	}

	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return array_unique( $classes );
}
add_filter( 'body_class', 'shrake_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @since 1.0.0
 *
 * @param array $classes Classes for the post element.
 * @return array
 */
function shrake_post_classes( $classes ) {
	$classes[] = shrake_theme()->archive_content->get_mode();

	return array_unique( $classes );
}
add_filter( 'post_class', 'shrake_post_classes' );

/**
 * Add an image itemprop attribute to image attachments.
 *
 * @since 2.3.0
 *
 * @param  array $attr Attributes for the image markup.
 * @return array
 */
function shrake_attachment_image_attributes( $attr ) {
	$attr['itemprop'] = 'image';
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'shrake_attachment_image_attributes' );

/**
 * Replace the excerpt more text with a link.
 *
 * @since 1.0.0
 *
 * @param string $link More link.
 * @return string
 */
function shrake_excerpt_more( $more ) {
	$more = sprintf( '&hellip; <p class="excerpt_read_more"><a class="more-link" href="%1$s">%2$s</a></p>',
		esc_url( get_permalink() ),
		__( 'Read More &#10145;', 'shrake' )
	);

	return $more;
}
add_filter( 'excerpt_more', 'shrake_excerpt_more');

/**
 * Remove the fragment identifer from "read more" links.
 *
 * @since 1.0.0
 *
 * @param string $link More link.
 * @return string
 */
function shrake_remove_more_link_fragment_id( $link ) {
    $link = preg_replace( '|#more-[0-9]+|', '', $link );
    return $link;
}
add_filter( 'the_content_more_link', 'shrake_remove_more_link_fragment_id' );

/**
 * Add author description to archives.
 *
 * @since 1.1.0
 *
 * @return string Archive description.
 */
function shrake_author_archive_description( $content ) {
	if ( is_author() ) {
		$content = wpautop( get_the_author_meta( 'description' ) );
	}

	return $content;
}
add_filter( 'get_the_archive_description', 'shrake_author_archive_description' );

/**
 * Filter a nav menu down to the submenu items of a specified parent.
 *
 * Allows for passing a 'shrake_submenu' arg when using wp_nav_menu() to
 * display a nav menu. The new arg filters the nav menu down to a branch in the
 * menu tree.
 *
 * @since 2.0.0
 *
 * @param array  $items Sorted menu items.
 * @param object $args An object containing wp_nav_menu() arguments.
 * @return array
 */
function shrake_submenu_limit( $items, $args ) {
	if ( empty( $args->shrake_submenu ) ) {
		return $items;
	}

	foreach ( $items as $item ) {
		if ( ! $item->menu_item_parent && ( in_array( 'current-menu-item', $item->classes ) || in_array( 'current-menu-ancestor', $item->classes ) ) ) {
			$current_top = $item;
			break;
		}
	}

	if ( empty( $current_top ) ) {
		return array();
	}

	$children = _shrake_submenu_get_child_ids( $current_top->ID, $items );

	foreach ( $items as $key => $item ) {
		if ( ! in_array( $item->ID, $children ) ) {
			unset( $items[ $key ] );
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'shrake_submenu_limit', 15, 2 );

/**
 * Get a menu item's children IDs.
 *
 * @since 2.0.0
 *
 * @param int $id Parent menu item ID.
 * @param array $items Menu items.
 * @return array
 */
function _shrake_submenu_get_child_ids( $id, $items ) {
	$ids = wp_filter_object_list( $items, array( 'menu_item_parent' => $id ), 'AND', 'ID' );

	foreach ( $ids as $id ) {
		$ids = array_merge( $ids, _shrake_submenu_get_child_ids( $id, $items ) );
	}

	return $ids;
}
