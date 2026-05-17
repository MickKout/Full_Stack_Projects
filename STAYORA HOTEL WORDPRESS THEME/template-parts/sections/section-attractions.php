<?php
/**
 * Stayora — Nearby Attractions Section
 *
 * @package Stayora
 */

$query = new WP_Query([
    'post_type'      => 'attraction',
    'posts_per_page' => 4,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);

$defaults = [
    ['title'=>'Old Town Historic Centre','dist'=>'5 min walk',  'cat'=>'Culture',   'icon'=>'map-pin'],
    ['title'=>'Golden Beach',            'dist'=>'2 min walk',  'cat'=>'Beach',      'icon'=>'map-pin'],
    ['title'=>'Local Farmers Market',    'dist'=>'8 min drive', 'cat'=>'Food',       'icon'=>'map-pin'],
    ['title'=>'Wellness & Spa Centre',   'dist'=>'10 min drive','cat'=>'Wellness',   'icon'=>'map-pin'],
    ['title'=>'Sunset Viewpoint',        'dist'=>'15 min walk', 'cat'=>'Nature',     'icon'=>'map-pin'],
    ['title'=>'Fine Dining District',    'dist'=>'5 min drive', 'cat'=>'Dining',     'icon'=>'map-pin'],
];
$map_url = get_theme_mod('stayora_map_url','');
?>

<section id="attractions" class="py-24 px-4" style="background-color:var(--color-surface);">
    <div class="stayora-container">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

            <!-- Left: Attractions List -->
            <div>
                <div class="reveal">
                    <span class="section-label"><?php esc_html_e('Explore Nearby','stayora'); ?></span>
                    <h2 class="section-title mb-6">
                        <?php esc_html_e('Everything at','stayora'); ?><br>
                        <em><?php esc_html_e('Your Doorstep','stayora'); ?></em>
                    </h2>
                    <p class="section-subtitle mb-10">
                        <?php esc_html_e('Our location puts you at the heart of it all — beaches, culture, cuisine, and nature, all within easy reach.','stayora'); ?>
                    </p>
                </div>

                <div class="space-y-0 reveal">
                    <?php if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();
                            $dist = get_post_meta(get_the_ID(),'_distance',true);
                            $cat  = get_post_meta(get_the_ID(),'_category',true);
                    ?>
                        <div class="amenity-item">
                            <span class="amenity-icon"><?php echo stayora_icon('map-pin','w-5 h-5'); ?></span>
                            <div class="flex-1">
                                <span class="font-medium text-sm" style="color:var(--color-text);"><?php the_title(); ?></span>
                                <?php if ($cat) : ?><span class="badge ml-2"><?php echo esc_html($cat); ?></span><?php endif; ?>
                            </div>
                            <?php if ($dist) : ?><span class="text-xs ml-auto flex-shrink-0" style="color:var(--color-text-muted);"><?php echo esc_html($dist); ?></span><?php endif; ?>
                        </div>
                    <?php endwhile; wp_reset_postdata();
                    else :
                        foreach ($defaults as $a) : ?>
                            <div class="amenity-item">
                                <span class="amenity-icon"><?php echo stayora_icon('map-pin','w-5 h-5'); ?></span>
                                <div class="flex-1">
                                    <span class="font-medium text-sm" style="color:var(--color-text);"><?php echo esc_html($a['title']); ?></span>
                                    <span class="badge ml-2"><?php echo esc_html($a['cat']); ?></span>
                                </div>
                                <span class="text-xs ml-auto flex-shrink-0" style="color:var(--color-text-muted);"><?php echo esc_html($a['dist']); ?></span>
                            </div>
                        <?php endforeach;
                    endif; ?>
                </div>
            </div>

            <!-- Right: Map -->
            <div class="reveal">
                <?php if ($map_url) : ?>
                    <div class="map-wrapper shadow-lg">
                        <iframe
                            src="<?php echo esc_url($map_url); ?>"
                            title="<?php esc_attr_e('Property Location Map','stayora'); ?>"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </div>
                <?php else : ?>
                    <div class="map-wrapper flex items-center justify-center" style="background-color:var(--color-surface-alt);border:1px solid var(--color-border);">
                        <div class="text-center p-8">
                            <?php echo stayora_icon('map-pin','w-12 h-12 mb-3 mx-auto text-gold'); ?>
                            <p class="text-sm" style="color:var(--color-text-muted);">
                                <?php esc_html_e('Add your Google Maps embed URL in the Theme Customizer → Contact & Location.','stayora'); ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($address = get_theme_mod('stayora_address')) : ?>
                    <p class="mt-4 flex items-center gap-2 text-sm" style="color:var(--color-text-muted);">
                        <?php echo stayora_icon('map-pin','w-4 h-4 flex-shrink-0 text-gold'); ?>
                        <?php echo esc_html($address); ?>
                    </p>
                <?php endif; ?>
            </div>

        </div><!-- /.grid -->
    </div><!-- /.container -->
</section>
