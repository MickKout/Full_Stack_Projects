<?php
/**
 * Stayora — search.php
 *
 * @package Stayora
 */

get_header();
?>
<?php do_action('stayora_before_main_content'); ?>

<div class="pt-28" style="background-color:var(--color-surface);">

    <header class="py-14 px-4 text-center" style="background-color:var(--color-surface-alt);border-bottom:1px solid var(--color-border);">
        <div class="stayora-container-narrow">
            <span class="section-label"><?php esc_html_e('Search','stayora'); ?></span>
            <h1 class="section-title mb-4">
                <?php printf(esc_html__('Results for: %s','stayora'),'<em>'.get_search_query().'</em>'); ?>
            </h1>
            <?php get_search_form(); ?>
        </div>
    </header>

    <div class="py-16 px-4">
        <div class="stayora-container">
            <?php if (have_posts()) : ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php if (get_post_type()==='accommodation') :
                            get_template_part('template-parts/accommodation/accommodation','card');
                        else :
                            get_template_part('template-parts/blog/blog','card');
                        endif; ?>
                    <?php endwhile; ?>
                </div>
                <?php stayora_pagination(); ?>
            <?php else : ?>
                <div class="text-center py-20">
                    <div class="mb-4"><?php echo stayora_icon('search','w-12 h-12 mx-auto'); ?></div>
                    <h2 class="font-display text-2xl mb-3"><?php esc_html_e('No results found','stayora'); ?></h2>
                    <p class="text-sm mb-8" style="color:var(--color-text-muted);">
                        <?php esc_html_e('Try different keywords or browse all accommodations.','stayora'); ?>
                    </p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('accommodation') ?: home_url('/accommodations/')); ?>" class="btn-primary">
                        <?php esc_html_e('Browse All Rooms','stayora'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php do_action('stayora_after_main_content'); ?>
<?php get_footer(); ?>
