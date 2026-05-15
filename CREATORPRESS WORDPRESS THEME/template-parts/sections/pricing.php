<section class="grid gap-8 lg:grid-cols-3">
    <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-soft">
        <p class="text-sm uppercase tracking-[0.28em] text-slate-500">Pricing</p>
        <h2 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">Simple packages for growing creators.</h2>
        <p class="mt-4 text-base leading-7 text-slate-600">Clean pricing with clear features and a focus on what matters most for your brand.</p>
    </div>

    <?php
    $plans = array(
        array( 'name' => __( 'Starter', 'creatorpress' ), 'price' => __( '$99 / month', 'creatorpress' ), 'features' => array( __( 'Landing page', 'creatorpress' ), __( 'Gutenberg-ready sections', 'creatorpress' ), __( 'SEO friendly markup', 'creatorpress' ) ) ),
        array( 'name' => __( 'Growth', 'creatorpress' ), 'price' => __( '$149 / month', 'creatorpress' ), 'features' => array( __( 'All starter features', 'creatorpress' ), __( 'Service pages', 'creatorpress' ), __( 'Blog previews', 'creatorpress' ) ) ),
    );

    foreach ( $plans as $plan ) : ?>
        <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-soft transition hover:-translate-y-1">
            <h3 class="text-xl font-semibold text-slate-900"><?php echo esc_html( $plan['name'] ); ?></h3>
            <p class="mt-4 text-3xl font-semibold text-slate-900"><?php echo esc_html( $plan['price'] ); ?></p>
            <ul class="mt-6 space-y-3 text-sm text-slate-600">
                <?php foreach ( $plan['features'] as $feature ) : ?>
                    <li class="flex items-start gap-3"><span class="mt-1 inline-block h-2 w-2 rounded-full bg-slate-900"></span><?php echo esc_html( $feature ); ?></li>
                <?php endforeach; ?>
            </ul>
            <a href="#contact" class="mt-8 inline-flex rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">Choose plan</a>
        </div>
    <?php endforeach; ?>
</section>
