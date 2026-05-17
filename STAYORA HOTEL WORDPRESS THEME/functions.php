<?php
/**
 * Stayora Theme — functions.php
 *
 * Architecture note: This file is intentionally lean. All functionality
 * is split into focused files inside /inc/ and loaded here. This keeps
 * each concern isolated and easy to override in a child theme.
 *
 * @package Stayora
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/* -------------------------------------------------------------------------
   Constants
------------------------------------------------------------------------- */
define( 'STAYORA_VERSION',   '1.0.0' );
define( 'STAYORA_DIR',       get_template_directory() );
define( 'STAYORA_URI',       get_template_directory_uri() );
define( 'STAYORA_ASSETS',    STAYORA_URI . '/assets' );
define( 'STAYORA_INC',       STAYORA_DIR . '/inc' );

/* -------------------------------------------------------------------------
   Load Inc Files
------------------------------------------------------------------------- */
$stayora_includes = [
    '/inc/setup.php',           // Theme supports, menus, image sizes
    '/inc/enqueue.php',         // Scripts & styles
    '/inc/customizer.php',      // Theme Customizer panels
    '/inc/template-functions.php', // Helper functions used in templates
    '/inc/template-hooks.php',  // Action/filter hooks for template parts
    '/inc/widgets.php',         // Custom widgets
    '/inc/post-types.php',      // Custom post types (Accommodation, Attraction)
    '/inc/taxonomies.php',      // Custom taxonomies (room type, amenity, location)
    '/inc/shortcodes.php',      // Useful shortcodes
    '/inc/booking-helpers.php', // Booking UI helpers & plugin bridge
    '/inc/gutenberg.php',       // Block editor compatibility
    '/inc/ajax.php',            // AJAX handlers
];

foreach ( $stayora_includes as $file ) {
    $path = STAYORA_DIR . $file;
    if ( file_exists( $path ) ) {
        require_once $path;
    }
}
