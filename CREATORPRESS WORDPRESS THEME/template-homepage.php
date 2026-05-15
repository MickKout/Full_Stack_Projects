<?php
/**
 * Template Name: CreatorPress Homepage
 *
 * A page template that renders the CreatorPress homepage layout.
 *
 * @package CreatorPress
 */

get_header();
?>

<section class="hero relative overflow-hidden bg-slate-950 text-white">
    <div class="mx-auto max-w-7xl px-5 py-20 lg:px-8 lg:py-28">
        <?php get_template_part( 'template-parts/sections/hero' ); ?>
    </div>
</section>

<div class="mx-auto max-w-7xl space-y-24 px-5 py-20 lg:px-8">
    <?php get_template_part( 'template-parts/sections/services' ); ?>
    <?php get_template_part( 'template-parts/sections/testimonials' ); ?>
    <?php get_template_part( 'template-parts/sections/pricing' ); ?>
    <?php get_template_part( 'template-parts/sections/faq' ); ?>
    <?php get_template_part( 'template-parts/sections/blog-preview' ); ?>
    <?php get_template_part( 'template-parts/sections/cta-banner' ); ?>
</div>

<?php get_footer();
