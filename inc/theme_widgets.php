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

class theme_claseWidgets {
    static $i;
    static $ids = array();

    /**
     * Agrega un string a los IDs a buscar.
     * @param  string $id ID del sidebar.
     * @return [type]     [description]
     */
    static function agregarId($id = '')
    {
        if (is_string($id) && !in_array($id, self::$ids)) {
            self::$ids[] = $id;
        }
    }

    /**
     * Retorna true si se debe modificar el sidebar actual.
     */
    static function modificarSidebar($params)
    {
        if (!is_array(self::$ids)) {
            trigger_error('Se debe especificar el ID de el o los sidebars a modificar.');
        }

        if (!isset($params[0]) 
            || !isset($params[0]['id'])
            ) {
            return false;
        }

        if (in_array($params[0]['id'], self::$ids)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Agrega nombres de clase con incrementos (widget-1, widget-2, etc).
     */
    static function incremental($params)
    {
        if (!self::modificarSidebar($params)) return $params;

        self::$i = (!is_numeric(self::$i)) ? 1 : self::$i + 1;
        $clase = 'item-' . self::$i . ' ';

        $params[0]['before_widget'] = str_replace(
            'class="',  
            'class="' . $clase, 
            $params[0]['before_widget']
            );

        return $params;
    }

    /**
     * Agrega clases que dependen de la cantidad de widgets.
     * Se usa para cambiar la cantidad de columnas de un sidebar de ancho completo.
     */
    static function cantidad($params)
    {
        if (!self::modificarSidebar($params)) return $params;

        $total_widgets = wp_get_sidebars_widgets();
        $sidebar_widgets = count($total_widgets[ ($params[0]['id']) ]);

        // Dividir en 12 columnas.
        $clase = 'large-' . floor(12 / $sidebar_widgets) . ' ';

        $params[0]['before_widget'] = str_replace('class="',  'class="'.$clase, $params[0]['before_widget']);

        return $params;
    }
}

// Para modificar la clase dentro de 'before_widget' de un sidebar, 
// hay que agregar su ID a la clase.
// theme_claseWidgets::agregarId('widget-1');

// Y agregar un filtro.
// add_filter('dynamic_sidebar_params', array('theme_claseWidgets', 'cantidad'));
// add_filter('dynamic_sidebar_params', array('theme_claseWidgets', 'incremental'));
