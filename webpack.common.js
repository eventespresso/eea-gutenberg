const path = require('path');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const assets = './src/assets/src/';
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const combineLoaders = require('webpack-combine-loaders');
const wpExternals = [
  'blocks',
  'element',
];
const externals = {};
[ ...wpExternals ].forEach(name => {
    externals[`@wordpress/${name}`] = {this:['wp', name]}
});
/** see below for multiple configurations.
 * - one configuration would be to have os-common.js built as a library with the target being osjs.[name]
 *   (see how gutenberg exported wpjs object: https://github.com/WordPress/gutenberg/blob/master/webpack.config.js)
 * - the other configuration will be something similar to below where we setup the "main" js files that would be
 *   enqueued by wp.
 * - a problem I will encounter is that I'm using webpack-merge to do a dev and a production build.  That makes things
 *   more tricky with the multiple configurations.
 *
 */
/** https://webpack.js.org/configuration/configuration-types/#exporting-multiple-configurations */
config = [
    {
        entry: {
            'ee-blocks': [
                'babel-polyfill',
                assets + 'blocks/index.js'
            ]
        },
        plugins: [
            new CleanWebpackPlugin(['src/assets/dist']),
            new ExtractTextPlugin('style.css')
        ],
        output: {
            filename: '[name].dist.js',
            path: path.resolve(__dirname, 'src/assets/dist')
        },
        externals,
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: "babel-loader"
                },
                {
                    test: /\.css$/,
                    loader: ExtractTextPlugin.extract(
                        combineLoaders([{
                            loader: 'css-loader',
                            query: {
                                modules: true,
                                localIdentName: '[local]'
                            }
                        }])
                    )
                }
            ]
        }
    }
];
module.exports = config;