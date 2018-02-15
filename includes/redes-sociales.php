<?php
if (!defined('ABSPATH')) exit;

/**
 * Retorna un array con la configuración de las redes sociales.
 * Se puede editar la primer variable $retorno para modificar el orden en el que aparecerán las redes.
 *
 * Algunas redes sociales permiten compartir y definir la página del proyecto en esa red, como Facebook y Twitter.
 * Otras solamente permiten compartir, como WhatsApp, o solamente definir la página del proyecto, como Instagram.
 * @return array Redes disponibles
 */
function retornarConfiguracionRedesSociales() {
    $facebook = array(
        'nombre' => 'Facebook', # Nombre de la red, para usar en el frontend
        'option' => 'url-facebook', # Option donde guardar la URL de la página/twitter/etc del sitio
        'icono' => 'facebook', # ID del icono SVG
        'customizer' => array(
            'label' => 'URL de Facebook', # Label en el customizer de WP
        ),
        'compartir' => array( # Datos para armar la URL para compartir
            'url' => 'https://www.facebook.com/sharer/sharer.php?',
            'query' => array(
                'u' => '{{URL}}',
                'display' => 'popup',
                'ref' => 'plugin',
                'src' => 'share_button',
            ),
        ),
    );

    $googleplus = array(
        'nombre' => 'Google Plus',
        'option' => 'url-google-plus',
        'icono' => 'googleplus',
        'customizer' => array(
            'label' => 'URL de Google Plus',
        ),
        'compartir' => array(
            'url' => 'https://plus.google.com/share?',
            'query' => array(
                'url' => '{{URL}}',
            ),
        ),
    );

    $instagram = array(
        'nombre' => 'Instagram',
        'option' => 'url-instagram',
        'icono' => 'instagram',
        'customizer' => array(
            'label' => 'URL de Instagram',
        ),
    );

    $linkedin = array(
        'nombre' => 'Linkedin',
        'option' => 'url-linkedin',
        'icono' => 'linkedin',
        'customizer' => array(
            'label' => 'URL de Linkedin',
        ),
        'compartir' => array( # Datos para armar la URL para compartir
            'url' => 'https://www.linkedin.com/shareArticle?',
            'query' => array(
                'url' => '{{URL}}',
                'mini' => 'true',
                'title' => '{{TITLE}}',
                'summary' => '{{EXCERPT}}',
                'source' => '{{URL}}',
            ),
        ),
    );

    $pinterest = array(
        'nombre' => 'Pinterest',
        'option' => 'url-pinterest',
        'icono' => 'pinterest',
        'customizer' => array(
            'label' => 'URL de Pinterest',
        ),
    );

    $twitter = array(
        'nombre' => 'Twitter',
        'option' => 'url-twitter',
        'icono' => 'twitter',
        'customizer' => array(
            'label' => 'URL de Twitter',
        ),
        'compartir' => array(
            'url' => 'https://twitter.com/home?',
            'query' => array(
                'status' => '{{SHORT_URL}}',
            ),
        ),
    );

    $youtube = array(
        'nombre' => 'YouTube',
        'option' => 'url-youtube',
        'icono' => 'youtube',
        'customizer' => array(
            'label' => 'URL del canal de Youtube',
        ),
    );

    $whatsapp = array(
        'nombre' => 'WhatsApp',
        'icono' => 'whatsapp',
        'compartir' => array(
            'url' => 'whatsapp://send?',
            'query' => array(
                'text' => '{{SHORT_URL}}',
            ),
        ),
    );

    return array(
        'facebook'    => $facebook,
        'google-plus' => $googleplus,
        'linkedin'    => $linkedin,
        'instagram'   => $instagram,
        'pinterest'   => $pinterest,
        'twitter'     => $twitter,
        'youtube'     => $youtube,
        'whatsapp'    => $whatsapp,
    );
}

/**
 * Comprueba si el string es una clave en el array de redes sociales.
 * @param  string $string String a comprobar
 * @return boolean
 */
function esRedSocialRegistrada($string = '') {
    $redesSociales = retornarConfiguracionRedesSociales();
    return array_key_exists($string, $redesSociales);
}

/**
 * Permite editar las URLs de las redes sociales desde el customizer de WP.
 * @param  object $wp_customize
 */
