<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shrake
 * @since 1.0.0
 */
?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'shrake' ); ?></h1>
	</header>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
				<?php echo shrake_allowed_tags( sprintf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'shrake' ), esc_url( admin_url( 'post-new.php' ) ) ) ); ?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p>
				<?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'shrake' ); ?>
			</p>

			<?php get_search_form(); ?>

		<?php else : ?>

			<p>
				<?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'shrake' ); ?>
			</p>

			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>
</section>
