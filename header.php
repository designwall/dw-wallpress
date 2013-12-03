<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="HandheldFriendly" content="true" />
<meta name="apple-mobile-web-app-capable" content="YES" />
<title><?php wp_title( ' - ', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/assets/css/template.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/assets/css/responsive.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/assets/css/shortcode.css" />

<?php if( ! class_exists( 'jigoshop' )) : ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/assets/css/jquery.fancybox.css" />	
<?php endif; ?>

<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/inc/font-awesome/css/font-awesome.min.css" />
<?php if ( function_exists('jigoshop_init') ) : ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/jigoshop/style.css" />
<?php endif; ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_uri(); ?>" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'before-header' ); ?>
<div id="header" class="main">
	<div id="header-inner" class="clearfix">
		<?php do_action( 'before-navigation' ); ?>
		<div id="navigation">
			<div class="menu-inner">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false ) ); ?>
			 </div>
		</div>
		<?php do_action( 'after-navigation' ); ?>
	</div>
</div>
<!-- #header -->
<?php do_action( 'after-header' ); ?>
<div id="main">
