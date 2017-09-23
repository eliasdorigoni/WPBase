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

    // Foundation custom
    wp_register_script('foundation', ASSETS_URI_JS . 'vendor/foundation.min.js', array('jquery'), '6.2.3', true);

    // Script principal del frontend
    wp_register_script('app', ASSETS_URI_JS.'app.min.js', array('foundation'), VERSION_THEME, true);
    
    // Slick - https://github.com/kenwheeler/slick/
    wp_register_script('slick', ASSETS_URI_JS . 'vendor/slick.min.js', array('jquery'), '1.7.1', true);
    wp_register_script('slick-cdn', '//cdn.jsdelivr.net/gh/kenwheeler/slick@1.7.1/slick/slick.min.js', array('jquery'), '1.7.1', true);

    // Lightbox - https://github.com/lokesh/lightbox2/
    wp_register_script('lightbox', ASSETS_URI_JS . 'vendor/lightbox.min.js', array('jquery'), '2.8.2', true);

    // Google Maps - https://developers.google.com/maps/?hl=es-419
    // Llamar a 'gmaps' en el enqueue.
    $args = array(
        'key' => WPBASE_GOOGLEMAPS_API_KEY,
        'callback' => 'initMap',
    );
    wp_register_script('mapa', ASSETS_URI_JS . 'mapa.js', array(), VERSION_THEME, true);
    wp_register_script('gmaps', 'https://maps.googleapis.com/maps/api/js?' . http_build_query($args), array('jquery', 'mapa'), null, true);
    wp_localize_script('gmaps', 'WPURLS', array(
        'home_url'  => HOME_URL,
        'theme_uri' => THEME_URI,
    ));

    // Estilos del backend (galeria, etc.)
    wp_register_style('backend', ASSETS_URI_CSS . 'backend.min.css', array(), VERSION_THEME);

    // Estilos del login
    wp_register_style('custom-login', ASSETS_URI_CSS . 'login.min.css');
}
add_action('wp_enqueue_scripts', 'registrarLibrerias', 1);
