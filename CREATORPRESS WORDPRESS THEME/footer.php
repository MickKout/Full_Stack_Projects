    </main>

    <footer class="footer border-t border-slate-200 bg-slate-950 text-slate-300">
        <div class="mx-auto grid max-w-7xl gap-10 px-5 py-16 sm:grid-cols-2 lg:grid-cols-4 lg:px-8">
            <div class="space-y-3">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 text-xl font-semibold text-white">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-950">CP</span>
                    CreatorPress
                </a>
                <p class="max-w-sm text-sm leading-6 text-slate-400">A lightweight landing page theme built for creative professionals, built for speed and modern styling.</p>
            </div>

            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Navigate</h2>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'grid gap-2 text-sm text-slate-300',
                    'fallback_cb'    => false,
                ) );
                ?>
            </div>

            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Follow</h2>
                <ul class="space-y-2 text-sm text-slate-300">
                    <li><a href="#" class="transition hover:text-white">Twitter</a></li>
                    <li><a href="#" class="transition hover:text-white">LinkedIn</a></li>
                    <li><a href="#" class="transition hover:text-white">Instagram</a></li>
                </ul>
            </div>

            <div class="space-y-4">
                <h2 class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Newsletter</h2>
                <p class="text-sm leading-6 text-slate-400">Stay in the loop with product updates, guides, and creator marketing tips.</p>
                <form class="grid gap-3" action="#" method="post">
                    <label for="footer-newsletter" class="sr-only"><?php esc_html_e( 'Email address', 'creatorpress' ); ?></label>
                    <input id="footer-newsletter" type="email" name="email" placeholder="Your email" class="w-full rounded-3xl border border-slate-700 bg-slate-900/90 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-500/20" required>
                    <button type="submit" class="rounded-full bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-white">Subscribe</button>
                </form>
            </div>
        </div>

        <div class="border-t border-slate-900 bg-slate-950/90 py-6">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-5 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between lg:px-8">
                <p>&copy; <?php echo date( 'Y' ); ?> CreatorPress. All rights reserved.</p>
                <p>Built for modern creators and personal brands.</p>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
