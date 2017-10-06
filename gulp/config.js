var argv = require('yargs').argv,
    path = require('path')

function armarDependenciasFoundation(plugins) {
    if (typeof plugins !== 'object' || plugins.length == 0) {
        return '';
    }

    var dependenciasRequeridas = [
        'core',
        'util.mediaQuery',
    ]

    var utilidadesDisponibles = [
        'util.box',
        'util.keyboard',
        'util.imageLoader',
        'util.motion',
        'util.nest',
        'util.timer',
        'util.timerAndImageLoader',
        'util.touch',
        'util.triggers',
    ]

    var pluginsDisponibles = {
        'abide': [
        ],
        'accordion': [
            'util.keyboard'
        ],
        'accordionMenu': [
            'util.keyboard',
            'util.nest',
        ],
        'drilldown': [
            'util.keyboard',
            'util.nest',
            'util.box',
        ],
        'dropdown': [
            'util.keyboard',
            'util.box',
            'util.triggers',
        ],
        'dropdownMenu': [
            'util.keyboard',
            'util.box',
            'util.nest',
        ],
        'equalizer': [
            'util.mediaQuery',
            'util.imageLoader', // Usar si tiene imagenes.
        ],
        'interchange': [
            'util.mediaQuery'
        ],
        'magellan': [
            'smoothScroll'
        ],
        'offcanvas': [
            'util.keyboard',
            'util.mediaQuery',
            'util.triggers',
        ],
        'orbit': [
            'util.keyboard',
            'util.motion',
            'util.timerAndImageLoader',
            'util.touch',
        ],
        'responsiveAccordionTabs': [
            'util.motion',
            'accordion',
            'tabs',
        ],
        'responsiveMenu': [
            'util.triggers',
            'util.mediaQuery',
        ],
        'responsiveToggle': [
            'util.mediaQuery',
            'util.motion',
        ],
        'reveal': [
            'util.keyboard',
            'util.triggers',
            'util.mediaQuery',
            'util.motion', // Usar si hay animaciones
        ],
        'slider': [
            'util.motion',
            'util.triggers',
            'util.keyboard',
            'util.touch',
        ],
        'smoothScroll': [
        ],
        'sticky': [
            'util.triggers',
            'util.mediaQuery',
        ],
        'tabs': [
            'util.keyboard',
            'util.imageLoader', // Usar si tiene imagenes
        ],
        'toggler': [
            'util.motion',
            'util.triggers',
        ],
        'tooltip': [
            'util.box',
            'util.mediaQuery',
            'util.triggers',
        ],
    }

    var utilidadesUsadas = [],
        pluginsUsados = []

    for (i in pluginsDisponibles) {
        if (plugins.indexOf(i) === -1) {
            continue;
        }

        for (j in pluginsDisponibles[i]) {
            var plugin = pluginsDisponibles[i][j]
            if (utilidadesUsadas.indexOf(plugin) === -1 && dependenciasRequeridas.indexOf(plugin) === -1) {
                utilidadesUsadas.push(plugin)
            }
        }
        pluginsUsados.push(i)
    }

    if (utilidadesUsadas.length > 0) {
        var scripts = dependenciasRequeridas.concat(utilidadesUsadas, pluginsUsados)
        for (i in scripts) {
            scripts[i] = './node_modules/foundation-sites/dist/js/plugins/foundation.' + scripts[i] + '.js'
        }
        return scripts
    }
    return []
}

module.exports = {
    dir: {
        root: './',
        assets: './assets/',
        theme: path.resolve('./') + '\\',
    },
    esBuild: function(bool) {
        if (typeof bool === 'boolean') {
            // bool esta configurado
        } else if (typeof argv.build === 'boolean') {
            // Si --build esta definido, es boolean (true)
            bool = argv.build
        } else {
            bool = false
        }

        if (bool === true) {
            this.dir.root = './build/' + path.resolve('./').split('\\').pop() + '/'
        } else {
            this.dir.root = './'
        }
        this.dir.assets = this.dir.root + 'assets/'

        return bool
    },
    dependenciasJS: armarDependenciasFoundation(['equalizer', 'offcanvas', 'reveal', 'toggler']),
}

module.exports.esBuild() // Corrige el directorio si existe la bandera --build
