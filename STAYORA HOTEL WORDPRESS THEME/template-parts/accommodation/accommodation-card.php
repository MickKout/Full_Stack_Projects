<?php
/**
 * Stayora — Accommodation Card Component
 * Reusable room card for listings, search results, and widgets.
 *
 * @package Stayora
 */

$meta     = stayora_get_accommodation_meta();
$amenities= stayora_get_amenities( 0, 3 );
$currency = get_option( 'stayora_currency', '€' );
$delay    = $args['delay'] ?? 0;
?>

<article
    class="room-card reveal group <?php echo $delay ? 'reveal-delay-' . $delay : ''; ?>"
    role="listitem"
    itemscope
    itemtype="https://schema.org/LodgingBusiness"
>
    <!-- Image -->
    <div class="room-card__image">
        <?php if ( has_post_thumbnail() ) :
            the_post_thumbnail( 'stayora-room-card', [
                'class'   => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105',
                'alt'     => get_the_title(),
                'loading' => 'lazy',
                'itemprop'=> 'image',
            ] );
        else : ?>
            <div class="w-full h-full flex items-center justify-center" style="background-color: var(--color-surface-alt);">
                <span style="color: var(--color-text-light);"><?php echo stayora_icon('bed', 'w-10 h-10'); ?></span>
            </div>
        <?php endif; ?>

        <!-- Badge -->
        <?php if ( $meta['badge'] ) : ?>
            <span class="room-card__badge"><?php echo esc_html( $meta['badge'] ); ?></span>
        <?php endif; ?>

        <!-- Wishlist -->
        <button
            class="room-card__wishlist"
            aria-label="<?php esc_attr_e( 'Save to wishlist', 'stayora' ); ?>"
            data-id="<?php the_ID(); ?>"
        >
            <?php echo stayora_icon( 'heart', 'w-4 h-4' ); ?>
        </button>
    </div><!-- /.room-card__image -->

    <!-- Body -->
    <div class="room-card__body">

        <!-- Type -->
        <?php
        $types = get_the_terms( get_the_ID(), 'room_type' );
        if ( $types && ! is_wp_error( $types ) ) : ?>
            <div class="mb-2">
                <span class="text-xs uppercase tracking-widest font-medium" style="color: var(--color-secondary);">
                    <?php echo esc_html( $types[0]->name ); ?>
                </span>
            </div>
        <?php endif; ?>

        <!-- Name -->
        <h3 class="room-card__name" itemprop="name">
            <a href="<?php the_permalink(); ?>" class="hover:text-[color:var(--color-secondary)] transition-colors">
                <?php the_title(); ?>
            </a>
        </h3>

        <!-- Meta: guests, beds, baths, size -->
        <?php echo stayora_meta_icons( $meta ); ?>

        <!-- Amenity Tags -->
        <?php if ( $amenities ) : ?>
            <div class="room-card__amenities">
                <?php foreach ( $amenities as $amenity ) : ?>
                    <span class="room-card__amenity-tag"><?php echo esc_html( $amenity->name ); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Footer: Price + CTA -->
        <div class="room-card__footer">
            <div class="room-card__price">
                <?php if ( $meta['price_per_night'] ) : ?>
                    <span class="text-xs uppercase tracking-wider block mb-0.5" style="color: var(--color-text-light);">
                        <?php esc_html_e( 'from', 'stayora' ); ?>
                    </span>
                    <div class="flex items-baseline gap-1">
                        <span class="price-amount font-display text-3xl"><?php echo esc_html( $currency . number_format( $meta['price_per_night'], 0 ) ); ?></span>
                        <span class="price-unit text-sm" style="color: var(--color-text-muted);">/ <?php esc_html_e( 'night', 'stayora' ); ?></span>
                    </div>
                <?php else : ?>
                    <span class="text-sm font-medium text-gold"><?php esc_html_e( 'Contact for pricing', 'stayora' ); ?></span>
                <?php endif; ?>
            </div>

            <a
                href="<?php the_permalink(); ?>"
                class="btn-primary py-2.5 px-5 text-xs"
                aria-label="<?php echo esc_attr( sprintf( __( 'View %s details', 'stayora' ), get_the_title() ) ); ?>"
            >
                <?php esc_html_e( 'View', 'stayora' ); ?>
                <?php echo stayora_icon( 'arrow-right', 'w-3.5 h-3.5' ); ?>
            </a>
        </div>

    </div><!-- /.room-card__body -->
</article>
