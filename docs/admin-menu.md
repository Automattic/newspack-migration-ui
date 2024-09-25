# Admin menu

The Newspack Migration UI plugin adds a new menu item to the WordPress admin menu. Look for the "Migration 🦈" item.

## On posts
* "🆔 234" (where 234 is the ID of the post). Clicking the menu item copies the post id to your clipboard.
* "👀 post on staging" will take you to the post on the staging site. It uses the `NP_STAGING` constant, so you need to set that somewhere (like in wp-config.php).
* "👀 post on live" will take you to the post on the live site. It uses the `NP_LIVE` constant, so you need to set that somewhere (like in wp-config.php).

If you need to filter the urls (for if you migrate a site where the live paths are very different), there are two filters available:
`newspack_migration_ui_admin_menu_live_url` and `newspack_migration_ui_admin_menu_staging_url`.

An example implementation could look something like this:
```php
function filter_drupal_live_url( string $liveurl, string $localurl ): string {

	$nid = get_post_meta( get_the_ID(), '_fgd2wp_old_node_id', true );
	if ( empty( $nid ) ) {
		return $liveurl;
	}
	$options = get_option( 'fgd2wp_options' );
	if ( empty( $options['url'] ) ) {
		return $liveurl;
	}

	return trailingslashit( $options['url'] ) . 'node/' . $nid;
}
```

