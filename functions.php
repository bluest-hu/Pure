<?php
/**
 * Created by PhpStorm.
 * User: hubery
 * Date: 2016/11/3
 * Time: 18:22
 */


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
		'height'                 => 500,
		// Header image random rotation default
		'random-default'         => false,
		// Enable upload of image file in admin
		'uploads'                => true,
		// function to be called in theme head section
		'wp-head-callback'       => 'wphead_cb',
		//  function to be called in preview page head section
		'admin-head-callback'    => 'adminhead_cb',
		// function to produce preview markup in the admin screen
		'admin-preview-callback' => 'adminpreview_cb',
	) );


	// 自定义 logo
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 400,
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

	add_theme_support( 'post-thumbnails', array() );
}


add_action( 'after_setup_theme', 'custom_theme_features' );

