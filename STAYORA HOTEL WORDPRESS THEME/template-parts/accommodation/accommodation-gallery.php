<?php
/**
 * Stayora — Accommodation Single: Gallery
 *
 * @package Stayora
 */

$meta        = stayora_get_accommodation_meta();
$gallery_ids = $meta['gallery_ids'];
$has_gallery = !empty($gallery_ids);

// Build array: featured image first, then gallery
$images = [];
if (has_post_thumbnail()) {
    $images[] = [
        'url' => get_the_post_thumbnail_url(null,'stayora-room-lg'),
        'alt' => get_the_title(),
    ];
}
if ($has_gallery) {
    foreach ($gallery_ids as $id) {
        $images[] = [
            'url' => wp_get_attachment_image_url($id,'stayora-room-lg'),
            'alt' => get_post_meta($id,'_wp_attachment_image_alt',true) ?: get_the_title(),
        ];
    }
}
$total = count($images);
?>

<?php if (!empty($images)) : ?>
<div class="accommodation-gallery px-4 pb-0" style="background-color:var(--color-surface);">
    <div class="stayora-container">

        <?php if ($total === 1) : ?>
            <div class="relative overflow-hidden" style="height:500px;">
                <img src="<?php echo esc_url($images[0]['url']); ?>"
                     alt="<?php echo esc_attr($images[0]['alt']); ?>"
                     class="w-full h-full object-cover"
                     loading="eager">
            </div>

        <?php elseif ($total === 2) : ?>
            <div class="grid grid-cols-2 gap-3" style="height:480px;">
                <?php foreach (array_slice($images,0,2) as $i=>$img) : ?>
                    <div class="relative overflow-hidden cursor-pointer gallery-item"
                         data-src="<?php echo esc_url($img['url']); ?>">
                        <img src="<?php echo esc_url($img['url']); ?>"
                             alt="<?php echo esc_attr($img['alt']); ?>"
                             class="w-full h-full object-cover transition-transform duration-500"
                             loading="<?php echo $i===0?'eager':'lazy'; ?>">
                        <div class="gallery-overlay"><?php echo stayora_icon('search','w-8 h-8 text-white'); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else : ?>
            <!-- 3+ images: featured mosaic layout -->
            <div class="grid grid-cols-4 gap-3" style="height:480px;" data-lightbox="accommodation">
                <!-- Main large image -->
                <div class="col-span-2 row-span-2 relative overflow-hidden cursor-pointer gallery-item"
                     data-src="<?php echo esc_url($images[0]['url']); ?>">
                    <img src="<?php echo esc_url($images[0]['url']); ?>"
                         alt="<?php echo esc_attr($images[0]['alt']); ?>"
                         class="w-full h-full object-cover transition-transform duration-500"
                         loading="eager">
                    <div class="gallery-overlay"><?php echo stayora_icon('search','w-8 h-8 text-white'); ?></div>
                </div>
                <!-- Secondary images -->
                <?php foreach (array_slice($images,1,4) as $i=>$img) : ?>
                    <div class="relative overflow-hidden cursor-pointer gallery-item <?php echo ($i===3 && $total>5)?'relative':'' ?>"
                         data-src="<?php echo esc_url($img['url']); ?>">
                        <img src="<?php echo esc_url($img['url']); ?>"
                             alt="<?php echo esc_attr($img['alt']); ?>"
                             class="w-full h-full object-cover transition-transform duration-500"
                             loading="lazy">
                        <div class="gallery-overlay"><?php echo stayora_icon('search','w-8 h-8 text-white'); ?></div>
                        <?php if ($i===3 && $total>5) : ?>
                            <div class="absolute inset-0 flex items-center justify-center bg-black/50 pointer-events-none">
                                <span class="text-white font-medium text-lg">+<?php echo ($total-5); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Gallery trigger -->
        <?php if ($total > 1) : ?>
            <div class="flex justify-end mt-3">
                <button class="text-xs uppercase tracking-widest flex items-center gap-2 py-2 px-4 transition-colors"
                        id="view-all-photos"
                        style="border:1px solid var(--color-border);color:var(--color-text-muted);"
                        aria-label="<?php esc_attr_e('View all photos','stayora'); ?>">
                    <?php echo stayora_icon('search','w-3.5 h-3.5'); ?>
                    <?php printf(esc_html__('View all %d photos','stayora'),$total); ?>
                </button>
            </div>
        <?php endif; ?>

    </div><!-- /.container -->
</div>

<!-- Full Gallery (all images for lightbox JS) -->
<script type="application/json" id="accommodation-gallery-data">
<?php echo json_encode(array_values($images)); ?>
</script>
<?php endif; ?>
