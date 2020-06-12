const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');

module.exports = {
  entry: {
    base: './src/theme.scss',
  },
  output: {
    // 全体の設定
    path: path.resolve(__dirname, './dest/'),
  },
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
          { loader: MiniCssExtractPlugin.loader },
          { loader: 'css-loader' },
          { loader: 'sass-loader' },
        ],
      }
    ],
  },
  plugins:[
    // cssの出力先を指定する
    new MiniCssExtractPlugin({ filename: '[name].css' }),
  ],
  optimization: {
    minimizer: [new OptimizeCSSAssetsPlugin({})],
  },
}