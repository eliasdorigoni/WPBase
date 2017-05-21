<?php
if (!defined('ABSPATH')) exit;

class RedesSociales
{
    static $config = array(
        'twitter' => array(
            'nombre' => 'Twitter',
            'option' => 'url-twitter',
            'customizer' => array(
                'label' => 'URL de Twitter',
            ),
        ),
        'facebook' => array(
            'nombre' => 'Facebook',
            'option' => 'url-facebook',
            'customizer' => array(
                'label' => 'URL de Facebook',
            ),
        ),
        'google-plus' => array(
            'nombre' => 'Google Plus',
            'option' => 'url-google-plus',
            'customizer' => array(
                'label' => 'URL de Google Plus',
            ),
        ),
        'youtube' => array(
            'nombre' => 'YouTube',
            'option' => 'url-youtube',
            'customizer' => array(
                'label' => 'URL del canal de Youtube',
            ),
        ),
        'instagram' => array(
            'nombre' => 'Instagram',
            'option' => 'url-instagram',
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
}

add_action('customize_register', array('RedesSociales', 'registrarOpcionesCustomizer'));
