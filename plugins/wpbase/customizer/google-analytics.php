<?php

function personalizarGoogleAnalytics($wp_customize) {
    $wp_customize->add_section('section-google-analytics', array(
        'title' => 'Google Analytics',
        'priority' => 170,
        'capability' => 'edit_theme_options',
        ));

    $wp_customize->add_setting('google-analytics', array(
        'type' => 'option',
        'capability' => 'edit_theme_options',
        ));
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'google-analytics-control',
            array(
                'label'       => 'Código UA de Google Analytics',
                'section'     => 'section-google-analytics',
                'settings'    => 'google-analytics',
                'type'        => 'text',
                'input_attrs' => array(
                    'placeholder' => 'UA-XXXXXXX-XX',
                    ),
                )
            )
        );

}
add_action('customize_register', 'personalizarGoogleAnalytics');
