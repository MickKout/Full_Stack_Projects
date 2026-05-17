<?php
/**
 * Stayora — Custom Post Types
 * Registers Accommodation and Attraction CPTs.
 *
 * @package Stayora
 */

defined( 'ABSPATH' ) || exit;

/* -------------------------------------------------------------------------
   Accommodation CPT
------------------------------------------------------------------------- */
add_action( 'init', 'stayora_register_accommodation_cpt' );

function stayora_register_accommodation_cpt() {
    $labels = [
        'name'               => __( 'Accommodations',       'stayora' ),
        'singular_name'      => __( 'Accommodation',        'stayora' ),
        'add_new'            => __( 'Add New',               'stayora' ),
        'add_new_item'       => __( 'Add New Accommodation', 'stayora' ),
        'edit_item'          => __( 'Edit Accommodation',    'stayora' ),
        'new_item'           => __( 'New Accommodation',     'stayora' ),
        'view_item'          => __( 'View Accommodation',    'stayora' ),
        'search_items'       => __( 'Search Accommodations', 'stayora' ),
        'not_found'          => __( 'No accommodations found', 'stayora' ),
        'menu_name'          => __( 'Accommodations',        'stayora' ),
        'all_items'          => __( 'All Accommodations',    'stayora' ),
    ];

    register_post_type( 'accommodation', [
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'rewrite'             => [ 'slug' => 'accommodations', 'with_front' => false ],
        'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ],
        'taxonomies'          => [ 'room_type', 'amenity', 'accommodation_location' ],
        'menu_icon'           => 'dashicons-building',
        'menu_position'       => 5,
        'show_in_rest'        => true,
        'template'            => [
            [ 'core/paragraph', [ 'placeholder' => __( 'Describe this accommodation…', 'stayora' ) ] ],
        ],
    ] );
}

/* -------------------------------------------------------------------------
   Attraction CPT (Nearby Attractions)
------------------------------------------------------------------------- */
add_action( 'init', 'stayora_register_attraction_cpt' );

function stayora_register_attraction_cpt() {
    $labels = [
        'name'          => __( 'Attractions',   'stayora' ),
        'singular_name' => __( 'Attraction',    'stayora' ),
        'add_new_item'  => __( 'Add Attraction', 'stayora' ),
        'menu_name'     => __( 'Attractions',    'stayora' ),
    ];

    register_post_type( 'attraction', [
        'labels'       => $labels,
        'public'       => true,
        'has_archive'  => false,
        'rewrite'      => [ 'slug' => 'attractions' ],
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'menu_icon'    => 'dashicons-location-alt',
        'menu_position'=> 6,
        'show_in_rest' => true,
    ] );
}

/* -------------------------------------------------------------------------
   Accommodation Meta Boxes
------------------------------------------------------------------------- */
add_action( 'add_meta_boxes', 'stayora_accommodation_meta_boxes' );

function stayora_accommodation_meta_boxes() {
    add_meta_box(
        'stayora_room_details',
        __( 'Room / Unit Details', 'stayora' ),
        'stayora_room_details_callback',
        'accommodation',
        'normal',
        'high'
    );

    add_meta_box(
        'stayora_pricing',
        __( 'Pricing', 'stayora' ),
        'stayora_pricing_callback',
        'accommodation',
        'side',
        'high'
    );
}

