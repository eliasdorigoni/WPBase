<h1>Constantes</h1>
<table>
<?php
echo '<tr><td>HOME_URL</td><td>' . HOME_URL . '</td></tr>';
echo '<tr><td>THEME_DIR</td><td>' . THEME_DIR . '</td></tr>';
echo '<tr><td>THEME_URI</td><td>' . THEME_URI . '</td></tr>';
echo '<tr><td>ASSETS_URI</td><td>' . ASSETS_URI . '</td></tr>';
echo '<tr><td>ASSETS_DIR</td><td>' . ASSETS_DIR . '</td></tr>';
echo '<tr><td>ASSETS_CSS_URI</td><td>' . ASSETS_CSS_URI . '</td></tr>';
echo '<tr><td>ASSETS_JS_URI</td><td>' . ASSETS_JS_URI . '</td></tr>';
echo '<tr><td>ASSETS_IMG_URI</td><td>' . ASSETS_IMG_URI . '</td></tr>';
echo '<tr><td>ASSETS_SVG_DIR</td><td>' . ASSETS_SVG_DIR . '</td></tr>';
echo '<tr><td>ASSETS_SVG_URI</td><td>' . ASSETS_SVG_URI . '</td></tr>';
?>
</table>
<h1>Archivos SVG</h1>
<table>
<?php 

$rutas = glob(ASSETS_SVG_DIR . '*.svg');
foreach ($rutas as $ruta) {
    if (is_file($ruta)) {
        $nombre = preg_replace('/\.svg$/', '', basename($ruta));
        printf('<tr><td>%s</td><td>%s</td></tr>', $nombre, retornarSVG($nombre));
    }
}
?>
</table>
