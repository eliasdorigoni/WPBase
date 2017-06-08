<?php
if (!defined('ABSPATH')) exit;

function vaciarCarrito() {
    if (isset($_GET['empty-cart'])) {
        WC()->cart->empty_cart();
    }

    // Agregar este botón en el template "Cart Page" (woocommerce/cart/cart.php):
    // <a class="button" href="<?php echo WC()->cart->get_cart_url(); ? >?empty-cart">Vaciar carrito</a>
}
add_action('init', 'vaciarCarrito');
