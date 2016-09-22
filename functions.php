<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');

define('THEME_ROOT',      dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('THEME_URI',       get_template_directory_uri());
define('STYLESHEET_URI',  get_stylesheet_directory_uri());
define('HOME_URL',        home_url());
define('SVG_DIR',         'img/svg/'); // relativo a este archivo, con barra al final.

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
