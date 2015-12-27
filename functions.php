<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');

define('THEME_ROOT',      dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('THEME_URI',       get_template_directory_uri());
define('STYLESHEET_URI',  get_stylesheet_directory_uri());
define('HOME_URL',        home_url());
// define('DISALLOW_FILE_EDIT', true);

if (!isset($content_width)) $content_width = 625;

class Configuracion
{
    function __construct()
    {
        add_action('after_setup_theme',  array($this, 'setup'   ));
        add_action('widgets_init',       array($this, 'widgets' ));
        add_action('wp_enqueue_scripts', array($this, 'enqueue' ));
        add_filter('body_classes',       array($this, 'agregarSlugPost' ));

        // Login
        add_action('login_enqueue_scripts', array($this, 'loginLogo'));
        add_filter('login_headertitle',     array($this, 'loginTitulo'));
        add_filter('login_headerurl',       array($this, 'loginUrl'));

        // Se eliminan emojis
        remove_action('wp_head', 'print_emoji_detection_script', 7 );
        remove_action('wp_print_styles', 'print_emoji_styles' );

        // Se elimina Manifest para Windows Live Writer
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'rsd_link');

        // Se elimina el meta generator
        remove_action('wp_head', 'wp_generator');

        add_filter( 'wp_title', array($this, 'wpdocs_hack_wp_title_for_home') );
    }

    public function setup()
    {
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
        add_theme_support('automatic-feed-links');
        add_theme_support('post-formats', array('aside', 'image', 'link', 'quote', 'status'));
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(624, 9999); // Altura ilimitada, soft crop
        // add_editor_style('css/editor-style.css');
        register_nav_menu('principal', 'Menu de cabecera');
    }

    public function widgets()
    {
        register_sidebar(array(
            'name' => 'Widget #1',
            'id'   => 'widget-1',
            'description' => 'Widget de ejemplo.',
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget'  => '</li>',
            'before_title'  => '<h2 class="widgettitle">',
            'after_title'   => '</h2>'
        ));
    }

    public function enqueue()
    {
        // Custom fonts
        wp_enqueue_style('custom-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,700');

        // Foundation
        wp_enqueue_style('foundation', THEME_URI . '/css/foundation.min.css' );

        // Estilos
        wp_enqueue_style('app', THEME_URI . '/css/app.css' );

        wp_enqueue_script('jquery');
        wp_enqueue_script('foundation', THEME_URI . '/js/foundation.min.js', array( 'jquery' ), null, true );

        wp_enqueue_script('app', THEME_URI.'/js/app.js', array(), null, true );
    }

    public function agregarSlugPost($classes)
    {
        global $post;
        if (isset($post)) {
            $classes[] = $post->post_type . '-' . $post->post_name;
        }
        return $classes;
    }

    public function loginLogo()
    {
        wp_enqueue_style('custom-login', THEME_URI . '/css/login.css' );
    }

    public function loginTitulo()
    {
        return get_bloginfo();
    }

    public function loginUrl()
    {
        return home_url();
    }

    /**
     * Customize the title for the home page, if one is not set.
     *
     * @param string $title The original title.
     * @return string The title to use.
     */
    public function wpdocs_hack_wp_title_for_home($title)
    {
        if (empty($title) && (is_home() || is_front_page())) {
            $title = get_bloginfo( 'name' );
        }
        return $title;
    }
}

new Configuracion;
