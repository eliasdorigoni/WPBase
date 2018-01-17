function initMap() {
    if (typeof configMapa === 'undefined') {
        return
    }

    var map = new google.maps.Map(
        document.getElementById(configMapa.idMapa),
        {mapTypeId: configMapa.tipo, zoom: configMapa.zoom, }
    )

    var markerBounds = new google.maps.LatLngBounds()

    if (typeof configMapa.marcadores == 'object') {

        configMapa.marcadores.map(function(marcador) {
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

            var m = new google.maps.Marker(args)

            if (args.clickable) {
                m.addListener('click', function() {
                    window.open(marcador.url, '_blank');
                })
            }

            markerBounds.extend(latLng)
        })

        // Aleja el zoom hasta lo establecido por configMapa, después de que fitBounds modifique los limites.
        google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
            if (map.getZoom() > configMapa.zoom) {
                map.setZoom(configMapa.zoom)
            }
        })

        map.fitBounds(markerBounds)
    }
}
