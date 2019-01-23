module.exports = {

  mode: 'production',

  entry: {
    main_bundle: './js/main.js',
    custom_block: './functions/gutenberg/src/_main.js',
  },

  output: {
    filename: '[name].js'
  },

  module: {
    rules: [
      {
        test: /\.js$/,
        use: [{
          loader: 'babel-loader',
          options: {
            presets: [
              '@babel/preset-env',
              '@babel/react',
            ]
          }
        }]
      }
    ]
  }
};

//参考：https://ics.media/entry/16028#webpack-babel-react
