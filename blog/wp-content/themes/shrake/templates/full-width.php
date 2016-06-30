<?php
/**
 * Template Name: Full Width
 *
 * @package Shrake
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area full-width" role="main" itemprop="mainContentOfPage">

	<?php do_action( 'shrake_main_top' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'templates/parts/content', 'page' ); ?>

		<?php shrake_page_links(); ?>

		<?php comments_template( '', true ); ?>

	<?php endwhile; ?>

	<?php do_action( 'shrake_main_bottom' ); ?>

</main>

<?php
get_footer();
