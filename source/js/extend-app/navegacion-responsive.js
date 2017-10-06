/**
 * Permite usar un botón para mostrar/ocultar un menú, y permite usar
 * 
 * El menú agrega la clase .visible cuando está visible y la elimina cuando
 * está escondido.
 * El botón agrega la clase .activo cuando el menú esta visible.
 */
jQuery.fn.extend({
  
navegacionResponsive: function(boton, demoraAnimacion) {
    var $ = jQuery
    if (typeof boton === 'undefined')
        console.error('Se debe pasar un objeto jQuery que controle el menú.');

    demoraAnimacion = typeof demoraAnimacion !== 'undefined' ? demoraAnimacion : 400;

    var $menu = this,
        $boton = $(boton)


    function cerrarMenu(menu) {
        menu.removeClass('visible').removeAttr('style')
    }

    function abrirMenu(menu) {
        menu.addClass('visible').removeAttr('style')
    }

    function comprobarMenuPrincipal(e) {
        var animarMovimiento = e.data.animar

        if ($menu.hasClass('visible')) {
            $boton.removeClass('activo');
            if (animarMovimiento) {
                $menu.slideUp(demoraAnimacion, function() {cerrarMenu($menu)})
            } else {
                cerrarMenu($menu)
            }

        } else {
            $boton.addClass('activo');
            if (animarMovimiento) {
                $menu.slideDown(demoraAnimacion, function() {abrirMenu($menu)})
            } else {
                abrirMenu($menu)
            }
        }
    }

    $boton.on('click', '', {animar: true}, comprobarMenuPrincipal)
    $(window).on('changed.zf.mediaquery', '', {animar: false}, comprobarMenuPrincipal)
}

});
