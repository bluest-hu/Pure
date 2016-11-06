<!doctype html>
<?php
// TODO: for better SEO!
// blog info
$blog_title = get_bloginfo('title') . '-' . get_bloginfo('description');
// description
$blog_description = get_bloginfo('description');
// keywords
$blog_keywords = "";
// author ID
$post_author_id = $post->post_author;
// blog author
$blog_author = get_bloginfo('admin_email');

// ID
$post_id = get_the_ID();
if (is_home()) {

} else if (is_single()) {
    $blog_title = single_post_title('', false);

    if (get_the_excerpt()) { // 默认读取文章的摘要信息
        $blog_description = get_the_excerpt($post_id);
    } else {
        $blog_description = strip_tags($post->post_content);
    }
    $blog_description = preg_replace('/\s+/', ' ', $blog_description);
    $blog_description = mb_strimwidth($blog_description, 0, 200);

    // join all the tags
    $blog_keywords = array();
    foreach (wp_get_post_tags($post_id) as $tag) {
        array_push($blog_keywords, $tag->name);
    }
    $blog_keywords = join($blog_keywords, ',');

    $blog_author = get_the_author_meta('nicename',$post_author_id);
    if ( get_the_author_meta('email', $post_author_id) ) {
        $blog_author = $blog_author . ',' . get_the_author_meta('email',$post_author_id);
    }
} else if (is_archive()) {
    echo "is archive";
} else if (is_search()) {

} else if (is_tag()) {
}
?>
<html lang="<?php echo get_bloginfo('language'); ?>">
    <head>
        <title><?php echo trim($blog_title);?></title>
        <meta charset="<?php echo get_bloginfo('charset');?>">
        <meta name="keywords" content="<?php echo trim($blog_keywords); ?>">
        <meta name="description" content="<?php echo trim($blog_description); ?>">
        <meta name="author" content="<?php echo trim($blog_author); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="renderer" content="webkit"/>
        <meta name="force-rendering" content="webkit"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <?php
        wp_register_style(
            'pure-main',
            get_template_directory_uri() . '/styles/index.css',
            array(),
            0.1,
            'all'
        );
        wp_enqueue_style('pure-main');
        wp_print_styles();
        ?>
    </head>
    <body class="<?php echo body_class(); ?>">
        <header class="main-header">
            <nav class="header-top-bar">
                <ul class="list">
                    <li class="list-item"><a href="">Facebook</a></li>
                </ul>
            </nav>
            <div class="main-header-content">

                <h1 class="blog-title"><img height="60px" style="vertical-align:middle;margin-right: 10px" src="https://s.w.org/about/images/logos/wordpress-logo-notext-rgb.png"><a class="home-link" href="<?php echo bloginfo("url");?>"><?php echo bloginfo("title")?></a></h1>
                <h2 class="blog-description"><?php echo bloginfo("description")?></h2>
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
                ));
                ?>
            </div>
        </header>

        <div class="post-list">
            <?php if ( have_posts() ) {
                while ( have_posts() ) : the_post();
                    ?>
                    <article <?php post_class('post');?> id="article-<?php get_the_ID();?>">
                        <div class="post-wrap">
                            <h1 class="post-title">
                                <a class="post-title-url"
                                   href="<?php the_permalink();?>"
                                   title="<?php the_title(); ?>"
                                >
                                    <?php the_title(); ?>
                                </a>
                            </h1>
                            <div>
                                <ul class="post-meta">
                                    <li class="post-meta-item">
                                        By:<a href="<?php echo get_the_author_meta('url')?>"
                                              class=""
                                              title="<?php echo get_the_author_meta('nicename');?>"><?php echo get_the_author_meta('nicename');?></a>
                                    </li>
                                    <li class="post-meta-item">
                                        @<time class="publish-time"
                                               datetime="<?php echo get_post_time('Y/m/d');?>">
                                            <?php echo get_post_time('Y/m/d');?>
                                        </time>
                                    </li>
                                    <?php if (get_the_category_list()) { ?>
                                    <li class="post-meta-item">
                                        In:<?php the_category('/');?>
                                    </li>
                                    <?php }?>
                                </ul>
                            </div>
                            <div class="post-entry">
                                <?php the_content("Read More"); ?>
                            </div>
                            <div class="post-meta">
                                <?php the_tags('',','); ?>
                            </div>
                        </div>
                    </article>


                    <?php
                endwhile;
            }
            else {
                _e( 'Sorry, no posts matched your criteria.', 'textdomain' );
            }
            ?>


            <?php if (is_page()) { ?>

                <?php ;?>

            <?php } ?>


            <?php
            if (is_single()) {
                if (get_previous_post_link()) { ?>
                    <?php echo get_previous_post_link('%link');?>
            <?php }
                if (get_next_post_link()) {

            ?>
                    <?php echo get_next_post_link('%link'); ?>
            <?php
                }
            }
            ?>


            <nav class="post-nav" id="postNav">
                <?php echo paginate_links( array(
                    'type' => 'list'
                ) ); ?>
            </nav>



        </div>

        <footer class="main-footer" id="main-footer">
            <div class="footer-content">
                Powered by WordPress
                Theme By Hubery
            </div>

        </footer>
    </body>

</html>