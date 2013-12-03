<?php 
/*-----------------------------------------------------------------------------------*/
/*	Disable Jigoshop breadcrumb
/*-----------------------------------------------------------------------------------*/
remove_action( 'jigoshop_before_main_content', 'jigoshop_breadcrumb', 20, 0);

/*-----------------------------------------------------------------------------------*/
/*	Add masonry class to Archive shop
/*-----------------------------------------------------------------------------------*/
remove_action( 'jigoshop_before_main_content', 'jigoshop_output_content_wrapper', 10);
add_action('jigoshop_before_main_content', 'wallpress_jigoshop_before_main_content', 10);
// Add new action for control open wrapper
function wallpress_jigoshop_before_main_content(){
	echo '<div id="container" class="clearfix">';

	echo '<div id="content"';
	if( !is_single() ){
		echo ' class="masonry" ';
	}
	echo '>';
}

/*-----------------------------------------------------------------------------------*/
/*	Before shop item
/*-----------------------------------------------------------------------------------*/
remove_action( 'jigoshop_before_shop_loop_item_title', 'jigoshop_template_loop_product_thumbnail', 10, 2);
add_action( 'jigoshop_before_shop_loop_item_title', 'wallpress_template_loop_product_thumbnail', 10, 2);
function wallpress_template_loop_product_thumbnail() {
	if(has_post_thumbnail()) : ?>
	<div class="item-thumbnail"><?php the_post_thumbnail('thumbnail'); ?></div>
	<?php
	endif;
}

add_action( 'jigoshop_after_shop_loop_item', 'wallpress_after_shop_loop_item_1', 9, 2);
function wallpress_after_shop_loop_item_1() {
	echo '<div class="item-actions">';

}

add_action( 'jigoshop_after_shop_loop_item', 'wallpress_after_shop_loop_item_2', 11, 2);
function wallpress_after_shop_loop_item_2() { ?>
	<a data-ajax="false" title="<?php the_title(); ?>" class="button button-white" href="<?php the_permalink(); ?>"><?php _e( 'More Details', 'dw-wallpress' ); ?></a></div>
<?php }

/*-----------------------------------------------------------------------------------*/
/*	Jigoshop Sidebar
/*-----------------------------------------------------------------------------------*/
remove_action( 'jigoshop_sidebar', 'jigoshop_get_sidebar', 10);
add_action( 'jigoshop_sidebar', 'wallpress_get_sidebar_shop', 10);
function wallpress_get_sidebar_shop() {
	get_sidebar('shop');
}

/*-----------------------------------------------------------------------------------*/
/*	Move Jigoshop message to outside container div
/*-----------------------------------------------------------------------------------*/
add_action('wp_head','wallpress_move_message',30);
function wallpress_move_message(){
if(is_post_type_archive('product')||is_tax('product_cat')||is_tax('product_tag') ) :
  remove_action( 'jigoshop_before_shop_loop', 'jigoshop::show_messages', 10);
	add_action( 'jigoshop_before_main_content', 'jigoshop::show_messages', 9);
endif;
}

/*-----------------------------------------------------------------------------------*/
/*	Add div.item-inner to single product
/*-----------------------------------------------------------------------------------*/
add_action( 'jigoshop_before_single_product_summary', 'wallpress_before_item_inner_div' , 10);
function wallpress_before_item_inner_div() {
	echo '<div class="item-inner clearfix">';
}

