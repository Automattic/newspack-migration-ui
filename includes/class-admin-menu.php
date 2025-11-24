<?php

namespace Newspack_MigrationUi;

use WP_Admin_Bar;

class Admin_Menu {

	/**
	 * This function is called when the class is included.
	 */
	public static function go(): void {
		static $did_go = false;
		if ( $did_go ) {
			return;
		}

		$did_go = true;
		if ( ! is_admin() ) {
			add_action( 'plugins_loaded', [ __CLASS__, 'on_plugins_loaded_frontend' ] );
		}
	}

	/**
	 * Do our thing on the frontend.
	 *
	 * @return void
	 */
	public static function on_plugins_loaded_frontend(): void {
		add_action( 'wp_before_admin_bar_render', [ __CLASS__, 'add_admin_menu' ] );
		add_action( 'admin_bar_menu', [ __CLASS__, 'add_custom_link_to_admin_bar' ], 999 );
	}

	/**
	 * Add the top level admin menu item.
	 *
	 * @return void
	 */
	public static function add_admin_menu(): void {
		global $wp_admin_bar;
		$wp_admin_bar->add_menu(
			[
				'parent' => false,
				'id'     => 'migration_ui_admin_menu',
				'title'  => __( 'Migration 🦈', 'migration-menu' ),
				'href'   => '#',
				'meta'   => [
					'class' => 'migration-menu',
				],
			]
		);
	}

	/**
	 * Add the menu items to the admin bar.
	 *
	 * @param WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar to add to/alter.
	 *
	 * @return void
	 */
	public static function add_custom_link_to_admin_bar( WP_Admin_Bar $wp_admin_bar ): void {
		if ( ! is_single() ) {
			return;
		}
		if ( defined( 'NP_STAGING' ) ) {
			$wp_admin_bar->add_node(
				[
					'id'     => 'np-on-staging',
					'parent' => 'migration_ui_admin_menu',
					'title'  => '👀 post on staging',
					'href'   => self::get_staging_url_for_post( get_permalink() ),
					'meta'   => [ 'target' => '_blank' ],
				] 
			);
		}

		if ( defined( 'NP_LIVE' ) ) {
			$wp_admin_bar->add_node(
				[
					'id'     => 'np-on-live',
					'parent' => 'migration_ui_admin_menu',
					'title'  => '👀 post on live',
					'href'   => self::get_live_url_for_post( get_permalink() ),
					'meta'   => [ 'target' => '_blank' ],
				] 
			);
		}
		$pid = get_the_ID();
		$wp_admin_bar->add_node(
			[
				'id'     => 'np-post-id',
				'parent' => 'migration_ui_admin_menu',
				'title'  => "<span id='nax-pid-icon'>🆔</span> $pid",
				'href'   => '',
				'meta'   => [ 'onclick' => sprintf( 'navigator.clipboard.writeText(%d);this.querySelector("#nax-pid-icon").innerHTML = "%s";', $pid, '👍' ) ],
			] 
		);
	}

	/**
	 * Get the staging URL for the site.
	 *
	 * If the NP_STAGING constant is defined, it will be used to replace the host in the URL.
	 * See docs/admin-menu.md
	 *
	 * @param string $local_url The local URL.
	 *
	 * @return string
	 */
	public static function get_staging_url_for_post( string $local_url ): string {
		if ( ! defined( 'NP_STAGING' ) ) {
			return $local_url;
		}
		$host        = wp_parse_url( $local_url, PHP_URL_HOST );
		$staging_url = str_replace( $host . '/', NP_STAGING . '/', $local_url );

		return apply_filters( 'newspack_migration_ui_admin_menu_staging_url', $staging_url );
	}

	/**
	 * Get the live URL for the site.
	 *
	 * If the NP_LIVE constant is defined, it will be used to replace the host in the URL.
	 * See docs/admin-menu.md
	 *
	 * @param string $local_url The local URL.
	 *
	 * @return string
	 */
	public static function get_live_url_for_post( string $local_url ): string {
		if ( ! defined( 'NP_LIVE' ) ) {
			return $local_url;
		}
		$host = wp_parse_url( $local_url, PHP_URL_HOST );

		$live_url = str_replace( $host . '/', NP_LIVE . '/', $local_url );

		return apply_filters( 'newspack_migration_ui_admin_menu_live_url', $live_url, $local_url );
	}
}

Admin_Menu::go();
