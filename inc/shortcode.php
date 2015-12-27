<?php

/*
    Nota #1: todas las funciones deben devolver el contenido, no mostrarlo.
    Nota #2: echo do_shortcode(['mi-shortcode']);

 */

class ThemeShortcode
{
    function __construct($shortcode, $funcion)
    {
        add_shortcode($shortcode, array($this, $funcion));
    }

    private function _miShortcode($atts)
    {
        $atts = shortcode_atts( array(
            'foo' => 'something',
            'bar' => 'something else',
        ), $atts );
    }

    private function _otroShortcode($atts, $content)
    {
        $atts = shortcode_atts( array(
            'foo' => 'something',
            'bar' => 'something else',
        ), $atts );
    }
}

new ThemeShortcode('mi-shortcode','_miShortcode');
new ThemeShortcode('otro-shortcode','_otroShortcode');

