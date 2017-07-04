<?php
if (!defined('ABSPATH')) exit;

function registrarNuevoCustomPostType() {
    $args = array(
        'labels'               => construirLabels('cosa', 'cosas', false);,
        'public'               => true,
        'menu_position'        => 30,
        'menu_icon'            => 'dashicons-building',
        'supports'             => array(
            'title',
            'editor',
            // 'author',
            'thumbnail',
            'excerpt'
            // 'trackbacks',
            // 'custom-fields',
            // 'comments',
            // 'revisions',
            // 'page-attributes',
            // 'post-formats',
        ),
        'taxonomies'           => array('custom-tax'),
        'register_meta_box_cb' => 'registrarMetaboxCosa',
    );
    register_post_type($singular, $args);
}
add_action('registrarPropiedad');

function registrarMetaboxCosa() {
    add_meta_box('id', 'Titulo', 'mostrarMetabox', 'cosa', 'normal', 'default');
}

function mostrarMetabox($post) {
    wp_nonce_field('metabox', 'metabox-nonce');
    $valor = get_post_meta($post->ID, 'valor', true);
    // echo <input ...
}

function guardarMetabox($postID) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $postID;
    }

    if (!current_user_can('manage_options')) {
        return $postID;
    }

    if (isset($_POST['metabox-nonce']) && wp_verify_nonce($_POST['metabox-nonce'], 'metabox')) {
        // Limpiar los datos de este metabox específico.
        update_post_meta($post_id, 'metabox', sanitize_text_field('fecha'));
    }

    if (isset($_POST['metabox-2-nonce']) && wp_verify_nonce($_POST['metabox-2-nonce'], 'metabox-2')) {
        // Limpiar los datos de este metabox específico.
        update_post_meta($post_id, 'metabox-2', sanitize_text_field('fecha-2'));
    }
}
add_action('save_post', 'guardarMetabox', 1, 1);
