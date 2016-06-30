<?php
/**
 * The default template part for displaying search content.
 *
 * @package Shrake
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-inside">
		<header class="entry-header">
			<?php shrake_entry_title(); ?>

			<div class="entry-meta">
				<?php shrake_posted_by(); ?>
				<?php shrake_posted_on(); ?>
			</div>
		</header>

		<div class="entry-content" itemprop="text">
			<?php the_excerpt(); ?>
		</div>
	</div>
</article>
