<?php

/**
 * Created by PhpStorm.
 * User: hubery
 * Date: 2016/11/3
 * Time: 18:22
 * charset: utf-8
 */

/**
 * theme manifest cache key
 */
const PURE_THEME_MANIFEST_KEY = 'KEY_theme_pure_manifest';
/**
 * track ID
 */
const PURE_THEME_TRACK_UUID_KEY = 'track_uuid';
/**
 * 判断是否为 AMP 模式
 */
function theme_pure_is_amp() {
  return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}

/**
 * @param $avatar
 *
 * @return string|string[]|null
 */
function new_avatar( $avatar ) {
  /**
   * https://gravatar.loli.net/avatar/
   * https://dn-qiniu-avatar.qbox.me/avatar/
   * https://gravatar.bluest.xyz/avatar/
   */
  $replace_url = "https://gravatar.bluest.xyz/avatar/";
  $avatar      = preg_replace( "#(?:http|https):\/\/(secure|\d).gravatar.com\/avatar\/#", $replace_url, $avatar );

  return $avatar;
}

// 替换原来的系统 avatar 函数
add_filter( 'get_avatar', 'new_avatar', 10, 5 );

// Register Top Menu
add_action( 'init', function () {
  register_nav_menus( array(
    'header_menu' => __( '顶部菜单' ),
  ) );
} );

/**
 * 添加 头部 SEO 信息
 */
add_action( 'wp_head', function () {
  global $post;
  // description
  $blog_description = get_bloginfo( 'description' );
  // keywords
  $blog_keywords = "";
  // author ID
  $post_author_id = $post && $post->post_author;
  // blog author
  $blog_author = get_bloginfo( 'admin_email' );
  // ID
  $post_id = get_the_ID();

  if ( get_option( 'pure_theme_index_page_keywords' ) != '' ) {
    $blog_keywords = trim( stripslashes( get_option( 'pure_theme_index_page_keywords' ) ) );
  }

  if ( get_option( 'pure_theme_index_page_description' ) != '' ) {
    $blog_description = trim( stripcslashes( get_option( 'pure_theme_index_page_description' ) ) );
  }

  if ( is_single() ) {
    if ( get_the_excerpt() ) { // 默认读取文章的摘要信息
      $blog_description = get_the_excerpt();
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
    $blog_keywords = join( ',', $blog_keywords );
    $blog_author   = get_the_author_meta( 'display_name', $post_author_id );
  } else if ( is_tag() ) {
    $blog_keywords    = single_tag_title( '', false );
    $blog_description = tag_description();
  } else if ( is_category() ) {
    $blog_keywords    = single_cat_title( '', false );
    $blog_description = category_description();
  }
  echo "
<meta name=\"keywords\" content=\"{$blog_keywords}\">
<meta name=\"description\" content=\"{$blog_description}\">
<meta name=\"author\" content=\"{$blog_author}\">
";
} );

// Register Theme Features
add_action( 'after_setup_theme', function () {

  // Add theme support for Automatic Feed Links
  add_theme_support( 'automatic-feed-links' );

  // 自定义 header
  add_theme_support( 'custom-header', array(
    'default-image'          => get_template_directory_uri() . '/assets/images/header_default.png',
    // Display the header text along with the image
    'header-text'            => true,
    // Header text color default
    'default-text-color'     => '000',
    // Header image width (in pixels)
    'width'                  => 1000,
    // Header image height (in pixels)
    'height'                 => 300,
    'flex-width'             => true,
    'flex-height'            => true,
    // Header image random rotation default
    'random-default'         => false,
    // Enable upload of image file in admin
    'uploads'                => true,
    // function to be called in theme head section
    'wp-head-callback'       => '',
    //  function to be called in preview page head section
    'admin-head-callback'    => 'adminhead_cb',
    // function to produce preview markup in the admin screen
    'admin-preview-callback' => 'adminpreview_cb',
    // video
    'video'                  => true,
  ) );

  // 自定义 logo
  add_theme_support( 'custom-logo', array(
    'height'      => 100,
    'width'       => 100,
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => array( 'site-title', 'site-description' ),
  ) );

  // 自定义背景图片
  add_theme_support( 'custom-background', array(
    'default-color'          => 'FFF',
    'default-image'          => '',
    'default-repeat'         => 'no-repeat',
    'default-position-x'     => 'left',
    'default-position-y'     => 'top',
    'default-size'           => 'auto',
    'default-attachment'     => 'fixed',
    'wp-head-callback'       => '_custom_background_cb',
    'admin-head-callback'    => '',
    'admin-preview-callback' => ''
  ) );

  // 自定义文章类型
  add_theme_support( 'post-formats', array(
    'aside',
    'gallery',
    'link',
    'image',
    'quote',
    'status',
    'video',
    'audio',
    'chart'
  ) );

  // 支持 html 5
  add_theme_support( 'html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
    'script',
    'style',
  ) );

  // 缩略图
  add_theme_support( 'post-thumbnails' );

  // title tag
  add_theme_support( 'title-tag' );

  add_theme_support( 'customize-selective-refresh-widgets' );

  add_theme_support( 'responsive-embeds' );

  add_theme_support( 'responsive-embeds' );

  add_theme_support( 'align-wide' );

  add_theme_support( 'dark-editor-style' );

  add_theme_support( 'disable-custom-colors' );

  add_theme_support( 'disable-custom-font-sizes' );

  add_theme_support( 'editor-color-pallete' );

  add_theme_support( 'editor-font-sizes' );

  add_theme_support( 'editor-styles' );

  // add_theme_support('wp-block-styles');

  //  load_theme_textdomain( 'text_domain', get_template_directory() . '/language' );
} );

