<article id="post-<?php the_ID(); ?>" <?php post_class( 'group overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-soft transition hover:-translate-y-1' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-t-[2rem]">
            <?php the_post_thumbnail( 'medium_large', array( 'class' => 'h-56 w-full object-cover transition duration-300 group-hover:scale-105', 'loading' => 'lazy' ) ); ?>
        </a>
    <?php endif; ?>

    <div class="space-y-4 px-6 py-7">
        <div class="flex flex-wrap items-center gap-3 text-xs uppercase tracking-[0.3em] text-slate-500">
            <?php the_category( ' ' ); ?>
            <span><?php echo esc_html( get_the_date() ); ?></span>
        </div>
        <h2 class="text-2xl font-semibold tracking-tight text-slate-900"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p class="text-sm leading-6 text-slate-600"><?php echo esc_html( get_the_excerpt() ); ?></p>
        <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-900 transition hover:text-slate-700">Read more<span aria-hidden="true">→</span></a>
    </div>
</article>
