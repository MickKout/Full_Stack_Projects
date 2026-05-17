<?php
/**
 * Stayora — Hero Booking Form
 * Shown below the hero section.
 *
 * @package Stayora
 */
?>

<div class="hero-booking-form" id="hero-booking-inner">
    <form
        class="flex flex-col md:flex-row md:items-end gap-4 md:gap-0"
        id="hero-booking-form"
        novalidate
        aria-label="<?php esc_attr_e( 'Check availability', 'stayora' ); ?>"
    >
        <?php wp_nonce_field( 'stayora_nonce', 'booking_nonce' ); ?>

        <!-- Check In -->
        <div class="booking-field flex-1 md:border-r" style="border-color: var(--color-border);">
            <label for="hero-checkin">
                <?php esc_html_e( 'Check In', 'stayora' ); ?>
            </label>
            <input
                type="date"
                id="hero-checkin"
                name="checkin"
                min="<?php echo esc_attr( gmdate('Y-m-d') ); ?>"
                aria-required="true"
                class="md:px-6"
            >
        </div>

        <!-- Check Out -->
        <div class="booking-field flex-1 md:border-r" style="border-color: var(--color-border);">
            <label for="hero-checkout">
                <?php esc_html_e( 'Check Out', 'stayora' ); ?>
            </label>
            <input
                type="date"
                id="hero-checkout"
                name="checkout"
                min="<?php echo esc_attr( gmdate('Y-m-d', strtotime('+1 day')) ); ?>"
                aria-required="true"
                class="md:px-6"
            >
        </div>

        <!-- Guests -->
        <div class="booking-field md:w-44 md:border-r" style="border-color: var(--color-border);">
            <label for="hero-guests">
                <?php esc_html_e( 'Guests', 'stayora' ); ?>
            </label>
            <select id="hero-guests" name="guests" class="md:px-6">
                <?php for ( $i = 1; $i <= 12; $i++ ) : ?>
                    <option value="<?php echo $i; ?>">
                        <?php echo $i; ?> <?php echo $i === 1 ? esc_html__( 'Guest', 'stayora' ) : esc_html__( 'Guests', 'stayora' ); ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

        <!-- Room Type (optional filter) -->
        <div class="booking-field md:w-48 md:border-r" style="border-color: var(--color-border);">
            <label for="hero-room-type">
                <?php esc_html_e( 'Room Type', 'stayora' ); ?>
            </label>
            <select id="hero-room-type" name="room_type" class="md:px-6">
                <option value=""><?php esc_html_e( 'Any Type', 'stayora' ); ?></option>
                <?php
                $terms = get_terms( [ 'taxonomy' => 'room_type', 'hide_empty' => true ] );
                if ( $terms && ! is_wp_error( $terms ) ) :
                    foreach ( $terms as $term ) :
                        echo '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</option>';
                    endforeach;
                endif;
                ?>
            </select>
        </div>

        <!-- Submit -->
        <div class="flex-shrink-0 md:pl-4">
            <button type="submit" class="btn-primary w-full md:w-auto py-4 px-8 whitespace-nowrap">
                <?php echo stayora_icon( 'search', 'w-4 h-4' ); ?>
                <span><?php esc_html_e( 'Search', 'stayora' ); ?></span>
            </button>
        </div>

    </form>
</div>
