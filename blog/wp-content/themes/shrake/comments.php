<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Shrake
 * @since 1.0.0
 */

// If the current post is protected by a password and the visitor has not yet
// entered the password, return early without loading the comments.
if ( post_password_required() ) {
	return;
}

// Don't show comments if commenting is closed and the current post doesn't
// have any comments associated with it.
if ( ! comments_open() && '0' == get_comments_number() ) {
	return;
}

$comments_by_type = $wp_query->comments_by_type;

do_action( 'shrake_comments_before' );
?>
<?php /* ?>
<section id="comments" class="comments-area">

	<?php do_action( 'shrake_comments_top' ); ?>

	<?php if ( have_comments() ) : ?>

		<header class="comments-header">
			<h2 class="comments-title">
				<?php
				printf( _n( '%1$s Comment', '%1$s Comments', count( $comments_by_type['comment'] ), 'shrake' ),
					number_format_i18n( count( $comments_by_type['comment'] ) )
				);
				?>

				<a class="comments-reply-link" href="<?php the_permalink(); ?>#respond" title="<?php esc_attr_e( 'Leave a Reply', 'shrake' ); ?>">+</a>
			</h2>
		</header>

		<?php shrake_comment_navigation(); ?>

		<ol class="comment-list<?php if ( 1 == get_option( 'show_avatars' ) ) { echo ' show-avatars'; } ?>">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 60,
				'max_depth'   => 4,
			) );
			?>
		</ol>

	<?php elseif ( comments_open() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<header class="comments-header">
			<h2 class="comments-title"><?php esc_html_e( 'Leave a Reply', 'shrake' ); ?> <span>+</span></h2>
		</header>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="comment-list no-comments"><?php esc_html_e( 'Comments are closed.', 'shrake' ); ?></p>

	<?php endif; ?>

	<?php
	comment_form( array(
		'comment_notes_after' => false,
	) );
	?>

	<?php do_action( 'shrake_comments_bottom' ); ?>

</section>
<?php */ ?>

<?php
do_action( 'shrake_comments_after' );
