<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shrake
 * @since 1.0.0
 */

get_header();
?>
<div id="home-main">
<main id="primary" class="content-area" role="main">

	<?php do_action( 'shrake_main_top' ); ?>


	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'templates/parts/content', get_post_format() ); ?>

		<?php endwhile; ?>

		<?php //shrake_content_navigation(); ?>
		<?php wp_pagenavi(); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/parts/content', 'none' ); ?>

	<?php endif; ?>

	<?php do_action( 'shrake_main_bottom' ); ?>

</main>
<?php if ( is_active_sidebar( 'sidebar-widgets' ) ) : ?>
<div id="sidebar">
<?php dynamic_sidebar( 'sidebar-widgets' ); ?>
</div>
<?php endif; ?>
</div>
<div class="clear10"></div>
<?php
get_footer();
