<div id="sidebar" class="widget-area" >
	<div class="sidebar-inner">	
	<?php if ( ! dynamic_sidebar( 'sidebar-main' ) ) : ?>

		<div id="search" class="widget widget_search">
			<?php get_search_form(); ?>
		</div>

		<div id="archives" class="widget">
			<h2 class="widget-title"><?php _e( 'Archives', 'dw-wallpress' ); ?></h2>
			<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul>
		</div>
		
		<div id="meta" class="widget">
			<h2 class="widget-title"><?php _e( 'Meta', 'dw-wallpress' ); ?></h2>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</div>
	<?php endif; // end sidebar widget area ?>
		<div id="copyright">
			<?php do_action( 'wallpress_credits' ); ?>
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'dw-wallpress' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'dw-wallpress' ); ?>"><?php printf( __( 'Proudly powered by %s', 'dw-wallpress' ), 'WordPress' ); ?></a>
		</div>
	</div>
</div><!-- #sidebar .widget-area -->