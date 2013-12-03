<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'dw-wallpress' ); ?></p>
	</div><!-- #comments -->
	<?php
			return;
		endif;
	?>

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 id="comments-title">
			<?php
				printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'dw-wallpress' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<div id="comment-nav-above">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'dw-wallpress' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'dw-wallpress' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'dw-wallpress' ) ); ?></div>
		</div>
		<?php endif; // check for comment navigation ?>

		<ol class="commentlist">
			<?php
				wp_list_comments( array( 'callback' => 'wallpress_comment' ) );
				$commentnumber = 0;
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<div id="comment-nav-below">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'dw-wallpress' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'dw-wallpress' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'dw-wallpress' ) ); ?></div>
		</div>
		<?php endif; // check for comment navigation ?>

	<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'dw-wallpress' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments -->
