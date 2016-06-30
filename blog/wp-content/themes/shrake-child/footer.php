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
				
<div class="wrap_cust">
<ul>
<li><a target="_blank" href="http://mrclass.in/terms-and-conditions">Terms &amp; Conditions</a></li>
<li><a target="_blank" href="http://mrclass.in/privacy-policy">Privacy Policy</a></li>
<li><a target="_blank" href="http://mrclass.in/our-team">Our Team</a></li>
<li><a target="_blank" href="http://mrclass.in/about-us">About Us</a></li>
<li><a target="_blank" href="http://mrclass.in/career">Career</a></li>
<li><a target="_blank" href="http://mrclass.in/press">Press</a></li>
<li><a target="_blank" href="http://mrclass.in/feedback">Feedback</a></li>
<li><a target="_blank" href="http://mrclass.in/contact-us">Contact Us</a></li>
<li><a target="_blank" href="http://mrclass.in/looking-for-a-tutor">Looking for a Tutor</a></li>
</ul>
</div>
				<div class="footer_credit">
				<div class="credits">
					<?php //shrake_credits(); ?>
					&copy; 2016 Mr Class. All rights reserved.
				</div>
				<div class="dev-by">Developed &amp; Maintained by <a href="http://www.andolasoft.com/" target="_blank">Andolasoft</a></div>
				</div>
			</div>

			<?php do_action( 'shrake_footer_bottom' ); ?>

		</footer>

		<?php do_action( 'shrake_after' ); ?>

	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>
