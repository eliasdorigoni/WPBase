var argv = require('yargs').argv,
    path = require('path')

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
}

module.exports.esBuild()
