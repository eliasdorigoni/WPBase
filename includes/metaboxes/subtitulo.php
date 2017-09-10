<?php 
if (!defined('ABSPATH')) exit;

function agregarSubtitulo() {
    add_meta_box('Subtitulo', 'Agregar frase debajo del título', 'agregarMetaboxSubtitulo', 'page', 'side', 'high');
}
add_action('add_meta_boxes', 'agregarSubtitulo');

function agregarMetaboxSubtitulo($post) {
    wp_nonce_field('subtitulo-metabox', 'subtitulo-meta-nonce' ); 

    printf(
        '<input type="text" name="subtitulo-pagina" class="widefat" value="%s" />
        <p>Este frase aparecerá sobre el título, de color gris oscuro.</p>',
        get_post_meta($post->ID, 'subtitulo', true)
    );
    
}

function guardarSubtitulo($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!isset($_POST['subtitulo-meta-nonce'])
        || !wp_verify_nonce($_POST['subtitulo-meta-nonce'], 'subtitulo-metabox')) {
        return;
    }

    if (!current_user_can('edit_pages', $post_id)) {
        return;
    }

    if (isset($_POST['subtitulo-pagina'])) {
        update_post_meta($post_id, 'subtitulo', sanitize_text_field($_POST['subtitulo-pagina']));
    }
}
add_action('save_post', 'guardarSubtitulo');
