<?php
namespace Mapa;

function retornarMapa($atts = array(), $contenido = '') {
    if (!has_shortcode($contenido, 'marcador')) {
        return;
    }

    $default = array(
        'class' => 'mapa',
        'tipo'  => '',
        'zoom'  => 16,
    );
    $atts = shortcode_atts($default, $atts, 'mapa');

    $atts['class'] = esc_attr($atts['class']);

    $atts['tipo'] = strtoupper($atts['tipo']);
    $tiposValidos = array('HYBRID', 'ROADMAP', 'SATELLITE', 'TERRAIN');
    if (!in_array($atts['tipo'], $tiposValidos)) {
        $atts['tipo'] = 'SATELLITE';
    }

    $marcadores = esc_attr(json_encode(convertirMarcadores($contenido)));

    return sprintf(
        '<div id="js-mapa" class="%s" data-mapa data-zoom="%s" data-tipo="%s" data-marcadores="%s"></div>',
        $atts['class'],
        $atts['zoom'],
        $atts['tipo'],
        $marcadores
    );
}

function convertirMarcadores($string) {
    $string = trim($string);
    $string = preg_replace('/( {2,}|[\r\n])/', '', $string); // Elimina espacios y nuevas lineas
    $string = do_shortcode($string);
    $string = trim($string, ',');
    $string = json_decode('['.$string.']', true);
    return $string;
}

function retornarMarcador($atts = array()) {
    $default = array(
        'contenido' => '',
        'coordenadas' => '',
        'enlazar-indicaciones' => 0,
        'icono' => 'default',
        'titulo' => '',
    );
    $atts = shortcode_atts($default, $atts, 'marcador');

    $coordenadas = explode(',', $atts['coordenadas']);
    $coordenadas = array_map('trim', $coordenadas);
    $coordenadas = array_map('floatval', $coordenadas);
    $coordenadas = array_filter($coordenadas);

    if ($atts['icono'] === 'default') {
        $icono = '';
    } else {
        $icono = $atts['icono'];
    }

    $url = '';
    if ($atts['enlazar-indicaciones'] == 1) {
        $url = 'https://www.google.com/maps/dir/?' 
            . http_build_query(
                array(
                    'api' => 1,
                    'destination' => implode(',', $coordenadas),
                    'travelmode' => 'driving',
                )
            );
    }

    return json_encode(
            array(
                'titulo' => $atts['titulo'],
                'contenido' => $atts['contenido'],
                'coordenadas' => $coordenadas,
                'icono' => $icono,
                'url' => $url,
            )
        ) . ',';
}
