<?php
/**
 * Stayora — Booking Widget (sidebar sticky widget)
 *
 * @package Stayora
 */

$post_id = isset($args['post_id']) ? (int)$args['post_id'] : get_the_ID();
$meta    = stayora_get_accommodation_meta($post_id);
?>

<form
    class="booking-enquiry-form"
    id="booking-enquiry-<?php echo esc_attr($post_id); ?>"
    data-post-id="<?php echo esc_attr($post_id); ?>"
    novalidate
    aria-label="<?php esc_attr_e('Booking enquiry form','stayora'); ?>"
>
    <?php wp_nonce_field('stayora_nonce','booking_nonce'); ?>
    <input type="hidden" name="accommodation_id" value="<?php echo esc_attr($post_id); ?>">
    <input type="hidden" name="action" value="stayora_booking_enquiry">

    <!-- Date Row -->
    <div class="grid grid-cols-2 gap-3 mb-4">
        <div class="booking-field">
            <label for="widget-checkin-<?php echo $post_id; ?>"><?php esc_html_e('Check In','stayora'); ?></label>
            <input type="date" id="widget-checkin-<?php echo $post_id; ?>" name="checkin"
                   min="<?php echo esc_attr(gmdate('Y-m-d')); ?>" required>
        </div>
        <div class="booking-field">
            <label for="widget-checkout-<?php echo $post_id; ?>"><?php esc_html_e('Check Out','stayora'); ?></label>
            <input type="date" id="widget-checkout-<?php echo $post_id; ?>" name="checkout"
                   min="<?php echo esc_attr(gmdate('Y-m-d',strtotime('+1 day'))); ?>" required>
        </div>
    </div>

    <!-- Guests -->
    <div class="mb-4" style="border:1px solid var(--color-border);padding:12px 14px;">
        <label class="block text-xs tracking-widest uppercase mb-3" style="color:var(--color-text-muted);">
            <?php esc_html_e('Guests','stayora'); ?>
        </label>
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <div class="text-sm font-medium" style="color:var(--color-text);"><?php esc_html_e('Adults','stayora'); ?></div>
                <div class="text-xs" style="color:var(--color-text-muted);"><?php esc_html_e('Ages 13+','stayora'); ?></div>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" class="guest-btn minus w-8 h-8 flex items-center justify-center"
                        style="border:1px solid var(--color-border);" data-target="adults" aria-label="<?php esc_attr_e('Decrease adults','stayora'); ?>">
                    <?php echo stayora_icon('minus','w-3.5 h-3.5'); ?>
                </button>
                <input type="number" name="adults" id="adults-<?php echo $post_id; ?>" value="2" min="1"
                       max="<?php echo esc_attr($meta['guests']); ?>"
                       class="w-8 text-center text-sm font-medium bg-transparent border-0 focus:outline-none"
                       style="color:var(--color-text);" readonly>
                <button type="button" class="guest-btn plus w-8 h-8 flex items-center justify-center"
                        style="border:1px solid var(--color-border);" data-target="adults" aria-label="<?php esc_attr_e('Increase adults','stayora'); ?>">
                    <?php echo stayora_icon('plus','w-3.5 h-3.5'); ?>
                </button>
            </div>
        </div>
        <div class="flex items-center justify-between mt-3 pt-3" style="border-top:1px solid var(--color-border);">
            <div class="flex-1">
                <div class="text-sm font-medium" style="color:var(--color-text);"><?php esc_html_e('Children','stayora'); ?></div>
                <div class="text-xs" style="color:var(--color-text-muted);"><?php esc_html_e('Ages 2–12','stayora'); ?></div>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" class="guest-btn minus w-8 h-8 flex items-center justify-center"
                        style="border:1px solid var(--color-border);" data-target="children" aria-label="<?php esc_attr_e('Decrease children','stayora'); ?>">
                    <?php echo stayora_icon('minus','w-3.5 h-3.5'); ?>
                </button>
                <input type="number" name="children" id="children-<?php echo $post_id; ?>" value="0" min="0" max="8"
                       class="w-8 text-center text-sm font-medium bg-transparent border-0 focus:outline-none"
                       style="color:var(--color-text);" readonly>
                <button type="button" class="guest-btn plus w-8 h-8 flex items-center justify-center"
                        style="border:1px solid var(--color-border);" data-target="children" aria-label="<?php esc_attr_e('Increase children','stayora'); ?>">
                    <?php echo stayora_icon('plus','w-3.5 h-3.5'); ?>
                </button>
            </div>
        </div>
    </div>

    <!-- Guest Info -->
    <div class="booking-field mb-3">
        <label for="widget-name-<?php echo $post_id; ?>"><?php esc_html_e('Your Name','stayora'); ?></label>
        <input type="text" id="widget-name-<?php echo $post_id; ?>" name="name"
               placeholder="<?php esc_attr_e('Full name','stayora'); ?>" required>
    </div>
    <div class="booking-field mb-3">
        <label for="widget-email-<?php echo $post_id; ?>"><?php esc_html_e('Email','stayora'); ?></label>
        <input type="email" id="widget-email-<?php echo $post_id; ?>" name="email"
               placeholder="<?php esc_attr_e('your@email.com','stayora'); ?>" required>
    </div>
    <div class="booking-field mb-5">
        <label for="widget-phone-<?php echo $post_id; ?>"><?php esc_html_e('Phone (optional)','stayora'); ?></label>
        <input type="tel" id="widget-phone-<?php echo $post_id; ?>" name="phone"
               placeholder="<?php esc_attr_e('+1 (555) 000-0000','stayora'); ?>">
    </div>

    <!-- Price Preview -->
    <div id="price-preview-<?php echo $post_id; ?>" class="hidden mb-4 p-3 text-sm"
         style="background-color:var(--color-surface-alt);border:1px solid var(--color-border);">
        <div class="flex justify-between mb-1">
            <span style="color:var(--color-text-muted);" id="nights-label-<?php echo $post_id; ?>"></span>
            <span id="nights-cost-<?php echo $post_id; ?>"></span>
        </div>
        <div class="flex justify-between font-medium" style="border-top:1px solid var(--color-border);padding-top:8px;margin-top:4px;">
            <span><?php esc_html_e('Total','stayora'); ?></span>
            <span id="total-cost-<?php echo $post_id; ?>"></span>
        </div>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn-primary w-full justify-center booking-submit-btn">
        <?php esc_html_e('Request Booking','stayora'); ?>
    </button>

    <!-- Response message -->
    <div class="booking-response mt-4 text-sm text-center hidden"></div>

    <p class="text-xs text-center mt-3" style="color:var(--color-text-light);">
        <?php esc_html_e('No charge yet · Free to enquire','stayora'); ?>
    </p>
</form>
