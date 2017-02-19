<?php

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
    'default-image' => ASSETS_IMG_URI . 'fondo.jpg',
    'uploads'       => true,
));

// Usar header_image() para obtener la URL de la imagen.
