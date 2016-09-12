<?php

function cb_shortcode($atts = array()) {
    $atts = shortcode_atts( array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $atts );

    return 'string';
}
add_shortcode('id-shortcode', 'cb_shortcode');
// echo do_shortcode('[id-shortcode]');
