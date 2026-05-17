<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php do_action( 'stayora_head' ); ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip to Content (Accessibility) -->
<a href="#main-content" class="skip-link"><?php esc_html_e( 'Skip to content', 'stayora' ); ?></a>

<!-- =====================================================================
     Site Header
===================================================================== -->
<header
    id="site-header"
    class="site-header <?php echo is_front_page() ? 'is-transparent' : 'is-scrolled'; ?>"
    role="banner"
    data-hero="<?php echo is_front_page() ? 'true' : 'false'; ?>"
>
    <div class="stayora-container h-full flex items-center justify-between">

        <!-- Logo -->
        <div class="site-logo flex-shrink-0">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-text" rel="home">
                    <span class="font-display text-2xl tracking-tight">
                        <?php echo esc_html( get_theme_mod( 'stayora_property_name', get_bloginfo( 'name' ) ) ); ?>
                    </span>
                </a>
            <?php endif; ?>
        </div>

        <!-- Primary Navigation (Desktop) -->
        <nav
            class="hidden lg:flex items-center gap-8"
            aria-label="<?php esc_attr_e( 'Primary', 'stayora' ); ?>"
            id="primary-nav"
        >
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'flex items-center gap-8',
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'fallback_cb'    => function() {
                    echo '<ul class="flex items-center gap-8">
                        <li><a href="' . home_url('/accommodations/') . '" class="nav-link">' . __('Rooms', 'stayora') . '</a></li>
                        <li><a href="' . home_url('/gallery/') . '" class="nav-link">' . __('Gallery', 'stayora') . '</a></li>
                        <li><a href="' . home_url('/blog/') . '" class="nav-link">' . __('Journal', 'stayora') . '</a></li>
                        <li><a href="' . home_url('/contact/') . '" class="nav-link">' . __('Contact', 'stayora') . '</a></li>
                    </ul>';
                },
            ] );
            ?>
        </nav>

        <!-- Header Actions -->
        <div class="flex items-center gap-3">

            <!-- Dark Mode Toggle -->
            <button
                id="theme-toggle"
                class="w-9 h-9 flex items-center justify-center rounded-full transition-colors hover:bg-black/5 dark:hover:bg-white/10"
                aria-label="<?php esc_attr_e( 'Toggle dark mode', 'stayora' ); ?>"
            >
                <span class="icon-sun hidden dark:block"><?php echo stayora_icon( 'sun', 'w-5 h-5' ); ?></span>
                <span class="icon-moon block dark:hidden"><?php echo stayora_icon( 'moon', 'w-5 h-5' ); ?></span>
            </button>

            <!-- Book Now CTA -->
            <a
                href="<?php echo esc_url( stayora_booking_url() ); ?>"
                class="btn-primary hidden sm:inline-flex py-2.5 px-6 text-xs"
                aria-label="<?php esc_attr_e( 'Book Now', 'stayora' ); ?>"
            >
                <?php esc_html_e( 'Book Now', 'stayora' ); ?>
            </a>

            <!-- Mobile Hamburger -->
            <button
                id="mobile-menu-toggle"
                class="lg:hidden w-10 h-10 flex items-center justify-center"
                aria-expanded="false"
                aria-controls="mobile-menu"
                aria-label="<?php esc_attr_e( 'Toggle navigation', 'stayora' ); ?>"
            >
                <span class="hamburger-icon"><?php echo stayora_icon( 'menu', 'w-6 h-6' ); ?></span>
                <span class="close-icon hidden"><?php echo stayora_icon( 'x', 'w-6 h-6' ); ?></span>
            </button>

        </div><!-- /.flex items-center -->
    </div><!-- /.container -->
</header>

<!-- =====================================================================
     Mobile Menu Drawer
===================================================================== -->
<div
    id="mobile-menu"
    class="fixed inset-0 z-[60] pointer-events-none"
    aria-hidden="true"
>
    <!-- Backdrop -->
    <div
        id="mobile-backdrop"
        class="absolute inset-0 bg-black/50 opacity-0 transition-opacity duration-300"
    ></div>

    <!-- Drawer -->
    <div
        class="absolute top-0 right-0 bottom-0 w-80 max-w-full transform translate-x-full
               transition-transform duration-300 ease-out flex flex-col"
        style="background-color: var(--color-surface);"
        id="mobile-drawer"
        role="dialog"
        aria-label="<?php esc_attr_e( 'Navigation Menu', 'stayora' ); ?>"
    >
        <!-- Drawer Header -->
        <div class="flex items-center justify-between p-6" style="border-bottom: 1px solid var(--color-border);">
            <span class="font-display text-xl">
                <?php echo esc_html( get_theme_mod( 'stayora_property_name', get_bloginfo( 'name' ) ) ); ?>
            </span>
            <button id="mobile-close" class="p-2 hover:opacity-70 transition-opacity" aria-label="<?php esc_attr_e( 'Close menu', 'stayora' ); ?>">
                <?php echo stayora_icon( 'x', 'w-6 h-6' ); ?>
            </button>
        </div>

        <!-- Nav Links -->
        <nav class="flex-1 overflow-y-auto p-6" aria-label="<?php esc_attr_e( 'Mobile Navigation', 'stayora' ); ?>">
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'space-y-1',
                'fallback_cb'    => function() {
                    $links = [
                        '/accommodations/' => __( 'Rooms & Villas', 'stayora' ),
                        '/gallery/'        => __( 'Gallery', 'stayora' ),
                        '/blog/'           => __( 'Journal', 'stayora' ),
                        '/contact/'        => __( 'Contact', 'stayora' ),
                    ];
                    echo '<ul class="space-y-1">';
                    foreach ( $links as $url => $label ) {
                        echo '<li><a href="' . home_url($url) . '" class="mobile-nav-link block py-3 px-4 font-medium transition-colors hover:text-[color:var(--color-secondary)]">' . esc_html($label) . '</a></li>';
                    }
                    echo '</ul>';
                },
            ] );
            ?>
        </nav>

        <!-- Drawer Footer -->
        <div class="p-6" style="border-top: 1px solid var(--color-border);">
            <a href="<?php echo esc_url( stayora_booking_url() ); ?>" class="btn-primary w-full justify-center">
                <?php esc_html_e( 'Book Your Stay', 'stayora' ); ?>
            </a>

            <?php $phone = get_theme_mod( 'stayora_phone', '' ); if ( $phone ) : ?>
            <a href="tel:<?php echo esc_attr( $phone ); ?>" class="flex items-center justify-center gap-2 mt-4 text-sm" style="color: var(--color-text-muted);">
                <?php echo esc_html( $phone ); ?>
            </a>
            <?php endif; ?>
        </div>

    </div><!-- /.drawer -->
</div><!-- /#mobile-menu -->
