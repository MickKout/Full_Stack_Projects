<?php
/**
 * Stayora — Asset Enqueuing
 * Registers and enqueues styles and scripts with performance best practices.
 *
 * @package Stayora
 */

defined( 'ABSPATH' ) || exit;

/* -------------------------------------------------------------------------
   Frontend Styles & Scripts
------------------------------------------------------------------------- */
add_action( 'wp_enqueue_scripts', 'stayora_enqueue_assets' );

function stayora_enqueue_assets() {

    // ---- Styles ----

    // Google Fonts: Cormorant Garamond (display) + DM Sans (body)
    wp_enqueue_style(
        'stayora-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap',
        [],
        null
    );

    // Compiled Tailwind CSS (generated via `npm run build`)
    wp_enqueue_style(
        'stayora-main',
        STAYORA_ASSETS . '/css/stayora.css',
        [ 'stayora-fonts' ],
        STAYORA_VERSION
    );

    // ---- Scripts ----

    // Main JS (defer, no jQuery dependency)
    wp_enqueue_script(
        'stayora-main',
        STAYORA_ASSETS . '/js/main.js',
        [],
        STAYORA_VERSION,
        [ 'strategy' => 'defer', 'in_footer' => true ]
    );

    // Booking UI JS (loaded only where needed)
    if ( is_front_page() || is_singular( 'accommodation' ) || is_page_template( 'templates/template-booking.php' ) ) {
        wp_enqueue_script(
            'stayora-booking',
            STAYORA_ASSETS . '/js/booking.js',
            [ 'stayora-main' ],
            STAYORA_VERSION,
            [ 'strategy' => 'defer', 'in_footer' => true ]
        );
    }

    // Gallery / Lightbox JS
    if ( is_singular( 'accommodation' ) || is_page_template( 'templates/template-gallery.php' ) ) {
        wp_enqueue_script(
            'stayora-gallery',
            STAYORA_ASSETS . '/js/gallery.js',
            [ 'stayora-main' ],
            STAYORA_VERSION,
            [ 'strategy' => 'defer', 'in_footer' => true ]
        );
    }

    // Localize script data for JS
    wp_localize_script( 'stayora-main', 'stayora', [
        'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
        'nonce'      => wp_create_nonce( 'stayora_nonce' ),
        'currency'   => get_option( 'stayora_currency', '€' ),
        'siteUrl'    => home_url(),
        'i18n'       => [
            'loading'    => __( 'Loading…',    'stayora' ),
            'bookNow'    => __( 'Book Now',     'stayora' ),
            'viewDates'  => __( 'Check Dates',  'stayora' ),
            'guests'     => __( 'Guests',       'stayora' ),
            'adults'     => __( 'Adults',       'stayora' ),
            'children'   => __( 'Children',     'stayora' ),
        ],
    ] );

    // Comments reply script
    if ( is_singular() && comments_open() ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

/* -------------------------------------------------------------------------
   Preload Critical Fonts (performance)
------------------------------------------------------------------------- */
add_action( 'wp_head', 'stayora_preload_resources', 1 );

function stayora_preload_resources() {
    // Preconnect to Google Fonts
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}

/* -------------------------------------------------------------------------
   Admin / Editor Styles
------------------------------------------------------------------------- */
add_action( 'admin_enqueue_scripts', 'stayora_admin_styles' );

function stayora_admin_styles( $hook ) {
    wp_enqueue_style(
        'stayora-admin',
        STAYORA_ASSETS . '/css/admin.css',
        [],
        STAYORA_VERSION
    );
}

/* -------------------------------------------------------------------------
   Block Editor Styles
------------------------------------------------------------------------- */
add_action( 'enqueue_block_editor_assets', 'stayora_block_editor_assets' );

function stayora_block_editor_assets() {
    wp_enqueue_style(
        'stayora-editor',
        STAYORA_ASSETS . '/css/editor.css',
        [ 'wp-edit-blocks' ],
        STAYORA_VERSION
    );
}
