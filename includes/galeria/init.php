<?php
if (!defined('ABSPATH')) exit;

require_once 'metabox.php';
require_once 'shortcode.php';

add_action('add_meta_boxes', 'registrarMetaboxGaleria');
add_action('save_post', 'guardarMetaboxGaleria', 1, 1);
add_shortcode('galeria', 'mostrarGaleria');

function theme_enqueueGaleriaBackend() {
    wp_enqueue_script('jquery');
    wp_enqueue_media();
    wp_enqueue_script('backend', ASSETS_URI_JS . 'backend/galeria.js', array('jquery'), VERSION_THEME, true);
}
add_action('admin_enqueue_scripts', 'theme_enqueueGaleriaBackend');
