<?php get_header(); ?>
	<?php get_sidebar('shop'); ?>

	<div id="container" class="clearfix">

		<div id="content" class="masonry">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php the_content( '' ); ?>

		<?php endwhile; ?>

		</div>
		<!-- #content -->
	</div>
	<!-- #container -->
<?php get_footer(); ?>