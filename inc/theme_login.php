<?php 
if (!defined('ABSPATH')) exit;

function theme_login() {
    wp_enqueue_style('custom-login', ASSETS_CSS_URI . 'login.min.css' );
}

function retornarLoginURL() {
    return HOME_URL;
}

add_action('login_enqueue_scripts', 'theme_login');
add_filter('login_headertitle', 'get_bloginfo');
add_filter('login_headerurl', 'retornarLoginURL');
