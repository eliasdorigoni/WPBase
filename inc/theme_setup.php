<?php 
function theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
    add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

    // %s = get_stylesheet_directory_uri()
    register_default_headers(array(
        'default' => array(
            'url'           => '%s/img/fondo.jpg',
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
        'default-image' => STYLESHEET_URI . '/img/fondo.jpg',
        'uploads'       => true,
    ));

    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    ));

    set_post_thumbnail_size(624, 9999); // Altura ilimitada, soft crop
    // add_editor_style('css/editor-style.css');
    register_nav_menu('principal', 'Menu de cabecera');

    add_image_size('formato', '220', '220', true);
}
