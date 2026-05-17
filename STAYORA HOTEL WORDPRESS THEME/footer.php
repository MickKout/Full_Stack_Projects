<?php
/**
 * Stayora — footer.php
 *
 * @package Stayora
 */
?>

<!-- =====================================================================
     Footer
===================================================================== -->
<footer id="site-footer" class="site-footer" role="contentinfo">

    <!-- Newsletter Bar -->
    <div class="py-14 px-4" style="background-color: var(--color-secondary);">
        <div class="stayora-container-narrow text-center">
            <h3 class="font-display text-3xl md:text-4xl mb-2" style="color: var(--color-cta-text);">
                <?php esc_html_e( 'Stay in the Loop', 'stayora' ); ?>
            </h3>
            <p class="mb-6 text-sm opacity-80" style="color: var(--color-cta-text);">
                <?php esc_html_e( 'Exclusive offers, travel inspiration, and early access to new properties.', 'stayora' ); ?>
            </p>
            <form class="newsletter-form" id="footer-newsletter" novalidate>
                <input
                    type="email"
                    name="email"
                    placeholder="<?php esc_attr_e( 'Your email address', 'stayora' ); ?>"
                    required
                    aria-label="<?php esc_attr_e( 'Email address', 'stayora' ); ?>"
                    style="border-color: rgba(0,0,0,0.2);"
                >
                <button type="submit" class="btn" style="background-color: var(--color-primary); color: var(--color-surface); padding: 1rem 2rem;">
                    <?php esc_html_e( 'Subscribe', 'stayora' ); ?>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Footer -->
    <div class="py-16 px-4" style="background-color: var(--color-primary); color: var(--color-surface);">
        <div class="stayora-container">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

                <!-- Brand Column -->
                <div class="lg:col-span-1">
                    <div class="mb-4">
                        <?php if ( has_custom_logo() ) :
                            // Output logo — in dark context
                            the_custom_logo();
                        else : ?>
                            <span class="font-display text-2xl" style="color: var(--color-surface);">
                                <?php echo esc_html( get_theme_mod( 'stayora_property_name', get_bloginfo( 'name' ) ) ); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <p class="text-sm leading-relaxed mb-6" style="color: rgba(240,237,232,0.6);">
                        <?php echo esc_html( get_theme_mod( 'stayora_tagline', __( 'Where luxury meets authentic comfort.', 'stayora' ) ) ); ?>
                    </p>

                    <!-- Social Icons -->
                    <?php
                    $socials = [
                        'instagram' => [ 'label' => 'Instagram', 'icon' => '<path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>' ],
                        'facebook'  => [ 'label' => 'Facebook',  'icon' => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>' ],
                        'twitter'   => [ 'label' => 'Twitter/X', 'icon' => '<path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/>' ],
                        'youtube'   => [ 'label' => 'YouTube',   'icon' => '<path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/>' ],
                    ];
                    $has_social = false;
                    foreach ( $socials as $key => $s ) {
                        if ( get_theme_mod( 'stayora_social_' . $key ) ) { $has_social = true; break; }
                    }
                    if ( $has_social ) :
                    ?>
                    <div class="flex items-center gap-3">
                        <?php foreach ( $socials as $key => $s ) :
                            $url = get_theme_mod( 'stayora_social_' . $key );
                            if ( ! $url ) continue; ?>
                            <a href="<?php echo esc_url( $url ); ?>"
                               target="_blank" rel="noopener noreferrer"
                               aria-label="<?php echo esc_attr( $s['label'] ); ?>"
                               class="w-9 h-9 flex items-center justify-center rounded-full transition-colors"
                               style="background-color: rgba(255,255,255,0.08); color: rgba(240,237,232,0.7);"
                               onmouseover="this.style.backgroundColor='rgba(201,169,110,0.3)'; this.style.color='#c9a96e';"
                               onmouseout="this.style.backgroundColor='rgba(255,255,255,0.08)'; this.style.color='rgba(240,237,232,0.7)';">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <?php echo $s['icon']; ?>
                                </svg>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Explore -->
                <div>
                    <h4 class="text-xs tracking-widest uppercase mb-5 font-medium" style="color: var(--color-secondary);">
                        <?php esc_html_e( 'Explore', 'stayora' ); ?>
                    </h4>
                    <?php
                    wp_nav_menu( [
                        'theme_location' => 'footer-main',
                        'container'      => false,
                        'menu_class'     => 'space-y-3',
                        'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                        'fallback_cb'    => function() {
                            $links = [
                                '/accommodations/' => 'Rooms & Villas',
                                '/gallery/'        => 'Gallery',
                                '/blog/'           => 'Travel Journal',
                                '/about/'          => 'Our Story',
                                '/contact/'        => 'Contact',
                            ];
                            echo '<ul class="space-y-3">';
                            foreach ( $links as $url => $label ) {
                                echo '<li><a href="' . home_url($url) . '" class="text-sm transition-colors" style="color:rgba(240,237,232,0.6);" onmouseover="this.style.color=\'#c9a96e\'" onmouseout="this.style.color=\'rgba(240,237,232,0.6)\'">' . esc_html($label) . '</a></li>';
                            }
                            echo '</ul>';
                        },
                    ] );
                    ?>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-xs tracking-widest uppercase mb-5 font-medium" style="color: var(--color-secondary);">
                        <?php esc_html_e( 'Contact', 'stayora' ); ?>
                    </h4>
                    <ul class="space-y-3 text-sm" style="color: rgba(240,237,232,0.6);">
                        <?php if ( $address = get_theme_mod( 'stayora_address' ) ) : ?>
                        <li><?php echo nl2br( esc_html( $address ) ); ?></li>
                        <?php endif; ?>
                        <?php if ( $phone = get_theme_mod( 'stayora_phone' ) ) : ?>
                        <li><a href="tel:<?php echo esc_attr( $phone ); ?>" style="color:inherit;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='rgba(240,237,232,0.6)'"><?php echo esc_html( $phone ); ?></a></li>
                        <?php endif; ?>
                        <?php if ( $email = get_theme_mod( 'stayora_email' ) ) : ?>
                        <li><a href="mailto:<?php echo esc_attr( $email ); ?>" style="color:inherit;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='rgba(240,237,232,0.6)'"><?php echo esc_html( $email ); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Book Now -->
                <div>
                    <h4 class="text-xs tracking-widest uppercase mb-5 font-medium" style="color: var(--color-secondary);">
                        <?php esc_html_e( 'Your Stay', 'stayora' ); ?>
                    </h4>
                    <p class="text-sm mb-5" style="color: rgba(240,237,232,0.6);">
                        <?php esc_html_e( 'Ready for an unforgettable experience? Reserve your dates today.', 'stayora' ); ?>
                    </p>
                    <a href="<?php echo esc_url( stayora_booking_url() ); ?>" class="btn-outline w-full justify-center">
                        <?php esc_html_e( 'Book Now', 'stayora' ); ?>
                    </a>
                </div>

            </div><!-- /.grid -->

            <!-- Footer Bottom -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs" style="border-top: 1px solid rgba(255,255,255,0.1); color: rgba(240,237,232,0.4);">
                <p>
                    &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
                    <?php echo esc_html( get_theme_mod( 'stayora_property_name', get_bloginfo( 'name' ) ) ); ?>.
                    <?php esc_html_e( 'All rights reserved.', 'stayora' ); ?>
                    &mdash; <?php esc_html_e( 'Powered by', 'stayora' ); ?>
                    <a href="https://stayora.com" target="_blank" rel="noopener" class="hover:opacity-70 transition-opacity">Stayora</a>
                </p>
                <nav aria-label="<?php esc_attr_e( 'Legal', 'stayora' ); ?>">
                    <?php
                    wp_nav_menu( [
                        'theme_location' => 'footer-legal',
                        'container'      => false,
                        'menu_class'     => 'flex items-center gap-6',
                        'fallback_cb'    => function() {
                            echo '<ul class="flex items-center gap-6">
                                <li><a href="' . home_url('/privacy-policy/') . '" style="color:inherit;" class="hover:opacity-70">Privacy Policy</a></li>
                                <li><a href="' . home_url('/terms/') . '" style="color:inherit;" class="hover:opacity-70">Terms</a></li>
                            </ul>';
                        },
                    ] );
                    ?>
                </nav>
            </div>

        </div><!-- /.container -->
    </div><!-- /.main footer -->

</footer>

<!-- Sticky Booking Bar (appears after hero scroll) -->
<div id="booking-bar" class="booking-bar" aria-hidden="true">
    <div class="stayora-container flex items-center justify-between gap-4">
        <div>
            <span class="font-display text-lg">
                <?php echo esc_html( get_theme_mod( 'stayora_property_name', get_bloginfo('name') ) ); ?>
            </span>
            <span class="text-sm ml-3" style="color: var(--color-text-muted);">
                <?php esc_html_e( 'Reserve your stay', 'stayora' ); ?>
            </span>
        </div>
        <a href="<?php echo esc_url( stayora_booking_url() ); ?>" class="btn-primary py-2.5 px-6 text-xs flex-shrink-0">
            <?php esc_html_e( 'Book Now', 'stayora' ); ?>
        </a>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