add_action( 'jigoshop_after_single_product', 'wallpress_after_item_inner_div' , 10);
function wallpress_after_item_inner_div() {
	echo '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*	More related product in jigoshop
/*-----------------------------------------------------------------------------------*/
remove_action('jigoshop_after_single_product_summary',	'jigoshop_output_related_products', 20);
add_action( 'jigoshop_after_single_product_summary', 'wallpress_jigoshop_ouput_related_products' , 20);
if( !function_exists('wallpress_jigoshop_ouput_related_products') ) :
function wallpress_jigoshop_ouput_related_products(){
	if (get_option ('jigoshop_enable_related_products') != 'no')
		// 3 Related Products in 3 columns
		jigoshop_related_products( 3, 3 );
}
endif;

/*-----------------------------------------------------------------------------------*/
/*	Jigoshop Minicart Widget
/*-----------------------------------------------------------------------------------*/
add_action( 'after-navigation' , 'wallpress_jigo_minicart', 20 );
if ( ! function_exists( 'wallpress_jigo_minicart' ) ) :
function wallpress_jigo_minicart() { ?>
<div id="jigo_minicart">
	<a href="#" class="minicart"><i class="fa fa-shopping-cart"></i></a>
	<div class="cartlist">
		<div class="cat-inner">
		<?php $cart_contents = class_exists('jigoshop_cart') ? jigoshop_cart::$cart_contents : ''; ?>
		
        <?php if ( ! empty( $cart_contents ) ) : ?>

			<ul class="cart_list">
		
			<?php foreach ( $cart_contents as $key => $value ) : ?>

			<?php $_product = $value['data']; ?>

			<?php if ( $_product->exists() && $value['quantity'] > 0 ) : ?>
                <li class="clearfix">
                    <a href="<?php echo esc_attr( get_permalink( $_product->id ) ); ?>" title="<?php echo esc_attr( $_product->get_title() ); ?>">
                        <?php echo (has_post_thumbnail( $_product->id ) ) ? get_the_post_thumbnail( $_product->id, 'shop_tiny' ) : jigoshop_get_image_placeholder( 'shop_tiny' ); ?>
                        <h4 class="js_widget_product_title"><?php echo $_product->get_title();?></h4>
                    </a>
                    <div class="js_widget_product_price">
                        <span class="price"><?php echo $_product->get_price_html() ?></span>
                        <?php _e(' &middot; QTY','dw-wallpress')?><?php echo $value['quantity']; ?>
                    </div>
                </li>
			<?php endif; ?>
			<?php endforeach; ?>
			</ul>
			<p class="total">
				<strong><?php _e( ( ( get_option( 'jigoshop_prices_include_tax') == 'yes' ) ? 'Total' : 'Subtotal' ), 'dw-wallpress' ); ?></strong>
				<span class="totalNum"><?php echo jigoshop_cart::get_cart_total(); ?></span>
			</p>
			<?php do_action( 'jigoshop_widget_cart_before_buttons' ); ?>
			<p class="buttons clearfix">
				<a href="<?php echo esc_attr( jigoshop_cart::get_cart_url() ); ?>" class="button">
					<?php _e( 'View Cart &rarr;', 'dw-wallpress' ); ?>
				</a>
				<a href="<?php echo esc_attr( jigoshop_cart::get_checkout_url() ); ?>" class="button checkout">
					<?php _e( 'Checkout &rarr;', 'dw-wallpress' ); ?>
				</a>
			</p>
		<?php else : ?>
			<span class="empty"><?php _e( 'No products in the cart.', 'dw-wallpress' ) ?></span>
		<?php endif; ?>
		</div>
	</div>
</div>
<?php }
endif;


/**
 * 	Override display add-to-cart template of jigoshop 
 */
if (!function_exists('wallpress_jigoshop_template_single_add_to_cart')) {
	function wallpress_jigoshop_template_single_add_to_cart( $post, $_product ) {
		$availability = $_product->get_availability();
		?>
		<?php if( $_product->product_type != 'variable' ){ ?>
		<p class="stock <?php echo $availability['class'] ?>"><?php echo $availability['availability']; ?></p>
		<?php } ?>
		<?php

		if ( $_product->is_in_stock() ) {
			do_action( $_product->product_type . '_add_to_cart' );
		}

	}
	remove_action( 'jigoshop_template_single_summary', 'jigoshop_template_single_add_to_cart', 30, 2 );
	add_action('jigoshop_template_single_summary', 'wallpress_jigoshop_template_single_add_to_cart',30,2);
}



if (!function_exists('wallpress_jigoshop_template_single_price')) {
	function wallpress_jigoshop_template_single_price( $post, $_product ) {
		if( $_product->product_type == 'variable' ) return;
		?><p class="price"><?php echo apply_filters( 'jigoshop_single_product_price', $_product->get_price_html() ); ?></p><?php
	}
	remove_action( 'jigoshop_template_single_summary', 'jigoshop_template_single_price'  , 10, 2);
	add_action( 'jigoshop_template_single_summary', 'wallpress_jigoshop_template_single_price'  , 10, 2);
}