function registrarCustomizerRedesSociales($wp_customize) {
    $wp_customize->add_section('redes-sociales', array(
        'title' => 'Redes sociales',
        'description' => 'Agregue las direcciones de sus redes sociales para mostrarlas, o dejelas vacías para ocultarlas.',
        'priority' => 160,
        'capability' => 'edit_theme_options',
    ));

    $config = retornarConfiguracionRedesSociales();

    foreach ($config as $k => $item) {
        if (empty($item['option']) || empty($item['customizer'])) {
            continue;
        }

        $wp_customize->add_setting($item['option'], array(
            'type' => 'option',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                $item['option'] . '-control',
                array(
                    'label'    => $item['customizer']['label'],
                    'section'  => 'redes-sociales',
                    'settings' => $item['option'],
                    'type'     => 'text',
                )
            )
        );
    }
}
add_action('customize_register', 'registrarCustomizerRedesSociales');

/**
 * Retorna las páginas del proyecto en las redes sociales.
 * @param  array  $atts
 * @return string
 */
function retornarPaginasRedesSociales($atts = array()) {
    $atts = shortcode_atts(array('mostrar' => 'todos'), $atts);
    $mostrar = explode(',', $atts['mostrar']);
    $mostrar = array_map('trim', $mostrar);

    $redesSocialesExistentes = retornarConfiguracionRedesSociales();

    if (in_array('todos', $mostrar)) {
        $mostrar = array_keys($redesSocialesExistentes);
    } else {
        $mostrar = array_filter($mostrar, 'esRedSocialRegistrada');
    }

    $items = array();
    foreach ($mostrar as $slug) {
        $red = $redesSocialesExistentes[$slug];
        if (empty($red['option'])) {
            continue;
        }

        // Si no tiene enlace, no se muestra.
        $enlace = get_option($red['option'], false);
        if (!$enlace) {
            continue;
        }

        $items[] = sprintf(
            '<a class="%s" href="%s" title="%s" target="_blank" rel="noopener">%s</a>',
            $slug,
            $enlace,
            $red['nombre'],
            retornarSVG($red['icono'])
        );
    }

    if ($items) {
        return '<div class="redesSociales">' . implode('', $items) . '</div>';
    }
    return '';
}
add_shortcode('redes-sociales', 'retornarPaginasRedesSociales');

/**
 * Retorna botones para compartir las redes sociales definidas en retornarConfiguracionRedesSociales()
 * @param  array  $atts
 * @return string
 */
function retornarBotonesCompartir($atts = array()) {
    $redesSocialesExistentes = retornarConfiguracionRedesSociales();

    $default = array(
        'id'      => 0,       // Post a compartir. 0 = actual
        'mostrar' => 'todos', // Redes sociales a mostrar
    );

    $atts = shortcode_atts($default, $atts);

    $mostrar = $atts['mostrar'];
    $id = $atts['id'];

    $url = get_the_permalink($id);
    $shortUrl = wp_get_shortlink($id);
    $titulo = get_the_title($id);
    $excerpt = get_the_excerpt($id);

    $mostrar = explode(',', $mostrar);
    if (in_array('todos', $mostrar)) {
        $mostrar = array_keys($redesSocialesExistentes);
    } else {
        $mostrar = array_filter($mostrar, 'stringEsRedSocial');
    }

    $retorno = '<ul class="compartirEnRedes">';
    foreach ($mostrar as $slug) {
        $redSocial = $redesSocialesExistentes[$slug];
        if (empty($redSocial['compartir'])) {
            continue;
        }

        // %1: URL,
        // %2: contenido del elemento,
        // %3: clase,
        // %4: titulo
        $formato = '<li><a class="%3$s" href="%1$s" rel="nofollow"';
        if ($formato != 'whatsapp') {
            $formato .= ' onclick="return !window.open(this.href, \'%4$s\', \'width=640,height=580\')"';
        }
        $formato .= '>%2$s</a></li>';

        $buscar = array('{{URL}}', '{{SHORT_URL}}', '{{TITLE}}', '{{EXCERPT}}');
        $reemplazar = array($url, $shortUrl, $titulo, $excerpt);

        foreach ($redSocial['compartir']['query'] as $k => $v) {
            $redSocial['compartir']['query'][$k] = str_replace($buscar, $reemplazar, $v);
        }

        $urlCompartir = $redSocial['compartir']['url'] . http_build_query($redSocial['compartir']['query']);
        $titulo = 'Compartir en ' . $redSocial['nombre'];
        $contenido = retornarSVG($redSocial['icono']);
        $claseCSS = 'compartir ' . $slug;

        $retorno .= sprintf($formato, $urlCompartir, $contenido, $claseCSS, $titulo);
    }

    return $retorno . '</ul>';
}
add_shortcode('compartir', 'retornarBotonesCompartir');
