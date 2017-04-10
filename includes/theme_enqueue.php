<?php
if (!defined('ABSPATH')) exit;

function theme_enqueue() {
    // wp_enqueue_style('custom-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700', array(), null);
    wp_enqueue_style('app', ASSETS_CSS_URI . 'app.min.css', array(), VERSION);

    wp_enqueue_script('jquery');
    wp_enqueue_script('foundation', ASSETS_JS_URI . 'vendor/foundation.min.js', array('jquery'), '6.2.3', true);
    wp_enqueue_script('extend-nav', ASSETS_JS_URI . 'extend/navegacion-responsive.js', array('jquery'), VERSION, true);
    wp_enqueue_script('nav', ASSETS_JS_URI.'vendor/superfish.min.js', array('jquery'), '1.7.9', true);
    wp_enqueue_script('app', ASSETS_JS_URI.'app.js', array('foundation'), VERSION, true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue');

function theme_enqueueBackend() {
    wp_enqueue_style('backend', ASSETS_CSS_URI . 'backend.min.css', array(), VERSION);
    wp_enqueue_script('backend', ASSETS_JS_URI . 'backend-galeria.js', array('jquery'), VERSION, true);
}
add_action('admin_enqueue_scripts', 'theme_enqueueBackend');

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
    wp_enqueue_style('widget-galeria', ASSETS_CSS_URI . 'backend-widget-galeria.min.css', array(), VERSION);

    wp_enqueue_script('jquery');
    wp_enqueue_media();
    wp_enqueue_script('widget-galeria', ASSETS_JS_URI . 'widget-galeria.js', array('jquery'), VERSION);
}
