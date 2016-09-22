<?php
/**
 * Se puede definir una constante para diferenciar un entorno 
 * de trabajo local de uno de producción.
 * 
 * Se envuelve en function_exists() porque también es útil en plugins.
 */
if (!function_exists('esServerLocal')) {
    function esServerLocal() {
        return (defined('LOCAL') && LOCAL === true) ? true : false;
    }
}

/**
 * Agrega el slug del post a las clases HTML.
 */
function theme_agregarSlugClase($classes) {
    global $post;
    if (isset($post)) {
        $classes[] = $post->post_type . '-' . $post->post_name;
        $classes[] = $post->post_name;
    }
    return $classes;
}
add_filter('body_classes', 'theme_agregarSlugClase');

/**
 * Busca un archivo SVG a partir del nombre del archivo (sin extension).
 * Retorna un array con la URL y el contenido si lo encontró, o false si no lo encontró.
 * @param  string $slug  Nombre del archivo
 * @return arr/bool      Array con la url y el contenido, o false.
 */
function buscarSVG($nombre = '') {
    $ruta = SVG_DIR . $nombre . '.svg';
    
    if (is_string($nombre) && strlen($nombre) > 0 && is_file(THEME_ROOT . $ruta)) {
        return array(
            'url' => STYLESHEET_URI . $ruta,
            'contenido' => file_get_contents(THEME_ROOT . $ruta)
            );
    }

    return false;
}

/**
 * Retorna un archivo SVG a partir del nombre (sin extension ni ruta), incrustado 
 * dentro de etiquetas span o enlazazo en una etiqueta img
 * @param  string  $nombre    Nombre del archivo svg
 * @param  boolean $incrustar Pone el contenido dentro de <span> o lo enlaza en <img>.
 *                            Por defecto true
 * @return string             Retorna el contenido o un string vacío.
 */
function retornarSVG($nombre = '', $incrustar = true) {
    $retorno = '';
    $svg = buscarSVG($nombre);
    if ($svg) {
        $formato = '<span class="svg %1$s">%2$s</span>';
        if (!$incrustar) $formato = '<img class="svg %1$s" src="%3$s" />';

        $retorno = sprintf($formato, $nombre, $svg['contenido'], $svg['url']);
    }

    return $retorno;
}

/**
 * Muestra el retorno de retornarSVG.
 * @param  string  $nombre    Nombre del archivo svg.
 * @param  boolean $incrustar Pone el contenido dentro de <span> o lo enlaza en <img>.
 * @return void
 */
function mostrarSVG($nombre, $incrustar = true) {
    echo retornarSVG($nombre, $incrustar);
}

/**
 * Retorna el nombre de la taxonomia dentro de una plantilla de taxonomía.
 * @return string  Nombre de la taxonomia
 */
if (!function_exists('get_the_taxonomy_title')) {
    function get_the_taxonomy_title() {
        if(is_tax()) {
            global $wp_query;
            $term = $wp_query->get_queried_object();
            return $term->name;
        }
    }
}

/**
 * Limpia el contenido de un textarea respetando las lineas nuevas.
 * @param  string $string Cadena a limpiar
 * @return string         Cadena limpia con lineas nuevas.
 */
if (!function_exists('sanitize_textarea')) {
    function sanitize_textarea($string = '') {
        $fake_newline = '###_LINE_BREAK_###';
        $escaped_newlines = str_replace("\n", $fake_newline, $string);
        $sanitized = sanitize_text_field($escaped_newlines);
        $restored = str_replace($fake_newline, "\n", $sanitized);

        return $restored;
    }
}

/**
 * Retorna una etiqueta <a> preparada con los datos de la $redSocial elegida,
 * opcionalmente con $contenido dentro de la etiqueta y una $clase en ella.
 * @param  string $redSocial Una de tres posibilidades con variantes:
 *                               facebook/fb/twitter/tw/google-plus/googleplus/g+
 * @param  string $link      Pagina a compartir (debe ser la actual)
 * @param  string $contenido Contenido opcional del link (normalmente el nombre de la red social)
 * @param  string $clase     Clase del elemento <a>
 * @return string            Boton para compartir.
 */
function retornarLinkCompartir($redSocial, $link, $contenido = '', $clase = '') {
    if (!$clase) $clase = $redSocial;

    switch ($redSocial) {
        case 'facebook':
        case 'fb':
            $nombre = 'Facebook';
            $uri = 'https://www.facebook.com/sharer/sharer.php?'
                . http_build_query(array(
                    'u'       => $link,
                    'display' => 'popup',
                    'ref'     => 'plugin',
                    'src'     => 'share_button'
                    ));
            break;
        case 'twitter':
        case 'tw':
            $nombre = 'Twitter';
            $uri = 'https://twitter.com/home?'
                . http_build_query(array(
                    'status' => $link,
                    ));
            break;
        case 'google-plus':
        case 'googleplus':
        case 'g+':
            $nombre = 'Google Plus';
            $uri = 'https://plus.google.com/share?'
                . http_build_query(array(
                    'url' => $link,
                    ));
            break;
        default:
            return '';
    }

    $formato = '<a class="%s" href="%s" onclick="return !window.open(this.href, \'%s\', \'width=640,height=580\')">%s</a>';

    return sprintf($formato, $clase, $uri, $nombre, $contenido);
}

function agregarFavicon() {
    $formato = '<link rel="%s" href="%s/favicon.ico" type="image/x-icon" />' . "\n";
    printf($formato, 'shortcut icon', STYLESHEET_URI);
    printf($formato, 'icon', STYLESHEET_URI);
}

add_action('wp_head', 'agregarFavicon');
