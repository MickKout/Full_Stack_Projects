<?php get_header(); ?>

<article class="mx-auto max-w-5xl px-5 py-16 lg:px-8">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <header class="mb-10">
            <p class="text-sm uppercase tracking-[0.24em] text-slate-500"><?php the_category( ' ' ); ?></p>
            <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl"><?php the_title(); ?></h1>
            <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-slate-500">
                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
                <span>&bull;</span>
                <span><?php echo esc_html( get_the_author() ); ?></span>
            </div>
        </header>

        <?php if ( has_post_thumbnail() ) : ?>
            <div class="mb-10 overflow-hidden rounded-3xl shadow-soft">
                <?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-auto object-cover' ) ); ?>
            </div>
        <?php endif; ?>

        <div class="prose prose-slate max-w-none text-slate-700"> 
            <?php the_content(); ?>
        </div>

        <footer class="mt-16 border-t border-slate-200 pt-10 text-sm text-slate-500">
            <?php the_tags( '<span class="mr-2">' . __( 'Tagged:', 'creatorpress' ) . '</span>', ', ', '' ); ?>
        </footer>

    <?php endwhile; endif; ?>
</article>

<?php get_footer(); ?>
