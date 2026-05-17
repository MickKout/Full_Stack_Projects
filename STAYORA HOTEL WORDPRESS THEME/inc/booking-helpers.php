<?php
/**
 * Stayora — Booking Plugin Bridge
 * Abstracts compatibility between booking plugins so templates stay clean.
 *
 * @package Stayora
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns the active booking plugin slug.
 */
function stayora_active_booking_plugin(): string {
    return get_theme_mod( 'stayora_booking_plugin', 'native' );
}

/**
 * Render the booking form for a given accommodation.
 * Delegates to the appropriate plugin or native UI.
 */
function stayora_render_booking_form( int $post_id = 0, string $context = 'widget' ): void {
    $id     = $post_id ?: get_the_ID();
    $plugin = stayora_active_booking_plugin();

    switch ( $plugin ) {
        case 'motopress':
            if ( function_exists( 'mphb_sc_booking_form' ) ) {
                echo do_shortcode( '[mphb_booking_form]' );
            } else {
                stayora_native_booking_form( $id, $context );
            }
            break;

        case 'amelia':
            if ( class_exists( '\AmeliaBooking\Plugin' ) ) {
                echo do_shortcode( '[ameliabooking category=0]' );
            } else {
                stayora_native_booking_form( $id, $context );
            }
            break;

        case 'fluent':
            if ( class_exists( '\FluentBooking\App\App' ) ) {
                echo do_shortcode( '[fluentbooking id="' . $id . '"]' );
            } else {
                stayora_native_booking_form( $id, $context );
            }
            break;

        case 'woocommerce':
            if ( class_exists( 'WooCommerce' ) ) {
                $product_id = get_post_meta( $id, '_stayora_wc_product_id', true );
                if ( $product_id ) {
                    echo do_shortcode( '[add_to_cart id="' . $product_id . '"]' );
                } else {
                    stayora_native_booking_form( $id, $context );
                }
            } else {
                stayora_native_booking_form( $id, $context );
            }
            break;

        default:
            stayora_native_booking_form( $id, $context );
            break;
    }
}

/**
 * Native booking form (UI-only / enquiry form).
 */
function stayora_native_booking_form( int $post_id, string $context = 'widget' ): void {
    $meta     = stayora_get_accommodation_meta( $post_id );
    $is_hero  = $context === 'hero';
    $is_widget= $context === 'widget';
    get_template_part( 'template-parts/booking/booking-form', null, [
        'post_id' => $post_id,
        'meta'    => $meta,
        'context' => $context,
    ] );
}

/**
 * Get the booking page URL.
 */
function stayora_booking_url( int $post_id = 0 ): string {
    $page_id = get_theme_mod( 'stayora_booking_page', 0 );
    $base    = $page_id ? get_permalink( $page_id ) : home_url( '/booking/' );
    if ( $post_id ) {
        $base = add_query_arg( 'accommodation', $post_id, $base );
    }
    return esc_url( $base );
}
