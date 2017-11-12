var argv = require('yargs').argv,
    path = require('path')

/**
 * Recibe un array de plugins y devuelve las rutas de los mismos con las dependencias requeridas.
 * @param  array    pluginsRequeridos  Plugins a usar
 * @return array                       Todos los scripts a procesar, o un array vacío.
 */
function armarDependenciasFoundation(pluginsRequeridos) {
    if (typeof pluginsRequeridos !== 'object' || pluginsRequeridos.length == 0) {
        return [];
    }

    var dependenciasObligatorias = [
            'core',
            'util.mediaQuery',
        ],
        utilidadesDisponibles = [
            'util.box',
            'util.keyboard',
            'util.imageLoader',
            'util.motion',
            'util.nest',
            'util.timer',
            'util.timerAndImageLoader',
            'util.touch',
            'util.triggers',
        ],
        pluginsDisponibles = {
            'abide': [],
            'accordion': ['util.keyboard'],
            'accordionMenu': ['util.keyboard', 'util.nest'],
            'drilldown': ['util.keyboard', 'util.nest', 'util.box'],
            'dropdown': ['util.keyboard', 'util.box', 'util.triggers'],
            'dropdownMenu': ['util.keyboard', 'util.box', 'util.nest'],
            // Usar util.imageLoader si el script maneja imagenes
            'equalizer': ['util.mediaQuery', 'util.imageLoader'],
            'interchange': ['util.mediaQuery'],
            'magellan': ['smoothScroll'],
            'offcanvas': ['util.keyboard', 'util.mediaQuery', 'util.triggers'],
            'orbit': ['util.keyboard', 'util.motion', 'util.timerAndImageLoader', 'util.touch'],
            'responsiveAccordionTabs': ['util.motion', 'accordion', 'tabs'],
            'responsiveMenu': ['util.triggers', 'util.mediaQuery'],
            'responsiveToggle': ['util.mediaQuery', 'util.motion'],
            // Usar util.motion si el script usa animaciones
            'reveal': ['util.keyboard', 'util.triggers', 'util.mediaQuery', 'util.motion'],
            'slider': ['util.motion', 'util.triggers', 'util.keyboard', 'util.touch'],
            'smoothScroll': [],
            'sticky': ['util.triggers', 'util.mediaQuery'],
            // Usar util.imageLoader si el script maneja imagenes
            'tabs': ['util.keyboard', 'util.imageLoader'],
            'toggler': ['util.motion', 'util.triggers'],
            'tooltip': ['util.box', 'util.mediaQuery', 'util.triggers'],
        },
        utilidadesRequeridas = [],
        pluginsUsados = []

    for (i in pluginsRequeridos) {
        var plugin = pluginsRequeridos[i]
        pluginsUsados.push(plugin)

        for (j in pluginsDisponibles[plugin]) {
            var dependencia = pluginsDisponibles[plugin][j]

            // Agrega el plugin si no fue agregado antes.
            if (utilidadesRequeridas.indexOf(dependencia) === -1 
                && dependenciasObligatorias.indexOf(dependencia) === -1) {
                utilidadesRequeridas.push(dependencia)
            }
        }
    }

    if (utilidadesRequeridas.length == 0) {
        return []
    }

    var scripts = dependenciasObligatorias.concat(utilidadesRequeridas, pluginsUsados).map(function(nombre) {
        return './node_modules/foundation-sites/dist/js/plugins/foundation.' + nombre + '.js'
    })

    return scripts
}

function esBuild() {
    return typeof argv.build === 'boolean'
}

function definirRoot() {
    var retorno = './'

    if (esBuild()) {
        var nombreTheme = path.resolve('./').split('\\').pop()
        retorno += 'build/' + nombreTheme + '/'
    }

    return retorno
}

var themeRoot = definirRoot()


module.exports = {
    esBuild: esBuild(),
    noEsBuild: !esBuild(),
    dependenciasJS: armarDependenciasFoundation(['equalizer', 'offcanvas', 'reveal', 'toggler']),
    dir: {
        root: themeRoot,
        assets: themeRoot + 'assets/',
    },
}
