jQuery(function($) {

    var limitarCantidad = (typeof limite == 'string') ? true : false;
    var cantidadImagenesGaleria = $('.media-upload input').length

    var actualizarRestantes = function() {
        $('.media-upload p span').html(maximo - cantidadImagenesGaleria)
    }

    var imagenExiste = function(id) {
        var retorno = false
        $('.media-upload input').each(function(k, v) {
            if (v.value == id)
                retorno = true
        })
        return retorno
    }

    $('.cargarImagenJS').click(function(event) {
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
                    var $nuevo = $(input)
                    $nuevo.find('input').val(attachment.id)
                    $nuevo.find('img').attr('src', attachment.sizes.thumbnail.url)
                    $('.media-upload ul').append($nuevo)
                    cantidadImagenesGaleria++
                    actualizarRestantes()
                }
            }
        })
        .open();
    });

    $('.media-upload').on('click', '.eliminar', function() {
        $(this).parents('li').remove()
        cantidadImagenesGaleria--
        actualizarRestantes()
    }).on('click', '.thumb', function(event) {
        event.preventDefault()
        var $input = $(this).parents('li')
        var custom_uploader = wp.media({
            title: 'Reemplazar imagen',
            button: {
                text: 'Reemplazar'
            },
            multiple: false,
        })
        .on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON()
            if (!imagenExiste(attachment.id)) {
                $input.find('input').val(attachment.id)
                $input.find('img').attr('src', attachment.sizes.thumbnail.url)
            }
        })
        .open();
    })
});
