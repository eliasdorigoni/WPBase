<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
define('HOME_URL', esc_url(home_url()) . '/');
define('THEME_DIR', dirname(__FILE__) . DS);
define('THEME_URI', esc_url(get_stylesheet_directory_uri()) . '/');
define('DISALLOW_FILE_EDIT', true);
define('VERSION', '1.0.0');

define('ASSETS_DIR',      THEME_DIR  . 'assets' . DS);
define('ASSETS_CSS_DIR',  ASSETS_DIR . 'css' . DS);
define('ASSETS_JS_DIR',   ASSETS_DIR . 'js' . DS);
define('ASSETS_IMG_DIR',  ASSETS_DIR . 'img' . DS);
define('ASSETS_SVG_DIR',  ASSETS_DIR . 'svg' . DS);

define('ASSETS_URI',      THEME_URI  . 'assets/');
define('ASSETS_CSS_URI',  ASSETS_URI . 'css/');
define('ASSETS_JS_URI',   ASSETS_URI . 'js/');
define('ASSETS_IMG_URI',  ASSETS_URI . 'img/');
define('ASSETS_SVG_URI',  ASSETS_URI . 'svg/');

if (!isset($content_width)) {
    $content_width = 625;
}

require THEME_DIR . 'includes/util.php';
require THEME_DIR . 'includes/theme_setup.php';
require THEME_DIR . 'includes/theme_widgets.php';
require THEME_DIR . 'includes/theme_enqueue.php';
require THEME_DIR . 'includes/theme_login.php';

require THEME_DIR . 'includes/shortcode.compartir.php';
require THEME_DIR . 'includes/svg.php';
require THEME_DIR . 'includes/customizer.google-analytics.php';

require THEME_DIR . 'includes/galeria/index.php';
require THEME_DIR . 'includes/redes-sociales/index.php';

require THEME_DIR . 'includes/widget.contenido.php';

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
