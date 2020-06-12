const path = require('path');
const glob = require('glob');

const html_webpack_plug = require('html-webpack-plugin');

const C = (() => {
  return require("./workspace.config.js");
})();

let exclude_reg_list = C.build.EXCLUDE.map((ex) => new RegExp(ex));

let conf = {

  mode: 'development',

  entry: (() => {
    let entries = {};
    for(let k in C.build.ENTRY){
      let pts = glob.sync(C.build.ENTRY[k] + "/*.{js,ts}");
      for(let p of pts){
        let pinf = path.parse(p);
        entries[pinf.name] = p;
      }
    }
    console.log("Target Entries: ", entries);
    return entries;
  })(),

  output: {
    path: path.resolve(__dirname, C.build.DESTINATION),
    filename: "[name].js"
  },

  resolve: {
    modules: Object.keys(C.build.ENTRY).map((k) => {
      let r = C.build.ENTRY[k];
      return path.resolve(__dirname, r);
    }),
    extensions: [
      '.ts', '.tsx', '.js'
    ]
  },

  plugins: [
    new (require('vue-loader/lib/plugin'))(),
  ].concat((() => {
    return C.build.PAGE.map((p) => {
      return new html_webpack_plug({ template: p })
    })
  })()),

  module: {
    rules: [
      //{
      //  test: /\.s[ac]ss$/i,
      //  use: [
      //    // Creates `style` nodes from JS strings
      //    'style-loader',
      //    'css-loader',
      //    // Compiles Sass to CSS
      //    'sass-loader',
      //  ],
      //},
      {
        test: /\.htm(l?)$/i,
        loader: 'html-loader',
      },
      {
        test: /\.vue$/,
        exclude: [].concat(exclude_reg_list),
        use: [
          { loader: 'vue-loader' },
          { loader: 'vue-style-loader' }
        ]
      },
      {
        test: /\.ts(x?)$/,
        exclude: [].concat(exclude_reg_list),
        use: [
          {
            loader: 'babel-loader',
            options: {
              cacheDirectory: true,
              presets: [
                ["@babel/env"]
              ]
            }
          },
          {
            loader: 'ts-loader',
            options: {
              // If your project takes too long to build with type-checkings.
              //transpileOnly: true,
            }
          }
        ]
      },
      {
        test: /\.js$/,
        exclude: [].concat(exclude_reg_list),
        use: [
          {
            loader: 'babel-loader',
            options: {
              cacheDirectory: true,
              presets: [
                ["@babel/env"]
              ]
            }
          },
          {
            loader: 'eslint-loader',
          }
        ]
      },
    ]

  }
}

module.exports = conf;