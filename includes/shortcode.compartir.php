<?php
if (!defined('ABSPATH')) exit;

function retornarBotonCompartir($redSocial, $link, $contenido = '', $clase = '') {
    if (!$clase) {
        $clase = 'compartir ' . $redSocial;
    }
    
    $nombre = $uri = '';
    $formato = '<a class="%s" href="%s" onclick="return !window.open(this.href, \'%s\', \'width=640,height=580\')">%s</a>';

    if ($redSocial == 'facebook') {
        if (!$contenido) {
            $contenido = retornarSVG('facebook');
        }
        $query = array(
            'u' => $link,
            'display' => 'popup',
            'ref' => 'plugin',
            'src' => 'share_button'
        );
        $uri = 'https://www.facebook.com/sharer/sharer.php?' . http_build_query($query);
        return sprintf($formato, $clase, $uri, 'Facebook', $contenido);
    }

    if ($redSocial == 'twitter') {
        if (!$contenido) {
            $contenido = retornarSVG('twitter');
        }
        $query = array('status' => $link);
        $uri = 'https://twitter.com/home?' . http_build_query($query);
        return sprintf($formato, $clase, $uri, 'Twitter', $contenido);
    }

    if ($redSocial == 'googleplus') {
        if (!$contenido) {
            $contenido = retornarSVG('google-plus');
        }
        $query = array('url' => $link);
        $uri = 'https://plus.google.com/share?' . http_build_query($query);
        return sprintf($formato, $clase, $uri, 'Google Plus', $contenido);
    }

    if ($redSocial == 'whatsapp') {
        if (!$contenido) {
            $contenido = retornarSVG('whatsapp');
        }
        $query = array('text' => $link);
        $uri = 'whatsapp://send?' . http_build_query($query);
        $formato = '<a class="%s" href="%s" rel="nofollow">%s</a>';
        return sprintf($formato, $clase, $uri, $contenido);
    }

    return '';
}

function shortcodeCompartir($atts = array()) {
    $default = array(
        // Redes sociales a mostrar
        'redes'    => 'facebook,twitter,googleplus,whatsapp',

        // URL a compartir para todas las redes sociales.
        // Por defecto get_the_permalink() o wp_get_shortlink().
        'url'        => '',

        // URLs a compartir para cada red social.
        // Sobreescribe el anterior.
        'facebook'   => '',
        'twitter'    => '',
        'googleplus' => '',
        'whatsapp'   => '',
        );
    extract(shortcode_atts($default, $atts));

    $redes = explode(',', $redes);
    $retorno = array();

    $permalink = get_the_permalink();
    $shortlink = wp_get_shortlink();

    if ($url) $permalink = $shortlink = $url;

    if (!$facebook) $facebook = $permalink;
    if (!$twitter) $twitter = $shortlink;
    if (!$googleplus) $googleplus = $permalink;
    if (!$whatsapp) $whatsapp = $permalink;

    foreach ($redes as $item) {
        $retorno[] = retornarBotonCompartir($item, $$item);
    }

    return implode('', $retorno);
}
add_shortcode('compartir', 'shortcodeCompartir');
