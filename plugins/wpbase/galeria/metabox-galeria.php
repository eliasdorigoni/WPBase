<?php
if (!defined('ABSPATH')) exit;

if (!function_exists('buscarAttachments')) {
/**
 * Retorna los posts de tipo attachment de una lista de $ids como un array
 * asociativo.
 * @param  array  $ids         IDs de posts como valores.
 * @param  string $dimensiones [description]
 * @return [type]              [description]
 */
function buscarAttachments($ids = array(), $dimensiones = '') {
    if (!$ids) return $ids;

    $query = new WP_Query(array(
        'post_type' => 'attachment',
        'post_status' => 'any',
        'post__in' => $ids,
        ));

    $retorno = array();
    foreach ($query->posts as $post) {
        if ($dimensiones) {
            $retorno[$post->ID] = wp_get_attachment_image_src($post->ID, $dimensiones);
        } else {
            $retorno[$post->ID] = $post;
        }
    }

    return $retorno;
}}

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
    $maximo = 20; // Cantidad máxima de imagenes.
    if (false == ($ids = get_post_meta($post->ID, 'galeria', true))) 
        $ids = array();

    $galeria = buscarAttachments($ids, 'thumbnail');
    include WPBASE_PLUGIN_DIR_PATH . 'galeria/metabox-galeria-template.phtml';
}

function enqueueMetaboxGaleria($hook) {
    if ($hook == 'post-new.php' || $hook == 'post.php') {
        global $post;
        if ($post->post_type === 'page') { 
            wp_enqueue_script('metabox-galeria', plugins_url('admin-metabox-galeria.js', __FILE__), array('jquery'), '0.1', true);
        }
    }
}
add_action('admin_enqueue_scripts', 'enqueueMetaboxGaleria');


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
