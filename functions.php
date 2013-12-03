<?php
/*-----------------------------------------------------------------------------------*/
/*	Include Jigoshop Functions
/*-----------------------------------------------------------------------------------*/
if ( function_exists('jigoshop_init') ) :
	require_once 'jigoshop/functions.php';
endif;

/*-----------------------------------------------------------------------------------*/
/*	Include Custom Post Type Functions
/*-----------------------------------------------------------------------------------*/
require_once 'inc/post-format.php';

/*-----------------------------------------------------------------------------------*/
/*	Include Widgets Functions
/*-----------------------------------------------------------------------------------*/
require_once 'inc/widgets.php';

/*-----------------------------------------------------------------------------------*/
/* Apply Theme Customize & Apply
/*-----------------------------------------------------------------------------------*/
require_once get_template_directory().'/inc/customize.php';

/*-----------------------------------------------------------------------------------*/
/*	Set the content width based on the theme's design and stylesheet.
/*-----------------------------------------------------------------------------------*/
if ( ! isset( $content_width ) ) $content_width = 620;

/*-----------------------------------------------------------------------------------*/
/*	Editor style
/*-----------------------------------------------------------------------------------*/
function wallpress_editor_styles() {
    add_editor_style();
}
add_action( 'init', 'wallpress_editor_styles' );

/*-----------------------------------------------------------------------------------*/
/*	Add Theme Default Options
/*-----------------------------------------------------------------------------------*/
add_action( 'after_setup_theme', 'wallpress_default_options' );
if ( ! function_exists( 'wallpress_default_options' ) ) :
function wallpress_default_options() {

	load_theme_textdomain( 'dw-wallpress', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );

	register_nav_menu( 'primary', __( 'Primary Menu', 'dw-wallpress' ) );

	add_theme_support( 'post-formats', array( 'gallery', 'link', 'image', 'quote', 'status', 'video', 'chat', 'audio', 'aside' ) );

	if ( is_admin() && isset( $_GET['activated'] ) ) {
		update_option( 'thumbnail_size_w', '300' );
		update_option( 'thumbnail_size_h', '0' );
		update_option( 'medium_size_w', '620' );
		update_option( 'medium_size_h', '0' );
		update_option( 'large_size_w', '940' );
		update_option( 'large_size_h', '0' );
	}

	add_theme_support( 'post-thumbnails' );
}
endif;

/*-----------------------------------------------------------------------------------*/
/*	Theme default excerpt more
/*-----------------------------------------------------------------------------------*/
add_filter( 'excerpt_more', 'wallpress_excerpt_more' );
if ( !function_exists( 'wallpress_excerpt_more' ) ) :
function wallpress_excerpt_more( $more ) {
	global $post;
	return '<a href="'.get_permalink( $post->ID ).'" > ...</a>';
}
endif;

/*-----------------------------------------------------------------------------------*/
/*	Javascript
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'wallpress_script_method' ) ) :
function wallpress_script_method() {
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'wallpress_jquery_masonry', get_template_directory_uri().'/assets/js/jquery.masonry.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'wallpress_jquery_infinite', get_template_directory_uri().'/assets/js/jquery.infinitescroll.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'wallpress_jquery_custom', get_template_directory_uri().'/assets/js/jquery.custom.js', array( 'jquery' ) );
	wp_enqueue_script( 'wallpress_jquery_jcarousel', get_template_directory_uri().'/assets/js/jquery.jcarousel.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'wallpress_jquery_jplayer', get_template_directory_uri().'/assets/js/jquery.jplayer.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'wallpress_jquery_iscroll', get_template_directory_uri().'/assets/js/iscroll.js', array( 'jquery' ) );
	wp_enqueue_script( 'wallpress_jquery_wheel', get_template_directory_uri().'/assets/js/jquery.mousewheel.js', array( 'jquery' ) );
	if ( ! class_exists(jigoshop) ) {
		wp_enqueue_script( 'wallpress_jquery_fancybox', get_template_directory_uri().'/assets/js/jquery.fancybox.pack.js', array( 'jquery' ) );
	}
	if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'wallpress_script_method' );
endif;

/*-----------------------------------------------------------------------------------*/
/*	Register our sidebars and widgetized areas.
/*-----------------------------------------------------------------------------------*/
add_action( 'widgets_init', 'wallpress_widgets_init' );
if ( ! function_exists( 'wallpress_widgets_init' ) ) :
function wallpress_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'dw-wallpress' ),
		'id' => 'sidebar-main',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Secondary Sidebar', 'dw-wallpress' ),
		'id' => 'sidebar-secondary',
		'before_widget' => '<div id="%1$s" class="item widget %2$s"><div class="widget-inner">',
		'after_widget' => "</div></div>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar Shop', 'dw-wallpress' ),
		'id' => 'sidebar-shop',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

}
endif;

