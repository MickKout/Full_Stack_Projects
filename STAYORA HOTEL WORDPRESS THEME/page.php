<?php
/**
 * Stayora — page.php
 *
 * @package Stayora
 */

get_header();
?>
<?php do_action('stayora_before_main_content'); ?>

<div class="pt-28" style="background-color:var(--color-surface);">

    <header class="py-14 px-4" style="background-color:var(--color-surface-alt);border-bottom:1px solid var(--color-border);">
        <div class="stayora-container-narrow">
            <?php stayora_breadcrumb(); ?>
            <h1 class="font-display font-light mt-4" style="font-size:clamp(2rem,4vw,3rem);color:var(--color-text);">
                <?php the_title(); ?>
            </h1>
        </div>
    </header>

    <div class="py-14 px-4">
        <div class="stayora-container-narrow">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="prose prose-lg max-w-none" style="color:var(--color-text);">
                    <?php the_content(); ?>
                </div>
                <?php wp_link_pages(); ?>
            <?php endwhile; endif; ?>

            <?php if (comments_open() || get_comments_number()) : ?>
                <?php comments_template(); ?>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php do_action('stayora_after_main_content'); ?>
<?php get_footer(); ?>