function stayora_room_details_callback( $post ) {
    wp_nonce_field( 'stayora_room_details', 'stayora_room_nonce' );
    $meta = [
        'guests'    => get_post_meta( $post->ID, '_stayora_guests',    true ),
        'bedrooms'  => get_post_meta( $post->ID, '_stayora_bedrooms',  true ),
        'bathrooms' => get_post_meta( $post->ID, '_stayora_bathrooms', true ),
        'size'      => get_post_meta( $post->ID, '_stayora_size',      true ),
        'size_unit' => get_post_meta( $post->ID, '_stayora_size_unit', true ) ?: 'm²',
        'featured'  => get_post_meta( $post->ID, '_stayora_featured',  true ),
        'badge'     => get_post_meta( $post->ID, '_stayora_badge',     true ),
        'gallery'   => get_post_meta( $post->ID, '_stayora_gallery',   true ),
    ];
    ?>
    <table class="form-table">
        <tr>
            <th><?php _e( 'Max Guests', 'stayora' ); ?></th>
            <td><input type="number" name="_stayora_guests" value="<?php echo esc_attr( $meta['guests'] ); ?>" min="1" class="small-text"></td>
        </tr>
        <tr>
            <th><?php _e( 'Bedrooms', 'stayora' ); ?></th>
            <td><input type="number" name="_stayora_bedrooms" value="<?php echo esc_attr( $meta['bedrooms'] ); ?>" min="0" class="small-text"></td>
        </tr>
        <tr>
            <th><?php _e( 'Bathrooms', 'stayora' ); ?></th>
            <td><input type="number" name="_stayora_bathrooms" value="<?php echo esc_attr( $meta['bathrooms'] ); ?>" min="0" step="0.5" class="small-text"></td>
        </tr>
        <tr>
            <th><?php _e( 'Size', 'stayora' ); ?></th>
            <td>
                <input type="number" name="_stayora_size" value="<?php echo esc_attr( $meta['size'] ); ?>" min="0" class="small-text">
                <select name="_stayora_size_unit">
                    <option value="m²"  <?php selected( $meta['size_unit'], 'm²' ); ?>>m²</option>
                    <option value="sq ft" <?php selected( $meta['size_unit'], 'sq ft' ); ?>>sq ft</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><?php _e( 'Badge Label', 'stayora' ); ?></th>
            <td>
                <input type="text" name="_stayora_badge" value="<?php echo esc_attr( $meta['badge'] ); ?>" class="regular-text" placeholder="e.g. Best Seller, New, Ocean View">
                <p class="description"><?php _e( 'Short badge shown on the card (optional).', 'stayora' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><?php _e( 'Featured', 'stayora' ); ?></th>
            <td>
                <label>
                    <input type="checkbox" name="_stayora_featured" value="1" <?php checked( $meta['featured'], '1' ); ?>>
                    <?php _e( 'Show in Featured Accommodations section', 'stayora' ); ?>
                </label>
            </td>
        </tr>
        <tr>
            <th><?php _e( 'Gallery IDs', 'stayora' ); ?></th>
            <td>
                <input type="hidden" name="_stayora_gallery" id="stayora_gallery_ids" value="<?php echo esc_attr( $meta['gallery'] ); ?>">
                <button type="button" class="button" id="stayora_gallery_btn"><?php _e( 'Manage Gallery', 'stayora' ); ?></button>
                <div id="stayora_gallery_preview" style="margin-top:8px;display:flex;gap:6px;flex-wrap:wrap;"></div>
                <p class="description"><?php _e( 'Comma-separated attachment IDs. Use the button to manage.', 'stayora' ); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

function stayora_pricing_callback( $post ) {
    $price_per_night = get_post_meta( $post->ID, '_stayora_price_per_night', true );
    $price_weekend   = get_post_meta( $post->ID, '_stayora_price_weekend',   true );
    $price_weekly    = get_post_meta( $post->ID, '_stayora_price_weekly',    true );
    $min_stay        = get_post_meta( $post->ID, '_stayora_min_stay',        true );
    ?>
    <p>
        <label><?php _e( 'Price / Night', 'stayora' ); ?></label><br>
        <input type="number" name="_stayora_price_per_night" value="<?php echo esc_attr( $price_per_night ); ?>" min="0" step="0.01" class="widefat">
    </p>
    <p>
        <label><?php _e( 'Weekend Rate', 'stayora' ); ?></label><br>
        <input type="number" name="_stayora_price_weekend" value="<?php echo esc_attr( $price_weekend ); ?>" min="0" step="0.01" class="widefat">
    </p>
    <p>
        <label><?php _e( 'Weekly Rate', 'stayora' ); ?></label><br>
        <input type="number" name="_stayora_price_weekly" value="<?php echo esc_attr( $price_weekly ); ?>" min="0" step="0.01" class="widefat">
    </p>
    <p>
        <label><?php _e( 'Min. Stay (nights)', 'stayora' ); ?></label><br>
        <input type="number" name="_stayora_min_stay" value="<?php echo esc_attr( $min_stay ); ?>" min="1" class="widefat">
    </p>
    <?php
}

/* -------------------------------------------------------------------------
   Save Meta
------------------------------------------------------------------------- */
add_action( 'save_post_accommodation', 'stayora_save_accommodation_meta' );

function stayora_save_accommodation_meta( $post_id ) {
    if ( ! isset( $_POST['stayora_room_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['stayora_room_nonce'], 'stayora_room_details' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $text_fields = [
        '_stayora_guests', '_stayora_bedrooms', '_stayora_bathrooms',
        '_stayora_size', '_stayora_size_unit', '_stayora_badge', '_stayora_gallery',
        '_stayora_price_per_night', '_stayora_price_weekend',
        '_stayora_price_weekly', '_stayora_min_stay',
    ];

    foreach ( $text_fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
        }
    }

    $featured = isset( $_POST['_stayora_featured'] ) ? '1' : '';
    update_post_meta( $post_id, '_stayora_featured', $featured );
}
