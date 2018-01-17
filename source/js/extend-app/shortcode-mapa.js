function initMap() {
    if (typeof configMapa === 'undefined') {
        return
    }

    var map = new google.maps.Map(
        document.getElementById(configMapa.idMapa),
        {mapTypeId: configMapa.tipo, zoom: configMapa.zoom, }
    )
    var markerBounds = new google.maps.LatLngBounds()

    google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
        map.setZoom(configMapa.zoom)
    })

    if (configMapa.marcadores.length > 0) {
        for (i in configMapa.marcadores) {
            var marcador = configMapa.marcadores[i]
            var args = {
                clickable: false,
                map: map,
                position: null,
                title: marcador.titulo,
            }

            var latLng = new google.maps.LatLng(
                marcador.coordenadas[0],
                marcador.coordenadas[1]
            )

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
        }

        map.fitBounds(markerBounds)
    }
}
