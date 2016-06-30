<?php
/**
 * The template part for displaying a message that child pages cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shrake
 * @since 2.0.0
 */

if ( current_user_can( 'publish_posts' ) ) :
?>

	<div class="no-results not-found">
		<p>
			<?php
			_ex( 'There currently are not any items available.', 'list page', 'shrake' );

			// translators: there is a space at the begining of this sentence.
			printf(
				_x( ' Create a <a href="%1$s">new page</a> with this page as its <a href="%2$s">parent</a>.', 'list page label; create page link', 'shrake' ),
				esc_url( add_query_arg( 'post_type', 'page', admin_url( 'post-new.php' ) ) ),
				esc_url( 'http://en.support.wordpress.com/pages/page-attributes/#parent' )
			);
			?>
		</p>
	</div>

<?php
endif;
