<?php
// -----------------------------------------------------------------------------------
// Customize variable
// -----------------------------------------------------------------------------------
global $dw_current_theme, $dw_colors;
$dw_current_theme = wp_get_theme();
$dw_colors = array('#2985e8','#ef4135', '#7cc576', '#B39964', '#e07798');

if ($dw_current_theme == 'DW WallDark') {
    $dw_colors = array('#DE3068','#ef4135', '#7cc576', '#B39964', '#2985e8');
}

if ($dw_current_theme == 'DW WallPin') {
    $dw_colors = array('#CB2027','#2985e8', '#7cc576', '#B39964', '#e07798');
}

if ($dw_current_theme == 'DW WallChristmas') {
    $dw_colors = array('#AE2F27','#2985e8', '#7cc576', '#B39964', '#e07798');
}


// -----------------------------------------------------------------------------------
// Add Customize Control
// -----------------------------------------------------------------------------------
include_once ABSPATH . 'wp-includes/class-wp-customize-control.php';

class dw_wall_Textarea_Custom_Control extends WP_Customize_Control {

    public $type = 'textarea';
    public $statuses;
    public function __construct( $manager, $id, $args = array() ) {

    $this->statuses = array( '' => __( 'Default', 'dw-wallpress' ) );
    parent::__construct( $manager, $id, $args );
    }

    public function render_content() {
    ?>
    <label>
        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <textarea class="large-text" cols="20" rows="5" <?php $this->link(); ?>>
            <?php echo esc_textarea( $this->value() ); ?>
        </textarea>
    </label>
    <?php
    }
}

class Color_Picker_Custom_control extends WP_Customize_Control {

    public function render_content() {

    if ( empty( $this->choices ) ) return;
    $name = '_customize-radio-' . $this->id; ?>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <table style="margin-top: 10px; text-align: center; width: 100%;">
        <tr>
            <?php foreach ( $this->choices as $value => $label ) { ?>
            <?php 
                $checked = '';
                if($value == 0) { $checked = 'checked'; } 
            ?>

            <td>
                <label>
                    <div style="width: 30px; height: 30px; margin: 0 auto; background: <?php echo esc_attr( $label )?> "></div><br />
                    <?php if ($value == 0) { $label = ''; } ?>
                    <input type="radio" value="<?php echo esc_attr( $label ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); echo $checked ?> />
                </label>
            </td>
            <?php } ?>
        </tr>
    </table><?php

    }
}

class WP_Cats_Select_Control extends WP_Customize_Control {
    public function render_content() {
    $cats = get_categories();
    ?>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <select multiple style="height: auto" <?php echo $this->get_link() ?> >
        <option value="-1" selected><?php _e('All Categories','dw-wallpress') ?></option>
        <?php foreach ($cats as $key => $value) { ?>
        <option value="<?php echo  esc_attr( $value->term_id ); ?>"><?php echo esc_html($value->name) ?></option>
        <?php } ?>
    </select>
    <?php
    }
}

