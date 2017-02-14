<?php
if (!defined('ABSPATH')) exit;

class WP_Widget_Imagenes extends WP_Widget
{

    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'widget_images',
            'customize_selective_refresh' => true,
        );
        $control_ops = array('width' => 400, 'height' => 350);
        parent::__construct('imagenes', 'Imagenes', $widget_ops, $control_ops );
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }

    public function enqueue()
    {
        wp_enqueue_style('media-upload', plugin_dir_url(__FILE__) . '../css/media-upload.css', array(), '0.1');

        wp_enqueue_script('jquery');
        wp_enqueue_media();
        wp_enqueue_script('media_upload', plugin_dir_url(__FILE__) . 'imagenes.js', array('jquery'));
    }

    public function widget($args, $instance)
    {
        $widget_text = ! empty( $instance['text'] ) ? $instance['text'] : '';
        $text = apply_filters( 'widget_text', $widget_text, $instance, $this );

        echo $args['before_widget']; ?>
            <div class="textwidget"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
        <?php
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        if ( current_user_can( 'unfiltered_html' ) ) {
            $instance['text'] = $new_instance['text'];
        } else {
            $instance['text'] = wp_kses_post( $new_instance['text'] );
        }
        $instance['filter'] = ! empty( $new_instance['filter'] );
        return $instance;
    }

    public function form( $instance )
    {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
        $filter = isset( $instance['filter'] ) ? $instance['filter'] : 0;
        $title = sanitize_text_field( $instance['title'] );
        $galeria = array();
        $maximo = 20;
        ?>
        <div class="widget media-upload">
            <button type="button" class="button cargarImagenJS">Agregar imagenes</button>
            <?php $formato = '<li><input type="hidden" value="%s" class="media-url" name="galeria[]" /> <img src="%s" /> <button type="button" class="button eliminar">Eliminar</button> <button type="button" class="button reemplazar">Reemplazar</button> </li>'; ?>
            <ul>
                <?php
                foreach($galeria as $id => $src) {
                    printf($formato, $id, $src[0]);
                } ?>
            </ul>
            <p><span><?php echo $maximo - count($galeria); ?></span> imagenes disponibles de <?php echo $maximo; ?></p>
        </div>
        <script type="text/javascript">
            var input = '<?php printf($formato, '', '') ?>';
            var maximo = 5;
        </script>




        <?php
    }
}

function cargar_widget_imagenes() {
    register_widget('WP_Widget_Imagenes');
}
add_action( 'widgets_init', 'cargar_widget_imagenes' );
