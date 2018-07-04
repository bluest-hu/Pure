<!doctype html>
<?php

// description
$blog_description = get_bloginfo( 'description' );
// keywords
$blog_keywords = "";
// author ID
$post_author_id = $post->post_author;
// blog author
$blog_author = get_bloginfo( 'admin_email' );
// ID
$post_id = get_the_ID();

if ( get_option( 'pure_theme_index_page_keywords' ) != '' ) {
	$blog_keywords = trim( stripslashes( get_option( 'pure_theme_index_page_keywords' ) ) );
}

if ( is_home() ) {

} else if ( is_single() ) {
	if ( get_the_excerpt() ) { // 默认读取文章的摘要信息
		$blog_description = get_the_excerpt( $post_id );
	} else {
		$blog_description = strip_tags( $post->post_content );
	}

	$blog_description = preg_replace( '/\s+/', ' ', $blog_description );
	$blog_description = mb_strimwidth( $blog_description, 0, 200 );

	// join all the tags
	$blog_keywords = array();

	foreach ( wp_get_post_tags( $post_id ) as $tag ) {
		array_push( $blog_keywords, $tag->name );
	}
	$blog_keywords = join( $blog_keywords, ',' );
	$blog_author   = get_the_author_meta( 'display_name', $post_author_id );

} else if ( is_archive() ) {
} else if ( is_search() ) {
} else if ( is_tag() ) {
} else if ( is_category() ) {
} else if ( is_page() ) {
} else {
}
?>
<html <?php echo get_language_attributes(); ?>>
<head>
    <meta charset="<?php echo get_bloginfo( 'charset' ); ?>">
    <meta name="theme-color" content="#1abc9c"/>
    <meta http-equiv="Content-Type" content="text/html;charset=<?php echo get_bloginfo( 'charset' ); ?>">
    <meta name="keywords" content="<?php echo trim( $blog_keywords ); ?>">
    <meta name="description" content="<?php echo trim( $blog_description ); ?>">
    <meta name="author" content="<?php echo trim( $blog_author ); ?>">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="alternate" hreflang="zh-Hans" href="<?php echo home_url(); ?>">
	<?php
	wp_meta();

	// 	wp_register_style(
	// 		'pure-main',
	// 		get_template_directory_uri() . '/assets/scss/main.min.css',
	// 		array(),
	// 		'20180411',
	// 		'all'
	// 	);

	// 	wp_enqueue_style( 'pure-main' );

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

	wp_head();

	add_editor_style();

	if ( ! isset( $content_width ) ) {
		$content_width = 900;
	}
	?>

    <style type="text/css">
        <?php include(get_stylesheet_directory() .'/assets/scss/main.min.css');?>
        .main-header .custom-header-background-image {
            padding-bottom: <?php echo get_custom_header()->height / get_custom_header()->width * 100 ; ?>%;
            background: url(<?php header_image(); ?>) no-repeat fixed;
            background-size: contain;
        }
    </style>
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
                       href="<?php echo esc_url( home_url() ); ?>">
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
