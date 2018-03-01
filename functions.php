<?php
/**
 * Created by PhpStorm.
 * User: hubery
 * Date: 2016/11/3
 * Time: 18:22
 */

/**
 * [my_avatar 将 Gavatar 的头像存储在本地，防止伟大的 GFW Fuck Gavatar，反强奸（很不幸已经被墙了）]
 *
 * @param    string $avatar []
 * @param    mixed $id_or_email [id or email]
 * @param    string $size [头像大小]
 * @param    string $default [默认头像地址]
 * @param    boolean/string $alt    [alt文本]
 *
 * @return string    [html img 字符串]
 */
function my_avatar( $avatar, $id_or_email, $size = '96', $default = '', $alt = false ) {
	$email = '';

	if ( is_numeric( $id_or_email ) ) {
		$id   = (int) $id_or_email;
		$user = get_userdata( $id );

		if ( $user ) {
			$email = $user->user_email;
		}
	} elseif ( is_object( $id_or_email ) ) {
		$allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );

		if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types ) ) {
			return false;
		}

		if ( ! empty( $id_or_email->user_id ) ) {
			$id   = (int) $id_or_email->user_id;
			$user = get_userdata( $id );
			if ( $user ) {
				$email = $user->user_email;
			}
		}

		if ( ! $email && ! empty( $id_or_email->comment_author_email ) ) {
			$email = $id_or_email->comment_author_email;
		}
	} else {
		$email = $id_or_email;
	}


	$FOLDER           = '/avatar/';
	$email_md5        = md5( strtolower( trim( $email ) ) );// 对email 进行 md5处理
	$avatar_file_name = $email_md5 . "_" . $size . '.jpg';
	$STORE_PATH       = ABSPATH . $FOLDER; //默认存储地址
	$alt              = ( false === $alt ) ? '' : esc_attr( $alt );
	$avatar_url       = home_url() . $FOLDER . $avatar_file_name; // 猜测在在博客的头像
	$avatar_local     = ABSPATH. $FOLDER . $avatar_file_name;// 猜测本地绝对路径
	$expire           = 604800; //设定7天, 单位:秒
	$r                = get_option( 'avatar_rating' );
	$max_size         = 10240000;
	// 默认的头像 在add_filter get_avatar 会默认传入默认的url;
	$fix_default      = get_stylesheet_directory_uri() . '/assets/image/default_avatar.jpg';

	// 暂时判断目录存在，如果不存在创建，存放的文件夹
	if ( ! is_dir( $STORE_PATH ) ) {
		if ( ! ! mkdir( $STORE_PATH ) ) {
			return null;
		}
	}

	// 判断在本地的头像文件 是否存在或者已经过期
	if ( ! file_exists( $avatar_local ) || ( time() - filemtime( $avatar_local ) ) > $expire ) {

		// 如果不能存在 Gavatar 会返回你设置的地址的头像
		$gavatar_uri = "https://secure.gravatar.com/avatar/" . $email_md5 . '?s=' . $size . '&r=' . $r;

		$response_code = get_http_response_code( $gavatar_uri );

		if ( (integer) $response_code != 200 ) {
			$gavatar_uri = $fix_default;
		}

		copy( $gavatar_uri, $avatar_local );

		// 如果头像大于 10 MB 那么还用默认头像替代
		if ( filesize( $avatar_local ) > $max_size ) {
			@copy( $fix_default, $avatar_local );
		}
	}

	// 增加时间戳 强制 CDN 正确的回源
	$file_make_time = filemtime( $avatar_local );

	$avatar = "<img title='{$alt}' 
					alt='{$alt}' src='{$avatar_url}?&t={$file_make_time}' 
					class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";

	return $avatar;
}

function get_http_response_code( $theURL ) {
	$headers = get_headers( $theURL );

	return substr( $headers[0], 9, 3 );
}

// 替换原来的系统函数
add_filter( 'get_avatar', 'my_avatar', 10, 5 );

if ( ! function_exists( 'utf8Substr' ) ) {
	function utf8Substr( $str, $from, $len ) {
		return preg_replace( '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $from . '}' .
		                     '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $len . '}).*#s',
			'$1', $str );
	}
}

// Register Theme Features
function custom_theme_features() {

	// Add theme support for Automatic Feed Links
	add_theme_support( 'automatic-feed-links' );

	// 自定义 header
	add_theme_support( 'custom-header', array(
		'default-image'          => get_template_directory_uri() . '/images/header_default.png',
		// Display the header text along with the image
		'header-text'            => false,
		// Header text color default
		'default-text-color'     => '000',
		// Header image width (in pixels)
		'width'                  => 1000,
		// Header image height (in pixels)
		'height'                 => 400,
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
		'default-color'          => '#FFF',
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
		'caption'
	) );

	add_theme_support( 'post-thumbnails' );
}

add_action( 'after_setup_theme', 'custom_theme_features' );

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

add_action( 'init', 'disable_emojis' );

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

function add_image_placeholders( $content ) {
	// Don't lazyload for feeds, previews, mobile
	if ( is_feed() || is_preview() || ( function_exists( 'is_mobile' ) && is_mobile() ) ) {
		return $content;
	}

	// Don't lazy-load if the content has already been run through previously
	if ( false !== strpos( $content, 'data-original' ) ) {
		return $content;
	}

	// In case you want to change the placeholder image
	$placeholder_image = apply_filters( 'lazyload_images_placeholder_image', get_template_directory_uri() . '/assets/images/image-pending.gif' );

	// This is a pretty simple regex, but it works
	$content = preg_replace(
		'#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#',
		sprintf( '<img${1}src="%s" data-src="${2}"${3}><noscript><img${1}src="${2}"${3}></noscript>', $placeholder_image ),
		$content );

	return $content;
}

add_filter( 'the_content', 'add_image_placeholders', 99 );