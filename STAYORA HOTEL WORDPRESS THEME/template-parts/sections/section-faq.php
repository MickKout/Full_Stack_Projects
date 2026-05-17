<?php
/**
 * Stayora — FAQ Section
 *
 * @package Stayora
 */

$faqs = [
    [
        'q' => __('What is the check-in and check-out time?','stayora'),
        'a' => __('Check-in is from 3:00 PM and check-out is by 11:00 AM. Early check-in or late check-out may be available upon request, subject to availability. Please contact us in advance to arrange.','stayora'),
    ],
    [
        'q' => __('Is breakfast included in the rate?','stayora'),
        'a' => __('Breakfast options vary by room type and season. Many of our packages include a daily continental or à la carte breakfast. Please check the details on your chosen accommodation page or contact us directly.','stayora'),
    ],
    [
        'q' => __('What is your cancellation policy?','stayora'),
        'a' => __('We offer free cancellation up to 48 hours before your arrival date for most bookings. Bookings made during peak season or for special event dates may have different terms. Full details are shown at the time of booking.','stayora'),
    ],
    [
        'q' => __('Are pets allowed?','stayora'),
        'a' => __('Select properties are pet-friendly. Please check the individual accommodation listing or contact us before booking if you plan to bring a pet. A small cleaning fee may apply.','stayora'),
    ],
    [
        'q' => __('Do you offer airport transfers?','stayora'),
        'a' => __('Yes, we can arrange private airport transfers for an additional fee. Please let us know your arrival and departure details when booking and we will provide a quote.','stayora'),
    ],
    [
        'q' => __('Is there parking available on site?','stayora'),
        'a' => __('Complimentary private parking is available for all guests. Our secure car park is on-site and monitored. Electric vehicle charging points are also available.','stayora'),
    ],
];
?>

<section id="faq" class="py-24 px-4" style="background-color:var(--color-surface-alt);">
    <div class="stayora-container">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

            <!-- Left sticky header -->
            <div class="lg:col-span-4">
                <div class="lg:sticky lg:top-32 reveal">
                    <span class="section-label"><?php esc_html_e('FAQ','stayora'); ?></span>
                    <h2 class="section-title mb-6">
                        <?php esc_html_e('Questions &','stayora'); ?><br>
                        <em><?php esc_html_e('Answers','stayora'); ?></em>
                    </h2>
                    <p class="section-subtitle mb-8">
                        <?php esc_html_e('Everything you need to know before your arrival. Can\'t find what you\'re looking for?','stayora'); ?>
                    </p>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn-outline">
                        <?php esc_html_e('Ask Us Anything','stayora'); ?>
                        <?php echo stayora_icon('arrow-right','w-4 h-4'); ?>
                    </a>
                </div>
            </div>

            <!-- Right: FAQ accordion -->
            <div class="lg:col-span-8 reveal" id="faq-accordion">
                <?php foreach ($faqs as $i => $faq) : ?>
                    <div class="faq-item">
                        <button
                            class="faq-question"
                            aria-expanded="false"
                            aria-controls="faq-answer-<?php echo $i; ?>"
                        >
                            <span><?php echo esc_html($faq['q']); ?></span>
                            <span class="faq-icon" aria-hidden="true">
                                <?php echo stayora_icon('plus','w-5 h-5 flex-shrink-0'); ?>
                            </span>
                        </button>
                        <div
                            class="faq-answer"
                            id="faq-answer-<?php echo $i; ?>"
                            role="region"
                        >
                            <?php echo esc_html($faq['a']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div><!-- /.grid -->
    </div><!-- /.container -->
</section>
