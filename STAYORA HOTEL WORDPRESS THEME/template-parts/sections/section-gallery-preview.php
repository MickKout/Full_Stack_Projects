<?php
/**
 * Stayora — Gallery Preview Section (Masonry)
 *
 * @package Stayora
 */

// Gather gallery images from recent accommodations or a dedicated gallery page
$gallery_images = [];

// Try to collect from accommodation posts
$acc_query = new WP_Query([
    'post_type'      => 'accommodation',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
    'meta_query'     => [[ 'key' => '_stayora_gallery', 'compare' => '!=' , 'value' => '' ]],
]);

if ( $acc_query->have_posts() ) {
    while ( $acc_query->have_posts() ) {
        $acc_query->the_post();
        $ids = array_filter( array_map( 'intval', explode( ',', get_post_meta( get_the_ID(), '_stayora_gallery', true ) ) ) );
        foreach ( array_slice( $ids, 0, 2 ) as $img_id ) {
            $gallery_images[] = [
                'id'  => $img_id,
                'url' => wp_get_attachment_image_url( $img_id, 'stayora-gallery' ),
                'alt' => get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ?: get_the_title(),
                'src' => wp_get_attachment_image_url( $img_id, 'stayora-room-lg' ),
            ];
        }
    }
    wp_reset_postdata();
}

// If no gallery images yet, show placeholder grid
$show_placeholder = empty( $gallery_images );
?>

<section id="gallery-preview" class="py-24 px-4 overflow-hidden" style="background-color: var(--color-surface);">
    <div class="stayora-container">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
            <div class="reveal">
                <span class="section-label"><?php esc_html_e( 'Visual Journey', 'stayora' ); ?></span>
                <h2 class="section-title">
                    <?php esc_html_e( 'See the', 'stayora' ); ?> <em><?php esc_html_e( 'Experience', 'stayora' ); ?></em>
                </h2>
            </div>
            <div class="reveal">
                <a href="<?php echo esc_url( home_url('/gallery/') ); ?>" class="btn-outline">
                    <?php esc_html_e( 'Full Gallery', 'stayora' ); ?>
                    <?php echo stayora_icon('arrow-right','w-4 h-4'); ?>
                </a>
            </div>
        </div>

        <?php if ( $show_placeholder ) : ?>
        <!-- Placeholder mosaic grid (shown until real images added) -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 reveal">
            <?php
            $placeholder_colors = ['var(--color-surface-alt)','var(--color-border)','var(--color-surface-alt)','var(--color-border)','var(--color-border)','var(--color-surface-alt)'];
            $spans = ['md:col-span-2 md:row-span-2','','','md:col-span-2','',''];
            for ( $i = 0; $i < 6; $i++ ) : ?>
                <div class="<?php echo $spans[$i]; ?> aspect-square overflow-hidden cursor-pointer group"
                     style="background-color: <?php echo $placeholder_colors[$i]; ?>; min-height: 160px;">
                    <div class="w-full h-full flex items-center justify-center group-hover:opacity-80 transition-opacity">
                        <?php echo stayora_icon('camera','w-8 h-8'); ?>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <p class="text-center mt-6 text-sm" style="color:var(--color-text-muted);">
            <?php esc_html_e('Add gallery images to your accommodations to display them here.','stayora'); ?>
        </p>

        <?php else : ?>
        <!-- Real masonry gallery -->
        <div class="masonry-gallery reveal" id="gallery-preview-grid" data-lightbox="gallery">
            <?php foreach ( array_slice( $gallery_images, 0, 9 ) as $img ) : ?>
                <div class="masonry-item group"
                     data-src="<?php echo esc_url( $img['src'] ); ?>"
                     tabindex="0"
                     role="button"
                     aria-label="<?php echo esc_attr( $img['alt'] ); ?>">
                    <img
                        src="<?php echo esc_url( $img['url'] ); ?>"
                        alt="<?php echo esc_attr( $img['alt'] ); ?>"
                        loading="lazy"
                        class="w-full object-cover"
                    >
                    <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <?php echo stayora_icon('search','w-8 h-8 text-white'); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div><!-- /.container -->
</section>

<!-- Lightbox -->
<div class="lightbox" id="gallery-lightbox" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Image gallery','stayora'); ?>">
    <button class="lightbox-close" id="lightbox-close" aria-label="<?php esc_attr_e('Close gallery','stayora'); ?>">
        <?php echo stayora_icon('x','w-8 h-8'); ?>
    </button>
    <button class="lightbox-nav prev" id="lightbox-prev" aria-label="<?php esc_attr_e('Previous image','stayora'); ?>">
        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <img src="" alt="" class="lightbox-img" id="lightbox-img">
    <button class="lightbox-nav next" id="lightbox-next" aria-label="<?php esc_attr_e('Next image','stayora'); ?>">
        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white/50 text-sm" id="lightbox-counter"></div>
</div>
