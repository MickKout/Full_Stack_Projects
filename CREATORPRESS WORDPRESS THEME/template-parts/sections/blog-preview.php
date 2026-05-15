<section class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Blog spotlight</p>
            <h2 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">Insights for creators who want more clarity.</h2>
        </div>
        <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="inline-flex rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 transition hover:border-slate-300">Browse blog</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <?php
        $latest_posts = new WP_Query( array(
            'posts_per_page' => 3,
            'post_status'    => 'publish',
        ) );

        if ( $latest_posts->have_posts() ) :
            while ( $latest_posts->have_posts() ) : $latest_posts->the_post();
                get_template_part( 'template-parts/content/post', 'card' );
            endwhile;
            wp_reset_postdata();
        else : ?>
            <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-soft"><?php esc_html_e( 'No posts have been published yet.', 'creatorpress' ); ?></div>
        <?php endif; ?>
    </div>
</section>
