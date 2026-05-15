<?php get_header(); ?>

<section class="mx-auto max-w-7xl px-5 py-16 lg:px-8">
    <header class="mb-10 text-center">
        <p class="text-sm uppercase tracking-[0.3em] text-slate-500"><?php post_type_archive_title(); ?></p>
        <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl"><?php single_cat_title(); ?></h1>
        <?php if ( category_description() ) : ?>
            <div class="mx-auto mt-4 max-w-2xl text-base leading-7 text-slate-600"><?php echo category_description(); ?></div>
        <?php endif; ?>
    </header>

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
            <h2 class="text-2xl font-semibold text-slate-900"><?php esc_html_e( 'No posts found', 'creatorpress' ); ?></h2>
            <p class="mt-3 text-slate-600"><?php esc_html_e( 'Check back later or try another category.', 'creatorpress' ); ?></p>
        </div>
    <?php endif; ?>
</section>

<?php get_footer(); ?>
