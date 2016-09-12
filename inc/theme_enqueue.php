<?php

function theme_enqueue() {
    wp_enqueue_style('custom-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700', array(), null);
    wp_enqueue_style('foundation', STYLESHEET_URI . '/css/foundation.min.css', array(), '6.2.3');
    wp_enqueue_style('app', STYLESHEET_URI . '/css/app.css', array(), '0.1');

    wp_enqueue_script('jquery');
    wp_enqueue_script('foundation', THEME_URI . '/js/foundation.min.js', array('jquery'), '6.2.3', true );
    wp_enqueue_script('app', THEME_URI.'/js/app.js', array('foundation'), '0.1', true );
}

// https://github.com/kenwheeler/slick/
function theme_enqueueSlick() {
    wp_enqueue_style('slick', THEME_URI . '/css/slick.css', array(), '1.6.0');
    wp_enqueue_script('slick', THEME_URI . '/js/vendor/slick.min.js', array('jquery'), '1.6.0', true);
}

// https://github.com/lokesh/lightbox2/
function theme_enqueueLightbox() {
    wp_enqueue_style('lightbox', THEME_URI . '/css/ligtbox.min.css', array(), '2.8.2');
    wp_enqueue_script('lightbox', THEME_URI . '/js/vendor/lightbox.min.js', array('jquery'), '2.8.2', true);
}
