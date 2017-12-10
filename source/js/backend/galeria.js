jQuery(function($) {
    var $galeria = $('#galeria')

    function cargarItemGaleria(e) {
        var $widget = $(this).parents('.componente-galeria')
        var cantidad = $widget.attr('data-maximo')
        var limitarCantidad = (cantidad > '0')

        var uploader = wp.media({
            title: 'Agregar imágenes a la galería',
            button: {text: 'Agregar'},
            multiple: true,
        })

        uploader.on('select', function() {
            var models = uploader.state().get('selection').models
            for(i in models) {
                if (limitarCantidad && $widget.find('.thumb').length === cantidad) {
                    break
                }
                var attachment = models[i].toJSON()
                var $nuevo = $('<li class="thumb"><input type="hidden" value="" name="" /><img src="" /> <button type="button" class="eliminar" title="Eliminar esta imagen">X</button> <button type="button" class="reemplazar" title="Reemplazar esta imagen">Reemplazar imagen</button></li>')
                $nuevo.find('input').attr('name', $widget.attr('data-name-input')).val(attachment.id)
                $nuevo.find('img').attr('src', attachment.sizes.thumbnail.url)
                $widget.find('ul').append($nuevo)
            }
            $widget.find('.cantidadActual').html($widget.find('.thumb').length)
        })

        uploader.open()
    }
    $galeria.on('click', '.componente-galeria .cargarImagenJS', cargarItemGaleria)

    function eliminarItemGaleria(e) {
        var $widget = $(this).parents('.componente-galeria')
        var cantidad = $widget.find('.thumb').length - 1
        $widget.find('.cantidadActual').html(cantidad)
        $(this).parents('li').remove()
    }
    $galeria.on('click', '.componente-galeria .eliminar', eliminarItemGaleria)

    function reemplazarItemGaleria(e) {
        var $thumb = $(this).parents('.thumb')

        var uploader = wp.media({
            title: 'Reemplazar imagen',
            button: {
                text: 'Reemplazar'
            },
            multiple: false,
        })

        uploader.on('select', function() {
            var attachment = uploader.state().get('selection').first().toJSON()
            $thumb.find('input').val(attachment.id)
            $thumb.find('img').attr('src', attachment.sizes.thumbnail.url)
        })

        uploader.open()
    }
    $galeria.on('click', '.componente-galeria .reemplazar', reemplazarItemGaleria)
})
