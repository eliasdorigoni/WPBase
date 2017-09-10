<?php
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
 * Agrega el slug del post a las clases HTML de body_class().
 */
function theme_agregarNombreEnBody($classes) {
    global $post;
    if (is_object($post)) {
        $classes[] = $post->post_type . '-' . $post->post_name;
        $classes[] = $post->post_name;
    }
    return $classes;
}

/**
 * Define constantes usando información externa. Ideado para claves de API y similares.
 * @param  array  $constantesPorDefecto  Claves y valores para constantes por defecto.
 * @param  string $archivo               Ruta absoluta al archivo INI
 */
function cargarConstantesDesdeINI($constantesPorDefecto = array(), $archivo = THEME_DIR . 'config.ini') {
    $ini = (file_exists($archivo)) ? parse_ini_file($archivo) : array();
    $data = wp_parse_args($ini, $constantesPorDefecto);

    foreach ($data as $nombre => $valor) {
        if (!defined($nombre)) define($nombre, $valor);
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

/**
 * Arma un array con los textos utilizados por register_post_type().
 */
function construirLabels($singular, $plural, $esMasculino = true) {
    return array(
        'name'               => ucfirst($plural),
        'singular_name'      => ucfirst($singular),
        'add_new'            => 'Añadir ' . _n('nuevo', 'nueva', $esMasculino),
        'add_new_item'       => 'Añadir ' . _n('nuevo', 'nueva', $esMasculino) . ' ' . $singular,
        'edit_item'          => 'Editar ' . $singular,
        'new_item'           => _n('Nuevo', 'Nueva', $esMasculino) . ' ' . $singular,
        'view_item'          => 'Ver ' . $singular,
        'view_items'         => 'Ver ' . $plural,
        'search_items'       => 'Buscar ' . $plural,
        'not_found'          => 'No se encontraron ' . $plural,
        'not_found_in_trash' => 'No se encontraron ' . $plural . ' en la papelera',
        'parent_item_colon'  => ucfirst($singular) . ' padre',
        'all_items'          => _n('Todos', 'Todas', $esMasculino) . ' ' . _n('los', 'las', $esMasculino) . ' ' . $plural,
        'archives'           => 'Archivos de ' . $singular,
        'attributes'         => 'Atributos de ' . $singular,
        'insert_into_item'   => 'Insertar en ' . $singular,
        'menu_name'          => ucfirst($plural),
        'name_admin_bar'     => ucfirst($singular),
        'parent_item'        => ucfirst($singular) . ' padre',
        'parent_item_colon'  => ucfirst($singular) . ' padre:',
        'update_item'        => 'Actualizar ' . $singular,
        'new_item_name'      => 'Nombre de ' . _n('nuevo', 'nueva', $esMasculino) . ' ' . $singular,
    );
}


function mostrarFavicon() {
    ?>
    <link rel="shortcut icon" href="<?php echo THEME_URI ?>favicon.ico" type="image/x-icon" />
    <link rel="icon" href="<?php echo THEME_URI ?>favicon.ico" type="image/x-icon" />
    <link rel="icon" href="<?php echo THEME_URI ?>favicon.png" type="image/png" sizes="64x64" />
    <?php
}


function retornarPostsAnteriorSiguiente() {
    $postAnterior = get_previous_post();
    $postSiguiente = get_next_post();
    $columnaAnterior = $columnaSiguiente = '';

    if (is_object($postAnterior)) {
        $clase = (is_object($postSiguiente)) ? 'medium-6' : '';
        $columnaAnterior = '<div class="column text-left ' . $clase . '">'
            . '<a class="anterior" href="' . get_permalink($postAnterior) . '">'
                . '<em>Entrada anterior:</em><br>'
                . ' &larr; ' . $postAnterior->post_title
            . '</a>'
         . '</div>';
    }

    if (is_object($postSiguiente)) {
        $clase = (is_object($postAnterior)) ? 'medium-6' : '';
        $columnaSiguiente = '<div class="column text-right ' . $clase . '">'
            . '<a class="siguiente" href="' . get_permalink($postSiguiente) . '">'
                . '<em>Entrada siguiente:</em><br>'
                . $postSiguiente->post_title . ' &rarr;'
            . '</a>'
         . '</div>';
    }

    if (!empty($columnaAnterior) || !empty($columnaSiguiente)) {
        return '<div class="enlacesNavegacion row">'
                . $columnaAnterior
                . $columnaSiguiente
             . '</div>';
    }

    return '';
}


function mostrarPostsAnteriorSiguiente() {
    echo retornarPostsAnteriorSiguiente();
}


function esEnteroPositivo($string = '') {
    if (is_string($string) || is_int($string)) {
        return preg_match('/^\d+$/', $string);
    }
    return false;
}


function ampliarPostThumbnail($html, $post_id, $thumb_id, $size, $attr) {
    if ($attr != 'expandir') {
        return $html;
    }

    if (!preg_match('/width="(\d+)"/', $html, $m)) {
        return $html;
    } else {
        $width = $m[1];
    }

    if (!preg_match('/height="(\d+)"/', $html, $m)) {
        return $html;
    } else {
        $height = $m[1];
    }

    $expectedWidth = 0;
    $expectedHeight = 0;

    switch ($size) {
        case 'thumb':
        case 'thumbnail':
        case 'medium':
        case 'medium_large':
        case 'large':
            if ($size == 'thumb') $size = 'thumbnail';
            $expectedWidth = get_option($size . '_size_w', 0);
            $expectedHeight = get_option($size . '_size_h', 0);
            break;
        default:
            global $_wp_additional_image_sizes;
            if (array_key_exists($size, $_wp_additional_image_sizes)) {
                $expectedWidth = $_wp_additional_image_sizes[$size]['width'];
                $expectedHeight = $_wp_additional_image_sizes[$size]['height'];
            }
            break;
    }

    if ($expectedWidth <= 0 || $expectedHeight <= 0) {
        return $html;
    }

    if ($width != $expectedWidth || $height != $expectedHeight) {
        $src = wp_get_attachment_image_src($thumb_id, $size);

        $html = sprintf(
            '<span style="display: inline-block; max-width: %3$spx"><img class="expandido %2$s %3$sx%4$s" style="'
            . 'background: #fff url(\'%1$s\') scroll no-repeat center center;'
            . 'background-size: cover; '
            . 'border: 1px solid red; '
            . 'display: inline-block; '
            . 'width: 100%%; height: 0; '
            . 'max-width: %3$spx; '
            . 'padding-bottom: %5$s%%'
            . '" /></span>',
            $src[0],
            $size,
            $expectedWidth,
            $expectedHeight,
            ($expectedHeight / $expectedWidth) * 100
        );

    }

    return $html;
}

/**
 * Activa el hard crop en las dimensiones por defecto.
 * Enganchar al hook 'after_setup_theme' para activar.
 */
function forzarCropEnDimensiones() {
    add_image_size('medium', get_option('medium_size_w'), get_option('medium_size_h'), true);
    add_image_size('large', get_option('large_size_w'), get_option('large_size_h'), true);
}


/**
 * Funciones para extender WordPress
 */

/**
 * Retorna el titulo de la página del blog
 */
if (!function_exists('get_the_blog_title')) {
    function get_the_blog_title() {
        $id = get_option('page_for_posts', true);
        return get_the_title($id);
    }
}

/**
 * Muestra el retorno de get_the_blog_title()
 */
if (!function_exists('the_blog_title')) {
    function the_blog_title() {
        echo get_the_blog_title();
    }
}

/**
 * Retorna el permalink del blog
 */
if (!function_exists('get_the_blog_permalink')) {
    function get_the_blog_permalink() {
        $id = get_option('page_for_posts', true);
        return get_permalink($id);
    }
}

/**
 * Retorna el permalink del blog
 */
if (!function_exists('the_blog_permalink')) {
    function the_blog_permalink() {
        echo get_the_blog_permalink();
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


if (!function_exists('change_action_priority')) {
    function change_action_priority($tag, $func, $old_priority, $new_priority) {
        remove_action($tag, $func, $old_priority);
        add_action($tag, $func, $new_priority);
    }
}
