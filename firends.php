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
<div class="content-width">
  <?php
  var_dump(get_bookmarks(array()));
  ?>
  <ul class="friend-list">
    <?php
    foreach (get_bookmarks(array()) as $friend) { ?>
      <li class="friend-list_item">
        <a href="<?php echo $friend->link_url; ?>">
          <img src="<?php echo $friend->link_image; ?>" alt="<?php echo $friend->link_name; ?>">
          <h2>
            <?php echo $friend->link_name; ?>
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
</div>

<?php get_footer(); ?>
