<?php

function theme_enqueue() {
    // Custom fonts
    wp_enqueue_style('custom-fonts', 'http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700,700italic|Open+Sans:400,400italic,700,700italic');

    // FontAwesome
    wp_enqueue_style('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');

    // Bootstrap 3.3.5
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css' );

    wp_enqueue_style('theme-css', get_stylesheet_uri() );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), null, true );

    // Google recaptcha
    wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js', array(), null, false );


    wp_enqueue_script('theme-js', get_template_directory_uri() . '/js/scripts.js', array( 'bootstrap-js' ), null, true );
}

add_action('wp_enqueue_scripts', 'theme_enqueue');