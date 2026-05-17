<?php
/**
 * Stayora — Accommodation Single: Hero
 *
 * @package Stayora
 */

$meta       = stayora_get_accommodation_meta();
$types      = get_the_terms(get_the_ID(),'room_type');
$type_label = ($types && !is_wp_error($types)) ? $types[0]->name : '';
$currency   = get_option('stayora_currency','€');
?>

<!-- Breadcrumb -->
<div class="pt-28 pb-6 px-4" style="background-color:var(--color-surface-alt); border-bottom:1px solid var(--color-border);">
    <div class="stayora-container">
        <?php stayora_breadcrumb(); ?>
    </div>
</div>

<!-- Accommodation Header -->
<div class="py-10 px-4" style="background-color:var(--color-surface);">
    <div class="stayora-container">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">

            <div>
                <?php if ($type_label) : ?>
                    <span class="section-label"><?php echo esc_html($type_label); ?></span>
                <?php endif; ?>
                <h1 class="font-display font-light mb-3" style="font-size:clamp(2rem,4vw,3rem);color:var(--color-text);">
                    <?php the_title(); ?>
                </h1>

                <!-- Meta row -->
                <?php echo stayora_meta_icons($meta); ?>

                <!-- Location / amenity highlights -->
                <?php
                $locations = get_the_terms(get_the_ID(),'accommodation_location');
                if ($locations && !is_wp_error($locations)) : ?>
                    <div class="flex items-center gap-1.5 mt-3 text-sm" style="color:var(--color-text-muted);">
                        <?php echo stayora_icon('map-pin','w-4 h-4 flex-shrink-0 text-gold'); ?>
                        <?php echo esc_html(implode(', ',wp_list_pluck($locations,'name'))); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Price + quick book -->
            <div class="flex-shrink-0 text-right">
                <?php if ($meta['price_per_night']) : ?>
                    <div class="price-badge items-end mb-4">
                        <span class="price-from"><?php esc_html_e('from','stayora'); ?></span>
                        <span class="price-value"><?php echo esc_html($currency.number_format($meta['price_per_night'],0)); ?></span>
                        <span class="price-per"><?php esc_html_e('/ night','stayora'); ?></span>
                    </div>
                <?php endif; ?>
                <a href="#booking-widget" class="btn-primary">
                    <?php esc_html_e('Reserve Now','stayora'); ?>
                </a>
            </div>

        </div><!-- /.flex -->
    </div><!-- /.container -->
</div>
