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
		add_action( 'admin_menu', [ __CLASS__, 'admin_page' ] );
		add_action( 'rest_api_init', [ __CLASS__, 'register_api_routes' ] );
	}

	public static function admin_page() {
		add_menu_page(
			'Newspack Migration UI',
			'Newspack Migration UI',
			'manage_options',
			'newspack-migration-ui',
			[ __CLASS__, 'menu_page' ],
		);
	}

	public static function menu_page() {
		?>
		Test
		<?php
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

	public static function get_migration_names() {

	}

	public static function register_api_routes() {
		require_once __DIR__ . '/class-newspack-migration-rest-api-controller.php';
		require_once __DIR__ . '/class-newspack-migration-rest-api-migration-objects-controller.php';

		(new \Newspack_MigrationUI\REST_API_Migration_Objects_Controller)->register_routes();
		(new \Newspack_MigrationUI\REST_API_Controller)->register_routes();
	}
}

Newspack_Migration_UI::init();
