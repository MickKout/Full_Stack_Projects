<?php
/**
 * Stayora — Custom Taxonomies
 *
 * @package Stayora
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'stayora_register_taxonomies' );

function stayora_register_taxonomies() {

    // Room Type (Hotel Room, Villa, Suite, Bungalow, etc.)
    register_taxonomy( 'room_type', 'accommodation', [
        'label'             => __( 'Room Types', 'stayora' ),
        'labels'            => [
            'name'          => __( 'Room Types',    'stayora' ),
            'singular_name' => __( 'Room Type',     'stayora' ),
            'add_new_item'  => __( 'Add Room Type',  'stayora' ),
        ],
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'rewrite'           => [ 'slug' => 'room-type' ],
        'show_admin_column' => true,
    ] );

    // Amenity (WiFi, Pool, AC, etc.)
    register_taxonomy( 'amenity', 'accommodation', [
        'label'             => __( 'Amenities', 'stayora' ),
        'labels'            => [
            'name'          => __( 'Amenities', 'stayora' ),
            'singular_name' => __( 'Amenity',   'stayora' ),
            'add_new_item'  => __( 'Add Amenity', 'stayora' ),
        ],
        'public'            => true,
        'hierarchical'      => false,
        'show_in_rest'      => true,
        'rewrite'           => [ 'slug' => 'amenity' ],
        'show_admin_column' => true,
    ] );

    // Location / Destination
    register_taxonomy( 'accommodation_location', [ 'accommodation', 'attraction' ], [
        'label'             => __( 'Locations', 'stayora' ),
        'labels'            => [
            'name'          => __( 'Locations', 'stayora' ),
            'singular_name' => __( 'Location',  'stayora' ),
            'add_new_item'  => __( 'Add Location', 'stayora' ),
        ],
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'rewrite'           => [ 'slug' => 'location' ],
        'show_admin_column' => true,
    ] );
}
