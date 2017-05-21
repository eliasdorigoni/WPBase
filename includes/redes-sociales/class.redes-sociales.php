<?php
if (!defined('ABSPATH')) exit;

class RedesSociales
{
    static $config = array(
        'twitter' => array(
            'nombre' => 'Twitter',
            'option' => 'url-twitter',
            'icono' => 'twitter',
            'customizer' => array(
                'label' => 'URL de Twitter',
            ),
        ),
        'facebook' => array(
            'nombre' => 'Facebook',
            'option' => 'url-facebook',
            'icono' => 'facebook',
            'customizer' => array(
                'label' => 'URL de Facebook',
            ),
        ),
        'google-plus' => array(
            'nombre' => 'Google Plus',
            'option' => 'url-google-plus',
            'icono' => 'google-plus',
            'customizer' => array(
                'label' => 'URL de Google Plus',
            ),
        ),
        'youtube' => array(
            'nombre' => 'YouTube',
            'option' => 'url-youtube',
            'icono' => 'youtube',
            'customizer' => array(
                'label' => 'URL del canal de Youtube',
            ),
        ),
        'instagram' => array(
            'nombre' => 'Instagram',
            'option' => 'url-instagram',
            'icono' => 'instagram',
            'customizer' => array(
                'label' => 'URL de Instagram',
            ),
        ),
    );

    static function registrarOpcionesCustomizer($wp_customize)
    {
        $wp_customize->add_section('redes-sociales', array(
            'title' => 'Redes sociales',
            'description' => 'Agrega las direcciones de sus redes sociales. Déjelas vacías para no usarlas.',
            'priority' => 160,
            'capability' => 'edit_theme_options',
        ));

        foreach (self::$config as $slug => $item) {
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

    static function stringEsRedSocial($string)
    {
        return array_key_exists($string, self::$config);
    }

    static function retornar($atts = array())
    {
        $default = array('mostrar' => 'todos');
        extract(shortcode_atts($default, $atts));
        $mostrar = explode(',', strtolower($mostrar));

        if (in_array('todos', $mostrar)) {
            $mostrar = array();
            foreach (self::$config as $slug => $array) {
                $mostrar[] = $slug;
            }
        } else {
            $mostrar = array_filter($mostrar, array('RedesSociales', 'stringEsRedSocial'));
        }

        $retorno = array();
        foreach ($mostrar as $slug) {
            $red = self::$config[$slug];

            // Si no tiene enlace, no se muestra.
            if (false === ($enlace = get_option($red['option'], false))) {
                continue;
            }

            $icono = SVG::retornar($red['icono']);
            $titulo = $red['nombre'];

            $retorno[$slug] = array(
                'slug' => $slug,
                'titulo' => $titulo,
                'enlace' => $enlace, 
                'icono' => $icono
            );
        }

        if (!$retorno) return;

        ob_start();
        foreach ($retorno as $item) {
            printf(
                '<a class="redSocial %s" href="%s" title="%s">%s</a>',
                $item['slug'],
                $item['enlace'],
                $item['titulo'],
                $item['icono']
            );
        }
        return sprintf('<div class="redesSociales">%s</div>', ob_get_clean());
    }
}

add_action('customize_register', array('RedesSociales', 'registrarOpcionesCustomizer'));
add_shortcode('redes-sociales', array('RedesSociales', 'retornar'));
