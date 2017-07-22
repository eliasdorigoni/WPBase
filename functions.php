<?php

if (!isset($content_width)) $content_width = 625;

get_template_part('includes/constantes');

get_template_part('includes/util');
add_filter('body_class', 'theme_agregarSlugClase');
add_filter('post_thumbnail_html', 'ampliarPostThumbnail', 10, 5);

get_template_part('includes/theme_setup');
add_action('after_setup_theme', 'themeSetup');
add_action('after_setup_theme', 'themeNavMenu');
add_action('after_setup_theme', 'permitirFondoPersonalizado');
add_action('after_setup_theme', 'permitirLogoPersonalizado');
add_action('after_setup_theme', 'agregarDimensionesImagenes');

get_template_part('includes/theme_widgets');
add_action('widgets_init', 'theme_widgets');
// add_filter('dynamic_sidebar_params', 'agregarClaseIncremental');
// add_filter('dynamic_sidebar_params', 'agregarClasePorCantidad');

get_template_part('includes/theme_enqueue');
get_template_part('includes/widget.contenido');

get_template_part('includes/svg');
get_template_part('includes/analytics/google-analytics');
get_template_part('includes/analytics/pixel-facebook');

get_template_part('includes/galeria/init');
get_template_part('includes/redes-sociales');

get_template_part('includes/woocommerce/gateway.banco');
get_template_part('includes/woocommerce/reordenar-form-checkout');
get_template_part('includes/woocommerce/cupones-condicionales');
get_template_part('includes/woocommerce/renombrar-checkout');
get_template_part('includes/woocommerce/vaciar-carrito');
get_template_part('includes/woocommerce/dni');


add_filter('login_headertitle', 'get_bloginfo');
add_filter('login_headerurl', 'home_url', 1, 0);

// Permitir usar shortcodes en widgets.
add_filter('widget_text','do_shortcode');

add_action('wp_head',    'mostrarFavicon');
add_action('login_head', 'mostrarFavicon');
add_action('admin_head', 'mostrarFavicon');

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