// -----------------------------------------------------------------------------------
// Customize register
// -----------------------------------------------------------------------------------
function dw_wall_customize_register( $wp_customize ) {
    global $dw_colors;

    // Site tile & Tagline
    // ---------------------------
    $wp_customize->add_setting('dw_wall_theme_options[logo]', array(
        'default' => get_stylesheet_directory_uri().'/assets/images/logo.png',
        'capability' => 'edit_theme_options',
        'type' => 'option',
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'logo', array(
        'label' => __('Site Logo', 'dw-wallpress'),
        'section' => 'title_tagline',
        'settings' => 'dw_wall_theme_options[logo]',
    )));

    $wp_customize->add_setting('dw_wall_theme_options[header_display]', array(
        'default'        => 'site_title',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));

    $wp_customize->add_control( 'header_display', array(
        'settings' => 'dw_wall_theme_options[header_display]',
        'label'   => 'Display as',
        'section' => 'title_tagline',
        'type'    => 'select',
        'choices'    => array(
            'site_title' => 'Site Title',
            'site_logo' => 'Site Logo',
        ),
    ));

    $wp_customize->add_setting('dw_wall_theme_options[favicon]', array(
        'capability' => 'edit_theme_options',
        'type' => 'option',
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'favicon', array(
        'label' => __('Site Favicon', 'dw-wallpress'),
        'section' => 'title_tagline',
        'settings' => 'dw_wall_theme_options[favicon]',
    )));

    // Style slector
    // ---------------------------  
    $wp_customize->add_section('dw_wall_primary_color', array(
        'title'    => __('Style Selector', 'dw-wallpress'),
        'priority' => 110,
    ));

    $wp_customize->add_setting('dw_wall_theme_options[select-color]', array(
        'capability' => 'edit_theme_options',
        'type' => 'option',
    ));

    $wp_customize->add_control( new Color_Picker_Custom_control($wp_customize, 'select-color', array(
        'label' => __('Color Schemes', 'dw-wallpress'),
        'section' => 'dw_wall_primary_color',
        'settings' => 'dw_wall_theme_options[select-color]',
        'choices' => $dw_colors
    )));

    $wp_customize->add_setting('dw_wall_theme_options[custom-color]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option'
    ));

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'custom-color', array(
        'label'        => __( 'Custom Color', 'dw-wallpress' ),
        'section'    => 'dw_wall_primary_color',
        'settings'   => 'dw_wall_theme_options[custom-color]',
    )));

    // Font selector
    // ---------------------------
    $fonts = dw_get_gfonts();
    $newarray = array();
    $newarray[] = '';
    foreach ($fonts as $index => $font) {
    foreach ($font->files as $key => $value) {
        $newarray[$font->family . ':dw:' . $value ] = $font->family . ' - ' . $key;
    }
    }
    $wp_customize->add_section('dw_wall_typo', array(
        'title'    => __('Font Selector', 'dw-wallpress'),
        'priority' => 111,
    ));

    $wp_customize->add_setting('dw_wall_theme_options[heading_font]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));

    $wp_customize->add_control( 'heading_font', array(
        'settings' => 'dw_wall_theme_options[heading_font]',
        'label'   => 'Select headding font',
        'section' => 'dw_wall_typo',
        'type'    => 'select',
        'choices'    => $newarray
    ));

    $wp_customize->add_setting('dw_wall_theme_options[body_font]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));

    $wp_customize->add_control( 'body_font', array(
        'settings' => 'dw_wall_theme_options[body_font]',
        'label'   => 'Select body font',
        'section' => 'dw_wall_typo',
        'type'    => 'select',
        'choices'    => $newarray
    ));

    // Category select
    // ---------------------------
    $wp_customize->add_setting('dw_wall_theme_options[cat_select]', array(
        'capability' => 'edit_theme_options',
        'type'    => 'option',
    ));

    $wp_customize->add_control( new WP_Cats_Select_Control($wp_customize, 'cat_select', array(
        'label'  => __('Static categories','dw-wallpress'),
        'section'  => 'static_front_page',
        'settings' => 'dw_wall_theme_options[cat_select]',
    )));

    // Custom code
    // ---------------------------
    $wp_customize->add_section('dw_wall_custom_code', array(
        'title'    => __('Custom Code', 'dw-wallpress'),
        'priority' => 200,
    ));

    $wp_customize->add_setting('dw_wall_theme_options[header_code]', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
    ));

    $wp_customize->add_control( new dw_wall_Textarea_Custom_Control($wp_customize, 'header_code', array(
        'label'    => __('Header Code (Meta tags, CSS, etc ...)', 'dw-wallpress'),
        'section'  => 'dw_wall_custom_code',
        'settings' => 'dw_wall_theme_options[header_code]',
    )));

    $wp_customize->add_setting('dw_wall_theme_options[footer_code]', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
    ));

    $wp_customize->add_control( new dw_wall_Textarea_Custom_Control($wp_customize, 'footer_code', array(
        'label'    => __('Footer Code', 'dw-wallpress'),
        'section'  => 'dw_wall_custom_code',
        'settings' => 'dw_wall_theme_options[footer_code]'
    )));
}
add_action( 'customize_register', 'dw_wall_customize_register' );


