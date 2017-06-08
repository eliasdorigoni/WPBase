<?php
if (!defined('ABSPATH')) exit;

function renombrarBotonIrACheckout() {
    return 'Finalizar compra';
}
add_filter('woocommerce_order_button_text', 'renombrarBotonIrACheckout', 10);
