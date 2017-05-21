<?php
if (!defined('ABSPATH')) exit;

class SVG {
    static function normalizarAtributos($atts)
    {
        if (is_string($atts)) {
            $atts = array('nombre' => $atts);
        } else if (!is_array($atts)) {
            $atts = array();
        }

        $default = array(
            'nombre'     => '',
            'contenedor' => '%s',
            );

        return shortcode_atts($default, $atts, 'icono');
    }

    /**
     * Retorna un elemento SVG con un ID que debería coincidir
     * con uno definido en el archivo SVG cargado.
     * @param  string  $nombre    Nombre del ID del icono
     * @return string             Retorna un elemento SVG
     */
    static function retornar($atts = array())
    {
        extract(self::normalizarAtributos($atts));

        if (!$nombre) return '';

        if (is_file(ASSETS_DIR_SVG . $nombre . '.svg')) {
            $elemento = file_get_contents(ASSETS_DIR_SVG . $nombre . '.svg');
            return sprintf($contenedor, $elemento);
        }

        $formato = '<svg class="icono icono-%1$s" role="img">'
                    . ' <use href="#%1$s" xlink:href="#%1$s"></use> '
                . '</svg>';
        $elemento = sprintf($formato, sanitize_title($nombre));
        return sprintf($contenedor, $elemento);
    }
    /**
     * Muestra el retorno de retornarSVG.
     * @param  string  $nombre    Nombre del ID del icono
     */
    static function mostrar($atts = array())
    {
        echo self::retornar($atts);
    }

    /**
     * Imprime el sprite de iconos
     */
    static function mostrarSprite()
    {
        $ruta = ASSETS_DIR_SVG . 'sprite.svg';
        if (is_file($ruta)) {
            printf(
                '<div style="display: none; visibility: hidden">%s</div>',
                file_get_contents($ruta)
            );
        }
    }
}

add_shortcode('icono', array('SVG', 'retornar'));
add_action('post_body', array('SVG', 'mostrarSprite'));
