<?php
if (!defined('ABSPATH')) exit;

function theme_registrarLibrerias() {
    # @url https://github.com/kenwheeler/slick/
    wp_register_script('slick', ASSETS_URI_JS . 'vendor/slick.min.js', array('jquery'), '1.6.0', true);
    // wp_register_script('slick-cdn', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', array('jquery'), '1.6.0', true);

    # https://github.com/lokesh/lightbox2/
    wp_register_script('lightbox', ASSETS_URI_JS . 'vendor/lightbox.min.js', array('jquery'), '2.8.2', true);

    // https://developers.google.com/maps/?hl=es-419
    $args = array(
        'key' => '',
        'callback' => 'initMap',
    );
    wp_register_script('google-maps', 'https://maps.googleapis.com/maps/api/js?' . http_build_query($args));
    wp_localize_script('google-maps', 'WPURLS', array(
        'home_url'    => HOME_URL,
        'theme_uri' => THEME_URI,
    ));
}
add_action('wp_enqueue_scripts', 'theme_registrarLibrerias');

function theme_enqueueFrontend() {
    // wp_enqueue_style('google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700', array(), null);
    wp_enqueue_style('app', ASSETS_URI_CSS . 'app.min.css', array(), VERSION_THEME);

    wp_enqueue_script('jquery');
    wp_enqueue_script('foundation', ASSETS_URI_JS . 'vendor/foundation.min.js', array('jquery'), '6.2.3', true);
    wp_enqueue_script('extend-nav', ASSETS_URI_JS . 'extend/navegacion-responsive.js', array('jquery'), VERSION_THEME, true);
    wp_enqueue_script('nav', ASSETS_URI_JS.'vendor/superfish.min.js', array('jquery'), '1.7.9', true);
    wp_enqueue_script('app', ASSETS_URI_JS.'app.js', array('foundation'), VERSION_THEME, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueueFrontend');

function theme_enqueueBackend() {
    wp_enqueue_style('backend', ASSETS_URI_CSS . 'backend.min.css', array(), VERSION_THEME);
}
add_action('admin_enqueue_scripts', 'theme_enqueueBackend');

function theme_enqueueSlick() {
    wp_enqueue_script('slick');
}

function theme_enqueueLightbox() {
    wp_enqueue_script('lightbox');
}

function theme_login() {
    wp_enqueue_style('custom-login', ASSETS_URI_CSS . 'login.min.css' );
}
add_action('login_enqueue_scripts', 'theme_login');
