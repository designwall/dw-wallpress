<?php
global $columns, $per_page;

do_action('jigoshop_before_shop_loop');

$loop = 0;

if (!isset($columns) || !$columns) $columns = apply_filters('loop_shop_columns', 4);

ob_start();

if ( ! have_posts() ) { wp_reset_query(); }
if (have_posts()) : while (have_posts()) : the_post(); $_product = new jigoshop_product( $post->ID ); $loop++;

	?>
	<div class="item product 
			<?php if(  get_post_meta(get_the_ID(), 'featured', true) ) { echo 'featured has-ribbon'; } ?> <?php if ($loop%$columns==0) echo 'last'; if (($loop-1)%$columns==0) echo 'first'; ?>">
		<div class="item-inner">

		<?php do_action('jigoshop_before_shop_loop_item'); ?>

		<?php do_action('jigoshop_before_shop_loop_item_title', $post, $_product); ?>

		<h2 class="item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

		<?php do_action('jigoshop_after_shop_loop_item_title', $post, $_product); ?>

		<?php do_action('jigoshop_after_shop_loop_item', $post, $_product); ?>

		</div>

	</div><?php

	if ($loop==$per_page) break;

endwhile; endif;

if ($loop==0) :

	echo '<p class="info">'.__('No products found which match your selection.', 'jigoshop').'</p>';

else :

	$found_posts = ob_get_clean();

	echo $found_posts;

endif;

do_action('jigoshop_after_shop_loop');
