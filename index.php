<!doctype html>
<html lang="<?php echo get_bloginfo('language'); ?>">

    <head>


        <?php
        // blog info
        $blog_title = get_bloginfo('title');
        // description
        $blog_description = get_bloginfo('description')
        ?>


        <title><?php echo $blog_title;?></title>
        <meta charset="<?php echo get_bloginfo('charset');?>">


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
        <header>
            <h1><a href="<?php echo bloginfo("url");?>"><?php echo bloginfo("title")?></a></h1>
            <h1><?php echo bloginfo("description")?></h1>
            <nav>
                <?php
                wp_nav_menu( array(
                    'theme_location'  => 'header_menu',
                    'menu'            => 'header-nemu',
                    'container'       => 'div',
                    'container_class' => 'top-nav-container',
                    'container_id'    => 'topNavigationContainer',
                    'menu_class'      => 'top-menu',
                    'menu_id'         => 'topMenu',
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
            </nav>
        </header>

        <div class="post-list">
            <?php if ( have_posts() ) {
                while ( have_posts() ) : the_post();
                    ?>
                    <article <?php post_class('post');?> id="article-<?php;?>">
                        <div class="post-wrap">
                            <h1 title="">
                                <a href="<?php the_permalink();?>">
                                    <?php the_title() ?>
                                </a>
                            </h1>
                            <div>
                                By:<a href="<?php echo get_the_author_meta('url')?>"
                                      class=""
                                      title="<?php echo get_the_author_meta('nicename');?>"
                                ><?php echo get_the_author_meta('nicename');?></a>
                                @<time class="publish-time"
                                    datetime="<?php echo get_post_time('Y/m/d');?>"><?php echo get_post_time('Y/m/d');?></time>
                            </div>



                            <div class="post-entry">
                                <?php the_content("Read More"); ?>
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
            <?php echo the_posts_pagination();?>
        </div>

        <footer>

        </footer>
    </body>

</html>