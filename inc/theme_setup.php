<?php 
function theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
    add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

    theme_nav_menu();

    // Imagen de fondo personalizada:
    require THEME_ROOT . 'inc/custom-background.php';

    // Logo personalizado:
    require THEME_ROOT . 'inc/custom-logo.php';

    // set_post_thumbnail_size(320, 320, false);
    // add_image_size('formato', '220', '220', true);

}

function theme_nav_menu() {
    register_nav_menu('principal', 'Menu de cabecera');
}
