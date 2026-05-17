<?php
/**
 * Stayora — Theme Setup
 * Registers WordPress features, menus, image sizes.
 *
 * @package Stayora
 */

defined( 'ABSPATH' ) || exit;

/* -------------------------------------------------------------------------
   Theme Setup
------------------------------------------------------------------------- */
add_action( 'after_setup_theme', 'stayora_setup' );

function stayora_setup() {

    // Translations
    load_theme_textdomain( 'stayora', STAYORA_DIR . '/languages' );

    // Core WordPress feature support
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 240,
        'flex-width'  => true,
        'flex-height' => true,
    ] );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ] );

    // Gutenberg
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-color-palette', [
        [ 'name' => __( 'Gold',       'stayora' ), 'slug' => 'gold',       'color' => '#c9a96e' ],
        [ 'name' => __( 'Champagne',  'stayora' ), 'slug' => 'champagne',  'color' => '#e8d5b0' ],
        [ 'name' => __( 'Dark',       'stayora' ), 'slug' => 'dark',       'color' => '#1a1a1a' ],
        [ 'name' => __( 'Surface',    'stayora' ), 'slug' => 'surface',    'color' => '#f9f7f4' ],
        [ 'name' => __( 'Stone Muted','stayora' ), 'slug' => 'stone-muted','color' => '#9e9189' ],
    ] );
    add_editor_style( 'assets/css/editor.css' );

    // Image sizes
    add_image_size( 'stayora-hero',      1920, 1080, true );
    add_image_size( 'stayora-room-card', 800,  600,  true );
    add_image_size( 'stayora-room-lg',   1200, 800,  true );
    add_image_size( 'stayora-blog-card', 720,  480,  true );
    add_image_size( 'stayora-gallery',   600,  400,  true );
    add_image_size( 'stayora-thumb',     400,  300,  true );

    // Navigation Menus
    register_nav_menus( [
        'primary'     => __( 'Primary Navigation', 'stayora' ),
        'footer-main' => __( 'Footer Main',        'stayora' ),
        'footer-legal'=> __( 'Footer Legal Links', 'stayora' ),
        'mobile'      => __( 'Mobile Navigation',  'stayora' ),
    ] );

    // Content width
    global $content_width;
    if ( ! isset( $content_width ) ) {
        $content_width = 1280;
    }
}

/* -------------------------------------------------------------------------
   Excerpt Length
------------------------------------------------------------------------- */
add_filter( 'excerpt_length', function() { return 28; } );
add_filter( 'excerpt_more',   function() {
    return '&hellip; <a class="read-more text-gold" href="' . get_permalink() . '">' .
           __( 'Read more', 'stayora' ) . '</a>';
} );

/* -------------------------------------------------------------------------
   Body Classes
------------------------------------------------------------------------- */
add_filter( 'body_class', 'stayora_body_classes' );

function stayora_body_classes( $classes ) {
    if ( is_singular() ) {
        $classes[] = 'is-singular';
    }

    // Dark mode class from cookie or user preference
    if ( isset( $_COOKIE['stayora_theme'] ) && $_COOKIE['stayora_theme'] === 'dark' ) {
        $classes[] = 'dark';
    }

    // Front page gets hero class for transparent header
    if ( is_front_page() ) {
        $classes[] = 'has-hero-header';
    }

    if ( is_singular( 'accommodation' ) ) {
        $classes[] = 'is-accommodation-page';
    }

    return $classes;
}
