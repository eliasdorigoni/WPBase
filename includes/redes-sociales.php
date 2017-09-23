<?php
if (!defined('ABSPATH')) exit;

function retornarConfiguracionRedesSociales() {
    $retorno = array();

    $retorno[] = array(
        # Nombre de la red, para usar en el frontend
        'nombre' => 'Facebook',
        # Option donde guardar la URL de la página/twitter/etc del sitio
        'option' => 'url-facebook',
        # ID del icono SVG
        'icono' => 'facebook',
        'customizer' => array(
            # Label en el customizer de WP
            'label' => 'URL de Facebook',
        ),
        # Datos para armar la URL para compartir
        'compartir' => array(
            'url' => 'https://www.facebook.com/sharer/sharer.php?',
            'query' => array(
                'u' => 'REEMPLAZAR_CON_ENLACE',
                'display' => 'popup',
                'ref' => 'plugin',
                'src' => 'share_button',
            ),
        ),
    );

    $retorno[] = array(
        'nombre' => 'Google Plus',
        'option' => 'url-google-plus',
        'icono' => 'google-plus',
        'customizer' => array(
            'label' => 'URL de Google Plus',
        ),
        'compartir' => array(
            'url' => 'https://plus.google.com/share?',
            'query' => array(
                'url' => 'REEMPLAZAR_CON_ENLACE',
            ),
        ),
    );

    $retorno[] = array(
        'nombre' => 'Instagram',
        'option' => 'url-instagram',
        'icono' => 'instagram',
        'customizer' => array(
            'label' => 'URL de Instagram',
        ),
    );

    $retorno[] = array(
        'nombre' => 'Pinterest',
        'option' => 'url-pinterest',
        'icono' => 'pinterest',
        'customizer' => array(
            'label' => 'URL de Pinterest',
        ),
    );

    $retorno[] = array(
        'nombre' => 'Twitter',
        'option' => 'url-twitter',
        'icono' => 'twitter',
        'customizer' => array(
            'label' => 'URL de Twitter',
        ),
        'compartir' => array(
            'url' => 'https://twitter.com/home?',
            'query' => array(
                'status' => 'REEMPLAZAR_CON_ENLACE',
            ),
        ),
    );

    $retorno[] = array(
        'nombre' => 'YouTube',
        'option' => 'url-youtube',
        'icono' => 'youtube',
        'customizer' => array(
            'label' => 'URL del canal de Youtube',
        ),
    );

    $retorno[] = array(
        'nombre' => 'WhatsApp',
        'icono' => 'whatsapp',
        'compartir' => array(
            'url' => 'whatsapp://send?',
            'query' => array(
                'text' => 'REEMPLAZAR_CON_ENLACE',
            ),
        ),
    );

    return $retorno;
}

function stringEsRedSocial($string) {
    $config = retornarConfiguracionRedesSociales();
    return array_key_exists($string, $config);
}

function registrarCustomizerRedesSociales($wp_customize) {
    $wp_customize->add_section('redes-sociales', array(
        'title' => 'Redes sociales',
        'description' => 'Agrega las direcciones de sus redes sociales. Déjelas vacías para no usarlas.',
        'priority' => 160,
        'capability' => 'edit_theme_options',
    ));

    $config = retornarConfiguracionRedesSociales();

    foreach ($config as $k => $item) {
        if (empty($item['option'])) {
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
                    'label' => $item['customizer']['label'],
                    'section' => 'redes-sociales',
                    'settings' => $item['option'],
                    'type' => 'text',
                )
            )
        );
    }
}
add_action('customize_register', 'registrarCustomizerRedesSociales');

function retornarRedesSociales($atts = array()) {
    $default = array('mostrar' => 'todos');
    extract(shortcode_atts($default, $atts));
    /** @var $mostrar string */

    $mostrar = explode(',', strtolower($mostrar));
    /** @var $mostrar array */

    $config = retornarConfiguracionRedesSociales();

    if (in_array('todos', $mostrar)) {
        $mostrar = array();
        foreach ($config as $slug => $array) {
            $mostrar[] = $slug;
        }
    } else {
        $mostrar = array_filter($mostrar, 'stringEsRedSocial');
    }

    $retorno = array();
    foreach ($mostrar as $slug) {
        $red = $config[$slug];
        if (!isset($red['option'])) {
            continue;
        }

        $enlace = get_option($red['option'], false);
        // Si no tiene enlace, no se muestra.
        if (!$enlace) {
            continue;
        }

        $icono = retornarSVG($red['icono']);
        $titulo = $red['nombre'];

        $retorno[$slug] = array(
            'slug' => $slug,
            'titulo' => $titulo,
            'enlace' => $enlace, 
            'icono' => $icono
        );
    }

    if (!$retorno) {
        return array();
    }

    ob_start();
    foreach ($retorno as $item) {
        printf(
            '<a class="%s" href="%s" title="%s" target="_blank" rel="noopener">%s</a>',
            $item['slug'],
            $item['enlace'],
            $item['titulo'],
            $item['icono']
        );
    }
    return sprintf('<div class="redesSociales">%s</div>', ob_get_clean());
}
add_shortcode('redes-sociales', 'retornarRedesSociales');

function retornarBotonesCompartir($atts = array()) {
    $config = retornarConfiguracionRedesSociales();
    $default = array(
        // Redes sociales a mostrar
        'mostrar'  => 'todos',

        // URL a compartir.
        'url'      => get_the_permalink(),
        'shorturl' => wp_get_shortlink(),
    );
    extract(shortcode_atts($default, $atts));
    /**
     * @var $mostrar string
     * @var $url string
     * @var $shorturl string
     */

    $retorno = array();
    foreach ($config as $slug => $array) {

        if ($mostrar != 'todos' && strpos($mostrar, $slug) === false) {
            continue;
        } else if (!isset($array['compartir'])) {
            continue;
        }

        $clases = array('compartir', $slug);

        // %1$s: URL
        // %2$s: Contenido del elemento
        // %3$s: Clase
        // %4$s: Titulo ("Compartir en...")
        if ($slug == 'whatsapp') {
            $formato = '<a class="%3$s" href="%1$s" rel="nofollow">%2$s</a>';
        } else {
            $formato = '<a class="%3$s" href="%1$s" onclick="return !window.open(this.href, \'%4$s\', \'width=640,height=580\')">%2$s</a>';
        }

        foreach ($array['compartir']['query'] as $clave => $valor) {
            if ($slug == 'twitter') {
                $valor = str_replace('REEMPLAZAR_CON_ENLACE', $shorturl, $valor);
            } else {
                $valor = str_replace('REEMPLAZAR_CON_ENLACE', $url, $valor);
            }
            $array['compartir']['query'][$clave] = $valor;
        }
        $query = http_build_query($array['compartir']['query']);
        $urlCompartir = $array['compartir']['url'] . $query;

        $titulo = 'Compartir en ' . $array['nombre'];
        $contenido = retornarSVG($array['icono']);

        $clases = implode(' ', $clases);

        $retorno[] = sprintf($formato, $urlCompartir, $contenido, $clases, $titulo);
    }

    return implode('', $retorno);
}
add_shortcode('compartir', 'retornarBotonesCompartir');
