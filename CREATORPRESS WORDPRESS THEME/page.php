<?php get_header(); ?>

<article class="mx-auto max-w-5xl px-5 py-16 lg:px-8">
    <?php while ( have_posts() ) : the_post(); ?>
        <header class="mb-10">
            <h1 class="text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl"><?php the_title(); ?></h1>
        </header>

        <div class="prose prose-slate max-w-none text-slate-700">
            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>
</article>

<?php get_footer(); ?>
