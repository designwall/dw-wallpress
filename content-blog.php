<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-inner">

		<?php if( ! has_post_format( 'audio' ) ) : ?>
		<div class="post-thumbnail">
		<?php if( has_post_format( 'gallery' ) ) : ?>
			<?php echo wallpress_gallery(); ?>
		<?php else : ?>
			<?php if( has_post_thumbnail() && !has_post_format('video') ) the_post_thumbnail(); ?>
		<?php endif; ?>

		<?php if( has_post_format('image') ) : ?>
				<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" class="image-btn zoom" title="<?php printf( esc_attr__( '%s', 'dw-wallpress' ), the_title_attribute( 'echo=0' ) ); ?>" ><?php the_title(); ?></a>
		<?php endif; ?>
		</div>
		<?php endif; ?>

		<div class="post-main">
			<h2 class="post-title">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'dw-wallpress' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>

			<div class="post-meta meta-top clearfix">
				<span class="item-author">
					<?php _e( 'By', 'dw-wallpress' );?>
					<?php the_author_posts_link(); ?>
				</span>
				<?php
					$categories_list = get_the_category_list( __( ', ', 'dw-wallpress' ) );
					if ( $categories_list ):
				?>
				<span class="item-category">
					<?php printf( __( '<span class="%1$s">in</span> %2$s', 'dw-wallpress' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
						$show_sep = true; 
					?>
				</span>
				<?php endif; ?>

				<span class="item-date">
					<?php _e( 'on', 'dw-wallpress' ); ?>
					<?php the_time( get_option('date_format') ); ?>
				</span>
			</div>

			<?php if( has_post_format( 'audio' ) ) : ?>
			<div class="post-thumbnail">
				<?php if( has_post_thumbnail() ) the_post_thumbnail(); ?>
			</div>
			<?php wallpress_audio_player( get_the_ID() ); ?>
			<?php endif ?>

			<div class="post-content">
				<?php if ( is_search() ) : ?>
					<?php the_excerpt(); ?>
				<?php else : ?>
					<?php
						global $more;
						$more = 0;
						the_content( '' );
					?>
					<?php wp_link_pages( array( 'before' => '<div class="item-link-pages"><span> ' . __( 'Pages:', 'dw-wallpress' ) . '</span>', 'after' => '</div>' ) ); ?>
				<?php endif; ?>
			</div>

			<div class="post-meta meta-bottom clear">
				<?php $tags_list = get_the_tag_list( '', __( ', ', 'nex' ) ); ?>
				<?php if ( $tags_list ): ?>

				<span class="tags"><?php printf( __( '<span class="%1$s">Tagged:</span> %2$s', 'nex' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?></span>
				<?php endif; ?>

				<?php $show_sep = true; ?>
				<span class="item-permalink">
					<a title="<?php the_title(); ?>" href="<?php echo get_permalink(); ?>"><?php _e( 'Read more', 'dw-wallpress' ); ?></a>
				</span>
				<?php if ( $show_sep ) : ?>
				<span class="sep"> &bull; </span>
				<?php endif; // End if $show_sep ?>
				<span class="comments-link">
					<?php comments_popup_link( '<span class="leave-reply">' . __( '0 comment', 'dw-wallpress' ) . '</span>', __( '<b>1</b> comment', 'dw-wallpress' ), __( '<b>%</b> comments', 'dw-wallpress' ) ); ?>
				</span>
				<?php edit_post_link( __( 'Edit', 'dw-wallpress' ), '<span class="sep"> &bull; </span><span class="edit-link">', '</span>' ); ?>
			</div>
		</div>
		
    </div>
</div>
<!-- #post-<?php the_ID(); ?> -->
