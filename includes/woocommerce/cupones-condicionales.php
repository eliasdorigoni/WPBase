<?php
if (!defined('ABSPATH')) exit;

function desactivarCuponesSiNoHay($activado) {
    if (is_cart() || is_checkout()) {
        $query = new WP_Query(array(
            'posts_per_page'   => 1,
            'post_type'        => 'shop_coupon',
            'post_status'      => 'publish',
            'no_found_rows'    => true,
            ));

        $activado = $query->have_posts();
    }
    return $activado;
}
add_filter('woocommerce_coupons_enabled', 'desactivarCuponesSiNoHay');
