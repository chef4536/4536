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
      },
      {
        test: /\.css/,
        use: [
          'style-loader',
          {
            loader: 'css-loader',
            options: {
              url: false,
              // minimize: true,
              // sourceMap: enabledSourceMap,
            }
          },
        ],
      },
    ]
  }
};

//参考：https://ics.media/entry/16028#webpack-babel-react