/**
 * 支持 svg 上传
 */
add_filter( 'upload_mimes', function ( $mimes = array() ) {
  $mimes['svg'] = 'image/svg+xml';

  return $mimes;
} );

// 已经集成
add_action( 'wp_enqueue_scripts', function () {
  wp_dequeue_style( 'wp-block-library' );
} );

/**
 * Disable the emoji's
 */
function disable_emojis() {
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
  add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}

// add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param array $plugins
 *
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 *
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
  if ( 'dns-prefetch' == $relation_type ) {
    /** This filter is documented in wp-includes/formatting.php */
    $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

    $urls = array_diff( $urls, array( $emoji_svg_url ) );
  }

  return $urls;
}

/**
 * 浏览器是否支持 Webp
 * @return {Boolean}
 */
function is_support_webp() {
  return strstr( $_SERVER['HTTP_ACCEPT'], 'image/webp' );
}

/**
 * 增加图片懒加载
 *
 * @param $content
 *
 * @return null|string|string[]
 */
function add_image_placeholders( $content ) {
  // Don't lazyload for feeds, previews, mobile
  if ( is_feed() ||
       is_preview() ||
       ( function_exists( 'is_mobile' ) && is_mobile() ) ||
       theme_pure_is_amp() ) {
    return $content;
  }

  // Don't lazy-load if the content has already been run through previously
  if ( false !== strpos( $content, 'data-original' ) ) {
    return $content;
  }

  // In case you want to change the placeholder image
  $placeholder_image = apply_filters( 'lazyload_images_placeholder_image', get_template_directory_uri() . '/assets/images/svg-loaders/puff.svg' );

  // This is a pretty simple regex, but it works
  $content = preg_replace(
    '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#',
    sprintf( '<img loading="lazy" ${1}src="%s" data-src="${2}"${3}><noscript><img loading="lazy" ${1}src="${2}"${3}></noscript>', $placeholder_image ),
    $content
  );

  return $content;
}

/**
 * 去除列表页面中文章中的 ID，这是为了防止 mWeb 等工具生成每篇文章的 ID 都是一致的
 *
 * @param $content
 *
 * @return string|string[]|null
 */
function remove_duplicate_id_attribute( $content ) {
  if ( is_single() ) {
    return $content;
  }

  $content = preg_replace(
    '#<h([1-6])([^>]*?)(id="toc_\d+")([^>]*)>([\s\S]*?)</h[1-6]>#',
    '<h${1}${2}${4}>${5}</h${1}>',
    $content
  );

  return $content;
}

add_filter( 'the_content', 'add_image_placeholders', 99 );
add_filter( 'the_content', 'remove_duplicate_id_attribute', 100 );