// -----------------------------------------------------------------------------------
//  Customize Function
// -----------------------------------------------------------------------------------

// Get options
// --------------------
function dw_wall_get_theme_option( $option_name, $default = '' ) {
    $options = get_option( 'dw_wall_theme_options' );
    if( $options[$option_name] != '' ) {
        return $options[$option_name];
    }
    return $default; 
}

// Display Logo
// --------------------
function dw_wall_logo() {
    $header_display = (dw_wall_get_theme_option( 'header_display', 'site_title') == 'site_title') ? 'display-title' : 'display-logo';
    $logo = dw_wall_get_theme_option( 'logo', get_stylesheet_directory_uri().'/assets/images/logo.png' );
    $tagline = get_bloginfo( 'description' );
    echo '<div id="branding">';
    echo '<h1 id="site-title" class="site-title '.$header_display.'"><a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" rel="home">';
    if ($header_display == 'display-logo') {
        echo '<img alt="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" src="'.$logo.'" />';
    } else {
        echo get_bloginfo( 'name' );
    }
    echo '</a></h1>';
    echo '</div>';
    if($tagline)
    echo '<h2 id="site-description" class="sr-only">'.$tagline.'</h2>';
}
add_action( 'dw-wallpress-before-navigation', 'dw_wall_logo' );

// Change Favicon
// --------------------
function dw_wall_favicon() {
    echo '<link type="image/x-icon" href="'.dw_wall_get_theme_option('favicon',get_template_directory_uri().'/assets/images/favicon.ico').'" rel="shortcut icon">';
}
add_action( 'wp_head', 'dw_wall_favicon' );

// Style selector
// --------------------
function colourBrightness($hex, $percent) {
    // Work out if hash given
    $hash = '';
    if (stristr($hex,'#')) {
        $hex = str_replace('#','',$hex);
        $hash = '#';
    }
    // HEX TO RGB
    $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
    //// CALCULATE 
    for ($i=0; $i<3; $i++) {
        // See if brighter or darker
        if ($percent > 0) {
            // Lighter
            $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
        } else {
            // Darker
            $positivePercent = $percent - ($percent*2);
            $rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
        }
        // In case rounding up causes us to go to 256
        if ($rgb[$i] > 255) {
            $rgb[$i] = 255;
        }
    }
    // RBG to Hex
    $hex = '';
    for($i=0; $i < 3; $i++) {
        // Convert the decimal digit to hex
        $hexDigit = dechex($rgb[$i]);
        // Add a leading zero if necessary
        if(strlen($hexDigit) == 1) {
            $hexDigit = "0" . $hexDigit;
        }
        // Append to the hex string
        $hex .= $hexDigit;
    }
    return $hash.$hex;
}

