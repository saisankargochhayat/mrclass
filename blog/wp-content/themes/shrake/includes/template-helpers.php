<?php
/**
 * Helper methods for loading or displaying template partials.
 *
 * These are typically miscellaneous template parts used outside the loop.
 * Although if the partial requires any sort of set up or tearddown, moving that
 * logic into a helper keeps the parent template a little more lean, clean,
 * reusable and easier to override in child themes.
 *
 * Loading these partials within an action hook will allow them to be easily
 * added, removed, or reordered without changing the parent template file.
 *
 * Take a look at shrake_register_template_parts() to see where most of these
 * are inserted.
 *
 * This approach tries to blend the two common approaches to theme development
 * (hooks or partials).
 *
 * @package Shrake
 * @since 2.3.0
 */

if ( ! function_exists( 'shrake_posts_page_featured_image' ) ) :
/**
 * Display the featured image the static posts page.
 *
 * @since 2.3.0
 */
function shrake_posts_page_featured_image() {
	if ( 'page' !== get_option( 'show_on_front' ) ) {
		return;
	}

	$post_id = get_option( 'page_for_posts' );

	if ( has_post_thumbnail( $post_id ) && ! is_paged() ) :
	?>
		<figure class="entry-image">
			<?php echo get_the_post_thumbnail( $post_id, 'shrake-featured', array( 'itemprop' => 'image' ) ); ?>
		</figure>
	<?php
	endif;
}
endif;
