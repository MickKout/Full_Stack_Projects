<?php
/**
 * Stayora — Theme Customizer
 * Adds Stayora-specific panels, sections, and controls.
 *
 * @package Stayora
 */

defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', 'stayora_customizer_register' );

function stayora_customizer_register( WP_Customize_Manager $wp_customize ) {

    /* ---- Panel ---- */
    $wp_customize->add_panel( 'stayora_panel', [
        'title'       => __( 'Stayora Theme', 'stayora' ),
        'priority'    => 10,
        'description' => __( 'Customize the Stayora hotel theme settings.', 'stayora' ),
    ] );

    /* =====================================================================
       Section: General / Branding
    ===================================================================== */
    $wp_customize->add_section( 'stayora_branding', [
        'title' => __( 'Branding & Identity', 'stayora' ),
        'panel' => 'stayora_panel',
    ] );

    // Property Name
    $wp_customize->add_setting( 'stayora_property_name', [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'stayora_property_name', [
        'label'   => __( 'Property Name', 'stayora' ),
        'section' => 'stayora_branding',
        'type'    => 'text',
    ] );

    // Property Tagline
    $wp_customize->add_setting( 'stayora_tagline', [ 'default' => 'Where Luxury Meets Comfort', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'stayora_tagline', [
        'label'   => __( 'Property Tagline', 'stayora' ),
        'section' => 'stayora_branding',
        'type'    => 'text',
    ] );

    // Currency
    $wp_customize->add_setting( 'stayora_currency', [ 'default' => '€', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'stayora_currency', [
        'label'   => __( 'Currency Symbol', 'stayora' ),
        'section' => 'stayora_branding',
        'type'    => 'text',
    ] );

    /* =====================================================================
       Section: Hero
    ===================================================================== */
    $wp_customize->add_section( 'stayora_hero', [
        'title' => __( 'Homepage Hero', 'stayora' ),
        'panel' => 'stayora_panel',
    ] );

    $hero_settings = [
        'stayora_hero_title'    => [ 'default' => 'Escape to Something Extraordinary', 'label' => __( 'Hero Title', 'stayora' ) ],
        'stayora_hero_subtitle' => [ 'default' => 'Discover handpicked villas, boutique hotels, and hidden retreats.', 'label' => __( 'Hero Subtitle', 'stayora' ) ],
        'stayora_hero_cta_text' => [ 'default' => 'Explore Rooms', 'label' => __( 'CTA Button Text', 'stayora' ) ],
        'stayora_hero_cta_url'  => [ 'default' => '/accommodations', 'label' => __( 'CTA Button URL', 'stayora' ) ],
    ];

    foreach ( $hero_settings as $id => $args ) {
        $wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $id, [ 'label' => $args['label'], 'section' => 'stayora_hero', 'type' => 'text' ] );
    }

    // Hero Background Image
    $wp_customize->add_setting( 'stayora_hero_image', [ 'default' => '', 'sanitize_callback' => 'absint' ] );
    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'stayora_hero_image', [
        'label'     => __( 'Hero Background Image', 'stayora' ),
        'section'   => 'stayora_hero',
        'mime_type' => 'image',
    ] ) );

    /* =====================================================================
       Section: Contact & Location
    ===================================================================== */
    $wp_customize->add_section( 'stayora_contact', [
        'title' => __( 'Contact & Location', 'stayora' ),
        'panel' => 'stayora_panel',
    ] );

    $contact_fields = [
        'stayora_phone'   => [ 'default' => '',  'label' => __( 'Phone Number', 'stayora' ) ],
        'stayora_email'   => [ 'default' => '',  'label' => __( 'Email Address', 'stayora' ) ],
        'stayora_address' => [ 'default' => '',  'label' => __( 'Address', 'stayora' ) ],
        'stayora_map_url' => [ 'default' => '',  'label' => __( 'Google Maps Embed URL', 'stayora' ) ],
    ];

    foreach ( $contact_fields as $id => $args ) {
        $wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $id, [ 'label' => $args['label'], 'section' => 'stayora_contact', 'type' => 'text' ] );
    }

    /* =====================================================================
       Section: Social
    ===================================================================== */
    $wp_customize->add_section( 'stayora_social', [
        'title' => __( 'Social Media', 'stayora' ),
        'panel' => 'stayora_panel',
    ] );

    $socials = [ 'instagram', 'facebook', 'twitter', 'youtube', 'tiktok', 'airbnb' ];
    foreach ( $socials as $platform ) {
        $wp_customize->add_setting( 'stayora_social_' . $platform, [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
        $wp_customize->add_control( 'stayora_social_' . $platform, [
            'label'   => ucfirst( $platform ) . ' URL',
            'section' => 'stayora_social',
            'type'    => 'url',
        ] );
    }

    /* =====================================================================
       Section: Booking Plugin
    ===================================================================== */
    $wp_customize->add_section( 'stayora_booking', [
        'title' => __( 'Booking Settings', 'stayora' ),
        'panel' => 'stayora_panel',
    ] );

    $wp_customize->add_setting( 'stayora_booking_plugin', [ 'default' => 'native', 'sanitize_callback' => 'sanitize_key' ] );
    $wp_customize->add_control( 'stayora_booking_plugin', [
        'label'   => __( 'Active Booking System', 'stayora' ),
        'section' => 'stayora_booking',
        'type'    => 'select',
        'choices' => [
            'native'       => __( 'Stayora Native (UI only)', 'stayora' ),
            'motopress'    => __( 'MotoPress Hotel Booking',  'stayora' ),
            'amelia'       => __( 'Amelia Booking',           'stayora' ),
            'fluent'       => __( 'FluentBooking',            'stayora' ),
            'woocommerce'  => __( 'WooCommerce',              'stayora' ),
        ],
    ] );

    $wp_customize->add_setting( 'stayora_booking_page', [ 'default' => 0, 'sanitize_callback' => 'absint' ] );
    $wp_customize->add_control( 'stayora_booking_page', [
        'label'   => __( 'Booking Page', 'stayora' ),
        'section' => 'stayora_booking',
        'type'    => 'dropdown-pages',
    ] );
}
