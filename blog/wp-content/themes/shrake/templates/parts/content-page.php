<?php
/**
 * The template used for displaying content in page.php.
 *
 * @package Shrake
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/CreativeWork">

	<div class="entry-inside">

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="entry-image">
				<?php the_post_thumbnail( 'shrake-featured', array( 'itemprop' => 'image' ) ); ?>
			</figure>
		<?php endif; ?>

		<header class="entry-header">
			<?php shrake_entry_title(); ?>
		</header>

		<div class="entry-content" itemprop="text">
			<?php the_content(); ?>
		</div>

	</div>

</article>
