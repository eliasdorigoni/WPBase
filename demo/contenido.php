<hr>
<h1>Todas las redes</h1>
<?php echo do_shortcode('[redes-sociales]'); ?>

<h1>Sólo Facebook</h1>
<?php echo do_shortcode('[redes-sociales mostrar="facebook"]'); ?>

<h1>Compartir</h1>
<?php echo do_shortcode('[compartir]'); ?>
<h1>Constantes</h1>
<table>
<?php

$constantes = array(
    'HOME_URL',
    'THEME_DIR',
    'THEME_URI',
    'ASSETS_URI',
    'ASSETS_URI_CSS',
    'ASSETS_URI_JS',
    'ASSETS_URI_IMG',
    'ASSETS_URI_SVG',
    'ASSETS_DIR',
    'ASSETS_DIR_CSS',
    'ASSETS_DIR_JS',
    'ASSETS_DIR_IMG',
    'ASSETS_DIR_SVG',
);

foreach ($constantes as $const) {
    echo '<tr><td>' . $const . '</td><td>' . constant($const) . '</td></tr>';
}

?>
</table>
<h1>Iconos</h1>
<table>
<?php 

$rutas = glob(dirname(__FILE__) . '/source/svg/**');

foreach ($rutas as $ruta) {
    $id = str_replace('.svg', '', basename($ruta));
    mostrarSVG(array(
        'nombre' => $id,
        'contenedor' => '<tr><td>'.$id.'</td><td>%s</td></tr>',
        ));
}
?>
</table>