// 恢复友情链接功能
add_filter( "pre_option_link_manager_enabled", "__return_true" );

/**
 * 添加 embed
 */
function deregister_scripts() {
  wp_deregister_script( 'wp-embed' );
}

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

add_action( 'wp_enqueue_scripts', 'deregister_scripts', 99 );

function pure_setting_page() {
  if ( count( $_POST ) > 0 && isset( $_POST['pure_theme_settings'] ) ) {
    $settings = $_POST;
    foreach ( $settings as $setting => $value ) {
      if ( $setting != 'pure_theme_settings' && $setting != 'Submit' ) {
        $option_key = 'pure_theme_' . $setting;
        delete_option( $option_key );
        add_option( $option_key, trim( $value ) );
      }
    }
  }

  add_menu_page( __( '主题选项' ),
    __( '主题选项' ),
    'edit_themes',
    basename( __FILE__ ),
    'pure_theme_settings'
  );
}

function pure_theme_settings() {
  include get_stylesheet_directory() . '/inc/form.php';
}

add_action( 'admin_menu', 'pure_setting_page' );

/**
 * 添加主题设置选项
 * ios: https://developer.apple.com/design/human-interface-guidelines/ios/icons-and-images/app-icon/
 * chrome: https://developer.chrome.com/multidevice/android/installtohomescreen
 *
 * @param array $sizeSet 尺寸合集
 *
 * @return array
 */
function get_theme_manifest( $sizeSet = array( 128, 144, 152, 192, 256, 512, ) ): array {
  $icons = array();

  if ( has_site_icon() ) {
    foreach ( $sizeSet as $s ) {
      $image_url = get_site_icon_url( $s );
      $file_type = substr( $image_url, - 3 );

      array_push( $icons, array(
        "src"   => $image_url,
        "sizes" => "{$s}x{$s}",
        "type"  => "image/{$file_type}",
      ) );
    }
  }

  $color = get_background_color();
  if ( empty( $color ) ) {
    $color = "#1abc9c";
  } else {
    $color = "#" . $color;
  }

  return array(
    "name"                        => get_bloginfo( 'blogname' ),
    "short_name"                  => substr( get_bloginfo( 'blogname' ), 0, 12 ),
    "description"                 => get_bloginfo( 'description' ),
    "lang"                        => get_bloginfo( 'language' ),
    "dir"                         => is_rtl() ? "rtl" : "ltr",
    "start_url"                   => esc_url( home_url() ),
    "background_color"            => $color,
    "theme_color"                 => $color,
    "display"                     => "standalone",
    "prefer_related_applications" => false,
    "orientation"                 => "portrait",
    "icons"                       => $icons,
  );
}

add_action( 'custom_header_options', function () {
  $manifest = get_theme_manifest();
  wp_cache_set( PURE_THEME_MANIFEST_KEY, $manifest );
} );

