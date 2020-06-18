<?php

/**
 * Template Name: Friends List Template
 *
 * Created by PhpStorm.
 * User: hubery
 * Date: 2018/6/5
 * Time: 14:37
 */

get_header();
?>

<main class="main-content">
  <div class="post-wrap content-width">
    <article <?php post_class('post h-entry'); ?>>
      <header class="entry-header">
        <h1 class="post-title entry-title"><?php echo esc_html(get_the_title()); ?></h1>
      </header>

      <div class="post-entry entry-content typo friends">
      </div>
    </article>
  </div>

  <div class="content-width">
    <ul class="friend-list">
      <?php
      $bookmarks = get_bookmarks(array(
        'orderby'         => 'rating',
        'limit'           => -1,
        'hide_invisible'  => 1,
      ));
      foreach ($bookmarks as $friend) { ?>
        <li class="friend-list-item">
          <a href="<?php echo $friend->link_url; ?>"
             ref="<?php echo $friend->link_rel; ?>"
             target="<?php echo $friend->link_target; ?>">
            <header>
            </header>
            <img src="<?php echo $friend->link_image; ?>"
                 alt="<?php echo $friend->link_name; ?>"
                 width="200">

            <img src="<?php echo $friend->link_description; ?>"
                 alt="<?php echo $friend->link_name; ?>"
                 width="200">
            <h2>
              <?php echo esc_html($friend->link_name); ?>
            </h2>
            <p>
              <?php echo $friend->link_notes; ?>
            </p>
            <?php echo $friend->link_rss; ?>
          </a>
        </li>
      <?php
      }
      ?>
    </ul>

    <pre>
    <?php var_dump(get_bookmarks(array()));?>
    </pre>
  </div>
</main>
  <?php get_footer(); ?>

