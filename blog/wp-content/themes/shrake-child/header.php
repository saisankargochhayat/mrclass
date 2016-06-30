<?php
/**
 * The header for our theme.
 *
 * @package Shrake
 * @since 1.0.0
 */
?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php shrake_body_schema(); ?>>
	<div id="page" class="hfeed site">

		<?php do_action( 'shrake_before' ); ?>

		<header id="masthead" class="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
			<div class="header-area">

				<?php do_action( 'shrake_header_top' ); ?>

				<div class="site-branding">
					<?php shrake_site_branding(); ?>
				</div>

				<nav class="site-navigation drop_down" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
					<h2 class="screen-reader-text"><?php esc_html_e( 'Main Menu', 'shrake' ); ?></h2>

					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'menu',
						'fallback_cb'    => 'shrake_primary_nav_menu_fallback_cb',
						'depth'          => 1,
						'link_before'    => '<span>',
						'link_after'     => '</span>',
						'items_wrap'     => sprintf(
							'<button class="site-navigation-toggle"><span class="screen-reader-text">%1$s</span></button> <ul id="%%1$s" class="%%2$s">%%3$s</ul>',
							__( 'Menu', 'shrake' )
						),
					) );
					?>
				</nav>
<!-- custom code -->
<div class="fr rt_head">
				<div class="con_social fl">
					<ul>
						<li><span class="top_ph_num"><b>(0674) 694 1111</b></span></li>
						<li class="info_li"><a href="mailto:info@mrclass.in"><b>info@mrclass.in</b></a></li>
					</ul>
					<div class="cb"></div>
				</div>
				<div class="top_log_reg fr">
					<ul>
						<li><a href="/signup">Sign Up</a></li>
						<li class="btn_top"><a href="/login">Sign In</a></li>
					</ul>
					<div class="cb"></div>
				</div>
				<div class="cb"></div>
			</div>
			<div class='selectnav_button'><span>&nbsp;</span></div>
			<nav class="selectnav topmenublock"></nav>
<!-- custom code -->
				<?php do_action( 'shrake_header_bottom' ); ?>

			</div>
		</header>

		<?php do_action( 'shrake_content_before' ); ?>
		<div id="content" class="site-content">
		<?php if(is_home() || is_front_page()){ ?>
		<header class="page-header home"><!--<h1 class="page-title" itemprop="headline">Our Blog</h1>--><h1 class="home_title" itemprop="headline">Our Blog</h1></header>
        <?php } ?>
			<?php do_action( 'shrake_content_top' ); ?>