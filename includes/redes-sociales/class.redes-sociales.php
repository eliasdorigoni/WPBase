<?php
if (!defined('ABSPATH')) exit;

class RedesSociales
{
    static function registrarOpcionesCustomizer($wp_customize)
    {
        $wp_customize->add_section('redes-sociales', array(
            'title' => 'Redes sociales',
            'description' => 'Agrega las direcciones de sus redes sociales. Déjelas vacías para no usarlas.',
            'panel' => '', // Not typically needed.
            'priority' => 160,
            'capability' => 'edit_theme_options',
            'theme_supports' => '', // Rarely needed.
            ));

        $redesSociales = array(
            'url-twitter'     => 'URL de Twitter',
            'url-facebook'    => 'URL de Facebook',
            'url-google-plus' => 'URL de Google Plus',
            'url-youtube'     => 'URL del canal de Youtube',
            'url-instagram'   => 'URL de Instagram',
            );

        foreach ($redesSociales as $setting => $label) {
            $wp_customize->add_setting($setting, array(
                'type' => 'option',
                'capability' => 'edit_theme_options',
                ));
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    $setting . '-control',
                    array(
                        'label'         => $label,
                        'section'       => 'redes-sociales',
                        'settings'      => $setting,
                        'type'          => 'text',
                        )
                    )
                );
        }
    }
}

add_action('customize_register', array('RedesSociales', 'registrarOpcionesCustomizer'));
