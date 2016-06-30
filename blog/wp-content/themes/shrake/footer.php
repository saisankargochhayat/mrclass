<?php
/**
 * The template for displaying the site footer.
 *
 * @package Shrake
 * @since 1.0.0
 */
?>
			<?php do_action( 'shrake_content_bottom' ); ?>

		</div> <!-- .site-content -->

		<?php do_action( 'shrake_content_after' ); ?>

		<footer id="footer" class="site-footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">

			<?php do_action( 'shrake_footer_top' ); ?>

			<?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>

				<div class="widget-area" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
					<div class="block-grid block-grid-3">
						<?php do_action( 'shrake_footer_widgets_top' ); ?>

						<?php dynamic_sidebar( 'footer-widgets' ); ?>

						<?php do_action( 'shrake_footer_widgets_bottom' ); ?>
					</div>
				</div>

			<?php endif; ?>

			<div class="footer-area">
				<?php shrake_social_navigation(); ?>
				<div class="credits">
					<?php shrake_credits(); ?>
				</div>
			</div>

			<?php do_action( 'shrake_footer_bottom' ); ?>

		</footer>

		<?php do_action( 'shrake_after' ); ?>

	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>
