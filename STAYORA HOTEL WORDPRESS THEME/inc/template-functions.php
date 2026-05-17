<?php
/**
 * Stayora — Template Helper Functions
 * Used throughout templates to keep PHP logic out of presentation files.
 *
 * @package Stayora
 */

defined( 'ABSPATH' ) || exit;

/* -------------------------------------------------------------------------
   Accommodation Helpers
------------------------------------------------------------------------- */

/**
 * Get accommodation meta in a single call.
 */
function stayora_get_accommodation_meta( int $post_id = 0 ): array {
    $id = $post_id ?: get_the_ID();
    return [
        'price_per_night' => (float) get_post_meta( $id, '_stayora_price_per_night', true ),
        'price_weekend'   => (float) get_post_meta( $id, '_stayora_price_weekend',   true ),
        'price_weekly'    => (float) get_post_meta( $id, '_stayora_price_weekly',    true ),
        'min_stay'        => (int)   get_post_meta( $id, '_stayora_min_stay',        true ) ?: 1,
        'guests'          => (int)   get_post_meta( $id, '_stayora_guests',          true ) ?: 2,
        'bedrooms'        => (int)   get_post_meta( $id, '_stayora_bedrooms',        true ) ?: 1,
        'bathrooms'       => (float) get_post_meta( $id, '_stayora_bathrooms',       true ) ?: 1,
        'size'            => (int)   get_post_meta( $id, '_stayora_size',            true ),
        'size_unit'       => get_post_meta( $id, '_stayora_size_unit', true ) ?: 'm²',
        'badge'           => sanitize_text_field( get_post_meta( $id, '_stayora_badge', true ) ),
        'featured'        => (bool)  get_post_meta( $id, '_stayora_featured',        true ),
        'gallery_ids'     => array_filter( array_map( 'intval',
                                explode( ',', get_post_meta( $id, '_stayora_gallery', true ) )
                             ) ),
    ];
}

/**
 * Format price with currency symbol.
 */
function stayora_format_price( float $amount, string $unit = '' ): string {
    $currency = get_option( 'stayora_currency', '€' );
    $formatted = $currency . number_format( $amount, 0, '.', ',' );
    if ( $unit ) {
        $formatted .= '<span class="price-unit text-sm text-[color:var(--color-text-muted)]"> / ' . esc_html( $unit ) . '</span>';
    }
    return $formatted;
}

/**
 * Render amenity tags for a given post.
 */
function stayora_get_amenities( int $post_id = 0, int $limit = 4 ): array {
    $id    = $post_id ?: get_the_ID();
    $terms = get_the_terms( $id, 'amenity' );
    if ( ! $terms || is_wp_error( $terms ) ) return [];
    return array_slice( $terms, 0, $limit );
}

/**
 * Render star rating HTML.
 */
function stayora_star_rating( float $rating = 5.0, bool $show_number = true ): string {
    $stars = '';
    for ( $i = 1; $i <= 5; $i++ ) {
        $filled = $i <= round( $rating );
        $stars .= '<svg class="w-4 h-4 ' . ( $filled ? 'fill-current' : 'fill-none stroke-current' ) . '" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke-width="1.5"/>
        </svg>';
    }
    $html  = '<span class="star-rating">' . $stars . '</span>';
    if ( $show_number ) {
        $html .= '<span class="text-xs ml-1.5 text-[color:var(--color-text-muted)]">' . number_format( $rating, 1 ) . '</span>';
    }
    return $html;
}

/**
 * Render accommodation meta icons row.
 */
function stayora_meta_icons( array $meta ): string {
    $items = [];
    if ( $meta['guests'] )   $items[] = '<span class="flex items-center gap-1.5">' . stayora_icon('users', 'w-4 h-4') . $meta['guests'] . ' ' . __( 'guests', 'stayora' ) . '</span>';
    if ( $meta['bedrooms'] ) $items[] = '<span class="flex items-center gap-1.5">' . stayora_icon('bed',   'w-4 h-4') . $meta['bedrooms'] . ' ' . _n( 'bed', 'beds', $meta['bedrooms'], 'stayora' ) . '</span>';
    if ( $meta['bathrooms']> 0 ) $items[] = '<span class="flex items-center gap-1.5">' . stayora_icon('droplet','w-4 h-4') . $meta['bathrooms'] . ' ' . __( 'bath', 'stayora' ) . '</span>';
    if ( $meta['size'] )     $items[] = '<span class="flex items-center gap-1.5">' . stayora_icon('maximize','w-4 h-4') . $meta['size'] . $meta['size_unit'] . '</span>';
    return '<div class="room-card__meta flex flex-wrap gap-x-4 gap-y-1">' . implode( '', $items ) . '</div>';
}

