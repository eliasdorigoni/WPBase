<?php 
/**
 * Permite mostrar un mapa con uno o más marcadores usando el shortcode [mapa][/mapa]
 * con uno o más [marcador] como contenido del primero.
 *
 * Requiere generar un API válido y escribirlo en theme/config.ini
 */

namespace Mapa;
if (!defined('\ABSPATH')) exit;

/**
 * Registra el mapa de google y algunas variables.
 * Se agrega al queue al procesar el primer [mapa].
 */
function registrarScripts() {
    \definirConstantesDesdeINI(array('GOOGLE_MAPS_API_KEY' => ''), THEME_DIR . 'config.ini');

    $url = 'https://maps.googleapis.com/maps/api/js?';
    $url .= http_build_query(array(
        'key'      => \GOOGLE_MAPS_API_KEY,
        'callback' => 'initMap',
    ));

    wp_register_script('google-maps', $url, array('jquery', 'app'), null, true);
    wp_localize_script('google-maps', 'WPURLS', array('home_url'  => \HOME_URL, 'theme_uri' => \THEME_URI));
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\registrarScripts', 1);

/**
 * Retorna un <div> que contiene el mapa.
 * @param  array  $atts
 * @param  string $contenido
 * @return string
 */
function retornarMapa($atts = array(), $contenido = '') {
    $default = array(
        'class' => 'mapa',
        'tipo'  => '',
        'zoom'  => 16,
    );

    // Se requiere por lo menos un marcador.
    if (!has_shortcode($contenido, 'marcador')) {
        return;
    }

    // Si el script ya estaba en el queue, se ignora.
    wp_enqueue_script('google-maps');

    $atts = shortcode_atts($default, $atts, 'mapa');

    $atts['class'] = esc_attr($atts['class']);

    $atts['tipo'] = strtolower($atts['tipo']);
    $tiposValidos = array(
        'satellite',
        'hybrid',
        'roadmap',
        'terrain',
    );
    if (!in_array($atts['tipo'], $tiposValidos)) {
        $atts['tipo'] = $tiposValidos[0];
    }

    $marcadoresJSON = esc_attr(extraerMarcadores($contenido));

    return sprintf(
        '<div id="js-mapa" class="%s" data-mapa data-zoom="%s" data-tipo="%s" data-marcadores="%s"></div>',
        $atts['class'],
        $atts['zoom'],
        $atts['tipo'],
        $marcadoresJSON
    );
}
add_shortcode('mapa', __NAMESPACE__ . '\retornarMapa');

/**
 * Retorna marcadores en formato JSON. Pensado para utilizar dentro de [mapa]
 * @param  array  $atts
 * @return string (json)
 */
function retornarMarcador($atts = array()) {
    $default = array(
        'contenido'            => '',
        'coordenadas'          => '',
        'enlazar-indicaciones' => 0,
        'icono'                => 'default',
        'titulo'               => '',
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
        'titulo'      => $atts['titulo'],
        'contenido'   => $atts['contenido'],
        'coordenadas' => $coordenadas,
        'icono'       => $icono,
        'url'         => $url,
    );

    return json_encode($retorno) . ',';
}
add_shortcode('marcador', __NAMESPACE__ . '\retornarMarcador');

/**
 * Recibe una cadena con shortcodes de uno o más [marcador], y retorna un
 * array en JSON
 * @param  string $string [description]
 * @return [type]         [description]
 */
function extraerMarcadores($string = '') {
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

// Utilidades
function limpiarCoordenadas($string) {
    $array = explode(',', $string);
    $array = array_map('trim', $array);
    $array = array_map('floatval', $array);
    $array = array_filter($array);
    return $array;
}

