<!doctype html>
<?php
// TODO: for better SEO!
// blog info
$blog_title = get_bloginfo( 'title' ) . '-' . get_bloginfo( 'description' );
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
if ( is_home() ) {

} else if ( is_single() ) {
	$blog_title = single_post_title( '', false );

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

	$blog_author = get_the_author_meta( 'nicename', $post_author_id );
	if ( get_the_author_meta( 'email', $post_author_id ) ) {
		$blog_author = $blog_author . ',' . get_the_author_meta( 'email', $post_author_id );
	}
} else if ( is_archive() ) {
	echo "is archive";
} else if ( is_search() ) {
	echo "is search";
} else if ( is_tag() ) {
	echo "is tag";
}
?>
<html lang="<?php echo get_bloginfo( 'language' ); ?>">
<head>
    <title><?php echo trim( $blog_title ); ?></title>
    <meta charset="<?php echo get_bloginfo( 'charset' ); ?>">
    <meta name="keywords" content="<?php echo trim( $blog_keywords ); ?>">
    <meta name="description" content="<?php echo trim( $blog_description ); ?>">
    <meta name="author" content="<?php echo trim( $blog_author ); ?>">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta name="renderer" content="webkit"/>
    <meta name="force-rendering" content="webkit"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<?php
	wp_meta();

	wp_register_style(
		'pure-main',
		get_template_directory_uri() . '/assets/scss/index.min.css',
		array(),
		'0.1.1',
		'all'
	);
	wp_enqueue_style( 'pure-main' );
	?>

	<?php wp_head(); ?>
</head>


<body class="<?php body_class(); ?>">

<header class="main-header">

    <div class="custom-header-background-image">
    </div>

    <div class="header-content-wrap">
        <!--        <nav class="header-top-bar">-->
        <!--            <ul class="list">-->
        <!--                <li class="list-item"><a href="">Facebook</a></li>-->
        <!--            </ul>-->
        <!--        </nav>-->

        <div class="main-header-content">
            <div class="blog-info-wrap">
				<?php the_custom_logo(); ?>

                <div class="split-line"></div>

                <div class="blog-title-desc-wrap serif">
                    <a class="home-link"
                       href="<?php bloginfo( "url" ); ?>">
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

        <!--	    --><?php
		//	    wp_nav_menu( array(
		//		    'theme_location'  => 'header_menu',
		//		    'menu'            => 'header-menu',
		//		    'menu_class'      => 'top-menu',
		//		    'menu_id'         => 'topMenu',
		//		    'container'       => 'nav',
		//		    'container_class' => 'top-nav-container',
		//		    'container_id'    => 'topNavigationContainer',
		//		    'echo'            => true,
		//		    'fallback_cb'     => 'wp_page_menu',
		//		    'before'          => '',
		//		    'after'           => '',
		//		    'link_before'     => '',
		//		    'link_after'      => '',
		//		    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		//		    'depth'           => 1,
		//		    'walker'          => ''
		//	    ) );
		//	    ?>

    </div>


</header>

<div class="post-list">
	<?php if ( have_posts() ) {
		while ( have_posts() ) : the_post();
			?>
            <div <?php post_class( 'post' ); ?>>
                <article class="post-wrap"
                         id="article-<?php get_the_ID(); ?>">
                    <h1 class="post-title serif">
                        <a class="post-title-url"
                           href="<?php the_permalink(); ?>"
                           title="<?php the_title(); ?>"
                        >
							<?php the_title(); ?>
                        </a>
                    </h1>
                    <div class="posy-meta-wrap">
                        <ul class="post-meta post-meta-top">
                            <li class="post-meta-item author-avatar-wrap">

                                <?php echo get_avatar(get_the_author_meta( 'user_email' )); ?>
                            </li>
                            <li class="post-meta-item">
                                <a class="author-name"
                                   href="<?php echo get_the_author_meta( 'url' ) ?>"
                                   title="<?php echo get_the_author_meta( 'display_name' ); ?>">
									<?php echo get_the_author_meta( 'display_name' ); ?>
                                </a>
                                <time class="publish-time"
                                      datetime="<?php echo get_post_time( 'Y/m/d' ); ?>">
									<?php echo get_post_time( 'Y/m/d' ); ?>
                                </time>
                            </li>

                            <li class="post-meta-item category-list">
								<?php if ( get_the_category_list() ) { ?>
									<?php the_category( ' / ' ); ?>
								<?php } ?>
                            </li>
                        </ul>
                    </div>
                    <div class="post-entry typo serif">
						<?php

						echo apply_filters( 'the_content', get_the_content( "" ) );

						?>
                    </div>
                    <div class="post-meta post-tags-wrap">
						<?php the_tags( '', '、', '' ); ?>
                    </div>


					<?php
					if ( is_single() ) { ?>
                        <nav>
							<?php
							if ( get_previous_post_link() ) { ?>
								<?php echo get_previous_post_link( '%link' ); ?>
							<?php }
							if ( get_next_post_link() ) {
								?>

								<?php echo get_next_post_link( '%link' ); ?>
								<?php
							}; ?>
                        </nav>
						<?php
					}
					?>

					<?php ?>
                </article>
            </div>
		<?php
		endwhile;
	} else {
		_e( 'Sorry, no posts matched your criteria.', 'textdomain' );
	}
	?>


	<?php if ( is_page() ) { ?>

		<?php ; ?>

	<?php } ?>


    <nav class="post-nav" id="postNav">
		<?php echo paginate_links( array(
			'type'               => 'list',
			'base'               => '%_%',
			'format'             => '?paged=%#%',
			'show_all'           => false,
			'end_size'           => 1,
			'mid_size'           => 2,
			'prev_next'          => true,
			'prev_text'          => __( '« Previous' ),
			'next_text'          => __( 'Next »' ),
			'add_args'           => false,
			'add_fragment'       => '',
			'before_page_number' => '',
			'after_page_number'  => ''
		) ); ?>
    </nav>
</div>

<footer class="main-footer" id="main-footer">
    <div class="footer-content">
        Powered by <a href="https://wordpress.org/" title="code is poetry">WordPress</a><br>
        Theme By <?php ; ?>
    </div>
</footer>

<?php
wp_register_style(
	'pure-main',
	get_template_directory_uri() . '/assets/scss/index.min.css',
	array(),
	'0.1.1',
	'all'
);

wp_register_script(
	'pure-lazyload-js',
	get_template_directory_uri() . '/assets/scripts/lazyload.min.js',
	array(),
	'2.0.0-beta.2'
);

wp_register_script(
	'pure-prism-js',
	get_template_directory_uri() . '/assets/scripts/prism.min.js',
	array(),
	'1.11.0'
);

wp_enqueue_style( 'pure-main' );
wp_enqueue_script( 'jquery' );
wp_enqueue_script( 'pure-prism-js' );
wp_enqueue_script( 'pure-lazyload-js' );


wp_print_styles();
wp_print_scripts();
wp_footer();
?>

<script type="text/javascript">
    Prism.highlightAll();
    jQuery(".post img").lazyload();
</script>


<style>
    .main-header .custom-header-background-image {
        background-image: url(<?php header_image(); ?>);
        background-attachment: fixed;
        background-repeat: no-repeat;
        background-size: cover;
        background-color: <?php echo get_custom_header()->default-text-color;?>;
        padding-bottom: <?php echo get_custom_header()->height / get_custom_header()->width * 100 ; ?>%;
        /*filter: blur(10px);*/
    }
</style>

</body>
</html>