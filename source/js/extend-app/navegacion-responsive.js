/**
 * Permite usar un botón para mostrar/ocultar una navegacion
 * 
 * La navegacion agrega la clase .visible cuando está visible y la elimina cuando está escondido.
 * El botón agrega la clase .activo cuando el menú esta visible.
 */

jQuery(function($) {
    var $boton = $('.toggleNavegacionPrincipal'),
        $navegacion = $('.navegacionPrincipal'),
        demoraAnimacion = 400,
        elementoEsVisible = false,
        claseBotonVisible = 'activo',
        claseNavegacionVisible = 'visible'

    function ocultarElemento() {
        $navegacion.removeClass(claseNavegacionVisible).removeAttr('style')
    }

    function mostrarElemento() {
        $navegacion.addClass(claseNavegacionVisible).removeAttr('style')
    }

    function comprobarMenuPrincipal(e) {
        var animarMovimiento = e.data.animar

        if (elementoEsVisible) {
            if (animarMovimiento) {
                $navegacion.slideUp(demoraAnimacion, ocultarElemento)
            } else {
                ocultarElemento()
            }
            $boton.removeClass(claseBotonVisible)
            elementoEsVisible = false

        } else {
            if (animarMovimiento) {
                $navegacion.slideDown(demoraAnimacion, mostrarElemento)
            } else {
                mostrarElemento($menu)
            }
            $boton.addClass(claseBotonVisible)
            elementoEsVisible = true
        }
    }

    elementoEsVisible = $navegacion.hasClass(claseNavegacionVisible)

    // Va animado cuando el usuario le hace clic. Si se redimensiona la ventana,
    $boton.on('click', '', {animar: true}, comprobarMenuPrincipal)
    $(window).on('changed.zf.mediaquery', '', {animar: false}, comprobarMenuPrincipal)
})
