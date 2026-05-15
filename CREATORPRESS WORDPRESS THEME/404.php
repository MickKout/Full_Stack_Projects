<?php get_header(); ?>

<section class="mx-auto max-w-4xl px-5 py-24 text-center lg:px-8">
    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">404</p>
    <h1 class="mt-6 text-5xl font-semibold tracking-tight text-slate-900 sm:text-6xl">Page not found</h1>
    <p class="mx-auto mt-6 max-w-2xl text-base leading-7 text-slate-600">The page you are looking for may have moved or no longer exists. Use the navigation or search to continue.</p>
    <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">Return home</a>
        <?php get_search_form(); ?>
    </div>
</section>

<?php get_footer(); ?>
