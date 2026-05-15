<section class="space-y-8">
    <div class="text-center">
        <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Testimonials</p>
        <h2 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">Trusted by creators, teams, and founders.</h2>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <?php
        $testimonials = array(
            array( 'quote' => __( 'The theme helped me launch faster and maintain a beautiful portfolio without bloated tools.', 'creatorpress' ), 'name' => __( 'Maya Turner', 'creatorpress' ), 'role' => __( 'Creative Director', 'creatorpress' ) ),
            array( 'quote' => __( 'The responsive design and accessibility focus made our brand site feel premium from the first build.', 'creatorpress' ), 'name' => __( 'Jordan Lee', 'creatorpress' ), 'role' => __( 'Freelance Designer', 'creatorpress' ) ),
            array( 'quote' => __( 'Everything feels fast, clean, and easy to edit in Gutenberg — a great fit for consultants.', 'creatorpress' ), 'name' => __( 'Sam Patel', 'creatorpress' ), 'role' => __( 'Business Coach', 'creatorpress' ) ),
        );

        foreach ( $testimonials as $item ) : ?>
            <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-soft transition hover:-translate-y-1">
                <p class="text-slate-700">&ldquo;<?php echo esc_html( $item['quote'] ); ?>&rdquo;</p>
                <div class="mt-6 text-sm text-slate-500">
                    <p class="font-semibold text-slate-900"><?php echo esc_html( $item['name'] ); ?></p>
                    <p><?php echo esc_html( $item['role'] ); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
