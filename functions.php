<?php
/**
 * Created by PhpStorm.
 * User: hubery
 * Date: 2016/11/3
 * Time: 18:22
 */


if (!function_exists('utf8Substr')) {
    function utf8Substr($str, $from, $len) {
        return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
            '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
            '$1',$str);
    }
}

// 自定义 header
add_theme_support( 'custom-header' ,array(
	'default-image'          => get_template_directory_uri() . '/images/header_default.png',
	'width'                  => 1000,
	'height'                 => 500,
	'flex-height'            => true,
	'flex-width'             => true,
	'uploads'                => true,
	'random-default'         => true,
	'header-text'            => true,
	'default-text-color'     => '#333',
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
));


// 自定义 logo
add_theme_support('custom-logo', array(
	'height'      => 100,
	'width'       => 400,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( 'site-title', 'site-description' ),
));

// 自定义背景图片
add_theme_support( 'custom-background', array(
	'default-color'          => '#FFF',
	'default-image'          => '',
	'default-repeat'         => '',
	'default-position-x'     => '',
	'default-attachment'     => '',
	'wp-head-callback'       => '_custom_background_cb',
	'admin-head-callback'    => '',
	'admin-preview-callback' => ''
));

// 自定义文章类型
add_theme_support('post-formats', array(
	'aside',
	'gallery',
	'link',
	'image',
	'quote',
	'status',
	'video',
	'audio',
	'chart'
));


add_theme_support( 'html5', array(
	'search-form',
	'comment-form',
	'comment-list',
	'gallery',
	'caption'
));

