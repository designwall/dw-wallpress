<div id="item-<?php the_ID(); ?>" <?php post_class(); ?> >
	<div class="item-inner">
		<?php if( has_post_format('gallery') ) : ?>

			<?php echo wallpress_gallery(); ?>

		<?php else : ?>

			<?php if( has_post_thumbnail() ) : ?>
			<?php $grid = get_post_meta($post->ID, 'grid', true); ?>
			<div class="item-thumbnail">
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'dw-wallpress' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
					<?php
					if($grid == 'double') :
						the_post_thumbnail('medium');
					else :
						the_post_thumbnail('thumbnail');
					endif;
					?>
				<?php if(has_post_format('video')) _e('<span class="video-play">Play</span>', 'dw-wallpress'); ?>
				</a>
				<?php if(has_post_format('image')) : ?>
				<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" class="image-btn zoom" title="<?php printf( esc_attr__( '%s', 'dw-wallpress' ), the_title_attribute( 'echo=0' ) ); ?>" ><?php the_title(); ?></a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			
		<?php endif; ?>

		<?php if(has_post_format('audio')) wallpress_audio_player( get_the_ID() ); ?>

		<div class="item-main">
			<div class="item-header">
				<h2 class="item-title">
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'dw-wallpress' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>

				<div class="item-meta meta-top clearfix">
					<span class="item-author">
						<?php _e( 'By', 'dw-wallpress' );?>
						<?php the_author_posts_link(); ?>
					</span>
					<?php
						$categories_list = get_the_category_list( __( ', ', 'dw-wallpress' ) );
						if ( $categories_list ):
					?>
					<span class="item-category">
						<?php 
							printf( __( '<span class="%1$s">in</span> %2$s', 'dw-wallpress' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
							$show_sep = true; 
						?>
					</span>
					<?php endif; ?>
				</div>
			</div>

			<div class="item-content">
			<?php if ( is_search() ) : ?>
				<?php the_excerpt(); ?>
			<?php else : ?>
				<?php the_content(''); ?>
				<?php wp_link_pages( array( 'before' => '<div class="item-link-pages"><span> ' . __( 'Pages:', 'dw-wallpress' ) . '</span>', 'after' => '</div>' ) ); ?>
			<?php endif; ?>
			</div>

			<div class="item-meta meta-bottom">
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
<!-- #item-<?php the_ID(); ?> -->
