<?php

function theme_widgets() {
    register_sidebar( array(
        'name'          => 'Logos en footer',
        'id'            => 'logos-footer',
        'description'   => '',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ));
}

add_action('widgets_init', 'theme_widgets');