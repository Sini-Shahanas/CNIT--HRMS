// eslint-disable-next-line @typescript-eslint/no-var-requires
const DumpBuildTimestampPlugin = require('./scripts/plugins/DumpBuildTimestampPlugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
  css: {
    loaderOptions: {
      sass: {
        additionalData: `@import "@/core/styles";`,
      },
    },
    extract: true,
  },
  configureWebpack: {
    resolve: {
      alias: {
        '@ohrm/core': '@/core',
        '@ohrm/components': '@/core/components',
      },
    },
    plugins: [new DumpBuildTimestampPlugin()],
  },
  chainWebpack: (config) => {
    // config.plugins.delete('html');
    config.plugin('html')
      .use(HtmlWebpackPlugin, [{
        template: 'public/index.html', // Adjust this path as needed
        title: 'Cloud HRM',
        BASE_URL: './',
      }]);
    config.plugins.delete('preload');
    config.plugins.delete('prefetch');
  },
  publicPath: '.',
  filenameHashing: false,
  runtimeCompiler: true,
};