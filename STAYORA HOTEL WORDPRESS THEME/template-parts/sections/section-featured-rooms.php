<?php
/**
 * Stayora — Featured Rooms Section
 *
 * @package Stayora
 */

$query = stayora_get_featured_accommodations( 6 );

if ( ! $query->have_posts() ) {
    // Fallback to latest rooms if none are featured
    $query = stayora_get_accommodations( [ 'posts_per_page' => 6 ] );
}

if ( ! $query->have_posts() ) return;
?>

<section id="featured-rooms" class="py-24 px-4" style="background-color: var(--color-surface);">
    <div class="stayora-container">

        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-14">
            <div class="reveal">
                <span class="section-label"><?php esc_html_e( 'Our Collection', 'stayora' ); ?></span>
                <h2 class="section-title">
                    <?php esc_html_e( 'Curated Stays for', 'stayora' ); ?><br>
                    <em><?php esc_html_e( 'Every Traveller', 'stayora' ); ?></em>
                </h2>
            </div>
            <div class="reveal flex-shrink-0">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'accommodation' ) ?: home_url('/accommodations/') ); ?>"
                   class="btn-outline">
                    <?php esc_html_e( 'View All Rooms', 'stayora' ); ?>
                    <?php echo stayora_icon( 'arrow-right', 'w-4 h-4' ); ?>
                </a>
            </div>
        </div>

        <!-- Room Type Filter Tabs -->
        <div class="reveal flex flex-wrap gap-2 mb-10" id="room-filter-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Filter by room type', 'stayora' ); ?>">
            <button class="badge-gold" data-filter="all" role="tab" aria-selected="true">
                <?php esc_html_e( 'All', 'stayora' ); ?>
            </button>
            <?php
            $types = get_terms( [ 'taxonomy' => 'room_type', 'hide_empty' => true, 'number' => 6 ] );
            if ( $types && ! is_wp_error( $types ) ) :
                foreach ( $types as $type ) : ?>
                    <button class="badge" data-filter="<?php echo esc_attr( $type->slug ); ?>" role="tab" aria-selected="false">
                        <?php echo esc_html( $type->name ); ?>
                    </button>
                <?php endforeach;
            endif; ?>
        </div>

        <!-- Rooms Grid -->
        <div
            id="rooms-grid"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
            role="list"
            aria-label="<?php esc_attr_e( 'Available accommodations', 'stayora' ); ?>"
        >
            <?php
            while ( $query->have_posts() ) {
                $query->the_post();
                get_template_part( 'template-parts/accommodation/accommodation', 'card' );
            }
            wp_reset_postdata();
            ?>
        </div>

    </div><!-- /.container -->
</section>
