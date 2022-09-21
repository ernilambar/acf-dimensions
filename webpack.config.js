const path = require( 'path' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const { CleanWebpackPlugin } = require( 'clean-webpack-plugin' );
const CssMinimizerPlugin = require( 'css-minimizer-webpack-plugin' );
const TerserPlugin = require( 'terser-webpack-plugin' );

const isProd = process.env.NODE_ENV === 'production';

module.exports = {
	entry: {
		input: './src/input.js',
	},
	output: {
		path: path.resolve( __dirname, 'assets' ),
		assetModuleFilename: 'static/[name][ext][query]',
		filename: '[name].js',
	},
	target: 'browserslist',
	externals: {
		jquery: 'jQuery',
	},
	mode: isProd ? 'production' : 'development',
	devtool: isProd ? false : 'inline-source-map',
	module: {
		rules: [
			{
				test: /\.(js|jsx)$/,
				exclude: /(node_modules|bower_components)/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: [ '@babel/preset-env' ],
					},
				},
			},
			{
				test: /\.(css|scss)$/,
				use: [
					MiniCssExtractPlugin.loader,
					'css-loader',
					{
						loader: 'postcss-loader',
						options: {
							postcssOptions: {
								plugins: [
									[ 'postcss-preset-env' ],
								],
							},
						},
					},
					'sass-loader',
				],
			},
			{
				test: /\.(png|svg|jpg|jpeg|gif)$/i,
				type: 'asset/resource',
			},
		],
	},
	plugins: [
		new CleanWebpackPlugin(),
		new MiniCssExtractPlugin( { filename: '[name].css' } ),
	],
	optimization: {
		minimizer: [
			new TerserPlugin( { extractComments: false } ),
			new CssMinimizerPlugin(),
		],
	},
};
