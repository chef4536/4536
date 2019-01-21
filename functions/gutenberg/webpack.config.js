module.exports = {

    mode: 'production',

    entry: './src/_main.js',

    output: {
        path: `${__dirname}/dist`,
        filename: 'bundle.js'
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
