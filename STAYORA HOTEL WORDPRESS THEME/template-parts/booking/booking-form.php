<?php
/**
 * Stayora — Booking Form
 *
 * @package Stayora
 */

$context = $args['context'] ?? 'widget';
$post_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();
$meta    = isset( $args['meta'] ) ? $args['meta'] : stayora_get_accommodation_meta( $post_id );
$currency = get_option( 'stayora_currency', '€' );
$widget_id = 'stayora-booking-form-' . $post_id;
$show_price = $meta['price_per_night'] > 0;

$form_classes = 'booking-enquiry-form';
if ( $context === 'hero' ) {
    $form_classes .= ' hero-booking-form';
}
?>

<form
    class="<?php echo esc_attr( $form_classes ); ?>"
    id="<?php echo esc_attr( $widget_id ); ?>"
    data-post-id="<?php echo esc_attr( $post_id ); ?>"
    novalidate
    aria-label="<?php esc_attr_e( 'Booking enquiry form', 'stayora' ); ?>"
>
    <?php wp_nonce_field( 'stayora_nonce', 'booking_nonce' ); ?>
    <input type="hidden" name="accommodation_id" value="<?php echo esc_attr( $post_id ); ?>">
    <input type="hidden" name="action" value="stayora_booking_enquiry">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
        <div class="booking-field">
            <label for="booking-checkin-<?php echo esc_attr( $post_id ); ?>"><?php esc_html_e( 'Check In', 'stayora' ); ?></label>
            <input type="date" id="booking-checkin-<?php echo esc_attr( $post_id ); ?>" name="checkin"
                   min="<?php echo esc_attr( gmdate( 'Y-m-d' ) ); ?>" required>
        </div>
        <div class="booking-field">
            <label for="booking-checkout-<?php echo esc_attr( $post_id ); ?>"><?php esc_html_e( 'Check Out', 'stayora' ); ?></label>
            <input type="date" id="booking-checkout-<?php echo esc_attr( $post_id ); ?>" name="checkout"
                   min="<?php echo esc_attr( gmdate( 'Y-m-d', strtotime( '+1 day' ) ) ); ?>" required>
        </div>
    </div>

    <div class="mb-4" style="border:1px solid var(--color-border);padding:14px;">
        <div class="flex items-center justify-between gap-3">
            <div>
                <label class="block text-xs tracking-widest uppercase mb-2" style="color:var(--color-text-muted);">
                    <?php esc_html_e( 'Guests', 'stayora' ); ?>
                </label>
                <div class="flex items-center gap-3">
                    <button type="button" class="guest-btn minus w-8 h-8 flex items-center justify-center"
                            style="border:1px solid var(--color-border);" data-target="adults"
                            aria-label="<?php esc_attr_e( 'Decrease adults', 'stayora' ); ?>">
                        <?php echo stayora_icon( 'minus', 'w-3.5 h-3.5' ); ?>
                    </button>
                    <input type="number" name="adults" id="adults-<?php echo esc_attr( $post_id ); ?>" value="2" min="1"
                           max="<?php echo esc_attr( max( 1, $meta['guests'] ) ); ?>"
                           class="w-12 text-center text-sm font-medium bg-transparent border-0 focus:outline-none"
                           style="color:var(--color-text);" readonly>
                    <button type="button" class="guest-btn plus w-8 h-8 flex items-center justify-center"
                            style="border:1px solid var(--color-border);" data-target="adults"
                            aria-label="<?php esc_attr_e( 'Increase adults', 'stayora' ); ?>">
                        <?php echo stayora_icon( 'plus', 'w-3.5 h-3.5' ); ?>
                    </button>
                </div>
            </div>
            <div>
                <label class="block text-xs tracking-widest uppercase mb-2" style="color:var(--color-text-muted);">
                    <?php esc_html_e( 'Children', 'stayora' ); ?>
                </label>
                <div class="flex items-center gap-3">
                    <button type="button" class="guest-btn minus w-8 h-8 flex items-center justify-center"
                            style="border:1px solid var(--color-border);" data-target="children"
                            aria-label="<?php esc_attr_e( 'Decrease children', 'stayora' ); ?>">
                        <?php echo stayora_icon( 'minus', 'w-3.5 h-3.5' ); ?>
                    </button>
                    <input type="number" name="children" id="children-<?php echo esc_attr( $post_id ); ?>" value="0" min="0" max="8"
                           class="w-12 text-center text-sm font-medium bg-transparent border-0 focus:outline-none"
                           style="color:var(--color-text);" readonly>
                    <button type="button" class="guest-btn plus w-8 h-8 flex items-center justify-center"
                            style="border:1px solid var(--color-border);" data-target="children"
                            aria-label="<?php esc_attr_e( 'Increase children', 'stayora' ); ?>">
                        <?php echo stayora_icon( 'plus', 'w-3.5 h-3.5' ); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="booking-field mb-3">
        <label for="booking-name-<?php echo esc_attr( $post_id ); ?>"><?php esc_html_e( 'Your Name', 'stayora' ); ?></label>
        <input type="text" id="booking-name-<?php echo esc_attr( $post_id ); ?>" name="name"
               placeholder="<?php esc_attr_e( 'Full name', 'stayora' ); ?>" required>
    </div>
    <div class="booking-field mb-3">
        <label for="booking-email-<?php echo esc_attr( $post_id ); ?>"><?php esc_html_e( 'Email', 'stayora' ); ?></label>
        <input type="email" id="booking-email-<?php echo esc_attr( $post_id ); ?>" name="email"
               placeholder="<?php esc_attr_e( 'your@email.com', 'stayora' ); ?>" required>
    </div>
    <div class="booking-field mb-5">
        <label for="booking-phone-<?php echo esc_attr( $post_id ); ?>"><?php esc_html_e( 'Phone (optional)', 'stayora' ); ?></label>
        <input type="tel" id="booking-phone-<?php echo esc_attr( $post_id ); ?>" name="phone"
               placeholder="<?php esc_attr_e( '+1 (555) 000-0000', 'stayora' ); ?>">
    </div>

    <?php if ( $show_price ) : ?>
        <div id="price-preview-<?php echo esc_attr( $post_id ); ?>" class="mb-4 p-4 hidden"
             style="background-color:var(--color-surface-alt);border:1px solid var(--color-border);">
            <div class="flex justify-between mb-2 text-sm" style="color:var(--color-text-muted);">
                <span id="nights-label-<?php echo esc_attr( $post_id ); ?>"></span>
                <span id="nights-cost-<?php echo esc_attr( $post_id ); ?>"></span>
            </div>
            <div class="flex justify-between font-medium" style="color:var(--color-text);">
                <span><?php esc_html_e( 'Estimated total', 'stayora' ); ?></span>
                <span id="total-cost-<?php echo esc_attr( $post_id ); ?>"></span>
            </div>
        </div>
    <?php endif; ?>

    <button type="submit" class="btn-primary w-full py-3 text-sm">
        <?php esc_html_e( 'Request Booking', 'stayora' ); ?>
    </button>

    <div class="booking-response mt-4 text-sm text-center hidden"></div>
</form>
