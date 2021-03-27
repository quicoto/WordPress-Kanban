const path = require('path');

module.exports = {
  configureWebpack: {
    devtool: 'none',
    output: {
      filename: "[name].js",
      chunkFilename: "[name].js",
      path: path.resolve(__dirname, 'dist'),
    }
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
  }
};
