<?php
/**
 * Newspack Migration UI
 *
 * @package Newspack
 */

defined( 'ABSPATH' ) || exit;

require_once NEWSPACK_MIGRATION_UI_PLUGIN_FILE . '/vendor/autoload.php';

/**
 * Main Newspack Migration UI Class.
 */
final class Newspack_Migration_UI {
	
	/**
	 * Initializer.
	 */
	public static function init() {

	}

	/**
	 * Temporary way to get all of the migrated data.
	 * We'll want to use whatever general purpose method the migrator provides once ready.
	 *
	 * @return array Array of JSON.
	 */
	public static function get_migrated_data() {
		global $wpdb;

		return $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE 'full_initial_migration1_%'", ARRAY_A );
	}
}
Newspack_Migration_UI::init();
