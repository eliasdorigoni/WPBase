<?php 

function theme_setup() {
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');
    // set_post_thumbnail_size(825, 510, true );
    // add_image_size( 'miniatura-foro', 52, 52, true );

    register_nav_menus(array(
        'menu-1' => 'Menu #1',
        'menu-2' => 'Menu #2'
        ));

    add_theme_support('html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ));

    add_editor_style('css/editor-style.css');
}


add_action('after_setup_theme', 'theme_setup');