<?php
/**
 * Template Name: Grid Page
 *
 * @package Shrake
 * @since 2.0.0
 */

get_header();
?>

<main id="primary" class="content-area archive-grid" role="main" itemprop="mainContentOfPage">

	<?php do_action( 'shrake_main_top' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<header class="page-header">
			<?php the_title( '<h1 class="page-title" itemprop="headline">', '</h1>' ); ?>

			<?php if ( shrake_has_content() ) : ?>
				<div class="page-content" itemprop="text">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
		</header>

	<?php endwhile; ?>

	<?php
	$loop = shrake_page_type_children_query();

	if ( $loop->have_posts() ) :
	?>

		<div class="block-grid-content">
			<?php
			shrake_block_grid( array(
				'loop' => $loop,
			) );
			?>
		</div>

		<?php wp_reset_postdata(); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/parts/content-none', 'page-type' ); ?>

	<?php endif; ?>

	<?php do_action( 'shrake_main_bottom' ); ?>

</main>

<?php
get_footer();
