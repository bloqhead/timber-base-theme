const path = require('path')
const UglifyJSPlugin = require('uglifyjs-webpack-plugin')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const LiveReloadPlugin = require('webpack-livereload-plugin')
const FriendlyErrorsPlugin = require('friendly-errors-webpack-plugin')

const ExtractedSass = new ExtractTextPlugin({
  filename: '../css/style.css'
})

module.exports = {
  watch: true,
  entry: './assets/js/main.js',
  output: {
    filename: '[name].min.js',
    path: path.resolve(__dirname, 'assets/js')
  },
  externals: {
    jquery: 'jQuery'
  },
  plugins: [
    ExtractedSass,
    new UglifyJSPlugin(),
    new LiveReloadPlugin({
      protocol: 'http',
      port: '35729',
      appendScriptTag: false,
      delay: 0
    })
  ],
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: ExtractedSass.extract({
          use: [{
            loader: "css-loader",
            options: {
              minimize: true
            }
        }, {
          loader: "sass-loader"
        }],
        fallback: "style-loader"
        })
      },
      {
        test: /\.js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['babel-preset-env']
          }
        }
      }
    ]
  }
}