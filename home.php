<?php 

get_header(); 

if ( dw_wall_get_theme_option('cat_select') ) {
	$cat_arr = dw_wall_get_theme_option('cat_select');
	if ($cat_arr[0] != '-1') {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$wp_query = new WP_Query( 'cat='.implode(',', $cat_arr).'&paged=' . $paged );
	}
}
?>
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
				<a href="#header" class="scroll-top"><?php _e( 'Top', 'dw-wallpress' ); ?></a>
			</div>
			<?php endif; ?>

		<?php endif; ?>

		<?php wp_reset_query(); ?>
		</div>
		<!-- #content -->

		
	</div>
	<!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>