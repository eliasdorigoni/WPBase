jQuery(function($) {
    var $boton = $('.toggleNavegacionPrincipal'),
        $navegacion = $('.navegacionPrincipal'),
        demoraAnimacion = 400,
        elementoEsVisible = false,
        claseBotonVisible = 'activo',
        claseNavegacionVisible = 'visible'

    /**
     * Permite usar un botón para mostrar/ocultar una navegacion
     * 
     * La navegacion agrega la clase .visible cuando está visible y la elimina cuando está escondido.
     * El botón agrega la clase .activo cuando el menú esta visible.
     */

    function ocultarNavegacion() {
        $navegacion.removeClass(claseNavegacionVisible).removeAttr('style')
    }

    function mostrarNavegacion() {
        $navegacion.addClass(claseNavegacionVisible).removeAttr('style')
    }

    function toggleNavegacion(e) {
        var animarMovimiento = e.data.animar

        if (elementoEsVisible) {
            if (animarMovimiento) {
                $navegacion.slideUp(demoraAnimacion, ocultarNavegacion)
            } else {
                ocultarNavegacion()
            }
            $boton.removeClass(claseBotonVisible)
            elementoEsVisible = false

        } else {
            if (animarMovimiento) {
                $navegacion.slideDown(demoraAnimacion, mostrarNavegacion)
            } else {
                mostrarNavegacion($menu)
            }
            $boton.addClass(claseBotonVisible)
            elementoEsVisible = true
        }
    }

    elementoEsVisible = $navegacion.hasClass(claseNavegacionVisible)

    // Va animado cuando el usuario le hace clic. Si se redimensiona la ventana,
    $boton.on('click', '', {animar: true}, toggleNavegacion)
    $(window).on('changed.zf.mediaquery', '', {animar: false}, toggleNavegacion)


    /**
     * Permite visibilizar los submenús si no hay hover
     */
    var timeoutElementoEnMouseOver = null,
        puedeSeguirLink = true

    function intentarAbrirSubmenu(e) {
        if (puedeSeguirLink) {
            console.log('seguir link')
            return true
        } else {
            console.log('NO seguir link')
        }
        e.preventDefault()
        return false
    }

    function actualizarTimeout(e) {
        clearTimeout(timeoutElementoEnMouseOver)
        puedeSeguirLink = false
        timeoutElementoEnMouseOver = setTimeout(
            function(){
                puedeSeguirLink = true
            },
            50
        )
    }

    $navegacion.on('mouseover', 'li.menu-item-has-children', actualizarTimeout)
    $navegacion.on('click', 'li.menu-item-has-children', intentarAbrirSubmenu)
})
