<?php 
if (!defined('ABSPATH')) exit;

function themeSetup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support(
        'html5',
        array(
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption',
        )
    );
    add_theme_support(
        'post-formats',
        array(
            'aside',
            'gallery',
            'link',
            'image',
            'quote',
            'status',
            'video',
            'audio',
            'chat'
        )
    );
}
add_action('after_setup_theme', 'themeSetup');

function themeNavMenu() {
    register_nav_menu('principal', 'Menu de cabecera');
}
add_action('after_setup_theme', 'themeNavMenu');

function permitirFondoPersonalizado() {
    // %s = get_stylesheet_directory_uri()
    $base = str_replace(get_stylesheet_directory_uri(), '%s', ASSETS_URI_IMG);

    register_default_headers(array(
        'default' => array(
            'url'           => $base . 'fondo.jpg',
            'thumbnail_url' => $base . 'fondo-thumb.jpg',
            ),
        'alt' => array(
            'url'           => $base . 'fondo-alt.jpg',
            'thumbnail_url' => $base . 'fondo-alt-thumb.jpg',
            )
        ));

    add_theme_support('custom-header', array(
        'width'         => 1920,
        'height'        => 1080,
        'default-image' => ASSETS_URI_IMG . 'fondo.jpg',
        'uploads'       => true,
    ));
    // Usar header_image() para obtener la URL de la imagen.
}
add_action('after_setup_theme', 'permitirFondoPersonalizado');

function permitirLogoPersonalizado() {
    add_theme_support('custom-logo', array(
        'height'      => 200,
        'width'       => 400,
        'flex-height' => true,
        // 'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    ));
}
add_action('after_setup_theme', 'permitirLogoPersonalizado');

function cambiarDimensionesImagenes() {
    set_post_thumbnail_size(320, 320, true);
    add_image_size('formato', '220', '220', true);
}
add_action('after_setup_theme', 'cambiarDimensionesImagenes');
