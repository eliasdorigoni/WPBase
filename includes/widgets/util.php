<?php

/**
 * Agrega una clase que incrementa en 1 por cada widget existente (item-1, item-2, 
 * item-3, etc...) dentro de sidebars especificados.
 * Se debe enganchar al filtro 'dynamic_sidebar_params'.
 */
function agregarClaseIncremental($params) {
    $sidebars = array('footer');
    $formatoClase = 'item-%s';

    if (is_admin() || empty($params[0]['id']) || !in_array($params[0]['id'], $sidebars)) {
        return $params;
    }

    static $i = 0;
    $i++;

    $buscar = 'class="';
    $reemplazar = 'class="' . sprintf($formatoClase, $i) . ' ';
    $params[0]['before_widget'] = str_replace($buscar, $reemplazar, $params[0]['before_widget']);

    return $params;
}

/**
 * Agrega una o más clases a todos los widgets de sidebars especificados. El nombre de
 * estas clases dependerá de la cantidad de widgets existentes en el sidebar.
 * Se debe agregar al filtro 'dynamic_sidebar_params'
 */
function agregarClasePorCantidad($params) {
    $sidebars = array('footer');

    if (is_admin() || empty($params[0]['id']) || !in_array($params[0]['id'], $sidebars)) {
        return $params;
    }

    $sidebars = wp_get_sidebars_widgets();
    $cantidad = count($sidebars[($params[0]['id'])]);

    if ($cantidad < 12) {
        $clase = 'large-' . floor(12 / $cantidad);
    } else {
        $clase = 'large-1';
    }

    $buscar = 'class="';
    $reemplazar = 'class="' . $clase . ' ';
    $params[0]['before_widget'] = str_replace($buscar, $reemplazar, $params[0]['before_widget']);

    return $params;
}
