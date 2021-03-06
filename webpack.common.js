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
/** https://webpack.js.org/configuration/configuration-types/#exporting-multiple-configurations */
config = [
    {
        entry: {
            'ee-shortcode-blocks': [
                assets + 'blocks/index.js'
            ],
            'ee-event-editor-blocks': [
                assets + 'blocks/event-editor-blocks/index.js'
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