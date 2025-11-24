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
		self::includes();
	}

	private static function includes() {
		include_once NEWSPACK_MIGRATION_UI_PLUGIN_FILE . '/includes/class-admin-menu.php';
	}
}
Newspack_Migration_UI::init();
