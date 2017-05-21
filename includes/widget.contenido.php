<?php
if (!defined('ABSPATH')) exit;

// Copia del widget de texto que no muestra el título.
class WP_Widget_Contenido extends WP_Widget
{

    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'widget_content',
            'description' => 'Texto, shortcodes o HTML. Sin título.',
            'customize_selective_refresh' => true,
        );
        $control_ops = array('width' => 400, 'height' => 350);
        parent::__construct('contenido', 'Contenido', $widget_ops, $control_ops);
    }

    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        $widget_text = !empty($instance['text']) ? $instance['text'] : '';
        $text = apply_filters('widget_text', $widget_text, $instance, $this);

        echo $args['before_widget']; ?>
            <div class="textwidget"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
        <?php
        echo $args['after_widget'];
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);
        if (current_user_can('unfiltered_html')) {
            $instance['text'] = $new_instance['text'];
        } else {
            $instance['text'] = wp_kses_post($new_instance['text']);
        }
        $instance['filter'] = !empty($new_instance['filter']);
        return $instance;
    }

    public function form($instance)
    {
        $instance = wp_parse_args((array) $instance, array(
            'title' => '',
            'text' => ''
        ));
        $filter = isset($instance['filter']) ? $instance['filter'] : 0;
        $title = sanitize_text_field($instance['title']);
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>">Titulo (no se va a mostrar en el frontend):</label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('text'); ?>">Contenido:</label>
        <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea></p>

        <p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox"<?php checked( $filter ); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>
        <?php
    }
}

function cargar_widget_contenido() {
    register_widget('WP_Widget_Contenido');
}
add_action( 'widgets_init', 'cargar_widget_contenido' );
