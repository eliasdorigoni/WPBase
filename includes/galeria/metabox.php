<?php
if (!defined('ABSPATH')) exit;

function registrarMetaboxGaleria() {
    $id       = 'galeria';
    $titulo   = 'Galería';
    $callback = 'mostrarMetaboxGaleria';
    $screen   = 'page';
    $context  = 'normal';
    $priority = 'high';
    add_meta_box($id, $titulo, $callback, $screen, $context, $priority);
}
add_action('add_meta_boxes', 'registrarMetaboxGaleria');

function mostrarMetaboxGaleria($post) {
    $cantidadMaxima = -1; // Límite de imagenes.
    $galeria = get_post_meta($post->ID, 'galeria', true);
    wp_nonce_field('metabox_galeria', 'metabox_galeria_nonce');
    include THEME_DIR . 'includes' . DS . 'galeria' . DS . 'templates' . DS . 'backend-form.phtml';
}

function guardarMetaboxGaleria($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
        return $post_id;

    if (!current_user_can('manage_options'))
        return $post_id;

    if (!isset($_POST['metabox_galeria_nonce']))
        return $post_id;

    if (!wp_verify_nonce($_POST['metabox_galeria_nonce'], 'metabox_galeria'))
        return $post_id;

    $galeria = array();
    if (isset($_POST['galeria']) && !empty($_POST['galeria'])) {
        foreach ($_POST['galeria'] as $k => $id) {
            if (!is_string($id) || !preg_match('/^\d+$/', $id)) {
                unset($_POST['galeria'][$k]);
            }
        }
        $galeria = array_values($_POST['galeria']);
    }
    update_post_meta($post_id, 'galeria', $galeria);
}
add_action('save_post', 'guardarMetaboxGaleria', 1, 2);
