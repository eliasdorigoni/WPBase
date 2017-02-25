<?php

function mostrarGaleria($atts, $content = '') {
    $default = array(
        'ids' => array(),
        );
    $atts = shortcode_atts($default, $atts);
    preg_match_all('/(\d+)/', $atts['ids'], $m);

    $galeria = $m[0];
    include 'templates/frontend-shortcode.phtml';
}

add_shortcode('galeria', 'mostrarGaleria');
