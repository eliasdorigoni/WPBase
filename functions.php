<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
define('HOME_URL',        esc_url(home_url()) . '/');
define('THEME_ROOT',      dirname(__FILE__) . DS);
define('THEME_URI',       esc_url(get_stylesheet_directory_uri()) . '/');

define('ASSETS_URI',      THEME_URI  . 'assets/');
define('ASSETS_DIR',      THEME_ROOT . 'assets/');
define('ASSETS_CSS_URI',  ASSETS_URI . 'css/');
define('ASSETS_JS_URI',   ASSETS_URI . 'js/');
define('ASSETS_IMG_DIR',  ASSETS_DIR . 'img/');
define('ASSETS_IMG_URI',  ASSETS_URI . 'img/');
define('ASSETS_SVG_DIR',  ASSETS_DIR . 'img/svg/');
define('ASSETS_SVG_URI',  ASSETS_URI . 'img/svg/');

define('DISALLOW_FILE_EDIT', true);

if (!isset($content_width)) $content_width = 625;

require THEME_ROOT . 'includes/util.php';
require THEME_ROOT . 'includes/theme_setup.php';
require THEME_ROOT . 'includes/theme_widgets.php';
require THEME_ROOT . 'includes/theme_enqueue.php';
require THEME_ROOT . 'includes/theme_login.php';

require THEME_ROOT . 'includes/shortcode.compartir.php';
require THEME_ROOT . 'includes/shortcode.svg.php';

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
