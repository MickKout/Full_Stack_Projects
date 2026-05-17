<?php
/**
 * Stayora — Index Fallback
 *
 * @package Stayora
 */

get_header();
?>

<?php do_action( 'stayora_before_main_content' ); ?>

<div class="pt-28" style="background-color:var(--color-surface);">
    <div class="stayora-container py-20">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'prose prose-lg max-w-none' ); ?> style="color:var(--color-text);">
                    <header class="mb-10">
                        <h1 class="font-display font-light text-4xl mb-6" style="color:var(--color-text);">
                            <?php the_title(); ?>
                        </h1>
                    </header>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>

            <?php if ( function_exists( 'stayora_pagination' ) ) : ?>
                <?php stayora_pagination(); ?>
            <?php endif; ?>

        <?php else : ?>
            <section class="text-center py-24">
                <h2 class="font-display font-light text-4xl mb-6" style="color:var(--color-text);">
                    <?php esc_html_e( 'Nothing Found', 'stayora' ); ?>
                </h2>
                <p class="text-sm" style="color:var(--color-text-muted);">
                    <?php esc_html_e( 'It seems we can’t find what you’re looking for. Try a search instead.', 'stayora' ); ?>
                </p>
                <?php get_search_form(); ?>
            </section>
        <?php endif; ?>
    </div>
</div>

<?php do_action( 'stayora_after_main_content' ); ?>

<?php get_footer(); ?>
