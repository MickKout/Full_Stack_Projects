<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-white text-slate-900 antialiased' ); ?>>
    <?php wp_body_open(); ?>

    <header class="site-header border-b border-slate-200 bg-white/95 backdrop-blur-lg fixed inset-x-0 top-0 z-40">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8">
            <div class="flex items-center gap-4">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo inline-flex items-center gap-3 text-lg font-semibold tracking-tight text-slate-900">
                    <?php if ( has_custom_logo() ) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <span class="inline-block rounded-full bg-slate-900 px-3 py-2 text-white">CP</span>
                    <?php endif; ?>
                    <span class="hidden sm:inline">CreatorPress</span>
                </a>
            </div>

            <nav class="primary-navigation hidden items-center gap-8 lg:flex" aria-label="Primary navigation">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'flex flex-wrap items-center gap-6 text-sm font-medium text-slate-700',
                    'fallback_cb'    => false,
                    'depth'          => 2,
                    'link_before'    => '',
                    'link_after'     => '',
                ) );
                ?>
                <a href="#contact" class="btn-primary rounded-full bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700">Get started</a>
            </nav>

            <div class="hidden items-center gap-3 lg:flex">
                <button id="creatorpress-color-mode" type="button" class="rounded-full border border-slate-200 bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:border-slate-300" aria-label="Switch to dark mode">Dark mode</button>
            </div>

            <button class="menu-toggle inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-900 shadow-sm transition hover:border-slate-300 lg:hidden" aria-expanded="false" aria-controls="creatorpress-mobile-menu" aria-label="Toggle navigation">
                <span class="hamburger block h-0.5 w-6 bg-current transition-all"></span>
                <span class="hamburger block h-0.5 w-6 bg-current mt-1.5 transition-all"></span>
            </button>
        </div>

        <div id="creatorpress-mobile-menu" class="mobile-menu hidden border-t border-slate-200 bg-white shadow-sm lg:hidden">
            <div class="mx-auto flex max-w-7xl flex-col gap-4 px-5 py-5">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'flex flex-col gap-3 text-base font-medium text-slate-700',
                    'fallback_cb'    => false,
                ) );
                ?>
                <a href="#contact" class="rounded-full bg-slate-900 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-slate-700">Get started</a>
            </div>
        </div>
    </header>

    <main class="pt-24">
