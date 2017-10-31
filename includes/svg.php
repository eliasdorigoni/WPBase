<?php
if (!defined('ABSPATH')) exit;

/**
 * Utiliza la clave 'nombre' para retornar un elemento SVG de HTML.
 * Si existe un archivo SVG con el mismo nombre de archivo, retorna el contenido
 * del archivo.
 * Sino se retorna un elemento SVG que linkea a un ID, que debería existir 
 * en el sprite de iconos mostrado por SVG::mostrarSprite().
 * @param  string/array $atts Configuración del retorno.
 * @return string             Retorna un elemento SVG.
 */
function retornarSVG($atts = array()) {
    $default = array(
        'nombre'     => '',
        'contenedor' => '%s',
    );

    if (is_string($atts)) {
        $atts = array('nombre' => $atts);
    } else if (!is_array($atts)) {
        $atts = array();
    }

    extract(shortcode_atts($default, $atts, 'icono'));

    if (!$nombre) {
        return 'Debe especificar un nombre de ícono';
    }

    if (is_file(ASSETS_DIR_SVG . $nombre . '.svg')) {
        return sprintf($contenedor, file_get_contents(ASSETS_DIR_SVG . $nombre . '.svg'));
    }

    $formato = '<svg class="icono icono-%1$s" role="img">'
                . ' <use href="#%1$s" xlink:href="#%1$s"></use> '
            . '</svg>';
    $elemento = sprintf($formato, sanitize_title($nombre));
    return sprintf($contenedor, $elemento);
}
add_shortcode('icono', 'retornarSVG');

/**
 * Imprime el retorno de retornarSVG().
 * @param string/array $atts  Nombre del icono o array de configuracion.
 */
function mostrarSVG($atts = array())
{
    echo retornarSVG($atts);
}

/**
 * Imprime el sprite de iconos generado por Grunt
 */
function mostrarSpriteSVG()
{
    $ruta = ASSETS_DIR_SVG . 'sprite.svg';
    if (is_file($ruta)) {
        printf(
            '<div style="display: none; visibility: hidden">%s</div>',
            file_get_contents($ruta)
        );
    }
}
add_action('pre_header', 'mostrarSpriteSVG');
