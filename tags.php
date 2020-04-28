<?php
/**
 * Template Name: Tags Template
 */
?>

<?php get_header(); ?>
<main class="main-content">
  <div class="post-wrap content-width">

<!--    <header class="entry-header">-->
<!--      <h1 class="post-title entry-title">--><?php //echo esc_html(get_the_title()); ?><!--</h1>-->
<!--    </header>-->
    <?php wp_tag_cloud(array(
      'smallest'   => 16,
      'largest'    => 48,
      'unit'       => 'px',
      'number'     => 0,
      'format'     => 'flat',
      'separator'  => "\n",
      'orderby'    => 'name',
      'order'      => 'ASC',
      'exclude'    => '',
      'include'    => '',
      'link'       => 'view',
      'taxonomy'   => 'post_tag',
      'post_type'  => '',
      'echo'       => true,
      'show_count' => 0,
    ));?>
  </div>
</main>
<?php get_footer(); ?>
