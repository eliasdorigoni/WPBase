<?php
if (!defined('ABSPATH')) exit;

get_template_part('includes/woocommerce/cupones-condicionales');
get_template_part('includes/woocommerce/dni');
get_template_part('includes/woocommerce/gateway.banco');
get_template_part('includes/woocommerce/renombrar-checkout');
get_template_part('includes/woocommerce/reordenar-form-checkout');
get_template_part('includes/woocommerce/vaciar-carrito');

function agregarSoporteWooCommerce() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'agregarSoporteWooCommerce');
