// This is shared-configuration between Gulp and Webpack
//
// ==== A Notion for Windows ====
// DONT use \ backslash as a path-separator.
// the backslashes will be escaped with \\
// and glob-module wont be able to find path properly.

module.exports = {

  build: {

    // Adjust src/dist path accordingly.
    // bootstrap: "src" means...
    // glob(./src/*.js),or .ts is an entry point.
    ENTRY: {
      "bootstrap": "./src"
    },
    DIST_DIR: "wptm/asset/dist",

    // Gulp-GLOB and Webpack.exclude, both uses this.
    EXCLUDE: [
      'node_modules',
      'vendor',
      'log',
      'cache'
    ],

    ASSET_GLOB: {
      STYLE: "**/*.{scss,sass,css}",
      SCRIPT: "**/*.{ts,js}",
    }

  }

};