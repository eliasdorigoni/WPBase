<?php
if (!defined('ABSPATH')) exit;

function registrarTaxonomiaCustom() {
    register_taxonomy('operacion', array('cosa'), array(
        'hierarchical'      => true,
        'labels'            => construirLabels('operacion', 'operaciones', false),
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true
    ));
    register_taxonomy_for_object_type('operacion', 'cosa');
}
add_action('init', 'registrarTaxonomiaCustom');
