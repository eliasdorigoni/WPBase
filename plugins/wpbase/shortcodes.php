<?php
if (!defined('ABSPATH')) exit;

/**
 * Muestra botones para compartir una página.
 * @param  array $atts  Redes sociales el
 * @return [type]       [description]
 */
function shortcodeCompartir($atts = array()) {
    $args = shortcode_atts(array(
        'mostrar' => 'facebook,twitter,googleplus,whatsapp',
        ), $atts);
    $redesMostradas = explode(',', $args['mostrar']);
    $retorno = array();

    // Clase del tag, url, nombre, contenido del tag
    $formato = '<a class="%s" href="%s" onclick="return !window.open(this.href, \'%s\', \'width=640,height=580\')">%s</a>';

    // Se los pasa por un loop para poder elegir el orden desde el shortcode.
    $permalink = get_the_permalink();
    $shortlink = wp_get_shortlink();

    foreach ($redesMostradas as $item) {
        if ($item == 'facebook') {
            $nombre = 'Facebook';
            $contenido = retornarSVG('facebook');
            $query = http_build_query(array(
                'u'       => $permalink,
                'display' => 'popup',
                'ref'     => 'plugin',
                'src'     => 'share_button'
                ));
            $url = 'https://www.facebook.com/sharer/sharer.php?' . $query;
            $retorno[] = sprintf($formato, 'compartir ' . $item, $url, $nombre, $contenido);
        }

        if ($item == 'twitter') {
            $nombre = 'Twitter';
            $contenido = retornarSVG('twitter');
            $query = http_build_query(array(
                'status' => $shortlink,
                ));
            $url = 'https://twitter.com/home?' . $query;
            $retorno[] = sprintf($formato, 'compartir ' . $item, $url, $nombre, $contenido);
        }
        
        if ($item == 'googleplus') {
            $nombre = 'Google Plus';
            $contenido = retornarSVG('google-plus');
            $query = http_build_query(array(
                'url' => get_the_permalink(),
                ));
            $url = 'https://plus.google.com/share?';
            $retorno[] = sprintf($formato, 'compartir ' . $item, $url . $query, $nombre, $contenido);
        }

        if ($item == 'whatsapp') {
            $nombre = 'WhatsApp';
            $contenido = retornarSVG('whatsapp');
            $query = http_build_query(array(
                'text' => get_the_permalink(),
                ));
            $url = 'whatsapp://send?' . $query;
            $retorno[] = sprintf('<a class="%s" href="%s" rel="nofollow">%s</a>', 'compartir ' . $item, $url, $contenido);
        }
    }

    return implode('', $retorno);
}
add_shortcode('compartir', 'shortcodeCompartir');
