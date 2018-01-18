function initMap() {
    var elemento = document.getElementById('js-mapa')
    if (elemento === null) {
        return
    }

    var map = new google.maps.Map(elemento, {mapTypeId: elemento.dataset.tipo, zoom: parseInt(elemento.dataset.zoom)}),
        markerBounds = new google.maps.LatLngBounds(),
        marcadores = elemento.dataset.marcadores,
        hayMarcadores = true

    try {
        marcadores = JSON.parse(marcadores)
    } catch (e) {
        // Si no hay marcadores, terminar.
        return
    }

    marcadores.map(function(marcador) {
        var args = {
            clickable: false,
            map: map,
            position: null,
            title: marcador.titulo,
        }

        var latLng = new google.maps.LatLng(marcador.coordenadas[0], marcador.coordenadas[1])
        args.position = latLng

        if (marcador.icono.length > 0) {
            args.icon = {
                size: new google.maps.Size(48, 48),
                scaledSize: new google.maps.Size(48, 48),
                url: marcador.icono,
            }
        }

        if (marcador.url.length > 0) {
            args.clickable = true
        }

        var marker = new google.maps.Marker(args)

        if (args.clickable) {
            marker.addListener('click', function() {
                window.open(marcador.url, '_blank');
            })
        }

        markerBounds.extend(latLng)
    })

    // Aleja el zoom hasta lo establecido por el usuario, después de que map.fitBounds() modifique los limites.
    google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
        var zoom = parseInt(elemento.dataset.zoom)
        if (map.getZoom() > zoom) {
            map.setZoom(zoom)
        }
    })

    map.fitBounds(markerBounds)
}
