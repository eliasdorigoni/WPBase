<?php
if (!defined('ABSPATH')) exit;

function shortcodeSVG($atts = array()) {
    $default = array(
        'nombre' => '',
        'incrustar' => 'true'
        );
    $atts = shortcode_atts($default, $atts);

    return retornarSVG($atts['nombre'], $atts['incrustar']);
}
add_shortcode('svg', 'shortcodeSVG');
