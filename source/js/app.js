jQuery(document).foundation()

jQuery(function($) {

    /**
     * Permite usar un botón para ocultar un menú.
     * El menú puede usar la clase .visible, y el botón la clase .activo
     */
    var ToggleNavegacion = function(menu, boton) {
        var menu = $(menu)
        var boton = $(boton)

        function cerrarMenu() {
            boton.removeClass('activo');
            menu.slideUp(400, function() {
                menu.removeClass('visible')
                menu.removeAttr('style')
            })
        }

        function abrirMenu() {
            boton.addClass('activo');
            menu.slideDown(400, function() {
                menu.addClass('visible')
                menu.removeAttr('style')
            })
        }

        boton.click(function() {
            if (menu.hasClass('visible')) {
                cerrarMenu()
            } else {
                abrirMenu()
            }
        })

        $(window).on('changed.zf.mediaquery', function(){
            if (menu.hasClass('visible')) {
                boton.removeClass('activo');
                menu.removeClass('visible')
            }
        });
    }

    new ToggleNavegacion('.nav-cabecera', '.toggleNavCabecera')
})
