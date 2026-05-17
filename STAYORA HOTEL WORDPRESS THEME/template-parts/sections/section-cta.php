<?php
/**
 * Stayora — CTA Banner Section
 *
 * @package Stayora
 */
?>

<section class="cta-banner">
    <div class="cta-pattern" aria-hidden="true"></div>
    <div class="stayora-container relative z-10">
        <div class="max-w-2xl mx-auto">
            <div class="reveal">
                <span class="section-label" style="color:var(--color-secondary);"><?php esc_html_e('Ready?','stayora'); ?></span>
                <h2 class="font-display font-light mb-6"
                    style="font-size:clamp(2rem,4vw,3.5rem);line-height:1.1;color:var(--color-surface);">
                    <?php esc_html_e('Your Perfect Stay','stayora'); ?><br>
                    <em><?php esc_html_e('Awaits You','stayora'); ?></em>
                </h2>
                <p class="text-lg mb-10" style="color:rgba(240,237,232,0.75);">
                    <?php esc_html_e('Book directly for the best rates and personalised service. No booking fees, no surprises.','stayora'); ?>
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="<?php echo esc_url(stayora_booking_url()); ?>" class="btn-primary">
                        <?php esc_html_e('Book Your Stay','stayora'); ?>
                        <?php echo stayora_icon('arrow-right','w-4 h-4'); ?>
                    </a>
                    <?php if ($phone = get_theme_mod('stayora_phone')) : ?>
                        <a href="tel:<?php echo esc_attr($phone); ?>" class="btn-ghost" style="color:rgba(240,237,232,0.8);">
                            <?php esc_html_e('Or call us:','stayora'); ?> <?php echo esc_html($phone); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
