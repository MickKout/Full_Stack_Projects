<section class="space-y-8">
    <div class="text-center">
        <p class="text-sm uppercase tracking-[0.3em] text-slate-500">FAQ</p>
        <h2 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">Questions creators ask first.</h2>
    </div>

    <div class="grid gap-5 lg:grid-cols-2">
        <?php
        $faqs = array(
            array( 'q' => __( 'Is the theme Gutenberg compatible?', 'creatorpress' ), 'a' => __( 'Yes. CreatorPress is optimized for Gutenberg blocks, editor styles, and clean page structure.', 'creatorpress' ) ),
            array( 'q' => __( 'Can I customize colors and typography?', 'creatorpress' ), 'a' => __( 'The theme uses Tailwind design tokens and supports theme.json custom palettes and font settings.', 'creatorpress' ) ),
            array( 'q' => __( 'Does it support featured images?', 'creatorpress' ), 'a' => __( 'Yes. Blog posts and landing sections support featured images and responsive media.', 'creatorpress' ) ),
            array( 'q' => __( 'Will it load quickly?', 'creatorpress' ), 'a' => __( 'Built with minimal JS, semantic markup, and lazy images to prioritize fast performance.', 'creatorpress' ) ),
        );

        foreach ( $faqs as $faq ) : ?>
            <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-soft">
                <h3 class="text-lg font-semibold text-slate-900"><?php echo esc_html( $faq['q'] ); ?></h3>
                <p class="mt-4 text-slate-600"><?php echo esc_html( $faq['a'] ); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
