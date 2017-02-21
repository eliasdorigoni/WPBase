<?php
if (!defined('ABSPATH')) exit;

class WP_Widget_Galeria extends WP_Widget
{
    public $cantidadMaxima = null;

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
        // Configurar si hace falta limitar la cantidad.
        // $this->cantidadMaxima = 20;
    }

    public function widget($args, $instance)
    {
        $widget_text = !empty($instance['text']) ? $instance['text'] : '';
        $text = apply_filters('widget_text', $widget_text, $instance, $this);

        echo $args['before_widget']; ?>
            <div class="textwidget"><?php echo !empty($instance['filter']) ? wpautop($text) : $text; ?></div>
        <?php
        echo $args['after_widget'];
    }

    public function update($new_instance, $old_instance)
    {
        Continuar viendo por que no se actualiza la galeria.
        // $instance = $old_instance;
        // $ids = array();
        // foreach ($instance['galeria'] as $id) {
        //     if (preg_match('/^\d+$/', $id)) {
        //         $ids[] = $id;
        //     }
        // }

        // $instance['galeria'] = '';
        // if ($ids) {
        //     $instance['galeria'] = implode('|', $ids);
        // }

        return $new_instance;
    }

    public function form($instance)
    {
        $instance = wp_parse_args($instance, array('galeria' => ''));
        $galeria = array();

        if ($instance['galeria']) {
            $galeria = explode('|', $instance['galeria']);
        }
        ?>
        <div class="widget widgetGaleriaJS media-upload">
            <?php if ($this->cantidadMaxima): ?>
                <p><span class="restantes"><?php echo $this->cantidadMaxima - count($galeria); ?></span> imagenes disponibles de <?php echo $this->cantidadMaxima; ?></p>
            <?php else: ?>
                <p>Imágenes: <code><pre><?php var_export($instance['galeria']); ?></pre></code></p>
            <?php endif ?>
            <button type="button" class="button button-primary cargarImagenJS">Agregar imagenes</button>
            <?php $formato = '<li class="thumb"><input type="hidden" value="%s" name="galeria[]" /> <img src="%s" /> <button type="button" class="button eliminar">Eliminar</button> <button type="button" class="button reemplazar">Reemplazar</button> </li>'; ?>
            <ul>
                <?php
                foreach($galeria as $id) {
                    $src = wp_get_attachment_image_src($id);
                    printf($formato, $id, $src[0]);
                } 
                ?>
            </ul>
        </div>
        <script type="text/javascript">
            var li = '<?php printf($formato, '', '') ?>';
            var maximo = <?php echo $this->cantidadMaxima ? $this->cantidadMaxima : -1 ?>;
            var limitarCantidadMaxima = <?php echo is_null($this->cantidadMaxima) ? true : false; ?>
        </script>
        <?php
    }
}

function registrarWidgetGaleria() {
    register_widget('WP_Widget_Galeria');
}
add_action('widgets_init', 'registrarWidgetGaleria');
