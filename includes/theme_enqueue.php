<?php
if (!defined('ABSPATH')) exit;

function theme_enqueueCSS() {
    wp_enqueue_style('custom-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700', array(), null);
    wp_enqueue_style('app', ASSETS_CSS_URI . 'app.min.css', array(), '0.1');
}

function theme_enqueueJS() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('foundation', ASSETS_JS_URI . 'vendor/foundation.min.js', array('jquery'), '6.2.3', true );
    wp_enqueue_script('app', ASSETS_JS_URI.'app.js', array('foundation'), '0.1', true );
}

add_action('wp_enqueue_scripts', 'theme_enqueueCSS');
add_action('wp_enqueue_scripts', 'theme_enqueueJS');

/**
 * @link https://github.com/kenwheeler/slick/
 */
function theme_enqueueSlick() {
    wp_enqueue_script('slick', ASSETS_JS_URI . 'vendor/slick.min.js', array('jquery'), '1.6.0', true);
}

/**
 * @link https://github.com/lokesh/lightbox2/
 */
function theme_enqueueLightbox() {
    wp_enqueue_script('lightbox', ASSETS_JS_URI . 'vendor/lightbox.min.js', array('jquery'), '2.8.2', true);
}

function theme_enqueueWidgetGaleria() {
    wp_enqueue_style('widget-galeria', ASSETS_CSS_URI . 'widget-galeria.css', array(), '0.1');

    wp_enqueue_script('jquery');
    wp_enqueue_media();
    wp_enqueue_script('widget-galeria', ASSETS_JS_URI . 'widget-galeria.js', array('jquery'));
}
