const path = require('path');
module.exports = {
	mode: 'production',
	entry: {
		'dist/main_bundle': './resources/js/main.js',
		'dist/custom_block': './resources/functions/gutenberg/src/_main.js'
  	},
	output: {
		filename: '[name].js',
		path: path.join(__dirname, '/resources')
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
