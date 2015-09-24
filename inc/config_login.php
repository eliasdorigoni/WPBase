<?php

function theme_loginLogo() {
    wp_enqueue_style('custom-login', get_template_directory_uri() . '/css/login.css' );
}

function theme_loginTitulo() {
    return get_bloginfo();
}

function theme_loginUrl() {
    return home_url();
}


add_action('login_enqueue_scripts', 'theme_loginLogo');
add_filter('login_headertitle', 'theme_loginTitulo');
add_filter('login_headerurl', 'theme_loginUrl');