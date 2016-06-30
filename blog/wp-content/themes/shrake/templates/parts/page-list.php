<?php
/**
 * The default template part for displaying content.
 *
 * @package Shrake
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/CreativeWork">
	<div class="entry-inside">
		<header class="entry-header">
			<?php shrake_entry_title( 'show-link' ); ?>
		</header>

		<?php if ( has_excerpt() ) : ?>
			<div class="entry-content" itemprop="text">
				<?php the_excerpt(); ?>
			</div>
		<?php endif; ?>
	</div>
</article>
