<?php
if (!defined('ABSPATH')) exit;

require_once 'metabox.php';
require_once 'shortcode.php';
require_once 'widget.php';

add_action('add_meta_boxes', 'registrarMetaboxGaleria');
add_action('save_post', 'guardarMetaboxGaleria', 1, 1);
add_shortcode('galeria', 'mostrarGaleria');
add_action('widgets_init', 'registrarWidgetGaleria');

function theme_enqueueGaleriaBackend() {
    wp_enqueue_script('backend', THEME_URI . 'includes/galeria/backend-galeria.js', array('jquery'), VERSION_THEME, true);
}
add_action('admin_enqueue_scripts', 'theme_enqueueGaleriaBackend');

function theme_enqueueWidgetGaleria() {
    wp_enqueue_style('backend-widget-galeria', ASSETS_URI_CSS . 'backend-widget-galeria.min.css', array(), VERSION_THEME);

    wp_enqueue_script('jquery');
    wp_enqueue_media();
    wp_enqueue_script('backend-widget-galeria', ASSETS_URI_JS . 'widget-galeria.js', array('jquery'), VERSION_THEME);
}
add_action('admin_enqueue_scripts', 'theme_enqueueWidgetGaleria');
