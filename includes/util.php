<?php
if (!defined('ABSPATH')) exit;

/**
 * Calcula la diferencia entre dos timestamps y retorna un array con las
 * unidades temporales más altas, en orden descendente (año, mes, semana, dia. etc).
 * Sirve para calcular las fechas de "hace x minutos" o "en x semanas".
 * Maneja automáticamente los singulares y plurales.
 * 
 * @param  integer $timestamp Tiempo a comparar, en el pasado o futuro
 * @param  integer $unidades  Unidades temporales a mostrar. 
 *                            Ej: 1 puede devolver "hora", 2 puede devolver
 *                            "semanas" y "dias".
 * @param  integer $comparar  Fecha a comparar. Por defecto, time().
 * @return array              Array de 2 o más valores.
 *                            El primero es un booleano que indica si el tiempo está
 *                            en el futuro. El resto son las unidades temporales.
 */
function fechaTextual($timestamp = 0, $unidades = 2, $comparar = 0) {
    if (!is_numeric($timestamp)) return array();
    if (!$comparar) $comparar = time();
    $diferencia = $comparar - $timestamp;
    $fechaEsFutura = ($diferencia < 0) ? true : false;

    $valores = array(
        'año'     => 0,
        'mes'     => 0,
        'semana'  => 0,
        'dia'     => 0,
        'hora'    => 0,
        'minuto'  => 0,
        'segundo' => 0,
        );

    $constantes = array(
        'año'     => YEAR_IN_SECONDS,
        'mes'     => MONTH_IN_SECONDS,
        'semana'  => WEEK_IN_SECONDS,
        'dia'     => DAY_IN_SECONDS,
        'hora'    => HOUR_IN_SECONDS,
        'minuto'  => MINUTE_IN_SECONDS,
        'segundo' => 1
        );

    foreach ($constantes as $k => $constante) {
        if ($diferencia > $constante) {
            $valores[$k] = floor($diferencia / $constante);
            $diferencia = $diferencia % $constante;
        }
    }

    $retorno = array($fechaEsFutura);

    $plural = array(
        'año'     => 'años',
        'mes'     => 'meses',
        'semana'  => 'semanas',
        'dia'     => 'dias',
        'hora'    => 'horas',
        'minuto'  => 'minutos',
        'segundo' => 'segundos'
        );

    while ($unidades > 0) {
        foreach ($valores as $k => $v) {
            if ($v != 0) {
                $retorno[] = $v . ' ' . plural($v, $k, $plural[$k]);
                unset($valores[$k]);
                break;
            }
            unset($valores[$k]);
        }
        $unidades--;
    }

    return $retorno;
}

/**
 * Elimina los valores de $array1 que estén en $array2 y reordena las
 * claves. Retorna $array1 sin las claves que coincidan en $array2.
 * @param  array  $array1 Array a retornar.
 * @param  array  $array2 Array de referencia para buscar los duplicados.
 * @return array          Retorna $array1 sin los valores de $array2
 */
function eliminarDuplicadosDeArray($array1 = array(), $array2 = array()) {
    if (is_array($array1) && is_array($array2)) {
        foreach ($array2 as $valor) {
            $clave = array_search($valor, $array1);
            if($clave !== false) {
                unset($array1[$clave]);
            }
        }
        array_values($array1);
    }
    return $array1;
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
    $archivo = $nombre . '.svg';

    if (is_string($nombre) && strlen($nombre) > 0 && is_file(ASSETS_SVG_DIR . $archivo)) {
        return array(
            'url' => ASSETS_SVG_URI . $archivo,
            'contenido' => file_get_contents(ASSETS_SVG_DIR . $archivo)
            );
    }

    return false;
}

/**
 * Retorna un archivo SVG a partir del nombre (sin extension ni ruta), incrustado 
 * dentro de etiquetas span o enlazazo en una etiqueta img
 * @param  string  $nombre    Nombre del archivo svg
 * @param  boolean $incrustar Pone el contenido dentro de <svg> o lo enlaza en <img>.
 *                            Por defecto true
 * @return string             Retorna el contenido o un string vacío.
 */
function retornarSVG($nombre = '', $incrustar = true) {
    $array = buscarSVG($nombre);
    if (!$array) {
        return '';
    }

    if (!$incrustar) {
        $formato = '<img class="svg %s" src="%s" />';
        return sprintf($formato, $nombre, $array['url']);
    }

    $array['contenido'] = str_replace('<svg', '<svg class="'.$nombre.'" ', $array['contenido']);
    return $array['contenido'];
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
