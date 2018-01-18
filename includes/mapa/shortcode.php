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

    $atts['tipo'] = strtolower($atts['tipo']);
    $tiposValidos = array('hybrid', 'roadmap', 'satellite', 'terrain');
    if (!in_array($atts['tipo'], $tiposValidos)) {
        $atts['tipo'] = 'satellite';
    }

    $marcadores = esc_attr(convertirMarcadores($contenido));

    return sprintf(
        '<div id="js-mapa" class="%s" data-mapa data-zoom="%s" data-tipo="%s" data-marcadores="%s"></div>',
        $atts['class'],
        $atts['zoom'],
        $atts['tipo'],
        $marcadores
    );
}

function convertirMarcadores($string) {
    // Elimina espacios al principio, al final, saltos de línea y espacios dobles.
    $string = trim($string);
    $string = preg_replace('/( {2,}|[\r\n])/', '', $string);

    // Procesa los marcadores que estén dentro.
    $marcadores = do_shortcode($string);

    // Elimina la última coma y simula un array de json
    $json = '[' . rtrim($marcadores, ',') . ']';

    // Retorna un array de marcadores.
    return $json;
}

function limpiarCoordenadas($string) {
    $array = explode(',', $string);
    $array = array_map('trim', $array);
    $array = array_map('floatval', $array);
    $array = array_filter($array);
    return $array;
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

    $coordenadas = limpiarCoordenadas($atts['coordenadas']);

    $icono = '';
    if ($atts['icono'] !== 'default') {
        $icono = $atts['icono'];
    }

    $url = '';
    if ($atts['enlazar-indicaciones'] == 1) {
        $query = array(
            'api' => 1,
            'destination' => implode(',', $coordenadas),
            'travelmode' => 'driving',
        );
        $url = 'https://www.google.com/maps/dir/?' . http_build_query($query);
    }

    $retorno = array(
        'titulo' => $atts['titulo'],
        'contenido' => $atts['contenido'],
        'coordenadas' => $coordenadas,
        'icono' => $icono,
        'url' => $url,
    );

    return json_encode($retorno) . ',';
}
