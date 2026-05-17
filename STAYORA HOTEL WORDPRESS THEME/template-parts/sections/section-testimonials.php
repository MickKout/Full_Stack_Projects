<?php
/**
 * Stayora — Testimonials Section
 *
 * @package Stayora
 */

// Testimonials can be managed via a custom post type or hardcoded defaults.
// If a 'testimonial' CPT exists (e.g. from a plugin), we query it; otherwise use defaults.
$testimonials_from_cpt = post_type_exists('testimonial')
    ? get_posts(['post_type'=>'testimonial','posts_per_page'=>6,'post_status'=>'publish'])
    : [];

$defaults = [
    [
        'quote'    => 'Waking up to that view every morning was something I\'ll never forget. The attention to detail in every corner of this villa is remarkable. Already planning our return.',
        'name'     => 'Sophia Laurent',
        'location' => 'Paris, France',
        'rating'   => 5,
        'initials' => 'SL',
    ],
    [
        'quote'    => 'From the seamless check-in to the personalised dining arrangements, every single moment felt curated just for us. This is what luxury hospitality should feel like.',
        'name'     => 'James & Clara Whitfield',
        'location' => 'London, UK',
        'rating'   => 5,
        'initials' => 'JW',
    ],
    [
        'quote'    => 'I travel for work constantly and have stayed in hundreds of hotels. This property genuinely surprised me — thoughtful, quiet, and impeccably maintained.',
        'name'     => 'Kenji Mori',
        'location' => 'Tokyo, Japan',
        'rating'   => 5,
        'initials' => 'KM',
    ],
];
?>

<section id="testimonials" class="py-24 px-4" style="background-color: var(--color-surface-alt);">
    <div class="stayora-container">

        <!-- Header -->
        <div class="text-center max-w-xl mx-auto mb-14 reveal">
            <span class="section-label"><?php esc_html_e( 'Guest Stories', 'stayora' ); ?></span>
            <h2 class="section-title">
                <?php esc_html_e( 'Words from Our', 'stayora' ); ?><br>
                <em><?php esc_html_e( 'Guests', 'stayora' ); ?></em>
            </h2>
        </div>

        <!-- Testimonials Slider / Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="testimonials-grid">
            <?php if ( ! empty( $testimonials_from_cpt ) ) :
                foreach ( $testimonials_from_cpt as $i => $t ) :
                    $rating = get_post_meta( $t->ID, '_rating', true ) ?: 5;
                    $location = get_post_meta( $t->ID, '_location', true );
                    ?>
                    <div class="testimonial-card reveal reveal-delay-<?php echo min($i+1,4); ?>">
                        <div class="testimonial-rating">
                            <?php for ($s=0;$s<5;$s++) : ?>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <?php endfor; ?>
                        </div>
                        <blockquote class="testimonial-quote">"<?php echo esc_html( get_the_excerpt($t) ?: $t->post_content ); ?>"</blockquote>
                        <div class="testimonial-author">
                            <?php if ( has_post_thumbnail($t) ) : ?>
                                <?php echo get_the_post_thumbnail($t,'thumbnail',['class'=>'author-avatar']); ?>
                            <?php else : ?>
                                <div class="author-avatar flex items-center justify-center text-sm font-medium" style="background-color:var(--color-secondary);color:var(--color-cta-text);">
                                    <?php echo esc_html( strtoupper( substr( $t->post_title, 0, 2 ) ) ); ?>
                                </div>
                            <?php endif; ?>
                            <div>
                                <div class="author-name"><?php echo esc_html( $t->post_title ); ?></div>
                                <?php if ($location) : ?>
                                    <div class="author-location"><?php echo esc_html($location); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            else :
                foreach ( $defaults as $i => $t ) : ?>
                    <div class="testimonial-card reveal reveal-delay-<?php echo $i+1; ?>">
                        <div class="testimonial-rating">
                            <?php for ($s=0;$s<$t['rating'];$s++) : ?>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <?php endfor; ?>
                        </div>
                        <blockquote class="testimonial-quote">"<?php echo esc_html( $t['quote'] ); ?>"</blockquote>
                        <div class="testimonial-author">
                            <div class="author-avatar flex items-center justify-center text-sm font-medium"
                                 style="background-color:var(--color-secondary);color:var(--color-cta-text);">
                                <?php echo esc_html( $t['initials'] ); ?>
                            </div>
                            <div>
                                <div class="author-name"><?php echo esc_html( $t['name'] ); ?></div>
                                <div class="author-location"><?php echo esc_html( $t['location'] ); ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>

        <!-- Overall Rating Strip -->
        <div class="reveal mt-14 py-8 px-6 flex flex-col sm:flex-row items-center justify-center gap-6 sm:gap-12"
             style="border:1px solid var(--color-border);">
            <div class="text-center">
                <div class="font-display text-5xl" style="color:var(--color-text);">4.9</div>
                <div class="flex justify-center mt-1 mb-1" style="color:var(--color-secondary);">
                    <?php for($s=0;$s<5;$s++) : ?>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <?php endfor; ?>
                </div>
                <div class="text-xs uppercase tracking-widest" style="color:var(--color-text-muted);"><?php esc_html_e('Overall Rating','stayora'); ?></div>
            </div>
            <div class="hidden sm:block w-px h-12" style="background-color:var(--color-border);"></div>
            <?php
            $platforms = [
                ['name'=>'Google',   'score'=>'4.9', 'count'=>'340+'],
                ['name'=>'Booking',  'score'=>'9.6', 'count'=>'180+'],
                ['name'=>'Airbnb',   'score'=>'4.98','count'=>'95+'],
                ['name'=>'TripAdv.', 'score'=>'5/5', 'count'=>'220+'],
            ];
            foreach ($platforms as $p) : ?>
                <div class="text-center">
                    <div class="font-medium text-lg" style="color:var(--color-text);"><?php echo esc_html($p['score']); ?></div>
                    <div class="text-xs" style="color:var(--color-secondary);"><?php echo esc_html($p['name']); ?></div>
                    <div class="text-xs" style="color:var(--color-text-muted);"><?php echo esc_html($p['count']); ?> <?php esc_html_e('reviews','stayora'); ?></div>
                </div>
            <?php endforeach; ?>
        </div>

    </div><!-- /.container -->
</section>
