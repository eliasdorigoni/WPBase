<h1>Archivos SVG</h1>
<table>
<?php 
$rutas = glob(__DIR__ . '/img/svg/*.svg');
foreach ($rutas as $ruta) {
    if (is_file($ruta)) {
        $nombre = preg_replace('/\.svg$/', '', basename($ruta));
        printf('<tr><td>%s</td><td>%s</td></tr>', $nombre, retornarSVG($nombre));
    }
}
?>
</table>
