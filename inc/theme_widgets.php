<?php

function theme_widgets() {
    register_sidebar(array(
        'name' => 'Widget #1',
        'id'   => 'widget-1',
        'description' => 'Widget de ejemplo.',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>'
    ));
}
