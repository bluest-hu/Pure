<?php

/**
 * Template Name: Archive Template
 */

?>

<?php get_header(); ?>

<main class="main-content">
  <div class="post-wrap content-width">
    <article <?php post_class('post h-entry'); ?>>
      <header class="entry-header">
        <h1 class="post-title entry-title"><?php echo esc_html(get_the_title()); ?></h1>
      </header>

      <div class="post-entry entry-content typo archive">
        <?php
        const PURE_THEME_CACHE_FLAG = 'KEY_theme_pure_archive';
        $result = wp_cache_get(PURE_THEME_CACHE_FLAG);

        if (!$result) {
          $result = array();
          $args = array(
            'post_type' => 'post', //如果你有多个 post type，可以这样 array('post', 'product', 'news')
            'posts_per_page' => -1, //全部 posts
            'ignore_sticky_posts' => true, //忽略 sticky posts
            'cache_results' => true,
          );
          $the_query = new WP_Query($args);

          while ($the_query->have_posts()) {
            $the_query->the_post();
            $post_year = get_the_time('Y');
            $post_mon = get_the_time('m');
            $post_day = get_the_time('d');

            $result[$post_year][$post_mon][] = array(
              'title' => get_the_title(),
              'publish_date' => get_post_time('d'),
              'post_status' => 'publish',
              'permalink' => get_the_permalink(),
              'comments' => get_comments_number('0', '1', '%'),
            );
          }
          wp_reset_postdata();
          wp_cache_set(PURE_THEME_CACHE_FLAG, $result);
        }

        add_action('save_post', function () {
          wp_cache_delete(PURE_THEME_CACHE_FLAG);
        });
        ?>
        <ol class="year-list">
          <?php foreach ($result as $year => $year_value) : ?>
            <li class="year-list-item">
              <h2 class="year-title"><?php echo $year; ?><span class="unit">年</span></h2>
              <ol class="month-list">
                <?php foreach ($year_value as $month => $month_value) : ?>
                  <li class="month-list-item">
                    <h3 class="month-title"><?php echo $month; ?><span class="unit">月</span></h3>
                      <ol class="post-list">
                        <?php foreach ($month_value as $post => $post_value) : ?>
                          <li class="post-list-item">
                            <time class="publish-time"><?php echo $post_value['publish_date']; ?>日</time>
                            <a class="title" 
                               title="<?php echo $post_value['title']; ?>" 
                               href="<?php echo $post_value['permalink']; ?>"><?php echo $post_value['title']; ?></a>
                            <span class="line"></span>
                            <a class="comments" 
                               href="<?php echo $post_value['permalink']; ?>#comments" 
                               title=" echo $post_value['comments']; ?> 条评论"><?php echo $post_value['comments']; ?> reply</a>
                          </li>
                        <?php endforeach ?>
                      </ol>
                  </li>
                <?php endforeach ?>
              </ol>
            </li>
          <?php endforeach ?>
        </ol>

        <div class="end">
          <span class="eof">EOF</span>
        </div>
      </div>
    </article>
  </div>
</main>
<?php get_footer(); ?>
