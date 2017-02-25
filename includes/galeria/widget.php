<?php
if (!defined('ABSPATH')) exit;

class WP_Widget_Galeria extends WP_Widget
{
    public $cantidadMaxima = -1; // -1 = ilimitado, 0 = desactivado, > 0 = limitado

    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'widget_galeria',
            'customize_selective_refresh' => true,
            'description' => 'Galería de imágenes.',
        );
        $control_ops = array(
            'width' => 400,
            'height' => 350
        );
        parent::__construct('galeria', 'Galeria', $widget_ops, $control_ops );
        add_action('admin_enqueue_scripts', 'theme_enqueueWidgetGaleria');
    }

    public function widget($args, $instance)
    {
        $default = array(
            'galeria' => array(),
            );
        $instance = wp_parse_args($instance, $default);
        extract($instance);
        extract($args);
        include 'templates/frontend-widget.phtml';
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['galeria'] = $new_instance['galeria'];

        return $instance;
    }

    public function form($instance)
    {
        $default = array(
            'galeria' => array(),
            );
        $instance = wp_parse_args($instance, $default);
        $cantidadMaxima = $this->cantidadMaxima;
        $galeria = $instance['galeria'];
        include 'templates/backend-form-widget.phtml';
    }
}

function registrarWidgetGaleria() {
    register_widget('WP_Widget_Galeria');
}
add_action('widgets_init', 'registrarWidgetGaleria');
