<div id="item-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="item-inner">
		<div class="item-main">
			<h1 class="item-title"><?php the_title(); ?></h1>

			<div class="item-content">
				<?php the_content( '' ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="item-link-pages"><span> ' . __( 'Pages:', 'dw-wallpress' ) . '</span>', 'after' => '</div>' ) ); ?>
			</div>

			<?php comments_template( '', true ); ?>
		</div>
    </div>
</div>
<!-- #item-<?php the_ID(); ?> -->