/*-----------------------------------------------------------------------------------*/
/* Body Classes
/*-----------------------------------------------------------------------------------*/
function wallpress_filter_wp_title( $title ) {
	// Get the Site Name
	$site_name = get_bloginfo( 'name' );
	// Prepend name
	$filtered_title = $title . $site_name;
	// If site front page, append description
	if ( is_front_page() ) {
		// Get the Site Description
		$site_description = get_bloginfo( 'description' );
		// Append Site Description to title
		$filtered_title.=  " - ".$site_description;
	}
	// Return the modified title
	return $filtered_title;
}
// Hook into 'wp_title'
add_filter( 'wp_title', 'wallpress_filter_wp_title' );


/*-----------------------------------------------------------------------------------*/
/* Body Classes
/*-----------------------------------------------------------------------------------*/
/* Check browser classes ---*/
add_filter( 'body_class', 'wallpress_browser_classes' );
if ( ! function_exists( 'wallpress_browser_classes' ) ) :
function wallpress_browser_classes( $classes ) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome;

	$useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
	
	$is_iphone = preg_match('/iphone/i',$useragent);
	$is_ipad = preg_match('/ipad/i',$useragent);

	if ( $is_lynx ) $classes[] = 'lynx';
	elseif ( $is_gecko ) $classes[] = 'gecko';
	elseif ( $is_opera ) $classes[] = 'opera';
	elseif ( $is_NS4 ) $classes[] = 'ns4';
	elseif ( $is_safari ) $classes[] = 'safari';
	elseif ( $is_chrome ) $classes[] = 'chrome';
	elseif ( $is_IE ) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if ( $is_iphone ) $classes[] = 'iphone';
	if ( $is_ipad ) $classes[] = 'ipad';

	$ie_check = array();
	$ie_classes = array( 'ie7', 'ie8', 'ie9' );
	$version = 7;
	while ( $version < 10 ) {
		$ie_check[] = strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE ' . $version . '.' ) !== FALSE;
		++$version;
	}
	$ie = '';
	foreach ( $ie_check as $key => $value  ) {
		if ( $value == 1 ) {
			$ie = $ie_classes[$key] . ' oldie';
		}
	}
	$classes[] = $ie;

	return $classes;
}
endif;

/* Page Slug Class ---*/
add_filter( 'body_class', 'wallpress_page_slug_class' );
if ( ! function_exists( 'wallpress_page_slug_class' ) ) :
function wallpress_page_slug_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
}
endif;

