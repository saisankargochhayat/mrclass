<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Shrake
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area" role="main">

	<?php do_action( 'shrake_main_top' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'templates/parts/content', get_post_format() ); ?>

		<?php shrake_page_links(); ?>

		<?php comments_template( '', false ); ?>

		<?php shrake_content_navigation(); ?>

	<?php endwhile; ?>

	<?php do_action( 'shrake_main_bottom' ); ?>

</main>

<?php
get_footer();
