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
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'dw-wallpress-before-header' ); ?>
<div id="header" class="main">
	<div id="header-inner" class="clearfix">
		<?php do_action( 'dw-wallpress-before-navigation' ); ?>
		<div id="navigation">
			<div class="menu-inner">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false ) ); ?>
			 </div>
		</div>
		<?php do_action( 'dw-wallpress-after-navigation' ); ?>
	</div>
</div>
<!-- #header -->
<?php do_action( 'dw-wallpress-after-header' ); ?>
<div id="main">
