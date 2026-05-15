<aside class="sidebar space-y-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
    <?php if ( is_active_sidebar( 'footer-newsletter' ) ) : ?>
        <?php dynamic_sidebar( 'footer-newsletter' ); ?>
    <?php else : ?>
        <div class="space-y-3 text-sm text-slate-600">
            <h2 class="text-base font-semibold text-slate-900"><?php esc_html_e( 'Stay connected', 'creatorpress' ); ?></h2>
            <p><?php esc_html_e( 'Add widgets here to display a newsletter signup, contact details, or social links.', 'creatorpress' ); ?></p>
        </div>
    <?php endif; ?>
</aside>
