<?php
if (!defined('ABSPATH')) exit;

require_once 'metabox.php';
require_once 'shortcode.php';
require_once 'widget.php';

function theme_enqueueGaleriaBackend() {
    wp_enqueue_script('backend', ASSETS_URI_JS . 'backend-galeria.js', array('jquery'), VERSION_THEME, true);
}
add_action('admin_enqueue_scripts', 'theme_enqueueGaleriaBackend');
