<?php

namespace Newspack_MigrationUI;

class REST_API_Controller {
    public $namespace = '/newspack-migrationui/v1';
    public $resource = 'migrations';

    public function __construct() {
        //
    }

    // Register our routes.
    public function register_routes() {
        register_rest_route( $this->namespace, '/' . $this->resource, array(
            // Here we register the readable endpoint for collections.
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'get_items' ),
                // 'permission_callback' => array( $this, 'get_items_permissions_check' ),
            ),
            // Register our schema callback.
            // 'schema' => array( $this, 'get_item_schema' ),
        ) );
    }

    public function get_items_permissions_check() {
        return current_user_can( 'manage_options' );
    }

    public function get_items() {
        global $wpdb;

        $migration_options = $wpdb->get_results( "SELECT DISTINCT(`option_name`) FROM `$wpdb->options` WHERE `option_name` LIKE '%full_initial_migration%'" );

        $migration_names = [];
        foreach ( $migration_options as $migration_option ) {
            preg_match( '~full_initial_migration([0-9]+)~', $migration_option->option_name, $matches );

            $migration_names[] = $matches[1];
        }

        return array_map( function ($index) use ($migration_options, $wpdb) {
            $migration_objects = [];

            foreach ( $migration_options as $migration_option ) {
                if (preg_match( 
                    '~full_initial_migration'. $index .'_(migration_object_([0-9]+))~', $migration_option->option_name,
                    $matches
                ) ) {
                    $migration_objects[] = 'post:' . $matches[2];
                }
            }

            return [
                'id' => $index,
                'name' => 'Migration ' . $index,
                'objects' => array_map( function ( $migration_object ) use ($wpdb, $index) {
                    $migration_object = explode(':', $migration_object);

                    $object_id = null;
                    $object_type = $migration_object[0];
                    $object_source_id = $migration_object[1];

                    if ( $object_type === 'post' ) {
                        $object_id = $wpdb->get_var(
                            sprintf(
                                "SELECT `post_id`
                                FROM `$wpdb->postmeta`
                                WHERE `meta_key` LIKE 'full_initial_migration%d_migration_object_source_%d_%%'",
                                $index, $object_source_id )
                        );
                    }

                    return [
                        'ID' => $object_id,
                        'source_ID' => $migration_object[1],
                        'type' => $migration_object[0],
                        'permalink' => match ($object_type) {
                            'post' => ! empty( $object_id ) ? get_permalink( $object_id ) : null,
                            // 'user' => ! empty( $object_id ) ? get_permalink( $object_id ) : null,
                            default => null,
                        }
                    ];
                }, array_values(array_unique( $migration_objects )) )
            ];
        }, array_unique( $migration_names ) );
    }

    public function get_item() {

    }
}