/*-----------------------------------------------------------------------------------*/
/* Post Classes
/*-----------------------------------------------------------------------------------*/
add_filter( 'post_class', 'wallpress_post_class' );
if ( ! function_exists( 'wallpress_post_class' ) ) :
function wallpress_post_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		if ( is_page_template( 'layout-blog.php' ) ) {
			$classes[] = 'clearfix';
		}
		else {
			$classes[] = 'item clearfix';
		}

		//Item Grid
		if ( get_post_meta( $post->ID, 'grid', true ) ) :
			$classes[] = 'grid-'.get_post_meta( $post->ID, 'grid', true );
		endif;

		//Item Ribbon
		if ( get_post_meta( $post->ID, 'ribbon', true ) ) :
			$classes[] = 'has-ribbon ribbon-'.get_post_meta( $post->ID, 'ribbon', true );
		endif;

		//Has thumbnail
		if ( has_post_thumbnail() ) {
			$classes[]="has-thumbnail";
		}

		//Has new posts
		if ( wallpress_is_new_post( $post->ID ) ) {
			$classes[]="has-ribbon ribbon-new";
		}
	}
	return $classes;
}
endif;
/*-----------------------------------------------------------------------------------*/
/*	Toolbar in header
/*-----------------------------------------------------------------------------------*/
add_action( 'after-navigation' , 'wallpress_toobar' );
if ( ! function_exists( 'wallpress_toobar' ) ) :
function wallpress_toobar() { ?>
	<a href="javascript:void(0);" class="sidebar-control"><?php _e( 'Collabse sidebar', 'dw-wallpress' ); ?></a>
	<a href="javascript:void(0);" class="navigation-control"><?php _e( 'Collabse navigation', 'dw-wallpress' ); ?></a>
	<?php get_search_form(); ?>
<?php }
endif;

/*-----------------------------------------------------------------------------------*/
/*	Pagenavi without any plugin
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'wallpress_pagenavi' ) ) :
function wallpress_pagenavi( $the_query ) {
	global $wp_query, $wp_rewrite;

	//User wordpress function paginate_links to create pagination, see codex.wordpress.org/Function_reference/paginate_links
	if ( $the_query ) $wp_query = $the_query;
	$pages = '';
	$max = $wp_query->max_num_pages;
	if ( !$current = get_query_var( 'paged' ) ) $current = 1;
	$a['base'] = ( $wp_rewrite->using_permalinks() ) ? user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' ) : @add_query_arg( 'paged', '%#%' );
	if ( !empty( $wp_query->query_vars['s'] ) ) $a['add_args'] = array( 's' => get_query_var( 's' ) );
	$a['total'] = $max;
	$a['current'] = $current;

	$total = 0; //1 - display the text "Page N of N", 0 - not display
	
	$a['mid_size'] = 5; //how many links to show on the left and right of the current
	$a['end_size'] = 1; //how many links to show in the beginning and end
	$a['prev_text'] = '&laquo; Previous'; //text of the "Previous page" link
	$a['next_text'] = 'Next &raquo;'; //text of the "Next page" link

	if ( $max > 1 ){
		echo '<div class="pagenav">';
		$pages = '<span class="pages">Page ' . $current . ' of ' . $max . '</span>'."\r\n";
		echo $pages . paginate_links( $a );
		echo '</div>';
	}
}
endif;

/*-----------------------------------------------------------------------------------*/
/*	Post Meta box
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'wallpress_meta_box' ) ) {

	function wallpress_meta_box() {
		$screens = array( 'post');

	    foreach ( $screens as $screen ) {
	        add_meta_box(
	            'wallpress_post_setting',
	            __( 'Post Settings', 'dw-wallpress' ),
	            'wallpress_post_setting_callback',
	            $screen,
	            'side',
	            'default'
	        );
	    }
	}
	add_action( 'add_meta_boxes', 'wallpress_meta_box' );

	if ( ! function_exists( 'wallpress_post_setting_callback' )) {

		function wallpress_post_setting_callback( $post ) {
			// Add an nonce field so we can check for it later.
	  		$grid_value = get_post_meta( $post->ID, 'grid', true );
	  		$ribbon_value = get_post_meta( $post->ID, 'ribbon', true );
	  		?>
	  		
			<table>
				<tr>
					<td>
						<?php _e('<strong>Select Grid</strong>','dw-wallpress') ?>
					</td>
				</tr>
				<tr>
					<td>
						<label>
							<input type="radio" name="wallpress_post_grid_setting" value="single" checked="checked">
							<span><?php _e('Normal','dw-wallpress') ?></span>
						</label>
					</td>
				</tr>

				<tr>
					<td>
						<label>
							<input type="radio" name="wallpress_post_grid_setting" value="double" <?php if ($grid_value == 'double') echo 'checked="checked"'  ?> >
							<span><?php _e('Large','dw-wallpress') ?></span>
						</label>
					</td>
				</tr>

				<tr>
					<td>
						<label>
							<input type="radio" name="wallpress_post_grid_setting" value="triple" <?php if ($grid_value == 'triple') echo 'checked="checked"' ?> >
							<span><?php _e('Extra Large','dw-wallpress') ?></span>
						</label>
					</td>
				</tr>
		
				<tr><td height="10"></td></tr>

				<tr>
					<td>
						<?php _e('<strong>Ribbon</strong>','dw-wallpress') ?>
					</td>
				</tr>

				<tr>
					<td>
						<label>
							<input type="checkbox" name="wallpress_post_ribbon_setting" value="hot" <?php if ($ribbon_value == 'hot') echo 'checked="checked"' ?>>
							<span><?php _e('Hot','dw-wallpress') ?></span>
						</label>
					</td>
				</tr>
			</table>
	  		<?php
		}
	}

	if ( ! function_exists( 'wallpress_post_setting_save_postdata' )) {
		
	
		function wallpress_post_setting_save_postdata( $post_id ) {

			// If this is an autosave, our form has not been submitted, so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

			 // Check the user's permissions.
			if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;

			} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
			}

			/* OK, its safe for us to save the data now. */

			// Grid
			$wallclassic_post_grid_setting_data = $_POST['wallpress_post_grid_setting'];
			update_post_meta( $post_id, 'grid', $wallclassic_post_grid_setting_data );

			// Ribbon
			$wallclassic_post_ribbon_data =  $_POST['wallpress_post_ribbon_setting'];
			update_post_meta( $post_id, 'ribbon', $wallclassic_post_ribbon_data );
		}
		add_action( 'save_post', 'wallpress_post_setting_save_postdata' );
	}
}

