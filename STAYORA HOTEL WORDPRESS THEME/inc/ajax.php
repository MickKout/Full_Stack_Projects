<?php
/**
 * Stayora — AJAX Handlers
 *
 * @package Stayora
 */

defined( 'ABSPATH' ) || exit;

/* -------------------------------------------------------------------------
   Booking Enquiry Submission
------------------------------------------------------------------------- */
add_action( 'wp_ajax_stayora_booking_enquiry',        'stayora_handle_booking_enquiry' );
add_action( 'wp_ajax_nopriv_stayora_booking_enquiry', 'stayora_handle_booking_enquiry' );

function stayora_handle_booking_enquiry(): void {
    check_ajax_referer( 'stayora_nonce', 'nonce' );

    $data = [
        'accommodation_id' => absint( $_POST['accommodation_id'] ?? 0 ),
        'checkin'          => sanitize_text_field( $_POST['checkin']   ?? '' ),
        'checkout'         => sanitize_text_field( $_POST['checkout']  ?? '' ),
        'guests'           => absint( $_POST['guests']    ?? 1 ),
        'name'             => sanitize_text_field( $_POST['name']      ?? '' ),
        'email'            => sanitize_email( $_POST['email']          ?? '' ),
        'phone'            => sanitize_text_field( $_POST['phone']     ?? '' ),
        'message'          => sanitize_textarea_field( $_POST['message'] ?? '' ),
    ];

    // Basic validation
    if ( empty( $data['email'] ) || empty( $data['checkin'] ) || empty( $data['checkout'] ) ) {
        wp_send_json_error( [ 'message' => __( 'Please fill in all required fields.', 'stayora' ) ] );
    }

    // Build email
    $room_title = $data['accommodation_id'] ? get_the_title( $data['accommodation_id'] ) : __( 'General Enquiry', 'stayora' );
    $subject    = sprintf( __( 'New Booking Enquiry: %s', 'stayora' ), $room_title );
    $body       = sprintf(
        "New booking enquiry received.\n\nProperty: %s\nCheck-in: %s\nCheck-out: %s\nGuests: %d\n\nGuest Details:\nName: %s\nEmail: %s\nPhone: %s\n\nMessage:\n%s",
        $room_title,
        $data['checkin'], $data['checkout'], $data['guests'],
        $data['name'], $data['email'], $data['phone'],
        $data['message']
    );

    $to      = get_option( 'admin_email' );
    $headers = [ 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $data['email'] ];

    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        wp_send_json_success( [ 'message' => __( 'Your enquiry has been sent. We will be in touch shortly!', 'stayora' ) ] );
    } else {
        wp_send_json_error( [ 'message' => __( 'There was a problem sending your enquiry. Please try again.', 'stayora' ) ] );
    }
}

/* -------------------------------------------------------------------------
   Get Rooms (AJAX filter)
------------------------------------------------------------------------- */
add_action( 'wp_ajax_stayora_filter_rooms',        'stayora_filter_rooms' );
add_action( 'wp_ajax_nopriv_stayora_filter_rooms', 'stayora_filter_rooms' );

function stayora_filter_rooms(): void {
    check_ajax_referer( 'stayora_nonce', 'nonce' );

    $args = [
        'post_type'      => 'accommodation',
        'posts_per_page' => 12,
        'post_status'    => 'publish',
    ];

    if ( ! empty( $_POST['room_type'] ) ) {
        $args['tax_query'] = [ [
            'taxonomy' => 'room_type',
            'field'    => 'slug',
            'terms'    => sanitize_text_field( $_POST['room_type'] ),
        ] ];
    }

    if ( ! empty( $_POST['guests'] ) ) {
        $args['meta_query'] = [ [
            'key'     => '_stayora_guests',
            'value'   => absint( $_POST['guests'] ),
            'compare' => '>=',
            'type'    => 'NUMERIC',
        ] ];
    }

    $query = new WP_Query( $args );
    ob_start();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'template-parts/accommodation/accommodation', 'card' );
        }
        wp_reset_postdata();
    } else {
        echo '<p class="col-span-full text-center py-12 text-[color:var(--color-text-muted)]">' . esc_html__( 'No accommodations found.', 'stayora' ) . '</p>';
    }

    $html = ob_get_clean();
    wp_send_json_success( [ 'html' => $html, 'count' => $query->found_posts ] );
}