/**
 * Inline SVG icon helper (Lucide-style paths).
 */
function stayora_icon( string $name, string $class = 'w-5 h-5' ): string {
    $icons = [
        'users'    => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'bed'      => '<path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/>',
        'droplet'  => '<path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>',
        'maximize' => '<path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/>',
        'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
        'wifi'     => '<path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/>',
        'pool'     => '<path d="M2 12h20"/><path d="M2 6c2.5 0 2.5 3 5 3s2.5-3 5-3 2.5 3 5 3 2.5-3 5-3"/><path d="M2 18c2.5 0 2.5 3 5 3s2.5-3 5-3 2.5 3 5 3 2.5-3 5-3"/>',
        'car'      => '<rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 5v3H16z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',
        'map-pin'  => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
        'camera'   => '<path d="M4 7h4l2-3h4l2 3h4a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2z"/><circle cx="12" cy="13" r="3"/>',
        'arrow-right' => '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>',
        'x'        => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        'menu'     => '<line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>',
        'moon'     => '<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>',
        'sun'      => '<circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>',
        'heart'    => '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>',
        'search'   => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
        'plus'     => '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>',
        'minus'    => '<line x1="5" y1="12" x2="19" y2="12"/>',
        'chevron-down' => '<polyline points="6 9 12 15 18 9"/>',
    ];

    $path = $icons[ $name ] ?? '<circle cx="12" cy="12" r="10"/>';
    return '<svg class="' . esc_attr( $class ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
}

/* -------------------------------------------------------------------------
   Query Helpers
------------------------------------------------------------------------- */

/**
 * Get featured accommodations.
 */
function stayora_get_featured_accommodations( int $count = 6 ): WP_Query {
    return new WP_Query( [
        'post_type'      => 'accommodation',
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'meta_query'     => [ [ 'key' => '_stayora_featured', 'value' => '1' ] ],
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ] );
}

/**
 * Get all accommodations with optional filters.
 */
function stayora_get_accommodations( array $args = [] ): WP_Query {
    $defaults = [
        'post_type'      => 'accommodation',
        'posts_per_page' => 12,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];
    return new WP_Query( array_merge( $defaults, $args ) );
}

/* -------------------------------------------------------------------------
   Navigation Helpers
------------------------------------------------------------------------- */

/**
 * Output navigation with fallback.
 */
function stayora_nav( string $location, array $args = [] ): void {
    $defaults = [
        'theme_location'  => $location,
        'container'       => false,
        'menu_class'      => 'stayora-menu',
        'fallback_cb'     => false,
        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    ];
    wp_nav_menu( array_merge( $defaults, $args ) );
}

/* -------------------------------------------------------------------------
   Template Part Loader
------------------------------------------------------------------------- */

/**
 * Load template part with optional data context.
 */
function stayora_part( string $slug, string $name = '', array $args = [] ): void {
    get_template_part( 'template-parts/' . $slug, $name ?: null, $args );
}

/* -------------------------------------------------------------------------
   Breadcrumb
------------------------------------------------------------------------- */
function stayora_breadcrumb(): void {
    if ( is_front_page() ) return;

    $items   = [];
    $items[] = '<a href="' . home_url() . '">' . __( 'Home', 'stayora' ) . '</a>';

    if ( is_singular( 'accommodation' ) ) {
        $items[] = '<a href="' . get_post_type_archive_link( 'accommodation' ) . '">' . __( 'Accommodations', 'stayora' ) . '</a>';
        $items[] = '<span>' . get_the_title() . '</span>';
    } elseif ( is_archive() ) {
        $items[] = '<span>' . get_the_archive_title() . '</span>';
    } elseif ( is_singular() ) {
        if ( $cat = get_the_category() ) {
            $items[] = '<a href="' . get_category_link( $cat[0]->term_id ) . '">' . $cat[0]->name . '</a>';
        }
        $items[] = '<span>' . get_the_title() . '</span>';
    } elseif ( is_search() ) {
        $items[] = '<span>' . sprintf( __( 'Search: %s', 'stayora' ), get_search_query() ) . '</span>';
    }

    echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'stayora' ) . '">';
    echo implode( '<span class="sep mx-2">/</span>', $items );
    echo '</nav>';
}

/* -------------------------------------------------------------------------
   Pagination
------------------------------------------------------------------------- */
function stayora_pagination(): void {
    $links = paginate_links( [
        'type'      => 'array',
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
    ] );

    if ( ! $links ) return;

    echo '<nav class="pagination flex items-center justify-center gap-2 mt-16" aria-label="' . esc_attr__( 'Pagination', 'stayora' ) . '">';
    foreach ( $links as $link ) {
        echo '<span class="page-item">' . $link . '</span>';
    }
    echo '</nav>';
}