/*-----------------------------------------------------------------------------------*/
/* WallPress Comment
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'wall_comment' ) ) :
function wallpress_comment( $comment, $args, $depth ) {
	global $commentnumber;
	$GLOBALS['comment'] = $comment;
	
	switch ( $comment->comment_type ) :

		case 'pingback' :
		case 'trackback' : ?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'dw-wallpress' ); ?> <?php comment_author_link(); ?></p>
			<?php edit_comment_link( __( 'Edit', 'dw-wallpress' ), '<span class="edit-link">', '</span>' ); ?>
		</li>
		<?php break;

		default :
		$commentnumber++; ?>

		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>" class="comment">
				<div class="comment-meta">
					<div class="comment-author vcard">
						<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s %2$s', 'dw-wallpress' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s %2$s', 'dw-wallpress' ), get_comment_date(), get_comment_time() )
							)
						); ?>
					</div><!-- .comment-author .vcard -->

					<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'dw-wallpress' ); ?></em>
					<?php endif; ?>

				</div>

				<div class="comment-content">
					<span class="commentnumber"><?php echo $commentnumber; ?></span>
					<?php comment_text(); ?>
				</div>

				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'dw-wallpress' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->

				<?php edit_comment_link( __( 'Edit', 'dw-wallpress' ), '<span class="edit-link">', '</span>' ); ?>
				
			</div><!-- #comment-## -->

		<?php
		break;
	endswitch;
}
endif;

/*-----------------------------------------------------------------------------------*/
/* Valid search form - Replace valid search form
/* role="search" is an attribute introduced in XHTML draft for accessibility however does not validate.
/*-----------------------------------------------------------------------------------*/
add_filter( 'get_search_form', 'wallpress_valid_search_form' );
if ( ! function_exists( 'wallpress_valid_search_form' ) ) :
function wallpress_valid_search_form( $form ) {
	return str_replace( 'role="search" ', '', $form );
}
endif;

