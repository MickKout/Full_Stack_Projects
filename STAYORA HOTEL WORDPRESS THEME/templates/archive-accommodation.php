<?php
/**
 * Stayora — Accommodation Archive (Listing Page)
 *
 * @package Stayora
 */

get_header();
?>

<?php do_action('stayora_before_main_content'); ?>

<div class="pt-28" style="background-color:var(--color-surface);">

    <!-- Archive Header -->
    <header class="py-14 px-4" style="background-color:var(--color-surface-alt);border-bottom:1px solid var(--color-border);">
        <div class="stayora-container">
            <?php stayora_breadcrumb(); ?>
            <div class="mt-6 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                <div>
                    <span class="section-label"><?php esc_html_e('Our Collection','stayora'); ?></span>
                    <h1 class="section-title">
                        <?php
                        if (is_tax()) {
                            single_term_title();
                        } else {
                            esc_html_e('All Accommodations','stayora');
                        }
                        ?>
                    </h1>
                    <?php if (have_posts()) : ?>
                        <p class="mt-2 text-sm" style="color:var(--color-text-muted);">
                            <?php printf(
                                _n('Showing %d property','Showing %d properties',$GLOBALS['wp_query']->found_posts,'stayora'),
                                $GLOBALS['wp_query']->found_posts
                            ); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Sort & Filter -->
                <div class="flex items-center gap-3 flex-wrap">
                    <select id="sort-rooms" class="text-sm px-4 py-2.5 focus:outline-none"
                            style="border:1px solid var(--color-border);background:var(--color-surface);color:var(--color-text);">
                        <option value="date"><?php esc_html_e('Newest First','stayora'); ?></option>
                        <option value="price-asc"><?php esc_html_e('Price: Low to High','stayora'); ?></option>
                        <option value="price-desc"><?php esc_html_e('Price: High to Low','stayora'); ?></option>
                        <option value="title"><?php esc_html_e('Name A–Z','stayora'); ?></option>
                    </select>

                    <!-- Room Type Filter -->
                    <?php
                    $room_types = get_terms(['taxonomy'=>'room_type','hide_empty'=>true]);
                    if ($room_types && !is_wp_error($room_types)) : ?>
                        <select id="filter-room-type" class="text-sm px-4 py-2.5 focus:outline-none"
                                style="border:1px solid var(--color-border);background:var(--color-surface);color:var(--color-text);">
                            <option value=""><?php esc_html_e('All Types','stayora'); ?></option>
                            <?php foreach ($room_types as $t) : ?>
                                <option value="<?php echo esc_attr($t->slug); ?>"><?php echo esc_html($t->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>

                    <!-- Guest Count Filter -->
                    <select id="filter-guests" class="text-sm px-4 py-2.5 focus:outline-none"
                            style="border:1px solid var(--color-border);background:var(--color-surface);color:var(--color-text);">
                        <option value=""><?php esc_html_e('Any Guests','stayora'); ?></option>
                        <?php for ($g=1;$g<=10;$g++) : ?>
                            <option value="<?php echo $g; ?>"><?php printf(_n('%d+ Guest','%d+ Guests',$g,'stayora'),$g); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
        </div>
    </header>

    <!-- Grid -->
    <div class="py-16 px-4">
        <div class="stayora-container">

            <!-- Loading indicator (hidden by default, shown during AJAX) -->
            <div id="rooms-loading" class="hidden text-center py-12">
                <div class="inline-block w-8 h-8 border-2 border-t-transparent rounded-full animate-spin" style="border-color:var(--color-secondary);border-top-color:transparent;"></div>
            </div>

            <div id="rooms-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8" role="list">
                <?php if (have_posts()) :
                    while (have_posts()) : the_post();
                        get_template_part('template-parts/accommodation/accommodation','card');
                    endwhile;
                else : ?>
                    <div class="col-span-full text-center py-20">
                        <div class="mb-4"><?php echo stayora_icon('search','w-12 h-12 mx-auto'); ?></div>
                        <h3 class="font-display text-2xl mb-3"><?php esc_html_e('No accommodations found','stayora'); ?></h3>
                        <p class="text-sm" style="color:var(--color-text-muted);">
                            <?php esc_html_e('Try adjusting your filters.','stayora'); ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <?php stayora_pagination(); ?>

        </div><!-- /.container -->
    </div>

</div>

<?php do_action('stayora_after_main_content'); ?>
<?php get_footer(); ?>
