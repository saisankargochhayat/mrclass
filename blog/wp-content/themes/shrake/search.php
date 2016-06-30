<?php
/**
 * The template for displaying search results.
 *
 * @package Shrake
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area" role="main" itemprop="mainContentOfPage">

	<?php do_action( 'shrake_main_top' ); ?>

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'shrake' ), get_search_query() ); ?></h1>
		</header>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'templates/parts/content', 'search' ); ?>

		<?php endwhile; ?>

		<?php shrake_content_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/parts/content-none', 'search' ); ?>

	<?php endif; ?>

	<?php do_action( 'shrake_main_bottom' ); ?>

</main>

<?php
get_footer();
