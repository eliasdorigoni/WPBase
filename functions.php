<?php

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
require dirname(__FILE__) . DS . 'includes' . DS . 'constantes.php';

if (!isset($content_width)) $content_width = 625;

require THEME_DIR . 'includes/util.php';
require THEME_DIR . 'includes/theme_setup.php';
require THEME_DIR . 'includes/theme_widgets.php';
require THEME_DIR . 'includes/theme_enqueue.php';

require THEME_DIR . 'includes/svg.php';
require THEME_DIR . 'includes/google-analytics.php';

require THEME_DIR . 'includes/galeria/index.php';
require THEME_DIR . 'includes/class.redes-sociales.php';

require THEME_DIR . 'includes/widget.contenido.php';

add_filter('login_headertitle', 'get_bloginfo');
add_filter('login_headerurl', 'retornarLoginURL');

// Permitir usar shortcodes en widgets.
add_filter('widget_text','do_shortcode');

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