function dw_wall_typo_color() {
    global $dw_current_theme;

    if ( dw_wall_get_theme_option('custom-color') != '' ) {
        $wall_color = dw_wall_get_theme_option('custom-color');
    } else {
        $wall_color = dw_wall_get_theme_option('select-color');
    } 

    if ($wall_color != '') :
    ?>
    <style type="text/css" id="wall_color" media="screen">

    /* Common 
    ----------------------*/
    button,
    input[type=button],
    input[type=submit],
    .button,
    .button-alt {
        border-color: <?php echo colourBrightness($wall_color,-0.7); ?>;
        background: <?php echo $wall_color; ?>;
        background: -moz-linear-gradient(top,<?php echo $wall_color; ?> 0,<?php echo colourBrightness($wall_color,-0.75); ?> 100%);
        background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,<?php echo $wall_color; ?>),color-stop(100%,<?php echo colourBrightness($wall_color,-0.75); ?>));
        background: -webkit-linear-gradient(top,<?php echo $wall_color; ?> 0,<?php echo colourBrightness($wall_color,-0.75); ?> 100%);
        background: -o-linear-gradient(top,<?php echo $wall_color; ?> 0,<?php echo colourBrightness($wall_color,-0.75); ?> 100%);
        background: -ms-linear-gradient(top,<?php echo $wall_color; ?> 0,<?php echo colourBrightness($wall_color,-0.75); ?> 100%);
        background: linear-gradient(to bottom,<?php echo $wall_color; ?> 0,<?php echo colourBrightness($wall_color,-0.75); ?> 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $wall_color; ?>', endColorstr='<?php echo colourBrightness($wall_color,-0.75); ?>',GradientType=0 );
    }

    button:hover,
    input[type=button]:hover,
    input[type=submit]:hover,
    .button:hover,
    .button-alt:hover {
        background: <?php echo colourBrightness($wall_color,-0.9); ?>;
    }

    button:active,
    input[type=button]:active,
    input[type=submit]:active,
    .button:active,
    .button-alt:active,
    button:focus,
    input[type=button]:focus,
    input[type=submit]:focus,
    .button:focus,
    .button-alt:focus {
        background: <?php echo colourBrightness($wall_color,-0.75); ?>;
        background: -moz-linear-gradient(top,<?php echo colourBrightness($wall_color,-0.75); ?> 0,<?php echo $wall_color; ?> 100%);
        background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,<?php echo colourBrightness($wall_color,-0.75); ?>),color-stop(100%,<?php echo $wall_color; ?>));
        background: -webkit-linear-gradient(top,<?php echo colourBrightness($wall_color,-0.75); ?> 0,<?php echo $wall_color; ?> 100%);
        background: -o-linear-gradient(top,<?php echo colourBrightness($wall_color,-0.75); ?> 0,<?php echo $wall_color; ?> 100%);
        background: -ms-linear-gradient(top,<?php echo colourBrightness($wall_color,-0.75); ?> 0,<?php echo $wall_color; ?> 100%);
        background: linear-gradient(to bottom,<?php echo colourBrightness($wall_color,-0.75); ?> 0,<?php echo $wall_color; ?> 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo colourBrightness($wall_color,-0.75); ?>', endColorstr='<?php echo $wall_color; ?>',GradientType=0 );
    }
    
    #header #navigation li.hilite > a:after,

    .format-image.has-thumbnail:hover .image-btn {
        background-color: <?php echo $wall_color; ?>;
    }

    /*Post*/
    .post-main:before {
        background-color: <?php echo $wall_color; ?>;
    }

    /* Widgets */
    .widget.wallpress-photo li:hover img {
        background-color: <?php echo $wall_color; ?>;
        border-color: <?php echo $wall_color; ?>;
    }

    /* Jigoshop */
    #customer_details h3,
    #order_review .shop_table strong,
    #jigo_minicart .minicart:hover,
    #jigo_minicart:hover .minicart,
    .jigoshop-myaccount .item-content h2,
    .jigoshop-myaccount .item-content h3,
    .jigoshop.page .item-content > p:first-child,

    .jigoshop .price {
        color: <?php echo $wall_color; ?>;
    }

    /* Q&A*/
    .single-dwqa-question .dwqa-container .dwqa-sidebar a:hover {
        color: <?php echo $wall_color; ?>;
    }

    /* WallPress
    ----------------------*/
    <?php if($dw_current_theme == 'DW WallPress'): ?>
    a {
        color: <?php echo $wall_color; ?>;
    }

    a:hover,
    a:active,
    a:focus {
        color: <?php echo colourBrightness($wall_color,-0.75); ?>;
    }
    <?php endif; ?>
    
    /* WallDark
    ----------------------*/
    <?php if($dw_current_theme == 'DW WallDark'): ?>
    a {
        color: <?php echo $wall_color; ?>;
    }

    #header #navigation a:hover, 
    #header #navigation a:active, 
    #header #navigation a:focus {
        color: <?php echo $wall_color; ?> !important;
    }

    #header #navigation li.current-menu-item > a, 
    #header #navigation li.current-menu-ancestor > a, 
    #header #navigation li.current_page_item > a,
    
    .post .post-title a:hover,

    .item .item-title a:hover,
    .item .item-title a:active,
    .item .item-title a:focus {
        color: <?php echo $wall_color; ?>;
    }
    <?php endif; ?>

    /* WallPin
    ----------------------*/    
    <?php if($dw_current_theme == 'DW WallPin'): ?>
    a:hover, a:active, a:focus,

    #branding a,

    .item:hover .item-title a {
        color: <?php echo $wall_color; ?>;
    }
    
    <?php endif; ?>
    
    /* WallChristmas
    ----------------------*/
    <?php if($dw_current_theme == 'DW WallChristmas'): ?>
    a,
    a:hover, a:active, a:focus {
        color: <?php echo $wall_color; ?>;
    }

    #sidebar a {
        color: <?php echo $wall_color; ?>;
    }

    .post:hover .post-main:before,
    .format-image.has-thumbnail:hover .image-btn:hover {
        background-color: <?php echo colourBrightness($wall_color, 0.85); ?>;
    }
    <?php endif; ?>


    </style>
    <?php
    endif;
}
add_filter('wp_head','dw_wall_typo_color');

