<?php
if (!defined('ABSPATH')) exit;

function extraerValorDeMetadata($order, $clave) {
    $meta = $order->get_data();
    foreach ($meta['meta_data'] as $item) {
        if ($item->key == $clave) {
            return wptexturize($item->value);
        }
    }
    return '';
}

function agregarDNIEnCheckout($campos) {
    $campos['dni_cuit'] = array(
        'label'        => 'DNI o CUIT de la empresa',
        'required'     => true,
        'class'        => array('form-row-last'),
        'type'         => 'text',
        'autocomplete' => 'text',
        'priority'     => 100,
    );
    return $campos;
}
add_filter('woocommerce_default_address_fields', 'agregarDNIEnCheckout', 20, 1);

function agregarDNIEnPedido($campos) {
    $campos['dni_cuit'] = array(
        'label' => 'DNI o CUIT de la empresa',
        'show' => true,
    );
    return $campos;
}
add_filter('woocommerce_admin_billing_fields', 'agregarDNIEnPedido', 20, 1);

function agregarDNIEnEmail($fields, $sent_to_admin, $order) {
    $valor = extraerValorDeMetadata($order, '_billing_dni_cuit');
    if ($valor) {
        $value = wptexturize($valor);
        $fields['dni_cuit'] = array(
            'label' => 'DNI o CUIT de la empresa', 
            'value' => $value,
        );
    }
    return $fields;
}
add_filter('woocommerce_email_customer_details_fields', 'agregarDNIEnEmail', 20, 3);
    
function agregarDNIEnPanelPedidos($order) {
    $valor = $this->extraerValorDeMetadata($order, '_billing_dni_cuit');
    if ($valor) {
        $valor = wptexturize($valor);
        echo '<tr>'
            . '<th>' . 'DNI o CUIT de la empresa' . '</th>'
            . '<td>' . esc_html($valor) . '</td>'
        . '</tr>';
    }
}
add_action('woocommerce_order_details_after_customer_details', 'agregarDNIEnPanelPedidos', 20, 1);
