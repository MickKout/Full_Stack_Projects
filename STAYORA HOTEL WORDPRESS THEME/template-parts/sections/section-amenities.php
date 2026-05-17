<?php
/**
 * Stayora — Amenities / Why Us Section
 *
 * @package Stayora
 */

$amenities = [
    [ 'icon' => 'wifi',     'title' => __( 'High-Speed WiFi',       'stayora' ), 'desc' => __( 'Stay connected with fibre-optic internet throughout the property.',  'stayora' ) ],
    [ 'icon' => 'pool',     'title' => __( 'Infinity Pool',          'stayora' ), 'desc' => __( 'Heated saltwater pool with panoramic views, open year-round.',        'stayora' ) ],
    [ 'icon' => 'car',      'title' => __( 'Private Parking',        'stayora' ), 'desc' => __( 'Complimentary secure parking for all guests on-site.',                'stayora' ) ],
    [ 'icon' => 'calendar', 'title' => __( 'Flexible Booking',       'stayora' ), 'desc' => __( 'Free cancellation up to 48 hours before check-in on most stays.',     'stayora' ) ],
    [ 'icon' => 'map-pin',  'title' => __( 'Prime Location',         'stayora' ), 'desc' => __( 'Steps from the beach, dining, and local cultural landmarks.',         'stayora' ) ],
    [ 'icon' => 'heart',    'title' => __( 'Personalised Service',   'stayora' ), 'desc' => __( 'Dedicated concierge available 24/7 to curate your perfect experience.','stayora' ) ],
];
?>

<section id="amenities" class="py-24 px-4 overflow-hidden" style="background-color: var(--color-surface-alt);">
    <div class="stayora-container">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <!-- Left: Text + Feature List -->
            <div>
                <div class="reveal">
                    <span class="section-label"><?php esc_html_e( 'The Stayora Difference', 'stayora' ); ?></span>
                    <h2 class="section-title mb-6">
                        <?php esc_html_e( 'Every Detail,', 'stayora' ); ?><br>
                        <em><?php esc_html_e( 'Thoughtfully Crafted', 'stayora' ); ?></em>
                    </h2>
                    <p class="section-subtitle mb-10">
                        <?php esc_html_e( 'From your first enquiry to your final morning coffee, we obsess over the details that transform a good stay into an unforgettable one.', 'stayora' ); ?>
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <?php foreach ( $amenities as $i => $item ) : ?>
                        <div class="reveal reveal-delay-<?php echo min( $i + 1, 4 ); ?> flex gap-4">
                            <div class="flex-shrink-0 w-11 h-11 rounded-full flex items-center justify-center"
                                 style="background-color: rgba(201,169,110,0.12); color: var(--color-secondary);">
                                <?php echo stayora_icon( $item['icon'], 'w-5 h-5' ); ?>
                            </div>
                            <div>
                                <h3 class="font-medium mb-1" style="color: var(--color-text); font-size: 0.95rem;">
                                    <?php echo esc_html( $item['title'] ); ?>
                                </h3>
                                <p class="text-sm leading-relaxed" style="color: var(--color-text-muted);">
                                    <?php echo esc_html( $item['desc'] ); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="reveal mt-10">
                    <a href="<?php echo esc_url( home_url('/about/') ); ?>" class="btn-outline">
                        <?php esc_html_e( 'Our Story', 'stayora' ); ?>
                        <?php echo stayora_icon( 'arrow-right', 'w-4 h-4' ); ?>
                    </a>
                </div>
            </div>

            <!-- Right: Image collage -->
            <div class="reveal relative h-[500px] hidden lg:block">
                <!-- Large image -->
                <div class="absolute top-0 right-0 w-3/4 h-4/5 overflow-hidden shadow-2xl">
                    <?php
                    $img_url = STAYORA_ASSETS . '/images/amenity-main.jpg';
                    ?>
                    <img
                        src="<?php echo esc_url( $img_url ); ?>"
                        alt="<?php esc_attr_e( 'Luxury amenities', 'stayora' ); ?>"
                        class="w-full h-full object-cover"
                        loading="lazy"
                        onerror="this.style.display='none'; this.parentElement.style.backgroundColor='var(--color-surface-alt)'"
                    >
                </div>
                <!-- Small accent image -->
                <div class="absolute bottom-0 left-0 w-2/5 h-2/5 overflow-hidden shadow-xl"
                     style="border: 6px solid var(--color-surface-alt);">
                    <img
                        src="<?php echo esc_url( STAYORA_ASSETS . '/images/amenity-accent.jpg' ); ?>"
                        alt="<?php esc_attr_e( 'Pool view', 'stayora' ); ?>"
                        class="w-full h-full object-cover"
                        loading="lazy"
                        onerror="this.style.display='none'; this.parentElement.style.backgroundColor='var(--color-border)'"
                    >
                </div>
                <!-- Gold accent box -->
                <div class="absolute top-12 left-0 w-28 h-28 opacity-20"
                     style="background-color: var(--color-secondary);" aria-hidden="true"></div>
            </div>

        </div><!-- /.grid -->
    </div><!-- /.container -->
</section>
