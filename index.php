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
	$blog_author   = get_the_author_meta( 'display_name', $post_author_id );

} else if ( is_archive() ) {

} else if ( is_search() ) {

} else if ( is_tag() ) {
	$blog_title = single_cat_title();
} else if ( is_category() ) {
	$blog_title = single_cat_title();
}
?>
<html <?php echo get_language_attributes(); ?>>
<head>
    <title><?php echo trim( $blog_title ) ?></title>
<!--    <title>--><?php //echo wp_title(); ?><!--</title>-->
    <meta charset="<?php echo get_bloginfo( 'charset' ); ?>">
    <meta name="keywords" content="<?php echo trim( $blog_keywords ); ?>">
    <meta name="description" content="<?php echo trim( $blog_description ); ?>">
    <meta name="author" content="<?php echo trim( $blog_author ); ?>">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta name="renderer" content="webkit"/>
    <meta name="force-rendering" content="webkit"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <link rel="alternate" hreflang="<?php get_language_attributes(); ?>" href="alternateURL">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="dns-prefetch" href="//cdn.bootcss.com">
    <?php
	wp_meta();

	wp_register_style(
		'pure-main',
		get_template_directory_uri() . '/assets/scss/main.min.css',
		array(),
		'20180320',
		'all'
	);


	wp_enqueue_style( 'pure-main' );

	wp_register_script(
		'pure-lazyload-js',
		'https://cdn.bootcss.com/jquery_lazyload/1.9.7/jquery.lazyload.min.js',
		array(),
		'1.9.7',
		true
	);

    wp_register_script(
        'pure-jquery',
        '//cdn.bootcss.com/jquery/3.3.1/jquery.slim.min.js',
        array(),
        '2.0.0-beta.2',
        true
    );

	wp_register_script(
		'pure-prism-js',
		get_template_directory_uri() . '/assets/scripts/prism.min.js',
		array(),
		'1.12.2',
		true
	);

    wp_head();

    add_editor_style();


    if ( ! isset( $content_width ) ) {
	    $content_width = 900;
    }
?>
    <style>
        .main-header .custom-header-background-image {
            background-attachment: fixed;
            background-size: contain;
            padding-bottom: <?php echo get_custom_header()->height / get_custom_header()->width * 100 ; ?>%;
            background-repeat: no-repeat;
        }
    </style>
</head>


<body <?php body_class('serif'); ?>>
<header class="main-header">
    <div class="custom-header-background-image">
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

<div class="post-list">
	<?php if ( have_posts() ) {
		while ( have_posts() ) : the_post();
			?>
            <article <?php post_class( 'post h-entry' ); ?>>
                <div class="post-wrap content-width">
                    <h2 class="post-title serif entry-title">
                        <a class="post-title-url"
                           href="<?php the_permalink(); ?>"
                           title="<?php the_title(); ?>"
                        >
							<?php the_title(); ?>
                        </a>
                    </h2>
                    <div class="posy-meta-wrap">
                        <ul class="post-meta post-meta-top">
                            <li class="post-meta-item author-avatar-wrap">
								<?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
                            </li>
                            <li class="post-meta-item">
                                <a class="author-name"
                                   rel="vcard author post-author"
                                   href="<?php echo get_the_author_meta( 'url' ) ?>"
                                   title="<?php echo get_the_author_meta( 'display_name' ); ?>">
									<?php echo get_the_author_meta( 'display_name' ); ?>
                                </a>
                                <time class="publish-time post-date updated"
                                      datetime="<?php echo get_post_time( 'Y/m/d' ); ?>">
									<?php echo get_post_time( 'Y/m/d' ); ?>
                                </time>
                            </li>
							<?php if ( get_the_category_list() ) { ?>
                                <li class="post-meta-item category-list">
									<?php the_category( ' / ' ); ?>
                                </li>
							<?php } ?>
                        </ul>
                    </div>
                    <div class="post-entry typo">
						<?php
						echo apply_filters( 'the_content', get_the_content( "Read More »", false ) );
						?>

                        <nav id="">
							<?php wp_link_pages(); ?>
                        </nav>
                    </div>

                    <div class="post-meta post-tags-wrap">
						<?php the_tags( '', '、', '' ); ?>
                    </div>
					<?php ?>
                </div>
            </article>



        <?php
        if ( is_single() ) { ?>
            <nav id="relativePostNav" class="relative-post-nav content-width">
                <ul class="nav-list">
                <?php if ( get_previous_post_link() ) { ?>
                    <li class="nav-item prev-nav-item"><?php previous_post_link(); ?></li>
                <?php } else if ( get_next_post_link() ) {; ?>
                    <li class="nav-item next-nav-item"><?php next_post_link(); ?></li>
                <?php } ?>
                </ul>
            </nav>
        <?php } ?>
		<?php
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile;
	} else {
		_e( 'Sorry, no posts matched your criteria.', '' );
	}
	?>

    <nav class="pages-nav" id="pagesNav">
		<?php echo paginate_links( array(
			'type'               => 'list',
			'show_all'           => false,
			'prev_next'          => true,
			'prev_text'          => __( '« Previous','' ),
			'next_text'          => __( 'Next »', '' ),
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
        Theme By <?php echo wp_get_theme()->display( 'Author' ); ?>
    </div>
</footer>

<?php
wp_enqueue_script( 'pure-jquery' );
wp_enqueue_script( 'pure-prism-js' );
wp_enqueue_script( 'pure-lazyload-js' );

wp_footer();
?>

<script>
    jQuery(function () {
        Prism.highlightAll();
        jQuery(".post img").lazyload();
    });
</script>


<style>
    .main-header .custom-header-background-image {
        background-image: url(<?php header_image(); ?>);
    }
</style>

</body>
</html>