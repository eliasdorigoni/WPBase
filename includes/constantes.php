<?php
if (!defined('ABSPATH')) exit;

$theme = wp_get_theme();
if (is_child_theme()) {
    $theme = wp_get_theme($theme->parent_theme);
}
define('VERSION_THEME', $theme->display('Version'));

$pluginsActivos = apply_filters('active_plugins', get_option('active_plugins'));
define('WOOCOMMERCE_ACTIVO', (in_array('woocommerce/woocommerce.php', $pluginsActivos)));

define('HOME_URL', esc_url(home_url()) . '/');
define('THEME_DIR', get_template_directory() . DS);
define('THEME_URI', esc_url(get_stylesheet_directory_uri()) . '/');
define('DISALLOW_FILE_EDIT', true);

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