/*-----------------------------------------------------------------------------------*/
/* WallPress Fix Valid W3C ref="category"
/*-----------------------------------------------------------------------------------*/
add_filter( 'the_category', 'wallpress_add_nofollow_cat' );
add_filter( 'wp_list_categories', 'wallpress_add_nofollow_cat' );
if ( ! function_exists( 'wallpress_add_nofollow_cat' ) ) :
function wallpress_add_nofollow_cat( $text ) {
	$text = str_replace( 'rel="category tag"', "", $text );
	$text = str_replace( 'rel="category"', "", $text );
	return $text;
}
endif;

/*-----------------------------------------------------------------------------------*/
/* Get newest post day of each category
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'wallpress_is_new_post' ) ) :
function wallpress_is_new_post( $post_id ) {
	//Get newest point of time of each category, must be newest and lessthan 3 days
	$categories = get_the_category( $post_id );
	foreach ( $categories as $category ) {
		$date = wallpress_newest_post_category( $category->cat_ID );
		$post_date = get_the_time( 'Y-m-d', $post_id );
		//if date of post equal to date of recent post and date difference with current date less than 3 day
		if ( ( strtotime( $post_date ) - strtotime( $date ) >= 0 ) && ( ( strtotime( $post_date ) - time() )/( 60*60*24 ) > -3 ) ) {
			return true;
		}
	}
	return false;
}
endif;

/*-----------------------------------------------------------------------------------*/
/* Get newest post in a categry
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'wallpress_newest_post_category' ) ) :
function wallpress_newest_post_category( $category_id ) {
	$args = array(
		'numberposts' => 1,
		'offset' => 0,
		'category' => $category_id,
		'post_status' => 'publish'
	);
	$posts = get_posts( $args );
	$date = get_the_time( 'Y-m-d', $posts[0]->ID );
	return $date;
}
endif;

/*-----------------------------------------------------------------------------------*/
/* Remove tags
/*-----------------------------------------------------------------------------------*/
add_filter('the_excerpt', 'wallpress_strip_tags');
add_filter('the_content', 'wallpress_strip_tags');
if( !function_exists('wallpress_strip_tags') ) :
function wallpress_strip_tags($text) {
	if( !is_single() & !is_page() ) {
		$text = preg_replace(
		array(
			// Remove invisible content
			'@<iframe[^>]*?>.*?</iframe>@siu',
			'@<embed[^>]*?>.*?</embed>@siu',
			'@<br.*?>@siu'
			),
		array(
		' ', ' '), $text );
		}
	return $text;
}
endif;

// load style for dw qa plugin
if( !function_exists('dwqa_wallpress_scripts') ){
    function dwqa_wallpress_scripts(){
        wp_enqueue_style( 'dw-wallpress-qa', get_stylesheet_directory_uri() . '/dwqa-templates/style.css' );
    }
    add_action( 'wp_enqueue_scripts', 'dwqa_wallpress_scripts' );
}

/*-----------------------------------------------------------------------------------*/
/* TGM plugin activation
/*-----------------------------------------------------------------------------------*/
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
function alx_plugins() {
	$plugins = array(
		array(
			'name' 				=> 'DW Question & Answer',
			'slug' 				=> 'dw-question-answer',
		),
		array(
			'name' 				=> 'Contact Form 7',
			'slug' 				=> 'contact-form-7',
		),
		array(
			'name' 				=> 'DW Shortcodes Bootstrap',
			'slug' 				=> 'dw-shortcodes-bootstrap',
		),
		array(
			'name' 				=> 'Jigoshop',
			'slug' 				=> 'jigoshop',
		)
	);	
	tgmpa( $plugins );
}
add_action( 'tgmpa_register', 'alx_plugins' );