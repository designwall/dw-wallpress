<?php get_header(); ?>
	<div id="container" class="clearfix">

		<div id="content">
		<?php
		$query_args = get_post_meta($post->ID, 'query_args', true);
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$the_query = new WP_Query( $query_args .'&paged=' . $paged ); ?>

		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

			<?php get_template_part( 'content-blog', get_post_format() ); ?>

		<?php endwhile; ?>

		<?php wallpress_pagenavi($the_query); ?>

		<?php if ( $the_query->max_num_pages > 1 ) : ?>
		<div class="navigation">
		<?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'dw-wallpress' ) ); ?>
		<?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'dw-wallpress' ) ); ?>
		</div>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
		</div>
		<!-- #content -->
		
		<?php get_sidebar('secondary'); ?>

	</div>
	<!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>