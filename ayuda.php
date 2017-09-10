<?php
if (!defined('ABSPATH')) exit;

function registrarPaginaAyuda() {
    add_submenu_page('index.php', 'Sobre la web', 'Ayuda', 'activate_plugins', 'sobre-la-web', 'mostrarPaginaAyuda');

}
add_action('admin_menu', 'registrarPaginaAyuda');

function mostrarPaginaAyuda() {
    // @Recomendado: usar div.card para el wrapper y h2.title para el título 
    // del contenido que se enganche al hook 'pagina-ayuda'.
    ?>
    <div class="wrap">
    <?php do_action('pagina-ayuda'); ?>
        <div class="card">
            <h1>A tener en cuenta:</h1>
            <ul>
                <?php do_action('pagina-ayuda-notas'); ?>
            </ul>
        </div>
    </div>
    <?php
}
