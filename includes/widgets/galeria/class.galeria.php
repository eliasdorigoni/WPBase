<?php
if (!defined('ABSPATH')) exit;

class WP_Widget_Galeria extends WP_Widget
{
    public $cantidadMaxima = 3;

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
        $widget_text = !empty($instance['text']) ? $instance['text'] : '';
        $text = apply_filters('widget_text', $widget_text, $instance, $this);

        include 'widget.phtml';
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['galeria'] = $new_instance['galeria'];

        return $instance;
    }

    public function form($instance)
    {
        $instance = wp_parse_args(
            $instance, 
            array(
                'galeria' => array()
            )
        );

        $cantidadMaxima = $this->cantidadMaxima;
        $galeria = ($instance['galeria']) ? $instance['galeria'] : array();
        
        include 'form.phtml';
    }
}

function registrarWidgetGaleria() {
    register_widget('WP_Widget_Galeria');
}
add_action('widgets_init', 'registrarWidgetGaleria');
