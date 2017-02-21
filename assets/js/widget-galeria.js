jQuery(function($) {
    function actualizarRestantes() {
        if ($widget.find('.restantes').length > 0)
            $widget.find('.restantes').html(maximo - cantidadImagenes)
    }

    function imagenExiste(id) {
        var retorno = false
        $widget.find('input').each(function(k, v) {
            if (v.value == id)
                retorno = true
        })
        return retorno
    }

    function eliminarImagen(e) {
        $(this).parents('li').remove()
        cantidadImagenes--
        actualizarRestantes()
    }

    function reemplazarImagen(e) {
        e.preventDefault()
        var $input = $(this).parents('li')
        var custom_uploader = wp.media(
            {
                title: 'Reemplazar imagen',
                button: {
                    text: 'Reemplazar'
                },
                multiple: false,
            }
        ).on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON()
            if (!imagenExiste(attachment.id)) {
                $input.find('input').val(attachment.id)
                $input.find('img').attr('src', attachment.sizes.thumbnail.url)
            }
        })
        .open();
    }

    function agregarImagen(e) {
        event.preventDefault();
        var custom_uploader = wp.media({
            title: 'Agregar imágenes a la galería',
            button: {
                text: 'Agregar'
            },
            multiple: true,
        })
        .on('select', function() {
            var models = custom_uploader.state().get('selection').models
            for(i in models) {
                var attachment = models[i].toJSON()
                if (!imagenExiste(attachment.id)) {
                    var $nuevo = $(li)
                    $nuevo.find('input').val(attachment.id)
                    $nuevo.find('img').attr('src', attachment.sizes.thumbnail.url)

                    $widget.find('ul').append($nuevo)
                    cantidadImagenes++
                }
            }
            actualizarRestantes()
        })
        .open();
    }

    var $widget = $('.widgetGaleriaJS')
    var cantidadImagenes = $widget.find('input').length

    $widget.on('click', '.eliminar', eliminarImagen)
             .on('click', '.reemplazar', reemplazarImagen)
             .on('click', '.cargarImagenJS', agregarImagen)

});
