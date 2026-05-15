<?php get_header(); ?>

<section class="mx-auto max-w-7xl px-5 py-16 lg:px-8">
    <div class="mb-12 text-center">
        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.28em] text-slate-700">Blog</span>
        <h1 class="mt-5 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">Latest insights for creators and solopreneurs.</h1>
        <p class="mx-auto mt-4 max-w-2xl text-base leading-7 text-slate-600">A clean blog experience with modern cards and fast page load performance.</p>
    </div>

    <?php if ( have_posts() ) : ?>
        <div class="grid gap-8 lg:grid-cols-3">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'template-parts/content/post', 'card' ); ?>
            <?php endwhile; ?>
        </div>

        <div class="mt-12 flex items-center justify-center">
            <?php the_posts_pagination( array(
                'mid_size'  => 1,
                'prev_text' => __( 'Previous', 'creatorpress' ),
                'next_text' => __( 'Next', 'creatorpress' ),
            ) ); ?>
        </div>
    <?php else : ?>
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-10 text-center">
            <h2 class="text-2xl font-semibold text-slate-900"><?php esc_html_e( 'Nothing found', 'creatorpress' ); ?></h2>
            <p class="mt-3 text-slate-600"><?php esc_html_e( 'Try adjusting your search or return to the homepage.', 'creatorpress' ); ?></p>
        </div>
    <?php endif; ?>
</section>

<?php get_footer(); ?>
