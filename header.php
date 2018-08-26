<!DOCTYPE html>
<?php

wp_register_script(
	'pure-lazyload-js',
	get_template_directory_uri() . '/assets/scripts/lazyload.min.js',
	array(),
	null,
	true
);

wp_register_script(
	'pure-prism-js',
	get_template_directory_uri() . '/assets/scripts/prism.min.js',
	array(),
	null,
	true
);

if ( ! isset( $content_width ) ) {
	$content_width = 900;
}
?>
<html <?php echo get_language_attributes(); ?> dir="<?php echo is_rtl() ? 'rtl' : 'ltr';?>">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="content-type" content="charset=<?php bloginfo('charset');?>;<?php bloginfo('html_type')?>>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,shrink-to-fit=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-starturl" content="/">
    <meta name="msapplication-navbutton-color" content="#1abc9c">
    <meta name="msapplication-TileColor" content="#1abc9c">
    <meta name="theme-color" content="#1abc9c">
    <meta name="referrer" content="always">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="x-dns-prefetch-control" content="on">
	<?php
	wp_meta();
    wp_head();
	?>
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/manifest.json">
    <link rel="alternate" hreflang="zh-Hans" href="<?php echo home_url(); ?>">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <style>
    <?php
     include(get_stylesheet_directory() .'/assets/scss/main.min.css');
    ?>
    .main-header .top-nav-container::before,
    .main-header .custom-header-background-image {
        padding-bottom: <?php echo get_custom_header()->height / get_custom_header()->width * 100 ; ?>%;
        background-image: url(<?php header_image(); ?>);
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100%;
        /*background-position: center;*/
    }
    .main-header .top-nav-container::before {
        padding-bottom: 0;
    }
    </style>
    <?php add_editor_style();?>
</head>

<body <?php body_class( 'serif' ); ?>>

<header class="main-header">
    <div class="custom-header-background-image"
         id="customHeaderBackgroundImage">
    </div>
    <div class="header-content-wrap">
        <div class="main-header-content">
            <div class="blog-info-wrap">
				<?php the_custom_logo(); ?>

                <div class="split-line"></div>

                <div class="blog-title-desc-wrap serif">
                    <a class="home-link"
                       href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <h1 class="blog-title">
							<?php bloginfo( "title" ) ?>
                        </h1>
                    </a>

                    <h2 class="blog-description">
						<?php bloginfo( "description" ) ?>
                    </h2>
                </div>
            </div>
        </div>

		<?php
		wp_nav_menu( array(
			'theme_location'  => 'header_menu',
			'menu'            => 'header-menu',
			'menu_class'      => 'top-menu',
			'menu_id'         => 'topMenu',
			'container'       => 'nav',
			'container_class' => 'top-nav-container',
			'container_id'    => 'topNavigationContainer',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 1,
			'walker'          => ''
		) );
		?>
    </div>
</header>
