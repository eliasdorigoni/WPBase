<?php
if (!defined('ABSPATH')) exit;

$theme = wp_get_theme();
define('VERSION_THEME', $theme->display('Version'));

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
define('HOME_URL', esc_url(home_url()) . '/');
define('THEME_DIR', get_template_directory() . DS);
define('THEME_URI', esc_url(get_stylesheet_directory_uri()) . '/');
define('DISALLOW_FILE_EDIT', true);

define('ASSETS_DIR',      THEME_DIR  . 'assets' . DS);
define('ASSETS_DIR_CSS',  ASSETS_DIR . 'css' . DS);
define('ASSETS_DIR_JS',   ASSETS_DIR . 'js' . DS);
define('ASSETS_DIR_IMG',  ASSETS_DIR . 'img' . DS);
define('ASSETS_DIR_SVG',  ASSETS_DIR . 'svg' . DS);

define('ASSETS_URI',      THEME_URI  . 'assets/');
define('ASSETS_URI_CSS',  ASSETS_URI . 'css/');
define('ASSETS_URI_JS',   ASSETS_URI . 'js/');
define('ASSETS_URI_IMG',  ASSETS_URI . 'img/');
define('ASSETS_URI_SVG',  ASSETS_URI . 'svg/');

cargarConstantesDesdeINI(array('WPBASE_GOOGLEMAPS_API_KEY' => ''));
