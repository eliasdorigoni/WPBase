<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
define('HOME_URL',        esc_url(home_url('/')));
define('THEME_ROOT',      dirname(__FILE__) . DS);
define('THEME_URI',       esc_url(get_stylesheet_directory_uri() . '/'));

define('ASSETS_URI',      THEME_URI  . 'assets/');
define('ASSETS_DIR',      THEME_ROOT . 'assets/');
define('ASSETS_CSS_URI',  ASSETS_URI . 'css/');
define('ASSETS_JS_URI',   ASSETS_URI . 'js/');
define('ASSETS_IMG_URI',  ASSETS_URI . 'img/');
define('ASSETS_SVG_DIR',  ASSETS_DIR . 'img/svg/');
define('ASSETS_SVG_URI',  ASSETS_URI . 'img/svg/');

define('DISALLOW_FILE_EDIT', true);

if (!isset($content_width)) $content_width = 625;

require THEME_ROOT . 'inc/helper.php';
require THEME_ROOT . 'inc/utilidades.php';

require THEME_ROOT . 'inc/theme_setup.php';
add_action('after_setup_theme', 'theme_setup');

require THEME_ROOT . 'inc/theme_widgets.php';
add_action('widgets_init', 'theme_widgets');

require THEME_ROOT . 'inc/theme_enqueue.php';
add_action('wp_enqueue_scripts', 'theme_enqueue');

require THEME_ROOT . 'inc/theme_login.php';
add_action('login_enqueue_scripts', 'theme_login');
add_filter('login_headertitle', 'get_bloginfo');
add_filter('login_headerurl', 'home_url');

//////////////
// Limpieza //
//////////////

// Se eliminan emojis
remove_action('wp_head', 'print_emoji_detection_script', 7 );
remove_action('wp_print_styles', 'print_emoji_styles' );

// Se elimina Manifest para Windows Live Writer del head
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

// Se elimina el meta generator
remove_action('wp_head', 'wp_generator');
