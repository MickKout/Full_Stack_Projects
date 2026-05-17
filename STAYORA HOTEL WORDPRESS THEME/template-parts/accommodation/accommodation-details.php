<?php
/**
 * Stayora — Accommodation Single: Details (main body + sidebar)
 *
 * @package Stayora
 */

$meta      = stayora_get_accommodation_meta();
$amenities = get_the_terms(get_the_ID(),'amenity');
$currency  = get_option('stayora_currency','€');
?>

<div class="py-14 px-4" style="background-color:var(--color-surface);">
    <div class="stayora-container">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            <!-- ============================================================
                 Main Content Column
            ============================================================ -->
            <div class="lg:col-span-7">

                <!-- Key Stats Bar -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-px mb-12"
                     style="border:1px solid var(--color-border);">
                    <?php
                    $stats = [
                        ['label'=>__('Guests','stayora'), 'value'=>$meta['guests'].''],
                        ['label'=>__('Bedrooms','stayora'),'value'=>$meta['bedrooms'].''],
                        ['label'=>__('Bathrooms','stayora'),'value'=>$meta['bathrooms'].''],
                        ['label'=>__('Size','stayora'),    'value'=>$meta['size'] ? $meta['size'].$meta['size_unit'] : '—'],
                    ];
                    foreach ($stats as $s) : ?>
                        <div class="py-5 px-4 text-center" style="background-color:var(--color-surface-alt);">
                            <div class="font-display text-2xl" style="color:var(--color-text);"><?php echo esc_html($s['value']); ?></div>
                            <div class="text-xs uppercase tracking-widest mt-1" style="color:var(--color-text-muted);"><?php echo esc_html($s['label']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Description -->
                <div class="prose max-w-none mb-12"
                     style="color:var(--color-text); --tw-prose-headings:var(--color-text);">
                    <h2 class="font-display font-light text-3xl mb-4" style="color:var(--color-text);">
                        <?php esc_html_e('About This Space','stayora'); ?>
                    </h2>
                    <?php the_content(); ?>
                </div>

                <!-- Amenities Grid -->
                <?php if ($amenities && !is_wp_error($amenities)) : ?>
                <div class="mb-12">
                    <h2 class="font-display font-light text-3xl mb-6" style="color:var(--color-text);">
                        <?php esc_html_e('What\'s Included','stayora'); ?>
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0">
                        <?php
                        $amenity_icons = [
                            'wifi'        => 'wifi',
                            'pool'        => 'pool',
                            'parking'     => 'car',
                            'beach'       => 'map-pin',
                            'kitchen'     => 'droplet',
                            'air-con'     => 'sun',
                            'heating'     => 'sun',
                            'tv'          => 'maximize',
                            'washer'      => 'droplet',
                            'balcony'     => 'maximize',
                        ];
                        foreach ($amenities as $amenity) :
                            $icon_key = strtolower(str_replace([' ','-'],'',sanitize_title($amenity->name)));
                            $icon = isset($amenity_icons[$icon_key]) ? $amenity_icons[$icon_key] : 'heart';
                        ?>
                            <div class="amenity-item">
                                <span class="amenity-icon"><?php echo stayora_icon($icon,'w-5 h-5'); ?></span>
                                <span class="text-sm font-medium" style="color:var(--color-text);"><?php echo esc_html($amenity->name); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Pricing Table -->
                <?php if ($meta['price_per_night']) : ?>
                <div class="mb-12 p-6" style="background-color:var(--color-surface-alt);border:1px solid var(--color-border);">
                    <h2 class="font-display font-light text-2xl mb-5" style="color:var(--color-text);">
                        <?php esc_html_e('Pricing','stayora'); ?>
                    </h2>
                    <div class="divide-y" style="border-color:var(--color-border);">
                        <div class="flex justify-between py-3 text-sm">
                            <span style="color:var(--color-text-muted);"><?php esc_html_e('Per Night','stayora'); ?></span>
                            <span class="font-medium" style="color:var(--color-text);">
                                <?php echo esc_html($currency.number_format($meta['price_per_night'],0)); ?>
                            </span>
                        </div>
                        <?php if ($meta['price_weekend']) : ?>
                        <div class="flex justify-between py-3 text-sm">
                            <span style="color:var(--color-text-muted);"><?php esc_html_e('Weekend Rate','stayora'); ?></span>
                            <span class="font-medium" style="color:var(--color-text);">
                                <?php echo esc_html($currency.number_format($meta['price_weekend'],0)); ?>
                            </span>
                        </div>
                        <?php endif; ?>
                        <?php if ($meta['price_weekly']) : ?>
                        <div class="flex justify-between py-3 text-sm">
                            <span style="color:var(--color-text-muted);"><?php esc_html_e('Weekly Rate','stayora'); ?></span>
                            <span class="font-medium" style="color:var(--color-text);">
                                <?php echo esc_html($currency.number_format($meta['price_weekly'],0)); ?>
                            </span>
                        </div>
                        <?php endif; ?>
                        <?php if ($meta['min_stay'] > 1) : ?>
                        <div class="flex justify-between py-3 text-sm">
                            <span style="color:var(--color-text-muted);"><?php esc_html_e('Minimum Stay','stayora'); ?></span>
                            <span class="font-medium" style="color:var(--color-text);">
                                <?php printf(_n('%d night','%d nights',$meta['min_stay'],'stayora'),$meta['min_stay']); ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- House Rules -->
                <div class="mb-12">
                    <h2 class="font-display font-light text-2xl mb-5" style="color:var(--color-text);">
                        <?php esc_html_e('House Rules','stayora'); ?>
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm" style="color:var(--color-text-muted);">
                        <?php
                        $rules = [
                            __('Check-in: From 3:00 PM','stayora'),
                            __('Check-out: By 11:00 AM','stayora'),
                            __('No smoking inside the property','stayora'),
                            __('No parties or events','stayora'),
                            __('Quiet hours: 10:00 PM – 8:00 AM','stayora'),
                            __('Maximum occupancy must be respected','stayora'),
                        ];
                        foreach ($rules as $rule) : ?>
                            <div class="flex items-center gap-2">
                                <span style="color:var(--color-secondary);font-size:0.4rem;">⬤</span>
                                <?php echo esc_html($rule); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div><!-- /.main col -->

            <!-- ============================================================
                 Sticky Sidebar: Booking Widget
            ============================================================ -->
            <div class="lg:col-span-5">
                <div id="booking-widget" class="booking-widget-sticky scroll-mt-header">
                    <div class="flex items-baseline justify-between mb-6">
                        <div class="price-badge">
                            <?php if ($meta['price_per_night']) : ?>
                                <span class="price-from"><?php esc_html_e('from','stayora'); ?></span>
                                <span class="price-value"><?php echo esc_html($currency.number_format($meta['price_per_night'],0)); ?></span>
                                <span class="price-per"><?php esc_html_e('/ night','stayora'); ?></span>
                            <?php else : ?>
                                <span class="font-display text-2xl"><?php esc_html_e('Contact for price','stayora'); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center gap-1 text-sm" style="color:var(--color-text-muted);">
                            <?php echo stayora_star_rating(4.9); ?>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <?php stayora_render_booking_form(get_the_ID(),'widget'); ?>
                </div>

                <!-- Property Manager Contact -->
                <div class="mt-6 p-5 flex items-center gap-4" style="border:1px solid var(--color-border);">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0"
                         style="background-color:var(--color-secondary);color:var(--color-cta-text);">
                        <?php echo stayora_icon('users','w-5 h-5'); ?>
                    </div>
                    <div>
                        <div class="font-medium text-sm mb-0.5" style="color:var(--color-text);">
                            <?php esc_html_e('Have a question?','stayora'); ?>
                        </div>
                        <div class="text-xs" style="color:var(--color-text-muted);">
                            <?php esc_html_e('We reply within 2 hours.','stayora'); ?>
                        </div>
                    </div>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn-ghost ml-auto text-xs flex-shrink-0">
                        <?php esc_html_e('Contact','stayora'); ?>
                    </a>
                </div>
            </div>

        </div><!-- /.grid -->
    </div><!-- /.container -->
</div>
