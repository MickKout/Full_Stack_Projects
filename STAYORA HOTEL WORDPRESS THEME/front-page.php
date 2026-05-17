<?php
/**
 * Stayora — front-page.php
 * Homepage template. Renders all hero and section parts.
 *
 * @package Stayora
 */

get_header();
?>

<?php do_action( 'stayora_before_main_content' ); ?>

    <!-- 1. Hero Section -->
    <?php stayora_part( 'sections/section', 'hero' ); ?>

    <!-- 2. Featured Accommodations -->
    <?php stayora_part( 'sections/section', 'featured-rooms' ); ?>

    <!-- 3. Why Us / Amenities -->
    <?php stayora_part( 'sections/section', 'amenities' ); ?>

    <!-- 4. Gallery Preview -->
    <?php stayora_part( 'sections/section', 'gallery-preview' ); ?>

    <!-- 5. Testimonials -->
    <?php stayora_part( 'sections/section', 'testimonials' ); ?>

    <!-- 6. Nearby Attractions -->
    <?php stayora_part( 'sections/section', 'attractions' ); ?>

    <!-- 7. FAQ -->
    <?php stayora_part( 'sections/section', 'faq' ); ?>

    <!-- 8. CTA Banner -->
    <?php stayora_part( 'sections/section', 'cta' ); ?>

<?php do_action( 'stayora_after_main_content' ); ?>

<?php get_footer(); ?>
