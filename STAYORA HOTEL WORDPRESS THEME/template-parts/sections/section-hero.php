<?php
/**
 * Stayora — Hero Section
 * Fullscreen hero with booking form overlay.
 *
 * @package Stayora
 */

$hero_image_id = get_theme_mod( 'stayora_hero_image' );
$hero_image    = $hero_image_id
    ? wp_get_attachment_image_url( $hero_image_id, 'stayora-hero' )
    : STAYORA_ASSETS . '/images/hero-placeholder.jpg';

$hero_title    = get_theme_mod( 'stayora_hero_title',    __( 'Escape to Something Extraordinary', 'stayora' ) );
$hero_subtitle = get_theme_mod( 'stayora_hero_subtitle', __( 'Discover handpicked villas, boutique hotels, and hidden retreats curated for the discerning traveller.', 'stayora' ) );
$cta_text      = get_theme_mod( 'stayora_hero_cta_text', __( 'Explore Rooms', 'stayora' ) );
$cta_url       = get_theme_mod( 'stayora_hero_cta_url',  get_post_type_archive_link('accommodation') ?: home_url('/accommodations/') );
?>

<section
    id="hero"
    class="hero-section"
    aria-label="<?php esc_attr_e( 'Hero', 'stayora' ); ?>"
    style="<?php if ( $hero_image ) echo 'background-image: url(' . esc_url($hero_image) . '); background-size: cover; background-position: center;'; ?>"
>
    <!-- Overlay -->
    <div class="hero-overlay" aria-hidden="true"></div>

    <!-- Parallax layer (optional JS-driven) -->
    <div id="hero-parallax" class="absolute inset-0 pointer-events-none" aria-hidden="true"
         style="background-image: url(<?php echo esc_url( $hero_image ); ?>); background-size: cover; background-position: center; will-change: transform;"></div>

    <!-- Hero Content -->
    <div class="hero-content max-w-3xl mx-auto px-4">

        <!-- Label -->
        <div class="reveal mb-6">
            <span class="section-label" style="color: var(--color-accent);">
                <?php echo esc_html( get_theme_mod( 'stayora_property_name', get_bloginfo('name') ) ); ?>
            </span>
        </div>

        <!-- Title -->
        <h1 class="reveal reveal-delay-1 font-display font-light text-white mb-6"
            style="font-size: clamp(2.5rem, 6vw, 5rem); line-height: 1.08; text-shadow: 0 2px 20px rgba(0,0,0,0.3);">
            <?php echo esc_html( $hero_title ); ?>
        </h1>

        <!-- Subtitle -->
        <p class="reveal reveal-delay-2 text-white/80 text-lg md:text-xl max-w-xl mx-auto mb-10">
            <?php echo esc_html( $hero_subtitle ); ?>
        </p>

        <!-- CTA Buttons -->
        <div class="reveal reveal-delay-3 flex flex-wrap items-center justify-center gap-4 mb-16">
            <a href="<?php echo esc_url( $cta_url ); ?>" class="btn-primary">
                <?php echo esc_html( $cta_text ); ?>
            </a>
            <a href="#booking-form" class="btn-white">
                <?php esc_html_e( 'Check Availability', 'stayora' ); ?>
            </a>
        </div>

        <!-- Stats Row -->
        <div class="reveal reveal-delay-4 flex flex-wrap items-center justify-center gap-8 md:gap-12">
            <?php
            $stats = [
                [ 'number' => '50+',  'label' => __( 'Properties', 'stayora' ) ],
                [ 'number' => '4.9★', 'label' => __( 'Average Rating', 'stayora' ) ],
                [ 'number' => '2k+',  'label' => __( 'Happy Guests', 'stayora' ) ],
            ];
            foreach ( $stats as $stat ) : ?>
                <div class="text-center">
                    <div class="font-display text-3xl text-white"><?php echo esc_html( $stat['number'] ); ?></div>
                    <div class="text-xs text-white/60 uppercase tracking-widest mt-1"><?php echo esc_html( $stat['label'] ); ?></div>
                </div>
            <?php endforeach; ?>
        </div>

    </div><!-- /.hero-content -->

    <!-- Scroll Indicator -->
    <a href="#booking-form"
       class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/60 hover:text-white/90 transition-colors"
       aria-label="<?php esc_attr_e( 'Scroll down', 'stayora' ); ?>">
        <span class="text-xs tracking-widest uppercase"><?php esc_html_e( 'Explore', 'stayora' ); ?></span>
        <span class="w-px h-8 bg-white/40 animate-bounce" style="animation: scrollBounce 2s ease infinite;"></span>
    </a>

</section>

<!-- =====================================================================
     Hero Booking Form
===================================================================== -->
<div id="booking-form" class="scroll-mt-header relative z-10 py-0">
    <div class="stayora-container">
        <div class="booking-form-overlay -mt-16 md:-mt-20 p-6 md:p-8 max-w-4xl mx-auto">
            <?php stayora_part( 'booking/booking', 'form-hero' ); ?>
        </div>
    </div>
</div>
