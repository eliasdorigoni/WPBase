<?php
if (!defined('ABSPATH')) exit;

function reordenarCamposCheckout($campos = array()) {
    $orden = array(
        'first_name',
        'last_name',
        'company',
        'country',
        'state',
        'city',
        'postcode',
        'address_1',
        'address_2',
        'phone',
        'email',
    );

    $camposOrdenados = array();
    $nuevaPrioridad = 1;

    foreach ($orden as $item) {
        if (isset($campos[$item])) {
            $campos[$item]['priority'] = $nuevaPrioridad++;
            $camposOrdenados[$item] = $campos[$item];
        }
    }

    return $camposOrdenados;
}
add_filter('woocommerce_default_address_fields', 'reordenarCamposCheckout', 30, 1);

function eliminarValorSiExiste($valor, &$array) {
    $posicion = array_search($valor, $array);
    if ($posicion !== false) {
        unset($array[$posicion]);
    }
}

function agregarValorSiNoExiste($valor, &$array) {
    $posicion = array_search($valor, $array);
    if ($posicion === false) {
        $array[] = $valor;
    }
}

function cambiarClasesCamposCheckout($campos) {
    // Pais
    agregarValorSiNoExiste('form-row-first', $campos['country']['class']);
    eliminarValorSiExiste('form-row-wide', $campos['country']['class']);

    // Provincia
    agregarValorSiNoExiste('form-row-last', $campos['state']['class']);
    eliminarValorSiExiste('form-row-wide', $campos['state']['class']);

    // Ciudad
    agregarValorSiNoExiste('form-row-first', $campos['city']['class']);
    eliminarValorSiExiste('form-row-wide', $campos['city']['class']);

    // Codigo postal
    agregarValorSiNoExiste('form-row-last', $campos['postcode']['class']);
    eliminarValorSiExiste('form-row-wide', $campos['postcode']['class']);

    return $campos;
}
add_filter('woocommerce_default_address_fields', 'cambiarClasesCamposCheckout', 30, 1);
