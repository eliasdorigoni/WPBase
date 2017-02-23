jQuery(function($) {
    var formatoThumb = '<li class="thumb"><input type="hidden" value="" name="" /><img src="" /> <button type="button" class="button eliminar">Eliminar</button> <button type="button" class="button reemplazar">Reemplazar</button></li>'

    $('body').on('click', '.widgetGaleriaJS .eliminar', function() {
        var $widget = $(this).parents('.widgetGaleriaJS')
        var cantidad = $widget.find('.thumb').length - 1
        $widget.find('.cantidadActual').html(cantidad)
        $(this).parents('li').remove()
    }).on('click', '.widgetGaleriaJS .reemplazar', function(e) {
        var $thumb = $(this).parents('.thumb')

        var uploader = wp.media({
            title: 'Reemplazar imagen',
            button: {text: 'Reemplazar'},
            multiple: false,
        })

        uploader.on('select', function() {
            var attachment = uploader.state().get('selection').first().toJSON()
            $thumb.find('input').val(attachment.id)
            $thumb.find('img').attr('src', attachment.sizes.thumbnail.url)
        })

        uploader.open()
    }).on('click', '.widgetGaleriaJS .cargarImagenJS', function(e) {
        var $widget = $(this).parents('.widgetGaleriaJS')
        var cantidad = $widget.attr('data-maximo')
        var limitarCantidad = (cantidad > '0') ? true : false

        var uploader = wp.media({
            title: 'Agregar imágenes a la galería',
            button: {text: 'Agregar'},
            multiple: true,
        })

        uploader.on('select', function() {
            var models = uploader.state().get('selection').models
            for(i in models) {
                if (limitarCantidad && $widget.find('.thumb').length == cantidad) {
                    break
                }
                var attachment = models[i].toJSON()
                var $nuevo = $(formatoThumb)
                $nuevo.find('input').attr('name', $widget.attr('data-name-input')).val(attachment.id)
                $nuevo.find('img').attr('src', attachment.sizes.thumbnail.url)
                $widget.find('ul').append($nuevo)
            }
            $widget.find('.cantidadActual').html($widget.find('.thumb').length)
        })

        uploader.open()
    })
})
