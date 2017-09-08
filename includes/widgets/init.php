<?php
if (!defined('ABSPATH')) exit;

require 'util.php';
require 'contenido.php';

function theme_widgets() {
    register_sidebar(array(
        'name'          => 'Barra lateral',
        'id'            => 'barra-lateral',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>'
    ));
    register_sidebar(array(
        'name'          => 'Footer',
        'id'            => 'footer',
        'description'   => 'Columnas en footer.',
        'before_widget' => '<div id="%1$s" class="column widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>'
    ));
    register_sidebar(array(
        'name'          => 'Ejemplo',
        'id'            => 'ejemplo',
        'description'   => 'Columnas en footer.',
        'before_widget' => '<div id="%1$s" class="column widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>'
    ));
}
add_action('widgets_init', 'theme_widgets');

add_action('widgets_init', 'cargar_widget_contenido');