// Get fonts
// --------------------
if( ! function_exists('dw_get_gfonts') ) {
    function dw_get_gfonts(){
        $fontsSeraliazed = wp_remote_fopen( get_template_directory_uri() . '/inc/font/gfonts_v2.txt' );
        $fontArray = unserialize( $fontsSeraliazed );
        return $fontArray->items;
    }
}

function dw_wall_typo_font(){
    global $dw_current_theme;

    if (dw_wall_get_theme_option('heading_font') && dw_wall_get_theme_option('heading_font') != '') {
        $heading_font = explode(':dw:', dw_wall_get_theme_option('heading_font') );
    ?>
        <style type="text/css" id="heading_font" media="screen">
        @font-face {
            font-family: "<?php echo $heading_font[0]; ?>";
            src: url('<?php echo $heading_font[1] ?>');
        } 
        h1,h2,h3,h4,h5,h6,
        .page-title,
        .small-header .page-title,
        #headline h2,
        #branding a,
        #sidebar-secondary .widget-title,
        <?php if($dw_current_theme == 'WallChristmas'): ?>
        #header #navigation li a,
        #header #navigation li li a,
        <?php endif; ?>
        #sidebar .widget-title {
            font-family: "<?php echo $heading_font[0]; ?>";
        }
        </style>
    <?php
    }

    if (dw_wall_get_theme_option( 'body_font') && dw_wall_get_theme_option( 'body_font') != '') {
        $body_font = explode( ':dw:', dw_wall_get_theme_option( 'body_font' ));
    ?>
        <style type="text/css" id="body_font" media="screen">
        @font-face {
            font-family: "<?php echo $body_font[0]; ?>";
            src: url('<?php echo $body_font[1] ?>');
        } 
        body,blockquote,blockquote cite,#site-description,#branding nav li.coming-soon > a:after,.format-quote blockquote,#testimonials blockquote {
            font-family: "<?php echo $body_font[0]; ?>";
        }
        .latest-twitter-tweet-time,#secondary #latest-twitter-follow-link {
            font-family: "<?php echo $body_font[0]; ?>" !important;
        }
        </style>
    <?php
    }
}
add_filter('wp_head','dw_wall_typo_font');

// Custom code
// --------------------
function dw_wall_custom_header_code() {
    echo dw_wall_get_theme_option( 'header_code' );
}
add_action('wp_head', 'dw_wall_custom_header_code');

function dw_wall_custom_footer_code() {
    echo dw_wall_get_theme_option( 'footer_code' );
}
add_action('wp_footer', 'dw_wall_custom_footer_code');