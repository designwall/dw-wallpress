<?php get_header(); ?>

	<div id="container" class="clearfix">

		<div id="content" class="masonry">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

			<?php endwhile; ?>
			
			<?php if ( $wp_query->max_num_pages > 1 ) : ?>
			<div class="navigation">
				<?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'dw-wallpress' ) ); ?>
				<?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'dw-wallpress' ) ); ?>
			</div>
			<a href="#header" class="scroll-top"><?php _e( 'Top', 'dw-wallpress' ); ?></a>
			<?php endif; ?>

		<?php else : ?>

			<div id="post-0" class="post no-results not-found">
				<h1 class="entry-title"><?php _e( 'Nothing Found', 'dw-wallpress' ); ?></h1>
				<div class="entry-content">
					<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'dw-wallpress' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</div><!-- #post-0 -->

		<?php endif; ?>

		</div>
		<!-- #content -->
	</div>
	<!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
