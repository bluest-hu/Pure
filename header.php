<!DOCTYPE html>
<?php
wp_register_script(
  'main-js',
  get_template_directory_uri() . '/dist/main.js',
  array(),
  null,
  true
);

if (!isset($content_width)) {
  $content_width = 900;
}
?>
<html <?php echo get_language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="content-type" content="charset=<?php bloginfo('charset'); ?>;<?php bloginfo('html_type') ?>>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="msapplication-starturl" content="/">
  <meta name="msapplication-navbutton-color" content="#1abc9c">
  <meta name="msapplication-TileColor" content="#1abc9c">
  <meta name="theme-color" content="#1abc9c">
  <meta name="referrer" content="always">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta http-equiv="x-dns-prefetch-control" content="on">
  <link rel="preload" as="image" href="<?php header_image(); ?>"/>
  <link rel="dns-prefetch"  href="//www.google-analytics.com"/>
  <link rel="prefetch"  href="//www.google-analytics.com"/>
  <?php
  wp_meta();
  wp_head();
  ?>
  <link rel="manifest" href="/wp-json/wp_theme_pure/v1/manifest.json">
  <link rel="alternate" hreflang="zh-Hans" href="<?php echo esc_url(home_url()); ?>">
  <?php if (is_singular() && pings_open(get_queried_object())) : ?>
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <?php endif; ?>
  <style>

    <?php
      include(get_stylesheet_directory() . '/dist/main.min.css');
    ?>
    .main-header .top-nav-container::before,
    .main-header .custom-header-background-image {
      padding-bottom: <?php echo get_custom_header()->height / get_custom_header()->width * 100; ?>%;
      background-image: url(<?php header_image(); ?>);
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: 100%;
      /*background-position: center;*/
    }

    .main-header .top-nav-container::before {
      padding-bottom: 0;
    }
  </style>
  <?php
  add_editor_style();

  if (get_option('pure_theme_analytics') != '') {
    echo trim(stripslashes(get_option('pure_theme_analytics')));
  }; ?>
</head>

<body <?php body_class('serif'); ?>>
  <header class="main-header">
    <div class="custom-header-background-image" id="customHeaderBackgroundImage">
    </div>
    <div class="header-content-wrap">
      <div class="main-header-content">
        <div class="blog-info-wrap">
          <?php the_custom_logo(); ?>

          <div class="split-line"></div>

          <div class="blog-title-desc-wrap serif">
            <a class="home-link" href="<?php echo esc_url(home_url('/')); ?>">
              <h1 class="blog-title">
                <?php bloginfo("title") ?>
              </h1>
            </a>

            <h2 class="blog-description">
              <?php bloginfo("description") ?>
            </h2>
          </div>
        </div>
      </div>
      <nav class="top-nav-container" id="topNavigationContainer">
        <?php
        wp_nav_menu(array(
          'theme_location'  => 'header_menu',
          'menu'            => 'header-menu',
          'menu_class'      => 'top-menu',
          'menu_id'         => 'topMenu',
          // 'container'       => '',
          // 'container_class' => '',
          // 'container_id'    => '',
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

    </div>
  </header>
