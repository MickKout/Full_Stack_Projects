<section class="grid gap-8 lg:grid-cols-3">
    <div class="space-y-4">
        <p class="text-sm uppercase tracking-[0.28em] text-slate-500">What we offer</p>
        <h2 class="text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">A polished digital presence for your next launch.</h2>
        <p class="max-w-xl text-base leading-7 text-slate-600">CreatorPress helps creators and consultants communicate value clearly with fast page performance and modular sections.</p>
    </div>

    <div class="space-y-4 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-soft">
        <h3 class="text-lg font-semibold text-slate-900">Brand & landing pages</h3>
        <p class="text-slate-600">High-converting landing pages with an emphasis on clarity, trust, and a premium visual language.</p>
    </div>

    <div class="space-y-4 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-soft">
        <h3 class="text-lg font-semibold text-slate-900">Content-ready structure</h3>
        <p class="text-slate-600">Built to work with Gutenberg, our layout keeps editing easy while preserving speed and semantic markup.</p>
    </div>
</section>

<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    <?php
    $items = array(
        array( 'title' => __( 'Strategy workshops', 'creatorpress' ), 'text' => __( 'Refine offers and landing page flow with clarity-first copy blocks.', 'creatorpress' ) ),
        array( 'title' => __( 'Coach websites', 'creatorpress' ), 'text' => __( 'Modern service pages optimized for lead generation and clear next steps.', 'creatorpress' ) ),
        array( 'title' => __( 'Portfolio showcases', 'creatorpress' ), 'text' => __( 'Minimal case study layouts that highlight your work without distraction.', 'creatorpress' ) ),
    );

    foreach ( $items as $item ) : ?>
        <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-soft transition hover:-translate-y-1 hover:border-slate-300">
            <h3 class="text-xl font-semibold text-slate-900"><?php echo esc_html( $item['title'] ); ?></h3>
            <p class="mt-3 text-slate-600"><?php echo esc_html( $item['text'] ); ?></p>
        </div>
    <?php endforeach; ?>
</div>