add_action( 'rest_api_init', function () {
  /**
   *  支持 service worker
   */
  register_rest_route( 'wp_theme_pure/v1', '/service-worker.js', array(
    'methods'             => WP_REST_Server::READABLE,
    'callback'            => function () {
      ob_start();
      header_remove( "Content-Type" );
      header( 'Content-Type: application/javascript' );
      header( 'Service-Worker-Allowed: /' );
      header( 'cache-control: no-cache, no-store, must-revalidate' );
      header( 'pragma: no-cache' );

      $filePath = get_stylesheet_directory() . '/dist/service-worker.js';

      if ( file_exists( $filePath ) ) {
        return include $filePath;
      }

      ob_end_flush();

      return '';
    },
    'permission_callback' => '__return_true',
  ), true );

  /**
   * PWA 支持 manifest
   */
  register_rest_route( 'wp_theme_pure/v1', '/manifest.json', array(
    'methods'             => WP_REST_Server::READABLE,
    'callback'            => function () {
      header( 'Content-Type: application/manifest+json' );
      header( 'Cache-Control:max-age=86400' );
      $manifest = wp_cache_get( PURE_THEME_MANIFEST_KEY );

      if ( ! $manifest ) {
        $manifest = get_theme_manifest();
        wp_cache_set( PURE_THEME_MANIFEST_KEY, $manifest );
      }

      return $manifest;
    },
    'permission_callback' => '__return_true',
  ) );

  function create_uuid() {
    $str  = md5( uniqid( mt_rand(), true ) );
    $uuid = substr( $str, 0, 8 ) . '-';
    $uuid .= substr( $str, 8, 4 ) . '-';
    $uuid .= substr( $str, 12, 4 ) . '-';
    $uuid .= substr( $str, 16, 4 ) . '-';
    $uuid .= substr( $str, 20, 12 );

    return $uuid;
  }

  function get_real_ip() {
    static $ip = '';
    $ip = $_SERVER['REMOTE_ADDR'];
    if ( isset( $_SERVER['HTTP_CDN_SRC_IP'] ) ) {
      $ip = $_SERVER['HTTP_CDN_SRC_IP'];
    } elseif ( isset( $_SERVER['HTTP_CLIENT_IP'] ) && preg_match( '/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'] ) ) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) and preg_match_all( '#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches ) ) {
      foreach ( $matches[0] as $xip ) {
        if ( ! preg_match( '#^(10|172\.16|192\.168)\.#', $xip ) ) {
          $ip = $xip;
          break;
        }
      }
    }

    return $ip;
  }

  /**
   * 支持 ga 统计
   */
  register_rest_route( 'wp_theme_pure/v1', '/ga', array(
    'methods'             => WP_REST_Server::ALLMETHODS,
    'permission_callback' => '__return_true',
    'callback'            => function () {
      ob_start();
      header( 'status: 204' );
      header( 'cache-control: no-cache, no-store, must-revalidate' );
      header( 'pragma: no-cache' );

      if ( ! isset( $_COOKIE[ PURE_THEME_TRACK_UUID_KEY ] ) ) {
        $uuid = create_uuid();
        setcookie( PURE_THEME_TRACK_UUID_KEY, $uuid, time() + 368400000 );
      } else {
        $uuid = $_COOKIE[ PURE_THEME_TRACK_UUID_KEY ];
      }

      $_REQUEST['tid'] = get_option( 'pure_theme_google_analytics_id' );
      $_REQUEST['cid'] = $uuid;
      $_REQUEST['ua']  = $_SERVER['HTTP_USER_AGENT'];
      $_REQUEST['uip'] = get_real_ip();
      try {
        $user_email = $_COOKIE[ 'comment_author_email_' . COOKIEHASH ];
      } catch ( Exception $ex ) {
        $user_email = false;
      }

      if ( $user_email ) {
        $_REQUEST['uid'] = $user_email;
      }

      $post_data = '';
      foreach ( $_REQUEST as $key => $value ) {
        $post_data .= ( $key . '=' . rawurlencode( rawurldecode( $value ) ) . '&' );
      }
      $post_data .= ( 'z=' . time() );
      $url       = 'https://www.google-analytics.com/collect';

      if ( function_exists( "fastcgi_finish_request" ) ) {
        fastcgi_finish_request(); // 对于 fastcgi 会提前返回请求结果，提高响应速度。
      }

      $curl = curl_init();
      curl_setopt_array( $curl, array(
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => "",
        // CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT        => 1,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => "POST",
        CURLOPT_POSTFIELDS     => $post_data,
        CURLOPT_TCP_FASTOPEN   => true,
        CURLOPT_HTTPHEADER     => array(
          'Accept-Encoding' => 'gzip',
          'cookie'          => $_COOKIE,
          'User-Agent'      => $_SERVER['HTTP_USER_AGENT'] . '',
        ),
      ) );

      $response = curl_exec( $curl );
      $err      = curl_error( $curl );
      curl_close( $curl );

      ob_end_flush();

      if ( $err ) {
        return array(
          'msg' => 'bad req',
        );
      } else {
        return array(
          'msg' => 'ok',
//          'a' => $_SERVER['HTTP_USER_AGENT'],
//          'body' => $_REQUEST,
//          'res'  => $response,
//          'res'  => $url . '?' . $post_data
        );
      }
    },
  ), true );
} );


//add_option('pure_theme_pwa_cache_version', get_option('pure_theme_pwa_cache_version') + 0);
// add_option('pure_theme_pwa_cache_version', 1);
