<?php

// Se eliminan emojis
remove_action('wp_head', 'print_emoji_detection_script', 7 );
remove_action('wp_print_styles', 'print_emoji_styles' );


// Fix para el backend de WordPress en Chrome
function chromefix() {
    wp_add_inline_style( 'wp-admin', '#adminmenu { transform: translateZ(0); }' );
}

add_action('admin_enqueue_scripts', array($this, 'chromefix'));