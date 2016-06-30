<?php
/**
 * The template used for displaying block grid content.
 *
 * Loaded by shrake_block_grid() in includes/template-tags.php.
 *
 * @package Shrake
 * @since 1.0.0
 */
?>

<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

	<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

		<article id="block-grid-item-<?php the_id(); ?>" <?php post_class( 'block-grid-item' ); ?>>
			<?php do_action( 'shrake_block_grid_item_top', get_the_ID() ); ?>

			<?php
			printf( '<a class="block-grid-item-thumbnail" href="%1$s"><span>%2$s</span></a>',
				esc_url( get_the_permalink() ),
				apply_filters( 'shrake_block_grid_item_thumbnail', shrake_get_image(), get_the_ID() )
			);
			?>

			<?php the_title( '<h2 class="block-grid-item-title"><a href="' . esc_url( get_the_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

			<?php
			if ( has_excerpt() ) :
				echo '<div class="block-grid-item-description">' . wpautop( get_the_excerpt() ) . '</div>';
			endif;
			?>

			<?php do_action( 'shrake_block_grid_item_bottom', get_the_ID() ); ?>
		</article>

	<?php endwhile; ?>

</div>
