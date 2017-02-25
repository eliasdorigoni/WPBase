<?php

function extraerRedes($mostrar, $redesDisponibles) {
    $patron = array();
    foreach ($redesDisponibles as $red) {
        foreach ($red['claves'] as $clave) {
            $patron[] = '('.$clave.')';
        }
    }
    $patron = '/(' . implode('|', $patron) . ')/';

    preg_match_all($patron, $mostrar, $m);
    return $m[0];
}

function mostrarRedesSociales($atts = array()) {
    $atts = shortcode_atts(array(
        'mostrar' => '',
    ), $atts);
    $mostrar = strtolower($atts['mostrar']);
    $redes = explode(',', $mostrar);

    $redesDisponibles = array(
        array(
            'claves' => array('twitter'),
            'option' => 'url-twitter',
            'svg'    => 'twitter',
            ),
        array(
            'claves' => array('facebook'),
            'option' => 'url-facebook',
            'svg'    => 'facebook',
            ),
        array(
            'claves' => array('google-plus', 'googleplus', 'gplus'),
            'option' => 'url-google-plus',
            'svg'    => 'google-plus-nuevo',
            ),
        array(
            'claves' => array('youtube'),
            'option' => 'url-youtube',
            'svg'    => 'youtube',
            ),
        array(
            'claves' => array('instagram'),
            'option' => 'url-instagram',
            'svg'    => 'instagram',
            ),
        );

    $mostrar = extraerRedes($mostrar, $redesDisponibles);

    $retorno = array();
    foreach ($mostrar as $item) {
        $usar = false;
        $enlace = $svg = '';
        foreach ($redesDisponibles as $red) {
            if (!$usar && in_array($item, $red['claves'])) {
                $enlace = get_option($red['option'], false);
                $svg = retornarSVG($red['svg']);
            }
        }

        if ($enlace) {
            $retorno[] = array(
                'enlace' => $enlace,
                'contenido' => $svg,
                );
        }
    }

    if ($retorno) {
        include 'template.frontend.phtml';
    }
}
add_shortcode('redes-sociales', 'mostrarRedesSociales');
