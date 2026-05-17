<?php
/**
 * Stayora — Single Accommodation Template
 *
 * @package Stayora
 */

get_header();
?>

<?php do_action('stayora_before_main_content'); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <?php do_action('stayora_accommodation_header'); ?>
    <?php do_action('stayora_accommodation_body'); ?>

    <!-- Related Accommodations -->
    <?php
    $related = stayora_get_accommodations([
        'posts_per_page' => 3,
        'post__not_in'   => [get_the_ID()],
        'tax_query'      => array_filter([
            get_the_terms(get_the_ID(),'room_type') ? [
                'taxonomy' => 'room_type',
                'field'    => 'term_id',
                'terms'    => wp_list_pluck(get_the_terms(get_the_ID(),'room_type') ?: [],'term_id'),
            ] : null,
        ]),
    ]);

    if ($related->have_posts()) : ?>
    <section class="py-20 px-4" style="background-color:var(--color-surface-alt);">
        <div class="stayora-container">
            <h2 class="font-display font-light text-3xl mb-10" style="color:var(--color-text);">
                <?php esc_html_e('You Might Also Like','stayora'); ?>
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php while ($related->have_posts()) : $related->the_post();
                    get_template_part('template-parts/accommodation/accommodation','card');
                endwhile;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

<?php endwhile; endif; ?>

<?php do_action('stayora_after_main_content'); ?>
<?php get_footer(); ?>
