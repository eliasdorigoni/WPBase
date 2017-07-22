<?php

function theme_widgets() {
    register_sidebar(array(
        'name'          => 'Barra lateral',
        'id'            => 'barra-lateral',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>'
    ));
    register_sidebar(array(
        'name'          => 'Footer',
        'id'            => 'footer',
        'description'   => 'Columnas en footer.',
        'before_widget' => '<div id="%1$s" class="column widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>'
    ));
    register_sidebar(array(
        'name'          => 'Ejemplo',
        'id'            => 'ejemplo',
        'description'   => 'Columnas en footer.',
        'before_widget' => '<div id="%1$s" class="column widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>'
    ));
}

/**
 * Agrega una clase que incrementa en 1 por cada widget existente (item-1, item-2, 
 * item-3, etc...), modificando la clave 'before_widget' de sidebars específicos.
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
 * Agrega una clase condicional a todos los widgets de uno o mas sidebars, que 
 * depende de la cantidad de widgets existentes en el sidebar.
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
