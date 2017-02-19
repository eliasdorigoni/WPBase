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

function themeNavMenu() {
    register_nav_menu('principal', 'Menu de cabecera');
}

function permitirFondoPersonalizado() {
    register_default_headers(array(
        'default' => array(
            'url'           => '%s/img/fondo.jpg', // %s = get_stylesheet_directory_uri()
            'thumbnail_url' => '%s/img/fondo-thumb.jpg',
            ),
        'alt' => array(
            'url'           => '%s/img/fondo-alt.jpg',
            'thumbnail_url' => '%s/img/fondo-alt-thumb.jpg',
            )
        ));

    add_theme_support('custom-header', array(
        'width'         => 1920,
        'height'        => 1080,
        'default-image' => ASSETS_IMG_URI . 'fondo.jpg',
        'uploads'       => true,
    ));
    // Usar header_image() para obtener la URL de la imagen.
}

function permitirLogoPersonalizado() {
    add_theme_support('custom-logo', array(
        'height'      => 200,
        'width'       => 400,
        'flex-height' => true,
        // 'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    ));
}

function cambiarDimensionesImagenes() {
    set_post_thumbnail_size(320, 320, false);
    add_image_size('formato', '220', '220', true);
}

add_action('after_setup_theme', 'themeSetup');
add_action('after_setup_theme', 'themeNavMenu');
// add_action('after_setup_theme', 'permitirFondoPersonalizado');
// add_action('after_setup_theme', 'permitirLogoPersonalizado');
// add_action('after_setup_theme', 'cambiarDimensionesImagenes');
