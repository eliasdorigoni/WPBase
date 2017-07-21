<?php 
if (!defined('ABSPATH')) exit;

function themeSetup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');

    // add_theme_support('woocommerce');
    // add_theme_support('wc-product-gallery-zoom');
    // add_theme_support('wc-product-gallery-lightbox');
    // add_theme_support('wc-product-gallery-slider');

    add_theme_support(
        'html5',
        array(
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption',
        )
    );
    add_theme_support(
        'post-formats',
        array(
            'aside',
            'gallery',
            'link',
            'image',
            'quote',
            'status',
            'video',
            'audio',
            'chat'
        )
    );
}
add_action('after_setup_theme', 'themeSetup');

function themeNavMenu() {
    register_nav_menu('principal', 'Menu de cabecera');
}
add_action('after_setup_theme', 'themeNavMenu');

function permitirFondoPersonalizado() {
    // %s = get_stylesheet_directory_uri()
    $base = str_replace(get_stylesheet_directory_uri(), '%s', ASSETS_URI_IMG);

    register_default_headers(array(
        'default' => array(
            'url'           => $base . 'fondo.jpg',
            'thumbnail_url' => $base . 'fondo-thumb.jpg',
            ),
        'alt' => array(
            'url'           => $base . 'fondo-alt.jpg',
            'thumbnail_url' => $base . 'fondo-alt-thumb.jpg',
            )
        ));

    add_theme_support('custom-header', array(
        'width'         => 1920,
        'height'        => 1080,
        'default-image' => ASSETS_URI_IMG . 'fondo.jpg',
        'uploads'       => true,
    ));
    // Usar header_image() para obtener la URL de la imagen.
}
add_action('after_setup_theme', 'permitirFondoPersonalizado');

function permitirLogoPersonalizado() {
    add_theme_support('custom-logo', array(
        'height'      => 200,
        'width'       => 400,
        'flex-height' => true,
        // 'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    ));
}
add_action('after_setup_theme', 'permitirLogoPersonalizado');

function cambiarDimensionesImagenes() {
    set_post_thumbnail_size(320, 320, true);
    add_image_size('formato', '220', '220', true);
}
add_action('after_setup_theme', 'cambiarDimensionesImagenes');

function ampliarPostThumbnail($html, $post_id, $thumb_id, $size, $attr) {
    if ($attr != 'expandir') {
        return $html;
    }

    if (!preg_match('/width="(\d+)"/', $html, $m)) {
        return $html;
    } else {
        $width = $m[1];
    }

    if (!preg_match('/height="(\d+)"/', $html, $m)) {
        return $html;
    } else {
        $height = $m[1];
    }

    $expectedWidth = 0;
    $expectedHeight = 0;

    switch ($size) {
        case 'thumb':
        case 'thumbnail':
        case 'medium':
        case 'medium_large':
        case 'large':
            if ($size == 'thumb') $size = 'thumbnail';
            $expectedWidth = get_option($size . '_size_w', 0);
            $expectedHeight = get_option($size . '_size_h', 0);
            break;
        default:
            global $_wp_additional_image_sizes;
            if (array_key_exists($size, $_wp_additional_image_sizes)) {
                $expectedWidth = $_wp_additional_image_sizes[$size]['width'];
                $expectedHeight = $_wp_additional_image_sizes[$size]['height'];
            }
            break;
    }

    if ($expectedWidth <= 0 || $expectedHeight <= 0) {
        return $html;
    }

    if ($width != $expectedWidth || $height != $expectedHeight) {
        $src = wp_get_attachment_image_src($thumb_id, $size);

        $html = sprintf(
            '<span style="display: inline-block; max-width: %3$spx"><img class="expandido %2$s %3$sx%4$s" style="'
            . 'background: #fff url(\'%1$s\') scroll no-repeat center center;'
            . 'background-size: cover; '
            . 'border: 1px solid red; '
            . 'display: inline-block; '
            . 'width: 100%%; height: 0; '
            . 'max-width: %3$spx; '
            . 'padding-bottom: %5$s%%'
            . '" /></span>',
            $src[0],
            $size,
            $expectedWidth,
            $expectedHeight,
            ($expectedHeight / $expectedWidth) * 100
        );

    }

    return $html;
}
add_filter('post_thumbnail_html', 'ampliarPostThumbnail', 10, 5);
