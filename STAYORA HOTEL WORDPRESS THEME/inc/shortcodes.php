<?php
/**
 * Stayora — Shortcodes
 *
 * @package Stayora
 */

defined( 'ABSPATH' ) || exit;

/**
 * [stayora_rooms count="6" featured="1" type="villa"]
 */
add_shortcode( 'stayora_rooms', function( $atts ) {
    $atts = shortcode_atts( [
        'count'    => 6,
        'featured' => 0,
        'type'     => '',
        'columns'  => 3,
    ], $atts, 'stayora_rooms' );

    $args = [
        'post_type'      => 'accommodation',
        'posts_per_page' => (int) $atts['count'],
        'post_status'    => 'publish',
    ];

    if ( $atts['featured'] ) {
        $args['meta_query'] = [ [ 'key' => '_stayora_featured', 'value' => '1' ] ];
    }

    if ( $atts['type'] ) {
        $args['tax_query'] = [ [ 'taxonomy' => 'room_type', 'field' => 'slug', 'terms' => $atts['type'] ] ];
    }

    $query = new WP_Query( $args );

    ob_start();
    if ( $query->have_posts() ) {
        echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-' . esc_attr( $atts['columns'] ) . ' gap-8">';
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'template-parts/accommodation/accommodation', 'card' );
        }
        echo '</div>';
        wp_reset_postdata();
    }
    return ob_get_clean();
} );

/**
 * [stayora_booking_form accommodation_id="123"]
 */
add_shortcode( 'stayora_booking_form', function( $atts ) {
    $atts = shortcode_atts( [ 'accommodation_id' => 0 ], $atts );
    ob_start();
    stayora_render_booking_form( (int) $atts['accommodation_id'] );
    return ob_get_clean();
} );

/**
 * [stayora_testimonials count="3"]
 */
add_shortcode( 'stayora_testimonials', function( $atts ) {
    $atts = shortcode_atts( [ 'count' => 3 ], $atts );
    ob_start();
    get_template_part( 'template-parts/sections/section', 'testimonials', [ 'count' => (int) $atts['count'] ] );
    return ob_get_clean();
} );
