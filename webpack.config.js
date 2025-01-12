/**
 **** WARNING: No ES6 modules here. Not transpiled! ****
 */
/* eslint-disable import/no-nodejs-modules */

/**
 * External dependencies
 */
const getBaseWebpackConfig = require( 'newspack-scripts/config/getWebpackConfig' );
const path = require( 'path' );

/**
 * Internal variables
 */
const editor = path.join( __dirname, 'src', 'editor' );

const webpackConfig = getBaseWebpackConfig(
	{ WP: true },
	{
		entry: { editor },
		'output-path': path.join( __dirname, 'dist' ),
	}
);

module.exports = webpackConfig;
