<?php
namespace Mapa;

function retornarMapa($atts = array(), $contenido = '') {
    if (!has_shortcode($contenido, 'marcador')) {
        return;
    }
    ob_start();

    $atts = shortcode_atts(
        array(
            'class' => 'mapa',
            'id' => 'js-mapa',
            'tipo' => 'satellite',
            'zoom' => 16,
        ), 
        $atts,
        'mapa'
    );
    ?>
    <script type="text/javascript">
        var configMapa = <?= json_encode(array(
            'marcadores' => convertirMarcadores($contenido),
            'zoom'       => intval($atts['zoom']),
            'tipo'       => $atts['tipo'],
            'idMapa'     => $atts['id'],
        )) ?>
    </script>
    <div id="<?= esc_attr($atts['id']) ?>" class="<?= esc_attr($atts['class']) ?>"></div>
    <?php

    return ob_get_clean();
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
                . http_build_query(array(
                        'api' => 1,
                        'destination' => implode(',', $coordenadas),
                        'travelmode' => 'driving',
                ));
    }

    return json_encode(array(
        'titulo' => $atts['titulo'],
        'contenido' => $atts['contenido'],
        'coordenadas' => $coordenadas,
        'icono' => $icono,
        'url' => $url,
    )) . ',';
}
