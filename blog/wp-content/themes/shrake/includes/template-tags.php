<?php
/**
 * Custom template tags for this theme.
 *
 * @package Shrake
 * @since 1.0.0
 */

if ( ! function_exists( 'shrake_site_branding' ) ) :
/**
 * Display the site logo.
 *
 * @since 1.0.0
 */
function shrake_site_branding() {
	// Site logo.
	$output = shrake_theme()->logo->html();

	// Site title.
	$output .= sprintf(
		'<h1 class="site-title"><a href="%1$s" rel="home">%2$s</a></h1>',
		esc_url( home_url( '/' ) ),
		get_bloginfo( 'name', 'display' )
	);

	// Site description.
	$output .= '<p class="site-description screen-reader-text">' . get_bloginfo( 'description', 'display' ) . '</p>';

	echo $output;
}
endif;

if ( ! function_exists( 'shrake_entry_title' ) ) :
/**
 * Display entry title without permalink on singular pages.
 *
 * @since 1.0.0
 *
 * @param $show_link Manual override to display permalink.
 */
function shrake_entry_title( $show_link = '' ) {
	// Prevent odd line breaks with larger text.
	$restore_widont = remove_filter( 'the_title', 'widont' );
	$title = get_the_title();

	if ( $restore_widont ) {
		add_filter( 'the_title', 'widont' );
	}

	if ( ! $title ) {
		return;
	}

	$format = get_post_format();

	if ( ! is_singular() || 'link' == $format ) {
		$show_link = 'show-link';
	}

	if ( 'show-link' == $show_link ) {
		$title = sprintf( '<a class="permalink" href="%1$s" rel="bookmark" itemprop="url">%2$s</a>',
			esc_url( ( 'link' == $format ) ? shrake_get_link_url() : get_the_permalink() ),
			$title
		);
	}

	printf( '<h1 class="entry-title" itemprop="headline">%s</h1>', $title );
}
endif;

if ( ! function_exists( 'shrake_get_entry_date' ) ) :
/**
 * Retrieve HTML with meta information for the current post-date/time.
 *
 * @since 1.0.0
 *
 * @param bool $updated Optional. Whether to print the updated time, too. Defaults to true.
 * @return string
 */
function shrake_get_entry_date( $updated = true ) {
	$time_string = '<time class="entry-time published" datetime="%1$s" itemprop="dateCreated datePublished" pubdate>%2$s</time>';

	// To appease rich snippets, an updated class needs to be defined.
	// Default to the published time if the post has not been updated.
	if ( $updated ) {
		if ( get_the_time( 'U' ) === get_the_modified_time( 'U' ) ) {
			$time_string .= '<time class="entry-time updated" datetime="%1$s">%2$s</time>';
		} else {
			$time_string .= '<time class="entry-time updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';
		}
	}

	return sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
}
endif;

if ( ! function_exists( 'shrake_get_entry_author' ) ) :
/**
 * Retrieve entry author.
 *
 * @since 1.0.0
 *
 * @return string
 */
