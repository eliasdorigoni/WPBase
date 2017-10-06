/**
 * Para mapas de varios lugares.
 * Centra el mapa en los límites de todos los marcadores.
 * Usa un sprite de iconos alineados horizontalmente como iconos de los marcadores.
 */

function initMap() {
    var lugares = [
        ['Titulo 1', -31.5393643, -58.0082182],
        ['Titulo 2', -31.530651, -58.015661],
        ['Titulo 3', -31.531220, -58.016178],
    ]

    var map = new google.maps.Map(document.getElementById('mapa'), {
        zoom: 16,
        mapTypeId: 'satellite',
    })

    var escala = 0.75
    var dimensionesSprite = [300, 100]
    var dimensionesIcono = [100, 100]
    var imagen = {
        origin:     new google.maps.Point(0, 0),
        scaledSize: new google.maps.Size(dimensionesSprite[0] * escala, dimensionesSprite[1] * escala),
        size:       new google.maps.Size(dimensionesIcono[0] * escala, dimensionesIcono[1] * escala),
        url:        WPURLS.theme_uri + 'assets/img/mapa/sprite-mapa.png',
    };

    var latLng,
        marcador,
        markerBounds = new google.maps.LatLngBounds()

    for (i in lugares) {
        imagen.origin = new google.maps.Point((dimensionesIcono[0] * escala) * i, 0)
        latLng = new google.maps.LatLng(lugares[i][1], lugares[i][2])
        marcador = new google.maps.Marker({
            title: lugares[i][0],
            icon: imagen,
            position: latLng,
            map: map,
        })
        markerBounds.extend(latLng)
    }

    map.fitBounds(markerBounds)
}
