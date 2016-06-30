<?php
/**
 * The template for displaying 404 (Not Found) pages.
 *
 * @package Shrake
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area" role="main" itemprop="mainContentOfPage">

	<?php do_action( 'shrake_main_top' ); ?>

	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'shrake' ); ?></h1>
		</header>

		<div class="page-content">
			<p>
				<?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'shrake' ); ?>
			</p>

			<?php get_search_form(); ?>
		</div>
	</section>

	<?php do_action( 'shrake_main_bottom' ); ?>

</main>

<?php
get_footer();
