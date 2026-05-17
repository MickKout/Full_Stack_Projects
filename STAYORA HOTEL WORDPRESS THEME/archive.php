<?php
/**
 * Stayora — archive.php
 * Blog archive, category, tag, date archives.
 *
 * @package Stayora
 */

// Accommodation archive delegates to its own template
if (is_post_type_archive('accommodation') || is_tax(['room_type','amenity','accommodation_location'])) {
    get_template_part('templates/archive','accommodation');
    return;
}

get_header();
?>

<?php do_action('stayora_before_main_content'); ?>

<div class="pt-28" style="background-color:var(--color-surface);">

    <!-- Archive Header -->
    <header class="py-14 px-4 text-center" style="background-color:var(--color-surface-alt);border-bottom:1px solid var(--color-border);">
        <div class="stayora-container-narrow">
            <span class="section-label"><?php esc_html_e('Travel Journal','stayora'); ?></span>
            <h1 class="section-title mb-4">
                <?php
                if (is_category()) {
                    single_cat_title();
                } elseif (is_tag()) {
                    single_tag_title();
                } elseif (is_author()) {
                    echo get_the_author();
                } elseif (is_date()) {
                    echo get_the_date('F Y');
                } else {
                    esc_html_e('Journal','stayora');
                }
                ?>
            </h1>
            <?php the_archive_description('<p class="section-subtitle mx-auto">','</p>'); ?>
        </div>
    </header>

    <div class="py-16 px-4">
        <div class="stayora-container">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <!-- Posts -->
                <div class="lg:col-span-8">
                    <?php if (have_posts()) : ?>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-12">
                            <?php while (have_posts()) : the_post(); ?>
                                <?php get_template_part('template-parts/blog/blog','card'); ?>
                            <?php endwhile; ?>
                        </div>
                        <?php stayora_pagination(); ?>
                    <?php else : ?>
                        <p style="color:var(--color-text-muted);"><?php esc_html_e('No posts found.','stayora'); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-4" aria-label="<?php esc_attr_e('Blog Sidebar','stayora'); ?>">
                    <?php if (is_active_sidebar('sidebar-blog')) : ?>
                        <?php dynamic_sidebar('sidebar-blog'); ?>
                    <?php else : ?>
                        <!-- Default sidebar: search + recent posts -->
                        <div class="mb-8">
                            <h4 class="font-display text-xl mb-4" style="color:var(--color-text);"><?php esc_html_e('Search','stayora'); ?></h4>
                            <?php get_search_form(); ?>
                        </div>
                        <div class="mb-8">
                            <h4 class="font-display text-xl mb-4" style="color:var(--color-text);"><?php esc_html_e('Recent Posts','stayora'); ?></h4>
                            <?php
                            $recent = new WP_Query(['posts_per_page'=>5,'post_status'=>'publish']);
                            if ($recent->have_posts()) :
                                echo '<ul class="space-y-3">';
                                while ($recent->have_posts()) : $recent->the_post(); ?>
                                    <li><a href="<?php the_permalink(); ?>" class="text-sm hover:text-[color:var(--color-secondary)] transition-colors" style="color:var(--color-text);"><?php the_title(); ?></a></li>
                                <?php endwhile;
                                echo '</ul>';
                                wp_reset_postdata();
                            endif; ?>
                        </div>
                    <?php endif; ?>
                </aside>

            </div><!-- /.grid -->
        </div><!-- /.container -->
    </div>

</div>

<?php do_action('stayora_after_main_content'); ?>
<?php get_footer(); ?>
