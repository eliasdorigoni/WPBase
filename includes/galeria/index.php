<?php

if (!defined('ABSPATH')) exit;

require_once 'class.galeria.php';

function registrarWidgetGaleria() {
    register_widget('WP_Widget_Galeria');
}
add_action('widgets_init', 'registrarWidgetGaleria');
