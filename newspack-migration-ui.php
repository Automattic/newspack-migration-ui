<?php
/**
 * Plugin Name:     Newspack Migration UI
 * Plugin URI:      https://newspack.com
 * Description:     An interface for visually QA'ing site migrations.
 * Author:          Automattic
 * Author URI:      https://newspack.com
 * Text Domain:     newspack-migration-ui
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Newspack_Migration_UI
 */

defined( 'ABSPATH' ) || exit;

// Define NEWSPACK_MIGRATION_UI_PLUGIN_FILE.
if ( ! defined( 'NEWSPACK_MIGRATION_UI_PLUGIN_FILE' ) ) {
	define( 'NEWSPACK_MIGRATION_UI_PLUGIN_FILE', plugin_dir_path( __FILE__ ) );
}

// Include the main Newspack Migration UI class.
if ( ! class_exists( 'Newspack_Migration_UI' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-newspack-migration-ui.php';
}
