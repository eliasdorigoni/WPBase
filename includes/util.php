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
add_filter('body_class', 'theme_agregarSlugClase');

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
 * Permite cargar información sensible en constantes, para dejarlas
 * fuera del backup.
 * @param  string $archivo               Ruta absoluta al archivo INI
 * @param  array  $constantesPorDefecto  Claves y valores para constantes por defecto.
 */
function cargarConstantesDesdeINI($archivo = '', $constantesPorDefecto = array()) {
    $ini = (file_exists($archivo)) ? parse_ini_file($archivo) : array();
    $constantesPorDefecto = array(
        'claves_por_defecto' => 'valores_por_defecto',
        );
    $data = wp_parse_args($ini, $constantesPorDefecto);

    foreach ($data as $const => $valor) {
        define(strtoupper($const), $valor);
    }
}

/**
 * Retorna un array con las urls de las imagenes de los attachments.
 * O con los posts si no hay $dimensiones definidas.
 * 
 * @param  array  $ids         IDs de posts como valores.
 * @param  string $dimensiones Dimensiones, ej: thumbnail, medium, large.
 * @return array
 */
function retornarImagenesDeAttachments($ids = array(), $dimensiones = '') {
    if (!$ids || !is_array($ids)) {
        return array();
    }

    $query = new WP_Query(array(
        'post_type' => 'attachment',
        'post_status' => 'any',
        'post__in' => $ids,
        ));

    $retorno = array();
    foreach ($query->posts as $post) {
        if ($dimensiones) {
            $retorno[$post->ID] = wp_get_attachment_image_src($post->ID, $dimensiones);
        } else {
            $retorno[$post->ID] = $post;
        }
    }

    return $retorno;
}

function cortarEnPalabra($string, $cantidadCaracteres) {
    $partes = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
    $cantidadPartes = count($partes);

    $caracteres = 0;
    $ultimaParte = 0;
    for (; $ultimaParte < $cantidadPartes; ++$ultimaParte) {
        $caracteres += strlen($partes[$ultimaParte]);
        if ($caracteres > $cantidadCaracteres) {
            break;
        }
    }

    return implode(array_slice($partes, 0, $ultimaParte));
}

function retornarHomeURL() {
    return HOME_URL;
}

function construirLabels($slug, $singular, $plural, $esMasculino = true) {
    return array(
        'name'               => ucfirst($plural),
        'singular_name'      => ucfirst($singular),
        'add_new'            => 'Añadir ' . _n('nuevo', 'nueva', $esMasculino),
        'add_new_item'       => 'Añadir ' . _n('nuevo', 'nueva', $esMasculino) . ' ' . $singular,
        'edit_item'          => 'Editar ' . $singular,
        'new_item'           => _n('Nuevo', 'Nueva', $esMasculino) . ' ' . $singular,
        'view_item'          => 'Ver ' . $singular,
        'view_items'         => 'Ver ' . $plural,
        'search_items'       => 'Buscar cosas',
        'not_found'          => 'No se encontraron cosas',
        'not_found_in_trash' => 'No se encontraron cosas en la papelera',
        'parent_item_colon'  => ucfirst($singular) . ' padre',
        'all_items'          => _n('Todos', 'Todas', $esMasculino) . ' ' . _n('los', 'las', $esMasculino) . ' ' . $plural,
        'archives'           => 'Archivos de ' . $singular,
        'attributes'         => 'Atributos de ' . $singular,
        'insert_into_item'   => 'Insertar en ' . $singular,
        'menu_name'          => ucfirst($plural),
        'name_admin_bar'     => ucfirst($singular),
        'parent_item'       => ucfirst($singular) . ' padre',
        'parent_item_colon' => ucfirst($singular) . ' padre:',
        'update_item'       => 'Actualizar ' . $single,
        'new_item_name'     => 'Nombre de ' . _n('nuevo', 'nueva', $esMasculino) . ' ' . $singular,
    );
}
