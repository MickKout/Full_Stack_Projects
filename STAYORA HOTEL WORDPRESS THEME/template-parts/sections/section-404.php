<?php
/**
 * Stayora — 404 Section
 *
 * @package Stayora
 */
?>
<div class="min-h-[70vh] flex items-center justify-center px-4 py-20">
    <div class="text-center max-w-lg">
        <div class="font-display mb-4" style="font-size:8rem;line-height:1;color:var(--color-border);">404</div>
        <h1 class="section-title mb-4"><?php esc_html_e('Room Not Found','stayora'); ?></h1>
        <p class="section-subtitle mb-10">
            <?php esc_html_e('Looks like this page checked out early. Let\'s get you back on track.','stayora'); ?>
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary"><?php esc_html_e('Back Home','stayora'); ?></a>
            <a href="<?php echo esc_url(get_post_type_archive_link('accommodation') ?: home_url('/accommodations/')); ?>" class="btn-outline"><?php esc_html_e('Browse Rooms','stayora'); ?></a>
        </div>
    </div>
</div>
