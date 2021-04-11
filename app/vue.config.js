const path = require('path');
const webpack = require('webpack');
module.exports = {
  configureWebpack: {
    devtool: 'none',
    output: {
      filename: "[name].js",
      chunkFilename: "[name].js",
      path: path.resolve(__dirname, 'dist'),
    },
    plugins: [
      new webpack.optimize.LimitChunkCountPlugin({
        maxChunks: 1,
      }),
    ],
  },

  chainWebpack: config => {
    if (config.plugins.has("extract-css")) {
      const extractCSSPlugin = config.plugin("extract-css");
      extractCSSPlugin &&
        extractCSSPlugin.tap(() => [
          {
            filename: "[name].css",
            chunkFilename: "[name].css",
            path: path.resolve(__dirname, 'dist'),
          }
        ]);
    }

    config.optimization.splitChunks(false)
  }
};
