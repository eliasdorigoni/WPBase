<?php
if (!defined('ABSPATH')) exit;

/*
 * @const WPBASE_GOOGLEMAPS_API_KEY string
 */
function registrarLibrerias() {
    // Fuentes
    wp_register_style('google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700', array(), null);

    // Estilo principal del frontend. Incluye foundation.
    wp_register_style('app', ASSETS_URI_CSS . 'app.min.css', array('google-fonts'), VERSION_THEME);

    // Script principal del frontend
    wp_register_script('app', ASSETS_URI_JS.'app.min.js', array('jquery'), VERSION_THEME, true);
    
    // Slick - https://github.com/kenwheeler/slick/
    wp_register_script('slick', ASSETS_URI_JS . 'vendor/slick.min.js', array('jquery'), '1.7.1', true);
    wp_register_script('slick-cdn', '//cdn.jsdelivr.net/gh/kenwheeler/slick@1.7.1/slick/slick.min.js', array('jquery'), '1.7.1', true);

    // Lightbox - https://github.com/lokesh/lightbox2/
    wp_register_script('lightbox', ASSETS_URI_JS . 'vendor/lightbox.min.js', array('jquery'), '2.8.2', true);

    // Backend
    wp_register_style('backend', ASSETS_URI_CSS . 'backend.min.css', array(), VERSION_THEME);

    // Login
    wp_register_style('custom-login', ASSETS_URI_CSS . 'login.min.css');
}
add_action('init', 'registrarLibrerias');