function shrake_get_entry_author() {
	$html  = '<span class="entry-author author vcard" itemprop="author" itemscope itemtype="http://schema.org/Person">';
	$html .= sprintf(
		'<a class="url fn n" href="%1$s" rel="author" itemprop="url"><span itemprop="name">%2$s</span></a>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);
	$html .= '</span>';

	return $html;
}
endif;

if ( ! function_exists( 'shrake_posted_by' ) ) :
/**
 * Display post author byline.
 *
 * @since 1.0.0
 */
function shrake_posted_by() {
	?>
	<span class="posted-by byline">
		<?php
		/* translators: %s: Author name */
		echo shrake_allowed_tags( sprintf( __( '<span class="sep">by</span> %s', 'shrake' ), shrake_get_entry_author() ) );
		?>
	</span>
	<?php
}
endif;

if ( ! function_exists( 'shrake_posted_on' ) ) :
/**
 * Display post date/time with link.
 *
 * @since 1.0.0
 */
function shrake_posted_on() {
	?>
	<span class="posted-on">
		<?php
		$html = sprintf(
			'<span class="entry-date"><a href="%1$s" rel="bookmark">%2$s</a></span>',
			esc_url( get_the_permalink() ),
			shrake_get_entry_date()
		);

		/* translators: %s: Publish date */
		echo shrake_allowed_tags( sprintf( __( '<span class="sep">on</span> %s', 'shrake' ), $html ) );
		?>
	</span>
	<?php
}
endif;

if ( ! function_exists( 'shrake_entry_terms' ) ) :
/**
 * Display terms for a given taxonomy.
 *
 * @since 1.0.0
 *
 * @param array $taxonomies Optional. List of taxonomy objects with labels.
 */
function shrake_entry_terms( $taxonomies = array() ) {
	if ( ! is_singular() || post_password_required() ) {
		return;
	}

	echo shrake_get_entry_terms( $taxonomies );
}
endif;

if ( ! function_exists( 'shrake_get_entry_terms' ) ) :
/**
 * Retrieve terms for a given taxonomy.
 *
 * @since 1.0.0
 *
 * @param array $taxonomies Optional. List of taxonomy objects with labels.
 * @param int|WP_Post $post Optional. Post ID or object. Defaults to the current post.
 */
function shrake_get_entry_terms( $taxonomies = array(), $post = null ) {
	$default = array(
		'category' => esc_html__( 'Categories:', 'shrake' ),
		'post_tag' => esc_html__( 'Tags:', 'shrake' ),
	);

	// Set default taxonomies if empty or not an array.
	if ( ! $taxonomies || ! is_array( $taxonomies ) ) {
		$taxonomies = $default;
	}

	// Allow plugins and themes to override taxonomies and labels.
	$taxonomies = apply_filters( 'shrake_entry_terms_taxonomies', $taxonomies );

	// Return early if the taxonomies are empty or not an array.
	if ( ! $taxonomies || ! is_array( $taxonomies ) ) {
		return;
	}

	$post   = get_post( $post );
	$output = '';

	// Get object taxonomy list to validate taxonomy later on.
	$object_taxonomies = get_object_taxonomies( get_post_type() );

	// Loop through each taxonomy and set up term list html.
	foreach( (array) $taxonomies as $taxonomy => $label ) {
		// Continue if taxonomy is not in the object taxonomy list.
		if ( ! in_array( $taxonomy, $object_taxonomies ) ) {
			continue;
		}

		// Get term list
		$term_list = get_the_term_list( $post->ID, $taxonomy, '<li>', '</li><li>', '</li>' );

		// Continue if there is not one or more terms in the taxonomy.
		if ( ! $term_list || ! shrake_theme()->template->has_multiple_terms( $taxonomy ) ) {
			continue;
		}

		if ( $label ) {
			$label = sprintf( '<h3 class="term-title">%s</h3>', $label );
		}

		$term_list = sprintf( '<ul class="term-list">%s</ul>', $term_list );

		// Set term list output html.
		$output .= sprintf(
			'<div class="term-group term-group--%1$s">%2$s %3$s</div>',
			esc_attr( $taxonomy ),
			$label,
			$term_list
		);
	}

	// Return if no term lists were created.
	if ( ! $output ) {
		return;
	}

	printf( '<div class="entry-terms">%s</div>', $output );
}
endif;

if ( ! function_exists( 'shrake_has_content' ) ) :
/**
 * Determine if a post has content.
 *
 * @since 1.1.0
 *
 * @param int|WP_Post $post_id Optional. Post ID or WP_Post object. Defaults to the current global post.
 * @return bool
 */
function shrake_has_content( $post_id = null ) {
	$post_id = empty( $post_id ) ? get_the_ID() : $post_id;
	$content = get_post_field( 'post_content', $post_id );

	return empty( $content ) ? false : true;
}
endif;

/**
 * Boolean function to check if page has a full width layout.
 *
 * @since 2.0.0
 */
function shrake_is_full_width() {
	$is_full_width    = false;

	if ( is_page_template( 'templates/full-width.php' ) || is_page_template( 'templates/archive-grid.php' ) ) {
		$is_full_width = true;
	}

	return (bool) apply_filters( 'shrake_is_full_width', $is_full_width );
}

if ( ! function_exists( 'shrake_content_navigation' ) ) :
/**
 * Display navigation to next/previous pages when applicable.
 *
 * @since 1.0.0
 * @uses shrake_post_nav()
 * @uses shrake_paging_nav()
 */
function shrake_content_navigation() {
	if ( is_singular() ) {
		the_post_navigation( array(
			'prev_text' => _x( '<span class="screen-reader-text">Previous Post: %title</span>', 'Previous post link', 'shrake' ),
			'next_text' => _x( '<span class="screen-reader-text">Next Post: %title</span>', 'Next post link', 'shrake' ),
		) );
	} else {
		the_posts_navigation( array(
			'prev_text' => _x( '<span class="screen-reader-text">Previous</span>', 'Previous posts link', 'shrake' ),
			'next_text' => _x( '<span class="screen-reader-text">Next</span>', 'Next posts link', 'shrake' ),
		) );
	}
}
endif;

if ( ! function_exists( 'shrake_comment_navigation' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 *
 * @since 1.0.0
 */
function shrake_comment_navigation() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'shrake' ); ?></h2>
		<div class="nav-links">
			<?php paginate_comments_links(); ?>
		</div>
	</nav>
	<?php
	endif;
}
endif;

if ( ! function_exists( 'shrake_social_navigation' ) ) :
/**
 * Display social navigation menu.
 *
 * @since 1.0.0
 *
 * @param array $args Optional. Default nav menu arguments. Default empty array.
 */
function shrake_social_navigation( $args = array() ) {
	if ( has_nav_menu( 'social' ) ) :
	?>
		<nav class="navigation social-navigation">
			<?php
			$label = '<h2 class="screen-reader-text">' . esc_html__( 'Social Media Profiles', 'shrake' ) . '</h2>';

			$args = wp_parse_args( $args, array(
				'theme_location' => 'social',
				'container'      => false,
				'depth'          => 1,
				'link_before'    => '<span class="screen-reader-text">',
				'link_after'     => '</span>',
				'items_wrap'     => $label . '<ul id="%1$s" class="%2$s">%3$s</ul>'
			) );

			wp_nav_menu( $args );
			?>
		</nav>
	<?php
	endif;
}
endif;

if ( ! function_exists( 'shrake_submenu_navigation' ) ) :
/**
 * Display submenu navigation.
 *
 * @since 2.0.0
 *
 * @see shrake_submenu_limit()
 */
function shrake_submenu_navigation() {
	$button = '<button class="submenu-navigation-toggle">' . esc_html__( 'Submenu', 'shrake' ) . '</button>';

	wp_nav_menu( array(
		'theme_location'   => 'primary',
		'container'        => 'nav',
		'container_class'  => 'navigation submenu-navigation',
		'items_wrap'       => $button . ' <ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'            => 1,
		'fallback_cb'      => false,
		'shrake_submenu'   => true,
	) );
}
endif;

if ( ! function_exists( 'shrake_page_links' ) ) :
/**
 * Wrapper for wp_link_pages() to help keep markup consistent.
 *
 * @since 1.0.0
 *
 * @return string
 */
function shrake_page_links() {
	wp_link_pages( array(
		'before'      => sprintf( '<nav class="page-links" role="navigation"><h2 class="screen-reader-text">%s</h2><div class="nav-links">', esc_html__( 'Page Links', 'shrake' ) ),
		'after'       => '</div></nav>',
		'link_before' => '<span class="page-number">',
		'link_after'  => '</span>',
	) );
}
endif;

if ( ! function_exists( 'shrake_get_image' ) ) :
/**
 * Retrieve the post image.
 *
 * @since 1.0.0
 *
 * @param string|array $size Optional. The size of the image to return. Defaults to large.
 * @param array        $attr Optional. Attributes for the image tag.
 * @param int|WP_Post  $post Optional. Post ID or object. Defaults to the current post.
 * @return string      Image Tag.
 */
function shrake_get_image( $size = 'post-thumbnail', $attr = array(), $post = 0 ) {
	return shrake_theme()->post_media->get_image( $post, $size, $attr );
}
endif;

if ( ! function_exists( 'shrake_get_link_url' ) ) :
/**
 * Return the post URL.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since 1.0.0
 *
 * @return string The Link format URL.
 */
function shrake_get_link_url() {
	return shrake_theme()->post_media->get_link_url();
}
endif;

if ( ! function_exists( 'shrake_block_grid' ) ) :
/**
 * Display block grid media objects.
 *
 * Display posts in a block grid on archive type pages.
 *
 * @since 2.0.0
 *
 * @param array $args List of arguments for modifying the query and display.
 */
function shrake_block_grid( $args = array() ) {
	global $wp_query;

	$args = apply_filters( 'shrake_block_grid_args', wp_parse_args( $args, array(
		'classes' => array(),
		'columns' => 3,
		'loop'    => $wp_query,
	) ) );

	$classes = $args['classes'];
	$columns = $args['columns'];
	$loop    = $args['loop'];

	array_unshift( $classes, 'block-grid' );

	if ( $columns ) {
		$classes[] = 'block-grid-' . $columns;
	}

	do_action( 'shrake_block_grid_before' );
	include( locate_template( 'templates/parts/block-grid.php' ) );
	do_action( 'shrake_block_grid_after' );
	wp_reset_postdata();
}
endif;

/**
 * Return new WP Query object with child pages for a specific page type.
 *
 * @since 2.0.0
 *
 * @param int|WP_Post $post Optional. Post ID or object. Defaults to the current post.
 *
 * @return object WP Query
 */
function shrake_page_type_children_query( $post = 0 ) {
	$post = get_post( $post );

	return new WP_Query( apply_filters( 'shrake_page_type_children_query_args', array(
		'post_type'      => 'page',
		'post_parent'    => $post->ID,
		'posts_per_page' => 999,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	) ) );
}

if ( ! function_exists( 'shrake_primary_nav_menu_fallback_cb' ) ) :
/**
 * Display primary nav menu fallback message.
 *
 * @since 1.0.0
 */
function shrake_primary_nav_menu_fallback_cb() {
	if ( ! current_user_can( 'edit_theme_options' ) || ! is_customize_preview() ) {
		return;
	}
	?>
	<p class="menu-fallback-notice">
		<?php
		printf( '<a class="button button-alt" href="%1$s">%2$s</a>',
			esc_url( admin_url( 'nav-menus.php' ) ),
			__( 'Add Menu', 'shrake' )
		);
		?>
	</p>
	<?php
}
endif;

/**
 * Display body schema markup.
 *
 * @since 1.7.0
 */
function shrake_body_schema() {
	$schema = 'http://schema.org/';
	$type   = 'WebPage';

	if ( is_home() || is_singular( 'post' ) || is_category() || is_tag() ) {
		$type = 'Blog'; // Microdata: http://schema.org/Blog
	} elseif ( is_author() ) {
		$type = 'ProfilePage'; // Microdata: http://schema.org/ProfilePage
	} elseif ( is_search() ) {
		$type = 'SearchResultsPage'; // Microdata: http://schema.org/SearchResultsPage
	}

	$type = apply_filters( 'shrake_body_schema', $type );

	printf(
		'itemscope="itemscope" itemtype="%1$s%2$s"',
		esc_attr( $schema ),
		esc_attr( $type )
	);
}

if ( ! function_exists( 'shrake_allowed_tags' ) ) :
/**
 * Allow only the allowedtags array in a string.
 *
 * @since 1.0.1
 *
 * @link https://www.tollmanz.com/wp-kses-performance/
 *
 * @param  string $string The unsanitized string.
 * @return string         The sanitized string.
 */
function shrake_allowed_tags( $string ) {
	global $allowedtags;

	$theme_tags = array(
		'a'    => array(
			'href'     => true,
			'itemprop' => true,
			'rel'      => true,
			'title'    => true,
		),
		'span' => array(
			'class' => true,
		),
		'time' => array(
			'class'    => true,
			'datetime' => true,
			'itemprop' => true,
		),
	);

	return wp_kses( $string, array_merge( $allowedtags, $theme_tags ) );
}
endif;

if ( ! function_exists( 'shrake_credits' ) ) :
/**
 * Theme credits text.
 *
 * @since 1.0.0
 *
 * @param string $text Text to display.
 * @return string
 */
function shrake_credits() {
	$text = sprintf( esc_html__( '%1$s by Cedaro.', 'shrake' ),
		'<a href="http://www.cedaro.com/wordpress/themes/shrake/">Shrake WordPress theme</a>'
	);

	echo apply_filters( 'shrake_credits', $text );
}
endif;
