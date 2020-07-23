module.exports = {
  devServer: {
    proxy: 'http://skeleton.test'
  },

  // output built static files to Laravel's public dir.
  // note the "build" script in package.json needs to be modified as well.
  outputDir: '../../public/assets',

  publicPath: process.env.NODE_ENV === 'production'
    ? '/assets/'
    : '/',

  // modify the location of the generated HTML file.
  indexPath: process.env.NODE_ENV === 'production'
    ? '../../resources/views/app.blade.php'
    : 'index.html',

  chainWebpack: config => {
    config.module
      .rule("i18n")
      .resourceQuery(/blockType=i18n/)
      .type('javascript/auto')
      .use("i18n")
        .loader("@kazupon/vue-i18n-loader")
        .end()
  }
}