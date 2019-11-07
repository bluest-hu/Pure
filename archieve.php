<?php

/**
 * Template Name: Archive Template
 */

?>

<?php get_header(); ?>

<div class="main-content">
  <div class="post-wrap content-width">
    <article <?php post_class('post h-entry'); ?>>
      <header class="entry-header">
        <h1 class="post-title entry-title"><?php echo esc_html(get_the_title()); ?></h1>
      </header>

      <div class="post-entry entry-content typo">
        <?php
        $args = array(
          'post_type' => 'post', //如果你有多个 post type，可以这样 array('post', 'product', 'news')
          'posts_per_page' => -1, //全部 posts
          'ignore_sticky_posts' => true, //忽略 sticky posts
          'cache_results' => true,
        );
        $the_query = new WP_Query( $args );

        $result = array();

        while ( $the_query->have_posts() ) {
          $the_query->the_post();
          $post_year = get_the_time('Y');
          $post_mon = get_the_time('m');
          $post_day = get_the_time('d');

          $result[$post_year][$post_mon] = array(
            'title' => get_the_title(),
            'publish_date' => get_the_time('d日: '),
          );
        }

        echo '<pre>';
        var_dump($result);
        echo '</pre>';

        wp_reset_postdata();
        ?>
      </div>
    </article>
  </div>
</div>


<?php get_footer(); ?>
