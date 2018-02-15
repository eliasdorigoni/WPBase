<?php
if (!isset($content_width)) $content_width = 625;

get_template_part('includes/util');
get_template_part('includes/constantes');

get_template_part('includes/librerias');
get_template_part('includes/widgets/init');
get_template_part('includes/svg');
get_template_part('includes/templates');

get_template_part('includes/analytics');
get_template_part('includes/mapa/init');

get_template_part('includes/metaboxes/subtitulo');

get_template_part('includes/galeria/init');
get_template_part('includes/redes-sociales');
get_template_part('includes/woocommerce/init');

// Agrega el slug del post y el tipo + slug del post al output de body_class()
add_filter('body_class', 'theme_agregarNombreEnBody');

// Configura el enlace a la web en login.
add_filter('login_headertitle', 'get_bloginfo');
add_filter('login_headerurl', 'home_url', 1, 0);

// Permitir usar shortcodes en widgets.
add_filter('widget_text','do_shortcode');

add_action('wp_head',    'mostrarFavicon');
add_action('login_head', 'mostrarFavicon');

//////////////
// Limpieza //
//////////////

// Se eliminan emojis
remove_action('wp_head', 'print_emoji_detection_script', 7 );
remove_action('wp_print_styles', 'print_emoji_styles' );

// Se elimina Manifest para Windows Live Writer del head
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

// Se elimina el meta generator
remove_action('wp_head', 'wp_generator');

function themeSetup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');

    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    add_theme_support(
        'html5',
        array(
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption',
        )
    );

    add_theme_support(
        'post-formats',
        array(
            'aside',
            'gallery',
            'link',
            'image',
            'quote',
            'status',
            'video',
            'audio',
            'chat'
        )
    );

    register_nav_menu('principal', 'Menu de cabecera');
}
add_action('after_setup_theme', 'themeSetup');

function permitirFondoPersonalizado() {
    // %s = get_stylesheet_directory_uri()
    $base = str_replace(get_stylesheet_directory_uri(), '%s', ASSETS_URI_IMG);

    register_default_headers(array(
        'default' => array(
            'url'           => $base . 'fondo.jpg',
            'thumbnail_url' => $base . 'fondo-thumb.jpg',
            ),
        'alt' => array(
            'url'           => $base . 'fondo-alt.jpg',
            'thumbnail_url' => $base . 'fondo-alt-thumb.jpg',
            )
        ));

    add_theme_support('custom-header', array(
        'width'         => 1920,
        'height'        => 1080,
        'default-image' => ASSETS_URI_IMG . 'fondo.jpg',
        'uploads'       => true,
    ));
    // Usar header_image() para obtener la URL de la imagen.
}
add_action('after_setup_theme', 'permitirFondoPersonalizado');

function theme_enqueueFrontend() {
    wp_enqueue_style('app');
    wp_enqueue_script('app');

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // wp_enqueue_script('gmaps');
    // wp_enqueue_script('slick');
    // wp_enqueue_script('lightbox');
}
add_action('wp_enqueue_scripts', 'theme_enqueueFrontend');

function theme_enqueueBackend() {
    wp_enqueue_style('backend');
}
add_action('admin_enqueue_scripts', 'theme_enqueueBackend');

function theme_enqueueLogin() {
    wp_enqueue_style('custom-login');
}
add_action('login_enqueue_scripts', 'theme_enqueueLogin');
